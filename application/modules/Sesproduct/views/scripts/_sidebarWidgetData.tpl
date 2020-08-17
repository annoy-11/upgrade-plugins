<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _sidebarWidgetData.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php 
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');
$this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesproduct/externals/styles/styles.css'); 
?>
<?php foreach( $this->results as $item ): ?>
	<?php if($this->view_type == 'list'):?>
		<li class="sesproduct_sidebar_product_list sesbasic_clearfix">
			<div class="sesproduct_sidebar_product_list_img <?php if($this->image_type == 'rounded'):?>sesproduct_sidebar_image_rounded<?php endif;?> sesproduct_list_thumb sesproduct_thumb" style="height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height_list ?>;width:<?php echo is_numeric($this->width) ? $this->width.'px' : $this->width ?>;">
				<?php $href = $item->getHref();$imageURL = $item->getPhotoUrl('thumb.profile');?>
				<a href="<?php echo $href; ?>" class="sesproduct_thumb_img">
					<span class="floatL" style="background-image:url(<?php echo $imageURL; ?>);"></span>
				</a>     
			</div>
			<div class="sesproduct_sidebar_product_list_cont">
				<?php  if(isset($this->titleActive)): ?>
					<div class="sesproduct_sidebar_product_list_title sesproduct_list_info_title">
						<?php if(strlen($item->getTitle()) > $this->title_truncation):?>
							<?php $title = mb_substr($item->getTitle(),0,$this->title_truncation).'...';?>
							<?php echo $this->htmlLink($item->getHref(),$title, array('data-src' => $item->getGuid()));?>
						<?php  else : ?>
							<?php echo $this->htmlLink($item->getHref(),$item->getTitle(), array('data-src' => $item->getGuid())) ?>
						<?php endif; ?>
					</div>
				<?php endif; ?>       
				<div class="sesproduct_sidebar_product_list_date sesproduct_sidebar_list_date">
					<?php $store = Engine_Api::_()->getItem('stores',$item->store_id); ?>
					<?php if(isset($this->storeNameActive) && count($store)): ?>
						<span><?php echo $this->translate('By');?> <?php echo $this->htmlLink($store->getHref(),$store->getTitle()) ?></span>
					<?php endif; ?>
					<?php if(isset($this->creationDateActive)):?>
						<span><i class="fa fa-calendar"></i> <?php echo date('M d, Y',strtotime($item->publish_date));?></span>
					<?php endif;?>
				</div>
				<?php  if(isset($this->locationActive) && $item->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.location', 1)): ?>
					<div class="sesproduct_sidebar_product_list_date sesproduct_list_location">
						<span class="widthfull">
							<i class="fa fa-map-marker sesbasic_text_light" title="<?php echo $this->translate('Location');?>"></i>
							<span title="<?php echo $item->location; ?>"> <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)) { ?><a href="<?php echo $this->url(array('resource_id' => $item->product_id,'resource_type'=>'sesproduct','action'=>'get-direction'), 'sesbasic_get_direction', true) ;?>" class="opensmoothboxurl" title="<?php echo $item->location;?>"><?php echo $item->location;?></a><?php } else { ?><?php echo $item->location;?><?php } ?> </span>
						</span>
					</div>
				<?php endif; ?>
				<?php if(isset($this->categoryActive)): ?>
					<?php if($item->category_id != '' && intval($item->category_id) && !is_null($item->category_id)):?>
						<?php $categoryItem = Engine_Api::_()->getItem('sesproduct_category', $item->category_id);?>
            <?php if($categoryItem): ?>
              <div class="sesproduct_sidebar_product_list_date">
                  <i class="fa fa-folder-open sesbasic_text_light" title="<?php echo $this->translate('Category:'); ?>"></i> 
                  <span><a href="<?php echo $categoryItem->getHref(); ?>">
                  <?php echo $categoryItem->category_name; ?></a>
                  <?php $subcategory = Engine_Api::_()->getItem('sesproduct_category',$item->subcat_id); ?>
                  <?php if($subcategory && $item->subcat_id): ?>
                    &nbsp;&raquo;&nbsp;<a href="<?php echo $subcategory->getHref(); ?>"><?php echo $subcategory->category_name; ?></a>
                  <?php endif; ?>
                  <?php $subsubcategory = Engine_Api::_()->getItem('sesproduct_category',$item->subsubcat_id); ?>
                  <?php if($subsubcategory && $item->subsubcat_id): ?>
                    &nbsp;&raquo;&nbsp;<a href="<?php echo $subsubcategory->getHref(); ?>"><?php echo $subsubcategory->category_name; ?></a>
                  <?php endif; ?>
                </span>
              </div>
            <?php endif; ?>
					<?php endif; ?>
				<?php endif; ?>
        <div class="sesproduct_sidebar_product_list_date">
          <?php if(isset($this->likeActive) && isset($item->like_count)) { ?>
            <span title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count)); ?>"><i class="fa fa-thumbs-up sesbasic_text_light"></i><?php echo $item->like_count; ?></span>
          <?php } ?>
          <?php if(isset($this->commentActive) && isset($item->comment_count)) { ?>
            <span title="<?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber($item->comment_count))?>"><i class="fa fa-comment sesbasic_text_light"></i><?php echo $item->comment_count;?></span>
          <?php } ?>
          <?php if(isset($this->viewActive) && isset($item->view_count)) { ?>
            <span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count))?>"><i class="fa fa-eye sesbasic_text_light"></i><?php echo $item->view_count; ?></span>
          <?php } ?>
          <?php if(isset($this->favouriteActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.favourite', 1)) { ?>
            <span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count))?>"><i class="fa fa-heart sesbasic_text_light"></i><?php echo $item->favourite_count; ?></span>
          <?php } ?>
        </div>
				<?php if(isset($this->ratingStarActive)): ?>
          <div class="sesproduct_sidebar_product_list_date sesbasic_text_light">
            <?php include APPLICATION_PATH .  '/application/modules/Sesproduct/views/scripts/_rating.tpl';?>
          </div>
				<?php  endif; ?>
			</div>
		</li>
	<?php elseif($this->view_type == 'grid1'): ?>
		<li class="sesproduct_grid sesbasic_clearfix" style="width:<?php echo is_numeric($this->width) ? $this->width.'px' : $this->width ?> ; ">
			<article>
				<div class="sesproduct_thumb">
		      <?php if(Engine_Api::_()->sesproduct()->saleRunning($item,$this->viewer()->getIdentity()) && $this->show_sale){ ?>
			      <div class="sesproduct_sale">
			        <p class="sale_label"><?php echo $this->translate("Sale"); ?></p>
			      </div>
		      <?php  } ?>
					<div class="sesproduct_grid_thumb" style="height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height ?>;">
						<?php $href = $item->getHref();$imageURL = $item->getPhotoUrl('thumb.profile');?>
						<a href="<?php echo $href; ?>" class="sesproduct_thumb_img">
							<span class="floatL" style="background-image:url(<?php echo $imageURL; ?>);"></span>
						</a>
						<?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive)): ?>
							<div class="sesproduct_labels">
								<?php if(isset($this->featuredLabelActive) && $item->featured): ?>
									<p class="sesproduct_label_featured" title="<?php echo $this->translate('Featured');?>"><i class="fa fa-star"></i></p>
								<?php endif; ?>
								<?php if(isset($this->sponsoredLabelActive) && $item->sponsored): ?>
									<p class="sesproduct_label_sponsored" title="<?php echo $this->translate('Sponsored');?>"><i class="fa fa-star"></i></p>
								<?php endif; ?>
							</div>
						<?php endif; ?>
						<?php if((isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.sharing', 1)) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive)):?>
							<?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref()); ?>
							<div class="sesproduct_img_thumb_over"> 
								<a href="<?php echo $href; ?>" data-url="<?php echo $item->getType() ?>"></a>
								<div class="sesproduct_list_grid_thumb_btns"> 
									<?php if(isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.sharing', 1)): ?>
	                  <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item)); ?>
									<?php endif;?>
									<?php $itemtype = 'sesproduct';?>
									<?php $getId = 'product_id';?>
									<?php $canComment =  $item->authorization()->isAllowed($this->viewer, 'comment');?>
									<?php if(isset($this->likeButtonActive) && $canComment):?>
										<!--Like Button-->
										<?php $LikeStatus = Engine_Api::_()->sesproduct()->getLikeStatusProduct($item->$getId, $item->getType()); ?>
										<a href="javascript:;" data-url="<?php echo $item->$getId ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sesproduct_like_<?php echo $itemtype; ?> <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $item->like_count; ?></span></a>
									<?php endif; ?>
									<?php if(isset($this->favouriteButtonActive) && isset($item->favourite_count) && $this->viewer_id && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.favourite', 1)):?>
										<?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'sesproduct')->isFavourite(array('resource_type'=>'sesproduct','resource_id'=>$item->product_id));
										$favClass = ($favStatus)  ? 'button_active' : '';?>
										<?php $shareOptions = "<a href='javascript:;' class='sesbasic_icon_btn sesbasic_icon_btn_count sesproduct_favourite_sesproduct_product_". $item->product_id." sesbasic_icon_fav_btn sesproduct_favourite_sesproduct_product ".$favClass ."' data-url=\"$item->product_id\"><i class='fa fa-heart'></i><span>$item->favourite_count</span></a>";?>
										<?php echo $shareOptions;?>
									<?php endif;?>
									<?php if(isset($this->listButtonActive) && $this->viewer_id): ?>
										<a href="javascript:;" onclick="opensmoothboxurl('<?php echo $this->url(array('action' => 'add','module'=>'sesproduct','controller'=>'list','product_id'=>$item->product_id),'default',true); ?>')" class="sesbasic_icon_btn  sesproduct_add_list"  title="<?php echo  $this->translate('Add To List'); ?>" data-url="<?php echo $item->product_id ; ?>"><i class="fa fa-plus"></i></a>
									<?php endif; ?>
								</div>
							</div>
						<?php endif; ?>
					</div>
					<div class="sesproduct_grid_info sesbasic_clearfix">
	          <?php if(Engine_Api::_()->getApi('core', 'sesproduct')->allowReviewRating() && isset($this->ratingStarActive)):?>
							<?php echo $this->partial('_productRating.tpl', 'sesproduct', array('rating' => $item->rating, 'class' => 'sesproduct_list_rating sesproduct_list_view_ratting', 'style' => 'margin-bottom:5px;'));?>
						<?php endif;?>
						<?php if(isset($this->titleActive) ): ?>
							<div class="sesproduct_grid_heading">
								<div class="sesproduct_grid_info_title">
									<?php if(strlen($item->getTitle()) > $this->title_truncation):?>
										<?php $title = mb_substr($item->getTitle(),0,$this->title_truncation).'...';?>
										<?php echo $this->htmlLink($item->getHref(),$title, array('data-src' => $item->getGuid())) ?>
									<?php else: ?>
										<?php echo $this->htmlLink($item->getHref(),$item->getTitle(), array('data-src' => $item->getGuid())) ?>
									<?php endif; ?>
									<?php if(isset($this->verifiedLabelActive) && $item->verified == 1): ?>
										<i class="sesproduct_verified_sign fa fa-check-circle"></i>
									<?php endif; ?>
								</div>
								<?php if(isset($this->verifiedLabelActive) && $item->verified == 1): ?>
									<div class="sesproduct_verify">
		                <i class="sesproduct_label_verified sesbasic_verified_icon" title="Verified"></i>
		              </div>
								<?php endif; ?>
							</div>
						<?php endif; ?>
						<div class="sesproduct_grid_meta_block">
							<?php if(isset($this->storeNameActive)): ?>
								<?php $store = Engine_Api::_()->getItem('stores',$item->store_id); ?>
							  <?php if(count($store)) { ?>
									<div class="sesproduct_product_stat sesbasic_text_light">
										<div class="sesproduct_store_name">
											<div class="store_logo">
												<a href="<?php echo $store->getHref();?>"><?php echo $this->itemPhoto($store, 'thumb.icon');?></a>
											</div>
										  <div class="store_name sesbasic_text_light">
										  	<?php echo $this->htmlLink($store->getHref(), $store->getTitle()); ?>
										 	</div> 	
										</div>
									</div>
			          <?php } ?>
							<?php endif; ?>
		          <?php if(isset($this->creationDateActive)): ?>
			          <div class="sesproduct_product_stat sesbasic_text_light">
			          	<span>
			            	<i class="fa fa-calendar"></i>
			            	<?php if($item->publish_date): ?>
			            		<?php echo date('M d, Y',strtotime($item->publish_date));?>
			            	<?php else: ?>
			            		<?php echo date('M d, Y',strtotime($item->creation_date));?>
			            	<?php endif; ?>
			            </span> 
			  				</div>
		          <?php endif;?>
            	<?php if(isset($this->brandActive) && $item->brand != ''): ?>
                <div class="sesproduct_product_brand sesbasic_text_light">
                    <span> <i class="fa fa-cube" title=""></i> <a href="#"><?php echo $item->brand ?></a> </span>
                </div>
            	<?php endif;?>
            	<?php if(isset($this->stockActive)){  ?>
                <?php  include(APPLICATION_PATH.'/application/modules/Sesproduct/views/scripts/_stock.tpl'); ?>
            	<?php } ?>
							<?php if(isset($this->categoryActive)): ?>
								<?php if($item->category_id != '' && intval($item->category_id) && !is_null($item->category_id)):?>
									<?php $categoryItem = Engine_Api::_()->getItem('sesproduct_category', $item->category_id);?>
									<?php if($categoryItem): ?>
		                <div class="sesproduct_product_stat sesbasic_text_light">
		                  <span>
		                    <i class="fa fa-folder-open" title="<?php echo $this->translate('Category'); ?>"></i>
		                    <a href="<?php echo $categoryItem->getHref(); ?>"><?php echo $categoryItem->category_name; ?></a>
		                  </span>
		                </div>
		              <?php endif; ?>
								<?php endif; ?>
							<?php endif; ?>
							<?php if(isset($this->locationActive) && $item->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.location', 1)):?>
								<div class="sesproduct_product_stat sesbasic_text_light"> 
									<span>
										<i class="fa fa-map-marker sesbasic_text_light" title="<?php echo $this->translate('Location');?>"></i>
										<?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)) { ?><a href="<?php echo $this->url(array('resource_id' => $item->product_id,'resource_type'=>'sesproduct','action'=>'get-direction'), 'sesbasic_get_direction', true) ;?>" class="opensmoothboxurl" title="<?php echo $item->location;?>"><?php echo $item->location;?></a><?php } else { ?><?php echo $item->location;?><?php } ?>
									</span>
								</div>
							<?php endif; ?>
						</div>
        		<?php if(isset($this->descriptionActive)){ ?>
            	<div class="sesproduct_listing_item_des">
                <p class="sesproduct_product_description"> <?php echo $this->string()->truncate($this->string()->stripTags($item->body), $this->description_truncation_grid) ?> </p>
            	</div>
         		<?php } ?>
		        <div class="sesbasic_clearfix sesbasic_bxs clear">
		          <?php if(isset($this->priceActive)){ ?>
		            <?php  include(APPLICATION_PATH."/application/modules/Sesproduct/views/scripts/_productPrice.tpl"); ?>
		          <?php } ?>
		        <?php if(isset($this->ratingActive)){ ?>
		            <?php include APPLICATION_PATH .  '/application/modules/Sesproduct/views/scripts/_productRatingStat.tpl';?>
		        <?php } ?>
		        </div>
		        <div class="sesproduct_add_cart sesbasic_clearfix">
		          <div class="cart_only_text hidden">
		           <?php if(isset($this->addCartActive)){ ?>
		              <?php echo $this->partial('_addToCart.tpl','sesproduct',array('item'=>$item)); ?>
		          <?php } ?>
		          <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.wishlist', 1) && isset($this->addWishlistActive)): ?>
		          	<a href="javascript:;" class="add-cart sesproduct_wishlist" data-rel="<?php echo $item->getIdentity(); ?>"  title="<?php echo $this->translate('Add to Wishlist'); ?>"><?php echo $this->translate('Add to Wishlist'); ?></a>
		          <?php endif; ?>
		         </div>
		          <div class="cart_only_icon">
		            <?php if(isset($this->addCartActive) ){ ?>
		              <?php echo $this->partial('_addToCart.tpl','sesproduct',array('item'=>$item,'icon'=>true)); ?>
		           <?php } ?>
		            <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.wishlist', 1)  && isset($this->addWishlistActive)): ?>
		            <a href="javascript:;" class="add-cart sesproduct_wishlist" data-rel="<?php echo $item->getIdentity(); ?>"  title="<?php echo $this->translate('Add to Wishlist'); ?>"><i class="fa fa-bookmark-o"></i></a>
		            <?php endif; ?>  
		          </div>
		        </div>
	          <?php if(isset($this->addCartActive) ){ ?>
	          	<div class="sesproduct_product_compare sesbasic_clearfix">
	            	<?php include(APPLICATION_PATH."/application/modules/Sesproduct/views/scripts/_addToCompare.tpl"); ?>
	            </div>
	          <?php } ?>
					</div>
				</div>
			</article>
		</li>
  <?php elseif($this->view_type == 'grid2'): ?>
    <li class="sesproduct_grid sesproduct_list_grid_thumb sesproduct_list_grid" style="width:<?php echo is_numeric($this->width) ? $this->width.'px' : $this->width ?>;">
			<div class="sesproduct_grid_inner sesproduct_thumb">
				<div class="sesproduct_grid_thumb sesproduct_thumb" style="height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height ?>;">
					<?php $href = $item->getHref();$imageURL = $item->getPhotoUrl('thumb.profile');?>
					<a href="<?php echo $href; ?>" class="sesproduct_thumb_img">
						<span class="main_image_container" style="background-image:url(<?php echo $imageURL; ?>);"></span>
					</a>
					<?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive)): ?>
						<div class="sesproduct_grid_labels">
							<?php if(isset($this->featuredLabelActive) && $item->featured): ?>
								<p class="sesproduct_label_featured"><?php echo $this->translate('Featured');?></p>
							<?php endif; ?>
							<?php if(isset($this->sponsoredLabelActive) && $item->sponsored): ?>
								<p class="sesproduct_label_sponsored"><?php echo $this->translate('Sponsored');?></p>
							<?php endif; ?>
						</div>
					<?php endif; ?>
          <?php if(isset($this->verifiedLabelActive) && $item->verified == 1): ?>
						<div class="sesproduct_verified_label" title="<?php echo $this->translate("Verified"); ?>" style=""><i class="fa fa-check"></i></div>
					<?php endif; ?>
				</div>
				<div class="sesproduct_grid_info clear sesbasic_clearfix sesbm">
					<?php if(isset($this->titleActive) ): ?>
						<div class="sesproduct_grid_info_title">
							<?php if(strlen($item->getTitle()) > $this->title_truncation):?>
								<?php $title = mb_substr($item->getTitle(),0,$this->title_truncation).'...';?>
								<?php echo $this->htmlLink($item->getHref(),$title) ?>
							<?php else: ?>
								<?php echo $this->htmlLink($item->getHref(),$item->getTitle()) ?>
							<?php endif; ?>
							<?php if(isset($this->verifiedLabelActive) && $item->verified == 1): ?>
								<i class="sesproduct_verified_sign fa fa-check-circle"></i>
							<?php endif; ?>
						</div>
					<?php endif; ?>
          <?php if(Engine_Api::_()->getApi('core', 'sesproduct')->allowReviewRating() && isset($this->ratingStarActive)):?>
					<?php echo $this->partial('_productRating.tpl', 'sesproduct', array('rating' => $item->rating, 'class' => 'sesproduct_list_rating sesproduct_list_view_ratting', 'style' => 'margin-bottom:5px;'));?>
				<?php endif;?>
				<?php $store = Engine_Api::_()->getItem('stores',$item->store_id); ?>
					<?php if(isset($this->storeNameActive) && count($store)): ?>
          <div class="sesproduct_list_grid_info sesbasic_clearfix">
						<div class="sesproduct_list_stats">
							<span class="sesproduct_list_grid_owner">
								<a href="<?php echo $store->getHref();?>"><?php echo $this->itemPhoto($store, 'thumb.icon');?></a>
								<?php echo $this->translate('By');?>
								<?php echo $this->htmlLink($store->getHref(),$store->getTitle()) ?>
							</span>
						</div>
            <?php if(isset($this->locationActive) && $item->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.location', 1)):?>
              <div class="sesproduct_list_stats sesproduct_list_location sesbasic_text_light">
                <span class="widthfull">
                <i class="fa fa-map-marker sesbasic_text_light" title="<?php echo $this->translate('Location');?>"></i>
                  <span title="<?php echo $item->location; ?>"> <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)) { ?><a href="<?php echo $this->url(array('resource_id' => $item->product_id,'resource_type'=>'sesproduct','action'=>'get-direction'), 'sesbasic_get_direction', true) ;?>" class="opensmoothboxurl" title="<?php echo $item->location;?>"><?php echo $item->location;?></a><?php } else { ?><?php echo $item->location;?><?php } ?> </span>
                </span>
              </div>
					<?php endif; ?>
					<?php endif; ?>
          </div>
				</div>
        <div class="sesproduct_grid_hover_block">
          <?php if(isset($this->titleActive) ): ?>
						<div class="sesproduct_grid_info_hover_title">
							<?php if(strlen($item->getTitle()) > $this->title_truncation):?>
								<?php $title = mb_substr($item->getTitle(),0,$this->title_truncation).'...';?>
								<?php echo $this->htmlLink($item->getHref(),$title, array('data-src' => $item->getGuid())) ?>
							<?php else: ?>
								<?php echo $this->htmlLink($item->getHref(),$item->getTitle(), array('data-src' => $item->getGuid())) ?>
							<?php endif; ?>
							<?php if(isset($this->verifiedLabelActive) && $item->verified == 1): ?>
								<i class="sesproduct_verified_sign fa fa-check-circle"></i>
							<?php endif; ?>
              <span></span>
						</div>
					<?php endif; ?>
          <?php if(isset($this->categoryActive)): ?>
						<?php if($item->category_id != '' && intval($item->category_id) && !is_null($item->category_id)):?>
							<?php $categoryItem = Engine_Api::_()->getItem('sesproduct_category', $item->category_id);?>
							<?php if($categoryItem): ?>
                <div class="sesproduct_admin_category sesbasic_clearfix">
                  <span>
                    <i class="fa fa-folder-open sesbasic_text_light" title="<?php echo $this->translate('Category:'); ?>"></i>
                    <a href="<?php echo $categoryItem->getHref(); ?>"><?php echo $categoryItem->category_name; ?></a>
                    <?php $subcategory = Engine_Api::_()->getItem('sesproduct_category',$item->subcat_id); ?>
                    <?php if($subcategory && $item->subcat_id) { ?>
                    &nbsp;&raquo;&nbsp;<a href="<?php echo $subcategory->getHref(); ?>"><?php echo $subcategory->category_name; ?></a>
                    <?php } ?>
                    <?php $subsubcategory = Engine_Api::_()->getItem('sesproduct_category',$item->subsubcat_id); ?>
                    <?php if($subsubcategory && $item->subsubcat_id) { ?>
                    &nbsp;&raquo;&nbsp;<a href="<?php echo $subsubcategory->getHref(); ?>"><?php echo $subsubcategory->category_name; ?></a>
                    <?php } ?>
                  </span>
                </div>
              <?php endif; ?>
						<?php endif; ?>
					<?php endif; ?>
					<div class="sesproduct_grid_des clear">
					<?php if(strlen($item->body) > $this->description_truncation):?>
							<?php $body = mb_substr($item->body,0,$this->description_truncation).'...';?>
							<?php echo strip_tags($body);?>
						<?php  else : ?>
							<?php echo strip_tags($item->body); ?>
						<?php endif; ?>
					</div>
					<div class="sesproduct_grid_hover_block_footer">
						<div class="sesproduct_list_stats sesbasic_text_light">
								<?php if(isset($this->likeActive) && isset($item->like_count)) { ?>
									<span title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count)); ?>"><i class="fa fa-thumbs-up sesbasic_text_light"></i><?php echo $item->like_count; ?></span>
								<?php } ?>
								<?php if(isset($this->commentActive) && isset($item->comment_count)) { ?>
									<span title="<?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber($item->comment_count))?>"><i class="fa fa-comment sesbasic_text_light"></i><?php echo $item->comment_count;?></span>
								<?php } ?>
								<?php if(isset($this->viewActive) && isset($item->view_count)) { ?>
									<span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count))?>"><i class="fa fa-eye sesbasic_text_light"></i><?php echo $item->view_count; ?></span>
								<?php } ?>
								<?php if(isset($this->favouriteActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.favourite', 1)) { ?>
									<span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count))?>"><i class="fa fa-heart sesbasic_text_light"></i><?php echo $item->favourite_count; ?></span>
								<?php } ?>
						</div>
					</div>
        </div>
          <?php if((isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.sharing', 1)) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive)):?>
						<?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref()); ?>
						<div class="sesproduct_img_thumb_over"> 
							<a href="<?php echo $href; ?>" data-url = "<?php echo $item->getType() ?>"></a>
							<div class="sesproduct_list_grid_thumb_btns"> 
								<?php if(isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.sharing', 1)): ?>
                  
                  <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item)); ?>

								<?php endif;?>
								<?php $itemtype = 'sesproduct';?>
								<?php $getId = 'product_id';?>
								<?php $canComment =  $item->authorization()->isAllowed($this->viewer, 'comment');?>
								<?php if(isset($this->likeButtonActive) && $canComment):?>
									<!--Like Button-->
									<?php $LikeStatus = Engine_Api::_()->sesproduct()->getLikeStatusProduct($item->$getId, $item->getType()); ?>
									<a href="javascript:;" data-url="<?php echo $item->$getId ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sesproduct_like_sesproduct_product_<?php echo $item->product_id ?> sesproduct_like_<?php echo $itemtype; ?> <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $item->like_count; ?></span></a>
								<?php endif; ?>
								<?php if(isset($this->favouriteButtonActive) && isset($item->favourite_count) && $this->viewer_id && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.favourite', 1)):?>
									<?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'sesproduct')->isFavourite(array('resource_type'=>'sesproduct','resource_id'=>$item->product_id));
									$favClass = ($favStatus)  ? 'button_active' : '';?>
									<?php $shareOptions = "<a href='javascript:;' class='sesbasic_icon_btn sesbasic_icon_btn_count sesproduct_favourite_sesproduct_product_". $item->product_id." sesbasic_icon_fav_btn sesproduct_favourite_sesproduct_product ".$favClass ."' data-url=\"$item->product_id\"><i class='fa fa-heart'></i><span>$item->favourite_count</span></a>";?>
									<?php echo $shareOptions;?>
								<?php endif;?>
								<?php if(isset($this->listButtonActive) && $this->viewer_id): ?>
									<a href="javascript:;" onclick="opensmoothboxurl('<?php echo $this->url(array('action' => 'add','module'=>'sesproduct','controller'=>'list','product_id'=>$item->product_id),'default',true); ?>')" class="sesbasic_icon_btn  sesproduct_add_list"  title="<?php echo  $this->translate('Add To List'); ?>" data-url="<?php echo $item->product_id ; ?>"><i class="fa fa-plus"></i></a>
								<?php endif; ?>
							</div>
						</div>
					<?php endif; ?>
			</div>
		</li>
	<?php endif; ?>
<?php endforeach; ?>
