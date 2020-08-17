<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslisting
 * @package    Seslisting
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _gridView2.tpl  2019-04-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<li class="seslisting_new_grid" style="width:<?php echo is_numeric($this->width_advgrid2) ? $this->width_advgrid2.'px' : $this->width_advgrid2 ?>;">
  <div class="seslisting_new_grid_inner seslisting_thumb">
    <div class="seslisting_grid_thumb" style="height:<?php echo is_numeric($this->height_advgrid2) ? $this->height_advgrid2.'px' : $this->height_advgrid2 ?>;">
      <?php $href = $item->getHref();$imageURL = $photoPath;?>
      <a href="<?php echo $href; ?>" data-url = "<?php echo $item->getType() ?>" class="seslisting_thumb_img">
      	<img src="<?php echo $imageURL; ?>" alt="" align="left" />
      </a>
      <?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) || isset($this->verifiedLabelActive)):?>
      <div class="seslisting_list_labels">
        <?php if(isset($this->featuredLabelActive) && $item->featured == 1):?>
          <p class="seslisting_label_featured"><?php echo $this->translate('FEATURED');?></p>
        <?php endif;?>
        <?php if(isset($this->sponsoredLabelActive) && $item->sponsored == 1):?>
          <p class="seslisting_label_sponsored"><?php echo $this->translate('SPONSORED');?></p>
        <?php endif;?>
      </div>
      <?php if(isset($this->verifiedLabelActive) && $item->verified == 1):?>
        <div class="seslisting_verified_label" title="<?php echo $this->translate('VERIFIED');?>"><i class="fa fa-check"></i></div>
      <?php endif;?>
    <?php endif;?>
      <?php if((isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.sharing', 1)) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive)):?>
        <?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref()); ?>
        <div class="seslisting_list_thumb_over">
          <a href="<?php echo $href; ?>" data-url = "<?php echo $item->getType() ?>"></a>
          <div class="seslisting_list_grid_thumb_btns"> 
            <?php if(isset($this->socialSharingActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.sharing', 1)):?>
                
              <?php if($this->socialshare_icon_limit): ?>
                <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
              <?php else: ?>
                <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_gridview4plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_gridview4limit)); ?>
              <?php endif; ?>
              
              
            <?php endif;?>
            <?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 ):?>
              <?php $canComment =  $item->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');?>
              <?php if(isset($this->likeButtonActive) && $canComment):?>
                <!--Like Button-->
                <?php $LikeStatus = Engine_Api::_()->seslisting()->getLikeStatus($item->listing_id,$item->getType()); ?>
                <a href="javascript:;" data-url="<?php echo $item->listing_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn seslisting_like_seslisting_listing_<?php echo $item->listing_id ?> seslisting_like_seslisting_listing <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $item->like_count; ?></span></a>
              <?php endif;?>
              <?php if(isset($this->favouriteButtonActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.favourite', 1)): ?>
              <?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'seslisting')->isFavourite(array('resource_type'=>'seslisting','resource_id'=>$item->listing_id)); ?>
                <a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn seslisting_favourite_seslisting_listing_<?php echo $item->listing_id ?> seslisting_favourite_seslisting_listing <?php echo ($favStatus)  ? 'button_active' : '' ?>"  data-url="<?php echo $item->listing_id ; ?>"><i class="fa fa-heart"></i><span><?php echo $item->favourite_count; ?></span></a>
              <?php endif;?>
            <?php endif;?>
          </div>
        </div>
      <?php endif;?> 
    </div>
  </div>
  <div class="seslisting_grid_info">
    <?php if(isset($this->categoryActive)){ ?>
    	<div class="seslisting_new_grid_category_title">
        <?php if($item->category_id != '' && intval($item->category_id) && !is_null($item->category_id)):?>
          <?php $categoryItem = Engine_Api::_()->getItem('seslisting_category', $item->category_id);?>
          <?php if($categoryItem):?>
            <?php $categoryItem = Engine_Api::_()->getItem('seslisting_category', $item->category_id);?>
            <?php if($categoryItem):?>
              <a href="<?php echo $categoryItem->getHref(); ?>"><?php echo $categoryItem->category_name; ?></a>
            <?php endif;?>
          <?php endif;?>
        <?php endif;?>
    	</div>
    <?php } ?>
    <?php if(isset($this->titleActive) ){ ?>
    	<div class="seslisting_gird_title">
        <?php if(strlen($item->getTitle()) > $this->title_truncation_advgrid2):?>
        <?php $title = mb_substr($item->getTitle(),0,$this->title_truncation_advgrid2).'...';?>
        <?php echo $this->htmlLink($item->getHref(),$title,array('title'=>$item->getTitle()) ) ?>
        <?php else: ?>
        <?php echo $this->htmlLink($item->getHref(),$item->getTitle(),array('title'=>$item->getTitle())  ) ?>
        <?php endif; ?>
      </div>
    <?php } ?>
    <div class="seslisting_grid_meta_tegs">
      <ul>
      	<?php if(isset($this->byActive)){ ?>
        	<li class="seslisting_grid_meta_owner">
          	<div class="seslisting_list_stats sesbasic_text_light"> <span>
            	<?php $owner = $item->getOwner(); ?>
            	<?php echo $this->htmlLink($item->getOwner()->getParent(), $this->itemPhoto($item->getOwner()->getParent(), 'thumb.icon')); ?> <?php echo $this->translate("by") ?> <?php echo $this->htmlLink($owner->getHref(),$owner->getTitle() ) ?> </span>
            </div>
        	</li>
        <?php } ?>
        <?php if(isset($this->creationDateActive)): ?>
        	<li class="seslisting_grid_meta_date">
          	<div class="seslisting_list_stats sesbasic_text_light"> <span><i class=" fa fa-clock-o"></i> 						<?php if($item->publish_date): ?>
              <?php echo date('M d, Y',strtotime($item->publish_date));?>
						<?php else: ?>
              <?php echo date('M d, Y',strtotime($item->creation_date));?>
						<?php endif; ?></span> </div>
        	</li>
        <?php endif;?>
        <?php if(isset($this->locationActive) && isset($item->location) && $item->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.location', 1)){ ?>
          <li class="seslisting_grid_meta_location">
          	<div class="seslisting_list_stats seslisting_list_location sesbasic_text_light"> <span> <i class="fa fa-map-marker"></i> <a href="<?php echo $this->url(array('resource_id' => $item->listing_id,'resource_type'=>'seslisting','action'=>'get-direction'), 'sesbasic_get_direction', true) ;?>" class="opensmoothboxurl" title="<?php echo $item->location;?>"><?php echo $item->location;?></a> </span> </div>
          </li>
      	<?php } ?>
      </ul>
    </div>
    <?php  if(isset($this->descriptiongrid2Active)){?>
      <div class="seslisting_grid_contant">
        <?php echo $item->getDescription($this->description_truncation_advgrid2);?>
      </div>
    <?php } ?>
    <div class="seslisting_grid_stats">
      <ul>
        <?php if(isset($this->likeActive) && isset($item->like_count)) { ?>
          <li>
          	<span title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count)); ?>"><i class="fa fa-thumbs-up"></i><?php echo $item->like_count; ?></span>
        	</li>
        <?php } ?>
       	<?php if(isset($this->commentActive) && isset($item->comment_count)) { ?>
          <li>
          	<span title="<?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber($item->comment_count))?>"><i class="fa fa-comment"></i><?php echo $item->comment_count;?></span>
        	</li>
        <?php } ?>
       	<?php if(isset($this->favouriteActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.favourite', 1)) { ?>
          <li>
          	<span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count))?>"><i class="fa fa-heart"></i><?php echo $item->favourite_count;?></span>
        	</li>
        <?php } ?>
        <?php if(isset($this->viewActive) && isset($item->view_count)) { ?>
          <li>
          	<span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count))?>"><i class="fa fa-eye"></i><?php echo $item->view_count; ?></span>
          </li>
        	<?php } ?>
         <li><?php include APPLICATION_PATH .  '/application/modules/Seslisting/views/scripts/_listingRatingStat.tpl';?></li>
      </ul>
      <p class="seslisting_grid_divider"></p>
    </div>
  </div>
</li>
