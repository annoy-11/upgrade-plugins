<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Booking
 * @package    Booking
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-03-19 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Booking/externals/styles/styles.css'); ?>
<?php  if(count($this->servicePaginator)){ ?>
<?php $userSelected = Engine_Api::_()->getItem('user',$item->user_id);?>
<?php if($this->providericon) { ?>
<?php if($userSelected->photo_id):?>
	<a href="<?php echo $userSelected->getHref();?>"><img src="<?php echo Engine_Api::_()->storage()->get($userSelected->photo_id)->getPhotoUrl(); ?>" alt=""></a>
<?php else:?>
	<a href="<?php echo $userSelected->getHref();?>"><img src="application/modules/Booking/externals/images/nophoto_service_thumb_profile.png" alt=""></a>
<?php endif;?>
<?php }?>
<?php if($this->providername) echo $userSelected->displayname; ?>
  <div class="sesapmt_view_service sesbasic_bxs sesbasic_clearfix">
    <div class="sesapmt_view_service_top sesbasic_clearfix">
      <div class="sesapmt_view_service_img"> <img src="<?php echo Engine_Api::_()->storage()->get($this->servicePaginator->file_id)->getPhotoUrl(); ?>" alt=""> </div>
      <div class="sesapmt_view_service_info"> <span class="_name"><?php echo $this->servicePaginator->name ?></span> <span class="_price sesbasic_text_light"><span class="sesbasic_text_hl"><?php echo Engine_Api::_()->booking()->getCurrencyPrice($this->servicePaginator->price); ?></span> /
        <?php  echo $this->servicePaginator->duration." ".(($this->servicePaginator->timelimit=="h")?"Hour.":"Minutes."); ?>
        </span> </div>
    </div>
    <?php $viewer = Engine_Api::_()->user()->getViewer(); ?>
    <?php $viewerId = $viewer->getIdentity(); ?>
    <?php $levelId = ($viewerId) ? $viewer->level_id : Engine_Api::_()->getDbtable('levels', 'authorization')->getPublicLevel()->level_id; ?>
    <?php if($levelId!=5) {
      if($this->servicePaginator->user_id!=Engine_Api::_()->user()->getViewer()->getIdentity()){ ?>
        <?php $viewer = Engine_Api::_()->user()->getViewer(); if (Engine_Api::_()->authorization()->getPermission($viewer, 'booking', 'bookservice')) { ?><a href="<?php echo $this->url(array("action"=>'bookservices','professional'=>$this->servicePaginator->user_id),'booking_general',true); ?>" class="sesapmt_btn sesbasic_animation" style="width:100px"><span>Book</span></a><?php } ?>
      <?php } else { ?>
      <?php $viewer = Engine_Api::_()->user()->getViewer(); 
        if (Engine_Api::_()->authorization()->getPermission($viewer, 'booking', 'bookservice')) { ?>
        <a href="<?php echo $this->url(array("action"=>'bookservices','professional'=>$this->servicePaginator->user_id),'booking_general',true); ?>" class="sesapmt_btn sesbasic_animation" style="width:150px"><span>Book for other</span></a>
      <?php } ?>
      <?php } ?>
    <?php } ?>
    <div class="sesapmt_view_service_des"> <?php echo $this->servicePaginator->description ?> </div>
  </div>
<?php } else { ?>
	<div class="tip"><span>No services available</span></div>
<?php }  ?>
<div class="sesapmt_service_reviews_container sesbasic_bxs">
  <div class="sesapmt_service_reviews_title"><?php echo $this->translate("Reviews");?></div>
    <div class="sesbasic_profile_tabs_top sesbasic_clearfix">
      <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('booking.allow.review', 1) && $this->allowedCreate && $this->viewer->getIdentity()){ if(!$this->isReviewAvailable) { ?>
      <a href="<?php echo $this->url(array("action"=>'service-review','service_id'=>$this->serviceId),'booking_general',true); ?>" class="sesapmt_btn sesbasic_animation smoothbox"><i class="fa fa-plus"></i><span>Write a Review</span></a>
      <?php } } ?>
    </div>
  <ul class="sesapmt_review_listing sesbasic_clearfix">
    <?php  if(count($this->reviewsPaginator)){ ?>
    <?php foreach ($this->reviewsPaginator as $item): ?>
    <li class="sesapmt_review_listing_item sesbasic_clearfix">
      <div class="sesapmt_review_listing_item_cont">
      	<div class="sesapmt_review_listing_item_title"><?php echo $item->title; ?></div>
        <div class="sesapmt_review_listing_item_rating sesbasic_rating_star">
          <?php for($i=1;$i<=$item->rating;$i++){  ?>
          <span id="" class="fa fa-star"></span>
          <?php } for($i=$item->rating;$i<5;$i++){ ?>
          <span id="" class="fa fa fa-star-o star-disable"></span>
          <?php }  ?>
        </div>
        <div class="sesapmt_review_listing_item_body"><b>Pros: </b><?php echo $item->pros; ?></div>
        <div class="sesapmt_review_listing_item_body"><b>Cons: </b><?php echo $item->cons; ?></div>
        <div class="sesapmt_review_listing_item_body"><?php echo $item->description; ?></div>
        <div class="sesapmt_review_listing_item_body"><b>Recommended: </b>
          <?php if($item->recommended) { ?>
          <i class="fa fa-check"></i>
          <?php } else { ?>
          <i class="fa fa-times"></i>
          <?php } ?>
        </div>
      </div>
      <div class="sesapmt_review_listing_item_footer">
        <div class="sesapmt_review_listing_reviewer_photo">
          <?php $userSelected = Engine_Api::_()->getItem('user',$item->user_id); ?>  
          <?php echo $this->htmlLink($userSelected->getHref(), $this->itemPhoto($userSelected, 'thumb.icon', $userSelected->getTitle())) ?>
        </div>
        <div class="sesapmt_review_listing_item_info">
          <div class="sesapmt_review_listing_reviewer_name"><a href="<?php echo $userSelected->getHref();?>"><?php echo $userSelected->displayname; ?></a></div>
        </div>
        <?php if($this->viewerId==$item->user_id) { ?>
        	<div class="sesapmt_review_listing_options clear sesbasic_animation">
          	<div><a href="<?php echo $this->url(array("action"=>'service-review','review_id'=>$item->review_id,'service_id'=>$item->service_id),'booking_general',true); ?>" class="sesbasic_button fa fa-pencil smoothbox"></a></div>
          	<div><a href="<?php echo $this->url(array("action"=>'delete','review_id'=>$item->review_id),'booking_general',true); ?>" class="sesbasic_button fa fa-trash smoothbox"></a></div>
        	</div>
        <?php } else { ?>
        <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('booking.show.report', 1) && $this->viewer->getIdentity()): ?>
            <a class="fa fa-flag sesbasic_button sesbasic_button_icon" href="<?php echo $this->url(array('route' => 'default', 'module' => 'core', 'controller' => 'report', 'action' => 'create', 'subject' => $item->getGuid(), 'format' => 'smoothbox',),'default',true); ?>" onclick='return opensmoothboxurl(this.href);'><span><i class="fa fa-caret-down"></i><?php echo $this->translate('Report');?></span></a>
            <?php endif; ?>
            <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('booking.allow.share', 1)): ?>
            <a class="fa fa-share sesbasic_button sesbasic_button_icon" href="<?php echo $this->url(array('route' => 'default', 'module' => 'activity', 'controller' => 'index', 'action' => 'share', 'type' => $item->getType(), 'id' => $item->getIdentity(), 'format' => 'smoothbox'),'default',true); ?>" onclick='return opensmoothboxurl(this.href);'><span><i class="fa fa-caret-down"></i><?php echo $this->translate('Share Review');?></span></a> 
            <?php endif; ?>
            <?php } ?>
      </div>
    </li>
    <?php endforeach;  ?>
    <?php } else { ?>
    <div class="tip"><span>No reviews are available yet!</span></div>
    <?php }  ?>
  </ul>
</div>
