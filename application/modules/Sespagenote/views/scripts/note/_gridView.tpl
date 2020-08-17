<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesinterest
 * @package    Sesinterest
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _gridView.tpl  2019-03-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sespagenote/externals/styles/style.css'); ?> 
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
<li class="sesbasic_bg sespagenote_grid_item" style="width:<?php echo $width ?>px;">
  <article class="sesbasic_bg">
    <div class="sespagenote_profile_top">
      <div class="sespagenote_profile_inner">
        <a href="<?php echo $item->getHref();?>" class="sespagenote_profile_img"><span style="height:<?php echo $height ?>px;background-image:url(<?php echo $item->getPhotoUrl() ?>);"></span></a>
        <!-- Share Buttons -->
        <?php include APPLICATION_PATH .  '/application/modules/Sespagenote/views/scripts/_dataSharing.tpl';?>
        <!-- Labels -->
        <?php include APPLICATION_PATH .  '/application/modules/Sespagenote/views/scripts/_dataLabel.tpl';?>
         <?php if($this->pagenameActive) { ?>
            <?php $page = Engine_Api::_()->getItem('sespage_page', $item->parent_id); ?>
            <span class="sespagenote_pagename"> 
                <i class="fa fa-file-text"></i> <a href="<?php echo $page->getHref(); ?>"><?php echo $page->getTitle(); ?></a>
            </span>
          <?php } ?>
      </div>
      <div class="sespagenote_profile_body">
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
        </span>
        <?php if($this->griddescriptionActive) { ?>
          <span class="_desc sesbasic_text_light">
            <?php $ro = preg_replace('/\s+/', ' ',$item->body);?>
            <?php $tmpBody = preg_replace('/ +/', ' ',html_entity_decode(strip_tags( $ro)));?>
            <?php  echo nl2br( Engine_String::strlen($tmpBody) > $descriptionLimit ? Engine_String::substr($tmpBody, 0, $descriptionLimit) . '...' : $tmpBody );?>
          </span>
        <?php } ?>
      </div>
      <!-- Stats -->
      <?php include APPLICATION_PATH .  '/application/modules/Sespagenote/views/scripts/_dataStatics.tpl';?>
    </div> 
  </article>
</li>
