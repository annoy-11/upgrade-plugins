<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventspeaker
 * @package    Seseventspeaker
 * @copyright  Copyright 2018-2017 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2017-03-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seseventspeaker/externals/styles/styles.css'); ?>

<?php $user_item = $this->results; ?>
<ul class="sesbasic_bxs sesbasic_clearfix sesbasic_sidebar_block">
  <li class="sesspeaker_list_item sesbasic_clearfix sesbasic_bxs sesevent_grid_btns_wrap" style="width:200px;">
    <div class="sesspeaker_list_item_inner prelative sesbasic_clearfix">
      <div class="sesspeaker_list_item_thumb prelative" style="height:200px;">
        <span class="sesspeaker_list_item_thumb_img" style="background-image:url(<?php echo $user_item->getPhotoUrl(); ?>);"></span>
        <a class="sesspeaker_list_item_thumb_overlay" href="<?php echo $user_item->getHref(); ?>"></a>
        <?php if($this->information):  ?>
          <?php if(in_array('featured', $this->information) || in_array('sponsored', $this->information)): ?>
            <span class="sesevent_labels sesbasic_animation">
              <?php if($speaker->featured && in_array('featured', $this->information)): ?>
                <span class="sesevent_label_featured"><?php echo $this->translate("FEATURED"); ?></span>
              <?php endif; ?>
              <?php if($speaker->sponsored && in_array('sponsored', $this->information)): ?>
                <span class="sesevent_label_sponsored"><?php echo $this->translate("SPONSORED"); ?></span>
              <?php endif; ?>
            </span>
          <?php endif; ?>
        <?php endif; ?>
        <?php if(isset($this->socialSharingActive) || isset($this->favouriteButtonActive)) {
        $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $href); ?>
          <div class="sesevent_grid_btns"> 
            <?php if(isset($this->socialSharingActive)){ ?>
            <a href="<?php echo 'http://www.facebook.com/sharer/sharer.php?u=' . $urlencode . '&t=' . $item->getTitle(); ?>" onclick="return socialSharingPopUp(this.href, '<?php echo $this->translate('Facebook'); ?>')" class="sesbasic_icon_btn sesbasic_icon_facebook_btn"><i class="fa fa-facebook"></i></a>
            <a href="<?php echo 'http://twitthis.com/twit?url=' . $urlencode . '&title=' . $item->getTitle(); ?>" onclick="return socialSharingPopUp(this.href, '<?php echo $this->translate('Twitter')?>')" class="sesbasic_icon_btn sesbasic_icon_twitter_btn"><i class="fa fa-twitter"></i></a>
            <a href="<?php echo 'http://pinterest.com/pin/create/button/?url='.$urlencode; ?>&media=<?php echo urlencode((strpos($item->getPhotoUrl('thumb.main'),'http') === FALSE ? (((!empty($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"] == 'on')) ? "https://" : "http://") . $_SERVER['HTTP_HOST'] ) : $item->getPhotoUrl('thumb.main'))); ?>&description=<?php echo $item->getTitle();?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate('Pinterest'); ?>')" class="sesbasic_icon_btn sesbasic_icon_pintrest_btn"><i class="fa fa-pinterest"></i></a>
            <?php } 
            $itemtype = 'seseventspeaker_speaker';
            $getId = 'speaker_id';
            ?>
            <?php
              if(isset($this->favouriteButtonActive) && isset($item->favourite_count)) {
                $favStatus = Engine_Api::_()->getDbtable('favourites', 'sesevent')->isFavourite(array('resource_type'=>'seseventspeaker_speaker','resource_id' => $item->speaker_id));
                $favClass = ($favStatus)  ? 'button_active' : '';
                $shareOptions = "<a href='javascript:;' class='sesbasic_icon_btn sesbasic_icon_btn_count sesevent_favourite_seseventspeaker_speaker_". $item->speaker_id." sesbasic_icon_fav_btn sesevent_favourite_seseventspeaker_speaker ".$favClass ."' data-url=\"$item->speaker_id\"><i class='fa fa-heart'></i><span>$item->favourite_count</span></a>";
                echo $shareOptions;
              }
            ?>
          </div>
        <?php } ?>
      </div>
      <div class="sesspeaker_list_item_details sesbasic_clearfix">
        <?php if(!empty($this->content_show) && in_array('displayname', $this->content_show)): ?>
          <div class="sesspeaker_list_item_title">
            <?php echo $this->htmlLink($user_item->getHref(), $user_item->name, array('title' => $user_item->name)) ?>
          </div>
        <?php endif; ?>
        <div class="sesspeaker_list_item_stats sesbasic_text_light">
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
</ul>