<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecipe
 * @package    Sesrecipe
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _advlistView2.tpl 2018-05-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<li class="sesrecipe_list_new_full_view sesbasic_clearfix clear">
  <div class="sesrecipe_list_full_thumb sesrecipe_list_thumb sesrecipe_thumb">
    <?php $href = $item->getHref();$imageURL = $photoPath;?>
    <a href="<?php echo $href; ?>" data-url = "<?php echo $item->getType() ?>" class="<?php echo $item->getType() != 'sesrecipe_chanel' ? 'sesrecipe_thumb_img' : 'sesrecipe_thumb_nolightbox' ?>">
    <!--<span style="background-image:url(<?php echo $imageURL; ?>);"></span>-->
    <img src="<?php echo $imageURL; ?>" alt="" align="left" /></a>
    <?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) || isset($this->verifiedLabelActive)):?>
      <div class="sesrecipe_list_labels">
        <?php if(isset($this->featuredLabelActive) && $item->featured == 1):?>
          <p class="sesrecipe_label_featured"><?php echo $this->translate('FEATURED');?></p>
        <?php endif;?>
        <?php if(isset($this->sponsoredLabelActive) && $item->sponsored == 1):?>
          <p class="sesrecipe_label_sponsored"><?php echo $this->translate('SPONSORED');?></p>
        <?php endif;?>
      </div>
      <?php if(isset($this->verifiedLabelActive) && $item->verified == 1):?>
        <div class="sesrecipe_verified_label" title="<?php echo $this->translate('VERIFIED');?>"><i class="fa fa-check"></i></div>
      <?php endif;?>
    <?php endif;?>
    <?php if((isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.sharing', 1)) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive)):?>
      <?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref()); ?>
      <div class="sesrecipe_list_thumb_over">
        <a href="<?php echo $href; ?>" data-url = "<?php echo $item->getType() ?>"></a>
        <div class="sesrecipe_grid_btns"> 
          <?php if(isset($this->socialSharingActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.sharing', 1)):?>
            
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
              <?php $LikeStatus = Engine_Api::_()->sesrecipe()->getLikeStatus($item->recipe_id,$item->getType()); ?>
              <a href="javascript:;" data-url="<?php echo $item->recipe_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sesrecipe_like_sesrecipe_recipe_<?php echo $item->recipe_id ?> sesrecipe_like_sesrecipe_recipe <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $item->like_count; ?></span></a>
            <?php endif;?>
            <?php if(isset($this->favouriteButtonActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.favourite', 1)): ?>
            <?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'sesrecipe')->isFavourite(array('resource_type'=>'sesrecipe_recipe','resource_id'=>$item->recipe_id)); ?>
              <a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn sesrecipe_favourite_sesrecipe_recipe_<?php echo $item->recipe_id ?> sesrecipe_favourite_sesrecipe_recipe <?php echo ($favStatus)  ? 'button_active' : '' ?>"  data-url="<?php echo $item->recipe_id ; ?>"><i class="fa fa-heart"></i><span><?php echo $item->favourite_count; ?></span></a>
            <?php endif;?>
          <?php endif;?>
        </div>
      </div>
    <?php endif;?> 
    </div>
    <div class="sesrecipe_list_full_view_info">
    <div class="sesrecipe_list_new_full_view_meta">
      <ul>       			
        <?php if(isset($this->byActive)){ ?>
         <li class="sesrecipe_list_new_full_view_meta_owner">
            <div class="sesrecipe_list_stats sesbasic_text_dark">
              <?php $owner = $item->getOwner(); ?>
              <span>
                <?php echo $this->htmlLink($item->getOwner()->getParent(), $this->itemPhoto($item->getOwner()->getParent(), 'thumb.icon')); ?>
                <?php echo $this->translate("by") ?> <?php echo $this->htmlLink($owner->getHref(),$owner->getTitle() ) ?>
              </span>
            </div>
          </li>
        <?php } ?>
        <?php if(isset($this->categoryActive)){ ?>
          <li class="sesrecipe_list_new_full_view_meta_category">
            <?php if($item->category_id != '' && intval($item->category_id) && !is_null($item->category_id)):?> 
              <?php $categoryItem = Engine_Api::_()->getItem('sesrecipe_category', $item->category_id);?>
              <?php if($categoryItem):?>
                <div class="sesrecipe_list_stats sesbasic_text_dark">
                  <span>
                    <i class="fa fa-folder-open" title="<?php echo $this->translate('Category'); ?>"></i> 
                    <a href="<?php echo $categoryItem->getHref(); ?>"><?php echo $categoryItem->category_name; ?></a>
                  </span>
                </div>
              <?php endif;?>
            <?php endif;?>
          </li>
        <?php } ?>
       	<?php if(isset($this->locationActive) && isset($item->location) && $item->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.location', 1)){ ?>
        	<li class="sesrecipe_list_new_full_view_meta_location">
            <div class="sesrecipe_list_stats sesbasic_text_dark sesrecipe_list_location">
              <span>
              <i class="fa fa-map-marker"></i><?php include APPLICATION_PATH .  '/application/modules/Sesrecipe/views/scripts/_location_direction.tpl';?>
              </span>
            </div>
          </li>
        <?php } ?>
      </ul>
    </div>
    <?php  if(isset($this->titleActive)): ?>
      <div class="sesrecipe_list_info_title">
        <?php if(strlen($item->getTitle()) > $this->title_truncation_list):?>
          <?php $title = mb_substr($item->getTitle(),0,$this->title_truncation_list).'...';?>
            <?php echo $this->htmlLink($item->getHref(),$title,array('title'=>$item->getTitle()));?>
          <?php else: ?>
            <?php echo $this->htmlLink($item->getHref(),$item->getTitle(),array('title'=>$item->getTitle())  ) ?>
        <?php endif;?>
      </div>
    <?php endif; ?>  
    <div class="sesrecipe_list_new_full_contant_recipe">
      <?php if(isset($this->descriptionlistActive)){ ?>
        <div class="sesrecipe_list_des">
          <?php echo $this->string()->truncate($this->string()->stripTags($item->body), $this->description_truncation_list) ?>
        </div>
      <?php } ?>
    </div>
    <div class="sesrecipe_list_new_full_stats">
      <div class="sesrecipe_list_stats floatL">
        <ul>
          <?php if(isset($this->likeActive) && isset($item->like_count)) { ?>
            <li title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count)); ?>"> LIKES <?php echo $item->like_count; ?>&nbsp; / &nbsp;</li>
          <?php } ?>
          <?php if(isset($this->commentActive) && isset($item->comment_count)) { ?>
            <li title="<?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber($item->comment_count))?>">COM <?php echo $item->comment_count;?>&nbsp; / &nbsp;</li>
          <?php } ?>
          <?php if(isset($this->favouriteActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.favourite', 1)) { ?>
            <li title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count))?>">FAV <?php echo $item->favourite_count;?>&nbsp; / &nbsp;</li>
          <?php } ?>
          <?php if(isset($this->viewActive) && isset($item->view_count)) { ?>
            <li title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count))?>">VIEW <?php echo $item->view_count; ?> </li>
          <?php } ?>
        </ul>
      </div>
      <div class="sesrecipe_list_socialicon floatR">
        <ul>
          <?php if(isset($this->socialSharingActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.sharing', 1)):?>
            <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'param' => 'photoviewpage', 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>

          <?php endif;?>
        </ul>
      </div>
       <div class="sesrecipe_list_divider"></div>
    </div>
  </div>
</li>
