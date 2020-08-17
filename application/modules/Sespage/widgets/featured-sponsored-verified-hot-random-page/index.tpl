<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sespage/externals/styles/styles.css'); ?>
<div class="sespage_3column_layout sesbasic_clearfix sesbasic_bxs clear">
  <?php $pageCount = 1;?>
  <?php foreach($this->pages as $page):?>
    <?php $owner = $page->getOwner();?>
    <div class="sespage_advgrid_item">
      <article>
        <div class="_thumb sespage_thumb" style="height:<?php echo is_numeric($this->params['height']) ? $this->params['height'].'px' : $this->params['height']; ?>;">
          <a href="<?php echo $page->getHref();?>" class="sespage_thumb_img">
            <span class="sesbasic_animation" style="background-image:url(<?php echo $page->getPhotoUrl('thumb.profile');?>);"></span>
          </a>
          <?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) || isset($this->hotLabel)):?>
            <div class="sespage_list_labels sesbasic_animation">
              <?php if(isset($this->featuredLabelActive) &&$page->featured == 1):?>
                <span class="sespage_label_featured" title="<?php echo $this->translate('FEATURED');?>"><i class="fa fa-star"></i></span>
              <?php endif;?>
              <?php if(isset($this->sponsoredLabelActive) && $page->sponsored == 1):?>
                <span class="sespage_label_sponsored" title="<?php echo $this->translate('SPONSORED');?>"><i class="fa fa-star"></i></span>
              <?php endif;?>
              <?php if(isset($this->hotLabelActive) && $page->hot == 1):?>
                <span class="sespage_label_hot" title="<?php echo $this->translate('HOT');?>"><i class="fa fa-star"></i></span>
              <?php endif;?>
            </div>
          <?php endif;?>
          <?php if(isset($this->likeButtonActive) || isset($this->favouriteButtonActive) || isset($this->followButtonActive)):?>
            <div class="_btns sesbasic_animation">
              <?php include APPLICATION_PATH .  '/application/modules/Sespage/views/scripts/_dataButtons.tpl';?>
            </div>
          <?php endif;?>
        </div>
        <div class="_cont sesbasic_animation">
          <div class="_continner">
            <div class="sesbasic_clearfix">
              <?php if(isset($this->locationActive) && $page->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('sespage_enable_location', 1)):?>
                <div class="sesbasic_text_light _location">
                	<span title="<?php echo $page->location;?>"><?php if(Engine_Api::_()->getApi('settings','core')->getSetting('sespage.enable.map.integration', 1) && Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)):?><a href="<?php echo $this->url(array('resource_id' => $page->page_id,'resource_type'=>'sespage_page','action'=>'get-direction'), 'sesbasic_get_direction', true);?>" class="openSmoothbox"><?php echo $page->location;?></a><?php else:?><?php echo $page->location;?><?php endif;?></span>
                </div>
              <?php endif;?>
              <?php if(isset($this->titleActive)):?>
                <div class="_title">
                  <a href="<?php echo $page->getHref();?>"><?php echo $page->getTitle();?></a>
                  <?php if(isset($this->verifiedLabelActive)&& $page->verified):?>
                    <i class="sespage_label_verified sesbasic_verified_icon" title='<?php echo $this->translate("Verified");?>'></i>
                  <?php endif;?>
                </div>
              <?php endif;?>
              <div class="_owner sesbasic_text_light sesbasic_clearfix">
                <?php if(SESPAGESHOWUSERDETAIL == 1):?>
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
                -&nbsp;<?php include APPLICATION_PATH .  '/application/modules/Sespage/views/scripts/_date.tpl';?>
                <?php endif;?>
              </div>
              <?php if (!empty($page->category_id)):?>
                <?php $category = Engine_Api::_ ()->getDbtable('categories', 'sespage')->find($page->category_id)->current();?>
              <?php endif;?>
              <?php if(isset($category) && isset($this->categoryActive)):?>
                <div class="_stats _category sesbasic_text_light sesbasic_clearfix">
                  <span><?php echo $this->translate('in');?>&nbsp;<a href="<?php echo $category->getHref(); ?>"><?php echo $this->translate($category->category_name) ?></a></span>
                </div>
              <?php endif;?> 
              <div class="_stats sesbasic_text_light">
                <?php include APPLICATION_PATH .  '/application/modules/Sespage/views/scripts/_dataStatics.tpl';?>
              </div>
              <?php if(isset($this->priceActive)):?>
                <div class="_price">
                  <div class="sespage_button"><i class="fa fa-usd"></i><span><?php echo $page->price;?></span></div>
                </div>
              <?php endif;?>
              <div class="_footer">
                <div class="_sharebuttons sesbasic_clearfix">
                  <?php include APPLICATION_PATH .  '/application/modules/Sespage/views/scripts/_dataSharing.tpl';?>
                </div>
              </div>
            </div>
          </div>
      	</div>    
      </article> 
  	</div>
  <?php $pageCount++;?>
  <?php endforeach;?>
</div>

