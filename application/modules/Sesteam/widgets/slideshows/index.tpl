<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesteam
 * @package    Sesteam
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2015-02-20 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php
$base_url = $this->layout()->staticBaseUrl;
$this->headScript()->appendFile($base_url . 'application/modules/Sesbasic/externals/scripts/class.noobSlide.packed.js');
$this->headLink()->appendStylesheet($base_url . 'application/modules/Sesbasic/externals/styles/slideshow.css'); 
$this->headLink()->appendStylesheet($base_url . 'application/modules/Sesteam/externals/styles/styles.css');
?>

<script type="text/javascript">

  window.addEvent('domready', function() {
  
    var sesteamSlideshow  = $$('#sesteam_slideshow<?php echo $this->identity ?> > div');
    for(i=0;i < sesteamSlideshow.length;i++) {
      sesteamSlideshow[i].style.width = $('sesbasic_content_slideshow_container').clientWidth + 'px';
    }
    
    var nS4 = new noobSlide({
      box: $('sesteam_slideshow<?php echo $this->identity ?>'),
      items: $$('#sesteam_slideshow<?php echo $this->identity ?> > div'),
      size: $('sesbasic_content_slideshow_container').clientWidth,
      autoPlay: true,
      interval: 5000,
      addButtons: {
        previous: $('prev1<?php echo $this->identity ?>'),
        next: $('next1<?php echo $this->identity ?>')
      },
      button_event: 'click',
    });

  });
  
</script>

<div class="sesbasic_content_slideshow_container sesbasic_bxs" id="sesbasic_content_slideshow_container">
  <div id="sesteam_slideshow<?php echo $this->identity ?>" class="sesbasic_content_slideshow sesteam_members_slideshow">
    <?php foreach( $this->paginator as $user ):
    if($this->type == 'teammember') {
     $user_item = $this->item('user', $user->user_id);
    } else {
     $user_item = $user;
    }
    ?>
    <div class="sesbasic_content_slideshow_slides">
      <div class="sesbasic_content_slideshow_photo">
        <?php if($user->photo_id && $this->type == 'teammember'): ?>
         <?php echo $this->htmlLink($user_item->getHref(), $this->itemPhoto($user, 'thumb.profile', $user_item->getTitle()), array('title' => $user_item->getTitle())); ?>
        <?php else: ?>
         <?php echo $this->htmlLink($user_item->getHref(), $this->itemPhoto($user_item, 'thumb.profile', $user_item->getTitle()), array('title' => $user_item->getTitle())); ?>
        <?php endif; ?>
        <?php //echo $this->htmlLink($user_item->getHref(), $this->itemPhoto($user_item, 'thumb.profile', $user_item->getTitle()), array('title' => $user_item->getTitle())) ?>

        <?php if($this->infoshow): ?>
        <?php if(in_array('featured', $this->infoshow) || in_array('sponsored', $this->infoshow)): ?>
        <span class="sesteam_labels_container">
          <?php if($user->featured && in_array('featured', $this->infoshow)): ?>
          <span class="sesteam_label sesteam_label_featured"><?php echo $this->translate("FEATURED"); ?></span>
          <?php endif; ?>
          <?php if($user->sponsored && in_array('sponsored', $this->infoshow)): ?>
          <span class="sesteam_label sesteam_label_sponsored"><?php echo $this->translate("SPONSORED"); ?></span>
          <?php endif; ?>
        </span>
        <?php endif; ?>
        <?php endif; ?>
      </div>
      <div class="sesbasic_content_slideshow_content">      
        <div class="sesbasic_content_slideshow_title">
          <?php if($this->type == 'teammember'): ?>
          <?php echo $this->htmlLink($user_item->getHref(), $user_item->getTitle(), array('title' => $user_item->getTitle())) ?>
          <?php else: ?>
          <?php echo $this->htmlLink($user_item->getHref(), $user_item->name, array('title' => $user_item->name)) ?>
          <?php endif; ?> 
        </div>
        <div class="team_member_role">
          <?php if($user->designation && in_array('designation', $this->infoshow)): ?>
          <?php echo $this->translate($user->designation); ?>
          <?php endif; ?>
        </div>
        <div class="team_member_contact_info sesbasic_clearfix clear">
          <?php if($user->email && $this->infoshow && in_array('email', $this->infoshow)): ?>
          <span>
            <i class="fas fa-envelope sesbasic_text_light"></i>
            <a href="mailto:<?php echo $user->email ?>" title="<?php echo $user->email ?>">
              <?php echo $user->email ?>
            </a>
          </span> 
          <?php endif; ?>
          <?php if($user->phone && $this->infoshow &&  in_array('phone', $this->infoshow)): ?>
          <span>
            <i class="fa fa-phone sesbasic_text_light"></i>
            <?php echo $user->phone ?>
          </span>
          <?php endif; ?>
          <?php if($user->location && $this->infoshow &&  in_array('location', $this->infoshow)): ?>
          <span>
            <i class="fas fa-map-marker-alt sesbasic_text_light"></i>
            <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)) { ?>
              <?php echo $this->htmlLink('http://maps.google.com/?q='.urlencode($user->location), $user->location, array('target' => 'blank')) ?>
            <?php } else { ?>
              <?php echo $user->location; ?>
            <?php } ?>
          </span>
          <?php endif; ?>
        </div>
        <div class="sesteam_members_slideshow_social_icon sesteam-social-icon sesbasic_clearfix clear">
          <?php if($user->email && $this->infoshow &&  in_array('email', $this->infoshow)): ?>
          <a href="mailto:<?php echo $user->email ?>" title="<?php echo $user->email ?>">
            <i class="fas fa-envelope sesbasic_text_light"></i>
          </a> 
          <?php endif; ?>

          <?php if($user->website && $this->infoshow &&  in_array('website', $this->infoshow)): ?>
          <?php $website = (preg_match("#https?://#", $user->website) === 0) ? 'http://'.$user->website : $user->website; ?>
          <a href="<?php echo $website ?>" target="_blank" title="<?php echo $website ?>">
            <i class="fas fa-globe sesbasic_text_light"></i>
          </a> 
          <?php endif; ?>
          <?php if($user->facebook && $this->infoshow &&  in_array('facebook', $this->infoshow)): ?>
          <?php $facebook = (preg_match("#https?://#", $user->facebook) === 0) ? 'http://'.$user->facebook : $user->facebook; ?>
          <a href="<?php echo $facebook ?>" target="_blank"  title="<?php echo $facebook ?>">
            <i class="fab fa-facebook-f sesbasic_text_light"></i>
          </a> 
          <?php endif; ?>
          <?php if($user->twitter && $this->infoshow &&  in_array('twitter', $this->infoshow)): ?>
          <?php $twitter = (preg_match("#https?://#", $user->twitter) === 0) ? 'http://'.$user->twitter : $user->twitter; ?>
          <a href="<?php echo $twitter ?>" target="_blank"  title="<?php echo $twitter ?>">
            <i class="fab fa-twitter sesbasic_text_light"></i>
          </a>
          <?php endif; ?>
          <?php if($user->linkdin && $this->infoshow &&  in_array('linkdin', $this->infoshow)): ?>
          <?php $linkdin = (preg_match("#https?://#", $user->linkdin) === 0) ? 'http://'.$user->linkdin : $user->linkdin; ?>
          <a href="<?php echo $linkdin ?>" target="_blank" title="<?php echo $linkdin ?>">
            <i class="fab fa-linkedin-in sesbasic_text_light"></i>
          </a>
          <?php endif; ?>
          <?php if($user->googleplus && $this->infoshow &&  in_array('googleplus', $this->infoshow)): ?>
          <?php $googleplus = (preg_match("#https?://#", $user->googleplus) === 0) ? 'http://'.$user->googleplus : $user->googleplus; ?>
          <a href="<?php echo $googleplus ?>" target="_blank" title="<?php echo $googleplus ?>">
            <i class="fab fa-google-plus-g sesbasic_text_light"></i>
          </a>
          <?php endif; ?>
        </div>
        <?php if($user->description && !empty($this->infoshow) &&  in_array('description', $this->infoshow)): ?>
          <div class="team_member_des sesbasic_clearfix clear">
            <?php echo $this->translate($user->description); ?>             
            <?php if(!empty($this->infoshow) && in_array('viewMore', $this->infoshow)): ?>
              <span class="sesbasic_content_slideshow_more clear">
                <?php if(!empty($this->viewMoreText)): ?>
                <?php $viewMoreText = $this->translate($this->viewMoreText) . ' &raquo;'; ?>
                <?php else: ?>
                <?php $viewMoreText = $this->translate("more") . ' &raquo;'; ?>
                <?php endif; ?>
                <?php if($user->detail_description && $this->type == 'teammember'): ?>
                <?php echo $this->htmlLink($user_item->getHref(), $viewMoreText, array()) ?>
                <?php elseif($user->detail_description): ?>
                <?php echo $this->htmlLink($user_item->getHref(), $viewMoreText, array()) ?>
                <?php endif; ?>
              </span>
            <?php endif; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
  <p class="sesbasic_content_slideshow_btns sesbasic_text_light">
    <span class="prevbtn" id="prev1<?php echo $this->identity ?>"><?php if($this->count > 1): ?><i class="fa fa-angle-left"></i><?php endif; ?></span>
    <span class="nxtbtn" id="next1<?php echo $this->identity ?>"><?php if($this->count > 1): ?><i class="fa fa-angle-right"></i><?php endif; ?></span>
  </p>
</div>
