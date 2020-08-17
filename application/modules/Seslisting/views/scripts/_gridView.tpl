<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslisting
 * @package    Seslisting
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _gridView.tpl  2019-04-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $reviewCount = Engine_Api::_()->seslisting()->getTotalReviews($item->listing_id);?>

<li class="seslisting_grid sesbasic_bxs <?php if((isset($this->my_listings) && $this->my_listings)){ ?>isoptions<?php } ?>" style="width:<?php echo is_numeric($this->width_grid) ? $this->width_grid.'px' : $this->width_grid ?>;">
  <div class="seslisting_grid_inner seslisting_thumb">
    <div class="seslisting_grid_thumb" style="height:<?php echo is_numeric($this->height_grid) ? $this->height_grid.'px' : $this->height_grid ?>;">
      <?php $href = $item->getHref();$imageURL = $photoPath;?>
      <a href="<?php echo $href; ?>" data-url = "<?php echo $item->getType() ?>" class="seslisting_thumb_img"> <span style="background-image:url(<?php echo $imageURL; ?>);"></span> </a>
      <?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) || isset($this->verifiedLabel)):?>
      <div class="seslisting_grid_labels">
        <?php if(isset($this->featuredLabelActive) && $item->featured == 1):?>
        <p class="seslisting_label_featured"><?php echo $this->translate('FEATURED');?></p>
        <?php endif;?>
        <?php if(isset($this->sponsoredLabelActive) && $item->sponsored == 1):?>
        <p class="seslisting_label_sponsored"><?php echo $this->translate('SPONSORED');?></p>
        <?php endif;?>
      </div>
      <?php endif;?>
    </div>
    <div class="seslisting_grid_info clear clearfix sesbm">
      <?php if(isset($this->categoryActive)){ ?>
      <?php if($item->category_id != '' && intval($item->category_id) && !is_null($item->category_id)):?>
      <?php $categoryItem = Engine_Api::_()->getItem('seslisting_category', $item->category_id);?>
      <?php if($categoryItem):?>
      <div class="seslisting_grid_memta_title">
        <?php $categoryItem = Engine_Api::_()->getItem('seslisting_category', $item->category_id);?>
        <?php if($categoryItem):?>
        <span> <a href="<?php echo $categoryItem->getHref(); ?>"><?php echo $categoryItem->category_name; ?></a> </span>
        <?php endif;?>
        <div class="seslisting_footer_two_listing">
    <?php if(isset($this->ratingActive)):?>
        <div class="sesbasic_rating_star">
          <?php $ratingCount = $item->rating; $x=0; ?>
          <?php if( $ratingCount > 0 ): ?>
            <?php for( $x=1; $x<=$ratingCount; $x++ ): ?>
              <span id="" class="seslisting_rating_star"></span>
            <?php endfor; ?>
            <?php if( (round($ratingCount) - $ratingCount) > 0){ ?>
            <span class="seslisting_rating_star seslisting_rating_star_half"></span>
            <?php }else{ $x = $x - 1;} ?>
            <?php if($x < 5){ 
            for($j = $x ; $j < 5;$j++){ ?>
            <span class="seslisting_rating_star seslisting_rating_star_disable"></span>
            <?php }     
            } ?>
          <?php endif; ?>
        </div>
      <?php endif;?>
       </div>
      </div>
      <?php endif;?>
      <?php endif;?>
      <?php } ?>
      <?php if(isset($this->titleActive) ){ ?>
      <div class="seslisting_grid_info_title">
        <?php if(strlen($item->getTitle()) > $this->title_truncation_grid):?>
        <?php $title = mb_substr($item->getTitle(),0,$this->title_truncation_grid).'...';?>
        <?php echo $this->htmlLink($item->getHref(),$title,array('title'=>$item->getTitle()) ) ?>
        <?php else: ?>
        <?php echo $this->htmlLink($item->getHref(),$item->getTitle(),array('title'=>$item->getTitle())  ) ?>
        <?php endif; ?>
        <?php if(isset($this->verifiedLabelActive) && $item->verified == 1):?>
      <div class="seslisting_grid_verified_label" title="<?php echo $this->translate('VERIFIED');?>"><i class="fa fa-check"></i></div>
      <?php endif;?>
      </div>
      <?php } ?>
      <?php if(isset($this->priceActive) ){ ?>
      <div class="seslisting_list_grid_price">
        <?php echo Engine_Api::_()->seslisting()->getCurrencyPrice($item->price); ?>
      </div>
      <?php } ?>
      <div class="seslisting_grid_meta_block">
        <?php if(isset($this->byActive)){ ?>
        <div class="seslisting_list_stats sesbasic_text_light"> <span>
          
          <?php echo $this->translate("<i class='fa fa-user'></i>") ?> <?php $owner = $item->getOwner(); ?><?php echo $this->htmlLink($owner->getHref(),$owner->getTitle() ) ?></span> </div>
        <?php } ?>
        <?php if(isset($this->locationActive) && isset($item->location) && $item->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.location', 1)){ ?>
        <div class="seslisting_list_stats seslisting_list_location sesbasic_text_light"> <span> <i class="fa fa-map-marker"></i> <a href="<?php echo $this->url(array('resource_id' => $item->listing_id,'resource_type'=>'seslisting_listing','action'=>'get-direction'), 'sesbasic_get_direction', true) ;?>" class="opensmoothboxurl" title="<?php echo $item->location;?>"><?php echo $item->location;?></a> </span> </div>
        <?php } ?>
      </div>
    </div>
    <?php if((isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.sharing', 1)) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive)):?>
    <?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref()); ?>
    <div class="seslisting_list_thumb_over"> <a href="<?php echo $href; ?>" data-url = "<?php echo $item->getType() ?>"></a>
      <div class="seslisting_list_grid_thumb_btns">
        <?php if(isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.sharing', 1)):?>
        
        <?php if($this->socialshare_icon_limit): ?>
          <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
        <?php else: ?>
          <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_gridview1plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_gridview1limit)); ?>
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
</li>
