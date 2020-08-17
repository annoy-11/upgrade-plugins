<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslisting
 * @package    Seslisting
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _advlistView2.tpl  2019-04-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<li class="seslisting_list_new_full_view sesbasic_clearfix clear">
  <div class="seslisting_list_full_thumb seslisting_list_thumb seslisting_thumb">
    <?php $href = $item->getHref();$imageURL = $photoPath;?>
    <a href="<?php echo $href; ?>" data-url = "<?php echo $item->getType() ?>" class="<?php echo $item->getType() != 'seslisting_chanel' ? 'seslisting_thumb_img' : 'seslisting_thumb_nolightbox' ?>">
    <!--<span style="background-image:url(<?php echo $imageURL; ?>);"></span>-->
    <img src="<?php echo $imageURL; ?>" alt="" align="left" /></a>
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
        <div class="seslisting_grid_btns"> 
          <?php if(isset($this->socialSharingActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.sharing', 1)):?>
            
            <?php if($this->socialshare_icon_limit): ?>
              <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
            <?php else: ?>
              <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_listview4plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_listview4limit)); ?>
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
    <div class="seslisting_list_full_view_info">
    <div class="seslisting_list_new_full_view_meta">
      <ul>       			
        <?php if(isset($this->byActive)){ ?>
         <li class="seslisting_list_new_full_view_meta_owner">
            <div class="seslisting_list_stats sesbasic_text_dark">
              <?php $owner = $item->getOwner(); ?>
              <span>
                <?php echo $this->htmlLink($item->getOwner()->getParent(), $this->itemPhoto($item->getOwner()->getParent(), 'thumb.icon')); ?>
                <?php echo $this->translate("by") ?> <?php echo $this->htmlLink($owner->getHref(),$owner->getTitle() ) ?>
              </span>
            </div>
          </li>
        <?php } ?>
        <?php if(isset($this->categoryActive)){ ?>
          <li class="seslisting_list_new_full_view_meta_category">
            <?php if($item->category_id != '' && intval($item->category_id) && !is_null($item->category_id)):?> 
              <?php $categoryItem = Engine_Api::_()->getItem('seslisting_category', $item->category_id);?>
              <?php if($categoryItem):?>
                <div class="seslisting_list_stats sesbasic_text_dark">
                  <span>
                    <i class="fa fa-folder-open" title="<?php echo $this->translate('Category'); ?>"></i> 
                    <a href="<?php echo $categoryItem->getHref(); ?>"><?php echo $categoryItem->category_name; ?></a>
                  </span>
                </div>
              <?php endif;?>
            <?php endif;?>
          </li>
        <?php } ?>
       	<?php if(isset($this->locationActive) && isset($item->location) && $item->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.location', 1)){ ?>
        	<li class="seslisting_list_new_full_view_meta_location">
            <div class="seslisting_list_stats sesbasic_text_dark seslisting_list_location">
              <span>
              <i class="fa fa-map-marker"></i><a href="<?php echo $this->url(array('resource_id' => $item->listing_id,'resource_type'=>'seslisting','action'=>'get-direction'), 'sesbasic_get_direction', true) ;?>" class="opensmoothboxurl" title="<?php echo $item->location;?>"><?php echo $item->location;?></a>
              </span>
            </div>
          </li>
        <?php } ?>
      </ul>
    </div>
    <?php  if(isset($this->titleActive)): ?>
      <div class="seslisting_list_info_title">
        <?php if(strlen($item->getTitle()) > $this->title_truncation_list):?>
          <?php $title = mb_substr($item->getTitle(),0,$this->title_truncation_list).'...';?>
            <?php echo $this->htmlLink($item->getHref(),$title,array('title'=>$item->getTitle()));?>
          <?php else: ?>
            <?php echo $this->htmlLink($item->getHref(),$item->getTitle(),array('title'=>$item->getTitle())  ) ?>
        <?php endif;?>
      </div>
    <?php endif; ?>  
    <div class="seslisting_list_new_full_contant_listing">
      <?php if(isset($this->descriptionlistActive)){ ?>
        <div class="seslisting_list_des">
          <?php echo $item->getDescription($this->description_truncation_list);?>
        </div>
      <?php } ?>
    </div>
    <div class="seslisting_list_new_full_stats">
      <div class="seslisting_list_stats floatL">
        <ul>
          <?php if(isset($this->likeActive) && isset($item->like_count)) { ?>
            <li title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count)); ?>"> LIKES <?php echo $item->like_count; ?>&nbsp; / &nbsp;</li>
          <?php } ?>
          <?php if(isset($this->commentActive) && isset($item->comment_count)) { ?>
            <li title="<?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber($item->comment_count))?>">COM <?php echo $item->comment_count;?>&nbsp; / &nbsp;</li>
          <?php } ?>
          <?php if(isset($this->favouriteActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.favourite', 1)) { ?>
            <li title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count))?>">FAV <?php echo $item->favourite_count;?>&nbsp; / &nbsp;</li>
          <?php } ?>
          <?php if(isset($this->viewActive) && isset($item->view_count)) { ?>
            <li title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count))?>">VIEW <?php echo $item->view_count; ?> </li>
          <?php } ?>
        </ul>
      </div>
      <div class="seslisting_list_socialicon floatR">
        <ul>
          <?php if(isset($this->socialSharingActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.sharing', 1)):?>
            <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'param' => 'photoviewpage', 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>

          <?php endif;?>
        </ul>
      </div>
       <div class="seslisting_list_divider"></div>
    </div>
  </div>
</li>
