<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _managelistView.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
  <?php if(strlen($group->getTitle()) > $this->params['list_title_truncation']):?>
    <?php $title = mb_substr($group->getTitle(),0,$this->params['list_title_truncation']).'...';?>
  <?php else: ?>
    <?php $title = $group->getTitle();?>
  <?php endif; ?>
  <?php $owner = $group->getOwner();?>
<li class="sesgroup_manage_groups_item">
  <article class="sesbasic_clearfix">
    <div class="_thumb sesgroup_thumb">
      <a href="<?php echo $group->getHref();?>" class="sesgroup_thumb_img">
      	<span style="background-image:url(<?php echo $group->getPhotoUrl('thumb.profile'); ?>);"></span>
      </a>
      <div class="sesgroup_list_labels sesbasic_animation">
        <?php  include APPLICATION_PATH .  '/application/modules/Sesgroup/views/scripts/_dataLabel.tpl';?>
      </div>
  	</div>
    <div class="_cont">
      <div class="_topcont sesbasic_clearfix">		
        <div class="_buttons">      
          <?php if(isset($this->likeButtonActive) || isset($this->favouriteButtonActive) || isset($this->followButtonActive)):?>
            <div><?php include APPLICATION_PATH .  '/application/modules/Sesgroup/views/scripts/_dataButtons.tpl';?></div>
          <?php endif;?>
          <?php include APPLICATION_PATH .  '/application/modules/Sesgroup/views/scripts/_dataSharing.tpl';?>
          <?php if(Engine_Api::_()->sesgroup()->groupPrivacy($group, 'edit')):?>
            <div>
              <a href="<?php echo $this->url(array('action' => 'edit', 'group_id' => $group->custom_url), 'sesgroup_dashboard', 'true');?>" class="sesgroup_button"><i class="fa fa-pencil"></i><span><?php echo $this->translate("Edit Group")?></span></a>
              <?php if($group->authorization()->isAllowed($this->viewer(), 'delete')){ ?>
                <a href="<?php echo $this->url(array('group_id' => $group->group_id,'action'=>'delete'), 'sesgroup_general', true); ?>" class="smoothbox sesgroup_button"><i class="fa fa-trash"></i><span><?php echo $this->translate("Delete Group")?></span></a>
              <?php } ?>
            </div>
          <?php endif;?>
          <?php if(SESGROUPPACKAGE == 1):?>
            <?php $package = Engine_Api::_()->getItem('sesgrouppackage_package',$group->package_id);?>
            <?php if(!$package->isFree()): ?>
              <?php $transaction = Engine_Api::_()->getDbTable('transactions', 'sesgrouppackage')->getItemTransaction(array('order_package_id' => $group->orderspackage_id, 'group' => $group));?>
              <?php if($transaction): ?>
                <?php if($package->isOneTime()):?>
                  <?php if($package->is_renew_link):?>
                    <?php if(!empty($transaction->expiration_date) && $transaction->expiration_date != '3000-00-00 00:00:00'):?>
                      <?php $datediff = strtotime($transaction->expiration_date) - time();?>
                      <?php $daysLeft =  floor($datediff/(60*60*24));?>
                      <?php if($daysLeft <= $renew_link_days || strtotime($transaction->expiration_date) <= time()): ?>
                        <div><a href="<?php echo $this->url(array('group_id' => $item->group_id,'action'=>'index'), 'sesgrouppackage_payment', true); ?>" class="sesgroup_button sesbasic_animation"><i class="fa fa-money"></i><span><?php echo $this->translate("Reniew Group Payment"); ?></span></a></div>
                      <?php endif;?>
                    <?php else: ?>
                      <div class="sesbasic_clearfix _paymnt_status"><span>Payment Status:</span> <span><?php echo ucwords($transaction->state); ?></span></div>
                    <?php endif;?>
                  <?php endif;?>
                <?php endif;?>
              <?php else:?>
              	<div>
                	<a href="<?php echo $this->url(array('group_id' => $group->group_id,'action'=>'index'), 'sesgrouppackage_payment', true); ?>" class="sesgroup_button"><i class="fa fa-money"></i><span><?php echo $this->translate("Make Payment")?></span></a>
              	</div>
              <?php endif;?>
            <?php endif;?>
          <?php endif;?>
        </div>
        <div class="_title">
          <?php if(isset($this->titleActive)):?>
              <a href="<?php echo $group->getHref();?>"><?php echo $title;?></a> <?php if(isset($this->verifiedLabelActive)&& $group->verified):?><i class="sesgroup_label_verified sesbasic_verified_icon" title='<?php echo $this->translate("Verified");?>'></i><?php endif;?>
          <?php endif;?>
        </div>
      </div>
      <div class="_footer">
      	<div class="_stats sesbasic_clearfix">
          <?php if(isset($this->likeActive)):?>
            <div><span class="_count"><?php echo $group->like_count;?></span><span class="_label"><?php if($group->like_count == 0 || $group->like_count > 1):?><?php echo $this->translate('Likes');?><?php else:?><?php echo $this->translate('Like');?><?php endif;?></span></div>
          <?php endif;?>
          <?php if(isset($this->commentActive)):?>
            <div><span class="_count"><?php echo $group->comment_count;?></span><span class="_label"><?php if($group->comment_count == 0 || $group->comment_count > 1):?><?php echo $this->translate('Comments');?><?php else:?><?php echo $this->translate('Comment');?><?php endif;?></span></div>
          <?php endif;?>
          <?php if(isset($this->viewActive)):?>
            <div><span class="_count"><?php echo $group->view_count;?></span><span class="_label"><?php if($group->view_count == 0 || $group->view_count > 1):?><?php echo $this->translate('Views');?><?php else:?><?php echo $this->translate('View');?><?php endif;?></span></div>
          <?php endif;?>
          <?php if(isset($this->favouriteActive)):?>
            <div><span class="_count"><?php echo $group->favourite_count;?></span><span class="_label"><?php if($group->favourite_count == 0 || $group->favourite_count > 1):?><?php echo $this->translate('Favourites');?><?php else:?><?php echo $this->translate('Favourite');?><?php endif;?></span></div>
          <?php endif;?>
          <?php if(isset($this->followActive)):?>
            <div><span class="_count"><?php echo $group->follow_count;?></span><span class="_label"><?php if($group->follow_count == 0 || $group->follow_count > 1):?><?php echo $this->translate('Followers');?><?php else:?><?php echo $this->translate('Follower');?><?php endif;?></span></div>
          <?php endif;?>
          <?php if(isset($this->memberActive)):?>
            <div><span class="_count"><?php echo $group->member_count;?></span><span class="_label"><?php if($group->member_count == 0 || $group->member_count > 1):?><?php echo $this->translate('Members');?><?php else:?><?php echo $this->translate('Member');?><?php endif;?></span></div>
          <?php endif;?>
        </div>
      </div>  
    </div>
  </article>
</li>