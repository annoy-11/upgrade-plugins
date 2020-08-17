<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessreview
 * @package    Sesbusinessreview
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-11-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $randonNumber = $this->widgetId; ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'externals/tinymce/tinymce.min.js'); ?>
<?php if(!$this->is_ajax){ ?>
  <?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbusinessreview/externals/styles/styles.css'); ?>
  <ul class="sesbusinessreview_review_listing sesbasic_clearfix sesbasic_bxs" id="sesbusinessreview_review_listing">
<?php } ?>
<?php if( $this->paginator->getTotalItemCount() > 0 ){ ?>
  <?php include APPLICATION_PATH . '/application/modules/Sesbusinessreview/views/scripts/_showReviewList.tpl'; ?>
  <?php if($this->loadOptionData == 'pagging'){ ?>
      <?php echo $this->paginationControl($this->paginator, null, array("_pagging.tpl", "sesbusinessreview"),array('identityWidget'=>$randonNumber)); ?>
    <?php } ?>
<?php }else{ ?>
	<div class="tip">
    <span>
      <?php echo $this->translate('No review have been posted yet.');?>
    </span>
  </div>
<?php } ?>
<?php if(!$this->is_ajax){ ?>
  </ul>
<?php } ?>
<?php if($this->loadOptionData != 'pagging' && !$this->is_ajax):?>
  <div class="sesbasic_load_btn" id="view_more_<?php echo $randonNumber;?>" onclick="viewMore_<?php echo $randonNumber; ?>();" ><a href="javascript:void(0);" class="sesbasic_animation sesbasic_link_btn" id="feed_viewmore_link_<?php echo $randonNumber; ?>"><i class="fa fa-repeat"></i><span><?php echo $this->translate('View More');?></span></a></div>
  <div class="sesbasic_load_btn sesbasic_view_more_loading_<?php echo $randonNumber;?>" id="loading_image_<?php echo $randonNumber; ?>" style="display: none;"> <span class="sesbasic_link_btn"><i class="fa fa-spinner fa-spin"></i></span></div>
<?php endif;?>
<script type="application/javascript">
  <?php if(!$this->is_ajax):?>
    <?php if($this->loadOptionData == 'auto_load'){ ?>
      window.addEvent('load', function() {
        sesJqueryObject(window).scroll( function() {
          var containerId = '#sesbusinessreview_review_listing';
          if(typeof sesJqueryObject(containerId).offset() != 'undefined') {
            var heightOfContentDiv_<?php echo $randonNumber; ?> = sesJqueryObject(containerId).offset().top;
            var fromtop_<?php echo $randonNumber; ?> = sesJqueryObject(this).scrollTop();
            if(fromtop_<?php echo $randonNumber; ?> > heightOfContentDiv_<?php echo $randonNumber; ?> - 100 && sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').css('display') == 'block' ){
              document.getElementById('feed_viewmore_link_<?php echo $randonNumber; ?>').click();
            }
          }
        });
      });
    <?php } ?>
  <?php endif; ?>
  var business<?php echo $randonNumber; ?> = <?php echo $this->business + 1; ?>;
  var params<?php echo $randonNumber; ?> = '<?php echo json_encode($this->params); ?>';
  var searchParams<?php echo $randonNumber; ?> = '';
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
        'url': en4.core.baseUrl + "widget/index/mod/sesbusinessreview/name/browse-reviews",
        'data': {
          format: 'html',
          business: business<?php echo $randonNumber; ?>,    
          params : params<?php echo $randonNumber; ?>, 
          is_ajax : 1,
          limit:'<?php echo $this->limit; ?>',
          widgetId : '<?php echo $this->widgetId; ?>',
          searchParams : searchParams<?php echo $randonNumber; ?>,
          loadOptionData : '<?php echo $this->loadOptionData ?>'
        },
        onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
          sesJqueryObject('#sesbusinessreview_review_listing').append(responseHTML);
          sesJqueryObject('.sesbasic_view_more_loading_<?php echo $randonNumber;?>').hide();
          sesJqueryObject('#loadingimgsesbusinessreviewreview-wrapper').hide();
          viewMoreHide_<?php echo $randonNumber; ?>();
        }
      });
      requestViewMore_<?php echo $randonNumber; ?>.send();
      return false;
	}
  <?php }else{ ?>
    function paggingNumber<?php echo $randonNumber; ?>(businessNum){
      sesJqueryObject('#sesbasic_loading_cont_overlay_<?php echo $randonNumber?>').css('display','block');
      requestViewMore_<?php echo $randonNumber; ?> = (new Request.HTML({
        method: 'post',
        'url': en4.core.baseUrl + "widget/index/mod/sesbusinessreview/name/browse-reviews",
        'data': {
          format: 'html',
          business: businessNum,
          params :params<?php echo $randonNumber; ?> , 
          searchParams : searchParams<?php echo $randonNumber; ?>,
          is_ajax : 1,
          limit:'<?php echo $this->limit; ?>',
          widgetId : '<?php echo $this->widgetId; ?>',
          loadOptionData : '<?php echo $this->loadOptionData ?>'
        },
        onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
          sesJqueryObject('#sesbusinessreview_review_listing').html(responseHTML);
          sesJqueryObject('#sesbasic_loading_cont_overlay_<?php echo $randonNumber?>').css('display', 'none');
          sesJqueryObject('#loadingimgsesbusinessreviewreview-wrapper').hide();
        }
      }));
      requestViewMore_<?php echo $randonNumber; ?>.send();
      return false;
    }
  <?php } ?>
</script>