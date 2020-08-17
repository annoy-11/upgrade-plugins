<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescontest
 * @package    Sescontest
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2017-12-01 00:00:00 SocialEngineSolutions $
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
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sescontest/externals/scripts/Picker.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sescontest/externals/scripts/Picker.Attach.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sescontest/externals/scripts/Picker.Date.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sescontest/externals/scripts/Picker.Date.Range.js'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sescontest/externals/styles/picker-style.css'); ?>
    <?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sescontest/externals/styles/bootstrap-datepicker.css'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sescontest/externals/styles/datepicker.css'); ?>
<div class="sesbasic_clearfix sesbasic_bxs sescontest_browse_search <?php echo $this->view_type=='horizontal' ? 'sescontest_browse_search_horizontal' : 'sescontest_browse_search_vertical'; ?>">
  <?php echo $this->form->render($this) ?>
</div>
<?php $request = Zend_Controller_Front::getInstance()->getRequest();?>
<?php $controllerName = $request->getControllerName();?>
<?php $actionName = $request->getActionName();?>
<?php $class = '.sescontest_contest_listing';?>
<?php if($actionName == 'all-results'):?>
<?php $pageName = 'advancedsearch_index_sescontest';?>
<?php $widgetName = 'sescontest.browse-contests';?>
<?php elseif($actionName == 'manage'):?>
  <?php $pageName = 'sescontest_index_manage';?>
  <?php $widgetName = 'sescontest.manage-contests';?>
<?php elseif($actionName == 'pinboard'):?>
<?php $pageName = 'sescontest_index_pinboard';?>
<?php $widgetName = 'sescontest.browse-contests';?>
<?php elseif($actionName == 'browse-contests'):?>
<?php $pageName = 'sescontest_index_'.$this->page_id;?>
<?php $widgetName = 'sescontest.browse-contests';?>
<?php else:?>
   <?php $pageName = 'sescontest_index_browse';?>
  <?php $widgetName = 'sescontest.browse-contests';?>
<?php endif;?>
<?php $identity = Engine_Api::_()->sesbasic()->getIdentityWidget($widgetName,'widget',$pageName); ?>

<script type="application/javascript">
    function formSubmit<?php echo $identity; ?>(obj){
        if(sesJqueryObject('<?php echo $class;?>').length > 0){
            sesJqueryObject('#tabbed-widget_<?php echo $identity; ?>').html('');
            sesJqueryObject('#loading_image_<?php echo $identity; ?>').show();
            sesJqueryObject('#loadingimgsescontest-wrapper').show();
            is_search_<?php echo $identity; ?> = 1;
            if(typeof paggingNumber<?php echo $identity; ?> == 'function'){
                isSearch = true;
                searchParams<?php echo $identity; ?> = sesJqueryObject(obj).serialize();
                paggingNumber<?php echo $identity; ?>(1);
            }else if(typeof viewMore_<?php echo $identity; ?> == 'function'){
                isSearch = true;
                searchParams<?php echo $identity; ?> = sesJqueryObject(obj).serialize();
                page<?php echo $identity; ?> = 1;
                viewMore_<?php echo $identity; ?>();
            }
        }
    }
    en4.core.runonce.add(function () {
    sesJqueryObject(document).on('submit','#filter_form',function(e){
      e.preventDefault();
      formSubmit<?php echo $identity; ?>(this);
      return true;
    });	
  });
  var Searchurl = "<?php echo $this->url(array('module' =>'sescontest','controller' => 'ajax', 'action' => 'get-contest'),'default',true); ?>";
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
    var url = en4.core.baseUrl + 'sescontest/ajax/subcategory/category_id/' + cat_id + '/type/'+ 'search';
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

    var url = en4.core.baseUrl + 'sescontest/ajax/subsubcategory/subcategory_id/' + cat_id + '/type/'+ 'search';;
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

    en4.core.runonce.add(function () {
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
</script>

<script>
	var inputwidth =sesJqueryObject('#show_date_field').width();
	var pickerposition =(400 - inputwidth);
    en4.core.runonce.add(function () {
        var picker = new Picker.Date.Range($('show_date_field'), {
            timePicker: false,
            columns: 2,
            positionOffset: {x: -pickerposition, y: 0}
        });
        var picker2 = new Picker.Date.Range('range_hidden', {
            toggle: $$('#range_select'),
            columns: 2,
            onSelect: function () {
                $('range_text').set('text', Array.map(arguments, function (date) {
                    return date.format('%e %B %Y');
                }).join(' - '))
            }
        });
    });
</script>
<style>
  .datepicker .footer button.apply:before{content:"Search";}
  .datepicker .footer button.cancel:before{content:"Cancel";}
</style>
