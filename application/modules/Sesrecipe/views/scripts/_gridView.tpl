<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecipe
 * @package    Sesrecipe
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _gridView.tpl 2018-05-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>

<li class="sesrecipe_grid sesbasic_bxs <?php if((isset($this->my_recipes) && $this->my_recipes)){ ?>isoptions<?php } ?>" style="width:<?php echo is_numeric($this->width_grid) ? $this->width_grid.'px' : $this->width_grid ?>;">
  <div class="sesrecipe_grid_inner sesrecipe_thumb">
    <div class="sesrecipe_grid_thumb" style="height:<?php echo is_numeric($this->height_grid) ? $this->height_grid.'px' : $this->height_grid ?>;">
      <?php $href = $item->getHref();$imageURL = $photoPath;?>
      <a href="<?php echo $href; ?>" data-url = "<?php echo $item->getType() ?>" class="sesrecipe_thumb_img"> <span style="background-image:url(<?php echo $imageURL; ?>);"></span> </a>
      <?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) || isset($this->verifiedLabel)):?>
      <div class="sesrecipe_grid_labels">
        <?php if(isset($this->featuredLabelActive) && $item->featured == 1):?>
        <p class="sesrecipe_label_featured"><?php echo $this->translate('FEATURED');?></p>
        <?php endif;?>
        <?php if(isset($this->sponsoredLabelActive) && $item->sponsored == 1):?>
        <p class="sesrecipe_label_sponsored"><?php echo $this->translate('SPONSORED');?></p>
        <?php endif;?>
      </div>
      <?php endif;?>
      <?php if(isset($this->verifiedLabelActive) && $item->verified == 1):?>
      <div class="sesrecipe_grid_verified_label" title="<?php echo $this->translate('VERIFIED');?>"><i class="fa fa-check"></i></div>
      <?php endif;?>
      <?php if(isset($this->categoryActive)){ ?>
      <?php if($item->category_id != '' && intval($item->category_id) && !is_null($item->category_id)):?>
      <?php $categoryItem = Engine_Api::_()->getItem('sesrecipe_category', $item->category_id);?>
      <?php if($categoryItem):?>
      <div class="sesrecipe_grid_memta_title">
        <?php $categoryItem = Engine_Api::_()->getItem('sesrecipe_category', $item->category_id);?>
        <?php if($categoryItem):?>
        <span> <a href="<?php echo $categoryItem->getHref(); ?>"><?php echo $categoryItem->category_name; ?></a> </span>
        <?php endif;?>
      </div>
      <?php endif;?>
      <?php endif;?>
      <?php } ?>
    </div>
    <div class="sesrecipe_grid_info clear clearfix sesbm">
      <?php if(Engine_Api::_()->getApi('core', 'sesrecipe')->allowReviewRating() && isset($this->ratingStarActive)):?>
      <?php echo $this->partial('_recipeRating.tpl', 'sesrecipe', array('rating' => $item->rating, 'class' => 'sesrecipe_list_rating sesrecipe_list_view_ratting floatR', 'style' => ''));?>
      <?php endif;?>
      <?php if(isset($this->titleActive) ){ ?>
      <div class="sesrecipe_grid_info_title">
        <?php if(strlen($item->getTitle()) > $this->title_truncation_grid):?>
        <?php $title = mb_substr($item->getTitle(),0,$this->title_truncation_grid).'...';?>
        <?php echo $this->htmlLink($item->getHref(),$title,array('title'=>$item->getTitle()) ) ?>
        <?php else: ?>
        <?php echo $this->htmlLink($item->getHref(),$item->getTitle(),array('title'=>$item->getTitle())  ) ?>
        <?php endif; ?>
      </div>
      <?php } ?>
      <div class="sesrecipe_grid_meta_block">
        <?php if(isset($this->byActive)){ ?>
        <div class="sesrecipe_list_stats sesbasic_text_light"> <span>
          <?php $owner = $item->getOwner(); ?>
          <?php echo $this->htmlLink($item->getOwner()->getParent(), $this->itemPhoto($item->getOwner()->getParent(), 'thumb.icon')); ?> <?php echo $this->translate("by") ?> <?php echo $this->htmlLink($owner->getHref(),$owner->getTitle() ) ?>&nbsp;| </span> </div>
        <?php } ?>
        <?php if(isset($this->creationDateActive)): ?>
        <div class="sesrecipe_list_stats sesbasic_text_light"> <span><i class=" fa fa-clock-o"></i> 						<?php if($item->publish_date): ?>
              <?php echo date('M d, Y',strtotime($item->publish_date));?>
						<?php else: ?>
              <?php echo date('M d, Y',strtotime($item->creation_date));?>
						<?php endif; ?>&nbsp;|</span> </div>
        <?php endif;?>
        <?php if(isset($this->locationActive) && isset($item->location) && $item->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.location', 1)){ ?>
        <div class="sesrecipe_list_stats sesrecipe_list_location sesbasic_text_light"> <span> <i class="fa fa-map-marker"></i> <?php include APPLICATION_PATH .  '/application/modules/Sesrecipe/views/scripts/_location_direction.tpl';?> </span> </div>
        <?php } ?>
      </div>
    </div>
    <div class="sesrecipe_grid_hover_block">
      <div class="sesrecipe_grid_info_hover_title">
        <?php if(isset($this->titleActive)): ?>
        <?php if(strlen($item->getTitle()) > $this->title_truncation_grid):?>
        <?php $title = mb_substr($item->getTitle(),0,$this->title_truncation_grid).'...';?>
        <?php echo $this->htmlLink($item->getHref(),$title,array('title'=>$item->getTitle()) ) ?>
        <?php else: ?>
        <?php echo $this->htmlLink($item->getHref(),$item->getTitle(),array('title'=>$item->getTitle())  ) ?>
        <?php endif; ?>
        <span></span>
        <?php endif;?>
      </div>
      <div class="sesrecipe_grid_meta_block">
        <?php if(isset($this->byActive)){ ?>
        <div class="sesrecipe_list_stats sesbasic_text_light"> <span>
          <?php $owner = $item->getOwner(); ?>
          <?php echo $this->htmlLink($item->getOwner()->getParent(), $this->itemPhoto($item->getOwner()->getParent(), 'thumb.icon')); ?> <?php echo $this->translate("by") ?> <?php echo $this->htmlLink($owner->getHref(),$owner->getTitle() ) ?>&nbsp;| </span> </div>
        <?php } ?>
        <?php if(isset($this->creationDateActive)): ?>
        <div class="sesrecipe_list_stats sesbasic_text_light"> <span><i class=" fa fa-clock-o"></i> <?php echo date('M d',strtotime($item->publish_date));?></span> </div>
        <?php endif;?>

      </div>
        <?php if(isset($this->locationActive) && isset($item->location) && $item->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.location', 1)){ ?>
        <div class="sesrecipe_list_stats sesrecipe_list_location sesbasic_text_light"> <span> <i class="fa fa-map-marker"></i> <?php include APPLICATION_PATH .  '/application/modules/Sesrecipe/views/scripts/_location_direction.tpl';?> </span> </div>
        <?php } ?>
      <?php  if(isset($this->descriptiongridActive)){?>
      <div class="sesrecipe_grid_des clear"> <?php echo $this->string()->truncate($this->string()->stripTags($item->body), $this->description_truncation_grid) ?> </div>
      <?php } ?>
      <div class="sesrecipe_grid_hover_block_footer">
        <div class="sesrecipe_list_stats sesbasic_text_light">
          <?php if(isset($this->likeActive) && isset($item->like_count)) { ?>
          <span title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count)); ?>"><i class="fa fa-thumbs-up"></i><?php echo $item->like_count; ?></span>
          <?php } ?>
          <?php if(isset($this->commentActive) && isset($item->comment_count)) { ?>
          <span title="<?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber($item->comment_count))?>"><i class="fa fa-comment"></i><?php echo $item->comment_count;?></span>
          <?php } ?>
          <?php if(isset($this->favouriteActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.favourite', 1)) { ?>
          <span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count))?>"><i class="fa fa-heart"></i><?php echo $item->favourite_count;?></span>
          <?php } ?>
          <?php if(isset($this->viewActive) && isset($item->view_count)) { ?>
          <span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count))?>"><i class="fa fa-eye"></i><?php echo $item->view_count; ?></span>
          <?php } ?>
          <?php include APPLICATION_PATH .  '/application/modules/Sesrecipe/views/scripts/_recipeRatingStat.tpl';?>
        </div>
        <?php if(isset($this->readmoreActive)):?>
        <div class="sesrecipe_grid_read_btn floatR"><a href="<?php echo $href; ?>"><?php echo $this->translate('Read More...');?></a></div>
        <?php endif;?>
      </div>
    </div>
    <?php if((isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.sharing', 1)) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive)):?>
    <?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref()); ?>
    <div class="sesrecipe_list_thumb_over"> <a href="<?php echo $href; ?>" data-url = "<?php echo $item->getType() ?>"></a>
      <div class="sesrecipe_list_grid_thumb_btns">
        <?php if(isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.sharing', 1)):?>
        
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
</li>
