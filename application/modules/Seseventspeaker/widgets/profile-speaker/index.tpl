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
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesevent/externals/scripts/jquery.js'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesevent/externals/styles/styles.css'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seseventspeaker/externals/styles/styles.css'); ?>

<?php $speaker = $this->speaker; ?>
<?php
  $sitehostredirect = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesevent.sitehostredirect', 1); 
	if($sitehostredirect && $speaker->user_id) {
	  $user = Engine_Api::_()->getItem('user', $speaker->user_id);
	  $href = $user->getHref();
	} else {
	  $href = $speaker->getHref();
	}
?>
<div class="seseventspeaker_view_container sesbasic_clearfix sesbasic_bxs">
	<div class="seseventspeaker_view_left">
    <?php if(!empty($this->infoshow) && in_array('profilePhoto', $this->infoshow)): ?>
      <div class="seseventspeaker_view_photo sesbasic_clearfix">
        <?php echo $this->itemPhoto($speaker, 'thumb.profile', $speaker->name); ?>
  
        <?php if($this->infoshow):   ?>
          <?php if(in_array('featuredLabel', $this->infoshow) || in_array('sponsoredLabel', $this->infoshow)):   ?>
            <p class="sesevent_labels sesbasic_animation">
              <?php if($speaker->featured && in_array('featuredLabel', $this->infoshow)): ?>
                <span class="sesevent_label_featured"><?php echo $this->translate("FEATURED"); ?></span>
              <?php endif; ?>
              <?php if($speaker->sponsored && in_array('sponsoredLabel', $this->infoshow)): ?>
                <span class="sesevent_label_sponsored"><?php echo $this->translate("SPONSORED"); ?></span>
              <?php endif; ?>
            </p>
          <?php endif; ?>
        <?php endif; ?>
      </div>
    <?php endif; ?>
  	
    <div class="seseventspeaker_view_contact_info sesbasic_clearfix">
      <?php if($speaker->email && in_array('email', $this->infoshow)): ?>
      	<p class="sesbasic_clearfix">
        	<i class="fa fa-envelope"></i>
          <span>
            <a href="mailto:<?php echo $speaker->email ?>" title="<?php echo $speaker->email ?>">
              <?php echo $speaker->email ?>
            </a> 
          </span>
        </p> 
      <?php endif; ?>    
    
			<?php if($speaker->phone && in_array('phone', $this->infoshow)): ?>
		    <p class="sesbasic_clearfix">
        	<i class="fa fa-phone"></i>
          <span><?php echo $speaker->phone; ?></span>
        </p>
      <?php endif; ?>
      
      <p class="sesbasic_clearfix">
      	<i class="fa fa-map-marker"></i>
        <span>New York</span>
      </p>
    </div>
    
    <div class="seseventspeaker_view_social_links">
      <?php if($speaker->website && in_array('website', $this->infoshow)): ?>
        <?php $website = (preg_match("#https?://#", $speaker->website) === 0) ? 'http://'.$speaker->website : $speaker->website; ?>
        <a class="seseventspeaker_icon_website sesbasic_animation" href="<?php echo $website ?>" target="_blank" title="<?php echo $website ?>">
          <i class="fa fa-globe"></i>
        </a> 
      <?php endif; ?>
      <?php if($speaker->facebook && in_array('facebook', $this->infoshow)): ?>
	      <?php $facebook = (preg_match("#https?://#", $speaker->facebook) === 0) ? 'http://'.$speaker->facebook : $speaker->facebook; ?>
	      <a class="seseventspeaker_icon_facebook sesbasic_animation" href="<?php echo $facebook ?>" target="_blank" title="<?php echo $facebook ?>">
	        <i class="fa fa-facebook"></i>
	      </a> 
      <?php endif; ?>
      <?php if($speaker->twitter && in_array('twitter', $this->infoshow)): ?>
	      <?php $twitter = (preg_match("#https?://#", $speaker->twitter) === 0) ? 'http://'.$speaker->twitter : $speaker->twitter; ?>
	      <a class="seseventspeaker_icon_twitter sesbasic_animation" href="<?php echo $twitter ?>" target="_blank" title="<?php echo $twitter ?>">
	        <i class="fa fa-twitter"></i>
	      </a>
      <?php endif; ?>
      <?php if($speaker->linkdin && in_array('linkdin', $this->infoshow)): ?>
	      <?php $linkdin = (preg_match("#https?://#", $speaker->linkdin) === 0) ? 'http://'.$speaker->linkdin : $speaker->linkdin; ?>
	      <a class="seseventspeaker_icon_linkedin sesbasic_animation" href="<?php echo $linkdin ?>" target="_blank" title="<?php echo $linkdin ?>">
	        <i class="fa fa-linkedin"></i>
	      </a>
      <?php endif; ?>
      <?php if($speaker->googleplus && in_array('googleplus', $this->infoshow)): ?>
	      <?php $googleplus = (preg_match("#https?://#", $speaker->googleplus) === 0) ? 'http://'.$speaker->googleplus : $speaker->googleplus; ?>
	      <a class="seseventspeaker_icon_gplus sesbasic_animation" href="<?php echo $googleplus ?>" target="_blank" title="<?php echo $googleplus ?>">
	        <i class="fa fa-google-plus"></i>
	      </a>
      <?php endif; ?>
    </div>
  </div>

  <div class="seseventspeaker_view_middle">
    <?php if(!empty($this->infoshow)): ?>
      <?php if(in_array('displayname', $this->infoshow)): ?>
        <div class='seseventspeaker_view_title'>
          <h2><?php echo $speaker->name; ?></h2>
        </div>
      <?php endif; ?>
      <?php if($speaker->description && in_array('detaildescription', $this->infoshow)): ?>
        <div class="seseventspeaker_view_des sesbasic_clearfix">
          <?php if($this->descriptionText): ?>
            <span><?php echo $this->translate($this->descriptionText); ?> </span>
          <?php else: ?>
            <span><?php echo $this->translate("Description"); ?> </span>
          <?php endif; ?>          
          <?php echo $speaker->description; ?>
        </div>
      <?php endif; ?>
			<div class="sesbasic_clearfix seseventspeaker_view_btn">
        <div class="seseventspeaker_view_stats sesbasic_clearfix floatL">
          <?php if($this->speakerEventCount && in_array('speakerEventCount', $this->infoshow)): ?>
            <span title="<?php echo $this->translate(array('%s event', '%s events', $this->speakerEventCount), $this->locale()->toNumber($this->speakerEventCount))?>"><i class="sesbasic_text_light fa fa-calendar"></i><?php echo $this->speakerEventCount; ?></span>
          <?php endif; ?>
          <?php if(in_array('view', $this->infoshow) && isset($speaker->view_count)) { ?>
            <span title="<?php echo $this->translate(array('%s view', '%s views', $speaker->view_count), $this->locale()->toNumber($speaker->view_count))?>"><i class="fa fa-eye sesbasic_text_light"></i><?php echo $speaker->view_count; ?></span>
          <?php } ?>
          <?php if(in_array('favourite', $this->infoshow) && isset($speaker->favourite_count)) { ?>
            <span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $speaker->favourite_count), $this->locale()->toNumber($speaker->favourite_count))?>"><i class="fa fa-heart sesbasic_text_light"></i><?php echo $speaker->favourite_count; ?></span>
          <?php } ?>
        </div>
        <div class="seseventspeaker_view_social_share sesbasic_clearfix floatR">
          <?php
            if(in_array('favouriteButton', $this->infoshow) && isset($speaker->favourite_count)) {
            $favStatus = Engine_Api::_()->getDbtable('favourites', 'sesevent')->isFavourite(array('resource_type'=>'seseventspeaker_speaker','resource_id'=>$speaker->speaker_id));
            $favClass = ($favStatus)  ? 'button_active' : '';
            $shareOptions = "<a href='javascript:;' class='sesbasic_icon_btn sesbasic_icon_btn_count sesevent_favourite_seseventspeaker_speaker_". $speaker->speaker_id." sesbasic_icon_fav_btn sesevent_favourite_seseventspeaker_speaker ".$favClass ."' data-url=\"$speaker->speaker_id\"><i class='fa fa-heart'></i><span>$speaker->favourite_count</span></a>";
            echo $shareOptions;
            }
          ?>
          <?php if(in_array('socialSharing', $this->infoshow)) {
            $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $href); ?> 
            <?php // if(isset($this->socialSharing)){ ?>
            <a href="<?php echo 'http://www.facebook.com/sharer/sharer.php?u=' . $urlencode . '&t=' . $speaker->getTitle(); ?>" onclick="return socialSharingPopUp(this.href, '<?php echo $this->translate('Facebook'); ?>')" class="sesbasic_icon_btn sesbasic_icon_facebook_btn"><i class="fa fa-facebook"></i></a>
            <a href="<?php echo 'http://twitthis.com/twit?url=' . $urlencode . '&title=' . $speaker->getTitle(); ?>" onclick="return socialSharingPopUp(this.href, '<?php echo $this->translate('Twitter')?>')" class="sesbasic_icon_btn sesbasic_icon_twitter_btn"><i class="fa fa-twitter"></i></a>
            <a href="<?php echo 'http://pinterest.com/pin/create/button/?url='.$urlencode; ?>&media=<?php echo urlencode((strpos($speaker->getPhotoUrl('thumb.main'),'http') === FALSE ? (((!empty($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"] == 'on')) ? "https://" : "http://") . $_SERVER['HTTP_HOST'] ) : $speaker->getPhotoUrl('thumb.main'))); ?>&description=<?php echo $speaker->getTitle();?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate('Pinterest'); ?>')" class="sesbasic_icon_btn sesbasic_icon_pintrest_btn"><i class="fa fa-pinterest"></i></a>
            <?php // } ?>
          <?php } ?>
        </div>
			</div>
    <?php endif; ?>


  </div>
</div>