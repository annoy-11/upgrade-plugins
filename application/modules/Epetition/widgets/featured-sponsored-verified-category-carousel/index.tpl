<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php $identity = $this->identity;?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Epetition/externals/styles/styles.css'); ?>
<?php
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Epetition/externals/scripts/jquery.js');
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Epetition/externals/scripts/owl.carousel.js') ?>
<div class="slide sesbasic_clearfix sesbasic_bxs epetition_category_carousel_wrapper <?php echo $this->isfullwidth ? 'isfull_width' : '' ; ?>" style="height:<?php echo $this->height ?>px;">
  <div class="fspetitionslide_<?php echo $this->identity; ?> owl-carousel owl-theme epetition_fs_carousel" style="height:<?php echo $this->height ?>px;">
    <?php foreach( $this->paginator as $item): ?>
    <div class="epetition_category_carousel_item sesbasic_clearfix epetition_grid_btns_wrap" style="height:<?php echo $this->height ?>px;width:<?php echo $this->width ?>px;">
      <div class="epetition_category_carousel_item_thumb epetition_thumb" style="height:<?php echo $this->height ?>px;">       
        <?php
        $href = $item->getHref();
        $imageURL = $item->getPhotoUrl();
        ?>
        <a href="<?php echo $href; ?>" class="epetition_list_thumb_img">
          <span style="background-image:url(<?php echo $imageURL; ?>);"></span>
        </a>
        <?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) || isset($this->verifiedLabelActive)):?>
          <div class="epetition_listing_label">
            <?php if(isset($this->featuredLabelActive) && $item->featured == 1):?>
              <p class="epetition_label_featured"><?php echo $this->translate('FEATURED');?></p>
            <?php endif;?>
            <?php if(isset($this->sponsoredLabelActive) && $item->sponsored == 1):?>
              <p class="epetition_label_sponsored"><?php echo $this->translate('SPONSORED');?></p>
            <?php endif;?>
            <?php if(isset($this->verifiedLabelActive) && $item->verified == 1):?>
              <p class="epetition_label_verified"><?php echo $this->translate('VERIFIED');?></p>
            <?php endif;?>
      
          </div>
        <?php endif;?>
		<?php if((isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition.enable.sharing', 1)) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive)):?>
				<?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref()); ?>
					<div class="epetition_item_thumb_over_btns"> 
						<?php if(isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition.enable.sharing', 1)):?>
              <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>

						<?php endif;?>
						<?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 ):?>
							<?php $canComment =  $item->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');?>
							<?php if(isset($this->likeButtonActive) && $canComment):?>
								<!--Like Button-->
								<?php $LikeStatus = Engine_Api::_()->epetition()->getLikeStatus($item->epetition_id,$item->getType()); ?>
								<a href="javascript:;" data-url="<?php echo $item->epetition_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn epetition_like_epetition_petition_<?php echo $item->epetition_id ?> epetition_like_epetition <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $item->like_count; ?></span></a>
							<?php endif;?>
							<?php if(isset($this->favouriteButtonActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition.enable.favourite', 1)): ?>
								<?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'epetition')->isFavourite(array('resource_type'=>'epetition_petition','resource_id'=>$item->epetition_id)); ?>
								<a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn epetition_favourite_epetition_petition_<?php echo $item->epetition_id ?> epetition_favourite_epetition <?php echo ($favStatus)  ? 'button_active' : '' ?>"  data-url="<?php echo $item->epetition_id ; ?>"><i class="fa fa-heart"></i><span><?php echo $item->favourite_count; ?></span></a>
							<?php endif;?>
						<?php endif;?>
					</div>
			<?php endif;?> 
        </div>
				<div class="epetition_item_info sesbasic_clearfix">
        <?php if(isset($this->titleActive) ){ ?>
            <span class="epetition_category_carousel_item_info_title">
              <?php if(strlen($item->getTitle()) > $this->title_truncation){ 
                $title = mb_substr($item->getTitle(),0,$this->title_truncation).'...';
                echo $this->htmlLink($item->getHref(),$title) ?>
              <?php }else{ ?>
              	<?php echo $this->htmlLink($item->getHref(),$item->getTitle() ) ?>
              <?php } ?>
							<?php if(Engine_Api::_()->getApi('core', 'epetition')->allowSignatureRating() && isset($this->ratingStarActive)):?>
								<?php echo $this->partial('_petitionRating.tpl', 'epetition', array('rating' => $item->rating, 'class' => 'epetition_list_rating epetition_list_view_ratting', 'style' => 'margin-bottom:0px; margin-top:5px;'));?>
							<?php endif;?>
            </span>
          <?php } ?>
          <div class="epetition_category_carousel_cont">
					<?php if(isset($this->categoryActive)){ ?>
						<?php if($item->category_id != '' && intval($item->category_id) && !is_null($item->category_id)):?> 
							<?php $categoryItem = Engine_Api::_()->getItem('epetition_category', $item->category_id);?>
							<?php if($categoryItem):?>
								<div class="category_tag sesbasic_clearfix">
										<a href="<?php echo $categoryItem->getHref(); ?>"><i class="fa fa-folder-open"></i> <?php echo $categoryItem->category_name; ?></a>
								</div>
							<?php endif;?>
						<?php endif;?>
					<?php } ?>
          <?php if(isset($this->byActive)){ ?>
				<div class="admin_teg epetition_list_stats sesbasic_text_dark">
					<i class="fa fa-user"></i> <?php $owner = $item->getOwner(); ?>
					<span>
						<?php echo $this->translate("by") ?> <?php echo $this->htmlLink($owner->getHref(),$owner->getTitle() ) ?>
					</span>
				</div>
			<?php } ?>
      <?php if(isset($this->creationDateActive)){ ?>
				<div class="admin_teg epetition_list_stats sesbasic_text_dark"><i class="fa fa-calendar"></i> <?php echo ' '.date('M d, Y',strtotime($item->publish_date));?></div>
			<?php } ?>
      </div>
      <div class="epetition_list_stats">
			<?php if(isset($this->likeActive) && isset($item->like_count)) { ?>
				<span onclick="" title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count)); ?>"><i class="sesbasic_icon_like_o"></i><?php echo $item->like_count; ?></span>
			<?php } ?>
			<?php if(isset($this->commentActive) && isset($item->comment_count)) { ?>
				<span title="<?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber($item->comment_count))?>"><i class="sesbasic_icon_comment_o"></i><?php echo $item->comment_count;?> </span>
			<?php } ?>
			<?php if(isset($this->favouriteActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition.enable.favourite', 1)) { ?>
				<span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count))?>"><i class="sesbasic_icon_favourite_o"></i>
        <?php echo $item->favourite_count;?> </span>
			<?php } ?>
			<?php if(isset($this->viewActive) && isset($item->view_count)) { ?>
				<span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count))?>"><i class="sesbasic_icon_view"></i><?php echo $item->view_count; ?></span>
			<?php } ?>
			<?php include APPLICATION_PATH .  '/application/modules/Epetition/views/scripts/_petitionRatingStat.tpl';?>
		</div>
        </div>
        </div>
    <?php endforeach; ?>
  </div>
</div>
<script type="text/javascript">
  sesblogJqueryObject(".epetition_fs_carousel").owlCarousel({
  nav:true,
  dots:false,
  items:1,
  loop:true,
  responsiveClass:true,
	autoplay:true,
  responsive:{
    0:{
        items:1,
    },
    600:{
        items: <?php  echo isset($this->paginator) && count($this->paginator)<4 ?  count($this->paginator) : 4;  ?>,
    },
  }
});
sesblogJqueryObject(".owl-prev").html('<i class="fa fa-angle-left"></i>');
sesblogJqueryObject(".owl-next").html('<i class="fa fa-angle-right"></i>');
</script>
