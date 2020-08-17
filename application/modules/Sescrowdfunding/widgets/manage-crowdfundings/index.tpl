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

<div class="sesbasic_clearfix sesbasic_bxs">
  <?php if( $this->paginator->getTotalItemCount() > 0 ): ?>
    <!--List View Start Here-->
    <ul class="sesbasic_clearfix sescf_list_listing">
      <?php foreach($this->paginator as $result): ?>
        <li class="sesbasic_clearfix sescf_list_item">
          <div class="sesbasic_clearfix sescf_list_item_inner">
            <div class="sescf_list_item_thumb sescf_list_btns_wrapper" style="height:230px;width:250px;">
              <img class="sescf_grid_item_img" src="<?php echo $result->getPhotoUrl(); ?>" alt="" />
              <a href="<?php echo $result->getHref(); ?>" class="sescf_list_item_thumb_overlay sesbasic_animation"></a>
               <div class="sescf_labels_main">
          <?php if($this->featuredLabelActive && $result->featured): ?>
            <p class="sescf_labels sesbasic_animation">
              <span class="sescf_label_featured"><?php echo $this->translate("FEATURED");?></span>
            </p>
          <?php endif; ?>
            <?php if($this->sponsoredLabelActive && $result->sponsored): ?>
            <p class="sescf_labels sesbasic_animation">
              <span class="sescf_label_sponsored"><?php echo $this->translate("SPONSORED");?></span>
            </p>
          <?php endif; ?>
           <?php if($this->verifiedLabelActive && $result->verified): ?>
            <p class="sescf_labels sesbasic_animation">
              <span class="sescf_label_verified"><?php echo $this->translate("VERIFIED");?></span>
            </p>
          <?php endif; ?>
          </div>
              <p class="sescf_list_btns sesbasic_animation">
                <?php $enableShare = Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfunding.enable.sharing', 1); ?>
                <?php if($enableShare == 2) { ?>
                <?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $result->getHref()); ?>
                <a href="<?php echo 'http://www.facebook.com/sharer/sharer.php?u=' . $urlencode . '&t=' . $result->getTitle(); ?>" onclick="return socialSharingPopUp(this.href, '<?php echo $this->translate('Facebook'); ?>')" class="sesbasic_icon_btn sesbasic_icon_facebook_btn"><i class="fa fa-facebook"></i></a>
                <a href="<?php echo 'https://twitter.com/intent/tweet?url=' . $urlencode . '&text=' . $result->getTitle().'%0a'; ?>" onclick="return socialSharingPopUp(this.href, '<?php echo $this->translate('Twitter')?>')" class="sesbasic_icon_btn sesbasic_icon_twitter_btn"><i class="fa fa-twitter"></i></a>
                <a href="<?php echo 'http://pinterest.com/pin/create/button/?url='.$urlencode; ?>&media=<?php echo urlencode((strpos($result->getPhotoUrl('thumb.main'),'http') === FALSE ? (((!empty($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"] == 'on')) ? "https://" : "http://") . $_SERVER['HTTP_HOST'] ) : $result->getPhotoUrl('thumb.main'))); ?>&description=<?php echo $result->getTitle();?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate('Pinterest'); ?>')" class="sesbasic_icon_btn sesbasic_icon_pintrest_btn"><i class="fa fa-pinterest"></i></a>
                <?php } ?>
                <!--Like Button-->
								<?php $canComment =  $result->authorization()->isAllowed($this->viewer, 'comment');?>
								<?php if($canComment):?>
									<?php $LikeStatus = Engine_Api::_()->sescrowdfunding()->getLikeStatusCrowdfunding($result->crowdfunding_id, $result->getType()); ?>
									<a href="javascript:;" data-url="<?php echo $result->crowdfunding_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sescrowdfunding_like_<?php echo 'sescrowdfunding'; ?> sescrowdfunding_like_<?php echo 'sescrowdfunding'; ?>_<?php echo $result->crowdfunding_id ?> <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $result->like_count; ?></span></a>
								<?php endif; ?>
              </p>
            </div> 
            <div class="sescf_list_item_cont sesbasic_clearfix">
              <div class="sescf_list_item_title">
                <a href="<?php echo $result->getHref(); ?>" title="<?php echo $this->translate($result->getTitle()); ?>"><?php echo $result->title; ?></a>
              </div>
              <div class="sescf_list_item_top_stats sesbasic_clearfix">
                <span class="sescf_list_item_owner">
                  <i class="fa fa-user-circle sesbasic_text_light"></i>
                  <span><?php echo $this->translate("Created by "); ?><a href="<?php echo $result->getOwner()->getHref(); ?>"><?php echo $result->getOwner()->getTitle(); ?></a></span>
                </span>
                <?php if($result->category_id): ?>
                  <?php $category = Engine_Api::_()->getItem('sescrowdfunding_category', $result->category_id); ?>
                  <span class="sescf_list_item_category">
                    <i class="fa fa-folder-open sesbasic_text_light"></i>
                    <span><a href="<?php echo $category->getHref(); ?>"><?php echo $category->getTitle(); ?></a></span> 
                  </span>
                <?php endif; ?>
              </div>
              <p class="sescf_list_item_des"><?php echo $this->string()->truncate($this->string()->stripTags($result->short_description), 400) ?></p>
              <?php 
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
              <div class="sescf_list_item_progress sesbasic_clearfix">
                <span class="sescf_list_item_progress_overall sesbasic_text_light"><?php echo round($totalPerAmountGain,2).'%'; echo $this->translate(" Completed"); ?></span>
                <?php
                  $daysLeft = 0;
                  $fromDate = date('Y-m-d',strtotime($result->publish_date));
                  $curDate = date('Y-m-d');
                  $daysLeft = abs(strtotime($curDate) - strtotime($fromDate));
                  $days = $daysLeft/(60 * 60 * 24);
                ?>
                <div class="sescf_list_goal sescf_profile_goal_stat">
                  <?php if(empty($result->show_start_time) && $result->publish_date != '' && strtotime($result->publish_date) > time()) { ?>
                    <span class="sescf_profile_goal_stat_value sesbasic_text_hl"><?php echo $days; ?> Days Left</span>
                  <?php } elseif(strtotime($result->publish_date) < time() && empty($result->show_start_time)) { ?>
                    <span class="sescf_profile_goal_stat_value sescf_expired"><?php echo $this->translate("Expired"); ?></span>
                  <?php } elseif($result->show_start_time) { ?>
                    <span class="sescf_profile_goal_stat_value sesbasic_text_hl"><?php echo $this->translate(""); ?></span>
                  <?php } ?>
                </div>
                <div class="sescf_list_item_fund_stats sescf_list_item_fund_stats_value sesbasic_clearfix">
                  <span><?php echo $totalGainAmountwithCu; ?></span>	
                  <span class="sescf_total_d centerT"><?php echo $getDoners; ?></span>
                  <span class="sescf_total_g rightT"><?php echo $totalAmount; ?></span>
                </div>
                <span class="sescf_list_item_progress_bar" style="background-color:<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfunding.outercolor', 'fbfbfb') ?>"><span style="width:<?php echo $totalPerAmountGain; ?>%;background-color:<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfunding.fillcolor', 'fbfbfb') ?>"></span></span>
                <div class="sescf_list_item_fund_stats sesbasic_clearfix">
                  <span class="sescf_total_g"><?php echo $this->translate("RAISED"); ?></span>
                  <span class="sescf_total_d centerT"><?php if($getDoners > 1) { echo $this->translate("Donors"); } else { echo $this->translate("Donor"); } ?></span>
                  <span class="sescf_total_g rightT"><?php echo $this->translate("GOAL"); ?></span>
                </div>
              </div>
              <div class="sescf_list_item_btn">
                <?php if($result->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'edit')){ ?>
									<a href="<?php echo $result->getHref(); ?>" class="sesbasic_link_btn cescf_view_icon cescf_ic_btn"><?php echo $this->translate("View"); ?></a>
                  <a href="<?php echo $this->url(array('crowdfunding_id' => $result->custom_url, 'action'=>'edit'), 'sescrowdfunding_dashboard', true); ?>" class="sesbasic_link_btn cescf_edit_icon cescf_ic_btn"><?php echo $this->translate("Dashboard"); ?></a>
                <?php } ?>
                <?php if($result->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'delete')){ ?>
                  <a href="<?php echo $this->url(array('crowdfunding_id' => $result->crowdfunding_id, 'action'=>'delete'), 'sescrowdfunding_specific', true); ?>" class="sesbasic_link_btn smoothbox cescf_delete_icon cescf_ic_btn"><?php echo $this->translate("Delete"); ?></a>
                <?php } ?>

              </div>
            </div>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
    <!--List View End Here-->
  <?php else: ?>
    <div class="sesbasic_tip">
      <img src="application/modules/Sescrowdfunding/externals/images/crowdfunding-icon.png" alt="" />
      <span>
        <?php echo $this->translate('You do not have any crowdfunding yet.');?>
      </span>
    </div>
  <?php endif; ?>
</div>
<?php echo $this->paginationControl($this->paginator, null, null, array('pageAsQuery' => true, 'query' => $this->formValues)); ?>

