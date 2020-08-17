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
  <script type="text/javascript">
  var previous_rate_value;
    function showReviewForm() {  
      document.getElementById('sesbusinessreview_review_create_form').style.display = 'block';
      setTimeout(function() { tinymce.init({
        mode: "specific_textareas",
        editor_selector: "sesbusinessreview_review_tinymce",
        plugins: "table,fullscreen,media,preview,paste,code,image,textcolor",
        theme: "modern",
        menubar: false,
        statusbar: false,
        toolbar1: "",
        toolbar2: "",
        toolbar3: "",
        element_format: "html",
        height: "225px",
        convert_urls: false,
        language: "en",
        directionality: "ltr"
      });console.log('dsadsadasda');}, '1000');
      var openObject = sesJqueryObject('#sesbusinessreview_review_create_form');
      sesJqueryObject('html, body').animate({
          scrollTop: openObject.offset().top
      }, 2000);
      if(typeof review_cover_data_rate_id != 'undefined'){
        previous_rate_value = sesJqueryObject('#rate_value').val();
        window.rate(review_cover_data_rate_id);	
      }
    }
  </script>
  <?php $editReviewPrivacy = Engine_Api::_()->sesbasic()->getViewerPrivacy('businessreview', 'edit');?>
  <?php if($this->viewer()->getIdentity() && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinessreview.allow.review', 1) && $this->allowedCreate):?>
    <div class="sesbasic_profile_tabs_top sesbasic_clearfix sesbusinessreview_review_profile_btn">
      <a id="sesbusinessreview_create_button" href="javascript:void(0)" onclick="showReviewForm();" class="sesbasic_button" style="display:<?php if($this->cancreate && !$this->isReview): ?>block;<?php else:?>none;<?php endif;?>">
				<i class="fa fa-plus"></i>
				<span><?php echo $this->translate('Write a Review');?></span>
			</a>
      <a id="sesbusinessreview_edit_button" href="javascript:void(0)" onclick="showReviewForm();" class="sesbasic_button" style="display:<?php if($editReviewPrivacy && $this->isReview):?>block;<?php else:?>none;<?php endif;?>">
				<i class="fa fa-plus"></i>
        <span><?php echo $this->translate('Update Review');?></span>
      </a>
    </div>
  <?php endif;?>
  <?php if( $this->paginator->getTotalItemCount() > 0 ){ ?>
    <div class="sesbusinessreview_profile_reviews_filters sesbasic_bxs sesbasic_clearfix">
      <?php echo $this->content()->renderWidget('sesbusinessreview.browse-review-search',array('review_search'=>1,'review_stars'=>1,'reviewRecommended'=>1,'review_title'=>0,'view_type'=>'horizontal','isWidget'=>true,'business_id'=>$this->subject->getIdentity(),'widgetIdentity'=>$this->identity)); ?>
    </div>
  <?php } ?>
  <ul class="sesbusinessreview_review_listing sesbasic_clearfix sesbasic_bxs" id="sesbusinessreview_review_listing">
<?php } ?>
  <?php if( $this->paginator->getTotalItemCount() > 0 ){ ?>
    <?php foreach( $this->paginator as $item ): ?>
      <li class="sesbasic_clearfix <?php if($item->owner_id == $this->viewer()->getIdentity()):?>sesbusinessreview_owner_review<?php endif;?>">
        <div class="sesbusinessreview_review_listing_top sesbasic_clearfix">
          <?php if(in_array('title', $this->stats)): ?>
            <div class='sesbusinessreview_review_listing_title sesbasic_clearfix'>
              <?php echo $this->htmlLink($item->getHref(), $item->title) ?>
            </div>
          <?php endif; ?>
          <div class="sesbusinessreview_review_listing_top_info sesbasic_clearfix">
            <?php if(in_array('postedBy', $this->stats)): ?>
              <div class='sesbusinessreview_review_listing_top_info_img'>
                <?php echo $this->htmlLink($item->getOwner()->getHref(), $this->itemPhoto($item->getOwner(), 'thumb.icon')) ?>
              </div>
            <?php endif; ?>
	        <div class='sesbusinessreview_review_listing_top_info_cont'>
            	<?php if(in_array('postedBy', $this->stats) || in_array('creationDate', $this->stats)): ?>
              	<p class="sesbusinessreview_review_listing_stats sesbasic_text_light">
                  <?php if(in_array('postedBy', $this->stats)): ?>
                    <?php echo $this->translate('by');?>&nbsp;<?php echo $this->htmlLink($item->getOwner()->getHref(), $item->getOwner()->getTitle(), array('class' => 'ses_tooltip', 'data-src' => $item->getOwner()->getGuid())) ?>
                    <?php if(in_array('creationDate', $this->stats)): ?> | <?php endif; ?>
                  <?php endif; ?>
                  <?php if(in_array('creationDate', $this->stats)): ?>		
                    <?php echo $this->translate('about');?>
                    <?php echo $this->timestamp(strtotime($item->creation_date)) ?>
                  <?php endif; ?>
              	</p>
              <?php endif; ?>
              <p class="sesbasic_text_light sesbusinessreview_review_listing_stats">
                <?php if(in_array('likeCount', $this->stats)): ?>
                <span title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count)); ?>"><i class="fa fa-thumbs-up"></i><?php echo $item->like_count; ?></span>
                <?php endif; ?>
                <?php if(in_array('commentCount', $this->stats)): ?>
                <span title="<?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber($item->comment_count))?>"><i class="fa fa-comment"></i><?php echo $item->comment_count;?></span>
                <?php endif; ?>
                <?php if(in_array('viewCount', $this->stats)): ?>
                <span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count))?>"><i class="fa fa-eye"></i><?php echo $item->view_count; ?></span>
                <?php endif; ?>
              </p>
            </div>	
          </div>
          <div class="sesbusinessreview_review_show_rating review_ratings_listing">
            <?php if(in_array('rating', $this->stats)): ?>
              <div class="sesbasic_rating_star">
                <?php $ratingCount = $item->rating;?>
                <?php for($i=0; $i<5; $i++){?>
                  <?php if($i < $ratingCount):?>
                    <span id="" class="sesbusinessreview_rating_star"></span>
                  <?php else:?>
                    <span id="" class="sesbusinessreview_rating_star sesbusinessreview_rating_star_disable"></span>
                  <?php endif;?>
                <?php }?>
              </div>
            <?php endif ?>
            <?php if(in_array('parameter', $this->stats)){ ?>
              <?php $reviewParameters = Engine_Api::_()->getDbtable('parametervalues', 'sesbusinessreview')->getParameters(array('content_id'=>$item->getIdentity(),'business_id'=>$item->business_id)); ?>
              <?php if(count($reviewParameters)>0){ ?>
                <div class="sesbusinessreview_review_show_rating_box sesbasic_clearfix">
                  <?php foreach($reviewParameters as $reviewP){ ?>
                    <div class="sesbasic_clearfix">
                      <div class="sesbusinessreview_review_show_rating_label"><?php echo $reviewP['title']; ?></div>
                      <div class="sesbusinessreview_review_show_rating_parameters sesbasic_rating_parameter sesbasic_rating_parameter_small">
                  <?php $ratingCount = $reviewP['rating'];?>
                  <?php for($i=0; $i<5; $i++){?>
                    <?php if($i < $ratingCount):?>
                      <span id="" class="sesbasic-rating-parameter-unit"></span>
                    <?php else:?>
                      <span id="" class="sesbasic-rating-parameter-unit sesbasic-rating-parameter-unit-disable"></span>
                    <?php endif;?>
                  <?php }?>
                </div>
              </div>
            <?php } ?>
          </div>
              <?php } 
            }?>
          </div>
    	</div>
        <div class="sesbusinessreview_review_listing_desc sesbasic_clearfix">
          <?php if(in_array('pros', $this->stats) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinessreview.show.pros', 1)): ?>
            <p class="sesbusinessreview_review_listing_body">
              <b><?php echo $this->translate("Pros"); ?></b>
              <?php echo $this->string()->truncate($this->string()->stripTags($item->pros), 300) ?>
            </p>
          <?php endif; ?>
          <?php if(in_array('cons', $this->stats) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinessreview.show.cons', 1)): ?>
            <p class="sesbusinessreview_review_listing_body">
              <b><?php echo $this->translate("Cons"); ?></b>
              <?php echo $this->string()->truncate($this->string()->stripTags($item->cons), 300) ?>
            </p>
          <?php endif; ?>
          <?php if(in_array('description', $this->stats) && $item->description): ?>
            <p class='sesbusinessreview_review_listing_body'>
              <b><?php echo $this->translate("Description"); ?></b>
              <?php echo $this->string()->truncate($this->string()->stripTags($item->description), 300) ?>
            </p>
          <?php endif; ?>
	  <p class="sesbusinessreview_review_listing_recommended"> <b><?php echo $this->translate('Recommended');?><i class="<?php if($item->recommended):?>fa fa-check<?php else:?>fa fa-times<?php endif;?>"></i></b></p>
          <p class="sesbusinessreview_review_listing_more">
          	<a href="<?php echo $item->getHref(); ?>" class=""><?php echo $this->translate("Continue Reading"); ?> &raquo;</a>
          </p>
        </div>
        <?php  echo $this->partial('_reviewOptions.tpl','sesbusinessreview',array('subject'=>$item,'viewer'=>Engine_Api::_()->user()->getViewer(),'stats'=>$this->stats,'updateReview' => 1, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon,'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>        
      </li>
    <?php endforeach; ?>
     <?php if($this->loadOptionData == 'pagging'){ ?>
      <?php echo $this->paginationControl($this->paginator, null, array("_pagging.tpl", "sesbusinessreview"),array('identityWidget'=>$randonNumber)); ?>
    <?php } ?>
  <?php }else{ ?>
  <div class="tip">
    <span>
      <?php echo $this->translate('No review have been posted on this business yet.');?>
    </span>
  </div>
  <?php } ?>
<?php if(!$this->is_ajax){ ?>
  </ul>
  <?php if($this->loadOptionData != 'pagging' && !$this->is_ajax):?>
    <div class="sesbasic_load_btn" id="view_more_<?php echo $randonNumber;?>" onclick="viewMore_<?php echo $randonNumber; ?>();" ><a href="javascript:void(0);" class="sesbasic_animation sesbasic_link_btn" id="feed_viewmore_link_<?php echo $randonNumber; ?>"><i class="fa fa-repeat"></i><span><?php echo $this->translate('View More');?></span></a></div>
  <div class="sesbasic_load_btn sesbasic_view_more_loading_<?php echo $randonNumber;?>" id="loading_image_<?php echo $randonNumber; ?>" style="display: none;"> <span class="sesbasic_link_btn"><i class="fa fa-spinner fa-spin"></i></span></div>
  <?php endif;?>
  <?php if(($this->allowedCreate && $this->cancreate && $this->viewer()->getIdentity() && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinessreview.allow.review', 1) && !$this->isReview) || ($editReviewPrivacy)): ?>
    <div id="sesbusinessreview_review_create_form" class="sesbusinessreview_review_form_block" style="display:none;"> 
      <?php echo $this->form->render($this);?>
      <div class="sesbasic_loading_cont_overlay" style="display:none"></div>
    </div>
  <?php endif;?>
  <script type="text/javascript">
    function closeReviewForm() {
      document.getElementById('sesbusinessreview_review_create_form').style.display = 'none';
      var openObject = sesJqueryObject('.sesbusinessreview_review_profile_btn');
      sesJqueryObject('html, body').animate({
          scrollTop: openObject.offset().top
      }, 2000);
      if(sesJqueryObject('#sesbusinessreview_edit_button').length && previous_rate_value != 'undefined'){
          window.rate(previous_rate_value);
      }
    }
  </script>
<?php } ?>
<script type="application/javascript">
  <?php if(!$this->is_ajax):?>
	sesJqueryObject(document).on('click','.sesbusinessreview_own_update_review',function(e){
      e.preventDefault();
      showReviewForm();
	});
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
  var params<?php echo $randonNumber; ?> = '<?php echo json_encode($this->stats); ?>';
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
      'url': en4.core.baseUrl + "widget/index/mod/sesbusinessreview/name/business-reviews",
      'data': {
        format: 'html',
        business: business<?php echo $randonNumber; ?>,    
        params : params<?php echo $randonNumber; ?>, 
        is_ajax : 1,
        limit:'<?php echo $this->limit; ?>',
        widgetId : '<?php echo $this->widgetId; ?>',
        searchParams : searchParams<?php echo $randonNumber; ?>,
        business_id:'<?php echo $this->business_id; ?>',
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
        'url': en4.core.baseUrl + "widget/index/mod/sesbusinessreview/name/business-reviews",
        'data': {
            format: 'html',
            business: businessNum,
            business_id:'<?php echo $this->business_id; ?>',
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
  var tabId_pE1 = '<?php echo $this->identity; ?>';
  window.addEvent('domready', function() {
    tabContainerHrefSesbasic(tabId_pE1);	
  });
</script>
