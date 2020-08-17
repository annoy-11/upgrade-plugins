<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: _pinboardView.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php $viewer = Engine_Api::_()->user()->getViewer();?>
<?php $title = '';?>
<?php if(isset($this->titleActive)):?>
<?php if(isset($this->params['pinboard_title_truncation'])):?>
<?php $titleLimit = $this->params['pinboard_title_truncation'];?>
<?php else:?>
<?php $titleLimit = $this->params['title_truncation'];?>
<?php endif;?>
<?php if(strlen($classroom->getTitle()) > $titleLimit):?>
<?php $title = mb_substr($classroom->getTitle(),0,$titleLimit).'...';?>
<?php else:?>
<?php $title = $classroom->getTitle();?>
<?php endif; ?>
<?php endif;?>
<?php $descriptionLimit = 0;?>
<?php if(isset($this->pinboarddescriptionActive)):?>
<?php $descriptionLimit = $this->params['pinboard_description_truncation'];?>
<?php elseif(isset($this->descriptionActive)):?>
<?php $descriptionLimit = $this->params['description_truncation'];?>
<?php endif;?>
<?php $owner = $classroom->getOwner();?>

 <!-- PINBOARD VIEW -->
<li class="eclassroom_pinboard_item" style="width:<?php echo $width; ?>px;">
  <article class="sesbasic_clearfix">
      <div class="_thumb classroom_thumb" style="height:<?php echo $height; ?>px;">
        <a href="<?php echo $classroom->getHref(); ?>" class="eclassroom_thumb_img">
          <img src="<?php echo $classroom->getPhotoUrl('thumb.profile'); ?>">
        </a>
        <?php  if(isset($this->statusLabelActive)): ?>
          <div class="eclassroom_status">
            <?php include APPLICATION_PATH .  '/application/modules/Eclassroom/views/scripts/_status.tpl';?>
          </div>
        <?php endif;?>
        <div class="eclassroom_labels">
            <?php include APPLICATION_PATH .  '/application/modules/Eclassroom/views/scripts/_dataLabel.tpl';?>
          </div>
           <div class="eclassroom_social">
            <?php  include APPLICATION_PATH .  '/application/modules/Eclassroom/views/scripts/_dataButtons.tpl';?>
        </div>
      </div>
      <div class="_cont">
        <div class="_title">
          <a href="<?php echo $classroom->getHref(); ?>"><?php echo $title; ?><?php if(isset($this->verifiedLabelActive) && $classroom->verified):?><i class="eclassroom_label_verified sesbasic_verified_icon" title='<?php echo $this->translate("Verified");?>'></i><?php endif;?></a>
          <?php if((isset($category) && isset($this->categoryActive)) || isset($this->byActive)): ?>
            <div class="_cat sesbasic_text_light">
              <?php if(isset($category) && isset($this->categoryActive)): ?> 
                <?php echo $this->translate('Posted in');?>&nbsp;<a href="<?php echo $category->getHref(); ?>"><?php echo $this->translate($category->category_name) ?></a>
              <?php endif;?>
              <?php if(isset($this->byActive) || isset($this->ownerPhotoActive)): ?> 
                <?php echo $this->translate('by');?>&nbsp;
                  <?php if(isset($this->ownerPhotoActive)):?>
                    <?php echo $this->htmlLink($owner->getHref(), $this->itemPhoto($owner, 'thumb.icon', $owner->getTitle()), array('title'=>$owner->getTitle())) ?>
                  <?php endif;?>
                <?php echo $this->htmlLink($owner->getHref(), $owner->getTitle());?>
              <?php endif;?>
            </div>
          <?php endif;?> 
        </div>
        <?php if(isset($this->ratingActive)): ?>
          <div class="_rating">
            <?php  include APPLICATION_PATH .  '/application/modules/Eclassroom/views/scripts/rating.tpl';?>
          </div>   
        <?php endif;?>
        <div class="_data">
            <?php   include APPLICATION_PATH .  '/application/modules/Eclassroom/views/scripts/_data.tpl';?>
        </div>
        <?php if($descriptionLimit):?>
          <div class="_des sesbasic_text_light">
            <?php echo $this->string()->truncate($this->string()->stripTags($classroom->description), $descriptionLimit) ?>
          </div>
        <?php endif;?>
        <div class="_btns">
            <?php  include APPLICATION_PATH .  '/application/modules/Eclassroom/views/scripts/_dataSharing.tpl';?>
        </div>
        <div class="eclassroom_pinboard_footer">
          <div class="_counts">
            <?php  include APPLICATION_PATH .  '/application/modules/Eclassroom/views/scripts/_dataStatics.tpl';?>
          </div>
        </div>
      </div>
  </article>
</li>
 
