<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _pinboardView.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $title = '';?>
<?php if(isset($this->titleActive)):?>
<?php if(isset($this->params['pinboard_title_truncation'])):?>
<?php $titleLimit = $this->params['pinboard_title_truncation'];?>
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
<?php if(isset($this->pinboarddescriptionActive)):?>
<?php $descriptionLimit = $this->params['pinboard_description_truncation'];?>
<?php elseif(isset($this->descriptionActive)):?>
<?php $descriptionLimit = $this->params['description_truncation'];?>
<?php endif;?>
<?php $owner = $store->getOwner();?>

<li class="estore_pinboard_item sesbasic_bxs">
  <div class="estore_pinboard_item_inner sesbasic_clearfix" style="height:<?php echo is_numeric($this->height_pinboard) ? $this->height_pinboard.'px' : $this->height_pinboard ?>;width:<?php echo is_numeric($this->width_pinboard) ? $this->width_pinboard.'px' : $this->width_pinboard ?>;">
     <?php
      $dayIncludeTime = strtotime(date("Y-m-d H:i:s", strtotime('+'.(Engine_Api::_()->authorization()->getPermission(Engine_Api::_()->user()->getViewer(), 'stores', 'newBsduration')*24).' hours', strtotime($store->creation_date))));
      $currentTime = strtotime(date("Y-m-d H:i:s"));
     if(isset($this->newLabelActive) && $dayIncludeTime > $currentTime && Engine_Api::_()->getApi('settings', 'core')->getSetting('store.new', 1)):?>
      <div class="estore_pinboard_newlabel">
        <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_newLabel.tpl';?>
      </div>
    <?php endif;?>
    <div class="estore_pin_seller_info">
      <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/seller_info.tpl';?>
    </div>
    <div class="_thumb sesbasic_clearfix">
      <div class="_img"><a href="<?php echo $store->getHref();?>"><img src="<?php echo $store->getCoverPhotoUrl() ?>" alt=""/></a></div>
      <a href="<?php echo $store->getHref();?>" class="_link"  data-url="<?php echo $store->getType() ?>"></a>
      <div class="estore_list_labels sesbasic_animation">
        <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_dataLabel.tpl';?>
      </div>
      <?php if(isset($this->likeButtonActive) || isset($this->favouriteButtonActive) || isset($this->followButtonActive)):?>
      <div class="_btns sesbasic_animation">
        <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_dataButtons.tpl';?>
      </div>
      <?php endif;?>
    </div>
    <header class="sesbasic_clearfix">
			<div class="estore_pin_isrounded"> 
        <a href="<?php echo $store->getHref();?>" class="estore_thumb_img">
          <span class="bg_item_photo" style="background-image:url(<?php echo $store->getPhotoUrl('thumb.icon'); ?>);">
          </span>
        </a>
      </div>
      <div class="_cont">
        <?php if(!empty($title)):?>
          <div class="_title">
          	<div class="_name"><a href="<?php echo $store->getHref();?>"><?php echo $title;?></a></div>
            <?php if(isset($this->verifiedLabelActive) && $store->verified):?>
  					<div class="estore_verify">
            	<i class="estore_label_verified sesbasic_verified_icon" title='<?php echo $this->translate("Verified");?>'></i>
  					</div>
            <?php endif;?>
          </div>
        <?php endif;  ?>
    			<div class="_stats sesbasic_text_light">
            <?php  if(ESTORESHOWUSERDETAIL == 1 && isset($this->byActive)):?>
              <span class="_owner_name"><?php echo $this->translate('by');?>&nbsp;<?php echo $this->htmlLink($owner->getHref(), $owner->getTitle());?></span>
            <?php  endif;?>
            <?php if(isset($this->creationDateActive)):?>
              <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_date.tpl';?>
            <?php endif;?>
          </div>
        </div>
    </header>
    <div class="_info sesbasic_clearfix">
    <?php if(isset($this->priceActive)):?>
      <?php if(!empty($store->price) && $store->price != '') { ?>
        <div class="_price">
        <?php if($store->price_type == '1'){
          echo $this->translate('Price'); 
        }else{
          echo $this->translate('Starting Price'); 
        }?>
          <span class="price_val sesbasic_text_hl"><i class="fa fa-usd"></i><?php echo $store->price; ?></span>
        </div>
      <?php } ?>
    <?php endif;?>
    
      <?php if(isset($category) && isset($this->categoryActive)):?>
        <div class="_stats sesbasic_text_light"> 
          <span><i class="fa fa-folder-open"></i><span><?php echo $this->translate('in');?>&nbsp;<a href="<?php echo $category->getHref(); ?>"><?php echo $this->translate($category->category_name) ?></a></span>
          </span> 
        </div>
      <?php endif;?>
      <?php if(isset($this->likeActive) || isset($this->commentActive) || isset($this->viewActive) || isset($this->favouriteActive) || (isset($this->followActive) && isset($store->follow_count)) || (isset($this->memberActive) && isset($store->member_count))):?>
       <?php endif;?>
      
        <?php if($descriptionLimit):?>
        <p class="_des"><?php echo $this->string()->truncate($this->string()->stripTags($store->description), $descriptionLimit) ?></p>
        <?php endif;?>
        <?php if(isset($this->ratingActive)):?>
            <div class="estore_pin_rating">
                <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/rating.tpl';?>
            </div>
         <?php endif;?>
        <div class="_stats sesbasic_text_light">
          <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_dataStatics.tpl';?>
        </div>
        <?php if(isset($this->socialSharingActive)):?>
            <div class="_socialbtns">
                <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_dataSharing.tpl';?>
            </div>
        <?php endif;?>
         <?php if(isset($this->totalProductActive)):?>
            <div class="estor_pin_product_img">
                <?php unset($item); ?>
                <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_productImg.tpl';?>
            </div>	
         <?php endif; ?>
      </div>
    </div>
</li>
