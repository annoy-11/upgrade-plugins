<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<?php $randonNumber = $this->identity; ?>
<?php if(!$this->is_ajax){ ?>
<?php if($this->params['tabOption'] == 'default'){ ?>
  <div class="layout_core_container_tabs" <?php if(count($this->defaultOptions) ==1){ ?> style="border-width:0;" <?php } ?>>
  	<div class="tabs_alt tabs_parent" <?php if(count($this->defaultOptions) ==1){ ?> style="display:none" <?php } ?>>
<?php } ?>
<!--Advance Tabs-->
<?php  if($this->params['tabOption'] == 'advance'){ ?>
  <div class="sesbasic_tabs_container sesbasic_clearfix sesbasic_bxs" <?php if(count($this->defaultOptions) ==1){ ?> style="border-width:0;" <?php } ?>>
    <div class="sesbasic_tabs sesbasic_clearfix" <?php if(count($this->defaultOptions) ==1){ ?> style="display:none" <?php } ?>>
 <?php  } ?>
<?php if($this->params['tabOption'] == 'filter'){ ?>
  <div class="sesbasic_filter_tabs_container sesbasic_clearfix sesbasic_bxs" <?php if(count($this->defaultOptions) ==1){ ?> style="border-width:0;" <?php } ?>>
    <div class="sesbasic_filter_tabs sesbasic_clearfix" <?php if(count($this->defaultOptions) ==1){ ?> style="display:none" <?php } ?>>
<?php } ?>
<?php if($this->params['tabOption'] == 'vertical'){ ?>
  <div class="sesbasic_v_tabs_container sesbasic_clearfix sesbasic_bxs" <?php if(count($this->defaultOptions) ==1){ ?> style="border-width:0;" <?php } ?>>
    <div class="sesbasic_v_tabs sesbasic_clearfix" <?php if(count($this->defaultOptions) ==1){ ?> style="display:none" <?php } ?>>
<?php } ?>
    <ul style="margin-bottom:10px;">
       <?php 
         $defaultOptionArray = array();
         foreach($this->defaultOptions as $key=>$valueOptions){ 
         $defaultOptionArray[] = $key;
       ?>
       <li <?php if($this->defaultOpenTab == $key){ ?> class="active"<?php } ?> id="sesTabContainer_<?php echo $randonNumber; ?>_<?php echo $key; ?>">
         <a href="javascript:;" data-src="<?php echo $key; ?>" onclick="changeTabSes_<?php echo $randonNumber; ?>('<?php echo $key; ?>')"><?php echo $valueOptions; ?></a>
       </li>
       <?php } ?>
      </ul>
      <?php if(SESBUSINESSPACKAGE == 1):?>
        <div class="sesbusiness_manage_package_btn">
          <a href="<?php echo $this->url(array('action' => 'package'),'sesbusiness_general',true);?>" class="sesbasic_link_btn"><?php echo $this->translate("My Packages"); ?></a>
        </div>
      <?php endif;?>
     </div>
  <div class="sesbasic_tabs_content sesbasic_clearfix">
<?php } ?>
<?php $editLink = 1;?>
	<?php include APPLICATION_PATH . '/application/modules/Sesbusiness/views/scripts/_showBusinessListGrid.tpl'; ?>
<?php if(!$this->is_ajax){ ?>
    </div>
  </div>
<?php } ?>

<?php if(!$this->is_ajax):?>
  <script type="application/javascript"> 
    var availableTabs_<?php echo $randonNumber; ?>;
    var requestTab_<?php echo $randonNumber; ?>;
    <?php if(isset($defaultOptionArray)){ ?>
      availableTabs_<?php echo $randonNumber; ?> = <?php echo json_encode($defaultOptionArray); ?>;
    <?php  } ?>
    var defaultOpenTab ;
    function changeTabSes_<?php echo $randonNumber; ?>(valueTab){
      if(sesJqueryObject("#sesTabContainer_<?php echo $randonNumber; ?>_"+valueTab).hasClass('active'))
      return;
      var id = '_<?php echo $randonNumber; ?>';
      var length = availableTabs_<?php echo $randonNumber; ?>.length;
      for (var i = 0; i < length; i++){
	if(availableTabs_<?php echo $randonNumber; ?>[i] == valueTab){
	  document.getElementById('sesTabContainer'+id+'_'+availableTabs_<?php echo $randonNumber; ?>[i]).addClass('active');
	  sesJqueryObject('#sesTabContainer'+id+'_'+availableTabs_<?php echo $randonNumber; ?>[i]).addClass('sesbasic_tab_selected');
	}else{
	  sesJqueryObject('#sesTabContainer'+id+'_'+availableTabs_<?php echo $randonNumber; ?>[i]).removeClass('sesbasic_tab_selected');
	  document.getElementById('sesTabContainer'+id+'_'+availableTabs_<?php echo $randonNumber; ?>[i]).removeClass('active');
	}
      }
      if(valueTab){
	if(document.getElementById("error-message_<?php echo $randonNumber;?>"))
	document.getElementById("error-message_<?php echo $randonNumber;?>").style.display = 'none';
	
	if(document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>'))
	document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML ='';
	
	sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').hide();
	document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML = '<div class="sesbasic_view_more_loading" id="loading_image_<?php echo $randonNumber; ?>"> <img src="<?php echo $this->layout()->staticBaseUrl; ?>application/modules/Sesbasic/externals/images/loading.gif" /> </div>';
	
	if(typeof(requestTab_<?php echo $randonNumber; ?>) != 'undefined')
	requestTab_<?php echo $randonNumber; ?>.cancel();
	
	if(typeof(requestViewMore_<?php echo $randonNumber; ?>) != 'undefined')
	requestViewMore_<?php echo $randonNumber; ?>.cancel();
	defaultOpenTab = valueTab;
        var type_data = "<?php echo $this->typedata; ?>"
	requestTab_<?php echo $randonNumber; ?> = new Request.HTML({
	  method: 'post',
	  'url': en4.core.baseUrl+"widget/index/mod/sesbusiness/name/<?php echo $this->widgetName; ?>/openTab/"+valueTab,
	  'data': {
	    format: 'html',  
	    is_ajax : 1,
	    searchParams:searchParams<?php echo $randonNumber; ?> ,
	    identity : '<?php echo $randonNumber; ?>',
	    height:'<?php echo $this->height;?>',
            widget_id: '<?php echo $this->widgetId;?>',
            type:sesJqueryObject("a.selectView_<?php echo $randonNumber; ?>.active").attr('rel'),
	  },
	  onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
	    
	    if(sesJqueryObject('#sesbasic_loading_cont_overlay_<?php echo $randonNumber?>').length)
	    sesJqueryObject('#sesbasic_loading_cont_overlay_<?php echo $randonNumber?>').css('display','none');
	    else
	    sesJqueryObject('#loading_image_<?php echo $randonNumber; ?>').hide();
	      
	    sesJqueryObject('#error-message_<?php echo $randonNumber;?>').remove();
	    var check = true;
	    if(document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>'))
	    document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML = responseHTML;
	    if(sesJqueryObject('.pin_selectView_<?php echo $randonNumber;?>').hasClass('active')) {
	      if(document.getElementById('sesbusiness_pinboard_view_<?php echo $randonNumber;?>'))
	      document.getElementById('sesbusiness_pinboard_view_<?php echo $randonNumber;?>').style.display = 'block';
	      pinboardLayout_<?php echo $randonNumber ?>('force','true');
	    }
	    sesJqueryObject('.sesbasic_view_more_loading_<?php echo $randonNumber;?>').hide();
	    if(typeof viewMoreHide_<?php echo $randonNumber; ?> == 'function')
	    viewMoreHide_<?php echo $randonNumber; ?>();
	  }
	});
	requestTab_<?php echo $randonNumber; ?>.send();
	return false;			
      }
    }
	
  </script> 
<?php endif;?>
