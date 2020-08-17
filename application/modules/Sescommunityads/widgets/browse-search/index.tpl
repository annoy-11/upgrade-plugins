<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescommunityads
 * @package    Sescommunityads
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-10-09 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sescommunityads/externals/styles/styles.css'); ?>

<div class="sescmads_search sesbasic_bxs <?php echo $this->view_type=='horizontal' ? 'sescmads_search_horizontal' : 'sescmads_search_vertical'; ?>">
  <?php echo $this->form->render($this) ?>
</div>

<?php $request = Zend_Controller_Front::getInstance()->getRequest();?>
<?php $controllerName = $request->getControllerName();?>
<?php $actionName = $request->getActionName(); ?>

<?php if($actionName == 'browse'){?>
  <?php $pageName = 'sescommunityads_index_browse';?>
  <?php $widgetName = 'sescommunityads.browse-ads';?>
<?php } ?>

<?php $identity = Engine_Api::_()->sescommunityads()->getIdentityWidget($widgetName,'widget',$pageName); ?>
<script type="application/javascript">
  sesJqueryObject(document).ready(function(){
    if(sesJqueryObject('#content_type').length && sesJqueryObject('#content_type').val() != "promote_content"){
      sesJqueryObject('#content_module-wrapper').hide();  
    }
    sesJqueryObject('#loadingimgsescommunityads-wrapper').hide();
    sesJqueryObject('#filter_form').submit(function(e){
      e.preventDefault();
      if(sesJqueryObject('#sescomm_widget_<?php echo $identity; ?>').length > 0){
        sesJqueryObject('#sescomm_widget_<?php echo $identity; ?>').html('');
        sesJqueryObject('#loading_image_<?php echo $identity; ?>').show();
        sesJqueryObject('#loadingimgsescommunityads-wrapper').show();
        is_search_<?php echo $identity; ?> = 1;
        if(typeof paggingNumber<?php echo $identity; ?> == 'function'){
          document.getElementById('sescomm_widget_<?php echo $identity; ?>').innerHTML = "<div class='clear sesbasic_loading_container' id='loading_images_browse_<?php echo $identity; ?>'></div>";
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
  });
  
  function showSubCategory(cat_id,selected) {
    var url = en4.core.baseUrl + 'sescommunityads/index/subcategory/category_id/' + cat_id + '/type/'+ 'search';
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

    var url = en4.core.baseUrl + 'sescommunityads/index/subsubcategory/subcategory_id/' + cat_id + '/type/'+ 'search';;
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
  function getModule(value){
      if(value == "promote_content"){
          sesJqueryObject('#content_module-wrapper').show();
      }else{
        sesJqueryObject('#content_module-wrapper').hide();  
      }
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
      sescommMapSearch();
    }
  });
</script>