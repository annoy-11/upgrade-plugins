<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _listView.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>

<?php   $title = '';?>
<?php if(isset($this->titleActive)):?>
<?php if(isset($this->params['list_title_truncation'])):?>
<?php $titleLimit = $this->params['list_title_truncation'];?>
<?php else:?>
<?php $titleLimit = $this->params['title_truncation'];?>
<?php endif;?>
<?php if(strlen($store->getTitle()) > $titleLimit):?>
<?php $title = mb_substr($store->getTitle(),0,$titleLimit).'...';?>
<?php else:?>
<?php $title = $store->getTitle();?>
<?php endif; ?>
<?php endif;?>
<?php $descriptionLimit = 0;?>
<?php if(isset($this->listdescriptionActive)):?>
<?php $descriptionLimit = $this->params['list_description_truncation'];?>
<?php elseif(isset($this->descriptionActive)):?>
<?php $descriptionLimit = $this->params['description_truncation'];?>
<?php endif;?>
<?php $owner = $store->getOwner();?>
<!--application/modules/Estore/externals/images/products/bg-banner.jpg-->
<li class="estore_list_text_item" id="estore_manage_listing_item_<?php echo $store->getIdentity(); ?>">
  <article class="sesbasic_clearfix">
   <?php
	 
		$dayIncludeTime = strtotime(date("Y-m-d H:i:s", strtotime('+'.(Engine_Api::_()->authorization()->getPermission(Engine_Api::_()->user()->getViewer(), 'stores', 'newBsduration')*24).' hours', strtotime($store->creation_date))));
		$currentTime = strtotime(date("Y-m-d H:i:s"));

	 if(isset($this->newLabelActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('store.new', 1) && $dayIncludeTime > $currentTime):?>
		<div class="estore_list_newlabel">
    	<?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_newLabel.tpl';?>
		</div>
   <?php endif;?>
    <div class="estore_list_left sesbasic_clearfix" style="height:<?php echo is_numeric($this->height_list) ? $this->height_list.'px' : $this->height_list ?>;width:<?php echo is_numeric($this->width_list) ? $this->width_list.'px' : $this->width_list ?>;">
			<div class="estore_list_thumb_bg" style=" background: url('<?php echo $store->getCoverPhotoUrl(); ?>'); background-size: cover;background-position: center center;">
        <div class="_thumb estore_thumb" style="height:<?php echo $height ?>px;width:<?php echo $width ?>px;"> 
          <a href="<?php  echo $store->getHref();?>" class="estore_thumb_img estore_browse_location_<?php echo $store->getIdentity(); ?>"> 
            <span style="background-image:url(<?php echo $store->getPhotoUrl('thumb.profile'); ?>);"></span> 
          </a> 
					<a href="javascript:;" class="_cover_link"></a>         
        </div>
				<div class="estore_list_labels sesbasic_animation">
          <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_dataLabel.tpl';?>
        </div>
        <?php if(isset($this->likeButtonActive) || isset($this->favouriteButtonActive) || isset($this->followButtonActive)):?>
        <div class="_btns sesbasic_animation">
          <?php  include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_dataButtons.tpl';?>
        </div>
        <?php endif;?>
			</div>
    </div>
		<div class="estore_list_right">
      <?php if(!empty($title)): ?>
        <div class="_title"> <a href="<?php echo $store->getHref();?>"><?php echo $title;?></a>
          <?php if(isset($this->verifiedLabelActive) && $store->verified):?>
          <i class="estore_label_verified sesbasic_verified_icon" title='<?php echo $this->translate("Verified");?>'></i>
          <?php endif;?>
        </div>
      <?php endif;?>
			<div class="estore_list_right_inner">
        <div class="_contentleft">
          <div class="_stats sesbasic_text_light">
            <?php if(ESTORESHOWUSERDETAIL == 1 && isset($this->byActive)):  ?>
            	<span class="_owner_name"><?php echo $this->translate('by');?>&nbsp;<?php echo $this->htmlLink($owner->getHref(), $owner->getTitle());?></span>
            <?php endif;?>
            <?php if(isset($this->creationDateActive)):?>
            -&nbsp;
            	<?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_date.tpl';?>
            <?php endif; ?>
          </div>
          <?php if(isset($category) && isset($this->categoryActive)): ?>
          <div class="_stats sesbasic_text_light"> 
            <span><i class="fa fa-folder-open"></i><span><?php echo $this->translate('in');?>&nbsp;<a href="<?php echo $category->getHref(); ?>"><?php echo $this->translate($category->category_name) ?></a></span>
            </span> 
          </div>
          <?php endif;?>
          <?php if(isset($this->locationActive) && $store->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.enable.location', 1)): ?>
          <div class="_stats sesbasic_text_light _location"> <i class="fa fa-map-marker sesbasic_text_light" title="<?php echo $this->translate('Location');?>"></i> 
            <span title="<?php echo $store->location;?>">
              <?php if(Engine_Api::_()->getApi('settings','core')->getSetting('estore.enable.map.integration', 1) && Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)):?>
                <a href="<?php echo $this->url(array('resource_id' => $store->store_id,'resource_type'=>'stores','action'=>'get-direction'), 'sesbasic_get_direction', true);?>" class="openSmoothbox"><?php echo $store->location;?></a>
              <?php else:?>
                <?php echo $store->location;?>
              <?php endif;?>
            </span>
          </div>
          <?php  endif;?>
          <?php if($descriptionLimit):?>
          <div class="_des"> <?php echo $this->string()->truncate($this->string()->stripTags($store->description), $descriptionLimit) ?></div>
          <?php endif;?>
				<div class="estore_grid_seller_info">
          <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/seller_info.tpl';?>
        </div>
		
        <?php if(isset($this->ratingActive)):?>
            <div class="estore_list_rating">
                <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/rating.tpl';  ?>
            </div>
        <?php  endif; ?>
        <?php unset($item); ?>
        <div class="_stats sesbasic_text_light">
          <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_dataStatics.tpl';?>
        </div>
		
        <?php if(isset($this->totalProductActive)): ?>
            <div class="estore_list_product_img">
                <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_productImg.tpl';?>
            </div>
        <?php endif; ?>
		  </div>
		  
      <div class="_contentright">
      <?php if(isset($this->priceActive)):?>
        <div class="estore_list_price">
          <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_priceLabel.tpl';?>
        </div>
        <?php  endif;?>
        <?php if(isset($this->socialSharingActive)):?>
            <div class="estore_list_share">
            <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_dataSharing.tpl';?>
            </div>  
        <?php  endif; ?>
      </div>
    </div>
  </article>
</li>

