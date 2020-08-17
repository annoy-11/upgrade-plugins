<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespageoffer
 * @package    Sespageoffer
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _gridView.tpl  2019-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sespageoffer/externals/styles/style.css'); ?> 
<?php $title = '';?>
<?php if(isset($this->titleActive)):?>
  <?php if(isset($this->params['grid_title_truncation'])):?>
    <?php $titleLimit = $this->params['grid_title_truncation'];?>
  <?php else:?>
    <?php $titleLimit = $this->params['title_truncation'];?>
  <?php endif;?>
  <?php if(strlen($item->title) > $titleLimit):?>
    <?php $title = mb_substr($item->title,0,$titleLimit).'...';?>
  <?php else:?>
    <?php $title = $item->title;?>
  <?php endif; ?>
<?php endif;?>
<?php $descriptionLimit = 0;?>
<?php if(isset($this->griddescriptionActive)):?>
  <?php $descriptionLimit = @$this->params['grid_description_truncation'];?>
<?php elseif(isset($this->descriptionActive)):?>
  <?php $descriptionLimit = @$this->params['description_truncation'];?>
<?php endif;?>
<li class="sesbasic_bg sespageoffer_grid_item" style="width:<?php echo $width ?>px;">
  <article class="sesbasic_bg">
    <div class="sespageoffer_profile_top">
      <div class="sespageoffer_profile_inner">
        <a href="<?php echo $item->getHref();?>" class="sespageoffer_profile_img" style="height:<?php echo $height ?>px;"><span style="background-image:url(<?php echo $item->getPhotoUrl() ?>);"></span></a>
        <!-- Share Buttons -->
        <?php include APPLICATION_PATH .  '/application/modules/Sespageoffer/views/scripts/_dataSharing.tpl';?>
        <!-- Labels -->
        <?php include APPLICATION_PATH .  '/application/modules/Sespageoffer/views/scripts/_dataLabel.tpl';?>
        <?php if($this->offertypevalueActive && $item->offertypevalue && ($item->offertype == 1 || $item->offertype == 2)) { ?>
            <?php if($item->offertype == 1 && $item->offertypevalue) { ?>
            <span class="sespageoffer_type">
              <?php echo $item->offertypevalue . '%'; ?> 
            </span>
            <?php } elseif($item->offertype == 2 && $item->offertypevalue) { ?>
            <span class="sespageoffer_type">
              <?php echo $this->translate("Fixed %s", $item->offertypevalue); ?>
            </span>
            <?php } ?>
        <?php } ?>
      </div>
      <div class="sespageoffer_profile_body">
        <span class="_name"><a href="<?php echo $item->getHref(); ?>"><?php echo $title; ?></a></span>
        <span class="_owner sesbasic_text_light">
          <?php if(isset($this->byActive)) { ?>
            <span>
              <?php echo $this->translate('<i class="fa fa-user"></i>');
                $itemOwner  = Engine_Api::_()->getItem('user',$item->owner_id); ?>
              <?php echo $this->htmlLink($itemOwner->getHref(), $itemOwner->getTitle(), array('class' => 'thumbs_author')) ?>
            </span>
          <?php }?>
          <?php if($this->posteddateActive) { ?>
            <span>
              <i class="fa fa-clock-o"></i> <?php echo $this->timestamp($item->creation_date) ?>
            </span>
          <?php } ?>
          <?php if($this->pagenameActive) { ?>
            <?php $page = Engine_Api::_()->getItem('sespage_page', $item->parent_id); ?>
            <span class="sespageoffer_pagename"> 
                <i class="fa fa-file-text"></i> <a href="<?php echo $page->getHref(); ?>"><?php echo $page->getTitle(); ?></a>
            </span>
          <?php } ?>
        </span>
        <?php if($this->claimedcountActive || $this->remainingcountActive || $this->getofferlinkActive) { ?>
          <div class="sespageoffer_claim">
            <?php if($this->claimedcountActive) { ?>
              <span class="sesbasic_text_light"><?php echo $this->translate("Claimed: "); ?><span class="_num"><?php echo $item->claimed_count; ?></span></span>
            <?php } ?>
            <?php if($this->remainingcountActive) { ?>
              <span class="sesbasic_text_light"><?php echo $this->translate("Remaining: "); ?><span class="_num"><?php echo $item->totalquantity - $item->claimed_count; ?> </span></span>
            <?php } ?>
            <?php if($this->getofferlinkActive && $item->claimed_count < $item->totalquantity) { ?>
              <span class="sespageoffer_get_offer"><a class="smoothbox" href="<?php echo $this->url(array('controller' => 'index', 'action' => 'getoffer','parent_id' => $item->parent_id, 'pageoffer_id' => $item->getIdentity()), 'sespageoffer_general', true); ?>"><?php echo $this->translate(" Get Offer"); ?></a></span>
            <?php } ?>
          </div>
        <?php } ?>
        <?php if($this->griddescriptionActive) { ?>
          <span class="_desc sesbasic_text_light">
            <?php $ro = preg_replace('/\s+/', ' ',$item->body);?>
            <?php $tmpBody = preg_replace('/ +/', ' ',html_entity_decode(strip_tags( $ro)));?>
            <?php  echo nl2br( Engine_String::strlen($tmpBody) > $descriptionLimit ? Engine_String::substr($tmpBody, 0, $descriptionLimit) . '...' : $tmpBody );?>
          </span>
        <?php } ?>
        <div class="sespageoffer_main">
          <?php if($this->showcouponcodeActive) { ?>
          <span class="sespageoffer_coupon">
              <?php echo $item->couponcode; ?>
          </span>
          <?php } ?>
          <?php if($this->offerlinkActive) { ?>
            <span class="sespageoffer_link">
              <a href="<?php echo $item->offerlink; ?>"><?php echo $this->translate("Click Here"); ?><i class="fa fa-long-arrow-right"></i></a>
            </span>
          <?php } ?>
				</div>
      </div>
      <!-- Stats -->
      <?php include APPLICATION_PATH .  '/application/modules/Sespageoffer/views/scripts/_dataStatics.tpl';?>
    </div> 
  </article>
</li>
