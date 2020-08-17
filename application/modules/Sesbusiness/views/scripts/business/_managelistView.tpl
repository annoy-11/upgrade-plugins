<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _managelistView.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
  <?php if(strlen($business->getTitle()) > $this->params['list_title_truncation']):?>
    <?php $title = mb_substr($business->getTitle(),0,$this->params['list_title_truncation']).'...';?>
  <?php else: ?>
    <?php $title = $business->getTitle();?>
  <?php endif; ?>
  <?php $owner = $business->getOwner();?>
<li class="sesbusiness_manage_businesses_item">
  <article class="sesbasic_clearfix">
    <div class="_thumb sesbusiness_thumb">
      <a href="<?php echo $business->getHref();?>" class="sesbusiness_thumb_img">
      	<span style="background-image:url(<?php echo $business->getPhotoUrl('thumb.profile'); ?>);"></span>
      </a>
      <div class="sesbusiness_list_labels sesbasic_animation">
        <?php  include APPLICATION_PATH .  '/application/modules/Sesbusiness/views/scripts/_dataLabel.tpl';?>
      </div>
  	</div>
    <div class="_cont">
      <div class="_topcont sesbasic_clearfix">		
        <div class="_buttons">      
          <?php if(isset($this->likeButtonActive) || isset($this->favouriteButtonActive) || isset($this->followButtonActive)):?>
            <div><?php include APPLICATION_PATH .  '/application/modules/Sesbusiness/views/scripts/_dataButtons.tpl';?></div>
          <?php endif;?>
          <?php include APPLICATION_PATH .  '/application/modules/Sesbusiness/views/scripts/_dataSharing.tpl';?>
          <?php if(Engine_Api::_()->sesbusiness()->businessPrivacy($business, 'edit')):?>
            <div>
              <a href="<?php echo $this->url(array('action' => 'edit', 'business_id' => $business->custom_url), 'sesbusiness_dashboard', 'true');?>" class="sesbusiness_button"><i class="fa fa-pencil"></i><span><?php echo $this->translate("Edit Business")?></span></a>
              <?php if($business->authorization()->isAllowed($this->viewer(), 'delete')){ ?>
                <a href="<?php echo $this->url(array('business_id' => $business->business_id,'action'=>'delete'), 'sesbusiness_general', true); ?>" class="smoothbox sesbusiness_button"><i class="fa fa-trash"></i><span><?php echo $this->translate("Delete Business")?></span></a>
              <?php } ?>
            </div>
          <?php endif;?>
          <?php if(SESBUSINESSPACKAGE == 1):?>
            <?php $package = Engine_Api::_()->getItem('sesbusinesspackage_package',$business->package_id);?>
            <?php if(!$package->isFree()): ?>
              <?php $transaction = Engine_Api::_()->getDbTable('transactions', 'sesbusinesspackage')->getItemTransaction(array('order_package_id' => $business->orderspackage_id, 'business' => $business));?>
              <?php if($transaction): ?>
                <?php if($package->isOneTime()):?>
                  <?php if($package->is_renew_link):?>
                    <?php if(!empty($transaction->expiration_date) && $transaction->expiration_date != '3000-00-00 00:00:00'):?>
                      <?php $datediff = strtotime($transaction->expiration_date) - time();?>
                      <?php $daysLeft =  floor($datediff/(60*60*24));?>
                      <?php if($daysLeft <= $renew_link_days || strtotime($transaction->expiration_date) <= time()): ?>
                        <div><a href="<?php echo $this->url(array('business_id' => $item->business_id,'action'=>'index'), 'sesbusinesspackage_payment', true); ?>" class="sesbusiness_button sesbasic_animation"><i class="fa fa-money"></i><span><?php echo $this->translate("Reniew Business Payment"); ?></span></a></div>
                      <?php endif;?>
                    <?php else: ?>
                      <div class="sesbasic_clearfix _paymnt_status"><span>Payment Status:</span> <span><?php echo ucwords($transaction->state); ?></span></div>
                    <?php endif;?>
                  <?php endif;?>
                <?php endif;?>
              <?php else:?>
              	<div>
                	<a href="<?php echo $this->url(array('business_id' => $business->business_id,'action'=>'index'), 'sesbusinesspackage_payment', true); ?>" class="sesbusiness_button"><i class="fa fa-money"></i><span><?php echo $this->translate("Make Payment")?></span></a>
              	</div>
              <?php endif;?>
            <?php endif;?>
          <?php endif;?>
        </div>
        <div class="_title">
          <?php if(isset($this->titleActive)):?>
              <a href="<?php echo $business->getHref();?>"><?php echo $title;?></a> <?php if(isset($this->verifiedLabelActive)&& $business->verified):?><i class="sesbusiness_label_verified sesbasic_verified_icon" title='<?php echo $this->translate("Verified");?>'></i><?php endif;?>
          <?php endif;?>
        </div>
        <?php if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesbusinessreview') && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinessreview.pluginactivated')):?>
          <?php echo $this->partial('_businessRating.tpl', 'sesbusinessreview', array('showRating' =>(isset($this->ratingActive) ? 1 : 0), 'rating' => $business->rating, 'review' => $business->review_count,'business_id' => $business->business_id));?>
        <?php endif;?>
      </div>
      <div class="_footer">
      	<div class="_stats sesbasic_clearfix">
          <?php if(isset($this->likeActive)):?>
            <div><span class="_count"><?php echo $business->like_count;?></span><span class="_label"><?php if($business->like_count == 0 || $business->like_count > 1):?><?php echo $this->translate('Likes');?><?php else:?><?php echo $this->translate('Like');?><?php endif;?></span></div>
          <?php endif;?>
          <?php if(isset($this->commentActive)):?>
            <div><span class="_count"><?php echo $business->comment_count;?></span><span class="_label"><?php if($business->comment_count == 0 || $business->comment_count > 1):?><?php echo $this->translate('Comments');?><?php else:?><?php echo $this->translate('Comment');?><?php endif;?></span></div>
          <?php endif;?>
          <?php if(isset($this->viewActive)):?>
            <div><span class="_count"><?php echo $business->view_count;?></span><span class="_label"><?php if($business->view_count == 0 || $business->view_count > 1):?><?php echo $this->translate('Views');?><?php else:?><?php echo $this->translate('View');?><?php endif;?></span></div>
          <?php endif;?>
          <?php if(isset($this->favouriteActive)):?>
            <div><span class="_count"><?php echo $business->favourite_count;?></span><span class="_label"><?php if($business->favourite_count == 0 || $business->favourite_count > 1):?><?php echo $this->translate('Favourites');?><?php else:?><?php echo $this->translate('Favourite');?><?php endif;?></span></div>
          <?php endif;?>
          <?php if(isset($this->followActive)):?>
            <div><span class="_count"><?php echo $business->follow_count;?></span><span class="_label"><?php if($business->follow_count == 0 || $business->follow_count > 1):?><?php echo $this->translate('Followers');?><?php else:?><?php echo $this->translate('Follower');?><?php endif;?></span></div>
          <?php endif;?>
          <?php if(isset($this->memberActive)):?>
            <div><span class="_count"><?php echo $business->member_count;?></span><span class="_label"><?php if($business->member_count == 0 || $business->member_count > 1):?><?php echo $this->translate('Members');?><?php else:?><?php echo $this->translate('Member');?><?php endif;?></span></div>
          <?php endif;?>
        </div>
      </div>  
    </div>
  </article>
</li>
