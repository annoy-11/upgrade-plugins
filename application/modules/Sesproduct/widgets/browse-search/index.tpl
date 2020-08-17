<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
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
<?php $this->headScript()->appendFile($baseURL . 'application/modules/Sesproduct/externals/scripts/jquery.js'); ?>
<div class="sesproduct_browse_search <?php echo $this->view_type=='horizontal' ? 'sesproduct_browse_search_horizontal' : 'sesproduct_browse_search_vertical'; ?>">
  <?php echo $this->form->render($this) ?>

</div>

<?php $request = Zend_Controller_Front::getInstance()->getRequest();?>
<?php $controllerName = $request->getControllerName();?>
<?php $actionName = $request->getActionName(); ?>
<?php $class = '.sesproduct_products_listing';?>
<?php if($actionName == 'browse'):?>
  <?php $pageName = 'sesproduct_index_browse';?>
  <?php $widgetName = 'sesproduct.browse-products';?>
<?php elseif($actionName == 'browse-products'):?>
  <?php $pageName = 'sesproduct_index_'.$this->page_id;?>
  <?php $widgetName = 'sesproduct.browse-products';?>
<?php elseif($actionName == 'manage'):?>
  <?php $pageName = 'sesproduct_index_manage';?>
  <?php $widgetName = 'sesproduct.manage-products';?>
<?php elseif($actionName == 'locations'):?>
  <?php $pageName = 'sesproduct_index_locations';?>
  <?php $widgetName = 'sesproduct.product-location';?>
  <?php $class = '.sesbasic_large_map';?>
  <?php else: ?>
  <?php $pageName = 'sesproduct_index_browse';?>
  <?php $widgetName = 'sesproduct.browse-products';?>
<?php endif;?>

<?php $identity = Engine_Api::_()->sesproduct()->getIdentityWidget($widgetName,'widget',$pageName); ?>
<script type="application/javascript">
  sesJqueryObject(document).ready(function(){
  
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
	sesJqueryObject('#loadingimgsesproduct-wrapper').show();
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

  var Searchurl = "<?php echo $this->url(array('module' =>'sesproduct','controller' => 'index', 'action' => 'get-product'),'default',true); ?>";
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
    var url = en4.core.baseUrl + 'sesproduct/index/subcategory/category_id/' + cat_id + '/type/'+ 'search';
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

    var url = en4.core.baseUrl + 'sesproduct/index/subsubcategory/subcategory_id/' + cat_id + '/type/'+ 'search';;
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
  
  window.addEvent('domready', function() {
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
  
  sesJqueryObject(document).ready(function(){
    mapLoad = false;
    if(sesJqueryObject('#lat-wrapper').length > 0){
      sesJqueryObject('#lat-wrapper').css('display' , 'none');
      sesJqueryObject('#lng-wrapper').css('display' , 'none');
      initializeSesProductMapList();
    }
  });
</script>
<script type="text/javascript">
  var sliderLeft=document.getElementById("slider0to50");
  var sliderRight=document.getElementById("slider51to100");
  var inputMin=document.getElementById("min");
  var inputMax=document.getElementById("max");
  function sliderLeftInput(){
    sliderLeft.value=inputMin.value;
  }
  function sliderRightInput(){
    sliderRight.value=(inputMax.value);
  }
  inputMin.addEventListener("change",sliderLeftInput);
  inputMax.addEventListener("change",sliderRightInput);
  function inputMinSliderLeft(){
    inputMin.value=sliderLeft.value;
  }
  function inputMaxSliderRight(){
    inputMax.value=sliderRight.value;
  }
  sliderLeft.addEventListener("change",inputMinSliderLeft);
  sliderRight.addEventListener("change",inputMaxSliderRight);
</script>
