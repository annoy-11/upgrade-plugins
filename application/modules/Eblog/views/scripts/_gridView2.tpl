<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _gridView2.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>

<li class="eblog_grid_two" style="width:<?php echo is_numeric($this->width_advgrid) ? $this->width_advgrid.'px' : $this->width_advgrid ?>;">
  <article>
   <div class="eblog_grid_two_inner eblog_thumb">
    <div class="eblog_grid_thumb" style="height:<?php echo is_numeric($this->height_advgrid) ? $this->height_advgrid.'px' : $this->height_advgrid ?>;">
      <?php $href = $item->getHref();$imageURL = $photoPath;?>
      <a href="<?php echo $href; ?>" data-url = "<?php echo $item->getType() ?>" class="eblog_thumb_img">
      	<img src="<?php echo $imageURL; ?>" alt="" align="left" />
      </a>
      <?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive)):?>
      <div class="eblog_list_labels">
        <?php if(isset($this->sponsoredLabelActive) && $item->sponsored == 1):?>
						<p class="eblog_label_sponsored"><?php echo $this->translate('Sponsored');?></p>
					<?php endif;?>
          <?php if(isset($this->featuredLabelActive) && $item->featured == 1):?>
						<p class="eblog_label_featured"><?php echo $this->translate('Featured');?></p>
					<?php endif;?>
      </div>
    <?php endif;?>
      <?php if((isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.sharing', 1)) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive)):?>
        <?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref()); ?>
        <div class="eblog_list_thumb_over">
          <a href="<?php echo $href; ?>" data-url = "<?php echo $item->getType() ?>"></a>
          <div class="eblog_list_grid_thumb_btns"> 
            <?php if(isset($this->socialSharingActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.sharing', 1)):?>
                
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
                <?php $LikeStatus = Engine_Api::_()->eblog()->getLikeStatus($item->blog_id,$item->getType()); ?>
                <a href="javascript:;" data-url="<?php echo $item->blog_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn eblog_like_eblog_blog_<?php echo $item->blog_id ?> eblog_like_eblog_blog <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $item->like_count; ?></span></a>
              <?php endif;?>
              <?php if(isset($this->favouriteButtonActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.favourite', 1)): ?>
              <?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'eblog')->isFavourite(array('resource_type'=>'eblog_blog','resource_id'=>$item->blog_id)); ?>
                <a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn eblog_favourite_eblog_blog_<?php echo $item->blog_id ?> eblog_favourite_eblog_blog <?php echo ($favStatus)  ? 'button_active' : '' ?>"  data-url="<?php echo $item->blog_id ; ?>"><i class="fa fa-heart"></i><span><?php echo $item->favourite_count; ?></span></a>
              <?php endif;?>
            <?php endif;?>
          </div>
        </div>
      <?php endif;?> 
    </div>
  </div>
  <div class="eblog_grid_info">
    <div class="eblog_grid_two_header">
    <?php if(isset($this->categoryActive)){ ?>
    	<div class="eblog_grid_two_category_title">
        <?php if($item->category_id != '' && intval($item->category_id) && !is_null($item->category_id)):?>
          <?php $categoryItem = Engine_Api::_()->getItem('eblog_category', $item->category_id);?>
          <?php if($categoryItem):?>
            <?php $categoryItem = Engine_Api::_()->getItem('eblog_category', $item->category_id);?>
            <?php if($categoryItem):?>
              <a href="<?php echo $categoryItem->getHref(); ?>"><?php echo $categoryItem->category_name; ?></a>
            <?php endif;?>
          <?php endif;?>
        <?php endif;?>
          	</div>
    <?php } ?>
     <div class="eblog_list_stats sesbasic_text_light"><span><i class="fa fa-clock-o"></i>2 min. read</span></div>
     </div>
    <?php if(isset($this->titleActive) ){ ?>
    	<div class="eblog_gird_title">
        <?php if(strlen($item->getTitle()) > $this->title_truncation_advgrid2):?>
        <?php $title = mb_substr($item->getTitle(),0,$this->title_truncation_advgrid2).'...';?>
        <?php echo $this->htmlLink($item->getHref(),$title,array('title'=>$item->getTitle()) ) ?>
        <?php else: ?>
        <?php echo $this->htmlLink($item->getHref(),$item->getTitle(),array('title'=>$item->getTitle())  ) ?>
        <?php endif; ?>
        <?php if(isset($this->verifiedLabelActive) && $item->verified == 1):?>
						<i class="sesbasic_verified_icon" title="Verified"></i>
					<?php endif;?>
      </div>
    <?php } ?>
    <?php if(Engine_Api::_()->getApi('core', 'eblog')->allowReviewRating() && isset($this->ratingStarActive)):?>
					<?php echo $this->partial('_blogRating.tpl', 'eblog', array('rating' => $item->rating, 'class' => 'eblog_list_rating eblog_list_view_ratting'));?>
				<?php endif;?>
    <div class="eblog_grid_meta_tegs">
      <ul>
      	<?php if(isset($this->byActive)){ ?>
        	<li class="eblog_grid_meta_owner">
          	<div class="eblog_list_stats sesbasic_text_light"> <span>
            	<?php $owner = $item->getOwner(); ?>
            	<?php echo $this->htmlLink($item->getOwner()->getParent(), $this->itemPhoto($item->getOwner()->getParent(), 'thumb.icon')); ?> <?php echo $this->translate("by") ?> <?php echo $this->htmlLink($owner->getHref(),$owner->getTitle() ) ?> </span>
            </div>
        	</li>
        <?php } ?>
        <?php if(isset($this->creationDateActive)): ?>
        	<li class="eblog_grid_meta_date">
          	<div class="eblog_list_stats sesbasic_text_light"> <span><?php if($item->publish_date): ?>
              <?php echo date('M d, Y',strtotime($item->publish_date));?>
						<?php else: ?>
              <?php echo date('M d, Y',strtotime($item->creation_date));?>
						<?php endif; ?></span> </div>
        	</li>
        <?php endif;?>
        <!-- <?php if(isset($this->locationActive) && isset($item->location) && $item->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.location', 1)){ ?>
          <li class="eblog_grid_meta_location">
          	<div class="eblog_list_stats eblog_list_location sesbasic_text_light"> <span> <i class="fa fa-map-marker"></i> <a href="<?php echo $this->url(array('resource_id' => $item->blog_id,'resource_type'=>'eblog_blog','action'=>'get-direction'), 'sesbasic_get_direction', true) ;?>" class="opensmoothboxurl" title="<?php echo $item->location;?>"><?php echo $item->location;?></a> </span> </div>
          </li>
      	<?php } ?> -->
      </ul>
    </div>
    <?php if(isset($this->descriptionadvgridActive)){?>
      <div class="eblog_grid_contant">
        <?php echo $item->getDescription($this->description_truncation_advgrid);?>
      </div>
    <?php } ?>
    <div class="eblog_list_stats sesbasic_text_light">
			<?php if(isset($this->likeActive) && isset($item->like_count)) { ?>
				<span title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count)); ?>"><i class="sesbasic_icon_like_o"></i><?php echo $item->like_count; ?></span>
			<?php } ?>
			<?php if(isset($this->commentActive) && isset($item->comment_count)) { ?>
				<span title="<?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber($item->comment_count))?>"><i class="sesbasic_icon_comment_o"></i><?php echo $item->comment_count;?></span>
			<?php } ?>
			<?php if(isset($this->favouriteActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.favourite', 1)) { ?>
				<span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count))?>"><i class="sesbasic_icon_favourite_o"></i><?php echo $item->favourite_count;?></span>
			<?php } ?>
			<?php if(isset($this->viewActive) && isset($item->view_count)) { ?>
				<span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count))?>"><i class="sesbasic_icon_view"></i><?php echo $item->view_count; ?></span>
			<?php } ?>
			<?php include APPLICATION_PATH .  '/application/modules/Eblog/views/scripts/_blogRatingStat.tpl';?>
		</div>
    <?php if((isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.sharing', 1)) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive)):?>
    <?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref()); ?>
    <div class="eblog_list_share_btns">
      <div class="eblog_list_btns">
        <?php if(isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.sharing', 1)):?>
        
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
        <?php $LikeStatus = Engine_Api::_()->eblog()->getLikeStatus($item->blog_id,$item->getType()); ?>
        <a href="javascript:;" data-url="<?php echo $item->blog_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn eblog_like_eblog_blog_<?php echo $item->blog_id ?> eblog_like_eblog_blog <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $item->like_count; ?></span></a>
        <?php endif;?>
        <?php if(isset($this->favouriteButtonActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.favourite', 1)): ?>
        <?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'eblog')->isFavourite(array('resource_type'=>'eblog_blog','resource_id'=>$item->blog_id)); ?>
        <a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn eblog_favourite_eblog_blog_<?php echo $item->blog_id ?> eblog_favourite_eblog_blog <?php echo ($favStatus)  ? 'button_active' : '' ?>"  data-url="<?php echo $item->blog_id ; ?>"><i class="fa fa-heart"></i><span><?php echo $item->favourite_count; ?></span></a>
        <?php endif;?>
        <?php endif;?>
      </div>
    </div>
    <?php endif;?>
  </div>
 </article>
</li>