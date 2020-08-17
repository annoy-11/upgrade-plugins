<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>

<?php $store = $this->result;?>
<?php $title = '';?>
<?php if(isset($this->titleActive)):?>
<?php if(isset($this->params['simplegrid_title_truncation'])):?>
<?php $titleLimit = $this->params['simplegrid_title_truncation'];?>
<?php else:?>
<?php $titleLimit = $this->params['title_truncation'];?>
<?php endif;?>
<?php if(strlen($store->getTitle()) > $titleLimit):?>
<?php $title = mb_substr($store->getTitle(),0,$titleLimit).'...';?>
<?php else:?>
<?php $title = $store->getTitle();?>
<?php $owner = $store->getOwner(); ?>
<?php endif; ?>
<?php endif;?>
<?php $descriptionLimit = 0;?>
<?php if(isset($this->simplegriddescriptionActive)):?>
<?php $descriptionLimit = $this->params['simplegrid_description_truncation'];?>
<?php elseif(isset($this->descriptionActive)):?>
<?php $descriptionLimit = $this->params['description_truncation'];?>
<?php endif;?>
<?php $likeDataType = 'like_view';?>
<?php $likeClassType = "estore_like_".$store->getIdentity(); ?>
<?php $favouriteDataType = 'favourite_view';?>
<?php $favouriteClassType = "estore_favourite_".$store->getIdentity(); ?>
<?php $followDataType = 'follow_view';?>
<?php $followClassType = "estore_follow_".$store->getIdentity(); ?>

<div class="sesbasic_bxs sesbasic_clearfix estore_sidebar_data">
  <div class="estore_grid_item sesbasic_clearfix item<?php if(isset($this->contactButtonActive) || isset($this->socialSharingActive)):?> _isbtns<?php endif;?>">
    <article>
     <?php if(isset($this->newLabelActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('store.new', 1)):?>
        <div class="estore_sgrid_newlabel">
            <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_newLabel.tpl';?>
        </div>
    <?php endif;?>
	
    <div class="_thumb estore_thumb" style="height:<?php echo $height ?>px;"> 
      <a href="<?php echo $store->getHref();?>" class="estore_thumb_img"><span style="background-image:url(<?php echo $store->getCoverPhotoUrl() ?>);"></span></a>
      <a href="javascript:;" class="_cover_link"></a>
      <div class="estore_list_labels sesbasic_animation">
        <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_dataLabel.tpl';?>
      </div>      
      <?php if(isset($this->likeButtonActive) || isset($this->favouriteButtonActive) || isset($this->followButtonActive)):?>
      <div class="_btns sesbasic_animation">
        <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_dataButtons.tpl';?>
      </div>
      <?php endif;?>
    </div>
		<div class="estore_grid_info">
    <?php if(!empty($title)):?>
          <div class="_title"> <a href="<?php echo $store->getHref();?>"><?php echo $title; ?></a>
          <?php if(isset($this->verifiedLabelActive) && $store->verified):?>
          <i class="estore_label_verified sesbasic_verified_icon" title='<?php echo $this->translate("Verified");?>'></i> 
      <?php endif;?>
          </div>
      <?php endif;?>
			 <?php $item = $store;  if(isset($this->ratingActive)):?>
            <div class="estore_sgrid_rating">
                <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_rating.tpl';?>
            </div>
        <?php endif;?>
      <div class="sesbasic_clearfix"> 
      <div class="_stats">
        <?php if(isset($this->creationDateActive)):?>
        <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_date.tpl';?>
        <?php endif;?>
       </div>
      <?php if(ESTORESHOWUSERDETAIL == 1 && isset($this->postedbyActive)):?>
              <span class="_stats"><i class="far fa-user"></i><?php echo $this->translate('By');?>&nbsp;<?php echo $this->htmlLink($owner->getHref(), $owner->getTitle());?></span>
              <?php endif;?>
         <?php if (!empty($store->category_id)): ?>
                <?php $category = Engine_Api::_ ()->getDbtable('categories', 'estore')->find($store->category_id)->current();?>
        <?php endif;?> 
        <?php if(isset($category) && isset($this->categoryActive)):?>
        <div class="_stats _category sesbasic_text_light sesbasic_clearfix"> <i class="far fa-folder-open"></i> <span><a href="<?php echo $category->getHref(); ?>"><?php echo $this->translate($category->category_name) ?></a></span> </div>
        <?php endif;?>
        <?php if(isset($this->locationActive) && $store->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('estore_enable_location', 1)):?>
        <div class="_stats sesbasic_text_light"> <i class="fa fa-map-marker-alt sesbasic_text_light" title="<?php echo $this->translate('Location');?>">  </i> <span title="<?php echo $store->location;?>">
          <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1) && Engine_Api::_()->getApi('settings','core')->getSetting('estore.enable.map.integration', 1)):?>
          <a href="<?php echo $this->url(array('resource_id' => $store->store_id,'resource_type'=>'stores','action'=>'get-direction'), 'sesbasic_get_direction', true);?>" class="openSmoothbox"><?php echo $store->location;?></a>
          <?php else:?>
          <?php echo $store->location;?>
          <?php endif;?>
          </span> 
        </div>
        <?php endif;?>
        <div class="_stats  _location sesbasic_text_light">
          <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_dataStatics.tpl';?>
        </div>
      </div>
    </div>
  </article>
  </div>
</div>
