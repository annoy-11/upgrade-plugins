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
<?php $business = $this->result;?>
<?php $likeDataType = 'like_view';?>
<?php $likeClassType = "sesbusiness_like_".$business->getIdentity(); ?>
<?php $favouriteDataType = 'favourite_view';?>
<?php $favouriteClassType = "sesbusiness_favourite_".$business->getIdentity(); ?>
<?php $followDataType = 'follow_view';?>
<?php $followClassType = "sesbusiness_follow_".$business->getIdentity(); ?>
<div class="sesbasic_bxs sesbasic_clearfix sesbusiness_sidebar_data">
  <div class="sesbusiness_grid_item sesbasic_clearfix item<?php if(isset($this->contactButtonActive) || isset($this->socialSharingActive)):?> _isbtns<?php endif;?>">
    <article>
    	<div class="_thumb sesbusiness_thumb" style="height:<?php echo $this->params['imageheight'] ?>px;">
        <a href="<?php echo $business->getHref(); ?>" class="sesbusiness_thumb_img">
          <span class="sesbasic_animation" style="background-image:url(<?php echo $business->getPhotoUrl('thumb.profile'); ?>);"></span>
        </a>
        <?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) && isset($this->hotLabelActive)){ ?>
          <div class="sesbusiness_list_labels sesbasic_animation">
            <?php if(isset($this->featuredLabelActive) && $business->featured){ ?>
              <span class="sesbusiness_label_featured" title="<?php echo $this->translate('Featured');?>"><i class="fa fa-star"></i></span>
            <?php } ?>
            <?php if(isset($this->sponsoredLabelActive) && $business->sponsored){ ?>
              <span class="sesbusiness_label_sponsored" title="<?php echo $this->translate('Sponsored');?>"><i class="fa fa-star"></i></span>
            <?php } ?>
            <span class="sesbusiness_label_hot" title="<?php echo $this->translate('Hot');?>"><i class="fa fa-star"></i></span>
          </div>
        <?php } ?>
        
        <?php  if(isset($this->likeButtonActive) || isset($this->favouriteButtonActive) || isset($this->followButtonActive)):?>
          <div class="_btns sesbasic_animation">
            <?php include APPLICATION_PATH .  '/application/modules/Sesbusiness/views/scripts/_dataButtons.tpl';?>
          </div>
        <?php endif;?>
        
        <?php if(isset($this->titleActive) ){ ?>
          <div class="_thumbinfo">
            <div>
              <div class="_title">          
              <?php if(strlen($business->getTitle()) > $this->params['title_truncation']){ 
                $title = mb_substr($business->getTitle(),0,($this->params['title_truncation'] - 3)).'...';?>
                <?php echo $this->htmlLink($business->getHref(),$title); ?>
              <?php }else{ ?>
                <?php echo $this->htmlLink($business->getHref(),$business->getTitle()) ?>
              <?php } ?>
              <?php if(isset($this->verifiedLabelActive)&& $business->verified):?><i class="sesbusiness_label_verified sesbasic_verified_icon" title='<?php echo $this->translate("Verified");?>'></i><?php endif;?>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
      <div class="_cont sesbasic_clearfix">
        <?php $owner = $business->getOwner(); ?>
        <?php $href = $business->getHref();?>
        <div class="_owner sesbasic_text_light">
          <?php if(SESBUSINESSSHOWUSERDETAIL == 1 && isset($this->postedbyActive)){ ?>	
            <span class="_owner_img">
              <?php echo $this->htmlLink($owner->getHref(), $this->itemPhoto($owner, 'thumb.icon', $owner->getTitle()), array('title'=>$owner->getTitle())) ?>
            </span>
            <span class="_owner_name"><?php echo $this->translate('by');?>&nbsp;<?php echo $this->htmlLink($owner->getHref(), $owner->getTitle());?></span>
          <?php  } ?>
          <?php if(isset($this->creationDateActive)):?>
            -&nbsp;<?php include APPLICATION_PATH .  '/application/modules/Sesbusiness/views/scripts/_date.tpl';?>
          <?php endif;?>
        </div>
        <?php if(isset($this->categoryActive)):?>
          <?php $category = Engine_Api::_ ()->getDbtable('categories', 'sesbusiness')->find($business->category_id)->current();?>
          <div class="_stats sesbasic_text_light">
            <i class="fa fa-folder-open"></i><span><?php echo $this->translate('in');?>&nbsp;<a href="<?php echo $category->getHref(); ?>"><?php echo $this->translate($category->category_name) ?></a></span>
          </div>
        <?php endif;?>  
        <?php if(isset($this->likeActive) || isset($this->commentActive) || isset($this->viewActive) || isset($this->favouriteActive) || (isset($this->followActive) && isset($business->follow_count)) || (isset($this->memberActive) && isset($business->member_count))):?>
          <div class="_stats sesbasic_text_light">
              <i class="fa fa-bar-chart"></i>
            <span><?php include APPLICATION_PATH .  '/application/modules/Sesbusiness/views/scripts/_dataStatics.tpl';?></span>
          </div>
        <?php endif;?>
        <?php if(isset($this->locationActive) && $business->location):?>
          <div class="_stats sesbasic_text_light _location">
            <i class="fa fa-map-marker sesbasic_text_light" title="<?php echo $this->translate('Location');?>"></i>
            <span title="<?php echo $business->location;?>"><?php if(Engine_Api::_()->getApi('settings','core')->getSetting('sesbusiness.enable.map.integration', 1)):?><a href="<?php echo $this->url(array('resource_id' => $business->business_id,'resource_type'=>'businesses','action'=>'get-direction'), 'sesbasic_get_direction', true);?>" class="openSmoothbox"><?php echo $business->location;?></a><?php else:?><?php echo $business->location;?><?php endif;?></span>
          </div>
        <?php endif;?>
      </div>
      <?php if(isset($this->contactButtonActive) || isset($this->socialSharingActive)):?>
        <div class="_sharebuttons sesbasic_clearfix">
          <?php include APPLICATION_PATH .  '/application/modules/Sesbusiness/views/scripts/_dataSharing.tpl';?>
        </div>
      <?php endif;?>
    </article>
  </div>
</div>
