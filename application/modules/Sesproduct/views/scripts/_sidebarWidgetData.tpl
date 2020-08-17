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
         <?php if(isset($this->priceActive)) { ?>
             <?php  include(APPLICATION_PATH."/application/modules/Sesproduct/views/scripts/_productPrice.tpl"); ?>
         <?php } ?>  
        <?php if(isset($this->ratingStarActive)): ?>
          <div class="sesproduct_sidebar_product_list_date sesbasic_text_light">
            <?php include APPLICATION_PATH .  '/application/modules/Sesproduct/views/scripts/_rating.tpl';?>
          </div>
				<?php  endif; ?>
				<div class="sesproduct_sidebar_product_list_date sesbasic_text_light sesproduct_sidebar_list_date">
					<?php $store = Engine_Api::_()->getItem('stores',$item->store_id); ?>
					<?php if(isset($this->storeNameActive) && count($store)): ?>
						<span><i class="fa fa-store"></i><?php echo $this->htmlLink($store->getHref(),$store->getTitle()) ?></span>
					<?php endif; ?>
					<?php if(isset($this->creationDateActive)):?>
						<span><i class="far fa-calendar"></i><?php echo date('M d, Y',strtotime($item->publish_date));?></span>
					<?php endif;?>
				</div>
				<?php  if(isset($this->locationActive) && $item->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.location', 1)): ?>
					<div class="sesproduct_sidebar_product_list_date sesproduct_list_location">
						<span class="widthfull">
							<i class="fa fa-map-marker-alt sesbasic_text_light" title="<?php echo $this->translate('Location');?>"></i>
							<span title="<?php echo $item->location; ?>"> <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)) { ?><a href="<?php echo $this->url(array('resource_id' => $item->product_id,'resource_type'=>'sesproduct','action'=>'get-direction'), 'sesbasic_get_direction', true) ;?>" class="opensmoothboxurl" title="<?php echo $item->location;?>"><?php echo $item->location;?></a><?php } else { ?><?php echo $item->location;?><?php } ?> </span>
						</span>
					</div>
				<?php endif; ?>
				<?php if(isset($this->categoryActive)): ?>
					<?php if($item->category_id != '' && intval($item->category_id) && !is_null($item->category_id)):?>
						<?php $categoryItem = Engine_Api::_()->getItem('sesproduct_category', $item->category_id);?>
            <?php if($categoryItem): ?>
              <div class="sesproduct_sidebar_product_list_date">
                  <i class="far fa-folder-open sesbasic_text_light" title="<?php echo $this->translate('Category:'); ?>"></i> 
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
            <span title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count)); ?>"><i class="far fa-thumbs-up sesbasic_text_light"></i><?php echo $item->like_count; ?></span>
          <?php } ?>
          <?php if(isset($this->commentActive) && isset($item->comment_count)) { ?>
            <span title="<?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber($item->comment_count))?>"><i class="far fa-comment sesbasic_text_light"></i><?php echo $item->comment_count;?></span>
          <?php } ?>
          <?php if(isset($this->viewActive) && isset($item->view_count)) { ?>
            <span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count))?>"><i class="far fa-eye sesbasic_text_light"></i><?php echo $item->view_count; ?></span>
          <?php } ?>
          <?php if(isset($this->favouriteActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.favourite', 1)) { ?>
            <span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count))?>"><i class="far fa-heart sesbasic_text_light"></i><?php echo $item->favourite_count; ?></span>
          <?php } ?>
        </div>
			</div>
		</li>
	<?php elseif($this->view_type == 'grid1'): ?>
		<li class="sesproduct_grid sesbasic_clearfix" style="width:<?php echo is_numeric($this->width) ? $this->width.'px' : $this->width ?> ; ">
			<article>
				<div class="sesproduct_thumb">
					<div class="sesproduct_grid_thumb" style="height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height ?>;">
						<?php $href = $item->getHref();$imageURL = $item->getPhotoUrl('thumb.profile');?>
						<a href="<?php echo $href; ?>" class="sesproduct_thumb_img">
							<span class="floatL" style="background-image:url(<?php echo $imageURL; ?>);"></span>
						</a>
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
						<?php if(isset($this->titleActive) ): ?>
							<div class="sesproduct_grid_heading">
								<div class="sesproduct_grid_info_title">
									<?php if(strlen($item->getTitle()) > $this->title_truncation):?>
										<?php $title = mb_substr($item->getTitle(),0,$this->title_truncation).'...';?>
										<?php echo $this->htmlLink($item->getHref(),$title, array('data-src' => $item->getGuid())) ?>
									<?php else: ?>
										<?php echo $this->htmlLink($item->getHref(),$item->getTitle(), array('data-src' => $item->getGuid())) ?>
									<?php endif; ?>
								</div>
							</div>
						<?php endif; ?>
						<div class="sesproduct_grid_meta_block">
            <div class="sesbasic_clearfix sesbasic_bxs clear">
		        <?php if(isset($this->ratingActive)){ ?>
		            <?php include APPLICATION_PATH .  '/application/modules/Sesproduct/views/scripts/_rating.tpl';?>
		        <?php } ?>
		        </div>
							<?php if(isset($this->storeNameActive)): ?>
								<?php $store = Engine_Api::_()->getItem('stores',$item->store_id); ?>
							  <?php if(count($store)) { ?>
									<div class="sesproduct_product_stat sesbasic_text_light">
										  <span>
										  	<i class="fa fa-store"></i><?php echo $this->htmlLink($store->getHref(), $store->getTitle()); ?>
										 </span>
									</div>
			          <?php } ?>
							<?php endif; ?>
		          <?php if(isset($this->creationDateActive)): ?>
			          <div class="sesproduct_product_stat sesbasic_text_light">
			          	<span>
			            	<i class="far fa-calendar"></i>
			            	<?php if($item->publish_date): ?>
			            		<?php echo date('M d, Y',strtotime($item->publish_date));?>
			            	<?php else: ?>
			            		<?php echo date('M d, Y',strtotime($item->creation_date));?>
			            	<?php endif; ?>
			            </span> 
			  				</div>
		          <?php endif;?>
							<?php if(isset($this->categoryActive)): ?>
								<?php if($item->category_id != '' && intval($item->category_id) && !is_null($item->category_id)):?>
									<?php $categoryItem = Engine_Api::_()->getItem('sesproduct_category', $item->category_id);?>
									<?php if($categoryItem): ?>
		                <div class="sesproduct_product_stat sesbasic_text_light">
		                  <span>
		                    <i class="far fa-folder-open" title="<?php echo $this->translate('Category'); ?>"></i>
		                    <a href="<?php echo $categoryItem->getHref(); ?>"><?php echo $categoryItem->category_name; ?></a>
		                  </span>
		                </div>
		              <?php endif; ?>
								<?php endif; ?>
							<?php endif; ?>
							<?php if(isset($this->locationActive) && $item->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.location', 1)):?>
								<div class="sesproduct_product_stat sesbasic_text_light"> 
									<span>
										<i class="fa fa-map-marker-alt sesbasic_text_light" title="<?php echo $this->translate('Location');?>"></i>
										<?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)) { ?><a href="<?php echo $this->url(array('resource_id' => $item->product_id,'resource_type'=>'sesproduct','action'=>'get-direction'), 'sesbasic_get_direction', true) ;?>" class="opensmoothboxurl" title="<?php echo $item->location;?>"><?php echo $item->location;?></a><?php } else { ?><?php echo $item->location;?><?php } ?>
									</span>
								</div>
							<?php endif; ?>
              <?php if(isset($this->priceActive)) { ?>
                <?php  include(APPLICATION_PATH."/application/modules/Sesproduct/views/scripts/_productPrice.tpl"); ?>
             <?php } ?> 
						</div>
					</div>
				</div>
			</article>
		</li>
	<?php endif; ?>
<?php endforeach; ?>
