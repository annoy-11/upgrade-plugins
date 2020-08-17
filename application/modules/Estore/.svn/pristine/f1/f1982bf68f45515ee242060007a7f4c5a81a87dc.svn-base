<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: mapmarkercontent.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>

<?php $resource = $store = $this->resource; ?>
<?php $owner = $resource->getOwner();?>
<div class="estore_quick_popup sesbasic_bxs">
	<section>
  	<div class="_top_section sesbasic_clearfix">
  		<div class="_thumb"><?php echo $this->htmlLink($resource->getHref(), $this->itemBackgroundPhoto($resource));?></div>
      <div class="_cont">
      	<h3><?php echo $resource->getTitle(); ?></h3>
        <?php if(ESTORESHOWUSERDETAIL == 1):?>
          <p class="_owner"><?php echo $this->translate('by');?>&nbsp;<?php echo $this->htmlLink($owner->getHref(), $owner->getTitle());?></p>
        <?php endif;?>
      </div>  
    </div>
  	<div class="_cont">
  	<?php if($resource->category_id):?>
      <div class="field_ sesbasic_clearfix">
        <?php $category = Engine_Api::_()->getItem('estore_category', $resource->category_id); ?>
        <span class="sesbasic_text_light"><?php echo $this->translate('Category');?></span><span><a href="<?php echo $category->getHref(); ?>"><?php echo $this->translate($category->category_name) ?></a></span></a>
      </div>
    <?php endif;?>
    <div class="sesbasic_clearfix"><p><?php echo $this->string()->stripTags($resource->description); ?></p></div>
    <?php if(count($this->results) > 0) { ?>
      <?php foreach($this->results as $location):?>
        <div class="_cont _locinfo">
          <div class="_title sesbasic_clearfix">
            <?php echo $location->title;?>
          </div>
          <div class="field_ sesbasic_clearfix">
            <span class="sesbasic_text_light"><?php echo $this->translate("Location:");?></span>
            <span><?php echo $location->location;?></span>
          </div>
          <div class="field_ sesbasic_clearfix">
            <span class="sesbasic_text_light"><?php echo $this->translate("Venue");?></span>
            <span><?php echo $location->venue;?></span>
          </div>
          <div class="field_ sesbasic_clearfix">
            <span class="sesbasic_text_light"><?php echo $this->translate("Address:");?></span>
            <span><?php echo $location->address;?></span>
          </div>
          <div class="field_ sesbasic_clearfix">
            <span class="sesbasic_text_light"><?php echo $this->translate("Street Address:");?></span>
            <span><?php echo $location->address2;?></span>
          </div>
          <div class="field_ sesbasic_clearfix">
            <p>
              <span class="sesbasic_text_light"><?php echo $this->translate("City:");?></span>
              <span><?php echo $location->city;?></span>
            </p>  
            <p>
              <span class="sesbasic_text_light"><?php echo $this->translate("ZIPCode:");?></span>
              <span><?php echo $location->zip;?></span>
            </p>
          </div>
          <div class="field_ sesbasic_clearfix">
            <p>
              <span class="sesbasic_text_light"><?php echo $this->translate("State:");?></span>
              <span><?php echo $location->state;?></span>
            </p>
            <p>
              <span class="sesbasic_text_light"><?php echo $this->translate("Country:");?></span>
              <span><?php echo $location->country;?></span>
            </p>  
          </div>
        </div>
      <?php endforeach;?>
    <?php } ?>
    </div>
  </section>
  <div class="_footer sesbasic_clearfix">
    <div class="_btnsleft">
      <?php $viewer = Engine_Api::_()->user()->getViewer();?>
      <?php $viewerId = $viewer->getIdentity();?>
      <?php if($store->is_approved):?>
        <?php $canComment = Engine_Api::_()->authorization()->isAllowed('stores', $viewer, 'create');?>
        <?php if($canComment):?>
          <?php $likeStatus = Engine_Api::_()->estore()->getLikeStatus($store->store_id,$store->getType()); ?>
          <a href="javascript:;" data-type="like_view" data-url="<?php echo $store->store_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn estore_like_<?php echo $store->store_id ?> estore_likefavfollow <?php echo ($likeStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-thumbs-up"></i><span><?php echo $store->like_count;?></span></a>
        <?php endif;?>
        <?php if($viewerId):?>
          <?php if( Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.allow.favourite', 1)):?>
            <?php $favouriteStatus = Engine_Api::_()->getDbTable('favourites', 'estore')->isFavourite(array('resource_id' => $store->store_id,'resource_type' => $store->getType())); ?>
            <a href="javascript:;" data-type="favourite_view" data-url="<?php echo $store->store_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn estore_favourite_<?php echo $store->store_id ?> estore_likefavfollow <?php echo ($favouriteStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-heart"></i><span><?php echo $store->favourite_count;?></span></a>
          <?php endif;?>
          <?php if($viewerId != $store->owner_id && Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.allow.follow', 1)):?>
            <?php $followStatus = Engine_Api::_()->getDbTable('followers', 'estore')->isFollow(array('resource_id' => $store->store_id,'resource_type' => $store->getType())); ?>
            <a href="javascript:;" data-type="follow_view" data-url="<?php echo $store->store_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_follow_btn estore_follow_<?php echo $store->store_id ?> estore_likefavfollow <?php echo ($followStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-check"></i><span><?php echo $store->follow_count;?></span></a>
          <?php endif;?>
        <?php endif;?>
      <?php endif;?>
    </div>
		<div class="_btnsright">
  	 <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_dataSharing.tpl';?>
  </div>
</div>
