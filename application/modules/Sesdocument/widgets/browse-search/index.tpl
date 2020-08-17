<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdocument
 * @package    Sesdocument
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php
$base_url = $this->layout()->staticBaseUrl;
$this->headScript()
->appendFile($base_url . 'externals/autocompleter/Observer.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.Local.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.Request.js');
?>
<div class="sesdocument_browse_search <?php echo $this->view_type=='horizontal' ? 'sesdocument_browse_search_horizontal' : 'sesdocument_browse_search_vertical'; ?>">
  <?php echo $this->form->render($this) ?>
</div>

<?php $request = Zend_Controller_Front::getInstance()->getRequest();?>
<?php $controllerName = $request->getControllerName();?>
<?php $actionName = $request->getActionName(); ?>
<?php $class = '.sesdocument_document_listing';?>
<?php if($actionName == 'browse'):?>
  <?php $pageName = 'sesdocument_index_browse';?>
  <?php $widgetName = 'sesdocument.browse-documents';?>
<?php elseif($actionName == 'manage'):?>
  <?php $pageName = 'sesdocument_index_manage';?>
  <?php $widgetName = 'sesdocument.manage-documents';?>
<?php endif;?>
<?php $identity = Engine_Api::_()->sesdocument()->getIdentityWidget($widgetName,'widget',$pageName); ?>
<script type="application/javascript">
    en4.core.runonce.add(function() {
     <?php if($controllerName == 'index' && $actionName == 'locations'):?>
    sesJqueryObject('#filter_form').submit(function(e){
      e.preventDefault();
      var error = false;
      sesJqueryObject('#loadingimgsesmember-wrapper').show();
      e.preventDefault();
      searchParams = sesJqueryObject(this).serialize();
      sesJqueryObject('#loadingimgsesmember-wrapper').show();
      callNewMarkersAjax();
      return true;
    });	

   <?php else:?>
  
    sesJqueryObject('#filter_form').submit(function(e){
      e.preventDefault();
      if(sesJqueryObject('<?php echo $class;?>').length > 0){
	sesJqueryObject('#tabbed-widget_<?php echo $identity; ?>').html('');
	//document.getElementById("tabbed-widget_<?php echo $identity; ?>").innerHTML = "<div class='clear sesbasic_loading_container' id='loading_images_browse_<?php echo $identity; ?>'></div>";
	sesJqueryObject('#loading_image_<?php echo $identity; ?>').show();
	sesJqueryObject('#loadingimgsesdocument-wrapper').show();
	is_search_<?php echo $identity; ?> = 1;
	if(typeof paggingNumber<?php echo $identity; ?> == 'function'){
	  isSearch = true;
	  e.preventDefault();
	  searchParams<?php echo $identity; ?> = sesJqueryObject(this).serialize();
	  paggingNumber<?php echo $identity; ?>(1);
	}else if(typeof viewMore_<?php echo $identity; ?> == 'function'){
	  isSearch = true;
	  e.preventDefault();
	  searchParams<?php echo $identity; ?> = sesJqueryObject(this).serialize();
	  page<?php echo $identity; ?> = 1;
	  viewMore_<?php echo $identity; ?>();
	}
      }
      return true;
    });	
    <?php endif; ?>
  });
  
  var SearchurlCompany = "<?php echo $this->url(array('module' =>'sesdocument','controller' => 'company', 'action' => 'get-company'),'default',true); ?>";
  en4.core.runonce.add(function() {
    var contentAutocompletecompany = new Autocompleter.Request.JSON('search_company', SearchurlCompany, {
      'postVar': 'text',
      'minLength': 1,
      'selectMode': 'pick',
      'autocompleteType': 'tag',
      'customChoices': true,
      'filterSubset': true,
      'multiple': false,
      'className': 'sesbasic-autosuggest',
      'injectChoice': function(token) {
        var choice = new Element('li', {
          'class': 'autocompleter-choices', 
          'html': token.photo, 
          'id':token.label
        });
        new Element('div', {
          'html': this.markQueryValue(token.label),
          'class': 'autocompleter-choice'
        }).inject(choice);
        this.addChoiceEvents(choice).inject(this.choices);
        choice.store('autocompleteChoice', token);
      }
    });
    contentAutocompletecompany.addEvent('onSelection', function(element, selected, value, input) {
      $('company_id').value = selected.retrieve('autocompleteChoice').id;
    });
  });

  var Searchurl = "<?php echo $this->url(array('module' =>'sesdocument','controller' => 'index', 'action' => 'get-document'),'default',true); ?>";
  en4.core.runonce.add(function() {
    var contentAutocomplete = new Autocompleter.Request.JSON('search', Searchurl, {
      'postVar': 'text',
      'minLength': 1,
      'selectMode': 'pick',
      'autocompleteType': 'tag',
      'customChoices': true,
      'filterSubset': true,
      'multiple': false,
      'className': 'sesbasic-autosuggest',
      'injectChoice': function(token) {
        var choice = new Element('li', {
          'class': 'autocompleter-choices', 
          'html': token.photo, 
          'id':token.label
        });
        new Element('div', {
          'html': this.markQueryValue(token.label),
          'class': 'autocompleter-choice'
        }).inject(choice);
        this.addChoiceEvents(choice).inject(this.choices);
        choice.store('autocompleteChoice', token);
      }
    });
    contentAutocomplete.addEvent('onSelection', function(element, selected, value, input) {
    });
  });
  
  function showSubCategory(cat_id,selected) {
    var url = en4.core.baseUrl + 'sesdocument/index/subcategory/category_id/' + cat_id + '/type/'+ 'search';
    new Request.HTML({
      url: url,
      data: {
	'selected':selected
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
	if ($('subcat_id') && responseHTML) {
	  if ($('subcat_id-wrapper')) {
	    $('subcat_id-wrapper').style.display = "inline-block";
	  }
	  $('subcat_id').innerHTML = responseHTML;
	} 
	else {
	  if ($('subcat_id-wrapper')) {
	    $('subcat_id-wrapper').style.display = "none";
	    $('subcat_id').innerHTML = '';
	  }
	  if ($('subsubcat_id-wrapper')) {
	    $('subsubcat_id-wrapper').style.display = "none";
	    $('subsubcat_id').innerHTML = '';
	  }
	}
      }
    }).send(); 
  }
  
  function showSubSubCategory(cat_id,selected) {
    if(cat_id == 0){
      if ($('subsubcat_id-wrapper')) {
	$('subsubcat_id-wrapper').style.display = "none";
	$('subsubcat_id').innerHTML = '';
      }	
      return false;
    }

    var url = en4.core.baseUrl + 'sesdocument/index/subsubcategory/subcategory_id/' + cat_id + '/type/'+ 'search';;
    (new Request.HTML({
      url: url,
      data: {
	'selected':selected
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
	if ($('subsubcat_id') && responseHTML) {
	  if ($('subsubcat_id-wrapper')) {
	    $('subsubcat_id-wrapper').style.display = "inline-block";
	  }
	  $('subsubcat_id').innerHTML = responseHTML;
	} 
	else {
	  if ($('subsubcat_id-wrapper')) {
	    $('subsubcat_id-wrapper').style.display = "none";
	    $('subsubcat_id').innerHTML = '';
	  }
	}
      }
    })).send();  
  }

    en4.core.runonce.add(function() {
    if($('category_id')){
      var catAssign = 1;
      <?php if(isset($_GET['category_id']) && $_GET['category_id'] != 0){ ?>
	<?php if(isset($_GET['subcat_id'])){$catId = $_GET['subcat_id'];}else $catId = ''; ?>
	showSubCategory('<?php echo $_GET['category_id']; ?>','<?php echo $catId; ?>');
	<?php if(isset($_GET['subsubcat_id'])){ ?>
	<?php if(isset($_GET['subsubcat_id'])){$subsubcat_id = $_GET['subsubcat_id'];}else $subsubcat_id = ''; ?>
	showSubSubCategory("<?php echo $_GET['subcat_id']; ?>","<?php echo $_GET['subsubcat_id']; ?>");
	<?php }else{?>
	$('subsubcat_id-wrapper').style.display = "none";
	<?php } ?>
      <?php  }else{?>
	$('subcat_id-wrapper').style.display = "none";
	$('subsubcat_id-wrapper').style.display = "none";
      <?php } ?>
    }
  });

    en4.core.runonce.add(function() {
    mapLoad = false;
    if(sesJqueryObject('#lat-wrapper').length > 0){
      sesJqueryObject('#lat-wrapper').css('display' , 'none');
      sesJqueryObject('#lng-wrapper').css('display' , 'none');
      initializeSesDocumentMapList();
    }
  });
</script>
