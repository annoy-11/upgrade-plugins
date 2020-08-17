<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<script type="text/javascript">

  en4.core.runonce.add(function() {
  
    var pre_rate = <?php echo $this->crowdfunding->rating;?>;
    var rated = '<?php echo $this->rated;?>';
    var crowdfunding_id = <?php echo $this->crowdfunding->crowdfunding_id;?>;
    var total_votes = <?php echo $this->rating_count;?>;
    var viewer = <?php echo $this->viewer_id;?>;
    new_text = '';

    var rating_over = window.rating_over = function(rating) {
      if( rated == 1 ) {
        $('rating_text').innerHTML = "<?php echo $this->translate('you already rated');?>";
        //set_rating();
      } else if( viewer == 0 ) {
        $('rating_text').innerHTML = "<?php echo $this->translate('please login to rate');?>";
      } else {
        $('rating_text').innerHTML = "<?php echo $this->translate('click to rate');?>";
        for(var x=1; x<=5; x++) {
          if(x <= rating) {
            $('rate_'+x).set('class', 'fa fa-star');
          } else {
            $('rate_'+x).set('class', 'fa fa fa-star-o star-disable');
          }
        }
      }
    }
    
    var rating_out = window.rating_out = function() {
      if (new_text != '') {
        $('rating_text').innerHTML = new_text;
      } else {
        $('rating_text').innerHTML = " <?php echo $this->translate(array('%s rating', '%s ratings', $this->rating_count),$this->locale()->toNumber($this->rating_count)) ?>";        
      }
      if (pre_rate != 0) {
        set_rating();
      }
      else {
        for(var x=1; x<=5; x++) {
          $('rate_'+x).set('class', 'fa fa fa-star-o star-disable');
        }
      }
    }

    var set_rating = window.set_rating = function() {
      var rating = pre_rate;
      if (new_text != ''){
        $('rating_text').innerHTML = new_text;
      }
      else{
        $('rating_text').innerHTML = "<?php echo $this->translate(array('%s rating', '%s ratings', $this->rating_count),$this->locale()->toNumber($this->rating_count)) ?>";
      }
      for(var x=1; x<=parseInt(rating); x++) {
        $('rate_'+x).set('class', 'fa fa-star');
      }

      for(var x=parseInt(rating)+1; x<=5; x++) {
        $('rate_'+x).set('class', 'fa fa fa-star-o star-disable');
      }

      var remainder = Math.round(rating)-rating;
      if (remainder <= 0.5 && remainder !=0){
        var last = parseInt(rating)+1;
        $('rate_'+last).set('class', 'fa fa-star-half-o');
      }
    }

    var rate = window.rate = function(rating) {
      $('rating_text').innerHTML = "<?php echo $this->translate('Thanks for rating!');?>";
      for(var x=1; x<=5; x++) {
        $('rate_'+x).set('onclick', '');
      }
      (new Request.JSON({
        'format': 'json',
        'url' : '<?php echo $this->url(array('module' => 'sescrowdfunding', 'controller' => 'index', 'action' => 'rate'), 'default', true) ?>',
        'data' : {
          'format' : 'json',
          'rating' : rating,
          'crowdfunding_id': crowdfunding_id
        },
        'onRequest' : function(){
          rated = 1;
          total_votes = total_votes+1;
          pre_rate = (pre_rate+rating)/total_votes;
          set_rating();
        },
        'onSuccess' : function(responseJSON, responseText)
        {
          $('rating_text').innerHTML = responseJSON[0].total+" ratings";
          new_text = responseJSON[0].total+" ratings";
        }
      })).send();

    }
    set_rating();
  });
</script>
<?php 
	$result = $this->crowdfunding;
	$currency = Engine_Api::_()->sescrowdfunding()->getCurrentCurrency();
	$totalGainAmount = Engine_Api::_()->getDbTable('orders', 'sescrowdfunding')->getCrowdfundingTotalAmount(array('crowdfunding_id' => $result->crowdfunding_id));
	$getDoners = Engine_Api::_()->getDbTable('orders', 'sescrowdfunding')->getDoners(array('crowdfunding_id' => $result->crowdfunding_id));
	$totalGainAmountwithCu = Engine_Api::_()->sescrowdfunding()->getCurrencyPrice($totalGainAmount,$currency);
	$totalAmount = Engine_Api::_()->sescrowdfunding()->getCurrencyPrice($result->price,$currency);
	$totalPerAmountGain = (($totalGainAmount * 100) / $result->price);
	if($totalPerAmountGain > 100) {
		$totalPerAmountGain = 100;
	} else if(empty($totalPerAmountGain)) {
		$totalPerAmountGain = 0;
	}
?>
 <?php if($this->design == 'desgin1') { ?>
 <!--Design 1 -->
  <div class="sesbasic_bxs sesbasic_clearfix sescf_cover_wrapper">
    <div class="sesbasic_clearfix sescf_cover_conainer">
      <div class="sescf_cover_image">
        <img src="<?php echo $this->crowdfunding->getPhotoUrl(); ?>" alt="" />
      </div>
      <div class="sescf_cover_info sesbasic_clearfix">
        <div class="sescf_view_title centerT">
          <h2><?php echo $this->crowdfunding->getTitle(); ?></h2>
        </div>
        <div class="sescf_cover_stats centerT">
          <?php if($this->categoryActive) { ?>
						<p>
						  <?php $category = Engine_Api::_()->getItem('sescrowdfunding_category', $this->crowdfunding->category_id); ?>
						  <?php if($category) { ?>
								<i class="fa fa-folder-open sesbasic_text_light"></i>
								<span><a href="<?php echo $category->getHref(); ?>"><?php echo $category->getTitle(); ?></a></span>
							<?php } ?>
						</p>
          <?php } ?>
          <?php if($this->likeActive) { ?>
						<p>
							<i class="fa fa-thumbs-up sesbasic_text_light"></i>
							<span><?php echo $this->translate(array('%s like', '%s likes', $this->crowdfunding->like_count), $this->locale()->toNumber($this->crowdfunding->like_count)); ?></span>
						</p>
          <?php } ?>
          <?php if($this->commentActive) { ?>
						<p>
							<i class="fa fa-comment sesbasic_text_light"></i>
							<span><?php echo $this->translate(array('%s comment', '%s comments', $this->crowdfunding->comment_count), $this->locale()->toNumber($this->crowdfunding->comment_count)); ?></span>
						</p>
          <?php } ?>
          <?php if($this->viewActive) { ?>
						<p>
							<i class="fa fa-eye sesbasic_text_light"></i>
							<span><?php echo $this->translate(array('%s view', '%s views', $this->crowdfunding->view_count), $this->locale()->toNumber($this->crowdfunding->view_count)); ?></span>
						</p>
          <?php } ?>
          <?php if($this->ratingActive) { ?>
						<p>
							<i class="fa fa-star sesbasic_text_light"></i>
							<span><?php echo $this->translate(array('%s rating', '%s ratings', round($this->crowdfunding->rating,2)), $this->locale()->toNumber(round($this->crowdfunding->rating,2))); ?></span>
						</p>
          <?php } ?>
        </div>
        <div class="sescf_cover_merge">
          <?php if($this->locationActive && $this->crowdfunding->location): ?>
            <div class="sescf_cover_stats centerT">
              <p>
                <i class="fa fa-map-marker sesbasic_text_light"></i>
                <span><a href="<?php echo $this->url(array('resource_id' => $this->crowdfunding->crowdfunding_id,'resource_type'=>'crowdfunding','action'=>'get-direction'), 'sesbasic_get_direction', true); ?>" class="openSmoothbox"><?php echo $this->crowdfunding->location; ?></a></span>
              </p>
            </div>
          <?php endif; ?>              
          <?php if($this->byActive) { ?>
          <div class="sescf_view_two_owner">
            <div class="sescf_view_two_owner_inner">
              <div class="_photo"><?php echo $this->htmlLink($this->crowdfunding->getOwner()->getHref(), $this->itemPhoto($this->crowdfunding->getOwner())); ?></div>
              <div class="_name"><a href="<?php echo $this->crowdfunding->getOwner()->getHref(); ?>"><?php echo $this->crowdfunding->getOwner()->getTitle(); ?></a></div>
            </div>
          </div>
          <?php } ?>
        </div>
        <?php if($this->ratingActive) { ?>
					<div id="crowdfunding_rating" class="sescf_cover_rating centerT" onmouseout="rating_out();">
						<p class="sesbasic_rating_star">
							<span id="rate_1" class="fa fa-star" <?php if (!$this->rated && $this->viewer_id):?> onclick="rate(1);"<?php endif; ?> onmouseover="rating_over(1);"></span>
							<span id="rate_2" class="fa fa-star" <?php if (!$this->rated && $this->viewer_id):?> onclick="rate(2);"<?php endif; ?> onmouseover="rating_over(2);"></span>
							<span id="rate_3" class="fa fa-star" <?php if (!$this->rated && $this->viewer_id):?> onclick="rate(3);"<?php endif; ?> onmouseover="rating_over(3);"></span>
							<span id="rate_4" class="fa fa-star" <?php if (!$this->rated && $this->viewer_id):?> onclick="rate(4);"<?php endif; ?> onmouseover="rating_over(4);"></span>
							<span id="rate_5" class="fa fa-star" <?php if (!$this->rated && $this->viewer_id):?> onclick="rate(5);"<?php endif; ?> onmouseover="rating_over(5);"></span>
							<span id="rating_text" class="sesbasic_rating_text"><?php echo $this->translate('click to rate');?></span>
						</p>
					</div>
        <?php } ?>
        <?php if($this->donationActive) { ?>
              <div class="sescf_view_two_raised">
                <div class="sescf_profile_goal_total">
									<?php $totalGainAmount = Engine_Api::_()->getDbTable('orders', 'sescrowdfunding')->getCrowdfundingTotalAmount(array('crowdfunding_id' => $this->crowdfunding->crowdfunding_id)); ?>
                  <?php $totalGainAmount = Engine_Api::_()->sescrowdfunding()->getCurrencyPrice($totalGainAmount,$currency); ?>
                  <?php echo $totalGainAmount; ?>
                </div>
              <div class="sescf_profile_goal_target">
                <?php $goal = Engine_Api::_()->sescrowdfunding()->getCurrencyPrice($this->crowdfunding->price,$currency); ?>
                <?php echo $this->translate("Raised of %s Goal", $goal); ?>
              </div>
            </div>
            <div class="sescf_view_two_footer">
            <?php
              $daysLeft = 0;
              $fromDate = date('Y-m-d',strtotime($this->crowdfunding->publish_date));
              $curDate = date('Y-m-d');
              $daysLeft = abs(strtotime($curDate) - strtotime($fromDate));
              $days = $daysLeft/(60 * 60 * 24);
            ?>
            <span class="sescf_list_item_progress_bar" style="background-color:#<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfunding.outercolor', 'fbfbfb') ?>"><span style="width:<?php echo $totalPerAmountGain; ?>%;background-color:<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfunding.fillcolor', 'fbfbfb') ?>"></span></span>
            <?php if(empty($this->crowdfunding->show_start_time) && $this->crowdfunding->publish_date != '' && strtotime($this->crowdfunding->publish_date) > time()) { ?>
                <span class="sescf_profile_goal_stat_value sesbasic_text_hl"><?php echo $days; ?> Days Left</span>
              <?php } elseif(strtotime($this->crowdfunding->publish_date) < time() && empty($this->crowdfunding->show_start_time)) { ?>
                <span class="sescf_profile_goal_stat_value sescf_expired"><?php echo $this->translate("Expired"); ?></span>
              <?php } elseif($this->crowdfunding->show_start_time) { ?>
                <span class="sescf_profile_goal_stat_value sesbasic_text_hl"><?php echo $this->translate(""); ?></span>
              <?php } ?>
            </div>
            <div class="sescf_view_two_bottom">
              <div>
                <?php if($this->totalGainAmount < $this->crowdfunding->price) { ?>
          <?php if($this->viewer_id && $this->viewer_id != $this->crowdfunding->owner_id && !empty($this->crowdfunding->show_start_time)) { ?>
            <div class="sescf_profile_goal_btn">
              <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sescrowdfunding', 'controller' => 'order', 'action' => 'donate', 'crowdfunding_id' => $this->crowdfunding->crowdfunding_id, 'gateway_id' => 2), $this->translate("DONATE"), array('class' => 'sesbasic_link_btn')); ?>
            </div>
          <?php } elseif($this->viewer_id && strtotime($this->crowdfunding->publish_date) > time() && $this->viewer_id != $this->crowdfunding->owner_id) { ?>
            <div class="sescf_profile_goal_btn">
              <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sescrowdfunding', 'controller' => 'order', 'action' => 'donate', 'crowdfunding_id' => $this->crowdfunding->crowdfunding_id, 'gateway_id' => 2), $this->translate("DONATE"), array('class' => 'sesbasic_link_btn')); ?>
            </div>
          <?php } ?>
        <?php } else { ?>
          <div class="sescf_profile_goal_success">
            <i class="fa fa-check"></i>
            <span><?php echo $this->translate("Successfully Completed"); ?></span>
          </div>
        <?php } ?>
        </div>
      <?php } ?>
      <div class="cover_socialshare">
        <p class="sescf_list_btns sesbasic_animation">
          <?php $result = $this->crowdfunding; ?>
            <?php $enableShare = Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfunding.enable.sharing', 1); ?>
            <?php if($this->socialSharingActive && $enableShare == 2): ?>
            <?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $result->getHref()); ?>
            <a href="<?php echo 'http://www.facebook.com/sharer/sharer.php?u=' . $urlencode . '&t=' . $result->getTitle(); ?>" onclick="return socialSharingPopUp(this.href, '<?php echo $this->translate('Facebook'); ?>')" class="sesbasic_icon_btn sesbasic_icon_facebook_btn"><i class="fa fa-facebook"></i></a>
            <a href="<?php echo 'https://twitter.com/intent/tweet?url=' . $urlencode . '&text=' . $result->getTitle().'%0a'; ?>" onclick="return socialSharingPopUp(this.href, '<?php echo $this->translate('Twitter')?>')" class="sesbasic_icon_btn sesbasic_icon_twitter_btn"><i class="fa fa-twitter"></i></a>
            <a href="<?php echo 'http://pinterest.com/pin/create/button/?url='.$urlencode; ?>&media=<?php echo urlencode((strpos($result->getPhotoUrl('thumb.main'),'http') === FALSE ? (((!empty($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"] == 'on')) ? "https://" : "http://") . $_SERVER['HTTP_HOST'] ) : $result->getPhotoUrl('thumb.main'))); ?>&description=<?php echo $result->getTitle();?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate('Pinterest'); ?>')" class="sesbasic_icon_btn sesbasic_icon_pintrest_btn"><i class="fa fa-pinterest"></i></a>
            <?php endif; ?>
            
            <?php if($this->likeButtonActive): ?>
              <!--Like Button-->
              <?php $canComment =  $result->authorization()->isAllowed($this->viewer, 'comment');?>
              <?php if($canComment):?>
                <?php $LikeStatus = Engine_Api::_()->sescrowdfunding()->getLikeStatusCrowdfunding($result->crowdfunding_id, $result->getType()); ?>
                <a href="javascript:;" data-url="<?php echo $result->crowdfunding_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sescrowdfunding_like_<?php echo 'sescrowdfunding'; ?> sescrowdfunding_like_<?php echo 'sescrowdfunding'; ?>_<?php echo $result->crowdfunding_id ?> <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $result->like_count; ?></span></a>
              <?php endif; ?>
            <?php endif; ?>
          </p>
        </div>
      </div>
    </div>
  </div> 
  </div>
<?php } else {  ?>
  <!--Design 2-->
  <div class="sescf_view_two sesbasic_bxs sesbasic_clearfix sesbasic_bg sescf_view_information">
    <div class="sescf_profile_des_photos">
  	  <?php echo $this->content()->renderWidget('sescrowdfunding.profile-photos-slideshow'); ?>
    </div> 
    <div class="sescf_view_information_top sesbasic_clearfix">
       <div class="sescf_view_two_cat">
          <?php if($this->categoryActive && $this->crowdfunding->category_id): ?>
            <p>
              <?php $category = Engine_Api::_()->getItem('sescrowdfunding_category', $this->crowdfunding->category_id); ?>
              <?php if($category) { ?>
              <span><a href="<?php echo $category->getHref(); ?>"><?php echo $category->getTitle(); ?></a></span>
              <?php } ?>
            </p>
          <?php endif; ?>
          <div class="sescf_view_information_stats floatR">
          <?php if($this->likeActive) { ?>
						<p>
							<i class="fa fa-thumbs-up sesbasic_text_light"></i>
							<span><?php echo $this->crowdfunding->like_count; ?></span>
						</p>
          <?php } ?>
          <?php if($this->commentActive) { ?>
						<p>
							<i class="fa fa-comment sesbasic_text_light"></i>
							<span><?php echo $this->crowdfunding->comment_count; ?></span>
						</p>
          <?php } ?>
          <?php if($this->viewActive) { ?>
						<p>
							<i class="fa fa-eye sesbasic_text_light"></i>
							<span><?php echo $this->crowdfunding->view_count; ?></span>
						</p>
          <?php } ?>
          <?php if($this->ratingActive) { ?>
						<p>
							<i class="fa fa-star sesbasic_text_light"></i>
							<span><?php echo round($this->crowdfunding->rating,2); ?></span>
						</p>
          <?php } ?>
        </div>
        </div>
      <div class="sescf_view_title">
        <h2><?php echo $this->crowdfunding->getTitle(); ?></h2>
      </div>
      <?php if($this->ratingActive) { ?>
       <div id="crowdfunding_rating" class="sescf_view_information_rating" onmouseout="rating_out();">
          <p class="sesbasic_rating_star">
            <span id="rate_1" class="fa fa-star" <?php if (!$this->rated && $this->viewer_id):?> onclick="rate(1);"<?php endif; ?> onmouseover="rating_over(1);"></span>
            <span id="rate_2" class="fa fa-star" <?php if (!$this->rated && $this->viewer_id):?> onclick="rate(2);"<?php endif; ?> onmouseover="rating_over(2);"></span>
            <span id="rate_3" class="fa fa-star" <?php if (!$this->rated && $this->viewer_id):?> onclick="rate(3);"<?php endif; ?> onmouseover="rating_over(3);"></span>
            <span id="rate_4" class="fa fa-star" <?php if (!$this->rated && $this->viewer_id):?> onclick="rate(4);"<?php endif; ?> onmouseover="rating_over(4);"></span>
            <span id="rate_5" class="fa fa-star" <?php if (!$this->rated && $this->viewer_id):?> onclick="rate(5);"<?php endif; ?> onmouseover="rating_over(5);"></span>
            <span id="rating_text" class="sesbasic_rating_text"><?php echo $this->translate('click to rate');?></span>
          </p>
        </div>
			<?php } ?>
			<?php if($this->byActive) { ?>
        <div class="sescf_view_two_owner">
          <span>Project Owner</span>
          <div class="sescf_view_two_owner_inner">
            <div class="_photo"><?php echo $this->htmlLink($this->crowdfunding->getOwner()->getHref(), $this->itemPhoto($this->crowdfunding->getOwner())); ?></div>
            <div class="_name"><a href="<?php echo $this->crowdfunding->getOwner()->getHref(); ?>"><?php echo $this->crowdfunding->getOwner()->getTitle(); ?></a></div>
          </div>
       </div>
       <?php } ?>
       <?php if($this->donationActive) { ?>
        <div class="sescf_view_two_raised">
          <div class="sescf_profile_goal_total">
            <?php $totalGainAmount = Engine_Api::_()->getDbTable('orders', 'sescrowdfunding')->getCrowdfundingTotalAmount(array('crowdfunding_id' => $this->crowdfunding->crowdfunding_id)); ?>
                  <?php $totalGainAmount = Engine_Api::_()->sescrowdfunding()->getCurrencyPrice($totalGainAmount,$currency); ?>
                  <?php echo $totalGainAmount; ?>
          </div>
        <div class="sescf_profile_goal_target">
          <?php $goal = Engine_Api::_()->sescrowdfunding()->getCurrencyPrice($this->crowdfunding->price,$currency); ?>
          <?php echo $this->translate("Raised of %s Goal", $goal); ?>
        </div>
      </div>
      <div class="sescf_view_two_footer">
			<?php
				$daysLeft = 0;
				$fromDate = date('Y-m-d',strtotime($this->crowdfunding->publish_date));
				$curDate = date('Y-m-d');
				$daysLeft = abs(strtotime($curDate) - strtotime($fromDate));
				$days = $daysLeft/(60 * 60 * 24);
			?>
      <span class="sescf_list_item_progress_bar" style="background-color:#<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfunding.outercolor', 'fbfbfb') ?>"><span style="width:<?php echo $totalPerAmountGain; ?>%;background-color:<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfunding.fillcolor', 'fbfbfb') ?>"></span></span>
      <?php if(empty($this->crowdfunding->show_start_time) && $this->crowdfunding->publish_date != '' && strtotime($this->crowdfunding->publish_date) > time()) { ?>
          <span class="sescf_profile_goal_stat_value sesbasic_text_hl"><?php echo $days; ?> Days Left</span>
        <?php } elseif(strtotime($this->crowdfunding->publish_date) < time() && empty($this->crowdfunding->show_start_time)) { ?>
          <span class="sescf_profile_goal_stat_value sescf_expired"><?php echo $this->translate("Expired"); ?></span>
        <?php } elseif($this->crowdfunding->show_start_time) { ?>
          <span class="sescf_profile_goal_stat_value sesbasic_text_hl"><?php echo $this->translate(""); ?></span>
        <?php } ?>
      </div>
      <div class="sescf_view_two_bottom">
          <div>
            <?php if($this->totalGainAmount < $this->crowdfunding->price) { ?>
    <?php if($this->viewer_id && $this->viewer_id != $this->crowdfunding->owner_id && !empty($this->crowdfunding->show_start_time)) { ?>
      <div class="sescf_profile_goal_btn">
        <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sescrowdfunding', 'controller' => 'order', 'action' => 'donate', 'crowdfunding_id' => $this->crowdfunding->crowdfunding_id, 'gateway_id' => 2), $this->translate("DONATE"), array('class' => 'sesbasic_link_btn')); ?>
      </div>
    <?php } elseif($this->viewer_id && strtotime($this->crowdfunding->publish_date) > time() && $this->viewer_id != $this->crowdfunding->owner_id) { ?>
      <div class="sescf_profile_goal_btn">
        <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sescrowdfunding', 'controller' => 'order', 'action' => 'donate', 'crowdfunding_id' => $this->crowdfunding->crowdfunding_id, 'gateway_id' => 2), $this->translate("DONATE"), array('class' => 'sesbasic_link_btn')); ?>
      </div>
    <?php } ?>
  <?php } else { ?>
    <div class="sescf_profile_goal_success">
    	<i class="fa fa-check"></i>
      <span><?php echo $this->translate("Successfully Completed"); ?></span>
    </div>
  <?php } ?>
          </div>
<?php } ?>
          
          <div>
              <p class="sescf_list_btns sesbasic_animation">
              <?php $result = $this->crowdfunding; ?>
            <?php $enableShare = Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfunding.enable.sharing', 1); ?>
            <?php if($this->socialSharingActive && $enableShare == 2): ?>
            <?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $result->getHref()); ?>
            <a href="<?php echo 'http://www.facebook.com/sharer/sharer.php?u=' . $urlencode . '&t=' . $result->getTitle(); ?>" onclick="return socialSharingPopUp(this.href, '<?php echo $this->translate('Facebook'); ?>')" class="sesbasic_icon_btn sesbasic_icon_facebook_btn"><i class="fa fa-facebook"></i></a>
            <a href="<?php echo 'https://twitter.com/intent/tweet?url=' . $urlencode . '&text=' . $result->getTitle().'%0a'; ?>" onclick="return socialSharingPopUp(this.href, '<?php echo $this->translate('Twitter')?>')" class="sesbasic_icon_btn sesbasic_icon_twitter_btn"><i class="fa fa-twitter"></i></a>
            <a href="<?php echo 'http://pinterest.com/pin/create/button/?url='.$urlencode; ?>&media=<?php echo urlencode((strpos($result->getPhotoUrl('thumb.main'),'http') === FALSE ? (((!empty($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"] == 'on')) ? "https://" : "http://") . $_SERVER['HTTP_HOST'] ) : $result->getPhotoUrl('thumb.main'))); ?>&description=<?php echo $result->getTitle();?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate('Pinterest'); ?>')" class="sesbasic_icon_btn sesbasic_icon_pintrest_btn"><i class="fa fa-pinterest"></i></a>
            <?php endif; ?>
            
            <?php if($this->likeButtonActive): ?>
              <!--Like Button-->
              <?php $canComment =  $result->authorization()->isAllowed($this->viewer, 'comment');?>
              <?php if($canComment):?>
                <?php $LikeStatus = Engine_Api::_()->sescrowdfunding()->getLikeStatusCrowdfunding($result->crowdfunding_id, $result->getType()); ?>
                <a href="javascript:;" data-url="<?php echo $result->crowdfunding_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sescrowdfunding_like_<?php echo 'sescrowdfunding'; ?> sescrowdfunding_like_<?php echo 'sescrowdfunding'; ?>_<?php echo $result->crowdfunding_id ?> <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $result->like_count; ?></span></a>
              <?php endif; ?>
            <?php endif; ?>
          </p>
          </div>
      </div>
    </div>
  </div>
<?php } ?>
