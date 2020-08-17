<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesevent
 * @package    Sesevent
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-07-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php $allParams=$this->allParams; ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesevent/externals/styles/styles.css'); ?>
<?php
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesevent/externals/scripts/jquery.js');
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesevent/externals/scripts/owl.carousel.js') ?>
<div class="slide sesbasic_carousel_wrapper sesevent_hosts_carousel_wrapper sesbm clearfix sesbasic_bxs">
  <div id="eventslide_<?php echo $this->identity; ?>" class="sesevent_hosts_carousel">
  	<?php foreach( $this->paginator as $item ): ?>
      <?php 
      $followCount = Engine_Api::_()->getDbtable('follows', 'sesevent')->getFollowCount(array('host_id' => $item->host_id, 'type' => $item->type));
      $hostEventCount = Engine_Api::_()->getDbtable('events', 'sesevent')->getHostEventCounts(array('host_id' => $item->host_id, 'type' => $item->type));
      $sitehostredirect = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesevent.sitehostredirect', 1); 
      if($sitehostredirect && $item->user_id) {
        $user = Engine_Api::_()->getItem('user', $item->user_id);
        $href = $user->getHref();
      } else {
        $href = $item->getHref();
      }
      ?>
        <div class="sesevent_host_list sesevent_grid_btns_wrap sesbasic_clearfix <?php if($this->contentInsideOutside == 'in'): ?> sesevent_host_list_in <?php else: ?> sesevent_host_list_out <?php endif; ?> <?php if($this->mouseOver): ?> sesae-i-over <?php endif; ?>">
          <div class="sesevent_host_list_thumb" style="height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height ?>;">
            <?php
            $href = $href;
            $imageURL = $item->getPhotoUrl('thumb.main');
            ?>
            <a href="<?php echo $href; ?>" class="sesevent_host_list_thumb_img">
              <span style="background-image:url(<?php echo $imageURL; ?>);"></span>
            </a>
            <a href="<?php echo $href; ?>" class="sesevent_host_list_overlay"></a>
            <?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive)){ ?>
              <p class="sesevent_labels">
                <?php if(isset($this->featuredLabelActive) && $item->featured){ ?>
                  <span class="sesevent_label_featured"><?php echo $this->translate("FEATURED"); ?></span>
                <?php } ?>
                <?php if(isset($this->sponsoredLabelActive) && $item->sponsored){ ?>
                  <span class="sesevent_label_sponsored"><?php echo $this->translate("SPONSORED"); ?></span>
                <?php } ?>
              </p>
              <?php if(isset($this->verifiedLabelActive) && $item->verified){ ?>
                <div class="sesevent_verified_label" title="<?php echo $this->translate("VERIFIED"); ?>"><i class="fa fa-check"></i></div>
              <?php } ?>
            <?php } ?>
            <?php if(isset($this->socialSharingActive) || isset($this->favouriteButtonActive)) {
            $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $href); ?>
              <div class="sesevent_grid_btns"> 
                <?php if(isset($this->socialSharingActive)){ ?>
                
                <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item)); ?>

                <?php } 
                $itemtype = 'sesevent_host';
                $getId = 'host_id';
                ?>
                <?php
                 if(isset($this->likeButtonActive) && isset($item->like_count)){ ?>
          <?php $LikeStatus = Engine_Api::_()->sesevent()->getLikeStatusEvent($item->$getId,$item->getType()); ?>
            <a href="javascript:;" data-url="<?php echo $item->$getId ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sesevent_like_<?php echo $itemtype; ?> <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $item->like_count; ?></span></a>
            <?php }
                  if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesevent.allowfavourite', 1) && isset($this->favouriteButtonActive) && isset($item->favourite_count)) {
                    $favStatus = Engine_Api::_()->getDbtable('favourites', 'sesevent')->isFavourite(array('resource_type'=>'sesevent_host','resource_id'=>$item->host_id));
                    $favClass = ($favStatus)  ? 'button_active' : '';
                    $shareOptions = "<a href='javascript:;' class='sesbasic_icon_btn sesbasic_icon_btn_count sesvideo_favourite_sesevent_host_". $item->host_id." sesbasic_icon_fav_btn sesevent_favourite_sesevent_host ".$favClass ."' data-url=\"$item->host_id\"><i class='fa fa-heart'></i><span>$item->favourite_count</span></a>";
                    echo $shareOptions;
                  }
                ?>
              </div>
            <?php } ?>
          </div>
          <?php //if(isset($this->titleActive) ){ ?>
            <div class="sesevent_host_list_in_show_title sesevent_animation">
              <?php if(strlen($item->getTitle()) > $this->title_truncation_grid) {
                $title = mb_substr($item->getTitle(),0,($this->title_truncation_grid - 3)).'...';
                echo $this->htmlLink($href,$title ) ?>
              <?php } else { ?>
                <?php echo $this->htmlLink($href,$item->getTitle() ) ?>
              <?php } ?>
            </div>
          <?php //} ?>
          <div class="sesevent_host_list_info sesbasic_clearfix">
            <?php //if(isset($this->titleActive) ){ ?>
              <div class="sesevent_host_list_name">
                <?php if(strlen($item->getTitle()) > $this->title_truncation_grid) {
                  $title = mb_substr($item->getTitle(),0,($this->title_truncation_grid - 3)).'...';
                  echo $this->htmlLink($href,$title ) ?>
                <?php } else { ?>
                  <?php echo $this->htmlLink($href,$item->getTitle() ) ?>
                <?php } ?>
              </div>
            <?php //} ?>
            <div class="sesevent_host_list_stats sesevent_list_stats">
              <?php if(isset($this->hostEventCountActive) && isset($hostEventCount)) { ?>
                <span title="<?php echo $this->translate(array('%s event host', '%s event hosted', $hostEventCount), $this->locale()->toNumber($hostEventCount))?>"><i class="far fa-calendar-alt sesbasic_text_light"></i><?php echo $hostEventCount; ?></span>
              <?php } ?>
              <?php if(isset($this->followActive) && isset($followCount)) { ?>
                <span title="<?php echo $this->translate(array('%s follow', '%s followed', $followCount), $this->locale()->toNumber($followCount))?>"><i class="fas fa-users sesbasic_text_light"></i><?php echo $followCount; ?></span>
              <?php } ?>
              <?php if(isset($this->viewActive) && isset($item->view_count)) { ?>
                <span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count))?>"><i class="fa fa-eye sesbasic_text_light"></i><?php echo $item->view_count; ?></span>
              <?php } ?>
              <?php if(isset($this->likeActive) && isset($item->like_count)) { ?>
                <span title="<?php echo $this->translate(array('%s like', '%s like', $item->like_count), $this->locale()->toNumber($item->like_count))?>"><i class="fa fa-thumbs-up sesbasic_text_light"></i><?php echo $item->like_count; ?></span>
              <?php } ?>
              <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesevent.allowfavourite', 1) && isset($this->favouriteActive) && isset($item->favourite_count)) { ?>
                <span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count))?>"><i class="fa fa-heart sesbasic_text_light"></i><?php echo $item->favourite_count; ?></span>
              <?php } ?>
            </div>
            <?php if($item->host_phone && isset($this->phoneActive)): ?>
              <div class="sesevent_host_list_stats sesevent_list_stats">
                <span class="clear sesbasic_clearfix">
                  <i class="fa fa-phone sesbasic_text_light"></i>
                  <?php echo $item->host_phone ?>
                </span>
              </div>         
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
  </div>
</div>
<script type="text/javascript">
  <?php if($allParams['autoplay']){ ?>
			var autoplay_<?php echo $this->identity; ?> = true;
		<?php }else{ ?>
			var autoplay_<?php echo $this->identity; ?> = false;
		<?php } ?>
  seseventJqueryObject(".sesevent_hosts_carousel").owlCarousel({
  nav:true,
  loop:<?php if($this->total_limit_data <= $this->limit_data){echo 1 ;}else{ echo 0 ;} ?>,
  dots:false,
  items:1,
	margin:10,
  loop:true,
  responsiveClass:true,
	autoplaySpeed: <?php echo $this->autoplay_speed; ?>,
  autoplay:<?php echo $this->autoplay; ?>,
  responsive:{
    0:{
        items:1,
    },
    600:{
        items:3,
    },
		1000:{
        items:<?php echo $this->total_limit_data; ?>,
    },
  }
});
seseventJqueryObject(".owl-prev").html('<i class="fas fa-angle-left"></i>');
seseventJqueryObject(".owl-next").html('<i class="fas fa-angle-right"></i>');
</script>

