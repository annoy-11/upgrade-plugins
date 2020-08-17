<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _managelistView.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
  <?php if(strlen($store->getTitle()) > $this->params['list_title_truncation']):?>
    <?php $title = mb_substr($store->getTitle(),0,$this->params['list_title_truncation']).'...';?>
  <?php else: ?>
    <?php $title = $store->getTitle();?>
  <?php endif; ?>
  <?php $owner = $store->getOwner();?>
<li class="estore_manage_stores_item">
  <article class="sesbasic_clearfix">
    <div class="_thumb estore_thumb">
      <a href="<?php echo $store->getHref();?>" class="estore_thumb_img">
      	<span style="background-image:url(<?php echo $store->getPhotoUrl('thumb.profile'); ?>);"></span>
      </a>
      <div class="estore_list_labels sesbasic_animation">
        <?php  include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_dataLabel.tpl';?>
      </div>
  	</div>
    <div class="_cont">
      <div class="_topcont sesbasic_clearfix">		
        <div class="_buttons">      
          <?php if(isset($this->likeButtonActive) || isset($this->favouriteButtonActive) || isset($this->followButtonActive)):?>
            <div><?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_dataButtons.tpl';?></div>
          <?php endif;?>
          <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_dataSharing.tpl';?>
          <?php if(Engine_Api::_()->estore()->storePrivacy($store, 'edit')):?>
            <div class="_deactivate_button">
              <a href="<?php echo $this->url(array('action' => 'edit', 'store_id' => $store->custom_url), 'estore_dashboard', 'true');?>" class="estore_button sesbasic_animation"><i class="fa fa-edit"></i></a>
              <?php if($store->authorization()->isAllowed($this->viewer(), 'delete')){ ?>
                <a href="<?php echo $this->url(array('store_id' => $store->store_id,'action'=>'delete'), 'estore_general', true); ?>" class="smoothbox estore_button sesbasic_animation"><i class="fa fa-trash"></i></a>
              <?php } ?>
            </div>
          <?php endif;?>
          <?php if(ESTOREPACKAGE == 1):?>
            <?php $package = Engine_Api::_()->getItem('estorepackage_package',$store->package_id);?>
            <?php if(!$package->isFree()): ?>
              <?php $transaction = Engine_Api::_()->getDbTable('transactions', 'estorepackage')->getItemTransaction(array('order_package_id' => $store->orderspackage_id, 'store' => $store));?>
              <?php if($transaction): ?>
                <?php if($package->isOneTime()):?>
                  <?php if($package->is_renew_link):?>
                    <?php if(!empty($transaction->expiration_date) && $transaction->expiration_date != '3000-00-00 00:00:00'):?>
                      <?php $datediff = strtotime($transaction->expiration_date) - time();?>
                      <?php $daysLeft =  floor($datediff/(60*60*24));?>
                      <?php if($daysLeft <= $renew_link_days || strtotime($transaction->expiration_date) <= time()): ?>
                        <div><a href="<?php echo $this->url(array('store_id' => $item->store_id,'action'=>'index'), 'estorepackage_payment', true); ?>" class="estore_button sesbasic_animation"><i class="fa fa-money-bill"></i><span><?php echo $this->translate("Review Store Payment"); ?></span></a></div>
                      <?php endif;?>
                    <?php else: ?>
                      <div class="sesbasic_clearfix _paymnt_status"><span>Payment Status:</span> <span><?php echo ucwords($transaction->state); ?></span></div>
                    <?php endif;?>
                  <?php endif;?>
                <?php endif;?>
              <?php else:?>
              	<div>
                	<a href="<?php echo $this->url(array('store_id' => $store->store_id,'action'=>'index'), 'estorepackage_payment', true); ?>" class="estore_button"><i class="fa fa-money-bill"></i><span><?php echo $this->translate("Make Payment")?></span></a>
              	</div>
              <?php endif;?>
            <?php endif;?>
          <?php endif;?>
        </div>
        <div class="_title">
          <?php if(isset($this->titleActive)):?>
              <a href="<?php echo $store->getHref();?>"><?php echo $title;?></a> <?php if(isset($this->verifiedLabelActive)&& $store->verified):?><i class="estore_label_verified sesbasic_verified_icon" title='<?php echo $this->translate("Verified");?>'></i><?php endif;?>
          <?php endif;?>
        </div>
      </div>
      <div class="_footer">
      	<div class="_stats sesbasic_clearfix">
          <?php if(isset($this->likeActive)):?>
            <div><span class="_count"><?php echo $store->like_count;?></span><span class="_label"><?php if($store->like_count == 0 || $store->like_count > 1):?><?php echo $this->translate('Likes');?><?php else:?><?php echo $this->translate('Like');?><?php endif;?></span></div>
          <?php endif;?>
          <?php if(isset($this->commentActive)):?>
            <div><span class="_count"><?php echo $store->comment_count;?></span><span class="_label"><?php if($store->comment_count == 0 || $store->comment_count > 1):?><?php echo $this->translate('Comments');?><?php else:?><?php echo $this->translate('Comment');?><?php endif;?></span></div>
          <?php endif;?>
          <?php if(isset($this->viewActive)):?>
            <div><span class="_count"><?php echo $store->view_count;?></span><span class="_label"><?php if($store->view_count == 0 || $store->view_count > 1):?><?php echo $this->translate('Views');?><?php else:?><?php echo $this->translate('View');?><?php endif;?></span></div>
          <?php endif;?>
          <?php if(isset($this->favouriteActive)):?>
            <div><span class="_count"><?php echo $store->favourite_count;?></span><span class="_label"><?php if($store->favourite_count == 0 || $store->favourite_count > 1):?><?php echo $this->translate('Favourites');?><?php else:?><?php echo $this->translate('Favourite');?><?php endif;?></span></div>
          <?php endif;?>
          <?php if(isset($this->followActive)):?>
            <div><span class="_count"><?php echo $store->follow_count;?></span><span class="_label"><?php if($store->follow_count == 0 || $store->follow_count > 1):?><?php echo $this->translate('Followers');?><?php else:?><?php echo $this->translate('Follower');?><?php endif;?></span></div>
          <?php endif;?>
          <?php if(isset($this->memberActive)):?>
            <div><span class="_count"><?php echo $store->member_count;?></span><span class="_label"><?php if($store->member_count == 0 || $store->member_count > 1):?><?php echo $this->translate('Members');?><?php else:?><?php echo $this->translate('Member');?><?php endif;?></span></div>
          <?php endif;?>
        </div>
      </div>  
    </div>
  </article>
</li>
