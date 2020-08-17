<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslisting
 * @package    Seslisting
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-04-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php $identity = $this->identity;?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seslisting/externals/styles/styles.css'); ?>
<?php 
  $baseURL = $this->layout()->staticBaseUrl;
  $this->headScript()->appendFile($baseURL . 'application/modules/Seslisting/externals/scripts/jquery.js');
  $this->headScript()->appendFile($baseURL . 'application/modules/Seslisting/externals/scripts/owl.carousel.js'); 
?>
<div class="seslisting_listings_slideshow_wrapper sesbasic_clearfix sesbasic_bxs">
  <div class="seslisting_listings_slideshow_container sesbasic_clearfix" id="seslisting_listings_slideshow_<?php echo $this->identity; ?>">
    
    <?php if($this->leftListing) { 
      $height = ($this->height -20) / 3;
    ?>
      <div class="_left_col <?php if(empty($this->enableSlideshow)) {?>_norightblock<?php } ?>">
        <?php foreach( $this->paginatorLeft as $item): ?>
          <div class="seslisting_listings_slideshow_left_item">
            <div class="seslisting_listings_slideshow_left_item_thumb" style="height:<?php echo $height ?>px;">       
              <?php
              $href = $item->getHref();
              $imageURL = $item->getPhotoUrl('');
              ?>
              <a href="<?php echo $href; ?>" class="seslisting_listings_slideshow_left_item_thumb_img">
                <span style="background-image:url(<?php echo $imageURL; ?>);"></span>
              </a>
              <?php if((isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.sharing', 1)) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive)):?>
              <?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref()); ?>
                <div class="seslisting_listings_slideshow_item_btns"> 
                  <?php if(isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.sharing', 1)):?>
                    <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
                  <?php endif;?>
                  <?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 ):?>
                    <?php $canComment =  $item->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');?>
                    <?php if(isset($this->likeButtonActive) && $canComment):?>
                      <!--Like Button-->
                      <?php $LikeStatus = Engine_Api::_()->seslisting()->getLikeStatus($item->listing_id,$item->getType()); ?>
                      <a href="javascript:;" data-url="<?php echo $item->listing_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn seslisting_like_seslisting_listing_<?php echo $item->listing_id ?> seslisting_like_seslisting_listing <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $item->like_count; ?></span></a>
                    <?php endif;?>
                    <?php if(isset($this->favouriteButtonActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.favourite', 1)): ?>
                      <?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'seslisting')->isFavourite(array('resource_type'=>'seslisting','resource_id'=>$item->listing_id)); ?>
                      <a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count seslisting_favourite_seslisting_listing_<?php echo $item->listing_id ;?>  sesbasic_icon_fav_btn seslisting_favourite_seslisting_listing <?php echo ($favStatus)  ? 'button_active' : '' ?>"  data-url="<?php echo $item->listing_id ; ?>"><i class="fa fa-heart"></i><span><?php echo $item->favourite_count; ?></span></a>
                    <?php endif;?>
                  <?php endif;?>
                </div>
                <?php endif;?> 
            </div>
            <div class="seslisting_listings_slideshow_left_item_cont">             
              <?php if(isset($this->titleActive) ){ ?>
                <div class="seslisting_listings_slideshow_left_item_title">
                  <?php if(strlen($item->getTitle()) > $this->title_truncation){ 
                    $title = mb_substr($item->getTitle(),0,$this->title_truncation).'...';
                    echo $this->htmlLink($item->getHref(),$title) ?>
                  <?php }else{ ?>
                    <?php echo $this->htmlLink($item->getHref(),$item->getTitle() ) ?>
                  <?php } ?>
                </div>
              <?php } ?>
              <?php $owner = $item->getOwner(); ?>
              <div class="seslisting_listings_slideshow_item_stats">
                <?php if(isset($this->byActive)): ?>
                  <span><i class="fa fa-user"></i><span><?php echo $this->translate("by"); ?> <?php echo $this->htmlLink($owner->getHref(),$owner->getTitle()); ?></span></span>
                <?php endif; ?>
                <?php if($this->creationDateActive): ?>
                  <span><i class="fa fa-calendar"></i><span><?php echo ' '.date('M d, Y',strtotime($item->publish_date));?></span></span>
                <?php endif; ?>
                <?php if(isset($this->likeActive) && isset($item->like_count)) { ?>
                  <span title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count)); ?>"><i class="fa fa-thumbs-up"></i><?php echo $item->like_count; ?></span>
                <?php } ?>
                <?php if(isset($this->commentActive) && isset($item->comment_count)) { ?>
                  <span title="<?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber($item->comment_count))?>"><i class="fa fa-comment"></i><?php echo $item->comment_count;?> </span>
                <?php } ?>
                <?php if(isset($this->favouriteActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.favourite', 1)) { ?>
                  <span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count))?>"><i class="fa fa-heart"></i><?php echo $item->favourite_count;?> </span>
                <?php } ?>
                <?php if(isset($this->viewActive) && isset($item->view_count)) { ?>
                  <span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count))?>"><i class="fa fa-eye"></i><?php echo $item->view_count; ?></span>
                <?php } ?>
                <?php include APPLICATION_PATH .  '/application/modules/Seslisting/views/scripts/_listingRatingStat.tpl';?>
              </div>
            </div>  
            <?php if(isset($this->categoryActive)){ ?>
              <?php if($item->category_id != '' && intval($item->category_id) && !is_null($item->category_id)):?> 
                <?php $categoryItem = Engine_Api::_()->getItem('seslisting_category', $item->category_id);?>
                <?php if($categoryItem):?>
                  <div class="seslisting_listings_slideshow_cat">
                    <span><a href="<?php echo $categoryItem->getHref(); ?>"><?php echo $categoryItem->category_name; ?></a></span>
                  </div>
                <?php endif;?>
              <?php endif;?>
            <?php } ?>    
          </div>
        <?php endforeach; ?>      
      </div>
    <?php } ?>
    <?php if($this->enableSlideshow){ ?>
      <div class="_right_col <?php if(empty($this->leftListing)) {?>_noleftblock<?php } ?>">
        <div autoplay = '<?php echo $this->autoplay ?>' autoplayTimeout = '<?php echo $this->speed ?>' class="seslisting_listings_slideshow" style="height:<?php echo $this->height?>px;">
          <?php foreach( $this->paginatorRight as $item): ?>
          <div class="seslisting_listings_slideshow_item sesbasic_clearfix">
            <div class="seslisting_listings_slideshow_thumb seslisting_thumb" style="height:<?php echo $this->height?>px;">       
              <?php
              $href = $item->getHref();
              $imageURL = $item->getPhotoUrl('');
              ?>
              <a href="<?php echo $href; ?>" class="seslisting_listings_slideshow_thumb_img">
                <span style="background-image:url(<?php echo $imageURL; ?>);"></span>
              </a>
              <?php if((isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.sharing', 1)) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive)):?>
              <?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref()); ?>
                <div class="seslisting_listings_slideshow_item_btns"> 
                  <?php if(isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.sharing', 1)):?>
                    <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
                  <?php endif;?>
                  <?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 ):?>
                    <?php $canComment =  $item->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');?>
                    <?php if(isset($this->likeButtonActive) && $canComment):?>
                      <!--Like Button-->
                      <?php $LikeStatus = Engine_Api::_()->seslisting()->getLikeStatus($item->listing_id,$item->getType()); ?>
                      <a href="javascript:;" data-url="<?php echo $item->listing_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn seslisting_like_seslisting_listing_<?php echo $item->listing_id ?> seslisting_like_seslisting_listing <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $item->like_count; ?></span></a>
                    <?php endif;?>
                    <?php if(isset($this->favouriteButtonActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.favourite', 1)): ?>
                      <?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'seslisting')->isFavourite(array('resource_type'=>'seslisting','resource_id'=>$item->listing_id)); ?>
                      <a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count seslisting_favourite_seslisting_listing_<?php echo $item->listing_id ;?>  sesbasic_icon_fav_btn seslisting_favourite_seslisting_listing <?php echo ($favStatus)  ? 'button_active' : '' ?>"  data-url="<?php echo $item->listing_id ; ?>"><i class="fa fa-heart"></i><span><?php echo $item->favourite_count; ?></span></a>
                    <?php endif;?>
                  <?php endif;?>
                </div>
                <?php endif;?> 
              </div>
            <?php if($this->show_criteria) { ?>
            <div class="seslisting_listings_slideshow_cont">             
              <?php if(isset($this->titleActive) ){ ?>
                <div class="seslisting_listings_slideshow_title">
                  <?php if(strlen($item->getTitle()) > $this->title_truncation){ 
                    $title = mb_substr($item->getTitle(),0,$this->title_truncation).'...';
                    echo $this->htmlLink($item->getHref(),$title) ?>
                  <?php }else{ ?>
                    <?php echo $this->htmlLink($item->getHref(),$item->getTitle() ) ?>
                  <?php } ?>
                </div>
              <?php } ?>
  
              <?php $owner = $item->getOwner(); ?>
              <div class="seslisting_listings_slideshow_item_stats">
                <?php if(isset($this->byActive)): ?>
                <span><i class="fa fa-user"></i><span><?php echo $this->translate("by"); ?> <?php echo $this->htmlLink($owner->getHref(),$owner->getTitle()); ?></span></span>
                <?php endif; ?>
                <?php if($this->creationDateActive): ?>
                <span><i class="fa fa-calendar"></i><span><?php echo ' '.date('M d, Y',strtotime($item->publish_date));?></span></span>
                <?php endif; ?>
                <?php if(isset($this->likeActive) && isset($item->like_count)) { ?>
                  <span title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count)); ?>"><i class="fa fa-thumbs-up"></i><?php echo $item->like_count; ?></span>
                <?php } ?>
                <?php if(isset($this->commentActive) && isset($item->comment_count)) { ?>
                  <span title="<?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber($item->comment_count))?>"><i class="fa fa-comment"></i><?php echo $item->comment_count;?> </span>
                <?php } ?>
                <?php if(isset($this->favouriteActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.favourite', 1)) { ?>
                  <span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count))?>"><i class="fa fa-heart"></i><?php echo $item->favourite_count;?> </span>
                <?php } ?>
                <?php if(isset($this->viewActive) && isset($item->view_count)) { ?>
                  <span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count))?>"><i class="fa fa-eye"></i><?php echo $item->view_count; ?></span>
                <?php } ?>
                <?php include APPLICATION_PATH .  '/application/modules/Seslisting/views/scripts/_listingRatingStat.tpl';?>
              </div>
              <?php if($this->descriptionActive): ?>
                <div class="seslisting_listings_slideshow_des">
                  <?php echo $item->getDescription('150');?>
                </div>
              <?php endif; ?>
              <?php if(isset($this->categoryActive)){ ?>
                <?php if($item->category_id != '' && intval($item->category_id) && !is_null($item->category_id)):?> 
                  <?php $categoryItem = Engine_Api::_()->getItem('seslisting_category', $item->category_id);?>
                  <?php if($categoryItem):?>
                    <div class="seslisting_listings_slideshow_cat">
                      <span><a href="<?php echo $categoryItem->getHref(); ?>"><?php echo $categoryItem->category_name; ?></a></span>
                    </div>
                  <?php endif;?>
                <?php endif;?>
              <?php } ?>
              </div>
              <?php } ?>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
		<?php } ?>
  </div>
</div>
<?php if($this->enableSlideshow): ?>
  <style>
  .owl-prev, .owl-next {
    display:block !important;
  }
  </style>
<?php endif; ?>
