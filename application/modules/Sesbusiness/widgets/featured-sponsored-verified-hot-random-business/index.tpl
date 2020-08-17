<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbusiness/externals/styles/styles.css'); ?>
<div class="sesbusiness_3column_layout sesbasic_clearfix sesbasic_bxs clear">
  <?php $businessCount = 1;?>
  <?php foreach($this->businesses as $business):?>
    <?php $owner = $business->getOwner();?>
    <div class="sesbusiness_advgrid_item">
      <article>
        <div class="_thumb sesbusiness_thumb" style="height:<?php echo is_numeric($this->params['height']) ? $this->params['height'].'px' : $this->params['height']; ?>;">
          <a href="<?php echo $business->getHref();?>" class="sesbusiness_thumb_img">
            <span class="sesbasic_animation" style="background-image:url(<?php echo $business->getPhotoUrl('thumb.profile');?>);"></span>
          </a>
          <?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) || isset($this->hotLabel)):?>
            <div class="sesbusiness_list_labels sesbasic_animation">
              <?php if(isset($this->featuredLabelActive) &&$business->featured == 1):?>
                <span class="sesbusiness_label_featured" title="<?php echo $this->translate('FEATURED');?>"><i class="fa fa-star"></i></span>
              <?php endif;?>
              <?php if(isset($this->sponsoredLabelActive) && $business->sponsored == 1):?>
                <span class="sesbusiness_label_sponsored" title="<?php echo $this->translate('SPONSORED');?>"><i class="fa fa-star"></i></span>
              <?php endif;?>
              <?php if(isset($this->hotLabelActive) && $business->hot == 1):?>
                <span class="sesbusiness_label_hot" title="<?php echo $this->translate('HOT');?>"><i class="fa fa-star"></i></span>
              <?php endif;?>
            </div>
          <?php endif;?>
          <?php if(isset($this->likeButtonActive) || isset($this->favouriteButtonActive) || isset($this->followButtonActive)):?>
            <div class="_btns sesbasic_animation">
              <?php include APPLICATION_PATH .  '/application/modules/Sesbusiness/views/scripts/_dataButtons.tpl';?>
            </div>
          <?php endif;?>
        </div>
        <div class="_cont sesbasic_animation">
        	<div class="_continner">
            <div class="sesbasic_clearfix">
              <?php if(isset($this->locationActive) && $business->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusiness_enable_location', 1)):?>
                <div class="_stats sesbasic_text_light _location">
                	<span title="<?php echo $business->location;?>"><?php if(Engine_Api::_()->getApi('settings','core')->getSetting('sesbusiness.enable.map.integration', 1)):?><a href="<?php echo $this->url(array('resource_id' => $business->business_id,'resource_type'=>'businesses','action'=>'get-direction'), 'sesbasic_get_direction', true);?>" class="openSmoothbox"><?php echo $business->location;?></a><?php else:?><?php echo $business->location;?><?php endif;?></span>
                </div>
              <?php endif;?>
              <?php if(isset($this->titleActive)):?>
                <div class="_title">
                  <a href="<?php echo $business->getHref();?>"><?php echo $business->getTitle();?></a>
                  <?php if(isset($this->verifiedLabelActive)&& $business->verified):?>
                    <i class="sesbusiness_label_verified sesbasic_verified_icon" title='<?php echo $this->translate("Verified");?>'></i>
                  <?php endif;?>
                </div>
              <?php endif;?>
              <div class="_owner sesbasic_text_light sesbasic_clearfix">
                <?php if(SESBUSINESSSHOWUSERDETAIL == 1):?>
                  <?php if(isset($this->ownerPhotoActive)):?>
                    <span class="_owner_img">
                      <?php echo $this->htmlLink($owner->getHref(), $this->itemPhoto($owner, 'thumb.icon', $owner->getTitle()), array('title'=>$owner->getTitle())) ?>
                    </span>
                  <?php endif;?>
                  <?php if(isset($this->byActive)):?>
                    <span class="_owner_name"><?php echo $this->translate('by');?>&nbsp;<?php echo $this->htmlLink($owner->getHref(), $owner->getTitle());?></span>
                  <?php endif;?>
                <?php endif;?>
                <?php if(isset($this->creationDateActive)):?>
                -&nbsp;<?php include APPLICATION_PATH .  '/application/modules/Sesbusiness/views/scripts/_date.tpl';?>
                <?php endif;?>
              </div>
              <?php if (!empty($business->category_id)):?>
                <?php $category = Engine_Api::_ ()->getDbtable('categories', 'sesbusiness')->find($business->category_id)->current();?>
              <?php endif;?>
              <?php if(isset($category) && isset($this->categoryActive)):?>
                <div class="_stats _category sesbasic_text_light sesbasic_clearfix">
                  <span><?php echo $this->translate('in');?>&nbsp;<a href="<?php echo $category->getHref(); ?>"><?php echo $this->translate($category->category_name) ?></a></span>
                </div>
              <?php endif;?> 
              <div class="_stats sesbasic_text_light">
                <?php include APPLICATION_PATH .  '/application/modules/Sesbusiness/views/scripts/_dataStatics.tpl';?>
              </div>
              <div class="_footer">
                <div class="_sharebuttons sesbasic_clearfix">
                  <?php include APPLICATION_PATH .  '/application/modules/Sesbusiness/views/scripts/_dataSharing.tpl';?>
                </div>
              </div>
            </div>
          </div>
      	</div>    
      </article> 
  	</div>
  <?php $businessCount++;?>
  <?php endforeach;?>
</div>

