<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _advgridView.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $title = '';?>
<?php if(isset($this->titleActive)):?>
  <?php if(isset($this->params['advgrid_title_truncation'])):?>
    <?php $titleLimit = $this->params['advgrid_title_truncation'];?>
  <?php else:?>
    <?php $titleLimit = $this->params['title_truncation'];?>
  <?php endif;?>
  <?php if(strlen($store->getTitle()) > $titleLimit):?>
    <?php $title = mb_substr($store->getTitle(),0,$titleLimit).'...';?>
  <?php else:?>
    <?php $title = $store->getTitle();?>
  <?php endif; ?>
<?php endif;?>
<?php $owner = $store->getOwner();?>
  <li class="estore_advgrid_item" style="width:<?php echo $width ?>px;">
  <article>
		<div class="estore_adgrid_newlabel">
    	<?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_newLabel.tpl';?>
		</div>
		<div class="estore_adgrid_sale">
			<?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_saleLabel.tpl';?>
		</div>
    <div class="_thumb estore_thumb" style="height:<?php echo $height ?>px;">
      <a href="<?php echo $store->getHref();?>" class="estore_thumb_img">
        <span class="sesbasic_animation" style="background-image:url(<?php echo $store->getPhotoUrl('thumb.profile'); ?>);"></span>
      </a>
      <div class="estore_list_labels sesbasic_animation">
        <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_dataLabel.tpl';?>
      </div>
      <?php if(isset($this->likeButtonActive) || isset($this->favouriteButtonActive) || isset($this->followButtonActive)):?>
        <div class="_btns sesbasic_animation">
          <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_dataButtons.tpl';?>
        </div>
      <?php endif;?>
    </div>
    <div class="_cont sesbasic_animation">
      <div class="_continner">
        <div class="sesbasic_clearfix">
					<div class="adv_grid_logo"> <a href="<?php echo $store->getHref();?>" class="estore_thumb_img"><span class="bg_item_photo" style="background-image:url(<?php echo $store->getPhotoUrl('thumb.icon'); ?>);"></span></a></div>
				<div class="estore_adv_grid_cont">
          <?php if(!empty($title)):?>
            <div class="_title">
              <a href="<?php echo $store->getHref();?>"><?php echo $title;?></a>
              <?php if(isset($this->verifiedLabelActive)&& $store->verified):?><i class="estore_label_verified sesbasic_verified_icon" title='<?php echo $this->translate("Verified");?>'></i><?php endif;?>
            </div>
          <?php endif;?>
          <div class="_date">
            <?php if(ESTORESHOWUSERDETAIL == 1 && isset($this->byActive)):?>
            <span class="_owner_name"><?php echo $this->translate('by');?>&nbsp;<?php echo $this->htmlLink($owner->getHref(), $owner->getTitle());?></span>
            <?php endif;?>
            <?php if(isset($this->creationDateActive)):?>
            -&nbsp;
            <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_date.tpl';?>
            <?php endif;?>
          </div>
          <?php if(isset($category) && isset($this->categoryActive)):?>
            <div class="_stats sesbasic_text_light"> <span><i class="fa fa-folder-open"></i> <span><?php echo $this->translate('in');?>&nbsp;<a href="<?php echo $category->getHref(); ?>"><?php echo $this->translate($category->category_name) ?></a></span></span> </div>
            <?php endif;?>
            <div class="_stats sesbasic_text_light">
              <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_dataStatics.tpl';?>
            </div>
            <div class="estore_adgrid_rating">
              <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/rating.tpl';?>
            </div>
					</div>
          <div class="estore_adgrid_seller_info">
            <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/seller_info.tpl';?>
          </div>
					<?php if($descriptionLimit):?>
          	<div class="_des"> <?php echo $this->string()->truncate($this->string()->stripTags($store->description), $descriptionLimit) ?> </div>
          <?php endif;?>
          <div class="estore_adgrid_share">
            <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_dataSharing.tpl';?>
          </div>
          <div class="estore_adgrid_price">
            <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_priceLabel.tpl';?>
          </div>
        </div>
      </div>
    </div>
  </article>
	<div class="estore_adgrid_product_img">
    <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_productImg.tpl';?>
  </div>
</li> 
