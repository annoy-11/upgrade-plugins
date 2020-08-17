<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Ecoupon
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php @$randonNumber = @$randonNumber ? @$randonNumber : $this->widgetId; ?>
<?php if(!$this->is_ajax){ ?>
  <?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Ecoupon/externals/styles/styles.css'); ?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery1.11.js'); ?>
  <div class="ecoupon_coupon_main" id="coupon-browse-widget_<?php echo $randonNumber; ?>">
<?php } ?>
  <?php foreach($this->paginator as $coupon): ?> 
    <?php include APPLICATION_PATH .  '/application/modules/Ecoupon/views/scripts/coupon-view.tpl';?>
  <?php endforeach; ?>
  
  <?php if($this->params['pagging'] == 'pagging' && (!isset($this->params['show_limited_data']) || $this->params['show_limited_data'] == 'no')): ?>
    <?php echo $this->paginationControl($this->paginator, null, array("_pagging.tpl", "ecoupon"),array('identityWidget'=>$randonNumber)); ?>
  <?php endif;?>
<?php if(!$this->is_ajax){ ?>
  </div>
  <?php if($this->params['pagging'] != 'pagging' && (!isset($this->params['show_limited_data']) || $this->params['show_limited_data'] == 'no')):?>
    <div class="sesbasic_load_btn" id="view_more_<?php echo $randonNumber;?>" onclick="viewMore_<?php echo $randonNumber; ?>();" >
      <a href="javascript:void(0);" class="sesbasic_animation sesbasic_link_btn" id="feed_viewmore_link_<?php echo $randonNumber; ?>"><i class="fa fa-repeat"></i><span><?php echo $this->translate('View More');?></span></a>
    </div>  
    <div class="sesbasic_load_btn sesbasic_view_more_loading_<?php echo $randonNumber;?>" id="loading_image_<?php echo $randonNumber; ?>" style="display: none;"><span class="sesbasic_link_btn"><i class="fa fa-spinner fa-spin"></i></span></div>
  <?php endif;?>
<?php } ?>
<script type="text/javascript">
  var defaultOpenTab = '<?php echo $this->defaultOpenTab; ?>';
  var requestViewMore_<?php echo $randonNumber; ?>;
  var params<?php echo $randonNumber; ?> = <?php echo json_encode($this->params); ?>;
  var identity<?php echo $randonNumber; ?>  = '<?php echo $randonNumber; ?>';
  var page<?php echo $randonNumber; ?> = '<?php echo $this->page + 1; ?>';
  var searchParams<?php echo $randonNumber; ?> ;
  var is_search_<?php echo $randonNumber;?> = 0;
  <?php if($this->params['pagging'] != 'pagging'){ ?>
    viewMoreHide_<?php echo $randonNumber; ?>();	
    function viewMoreHide_<?php echo $randonNumber; ?>() {
      if ($('view_more_<?php echo $randonNumber; ?>'))
      $('view_more_<?php echo $randonNumber; ?>').style.display = "<?php echo ($this->paginator->count() == 0 ? 'none' : ($this->paginator->count() == $this->paginator->getCurrentPageNumber() ? 'none' : '' )) ?>";
    }
    function viewMore_<?php echo $randonNumber; ?> (){
      sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').hide();
      if(!isSearch)
        sesJqueryObject('#loading_image_<?php echo $randonNumber; ?>').show(); 
      var openTab_<?php echo $randonNumber; ?> = '<?php echo $this->defaultOpenTab; ?>';  
      requestViewMore_<?php echo $randonNumber; ?> = new Request.HTML({
        method: 'post',
        'url': en4.core.baseUrl + "widget/index/mod/ecoupon/id/<?php echo $this->widgetId; ?>/name/<?php echo $this->widgetName; ?>/openTab/" + openTab_<?php echo $randonNumber; ?>,
        'data': {
          format: 'html',
          page: page<?php echo $randonNumber; ?>,    
          params : params<?php echo $randonNumber; ?>, 
          is_ajax : 1,
          is_search:is_search_<?php echo $randonNumber;?>,
          view_more:1,
          identity : '<?php echo $randonNumber; ?>',
          searchParams:searchParams<?php echo $randonNumber; ?> ,
          widget_id: '<?php echo $this->widgetId;?>',
          type:'<?php echo $this->view_type;?>',
          identityObject:'<?php echo isset($this->identityObject) ? $this->identityObject : "" ?>',
          getParams:'<?php echo $this->getParams;?>',
          resource_type: '<?php echo !empty($this->resource_type) ? $this->resource_type : "";?>',
          resource_id: '<?php echo !empty($this->resource_id) ? $this->resource_id : "";?>',
        },
        onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) { 
          if($('loading_images_browse_<?php echo $randonNumber; ?>'))
            sesJqueryObject('#loading_images_browse_<?php echo $randonNumber; ?>').remove();
          if($('loadingimgecoupon-wrapper'))
            sesJqueryObject('#loadingimgecoupon-wrapper').hide();
          if(!isSearch) {
            document.getElementById('coupon-browse-widget_<?php echo $randonNumber; ?>').innerHTML = document.getElementById('coupon-browse-widget_<?php echo $randonNumber; ?>').innerHTML + responseHTML;
          }
          else { 
            document.getElementById('coupon-browse-widget_<?php echo $randonNumber; ?>').innerHTML = document.getElementById('coupon-browse-widget_<?php echo $randonNumber; ?>').innerHTML + responseHTML;
            isSearch = false;
          }
          var totalCoupons= sesJqueryObject('#coupon-browse-widget_<?php echo $randonNumber; ?>').find("#paginator_count_ajax_ecoupon_entry"); 
          sesJqueryObject('.sesbasic_view_type_<?php echo $randonNumber; ?>').find('#paginator_count_ecoupon').html(totalCoupons.html());
          totalCoupons.remove();
          document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = 'none';
        }
      });
      requestViewMore_<?php echo $randonNumber; ?>.send();
      return false;
    }
  <?php }else{ ?>
    function paggingNumber<?php echo $randonNumber; ?>(pageNum){
      sesJqueryObject('.sesbasic_loading_cont_overlay').css('display','block');
      var openTab_<?php echo $randonNumber; ?> = '<?php echo $this->defaultOpenTab; ?>';
      requestViewMore_<?php echo $randonNumber; ?> = (new Request.HTML({
        method: 'post',
        'url': en4.core.baseUrl + "widget/index/mod/ecoupon/id/<?php echo $this->widgetId; ?>/name/<?php echo $this->widgetName; ?>/openTab/" + openTab_<?php echo $randonNumber; ?>,
        'data': {
          format: 'html',
          page: pageNum,    
          params :params<?php echo $randonNumber; ?> , 
          is_ajax : 1,
          searchParams:searchParams<?php echo $randonNumber; ?>,
          widget_id: '<?php echo $this->widgetId;?>',
          type:'<?php echo $this->view_type;?>',
          getParams:'<?php echo $this->getParams;?>',
          resource_type: '<?php echo !empty($this->resource_type) ? $this->resource_type : "";?>',
          resource_id: '<?php echo !empty($this->resource_id) ? $this->resource_id : "";?>',
        },
        onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
          if($('loading_images_browse_<?php echo $randonNumber; ?>'))
            sesJqueryObject('#loading_images_browse_<?php echo $randonNumber; ?>').remove();
          if($('loadingimgecoupon-wrapper'))
            sesJqueryObject('#loadingimgecoupon-wrapper').hide();
          sesJqueryObject('.sesbasic_loading_cont_overlay').css('display','none');
          document.getElementById('coupon-browse-widget_<?php echo $randonNumber; ?>').innerHTML =  responseHTML;
          var totalCoupons= sesJqueryObject('#coupon-browse-widget_<?php echo $randonNumber; ?>').find("#paginator_count_ajax_ecoupon_entry"); 
          sesJqueryObject('.sesbasic_view_type_<?php echo $randonNumber; ?>').find('#paginator_count_ecoupon').html(totalCoupons.html());
          totalCoupons.remove();
          sesJqueryObject('html, body').animate({
              scrollTop: sesJqueryObject("#scrollHeightDivSes_<?php echo $randonNumber; ?>").offset().top
          }, 500);
        }
      }));
      requestViewMore_<?php echo $randonNumber; ?>.send();
      return false;
    }
  <?php } ?>
   var isSearch = false;
</script>
