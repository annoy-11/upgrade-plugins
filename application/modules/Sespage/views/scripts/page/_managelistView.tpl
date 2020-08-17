<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _managelistView.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
  <?php if(strlen($page->getTitle()) > $this->params['list_title_truncation']):?>
    <?php $title = mb_substr($page->getTitle(),0,$this->params['list_title_truncation']).'...';?>
  <?php else: ?>
    <?php $title = $page->getTitle();?>
  <?php endif; ?>
  <?php $owner = $page->getOwner();?>
<li class="sespage_manage_pages_item">
  <article class="sesbasic_clearfix">
    <div class="_thumb sespage_thumb">
      <a href="<?php echo $page->getHref();?>" class="sespage_thumb_img">
      	<span style="background-image:url(<?php echo $page->getPhotoUrl('thumb.profile'); ?>);"></span>
      </a>
      <div class="sespage_list_labels sesbasic_animation">
        <?php  include APPLICATION_PATH .  '/application/modules/Sespage/views/scripts/_dataLabel.tpl';?>
      </div>
  	</div>
    <div class="_cont">
      <div class="_topcont sesbasic_clearfix">		
        <div class="_buttons">      
          <?php if(isset($this->likeButtonActive) || isset($this->favouriteButtonActive) || isset($this->followButtonActive)):?>
            <div><?php include APPLICATION_PATH .  '/application/modules/Sespage/views/scripts/_dataButtons.tpl';?></div>
          <?php endif;?>
          <?php include APPLICATION_PATH .  '/application/modules/Sespage/views/scripts/_dataSharing.tpl';?>
          <?php if(Engine_Api::_()->sespage()->pagePrivacy($page, 'edit')):?>
            <div>
              <a href="<?php echo $this->url(array('action' => 'edit', 'page_id' => $page->custom_url), 'sespage_dashboard', 'true');?>" class="sespage_button"><i class="fa fa-pencil"></i><span><?php echo $this->translate("Edit Page")?></span></a>
              <?php if($page->authorization()->isAllowed($this->viewer(), 'delete')){ ?>
                <a href="<?php echo $this->url(array('page_id' => $page->page_id,'action'=>'delete'), 'sespage_general', true); ?>" class="smoothbox sespage_button"><i class="fa fa-trash"></i><span><?php echo $this->translate("Delete Page")?></span></a>
              <?php } ?>
            </div>
          <?php endif;?>
          <?php if(SESPAGEPACKAGE == 1):?>
            <?php $package = Engine_Api::_()->getItem('sespagepackage_package',$page->package_id);?>
            <?php if(!$package->isFree()): ?>
              <?php $transaction = Engine_Api::_()->getDbTable('transactions', 'sespagepackage')->getItemTransaction(array('order_package_id' => $page->orderspackage_id, 'page' => $page));?>
              <?php if($transaction): ?>
                <?php if($package->isOneTime()):?>
                  <?php if($package->is_renew_link):?>
                    <?php if(!empty($transaction->expiration_date) && $transaction->expiration_date != '3000-00-00 00:00:00'):?>
                      <?php $datediff = strtotime($transaction->expiration_date) - time();?>
                      <?php $daysLeft =  floor($datediff/(60*60*24));?>
                      <?php if($daysLeft <= $renew_link_days || strtotime($transaction->expiration_date) <= time()): ?>
                        <div><a href="<?php echo $this->url(array('page_id' => $item->page_id,'action'=>'index'), 'sespagepackage_payment', true); ?>" class="sespage_button sesbasic_animation"><i class="fa fa-money"></i><span><?php echo $this->translate("Reniew Page Payment"); ?></span></a></div>
                      <?php endif;?>
                    <?php else: ?>
                      <div class="sesbasic_clearfix _paymnt_status"><span>Payment Status:</span> <span><?php echo ucwords($transaction->state); ?></span></div>
                    <?php endif;?>
                  <?php endif;?>
                <?php endif;?>
              <?php else:?>
              	<div>
                	<a href="<?php echo $this->url(array('page_id' => $page->page_id,'action'=>'index'), 'sespagepackage_payment', true); ?>" class="sespage_button"><i class="fa fa-money"></i><span><?php echo $this->translate("Make Payment")?></span></a>
              	</div>
              <?php endif;?>
            <?php endif;?>
          <?php endif;?>
        </div>
        <div class="_title">
          <?php if(isset($this->titleActive)):?>
              <a href="<?php echo $page->getHref();?>"><?php echo $title;?></a> <?php if(isset($this->verifiedLabelActive)&& $page->verified):?><i class="sespage_label_verified sesbasic_verified_icon" title='<?php echo $this->translate("Verified");?>'></i><?php endif;?>
          <?php endif;?>
        </div>
        <?php if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sespagereview') && Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagereview.pluginactivated')):?>
          <?php echo $this->partial('_pageRating.tpl', 'sespagereview', array('showRating' =>(isset($this->ratingActive) ? 1 : 0), 'rating' => $page->rating, 'review' => $page->review_count,'page_id' => $page->page_id));?>
        <?php endif;?>
      </div>
      <div class="_footer">
        <?php if(isset($this->likeActive) || isset($this->commentActive) || isset($this->viewActive) || isset($this->favouriteActive) || (isset($this->followActive) && isset($page->follow_count)) || (isset($this->memberActive) && isset($page->member_count))):?>
        <div class="_stats sesbasic_text_light sesbasic_clearfix">
          <i class="fa fa-bar-chart"></i>
          <span><?php include APPLICATION_PATH .  '/application/modules/Sespage/views/scripts/_dataStatics.tpl';?></span>
        </div>
       <?php endif;?>
      </div>  
    </div>
  </article>
</li>
