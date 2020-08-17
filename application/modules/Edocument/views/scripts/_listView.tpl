<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Edocument
 * @package    Edocument
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _listView.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<li class="edocument_list_document_view sesbasic_clearfix clear">
	<div class="edocument_list_thumb edocument_thumb" style="height:<?php echo is_numeric($this->height_list) ? $this->height_list.'px' : $this->height ?>;width:<?php echo is_numeric($this->width_list) ? $this->width_list.'px' : $this->width_list ?>;">
		<?php $href = $item->getHref();$imageURL = $photoPath;?>
		<a href="<?php echo $href; ?>" data-url = "<?php echo $item->getType() ?>" class="edocument_thumb_img">
		<span style="background-image:url(<?php echo $imageURL; ?>);"></span>
		</a>
		<?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) || isset($this->verifiedLabel)):?>
			<div class="edocument_list_labels ">
				<?php if(isset($this->featuredLabelActive) && $item->featured == 1):?>
					<p class="edocument_label_featured"><i class='fa fa-star'></i></p>
				<?php endif;?>
				<?php if(isset($this->sponsoredLabelActive) && $item->sponsored == 1):?>
					<p class="edocument_label_sponsored"><i class='fa fa-star'></i></p>
				<?php endif;?>
			</div>
      <?php if(isset($this->verifiedLabelActive) && $item->verified == 1):?>
        <div class="edocument_verified_label" title="<?php echo $this->translate('VERIFIED');?>"><i class="fa fa-check"></i></div>
      <?php endif;?>
		<?php endif;?>
		<?php if((isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('edocument.enable.sharing', 1)) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive)):?>
			<?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref()); ?>
			<div class="edocument_list_thumb_over">
				<a href="<?php echo $href; ?>" data-url = "<?php echo $item->getType() ?>"></a>
				<div class="edocument_grid_btns"> 
					<?php if(isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('edocument.enable.sharing', 1)):?>
            
            <?php if($this->socialshare_icon_limit): ?>
              <?php echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
            <?php else: ?>
              <?php echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_listview1plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_listview1limit)); ?>
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
    <div class="edcoument_type"> <span><img src="application/modules/Edocument/externals/images/types/doc.png" /></span> </div>
	</div>
	<div class="edocument_list_info">
  <div class="sesbasic_clearfix clear">
		<?php if(isset($this->titleActive)): ?>
			<div class="edocument_list_info_title">
				<?php if(strlen($item->getTitle()) > $this->title_truncation_list):?>
					<?php $title = mb_substr($item->getTitle(),0,$this->title_truncation_list).'...';?>
					<?php echo $this->htmlLink($item->getHref(),$title,array('title'=>$item->getTitle()));?>
				<?php else: ?>
					<?php echo $this->htmlLink($item->getHref(),$item->getTitle(),array('title'=>$item->getTitle())  ) ?>
				<?php endif;?>
			</div>
		<?php endif;?>
    <!-- <?php if(Engine_Api::_()->getApi('core', 'edocument')->allowReviewRating() && isset($this->ratingStarActive)):?>
			<?php echo $this->partial('_documentRating.tpl', 'edocument', array('rating' => $item->rating, 'class' => 'edocument_list_rating edocument_list_view_ratting floatR ', 'style' => ''));?>
    <?php endif;?> -->
    </div>
		<div class="edocument_admin_list">
			<?php if(isset($this->byActive)){ ?>
				<div class="edocument_stats_list sesbasic_text_dark">
					<?php $owner = $item->getOwner(); ?>
					<span><i class="fa fa-user-o"></i> <?php echo $this->htmlLink($owner->getHref(),$owner->getTitle() ) ?>
					</span>
				</div>
			<?php } ?>
			<?php if(isset($this->creationDateActive)){ ?>
				<div class="edocument_stats_list sesbasic_text_dark">
					<span>
						<i class="fa fa-clock-o"></i>
												<?php if($item->publish_date): ?>
              <?php echo date('M d, Y',strtotime($item->publish_date));?>
						<?php else: ?>
              <?php echo date('M d, Y',strtotime($item->creation_date));?>
						<?php endif; ?>
					</span>
				</div>
			<?php } ?>
			<?php if(isset($this->categoryActive)){ ?>
				<?php if($item->category_id != '' && intval($item->category_id) && !is_null($item->category_id)):?> 
					<?php $categoryItem = Engine_Api::_()->getItem('edocument_category', $item->category_id);?>
					<?php if($categoryItem):?>
						<div class="edocument_stats_list sesbasic_text_dark">
							<span>
							<i class="fa fa-folder-open" title="<?php echo $this->translate('Category'); ?>"></i> 
							<a href="<?php echo $categoryItem->getHref(); ?>"><?php echo $categoryItem->category_name; ?></a>
							</span>
						</div>
					<?php endif;?>
				<?php endif;?>
			<?php } ?>
      <div class="edocument_rating_stars">
        <div class="sesbasic_rating_star"> <span class="courses_rating_star"> <span class="sesbasic_rating_star_small fa fa-star"></span> <span class="sesbasic_rating_star_small fa fa-star"></span> <span class="sesbasic_rating_star_small fa fa-star"></span> <span class="sesbasic_rating_star_small fa fa-star"></span> <span class="sesbasic_rating_star_small fa fa-star sesbasic_rating_star_small_disable"></span> <span class="course_rating"> (4/5) </span> </span> </div>
      </div>
		</div>
		<div class="edocument_list_contant">
		<?php if(isset($this->descriptionlistActive)){ ?>
			<p class="edocument_list_des">
				<?php echo $item->getDescription($this->description_truncation_list);?>
			</p>
		<?php } ?>      
		</div>
    <div class="edocument_static_list_group">
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
      </div>
      <?php if(isset($this->readmoreActive)):?>
        <div class="edocument_list_readmore"><a class="edocument_animation" href="<?php echo $item->getHref();?>"><?php echo $this->translate('Read More');?></a></div>
      <?php endif;?>
    </div>
		<?php if(isset($this->my_documents) && $this->my_documents){ ?> 
      <div class="edocument_options_buttons edocument_list_options sesbasic_clearfix">
        <?php if($this->can_edit){ ?>
        <a href="<?php echo $this->url(array('action' => 'edit', 'edocument_id' => $item->edocument_id), 'edocument_specific', true); ?>" class="sesbasic_icon_btn" title="<?php echo $this->translate('Edit Document'); ?>">
        <i class="fa fa-pencil"></i>
        </a>
        <?php } ?>
        <?php if ($this->can_delete){ ?>
          <a href="<?php echo $this->url(array('action' => 'delete', 'edocument_id' => $item->edocument_id), 'edocument_specific', true); ?>" class="sesbasic_icon_btn" title="<?php echo $this->translate('Delete Document'); ?>" onclick='opensmoothboxurl(this.href);return false;'>
          <i class="fa fa-trash"></i>
          </a>
        <?php } ?>
      </div>
    <?php } ?>
	</div>
</li>
