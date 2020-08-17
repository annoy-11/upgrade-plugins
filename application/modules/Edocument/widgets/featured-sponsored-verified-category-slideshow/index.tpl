<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Edocument
 * @package    Edocument
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $baseUrl = $this->layout()->staticBaseUrl; ?>
<?php $this->headLink()->appendStylesheet($baseUrl . 'application/modules/Edocument/externals/styles/styles.css'); ?>
<?php $this->headLink()->appendStylesheet($baseUrl . 'application/modules/Edocument/externals/styles/slideshow.css'); ?>

<div class="edocument_slideshow_document_wrapper sesbasic_clearfix sesbasic_bxs <?php if($this->navigation != 'nextprev'){ echo " isbulletnav " ; } echo $this->isfullwidth ? 'isfull_width' : '' ; ?>" style="height:<?php echo $this->height ?>px;">
	<div class="edocument_slideshow_document_container" style="height:<?php echo $this->height ?>px;">
  	<div class="edocument_slideshow">
    	<div class="edocument_slideshow_document" id="edocument_slideshow_<?php echo $this->identity; ?>">
      <ul class="bjqs">
        <?php foreach( $this->paginator as $item): ?>
        <li class="edocument_slideshow_inner_view sesbasic_clearfix " style="height:<?php echo $this->height ?>px;">
          <div class="edocument_slideshow_inside">
          <div class="edocument_slideshow_thumb edocument_thumb" style="height:<?php echo $this->height ?>px;">       
            <a href="<?php echo $item->getHref(); ?>" class="edocument_slideshow_thumb_img">
              <span style="background-image:url(<?php echo $item->getPhotoUrl(''); ?>);"></span>
            </a>
            <?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) || isset($this->verifiedLabelActive)):?>
              <div class="edocument_list_labels">
                <?php if(isset($this->featuredLabelActive) && $item->featured == 1):?>
                  <p class="edocument_label_featured"><?php echo $this->translate('FEATURED');?></p>
                <?php endif;?>
                <?php if(isset($this->sponsoredLabelActive) && $item->sponsored == 1):?>
                  <p class="edocument_label_sponsored"><?php echo $this->translate('SPONSORED');?></p>
                <?php endif;?>
              </div>
              <?php if(isset($this->verifiedLabelActive) && $item->verified == 1):?>
                <div class="edocument_verified_label" title="<?php echo $this->translate('VERIFIED');?>"><i class="fa fa-check"></i></div>
              <?php endif;?>
            <?php endif;?>
        		<?php if((isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('edocument.enable.sharing', 1)) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive)):?>
            <?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref()); ?>
              <div class="edocument_list_grid_thumb_btns"> 
                <?php if(isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('edocument.enable.sharing', 1)):?>
                  <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
                <?php endif;?>
                <?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 ):?>
                  <?php $canComment =  $item->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');?>
                  <?php if(isset($this->likeButtonActive) && $canComment):?>
                    <?php $LikeStatus = Engine_Api::_()->edocument()->getLikeStatus($item->edocument_id,$item->getType()); ?>
                    <a href="javascript:;" data-url="<?php echo $item->edocument_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn edocument_like_edocument_<?php echo $item->edocument_id ?> edocument_like_edocument <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $item->like_count; ?></span></a>
                  <?php endif;?>
                  <?php if(isset($this->favouriteButtonActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('edocument.enable.favourite', 1)): ?>
                    <?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'edocument')->isFavourite(array('resource_type'=>'edocument','resource_id'=>$item->edocument_id)); ?>
                    <a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count edocument_favourite_edocument_<?php echo $item->edocument_id ;?>  sesbasic_icon_fav_btn edocument_favourite_edocument <?php echo ($favStatus)  ? 'button_active' : '' ?>"  data-url="<?php echo $item->edocument_id ; ?>"><i class="fa fa-heart"></i><span><?php echo $item->favourite_count; ?></span></a>
                  <?php endif;?>
                <?php endif;?>
              </div>
          		<?php endif;?> 
            </div>
            </div>
            <div class="edocument_slideshow_inside_contant">
            	<div class="slideshow_contant">
              <div class="edocument_slideshow_info sesbasic_clearfix ">
              <?php if(isset($this->titleActive) ){ ?>
                <span class="edocument_slideshow_info_title">
                  <?php if(strlen($item->getTitle()) > $this->title_truncation){ 
                    $title = mb_substr($item->getTitle(),0,$this->title_truncation).'...';
                    echo $this->htmlLink($item->getHref(),$title) ?>
                  <?php }else{ ?>
                    <?php echo $this->htmlLink($item->getHref(),$item->getTitle() ) ?>
                  <?php } ?>
                </span>
              <?php } ?>
              <?php if(Engine_Api::_()->getApi('core', 'edocument')->allowReviewRating() && isset($this->ratingStarActive)):?>
                <?php echo $this->partial('_documentRating.tpl', 'edocument', array('rating' => $item->rating, 'class' => 'edocument_list_rating edocument_list_view_ratting', 'style' => 'margin-bottom:0px;'));?>
              <?php endif;?>
              <?php if(isset($this->byActive)){ ?>
                <div class="admin_teg edocument_list_stats sesbasic_text_dark">
                      <?php $owner = $item->getOwner(); ?>
                    <?php echo $this->htmlLink($item->getOwner()->getParent(), $this->itemPhoto($item->getOwner()->getParent(), 'thumb.icon')); ?>
                  <span>
                    <?php echo $this->translate("by") ?> <?php echo $this->htmlLink($owner->getHref(),$owner->getTitle() ) ?>
                  </span>
                </div>
              <?php } ?>
           <?php if(isset($this->creationDateActive)){ ?>
            <div class="admin_teg edocument_list_stats sesbasic_text	_dark"><span> <i class="fa fa-calendar"></i> <?php echo ' '.date('M d, Y',strtotime($item->publish_date));?> |</span></div>
          <?php } ?>
          <div class="edocument_list_stats">
          <?php if(isset($this->likeActive) && isset($item->like_count)) { ?>
            <span title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count)); ?>"><i class="fa fa-thumbs-up"></i><?php echo $item->like_count; ?></span>
          <?php } ?>
          <?php if(isset($this->commentActive) && isset($item->comment_count)) { ?>
            <span title="<?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber($item->comment_count))?>"><i class="fa fa-comment"></i><?php echo $item->comment_count;?> </span>
          <?php } ?>
          <?php if(isset($this->favouriteActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('edocument.enable.favourite', 1)) { ?>
            <span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count))?>"><i class="fa fa-heart"></i><?php echo $item->favourite_count;?> </span>
          <?php } ?>
          <?php if(isset($this->viewActive) && isset($item->view_count)) { ?>
            <span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count))?>"><i class="fa fa-eye"></i><?php echo $item->view_count; ?></span>
          <?php } ?>
          <?php include APPLICATION_PATH .  '/application/modules/Edocument/views/scripts/_documentRatingStat.tpl';?>
        </div>
 			   <div class="edocument_slideshow-des">
         	<p><?php echo $item->getDescription('150');?></p>
			 <?php if(isset($this->categoryActive)){ ?>
            <?php if($item->category_id != '' && intval($item->category_id) && !is_null($item->category_id)):?> 
              <?php $categoryItem = Engine_Api::_()->getItem('edocument_category', $item->category_id);?>
              <?php if($categoryItem):?>
                <div class="category_tag sesbasic_clearfix">
                   <span><a href="<?php echo $categoryItem->getHref(); ?>"><?php echo $categoryItem->category_name; ?></a></span>
                </div>
              <?php endif;?>
            <?php endif;?>
          <?php } ?>
         </div>
            </div>
              </div>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
    </div>
  </div>
</div>
<?php $this->headScript()->appendFile($baseUrl . 'application/modules/Edocument/externals/scripts/slideshow/bjqs-1.3.min.js'); ?>
<script type="text/javascript">
window.addEvent('domready', function () {
  <?php if($this->isfullwidth){ ?>
    var htmlElement = document.getElementsByTagName("body")[0];
    htmlElement.addClass('edocument_category_slideshow');
  <?php } ?>
  <?php if($this->autoplay){ ?>
    var autoplay_<?php echo $this->identity; ?> = true;
  <?php }else{ ?>
    var autoplay_<?php echo $this->identity; ?> = false;
  <?php } ?>
  <?php if($this->navigation == 'nextprev'){ ?>
    var navigation_<?php echo $this->identity; ?> = true;
    var markers_<?php echo $this->identity; ?> = false;
  <?php }else{ ?>
    var navigation_<?php echo $this->identity; ?> = false;
    markers_<?php echo $this->identity; ?> = true;
  <?php } ?>
  
    var	width = sesJqueryObject('#edocument_slideshow_<?php echo $this->identity; ?>').outerWidth();
    var	heigth = '<?php echo $this->height ?>';
    sesJqueryObject('#edocument_slideshow_<?php echo $this->identity; ?>').bjqs({
      responsive  : true,// enable responsive capabilities (beta)
      automatic: autoplay_<?php echo $this->identity; ?>,// automatic
      animspeed:<?php echo $this->speed; ?>,// the delay between each slide
      animtype:"<?php echo $this->type; ?>", // accepts 'fade' or 'slide'
      showmarkers:markers_<?php echo $this->identity; ?>,
      showcontrols: navigation_<?php echo $this->identity; ?>,/// center controls verically
      // if responsive is set to true, these values act as maximum dimensions
      width : width,
      height : heigth,
      slidecount: <?php echo count($this->paginator) ?>
    });
});
// On before slide change
sesBasicAutoScroll('.documentslide_<?php echo $this->identity; ?>').on('init', function(event, slick, currentSlide, nextSlide) {
  sesBasicAutoScroll('#edocument_carousel_<?php echo $this->identity; ?>').show();
});
</script>
