<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventspeaker
 * @package    Seseventspeaker
 * @copyright  Copyright 2018-2017 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _sidebarWidgetData.tpl 2017-03-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesevent/externals/scripts/jquery.js');
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesevent/externals/styles/styles.css'); ?>

<?php foreach( $this->paginator as $item ): 
$item = Engine_Api::_()->getItem('seseventspeaker_speakers', $item->speaker_id);
 ?>
<?php if($this->view_type == 'list'): ?>
  <li class="sesbasic_sidebar_list sesbasic_clearfix clear">
    <?php echo $this->htmlLink($item, $this->itemPhoto($item, 'thumb.icon')); ?>
    <div class="sesbasic_sidebar_list_info">
      <?php  if(isset($this->titleActive)){ ?>
        <div class="sesbasic_sidebar_list_title">
          <?php if(strlen($item->getTitle()) > $this->title_truncation_list){
          $title = mb_substr($item->getTitle(),0,$this->title_truncation_list).'...';
	          echo $this->htmlLink($item->getHref(),$title );
          } else { ?>
          <?php echo $this->htmlLink($item->getHref(),$item->getTitle() ) ?>
          <?php } ?>
        </div>
      <?php } ?>
      <?php if(isset($this->locationActive) && $item->location){ ?>
      <div class="sesevent_list_stats sesevent_list_location">
        <span class="widthfull">
          <i class="fa fa-map-marker sesbasic_text_light" title="<?php echo $this->translate('Location');?>"></i>
          <span title="<?php echo $item->location; ?>"><?php echo $item->location ?></span>
        </span>
       </div>
      <?php } ?>
      <div class="sesevent_list_stats">
<!--        <?php if(isset($this->likeActive) && isset($item->like_count)) { ?>
        <span title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count)); ?>"><i class="fa fa-thumbs-up sesbasic_text_light"></i><?php echo $item->like_count; ?></span>
        <?php } ?>-->
        <?php if(isset($this->speakerEventCountActive) && isset($speakerEventCount)) { ?>
          <span title="<?php echo $this->translate(array('%s event', '%s events', $speakerEventCount), $this->locale()->toNumber($speakerEventCount))?>"><i class="fa fa-calendar"></i><?php echo $speakerEventCount; ?></span>
        <?php } ?>
        <?php if(isset($this->viewActive) && isset($item->view_count)) { ?>
        <span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count))?>"><i class="fa fa-eye sesbasic_text_light"></i><?php echo $item->view_count; ?></span>
        <?php } ?>
        <?php if(isset($this->favouriteActive) && isset($item->favourite_count)) { ?>
        <span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count))?>"><i class="fa fa-heart sesbasic_text_light"></i><?php echo $item->favourite_count; ?></span>
        <?php } ?>
      </div>
    </div>
  </li>
<?php else: ?>
  <li class="sesspeaker_list_item sesbasic_clearfix sesbasic_bxs sesevent_grid_btns_wrap" style="width:<?php echo is_numeric($this->width) ? $this->width.'px' : $this->width ?>;">
		<div class="sesspeaker_list_item_inner prelative sesbasic_clearfix">
      <div class="sesspeaker_list_item_thumb prelative " style="height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height ?>;">
        <?php
        $href = $item->getHref();
        $imageURL = $item->getPhotoUrl('thumb.profile');
        ?>
        <span class="sesspeaker_list_item_thumb_img" style="background-image:url(<?php echo $imageURL; ?>);"></span>
        <a href="<?php echo $href; ?>" class="sesspeaker_list_item_thumb_overlay"></a>
        <?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive)){ ?>
          <p class="sesevent_labels">
            <?php if(isset($this->featuredLabelActive) && $item->featured){ ?>
            <span class="sesevent_label_featured"><?php echo $this->translate("FEATURED"); ?></span>
            <?php } ?>
            <?php if(isset($this->sponsoredLabelActive) && $item->sponsored){ ?>
            <span class="sesevent_label_sponsored"><?php echo $this->translate("SPONSORED"); ?></span>
            <?php } ?>
          </p>
        <?php } ?>
        <?php if(isset($this->socialSharingActive) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive)) {
        $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref()); ?>
          <div class="sesevent_grid_btns"> 
            <?php if(isset($this->socialSharingActive)){ ?>
            <a href="<?php echo 'http://www.facebook.com/sharer/sharer.php?u=' . $urlencode . '&t=' . $item->getTitle(); ?>" onclick="return socialSharingPopUp(this.href, '<?php echo $this->translate('Facebook'); ?>')" class="sesbasic_icon_btn sesbasic_icon_facebook_btn"><i class="fa fa-facebook"></i></a>
            <a href="<?php echo 'http://twitthis.com/twit?url=' . $urlencode . '&title=' . $item->getTitle(); ?>" onclick="return socialSharingPopUp(this.href, '<?php echo $this->translate('Twitter')?>')" class="sesbasic_icon_btn sesbasic_icon_twitter_btn"><i class="fa fa-twitter"></i></a>
            <a href="<?php echo 'http://pinterest.com/pin/create/button/?url='.$urlencode; ?>&media=<?php echo urlencode((strpos($item->getPhotoUrl('thumb.main'),'http') === FALSE ? (((!empty($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"] == 'on')) ? "https://" : "http://") . $_SERVER['HTTP_HOST'] ) : $item->getPhotoUrl('thumb.main'))); ?>&description=<?php echo $item->getTitle();?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate('Pinterest'); ?>')" class="sesbasic_icon_btn sesbasic_icon_pintrest_btn"><i class="fa fa-pinterest"></i></a>
            <?php } 
            $itemtype = 'seseventspeaker_speaker';
            $getId = 'speaker_id';
            if(isset($this->likeButtonActive)){
            ?>
            <!--Like Button-->
            <?php $LikeStatus = Engine_Api::_()->sesevent()->getLikeStatusEvent($item->$getId, $item->getType()); ?>
            <a href="javascript:;" data-url="<?php echo $item->$getId ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sesevent_like_<?php echo $itemtype; ?> <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $item->like_count; ?></span></a>
            <?php } ?>
            <?php
              if(isset($this->favouriteButtonActive) && isset($item->favourite_count)) {
                $favStatus = Engine_Api::_()->getDbtable('favourites', 'sesevent')->isFavourite(array('resource_type'=>'seseventspeaker_speaker','resource_id'=>$item->speaker_id));
                $favClass = ($favStatus)  ? 'button_active' : '';
                $shareOptions = "<a href='javascript:;' class='sesbasic_icon_btn sesbasic_icon_btn_count sesvideo_favourite_seseventspeaker_speaker_". $item->speaker_id." sesbasic_icon_fav_btn sesvideo_favourite_seseventspeaker_speaker ".$favClass ."' data-url=\"$item->speaker_id\"><i class='fa fa-heart'></i><span>$item->favourite_count</span></a>";
                echo $shareOptions;
              }
            ?>
          </div>
        <?php } ?>
      </div>
      <div class="sesspeaker_list_item_details sesbasic_clearfix">
        <?php if(isset($this->titleActive) ){ ?>
        <div class="sesspeaker_list_item_title">
          <?php if(strlen($item->getTitle()) > $this->title_truncation_grid){ 
          $title = mb_substr($item->getTitle(),0,$this->title_truncation_grid).'...';
          echo $this->htmlLink($item->getHref(),$title ) ?>
          <?php }else{ ?>
          	<?php echo $this->htmlLink($item->getHref(),$item->getTitle() ) ?>
          <?php } ?>
        </div>
        <?php } ?>
        <?php if(isset($this->locationActive) && $item->location){ ?>
            <div class="sesevent_list_stats sesevent_list_location">
              <span class="widthfull">
                <i class="fa fa-map-marker sesbasic_text_light" title="<?php echo $this->translate('Location');?>"></i>
                <span title="<?php echo $item->location; ?>"><?php echo $item->location ?></span>
              </span>
            </div>
        <?php } ?>
        <div class="sesspeaker_list_item_stats sesbasic_text_light">
<!--          <?php if(isset($this->likeActive) && isset($item->like_count)) { ?>
          	<span title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count)); ?>"><i class="fa fa-thumbs-up sesbasic_text_light"></i><?php echo $item->like_count; ?></span>
          <?php } ?>-->
          <?php if(isset($this->speakerEventCountActive) && isset($speakerEventCount)) { ?>
            <span title="<?php echo $this->translate(array('%s event', '%s events', $speakerEventCount), $this->locale()->toNumber($speakerEventCount))?>"><i class="fa fa-calendar"></i><?php echo $speakerEventCount; ?></span>
          <?php } ?>
          <?php if(isset($this->viewActive) && isset($item->view_count)) { ?>
          	<span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count))?>"><i class="fa fa-eye sesbasic_text_light"></i><?php echo $item->view_count; ?></span>
          <?php } ?>
          <?php if(isset($this->favouriteActive) && isset($item->favourite_count)) { ?>
          	<span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count))?>"><i class="fa fa-heart sesbasic_text_light"></i><?php echo $item->favourite_count; ?></span>
          <?php } ?>
        </div>
      </div>
    </div>
  </li>
<?php endif; ?>
<?php endforeach; ?>