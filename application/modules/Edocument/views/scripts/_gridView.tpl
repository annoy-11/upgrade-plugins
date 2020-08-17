<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Edocument
 * @package    Edocument
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _gridView.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>

<li class="edocument_grid sesbasic_bxs <?php if((isset($this->my_documents) && $this->my_documents)){ ?>isoptions<?php } ?>" style="width:<?php echo is_numeric($this->width_grid) ? $this->width_grid.'px' : $this->width_grid ?>;">
  <div class="edocument_grid_inner edocument_thumb">
    <div class="edocument_grid_thumb" style="height:<?php echo is_numeric($this->height_grid) ? $this->height_grid.'px' : $this->height_grid ?>;">
      <?php $href = $item->getHref();$imageURL = $photoPath;?>
      <a href="<?php echo $href; ?>" data-url = "<?php echo $item->getType() ?>" class="edocument_thumb_img"> <span style="background-image:url(<?php echo $imageURL; ?>);"></span> </a>
      <?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) || isset($this->verifiedLabel)):?>
      <div class="edocument_grid_labels">
        <?php if(isset($this->featuredLabelActive) && $item->featured == 1):?>
        <p class="edocument_label_featured"><i class='fa fa-star'></i></p>
        <?php endif;?>
        <?php if(isset($this->sponsoredLabelActive) && $item->sponsored == 1):?>
        <p class="edocument_label_sponsored"><i class='fa fa-star'></i></p>
        <?php endif;?>
      </div>
      <?php endif;?>
      <div class="edcoument_type"> <span><img src="application/modules/Edocument/externals/images/types/doc.png" /></span> </div>
      <div class="edocument_grid_hover_block">
        <?php if((isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('edocument.enable.sharing', 1)) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive)):?>
        <?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref()); ?>
        <div class="edocument_list_thumb_over"> <a href="<?php echo $href; ?>" data-url = "<?php echo $item->getType() ?>"></a>
          <div class="edocument_list_grid_thumb_btns">
            <?php if(isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('edocument.enable.sharing', 1)):?>
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
            <?php $LikeStatus = Engine_Api::_()->edocument()->getLikeStatus($item->edocument_id,$item->getType()); ?>
            <a href="javascript:;" data-url="<?php echo $item->edocument_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn edocument_like_edocument_<?php echo $item->edocument_id ?> edocument_like_edocument <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $item->like_count; ?></span></a>
            <?php endif;?>
            <?php if(isset($this->favouriteButtonActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('edocument.enable.favourite', 1)): ?>
            <?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'edocument')->isFavourite(array('resource_type'=>'edocument','resource_id'=>$item->edocument_id)); ?>
            <a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn edocument_favourite_edocument_<?php echo $item->edocument_id ?> edocument_favourite_edocument <?php echo ($favStatus)  ? 'button_active' : '' ?>"  data-url="<?php echo $item->edocument_id ; ?>"><i class="fa fa-heart"></i><span><?php echo $item->favourite_count; ?></span></a>
            <?php endif;?>
            <?php endif;?>
          </div>
        </div>
        <?php endif;?>
        <div class="edocument_grid_meta_block">
          <?php if(isset($this->creationDateActive)): ?>
          <div class="edocument_list_stats sesbasic_text_light"> <span><i class=" fa fa-clock-o"></i> <?php echo date('M d',strtotime($item->publish_date));?></span> </div>
          <?php endif;?>
          <?php if(isset($this->locationActive) && isset($item->location) && $item->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('edocument.enable.location', 1)){ ?>
          <div class="edocument_list_stats edocument_list_location sesbasic_text_light"> <span> <i class="fa fa-map-marker"></i> <a href="<?php echo $this->url(array('resource_id' => $item->edocument_id,'resource_type'=>'edocument','action'=>'get-direction'), 'sesbasic_get_direction', true) ;?>" class="opensmoothboxurl" title="<?php echo $item->location;?>"><?php echo $item->location;?></a> </span> </div>
          <?php } ?>
        </div>
        <div class="edocument_grid_hover_block_footer">
          <div class="edocument_list_stats sesbasic_text_light">
            <?php if(isset($this->likeActive) && isset($item->like_count)) { ?>
            <span title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count)); ?>"><i class="sesbasic_icon_like_o"></i><?php echo $item->like_count; ?></span>
            <?php } ?>
            <?php if(isset($this->commentActive) && isset($item->comment_count)) { ?>
            <span title="<?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber($item->comment_count))?>"><i class="sesbasic_icon_comment_o"></i><?php echo $item->comment_count;?></span>
            <?php } ?>
            <?php if(isset($this->favouriteActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('edocument.enable.favourite', 1)) { ?>
            <span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count))?>"><i class="sesbasic_icon_favourite_o"></i><?php echo $item->favourite_count;?></span>
            <?php } ?>
            <?php if(isset($this->viewActive) && isset($item->view_count)) { ?>
            <span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count))?>"><i class="sesbasic_icon_view"></i><?php echo $item->view_count; ?></span>
            <?php } ?>
            <?php include APPLICATION_PATH .  '/application/modules/Edocument/views/scripts/_documentRatingStat.tpl';?>
          </div>
        </div>
        <?php if(isset($this->readmoreActive)):?>
        <div class="edocument_grid_read_btn"><a href="<?php echo $href; ?>"><?php echo $this->translate('View');?></a></div>
        <?php endif;?>
      </div>
      <?php if(isset($this->verifiedLabelActive) && $item->verified == 1):?>
      <div class="edocument_grid_verified_label" title="<?php echo $this->translate('VERIFIED');?>"><i class="fa fa-check"></i></div>
      <?php endif;?>
      <?php if(isset($this->categoryActive)){ ?>
      <?php if($item->category_id != '' && intval($item->category_id) && !is_null($item->category_id)):?>
      <?php $categoryItem = Engine_Api::_()->getItem('edocument_category', $item->category_id);?>
      <?php if($categoryItem):?>
      <div class="edocument_grid_memta_title">
        <?php $categoryItem = Engine_Api::_()->getItem('edocument_category', $item->category_id);?>
        <?php if($categoryItem):?>
        <span> <a href="<?php echo $categoryItem->getHref(); ?>"><?php echo $categoryItem->category_name; ?></a> </span>
        <?php endif;?>
      </div>
      <?php endif;?>
      <?php endif;?>
      <?php } ?>
    </div>
    <div class="edocument_grid_info clear clearfix sesbm">
      <?php if(Engine_Api::_()->getApi('core', 'edocument')->allowReviewRating() && isset($this->ratingStarActive)):?>
      <?php echo $this->partial('_documentRating.tpl', 'edocument', array('rating' => $item->rating, 'class' => 'edocument_list_rating edocument_list_view_ratting floatR', 'style' => ''));?>
      <?php endif;?>
      <?php if(isset($this->titleActive) ){ ?>
      <div class="edocument_grid_info_title">
        <?php if(strlen($item->getTitle()) > $this->title_truncation_grid):?>
        <?php $title = mb_substr($item->getTitle(),0,$this->title_truncation_grid).'...';?>
        <?php echo $this->htmlLink($item->getHref(),$title,array('title'=>$item->getTitle()) ) ?>
        <?php else: ?>
        <?php echo $this->htmlLink($item->getHref(),$item->getTitle(),array('title'=>$item->getTitle())  ) ?>
        <?php endif; ?>
      </div>
      <?php } ?>
      <div class="edocument_grid_meta_block">
        <?php if(isset($this->byActive)) { ?>
        <div class="edocument_list_stats sesbasic_text_light"> <span>
          <?php $owner = $item->getOwner(); ?>
          <?php echo $this->htmlLink($owner->getHref(),$owner->getTitle() ) ?></span> </div>
        <?php } ?>
      </div>
      <div class="edocument_rating_stars">
        <div class="sesbasic_rating_star"> <span class="courses_rating_star"> <span class="sesbasic_rating_star_small fa fa-star"></span> <span class="sesbasic_rating_star_small fa fa-star"></span> <span class="sesbasic_rating_star_small fa fa-star"></span> <span class="sesbasic_rating_star_small fa fa-star"></span> <span class="sesbasic_rating_star_small fa fa-star sesbasic_rating_star_small_disable"></span> <span class="course_rating"> (4/5) </span> </span> </div>
      </div>
    </div>
  </div>
</li>
