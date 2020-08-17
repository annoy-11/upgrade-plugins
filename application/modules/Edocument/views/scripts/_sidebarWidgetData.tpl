<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Edocument
 * @package    Edocument
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _sidebarWidgetData.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php 
  $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');
  $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Edocument/externals/styles/styles.css'); 
?>
<?php foreach( $this->results as $item ): ?>
	<?php if($this->view_type == 'list'):?>
		<li class="edocument_sidebar_document_list sesbasic_clearfix">
			<div class="edocument_sidebar_document_list_img <?php if($this->image_type == 'rounded'):?>edocument_sidebar_image_rounded<?php endif;?> edocument_list_thumb edocument_thumb" style="height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height_list ?>;width:<?php echo is_numeric($this->width) ? $this->width.'px' : $this->width ?>;">
				<?php $href = $item->getHref();$imageURL = $item->getPhotoUrl('thumb.profile');?>
				<a href="<?php echo $href; ?>" class="edocument_thumb_img">
					<span class="floatL" style="background-image:url(<?php echo $imageURL; ?>);"></span>
				</a>     
			</div>
			<div class="edocument_sidebar_document_list_cont">
				<?php  if(isset($this->titleActive)): ?>
					<div class="edocument_sidebar_document_list_title edocument_list_info_title">
						<?php if(strlen($item->getTitle()) > $this->title_truncation):?>
							<?php $title = mb_substr($item->getTitle(),0,$this->title_truncation).'...';?>
							<?php echo $this->htmlLink($item->getHref(),$title, array('class' => 'ses_tooltip', 'data-src' => $item->getGuid()));?>
						<?php  else : ?>
							<?php echo $this->htmlLink($item->getHref(),$item->getTitle(), array('class' => 'ses_tooltip', 'data-src' => $item->getGuid())) ?>
						<?php endif; ?>
					</div>
				<?php endif; ?>       
				<?php if(Engine_Api::_()->getApi('core', 'edocument')->allowReviewRating() && isset($this->ratingStarActive)):?>
					<?php echo $this->partial('_documentRating.tpl', 'edocument', array('rating' => $item->rating, 'class' => 'edocument_list_rating edocument_list_view_ratting', 'style' => 'margin-bottom:0px; margin-top:10px;'));?>
				<?php endif;?>  
				<div class="edocument_sidebar_document_list_date edocument_sidebar_list_date">
					<?php if(isset($this->byActive)): ?>
						<?php $owner = $item->getOwner(); ?>
						<span><?php echo $this->translate('By');?> <?php echo $this->htmlLink($owner->getHref(),$owner->getTitle()) ?></span>
					<?php endif; ?>
					<?php if(isset($this->creationDateActive)):?>
						<span><i class="fa fa-calendar"></i> <?php echo date('M d, Y',strtotime($item->publish_date));?></span>
					<?php endif;?>
				</div>
				<?php if(isset($this->categoryActive)): ?>
					<?php if($item->category_id != '' && intval($item->category_id) && !is_null($item->category_id)):?>
						<?php $categoryItem = Engine_Api::_()->getItem('edocument_category', $item->category_id);?>
            <?php if($categoryItem): ?>
              <div class="edocument_sidebar_document_list_date">
                  <i class="fa fa-folder-open sesbasic_text_light" title="<?php echo $this->translate('Category:'); ?>"></i> 
                  <span><a href="<?php echo $categoryItem->getHref(); ?>">
                  <?php echo $categoryItem->category_name; ?></a>
                  <?php $subcategory = Engine_Api::_()->getItem('edocument_category',$item->subcat_id); ?>
                  <?php if($subcategory && $item->subcat_id): ?>
                    &nbsp;&raquo;&nbsp;<a href="<?php echo $subcategory->getHref(); ?>"><?php echo $subcategory->category_name; ?></a>
                  <?php endif; ?>
                  <?php $subsubcategory = Engine_Api::_()->getItem('edocument_category',$item->subsubcat_id); ?>
                  <?php if($subsubcategory && $item->subsubcat_id): ?>
                    &nbsp;&raquo;&nbsp;<a href="<?php echo $subsubcategory->getHref(); ?>"><?php echo $subsubcategory->category_name; ?></a>
                  <?php endif; ?>
                </span>
              </div>
            <?php endif; ?>
					<?php endif; ?>
				<?php endif; ?>
				<div class="edocument_sidebar_document_list_date sesbasic_text_light">
					<?php if(isset($this->likeActive) && isset($item->like_count)) { ?>
						<span title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count)); ?>"><i class="fa fa-thumbs-up sesbasic_text_light"></i><?php echo $item->like_count; ?></span>
					<?php } ?>
					<?php if(isset($this->commentActive) && isset($item->comment_count)) { ?>
						<span title="<?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber($item->comment_count))?>"><i class="fa fa-comment sesbasic_text_light"></i><?php echo $item->comment_count;?></span>
					<?php } ?>
					<?php if(isset($this->viewActive) && isset($item->view_count)) { ?>
						<span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count))?>"><i class="fa fa-eye sesbasic_text_light"></i><?php echo $item->view_count; ?></span>
					<?php } ?>
					<?php if(isset($this->favouriteActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('edocument.enable.favourite', 1)) { ?>
						<span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count))?>"><i class="fa fa-heart sesbasic_text_light"></i><?php echo $item->favourite_count; ?></span>
					<?php } ?>
					<?php include APPLICATION_PATH .  '/application/modules/Edocument/views/scripts/_documentRatingStat.tpl';?>
				</div>
			</div>
		</li>
	<?php elseif($this->view_type == 'grid1'): ?>
		<li class="edocument_sidebar_grid sesbasic_clearfix sesbasic_bxs sesbm" style="width:<?php echo is_numeric($this->width) ? $this->width.'px' : $this->width ?> ; ">
			<div class="edocument_grid_inner edocument_list_thumb edocument_thumb">
				<div class="edocument_grid_thumb edocument_thumb" style="height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height ?>;">
					<?php $href = $item->getHref();$imageURL = $item->getPhotoUrl('thumb.profile');?>
					<a href="<?php echo $href; ?>" class="edocument_item_grid_thumb_img floatL">
						<span class="floatL" style="background-image:url(<?php echo $imageURL; ?>);"></span>
					</a>
					<?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive)): ?>
						<div class="edocument_list_labels ">
							<?php if(isset($this->featuredLabelActive) && $item->featured): ?>
								<p class="edocument_label_featured"><?php echo $this->translate('FEATURED');?></p>
							<?php endif; ?>
							<?php if(isset($this->sponsoredLabelActive) && $item->sponsored): ?>
								<p class="edocument_label_sponsored"><?php echo $this->translate('SPONSORED');?></p>
							<?php endif; ?>
						</div>
					<?php endif; ?>
					<?php if(isset($this->verifiedLabelActive) && $item->verified == 1): ?>
						<div class="edocument_verified_label" title="<?php echo $this->translate("VERIFIED"); ?>" style=""><i class="fa fa-check"></i></div>
					<?php endif; ?>
					<?php if((isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('edocument.enable.sharing', 1)) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive)):?>
						<?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref()); ?>
						<div class="edocument_list_thumb_over"> 
							<a href="<?php echo $href; ?>" data-url = "<?php echo $item->getType() ?>"></a>
							<div class="edocument_list_grid_thumb_btns"> 
								<?php if(isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('edocument.enable.sharing', 1)): ?>
                  
                  <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item)); ?>

								<?php endif;?>
								<?php $itemtype = 'edocument';?>
								<?php $getId = 'edocument_id';?>
								<?php $canComment =  $item->authorization()->isAllowed($this->viewer, 'comment');?>
								<?php if(isset($this->likeButtonActive) && $canComment):?>
									<!--Like Button-->
									<?php $LikeStatus = Engine_Api::_()->edocument()->getLikeStatus($item->$getId, $item->getType()); ?>
									<a href="javascript:;" data-url="<?php echo $item->$getId ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn edocument_like_<?php echo $itemtype; ?> <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $item->like_count; ?></span></a>
								<?php endif; ?>
								<?php if(isset($this->favouriteButtonActive) && isset($item->favourite_count) && $this->viewer_id && Engine_Api::_()->getApi('settings', 'core')->getSetting('edocument.enable.favourite', 1)):?>
									<?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'edocument')->isFavourite(array('resource_type'=>'edocument','resource_id'=>$item->edocument_id));
									$favClass = ($favStatus)  ? 'button_active' : '';?>
									<?php $shareOptions = "<a href='javascript:;' class='sesbasic_icon_btn sesbasic_icon_btn_count edocument_favourite_edocument_". $item->edocument_id." sesbasic_icon_fav_btn edocument_favourite_edocument ".$favClass ."' data-url=\"$item->edocument_id\"><i class='fa fa-heart'></i><span>$item->favourite_count</span></a>";?>
									<?php echo $shareOptions;?>
								<?php endif;?>
								<?php if(isset($this->listButtonActive) && $this->viewer_id): ?>
									<a href="javascript:;" onclick="opensmoothboxurl('<?php echo $this->url(array('action' => 'add','module'=>'edocument','controller'=>'list','edocument_id'=>$item->edocument_id),'default',true); ?>')" class="sesbasic_icon_btn  edocument_add_list"  title="<?php echo  $this->translate('Add To List'); ?>" data-url="<?php echo $item->edocument_id ; ?>"><i class="fa fa-plus"></i></a>
								<?php endif; ?>
							</div>
						</div>
					<?php endif; ?>
				</div>
				<div class="edocument_grid_info clear sesbasic_clearfix sesbm">
					<?php if(isset($this->titleActive) ): ?>
						<div class="edocument_grid_info_title">
							<?php if(strlen($item->getTitle()) > $this->title_truncation):?>
								<?php $title = mb_substr($item->getTitle(),0,$this->title_truncation).'...';?>
								<?php echo $this->htmlLink($item->getHref(),$title, array('class' => 'ses_tooltip', 'data-src' => $item->getGuid())) ?>
							<?php else: ?>
								<?php echo $this->htmlLink($item->getHref(),$item->getTitle(), array('class' => 'ses_tooltip', 'data-src' => $item->getGuid())) ?>
							<?php endif; ?>
							<?php if(isset($this->verifiedLabelActive) && $item->verified == 1): ?>
								<i class="edocument_verified_sign fa fa-check-circle"></i>
							<?php endif; ?>
						</div>
					<?php endif; ?>
          <?php if(Engine_Api::_()->getApi('core', 'edocument')->allowReviewRating() && isset($this->ratingStarActive)):?>
					<?php echo $this->partial('_documentRating.tpl', 'edocument', array('rating' => $item->rating, 'class' => 'edocument_list_rating edocument_list_view_ratting', 'style' => 'margin-bottom:5px;'));?>
				<?php endif;?>
					<?php if(isset($this->byActive)): ?>
						<div class="edocument_admin sesbasic_clearfix">
							<?php $owner = $item->getOwner(); ?>
							<p>
								<a href="<?php echo $owner->getHref();?>"><?php echo $this->itemPhoto($owner, 'thumb.icon');?></a>
							  <?php echo $this->translate('By');?> <?php echo $this->htmlLink($owner->getHref(),$owner->getTitle()) ?>
							</p>
						</div>
					<?php endif; ?>
					<?php if(isset($this->categoryActive)): ?>
						<?php if($item->category_id != '' && intval($item->category_id) && !is_null($item->category_id)):?>
							<?php $categoryItem = Engine_Api::_()->getItem('edocument_category', $item->category_id);?>
							<?php if($categoryItem): ?>
                <div class="edocument_admin sesbasic_clearfix">
                  <span>
                    <i class="fa fa-folder-open sesbasic_text_light" title="<?php echo $this->translate('Category:'); ?>"></i>
                    <a href="<?php echo $categoryItem->getHref(); ?>"><?php echo $categoryItem->category_name; ?></a>
                    <?php $subcategory = Engine_Api::_()->getItem('edocument_category',$item->subcat_id); ?>
                    <?php if($subcategory && $item->subcat_id) { ?>
                    &nbsp;&raquo;&nbsp;<a href="<?php echo $subcategory->getHref(); ?>"><?php echo $subcategory->category_name; ?></a>
                    <?php } ?>
                    <?php $subsubcategory = Engine_Api::_()->getItem('edocument_category',$item->subsubcat_id); ?>
                    <?php if($subsubcategory && $item->subsubcat_id) { ?>
                    &nbsp;&raquo;&nbsp;<a href="<?php echo $subsubcategory->getHref(); ?>"><?php echo $subsubcategory->category_name; ?></a>
                    <?php } ?>
                  </span>
                </div>
              <?php endif; ?>
						<?php endif; ?>
					<?php endif; ?>
					<div class="edocument_list_stats">
						<?php if(isset($this->likeActive) && isset($item->like_count)) { ?>
							<span title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count)); ?>"><i class="fa fa-thumbs-up sesbasic_text_light"></i><?php echo $item->like_count; ?></span>
						<?php } ?>
						<?php if(isset($this->commentActive) && isset($item->comment_count)) { ?>
							<span title="<?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber($item->comment_count))?>"><i class="fa fa-comment sesbasic_text_light"></i><?php echo $item->comment_count;?></span>
						<?php } ?>
						<?php if(isset($this->viewActive) && isset($item->view_count)) { ?>
							<span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count))?>"><i class="fa fa-eye sesbasic_text_light"></i><?php echo $item->view_count; ?></span>
						<?php } ?>
						<?php if(isset($this->favouriteActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('edocument.enable.favourite', 1)) { ?>
							<span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count))?>"><i class="fa fa-heart sesbasic_text_light"></i><?php echo $item->favourite_count; ?></span>
						<?php } ?>
					</div>
				</div>
			</div>
		</li>
	<?php endif; ?>
<?php endforeach; ?>
