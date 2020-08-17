<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecipe
 * @package    Sesrecipe
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _pinboardView.tpl 2018-05-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<li class="sesrecipe_pinboard_list sesbasic_bxs new_image_pinboard_<?php echo $randonNumber; ?>">
	<div class="sesrecipe_pinboard_list_item sesbm <?php if((isset($this->my_recipes) && $this->my_recipes)){ ?>isoptions<?php } ?>">
		<div class="sesrecipe_pinboard_list_item_top sesrecipe_thumb sesbasic_clearfix">
			<div class="sesrecipe_pinboard_list_item_thumb">
				<a href="<?php echo $item->getHref()?>" data-url = "<?php echo $item->getType() ?>" class="<?php echo $item->getType() != 'sesrecipe_chanel' ? 'sesrecipe_thumb_img' : 'sesrecipe_thumb_nolightbox' ?>">
					<img src="<?php echo $photoPath; ?>">
					<span style="background-image:url(<?php echo $photoPath; ?>);display:none;"></span>
				</a>
			</div> 
			<?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) || isset($this->verifiedLabel)):?>
				<div class="sesrecipe_pinboard_labels">
					<?php if(isset($this->featuredLabelActive) && $item->featured == 1):?>
						<p class="sesrecipe_label_featured"><?php echo $this->translate('FEATURED');?></p>
					<?php endif;?>
					<?php if(isset($this->sponsoredLabelActive) && $item->sponsored == 1):?>
						<p class="sesrecipe_label_sponsored"><?php echo $this->translate('SPONSORED');?></p>
					<?php endif;?>
				</div>
			<?php endif;?>
       <?php if(isset($this->verifiedLabelActive) && $item->verified == 1):?>
        <div class="sesrecipe_verified_label" title="<?php echo $this->translate('VERIFIED');?>"><i class="fa fa-check"></i></div>
      <?php endif;?>
			<?php if((isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.sharing', 1)) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive)):?>
				<?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref()); ?>
				<div class="sesrecipe_list_thumb_over"> 
					<a href="<?php echo $href; ?>" data-url = "<?php echo $item->getType() ?>"></a> 
					<div class="sesrecipe_list_grid_thumb_btns"> 
						<?php if(isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.sharing', 1)):?>
              
              <?php if($this->socialshare_icon_limit): ?>
                <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
              <?php else: ?>
                <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_pinviewplusicon, 'socialshare_icon_limit' => $this->socialshare_icon_pinviewlimit)); ?>
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

    <div class="sesrecipe_pinboard_info_recipe sesbasic_clearfix">
      <div class="sesrecipe_pinboard_list_item_cont sesbasic_clearfix">
        <?php if(isset($this->categoryActive)){ ?>
          <?php if($item->category_id != '' && intval($item->category_id) && !is_null($item->category_id)):?> 
            <?php $categoryItem = Engine_Api::_()->getItem('sesrecipe_category', $item->category_id);?>
            <?php if($categoryItem):?>
              <div class="sesrecipe_pinboard_categry sesrecipe_list_stats sesbasic_text_light">
                <span>
                  <a href="<?php echo $categoryItem->getHref(); ?>"><i class="fa fa-folder-open" title="<?php echo $this->translate('Category'); ?>"></i> 
                  <span><?php echo $categoryItem->category_name; ?></span></a>
                </span>
              </div>
            <?php endif;?>
          <?php endif;?>
        <?php } ?>
        <?php if(Engine_Api::_()->getApi('core', 'sesrecipe')->allowReviewRating() && isset($this->ratingStarActive)):?>
          <?php echo $this->partial('_recipeRating.tpl', 'sesrecipe', array('rating' => $item->rating, 'class' => 'sesrecipe_list_rating sesrecipe_list_view_ratting floatR', 'style' => ''));?>
        <?php endif;?>
        <?php if(isset($this->titleActive)):?>
          <div class="sesrecipe_pinboard_title">
            <?php if(strlen($item->getTitle()) > $this->title_truncation_pinboard):?>
              <?php $title = mb_substr($item->getTitle(),0,$this->title_truncation_pinboard).'...';?>
              <?php echo $this->htmlLink($item->getHref(),$title ) ?>
            <?php else: ?>
              <?php echo $this->htmlLink($item->getHref(),$item->getTitle() ) ?>
            <?php endif;?>   
          </div>  
        <?php endif;?>
        
        <div class="sesrecipe_pinboard_meta_recipe">
          <?php if(isset($this->byActive)):?>
						<div class="sesrecipe_list_stats sesbasic_text_dark sesbasic_clearfix">
							<?php $owner = $item->getOwner(); ?>
							<?php echo $this->htmlLink($item->getOwner()->getParent(), $this->itemPhoto($item->getOwner()->getParent(), 'thumb.icon')); ?>
							<span class="sesrecipe_pinboard_list_item_poster_info_title"><?php echo $this->translate('by ');?><?php echo $this->htmlLink($owner->getHref(),$owner->getTitle() ) ?></span>
						</div>
          <?php endif;?>
          <?php if(isset($this->creationDateActive)){ ?>
            <div class="sesrecipe_list_stats sesbasic_text_dirk">
              <?php if($item->publish_date): ?>
                <span><i class="fa fa-clock-o"></i> <a href="<?php echo $this->url(array('action'=>'browse'),'sesrecipe_general',true).'?date='.date('Y-m-d',strtotime($item->publish_date)); ?>"><b><?php echo date('M d',strtotime($item->publish_date));?></b></a></span>
              <?php else: ?>
                <span><i class="fa fa-clock-o"></i> <a href="<?php echo $this->url(array('action'=>'browse'),'sesrecipe_general',true).'?date='.date('Y-m-d',strtotime($item->creation_date)); ?>"><b><?php echo date('M d',strtotime($item->creation_date));?></b></a></span>
              <?php endif; ?>
            </div>
          <?php } ?>
          <?php if(isset($this->locationActive) && isset($item->location) && $item->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe_enable_location', 1)){ ?>
            <div class="sesrecipe_list_stats sesbasic_text_dark sesrecipe_list_location">
              <span>
                <i class="fa fa-map-marker"></i>
                <?php include APPLICATION_PATH .  '/application/modules/Sesrecipe/views/scripts/_location_direction.tpl';?>
              </span>
            </div>
          <?php } ?>
        </div>
        <?php if(isset($this->descriptionpinboardActive)){ ?>
          <div class="sesrecipe_pinboard_list_item_des clear">
          	<?php echo $this->string()->truncate($this->string()->stripTags($item->body), $this->description_truncation_pinboard) ?>
          </div>
        <?php } ?>
        
        <div class="sesrecipe_pinboard_list_item_btm sesbm sesbasic_clearfix">
          <div class="sesrecipe_pinboard_list_item_btm_cont sesbasic_text_light sesbasic_clearfix">
            <?php $owner = $item->getOwner(); ?>
            <div class="sesrecipe_pinboard_list_statics floatL sesbasic_text_dark">
              <?php if(isset($this->likeActive) && isset($item->like_count)) { ?>
                <span title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count)); ?>"><i class="fa fa-thumbs-up"></i><?php echo $item->like_count; ?></span>
              <?php } ?>
              <?php if(isset($this->commentActive) && isset($item->comment_count)) { ?>
                <span title="<?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber($item->comment_count))?>"><i class="fa fa-comment"></i><?php echo $item->comment_count;?></span>
              <?php } ?>                  
              <?php if(isset($this->viewActive) && isset($item->view_count)) { ?>
                <span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count))?>"><i class="fa fa-eye"></i><?php echo $item->view_count; ?></span>
              <?php } ?>
              <?php if(isset($this->favouriteActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.favourite', 1)) { ?>
                <span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count))?>"><i class="fa fa-heart"></i><?php echo $item->favourite_count;?></span>
              <?php } ?>
              <?php include APPLICATION_PATH .  '/application/modules/Sesrecipe/views/scripts/_recipeRatingStat.tpl';?>
            </div>
            <?php if(isset($this->readmoreActive)):?>
              <div class="sesblock_pinboard_readmore floatR"><a href="<?php echo $item->getHref();?>"><?php echo $this->translate('Read More...');?></a></div>
            <?php endif;?>
          </div>
          <?php if(isset($this->my_recipes) && $this->my_recipes ){ ?>
            <?php if($this->can_edit || $this->can_delete){ ?>
              <div class="sesrecipe_listing_in_grid2_date sesbasic_text_light">
                <span class="sesrecipe_list_option_toggle fa fa-ellipsis-v sesbasic_text_light"></span>
                <div class="sesrecipe_listing_options_pulldown">
                  <?php if($this->can_edit){ 
                  echo $this->htmlLink(array('route' => 'sesrecipe_specific','action' => 'edit','recipe_id' => $item->recipe_id), $this->translate('Edit Recipe')) ; 
                  } ?>
                  <?php if ($this->can_delete){
                  echo $this->htmlLink(array('route' => 'sesrecipe_specific','action' => 'delete', 'recipe_id' => $item->recipe_id), $this->translate('Delete Recipe'), array('onclick' =>'opensmoothboxurl(this.href);return false;'));
                  } ?>
                </div>
              </div>
            <?php } ?>
          <?php } ?>
          <?php if(isset($this->enableCommentPinboardActive)):?>
            <?php $itemType = '';?>
            <?php if(isset($item->recipe_id)):?> 
              <?php $item_id = $item->recipe_id;?>
              <?php $itemType = 'sesrecipe_recipe';?>
            <?php endif; ?>
            <?php if(($itemType != '')): ?>
              <div class="sesrecipe_pinboard_list_comments">
                <?php echo (Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesadvancedcomment') ? $this->action('list', 'comment', 'sesadvancedcomment', array('type' => $itemType, 'id' => $item_id,'page'=>'')) : $this->action("list", "comment", "sesbasic", array("item_type" => $itemType, "item_id" => $item_id,"widget_identity"=>$randonNumber))); ?></div>
            <?php endif; ?>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</li>
