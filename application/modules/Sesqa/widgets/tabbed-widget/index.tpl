<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 $randonNumber = $this->widgetIdentity;
 
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesqa/externals/styles/styles.css'); ?>
<?php if(!$this->is_ajax){ ?>
  <!--Default Tabs-->
  <?php if($this->tab_option == 'default'){ ?>
  	<div class="layout_core_container_tabs">
  		<div class="tabs_alt tabs_parent" <?php if(count($this->defaultOptions) ==1){ ?> style="display:none" <?php } ?>>
  <?php } ?>
  <!--Advance Tabs-->
  <?php if($this->tab_option == 'advance'){ ?>
  	<div class="sesqa_tabs_container sesbasic_clearfix sesbasic_bxs">
  		<div class="sesqa_tabs sesbasic_clearfix" <?php if(count($this->defaultOptions) ==1){ ?> style="display:none" <?php } ?>>
  <?php } ?>
  <!--Filter Tabs-->
  <?php if($this->tab_option == 'filter'){ ?>
  	<div class="sesbasic_filter_tabs_container sesbasic_clearfix sesbasic_bxs">
  		<div class="sesbasic_filter_tabs sesbasic_clearfix" <?php if(count($this->defaultOptions) ==1){ ?> style="display:none" <?php } ?>>
  <?php } ?>
  <!--Vertical Tabs-->
  <?php if($this->tab_option == 'vertical'){ ?>
  	<div class="sesbasic_v_tabs_container sesbasic_clearfix sesbasic_bxs">
  		<div class="sesbasic_v_tabs sesbasic_clearfix" <?php if(count($this->defaultOptions) ==1){ ?> style="display:none" <?php } ?>>
    <?php } ?>
    <ul id="sesqa-tabbed-widget-tabs-<?php echo $randonNumber; ?>">
      <?php 
           $defaultOptionArray = array();
           foreach($this->defaultOptions as $key=>$valueOptions){ 
           $defaultOptionArray[] = $key;
         ?>
      <li <?php if($this->defaultOpenTab == $key){ ?>class="active"<?php } ?> id="sesTabContainer_<?php echo $randonNumber; ?>_<?php echo $key; ?>"> <a href="javascript:;" data-src="<?php echo $key; ?>" onclick="changeTabSes_<?php echo $randonNumber; ?>('<?php echo $key; ?>')"><?php echo $this->translate(($valueOptions)); ?></a> </li>
      <?php } ?>
    </ul>
  </div>
  <div class="sesbasic_tabs_content sesbasic_clearfix">
<?php } ?>
<?php if($this->viewType == 'list1' || $this->viewType == "list2"){ ?>
  <?php if(empty($this->is_ajax)){ ?>
    <div class="sesqa_listview sesbasic_bxs sesbasic_clearfix">
  <?php } ?>
      <?php if($this->viewType == 'list1'){
        include("application/modules/Sesqa/views/scripts/_list1.tpl");
      }else{
        include("application/modules/Sesqa/views/scripts/_list2.tpl");
      }
      ?>
  <?php if(empty($this->is_ajax)){ ?>
    </div>
  <?php } ?>
<?php }else{ ?>
  <?php if(empty($this->is_ajax)){ ?>
    <div class="sesqa_gridview sesbasic_bxs sesbasic_clearfix">
  <?php } ?>
      <?php 
      if($this->viewType == 'grid1'){
        include("application/modules/Sesqa/views/scripts/_grid1.tpl");
      }else{
        include("application/modules/Sesqa/views/scripts/_grid2.tpl");
      }
    ?>
  <?php if(empty($this->is_ajax)){ ?>
    </div>
  <?php } ?>
<?php } ?>
<?php if($this->loadOptionData != 'pagging' && !$this->is_ajax  && (empty($this->show_limited_data) || $this->show_limited_data  == 'no')):?>
<div class="sesbasic_load_btn" id="view_more_<?php echo $randonNumber;?>" onclick="viewMore_<?php echo $randonNumber; ?>();" >
  <a href="javascript:void(0);" class="sesbasic_animation sesbasic_link_btn" id="feed_viewmore_link_<?php echo $randonNumber; ?>"><i class="fa fa-repeat"></i><span><?php echo $this->translate('View More');?></span></a>
</div>
<div class="sesbasic_load_btn sesbasic_view_more_loading_<?php echo $randonNumber;?>" id="loading_image_<?php echo $randonNumber; ?>" style="display: none;"><span class="sesbasic_link_btn"><i class="fa fa-spinner fa-spin"></i></span></div>
<?php endif;?>
<?php if(empty($this->is_ajax)){ ?>
	</div>
</div>
<?php } ?>
<script type="application/javascript">
  <?php if(empty($this->is_ajax)){ ?>
var searchParams<?php echo $randonNumber; ?> ;
var identity<?php echo $randonNumber; ?>  = '<?php echo $randonNumber; ?>';
var filterSearch<?php  echo $randonNumber; ?> = '<?php echo $this->defaultOpenTab; ?>';
<?php } ?>
var params<?php echo $randonNumber; ?> = '<?php echo json_encode($this->params); ?>';
var page<?php echo $randonNumber; ?> = '<?php echo $this->page + 1; ?>';
<?php if(!$this->is_ajax){ ?>
 var isSearch = false;
 <?php } ?>
 <?php if($this->loadOptionData != 'pagging') { ?>
      en4.core.runonce.add(function() {
    viewMoreHide_<?php echo $randonNumber; ?>();
    });
    function viewMoreHide_<?php echo $randonNumber; ?>() {
      if ($('view_more_<?php echo $randonNumber; ?>'))
	$('view_more_<?php echo $randonNumber; ?>').style.display = "<?php echo ($this->paginator->count() == 0 ? 'none' : ($this->paginator->count() == $this->paginator->getCurrentPageNumber() ? 'none' : '' )) ?>";
    }
    function viewMore_<?php echo $randonNumber; ?> () {
      sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').hide();
      sesJqueryObject('#loading_image_<?php echo $randonNumber; ?>').show(); 
			if(typeof requestViewMore_<?php echo $randonNumber; ?> != "undefined")
          requestViewMore_<?php echo $randonNumber; ?>.cancel();
			requestViewMore_<?php echo $randonNumber; ?> = new Request.HTML({
					method: 'post',
					'url': en4.core.baseUrl + "widget/index/mod/sesqa/name/<?php echo $this->widgetName; ?>",
					'data': {
						format: 'html',
						page: page<?php echo $randonNumber; ?>,    
						params : params<?php echo $randonNumber; ?>, 
						is_ajax : 1,
						searchParams:searchParams<?php echo $randonNumber; ?> ,
						widgetIdentity : '<?php echo $randonNumber; ?>',
						type:'<?php echo $this->viewType; ?>',
            defaultOpenTab:filterSearch<?php  echo $randonNumber; ?>,
					},
							onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
                sesJqueryObject('.sesbasic_view_more_loading_<?php echo $randonNumber;?>').hide();
                document.getElementById('sesqa-tabbed-widget-<?php echo $randonNumber; ?>').innerHTML = document.getElementById('sesqa-tabbed-widget-<?php echo $randonNumber; ?>').innerHTML + responseHTML;
                sesJqueryObject('#loading_images_browse_<?php echo $randonNumber; ?>').remove();
         
								sesJqueryObject('#loadingimgsesqa-wrapper').hide();
								viewMoreHide_<?php echo $randonNumber; ?>();  
              }
				});
      requestViewMore_<?php echo $randonNumber; ?>.send();
      return false;
    }
    <?php }else{ ?>
    function paggingNumber<?php echo $randonNumber; ?>(pageNum){
      sesJqueryObject('#sesbasic_loading_cont_overlay_<?php echo $randonNumber?>').css('display','block');
          if(typeof requestViewMore_<?php echo $randonNumber; ?> != "undefined")
          requestViewMore_<?php echo $randonNumber; ?>.cancel();
      requestViewMore_<?php echo $randonNumber; ?> = (new Request.HTML({
				method: 'post',
				'url': en4.core.baseUrl + "widget/index/mod/sesqa/name/<?php echo $this->widgetName; ?>",
				'data': {
          format: 'html',
          page: pageNum,    
          params : params<?php echo $randonNumber; ?>, 
          is_ajax : 1,
          searchParams:searchParams<?php echo $randonNumber; ?> ,
          widgetIdentity : '<?php echo $randonNumber; ?>',
          type:'<?php echo $this->viewType; ?>',
          defaultOpenTab:filterSearch<?php  echo $randonNumber; ?>,
				},
				onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
          sesJqueryObject('.sesbasic_view_more_loading_<?php echo $randonNumber;?>').hide();
          sesJqueryObject('#loadingimgsesqa-wrapper').hide();
          document.getElementById('sesqa-tabbed-widget-<?php echo $randonNumber; ?>').innerHTML = responseHTML;
          sesJqueryObject('#loading_images_browse_<?php echo $randonNumber; ?>').remove();
        }
      }));
      requestViewMore_<?php echo $randonNumber; ?>.send();
      return false;
    }
  <?php } ?>
  <?php if($this->loadOptionData == 'auto_load' && (empty($this->show_limited_data) || $this->show_limited_data  == 'no')){ ?>
    window.addEvent('load', function() {
      sesJqueryObject(window).scroll( function() {
				var containerId = '#sesqa-tabbed-widget-<?php echo $randonNumber;?>';
				if(typeof sesJqueryObject(containerId).offset() != 'undefined') {
					var hT = sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').offset().top,
					hH = sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').outerHeight(),
					wH = sesJqueryObject(window).height(),
					wS = sesJqueryObject(this).scrollTop();
					if ((wS + 30) > (hT + hH - wH) && sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').css('display') == 'block') {
						document.getElementById('feed_viewmore_link_<?php echo $randonNumber; ?>').click();
					}
				}      
      });
    });
  <?php } ?>
</script> 

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
      filterSearch<?php  echo $randonNumber; ?> = valueTab;
      sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').hide();
      //sesJqueryObject('#loading_image_<?php echo $randonNumber; ?>').show(); 
			document.getElementById('sesqa-tabbed-widget-<?php echo $randonNumber; ?>').innerHTML = '<div class="sesbasic_loading_container" id="loading_image_<?php echo $randonNumber; ?>"></div>';
      if(typeof(requestTab_<?php echo $randonNumber; ?>) != 'undefined')
				requestTab_<?php echo $randonNumber; ?>.cancel();
      if(typeof(requestViewMore_<?php echo $randonNumber; ?>) != 'undefined')
				requestViewMore_<?php echo $randonNumber; ?>.cancel();
      defaultOpenTab = valueTab;
      requestTab_<?php echo $randonNumber; ?> = new Request.HTML({
				method: 'post',
				'url': en4.core.baseUrl+"widget/index/mod/sesqa/name/<?php echo $this->widgetName; ?>/openTab/"+valueTab,
				'data': {
					format: 'html',
          page: 1,    
          params : params<?php echo $randonNumber; ?>, 
          is_ajax : 1,
          searchParams:searchParams<?php echo $randonNumber; ?> ,
          widgetIdentity : '<?php echo $randonNumber; ?>',
          type:'<?php echo $this->viewType; ?>',
          defaultOpenTab:filterSearch<?php  echo $randonNumber; ?>,
				},
				onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
					if(sesJqueryObject('#sesbasic_loading_cont_overlay_<?php echo $randonNumber?>').length)
						sesJqueryObject('#sesbasic_loading_cont_overlay_<?php echo $randonNumber?>').css('display','none');
					else
						sesJqueryObject('#loading_image_<?php echo $randonNumber; ?>').hide(); 
					sesJqueryObject('#norecord<?php echo $this->widgetIdentity; ?>').remove();

					var check = true;
					if(document.getElementById('sesqa-tabbed-widget-<?php echo $randonNumber; ?>'))
							document.getElementById('sesqa-tabbed-widget-<?php echo $randonNumber; ?>').innerHTML = responseHTML;
				  sesJqueryObject('#loading_images_browse_<?php echo $randonNumber; ?>').remove();          
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