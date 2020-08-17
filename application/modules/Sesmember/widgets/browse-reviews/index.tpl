<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmember
 * @package    Sesmember
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php $randonNumber = $this->widgetId; ?>
<?php if(!$this->is_ajax){ ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesmember/externals/styles/styles.css'); ?>
<ul class="sesmember_review_listing sesbasic_clearfix sesbasic_bxs" id="sesmember_review_listing">
<?php } ?>
<?php if( $this->paginator->getTotalItemCount() > 0 ){ ?>
  <?php foreach( $this->paginator as $item ): ?>
    <?php $reviewer = Engine_Api::_()->getItem('user', $item->user_id);?>
    <li class="sesbasic_clearfix">
    	<div class="sesmember_review_listing_left">
      	<div class="sesmember_review_listing_left_photo">
          <?php echo $this->htmlLink($item->getOwner()->getHref(), $this->itemPhoto($item->getOwner(), 'thumb.profile')) ?>
        </div>
        <p class="sesmember_review_listing_left_title"><?php echo $this->htmlLink($item->getOwner()->getHref(), $item->getOwner()->getTitle(),array('class' => 'ses_tooltip', 'data-src' => $item->getOwner()->getGuid())) ?></p>
        <p class="sesmember_review_listing_left_btns clear sesbasic_clearfix">
	  <?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 &&  isset($this->friendButtonActive)):?>
	    <?php echo '<span>'.$this->partial('_addfriend.tpl', 'sesbasic', array('subject' => $reviewer)).'</span>'; ?>
	  <?php endif;?>
	  <?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 &&  isset($this->likemainButtonActive)):?>
	    <?php $LikeStatus = Engine_Api::_()->sesbasic()->getLikeStatus($reviewer->user_id,$reviewer->getType());?>
	    <?php $likeClass = (!$LikeStatus) ? 'fa-thumbs-up' : 'fa-thumbs-down' ;?>
	    <?php $likeText = ($LikeStatus) ?  $this->translate('Unlike') : $this->translate('Like') ;?>
	    <?php echo "<span><a href='javascript:;' data-url='".$reviewer->getIdentity()."' class='sesbasic_btn sesmember_add_btn sesmember_button_like_user sesmember_button_like_user_". $reviewer->user_id."'><i class='fa ".$likeClass."'></i><span><i class='fa fa-caret-down'></i>$likeText</span></a></span>";?>
	  <?php endif;?>
	  <?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 &&  isset($this->followButtonActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.follow.active',1)  && !Engine_Api::_()->user()->getViewer()->isSelf($reviewer)){
	    $FollowUser = Engine_Api::_()->sesmember()->getFollowStatus($reviewer->user_id);
	    $followClass = (!$FollowUser) ? 'fa-check' : 'fa-times' ;
	    $followText = ($FollowUser) ?  $this->translate('Unfollow') : $this->translate('Follow') ;
	    echo "<span><a href='javascript:;' data-url='".$reviewer->getIdentity()."' class='sesbasic_btn sesmember_add_btn sesmember_follow_user sesmember_follow_user_".$reviewer->getIdentity()."'><i class='fa ".$followClass."'></i> <span><i class='fa fa-caret-down'></i>$followText</span></a></span>"; 
	  }
	  ?>
	  <?php if (Engine_Api::_()->sesbasic()->hasCheckMessage($reviewer) && isset($this->messageActive)): ?>
	    <?php $baseUrl = $this->baseUrl();?>
	    <?php $messageText = $this->translate('Message');?>
	    <?php echo "<span><a href=\"$baseUrl/messages/compose/to/$reviewer->user_id\" target=\"_parent\" title=\"$messageText\" class=\"smoothbox sesbasic_btn sesmember_add_btn\"><i class=\"fa fa-commenting-o\"></i><span><i class=\"fa fa-caret-down\"></i>".$this->translate('Message')."</span></a></span>"; ?>
	  <?php endif; ?>        
        </p>
        <?php if(isset($this->featuredLabelActive) && $item->featured):?>
	  <div class="sesmember_review_featured_block">
	  <p><?php echo $this->translate('Featured');?></p>
	  </div>
	<?php endif;?>
	<?php if(isset($this->verifiedLabelActive) && $item->verified):?>
	  <div class="sesmember_review_verified_block">
	    <p><?php echo $this->translate('Verified');?></p>
	  </div>
	<?php endif;?>
      </div>
      <div class="sesmember_review_listing_right sesbasic_clearfix">
        <div class="sesmember_review_listing_top sesbasic_clearfix">
          <?php if(in_array('title', $this->stats)): ?>
            <div class='sesmember_review_listing_title sesbasic_clearfix'>
              <?php echo $this->htmlLink($item->getHref(), $item->title) ?>
            </div>
          <?php endif; ?>
          <!--<div class="sesmember_review_featured_verified_block">
          	<p class="featured" title="Featured"><i class="fa fa-star"></i></p>
            <p class="verified" title="Verified"><i class="fa fa-check"></i></p>
          </div>-->
        <div class="sesmember_review_listing_top_info sesbasic_clearfix">
          <?php if(in_array('postedBy', $this->stats)): ?>
            <div class='sesmember_review_listing_top_info_img'>
              <?php echo $this->htmlLink($reviewer->getOwner()->getHref(), $this->itemPhoto($reviewer->getOwner(), 'thumb.icon')) ?>
            </div>
          <?php endif; ?>
          <div class='sesmember_review_listing_top_info_cont'>
            <?php if(in_array('postedBy', $this->stats) || in_array('creationDate', $this->stats)): ?>
              <p class="sesmember_review_listing_stats">
                <?php if(in_array('postedBy', $this->stats)): ?>
                  <?php echo $this->translate('For ');?><?php echo $this->htmlLink($reviewer->getOwner()->getHref(), $reviewer->getOwner()->getTitle(), array('class' => 'ses_tooltip', 'data-src' => $reviewer->getOwner()->getGuid())) ?>
                <?php endif; ?>
                <?php if(in_array('postedBy', $this->stats) && in_array('creationDate', $this->stats)): ?> | <?php endif; ?>
                <?php if(in_array('creationDate', $this->stats)): ?>
                  <?php echo $this->translate('about');?>
                  <?php echo $this->timestamp(strtotime($item->creation_date)) ?>
                <?php endif; ?>
               </p>
            <?php endif; ?>
            
            <p class="sesmember_review_listing_stats sesbasic_text_light">
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
          <div class="sesmember_review_show_rating review_ratings_listing">
            <?php if(in_array('rating', $this->stats)): ?>
              <div class="sesbasic_rating_star">
                <?php $ratingCount = $item->rating;?>
                <?php for($i=0; $i<5; $i++){?>
            <?php if($i < $ratingCount):?>
              <span id="" class="sesmember_rating_star"></span>
            <?php else:?>
              <span id="" class="sesmember_rating_star sesmember_rating_star_disable"></span>
            <?php endif;?>
                <?php }?>
              </div>
            <?php endif ?>
            <?php if(in_array('parameter', $this->stats)){ ?>
              <?php $reviewParameters = Engine_Api::_()->getDbtable('parametervalues', 'sesmember')->getParameters(array('content_id'=>$item->getIdentity(),'user_id'=>$item->owner_id)); ?>
              <?php if(count($reviewParameters)>0){ ?>
                <div class="sesmember_review_show_rating_box sesbasic_clearfix">
            <?php foreach($reviewParameters as $reviewP){ ?>
              <div class="sesbasic_clearfix">
                <div class="sesmember_review_show_rating_label"><?php echo $reviewP['title']; ?></div>
                <div class="sesmember_review_show_rating_parameters sesbasic_rating_parameter sesbasic_rating_parameter_small">
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
        <div class="sesmember_review_listing_desc sesbasic_clearfix">
          <?php if(in_array('pros', $this->stats) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.show.pros', 1)): ?>
            <p class="sesmember_review_listing_body">
              <b><?php echo $this->translate("Pros"); ?></b>
              <?php echo $this->string()->truncate($this->string()->stripTags($item->pros), 300) ?>
            </p>
          <?php endif; ?>
          <?php if(in_array('cons', $this->stats) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.show.cons', 1)): ?>
            <p class="sesmember_review_listing_body">
              <b><?php echo $this->translate("Cons"); ?></b>
              <?php echo $this->string()->truncate($this->string()->stripTags($item->cons), 300) ?>
            </p>
          <?php endif; ?>
          <?php if(in_array('description', $this->stats) && $item->description): ?>
            <p class='sesmember_review_listing_body'>
              <b><?php echo $this->translate("Description"); ?></b>
              <?php echo $this->string()->truncate($this->string()->stripTags($item->description), 300) ?>
            </p>
          <?php endif; ?>
	  <?php if(in_array('recommended', $this->stats)):?>
	    <p class="sesmember_review_listing_recommended"> <b><?php echo $this->translate('Recommended');?><i class="<?php if($item->recommended):?>fa fa-check<?php else:?>fa fa-times<?php endif;?>"></i></b></p>
	  <?php endif;?>
          <p class="sesmember_review_listing_more">
            <a href="<?php echo $item->getHref()?>" class=""><?php echo $this->translate('Continue Reading »');?></a>
          </p>
        </div>
        <?php  echo $this->partial('_reviewOptions.tpl','sesmember',array('subject'=>$item,'viewer'=>$this->viewer(),'stats'=>$this->stats)); ?>
      </div>
    </li>
  <?php endforeach; ?>
  <?php if($this->loadOptionData == 'pagging'){ ?>
      <?php echo $this->paginationControl($this->paginator, null, array("_pagging.tpl", "sesmember"),array('identityWidget'=>$randonNumber)); ?>
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
<?php  } ?>

<?php if($this->loadOptionData != 'pagging' && !$this->is_ajax):?>
  <div class="sesbasic_load_btn" id="view_more_<?php echo $randonNumber;?>" onclick="viewMore_<?php echo $randonNumber; ?>();" ><a href="javascript:void(0);" class="sesbasic_animation sesbasic_link_btn" id="feed_viewmore_link_<?php echo $randonNumber; ?>"><i class="fa fa-repeat"></i><span><?php echo $this->translate('View More');?></span></a></div>
<div class="sesbasic_load_btn sesbasic_view_more_loading_<?php echo $randonNumber;?>" id="loading_image_<?php echo $randonNumber; ?>" style="display: none;"> <span class="sesbasic_link_btn"><i class="fa fa-spinner fa-spin"></i></span></div>
<?php endif;?>

<script type="application/javascript">
  <?php if(!$this->is_ajax):?>
    <?php if($this->loadOptionData == 'auto_load'){ ?>
    window.addEvent('load', function() {
      sesJqueryObject(window).scroll( function() {
	var containerId = '#sesmember_review_listing';
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

	var page<?php echo $randonNumber; ?> = <?php echo $this->page + 1; ?>;
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
				'url': en4.core.baseUrl + "widget/index/mod/sesmember/name/browse-reviews",
				'data': {
		format: 'html',
		page: page<?php echo $randonNumber; ?>,    
		params : params<?php echo $randonNumber; ?>, 
		is_ajax : 1,
		limit:'<?php echo $this->limit; ?>',
		widgetId : '<?php echo $this->widgetId; ?>',
		searchParams : searchParams<?php echo $randonNumber; ?>,
		loadOptionData : '<?php echo $this->loadOptionData ?>'
				},
				onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
				sesJqueryObject('#sesmember_review_listing').append(responseHTML);
				sesJqueryObject('.sesbasic_view_more_loading_<?php echo $randonNumber;?>').hide();
				sesJqueryObject('#loadingimgsesmemberreview-wrapper').hide();
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
				'url': en4.core.baseUrl + "widget/index/mod/sesmember/name/browse-reviews",
				'data': {
					format: 'html',
					page: pageNum,
					params :params<?php echo $randonNumber; ?> , 
					searchParams : searchParams<?php echo $randonNumber; ?>,
					is_ajax : 1,
					limit:'<?php echo $this->limit; ?>',
					widgetId : '<?php echo $this->widgetId; ?>',
					loadOptionData : '<?php echo $this->loadOptionData ?>'
				},
				onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
					sesJqueryObject('#sesmember_review_listing').html(responseHTML);
					sesJqueryObject('#sesbasic_loading_cont_overlay_<?php echo $randonNumber?>').css('display', 'none');
					sesJqueryObject('#loadingimgsesmemberreview-wrapper').hide();
				}
			}));
			requestViewMore_<?php echo $randonNumber; ?>.send();
			return false;
		}
<?php } ?>
</script>