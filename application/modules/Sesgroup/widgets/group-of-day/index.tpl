<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesgroup/externals/styles/styles.css'); ?>
<?php $group = $this->result;?>
<?php $likeDataType = 'like_view';?>
<?php $likeClassType = "sesgroup_like_".$group->getIdentity(); ?>
<?php $favouriteDataType = 'favourite_view';?>
<?php $favouriteClassType = "sesgroup_favourite_".$group->getIdentity(); ?>
<?php $followDataType = 'follow_view';?>
<?php $followClassType = "sesgroup_follow_".$group->getIdentity(); ?>
<div class="sesbasic_bxs sesbasic_clearfix sesgroup_sidebar_data">
  <div class="sesgroup_grid_item sesbasic_clearfix item<?php if(isset($this->contactButtonActive) || isset($this->socialSharingActive)):?> _isbtns<?php endif;?>">
    <article>
    	<div class="_thumb sesgroup_thumb" style="height:<?php echo $this->params['imageheight'] ?>px;">
        <a href="<?php echo $group->getHref(); ?>" class="sesgroup_thumb_img">
          <span class="sesbasic_animation" style="background-image:url(<?php echo $group->getPhotoUrl('thumb.profile'); ?>);"></span>
        </a>
        <?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) && isset($this->hotLabelActive)){ ?>
          <div class="sesgroup_list_labels sesbasic_animation">
            <?php if(isset($this->featuredLabelActive) && $group->featured){ ?>
              <span class="sesgroup_label_featured" title="<?php echo $this->translate('Featured');?>"><i class="fa fa-star"></i></span>
            <?php } ?>
            <?php if(isset($this->sponsoredLabelActive) && $group->sponsored){ ?>
              <span class="sesgroup_label_sponsored" title="<?php echo $this->translate('Sponsored');?>"><i class="fa fa-star"></i></span>
            <?php } ?>
            <span class="sesgroup_label_hot" title="<?php echo $this->translate('Hot');?>"><i class="fa fa-star"></i></span>
          </div>
        <?php } ?>
        
        <?php  if(isset($this->likeButtonActive) || isset($this->favouriteButtonActive) || isset($this->followButtonActive)):?>
          <div class="_btns sesbasic_animation">
            <?php include APPLICATION_PATH .  '/application/modules/Sesgroup/views/scripts/_dataButtons.tpl';?>
          </div>
        <?php endif;?>
        
        <?php if(isset($this->titleActive) ){ ?>
          <div class="_thumbinfo">
            <div>
              <div class="_title">          
              <?php if(strlen($group->getTitle()) > $this->params['title_truncation']){ 
                $title = mb_substr($group->getTitle(),0,($this->params['title_truncation'] - 3)).'...';?>
                <?php echo $this->htmlLink($group->getHref(),$title); ?>
              <?php }else{ ?>
                <?php echo $this->htmlLink($group->getHref(),$group->getTitle()) ?>
              <?php } ?>
              <?php if(isset($this->verifiedLabelActive)&& $group->verified):?><i class="sesgroup_label_verified sesbasic_verified_icon" title='<?php echo $this->translate("Verified");?>'></i><?php endif;?>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
      <div class="_cont sesbasic_clearfix">
        <?php $owner = $group->getOwner(); ?>
        <?php $href = $group->getHref();?>
        <div class="_owner sesbasic_text_light">
          <?php if(SESGROUPSHOWUSERDETAIL == 1 && isset($this->postedbyActive)){ ?>	
            <span class="_owner_img">
              <?php echo $this->htmlLink($owner->getHref(), $this->itemPhoto($owner, 'thumb.icon', $owner->getTitle()), array('title'=>$owner->getTitle())) ?>
            </span>
            <span class="_owner_name"><?php echo $this->translate('by');?>&nbsp;<?php echo $this->htmlLink($owner->getHref(), $owner->getTitle());?></span>
          <?php  } ?>
          <?php if(isset($this->creationDateActive)):?>
            -&nbsp;<?php include APPLICATION_PATH .  '/application/modules/Sesgroup/views/scripts/_date.tpl';?>
          <?php endif;?>
        </div>
        <?php if(isset($this->categoryActive)):?>
          <?php $category = Engine_Api::_ ()->getDbtable('categories', 'sesgroup')->find($group->category_id)->current();?>
          <div class="_stats sesbasic_text_light">
            <i class="fa fa-folder-open"></i><span><?php echo $this->translate('in');?>&nbsp;<a href="<?php echo $category->getHref(); ?>"><?php echo $this->translate($category->category_name) ?></a></span>
          </div>
        <?php endif;?>  
        <?php if(isset($this->likeActive) || isset($this->commentActive) || isset($this->viewActive) || isset($this->favouriteActive) || (isset($this->followActive) && isset($group->follow_count)) || (isset($this->memberActive) && isset($group->member_count))):?>
          <div class="_stats sesbasic_text_light">
              <i class="fa fa-bar-chart"></i>
            <span><?php include APPLICATION_PATH .  '/application/modules/Sesgroup/views/scripts/_dataStatics.tpl';?></span>
          </div>
        <?php endif;?>
        <?php if(isset($this->locationActive) && $group->location):?>
          <div class="_stats sesbasic_text_light _location">
            <i class="fa fa-map-marker sesbasic_text_light" title="<?php echo $this->translate('Location');?>"></i>
            <span title="<?php echo $group->location;?>"><?php if(Engine_Api::_()->getApi('settings','core')->getSetting('sesgroup.enable.map.integration', 1)):?><a href="<?php echo $this->url(array('resource_id' => $group->group_id,'resource_type'=>'sesgroup_group','action'=>'get-direction'), 'sesbasic_get_direction', true);?>" class="openSmoothbox"><?php echo $group->location;?></a><?php else:?><?php echo $group->location;?><?php endif;?></span>
          </div>
        <?php endif;?>
      </div>
      <?php if(isset($this->contactButtonActive) || isset($this->socialSharingActive)):?>
        <div class="_sharebuttons sesbasic_clearfix">
          <?php include APPLICATION_PATH .  '/application/modules/Sesgroup/views/scripts/_dataSharing.tpl';?>
        </div>
      <?php endif;?>
    </article>
  </div>
</div>
