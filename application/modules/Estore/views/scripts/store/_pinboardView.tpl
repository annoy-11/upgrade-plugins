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

<li class="estore_pinboard_item sesbasic_bxs" style="width:<?php echo is_numeric($this->width_pinboard) ? $this->width_pinboard.'px' : $this->width_pinboard ?>;">
  <div class="estore_pinboard_item_inner sesbasic_clearfix">
     <?php
      $dayIncludeTime = strtotime(date("Y-m-d H:i:s", strtotime('+'.(Engine_Api::_()->authorization()->getPermission((Engine_Api::_()->user()->getViewer()->getIdentity() ? Engine_Api::_()->user()->getViewer() : 0), 'stores', 'newBsduration')*24).' hours', strtotime($store->creation_date))));
      $currentTime = strtotime(date("Y-m-d H:i:s"));
     if(isset($this->newLabelActive) && $dayIncludeTime > $currentTime && Engine_Api::_()->getApi('settings', 'core')->getSetting('store.new', 1)):?>
      <div class="estore_pinboard_newlabel">
        <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_newLabel.tpl';?>
      </div>
    <?php endif;?>
    <div class="_thumb sesbasic_clearfix">
      <div class="_img"><a href="<?php echo $store->getHref();?>"><img src="<?php echo $store->getPhotoUrl() ?>" alt=""/></a></div>
      <a href="<?php echo $store->getHref();?>" class="_link"  data-url="<?php echo $store->getType() ?>"></a>
      <div class="estore_list_labels sesbasic_animation">
        <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_dataLabel.tpl';?>
      </div>
      <?php if(isset($this->likeButtonActive) || isset($this->favouriteButtonActive) || isset($this->followButtonActive)):?>
      <div class="_btns sesbasic_animation">
        <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_dataButtons.tpl';?>
      </div>
      <?php endif;?>
       <?php if(isset($this->creationDateActive)):?>
           <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_date.tpl';?>
       <?php endif;?>
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
              <span class="_owner_name"><?php echo $this->translate('Posted by');?>&nbsp;<?php echo $this->htmlLink($owner->getHref(), $owner->getTitle());?></span>
            <?php  endif;?>
          </div>
        <div class="_stats sesbasic_text_light"> 
         <?php if(isset($this->ratingActive)):?>
            <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_rating.tpl';?>
          <?php  endif; ?>
           <?php if(isset($category) && isset($this->categoryActive)):?>
          <span><i class="far fa-folder-open"></i><span>&nbsp;<a href="<?php echo $category->getHref(); ?>"><?php echo $this->translate($category->category_name) ?></a></span>
          <?php endif;?>
          </span> 
        </div>
      <?php if($descriptionLimit):?>
        <div class="_des"><?php echo $this->string()->truncate($this->string()->stripTags($store->description), $descriptionLimit) ?></div>
        <?php endif;?>
        <?php if(isset($this->locationActive) && $store->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('estore_enable_location', 1)):?>
        <div class="_stats sesbasic_text_light _location"> <span title="<?php echo $store->location;?>"><i class="fa fa-map-marker-alt sesbasic_text_light" title="<?php echo $this->translate('Location');?>"></i> 
          <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1) && Engine_Api::_()->getApi('settings','core')->getSetting('estore.enable.map.integration', 1)):?>
          <a href="<?php echo $this->url(array('resource_id' => $store->store_id,'resource_type'=>'stores','action'=>'get-direction'), 'sesbasic_get_direction', true);?>" class="openSmoothbox"><?php echo $store->location;?></a>
          <?php else:?>
          <?php echo $store->location;?>
          <?php endif;?>
          </span> 
        </div>
        <?php endif;?>
        </div>
      </div>
</li>
