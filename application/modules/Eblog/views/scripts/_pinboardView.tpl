<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _pinboardView.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<li class="eblog_pinboard_list sesbasic_bxs new_image_pinboard_<?php echo $randonNumber; ?>">
	<div class="eblog_pinboard_list_item <?php if((isset($this->my_blogs) && $this->my_blogs)){ ?>isoptions<?php } ?>">
		<div class="eblog_pinboard_list_item_top eblog_thumb sesbasic_clearfix">
			<div class="eblog_pinboard_list_item_thumb">
				<a href="<?php echo $item->getHref()?>" data-url = "<?php echo $item->getType() ?>" class="<?php echo $item->getType() != 'eblog_chanel' ? 'eblog_thumb_img' : 'eblog_thumb_nolightbox' ?>">
					<img src="<?php echo $photoPath; ?>">
					<span style="background-image:url(<?php echo $photoPath; ?>);display:none;"></span>
				</a>
			</div> 
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
		</div>

    <div class="eblog_pinboard_info_blog sesbasic_clearfix">
      <div class="eblog_pinboard_list_item_cont sesbasic_clearfix">
        <div class="eblog_pinboard_header">
         <?php if(isset($this->creationDateActive)){ ?>
            <div class="eblog_list_stats eblog_pinboard_date sesbasic_text_light">
              <?php if($item->publish_date): ?>
                <span><a href="<?php echo $this->url(array('action'=>'browse'),'eblog_general',true).'?date='.date('Y-m-d',strtotime($item->publish_date)); ?>"> <?php echo date('d M',strtotime($item->publish_date));?></a></span>
              <?php else: ?>
                <span><a href="<?php echo $this->url(array('action'=>'browse'),'eblog_general',true).'?date='.date('Y-m-d',strtotime($item->creation_date)); ?>"> <?php echo date('d M',strtotime($item->creation_date));?></a></span>
              <?php endif; ?>
            </div>
          <?php } ?>
           <?php if(isset($this->categoryActive)){ ?>
          <?php if($item->category_id != '' && intval($item->category_id) && !is_null($item->category_id)):?> 
            <?php $categoryItem = Engine_Api::_()->getItem('eblog_category', $item->category_id);?>
            <?php if($categoryItem):?>
              <div class="eblog_pinboard_categry eblog_list_stats sesbasic_text_light">
                <span>
                  <a href="<?php echo $categoryItem->getHref(); ?>">
                  <span><?php echo $categoryItem->category_name; ?></span></a>
                </span>
              </div>
            <?php endif;?>
          <?php endif;?>
        <?php } ?>
          <div class="eblog_list_stats sesbasic_text_light">
              <span><i class="fa fa-clock-o"></i> 2 Min. read</span>
          </div>
          </div>
        <?php if(isset($this->titleActive)):?>
          <div class="eblog_pinboard_title">
            <?php if(strlen($item->getTitle()) > $this->title_truncation_pinboard):?>
              <?php $title = mb_substr($item->getTitle(),0,$this->title_truncation_pinboard).'...';?>
              <?php echo $this->htmlLink($item->getHref(),$title ) ?>
            <?php else: ?>
              <?php echo $this->htmlLink($item->getHref(),$item->getTitle() ) ?>
            <?php endif;?>   
             <?php if(isset($this->verifiedLabelActive) && $item->verified == 1):?>
						<i class="sesbasic_verified_icon" title="Verified"></i>
					<?php endif;?>
          </div>  
        <?php endif;?>
        
        <div class="eblog_pinboard_meta_blog">
          <?php if(isset($this->byActive)):?>
						<div class="eblog_list_stats sesbasic_text_dark sesbasic_clearfix">
							<?php $owner = $item->getOwner(); ?>
							<span class="eblog_pinboard_list_item_poster_info_title"><?php echo $this->translate('Posted by ');?><?php echo $this->htmlLink($item->getOwner()->getParent(), $this->itemPhoto($item->getOwner()->getParent(), 'thumb.icon')); ?> <?php echo $this->htmlLink($owner->getHref(),$owner->getTitle() ) ?></span>
            </div>
          <?php endif;?>
          <!-- <?php if(isset($this->locationActive) && isset($item->location) && $item->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog_enable_location', 1)){ ?>
            <div class="eblog_list_stats sesbasic_text_dark eblog_list_location">
              <span>
                <i class="fa fa-map-marker"></i>
                <a href="<?php echo $this->url(array('resource_id' => $item->blog_id,'resource_type'=>'eblog_blog','action'=>'get-direction'), 'sesbasic_get_direction', true) ;?>" class="opensmoothboxurl" title="<?php echo $item->location;?>"><?php echo $item->location;?></a>
              </span>
            </div>
          <?php } ?> -->
        </div>
        <?php if(Engine_Api::_()->getApi('core', 'eblog')->allowReviewRating() && isset($this->ratingStarActive)):?>
          <?php echo $this->partial('_blogRating.tpl', 'eblog', array('rating' => $item->rating, 'class' => 'eblog_list_rating eblog_list_view_ratting', 'style' => ''));?>
        <?php endif;?>
        <?php if(isset($this->descriptionpinboardActive)){ ?>
          <div class="eblog_pinboard_list_item_des clear">
          	<?php echo $item->getDescription($this->description_truncation_pinboard);?>
          </div>
        <?php } ?>
          <?php if(isset($this->readmoreActive)):?>
              <div class="eblog_pinboard_readmore"><a href="<?php echo $item->getHref();?>"><?php echo $this->translate('More');?></a></div>
           <?php endif;?>
        <div class="eblog_pinboard_list_item_btm sesbm sesbasic_clearfix">
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
          <?php if(isset($this->my_blogs) && $this->my_blogs ){ ?>
            <?php if($this->can_edit || $this->can_delete){ ?>
              <div class="eblog_listing_in_grid2_date sesbasic_text_light">
                <span class="eblog_list_option_toggle fa fa-ellipsis-v sesbasic_text_light"></span>
                <div class="eblog_listing_options_pulldown">
                  <?php if($this->can_edit){ 
                  echo $this->htmlLink(array('route' => 'eblog_specific','action' => 'edit','blog_id' => $item->blog_id), $this->translate('Edit Blog')) ; 
                  } ?>
                  <?php if ($this->can_delete){
                  echo $this->htmlLink(array('route' => 'eblog_specific','action' => 'delete', 'blog_id' => $item->blog_id), $this->translate('Delete Blog'), array('onclick' =>'opensmoothboxurl(this.href);return false;'));
                  } ?>
                </div>
              </div>
            <?php } ?>
          <?php } ?>
          <!-- <?php if(isset($this->enableCommentPinboardActive)):?>
            <?php $itemType = '';?>
            <?php if(isset($item->blog_id)):?> 
              <?php $item_id = $item->blog_id;?>
              <?php $itemType = 'eblog_blog';?>
            <?php endif; ?>
            <?php if(($itemType != '')): ?>
              <div class="eblog_pinboard_list_comments">
                <?php echo (Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesadvancedcomment') ? $this->action('list', 'comment', 'sesadvancedcomment', array('type' => $itemType, 'id' => $item_id,'page'=>'')) : $this->action("list", "comment", "sesbasic", array("item_type" => $itemType, "item_id" => $item_id,"widget_identity"=>$randonNumber))); ?></div>
            <?php endif; ?>
          <?php endif; ?> -->
        </div>
      </div>
    </div>
  </div>
</li>