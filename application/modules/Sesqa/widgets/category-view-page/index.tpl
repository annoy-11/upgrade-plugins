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
 
 ?>
<?php 
$randonNumber = $this->widgetIdentity;
if(!$this->is_ajax){ ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesqa/externals/styles/styles.css'); ?>
<div class="sesqa_category_qa_listing_head">
  <?php if($this->subject->getCategoryIconUrl()){ ?>
	<img src="<?php echo $this->subject->getCategoryIconUrl(); ?>" />
  <?php } ?>
  <span><?php echo $this->subject->category_name; ?></span>
</div>
<?php } ?>
<?php if($this->viewType == 'list1' || $this->viewType == "list2"){ ?>
<?php if(!$this->is_ajax){ ?>
<div class="sesqa_listview sesbasic_bxs sesbasic_clearfix">
<?php } ?>
    <?php if($this->viewType == 'list1'){
      include("application/modules/Sesqa/views/scripts/_list1.tpl");
    }else{
      include("application/modules/Sesqa/views/scripts/_list2.tpl");
    }
    ?>
    <?php if(!$this->is_ajax){ ?>
</div>
<?php } ?>
<?php }else{ ?>
<?php if(!$this->is_ajax){ ?>
  <div class="sesqa_gridview sesbasic_bxs sesbasic_clearfix">
<?php } ?>
    <?php 
      if($this->viewType == 'grid1'){
        include("application/modules/Sesqa/views/scripts/_grid1.tpl");
      }else{
        include("application/modules/Sesqa/views/scripts/_grid2.tpl");
      }
    ?>
    <?php if(!$this->is_ajax){ ?>
  </div>
  <?php  } ?>
<?php } ?>
<?php if($this->loadOptionData != 'pagging' && !$this->is_ajax):?>
<div class="sesbasic_load_btn" id="view_more_<?php echo $randonNumber;?>" onclick="viewMore_<?php echo $randonNumber; ?>();" > <?php echo $this->htmlLink('javascript:void(0);', $this->translate('View More'), array('id' => "feed_viewmore_link_$randonNumber", 'class' => 'sesbasic_animation sesbasic_link_btn fa fa-repeat')); ?> </div>
<div class="sesbasic_load_btn sesbasic_view_more_loading_<?php echo $randonNumber;?>" id="loading_image_<?php echo $randonNumber; ?>" style="display: none;"><span class="sesbasic_link_btn"><i class="fa fa-spinner fa-spin"></i></span> </div>

<?php endif;?>
<script type="application/javascript">
  <?php if(empty($this->is_ajax)){ ?>
var identity<?php echo $randonNumber; ?>  = '<?php echo $randonNumber; ?>';
<?php } ?>
var page<?php echo $randonNumber; ?> = '<?php echo $this->page + 1; ?>';
<?php if(!$this->is_ajax){ ?>
 var isSearch = false;
 <?php } ?>
 <?php if($this->loadOptionData != 'pagging') { ?>
    viewMoreHide_<?php echo $randonNumber; ?>();
    function viewMoreHide_<?php echo $randonNumber; ?>() {
      if ($('view_more_<?php echo $randonNumber; ?>'))
	$('view_more_<?php echo $randonNumber; ?>').style.display = "<?php echo ($this->paginator->count() == 0 ? 'none' : ($this->paginator->count() == $this->paginator->getCurrentPageNumber() ? 'none' : '' )) ?>";
    }
    function viewMore_<?php echo $randonNumber; ?> () {
      sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').hide();
      sesJqueryObject('#loading_image_<?php echo $randonNumber; ?>').show(); 
			
			requestViewMore_<?php echo $randonNumber; ?> = new Request.HTML({
					method: 'post',
					'url': en4.core.baseUrl + "widget/index/mod/sesqa/name/<?php echo $this->widgetName; ?>",
					'data': {
						format: 'html',
						page: page<?php echo $randonNumber; ?>,    
						is_ajax : 1,
						widgetIdentity : '<?php echo $randonNumber; ?>',
            viewtype: '<?php echo $this->viewType; ?>',
            category_id: '<?php echo $this->category_id; ?>',
            socialshare_icon_limit: '<?php echo $this->socialshare_icon_limit; ?>',
            socialshare_enable_plusicon: '<?php echo $this->socialshare_enable_plusicon; ?>',
            title_truncate: '<?php echo $this->title_truncate; ?>',
            qacriteria: '<?php echo $this->qacriteria; ?>',
            locationEnable: '<?php echo $this->locationEnable; ?>',
            limitdataqa: '<?php echo $this->limitdataqa; ?>',
            height: '<?php echo $this->height; ?>',
            width: '<?php echo $this->width; ?>',
            loadOptionData:'<?php echo $this->loadOptionData; ?>',
            showinformation: '<?php echo json_encode($this->showOptions); ?>',
            
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
			
      requestViewMore_<?php echo $randonNumber; ?> = (new Request.HTML({
				method: 'post',
				'url': en4.core.baseUrl + "widget/index/mod/sesqa/name/<?php echo $this->widgetName; ?>",
				'data': {
          format: 'html',
          page: pageNum,    
          is_ajax : 1,
          widgetIdentity : '<?php echo $randonNumber; ?>',
          viewtype: '<?php echo $this->viewType; ?>',
          category_id: '<?php echo $this->category_id; ?>',
          socialshare_icon_limit: '<?php echo $this->socialshare_icon_limit; ?>',
          socialshare_enable_plusicon: '<?php echo $this->socialshare_enable_plusicon; ?>',
          title_truncate: '<?php echo $this->title_truncate; ?>',
          qacriteria: '<?php echo $this->qacriteria; ?>',
          locationEnable: '<?php echo $this->locationEnable; ?>',
          limitdataqa: '<?php echo $this->limitdataqa; ?>',
          height: '<?php echo $this->height; ?>',
          width: '<?php echo $this->width; ?>',
          loadOptionData:'<?php echo $this->loadOptionData; ?>',
          showinformation: '<?php echo json_encode($this->showOptions); ?>',
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