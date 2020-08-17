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
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesteam/externals/styles/styles.css'); ?>
<?php if($this->blockposition == 1): ?>
<ul class="sesteam_member_list_sidebar">
  <?php foreach( $this->paginator as $user ):
    if($this->type == 'teammember') {
      $user_item = $this->item('user', $user->user_id);
    } else {
      $user_item = $user;
    }
  ?>
  <li class="clear sesbasic_clearfix <?php if (!$this->viewType): ?>isround<?php endif; ?>">
    <?php if($user->photo_id && $this->type == 'teammember'): ?>
      <?php echo $this->htmlLink($user_item->getHref(), $this->itemPhoto($user, 'thumb.icon', $user_item->getTitle()), array('title' => $user_item->getTitle())); ?>
    <?php else: ?>
     <?php echo $this->htmlLink($user_item->getHref(), $this->itemPhoto($user_item, 'thumb.icon', $user_item->getTitle()), array('title' => $user_item->getTitle())); ?>
    <?php endif; ?>
    <?php //echo $this->htmlLink($user_item->getHref(), $this->itemPhoto($user_item, 'thumb.icon', $user_item->getTitle()), array('title' => $user_item->getTitle())) ?>
    <?php if(!empty($this->infoshow)): ?>
      <div class='sesteam_member_list_sidebar_info'>
        <?php if(in_array('displayname', $this->infoshow)): ?>
        <div class='sesteam_member_list_name'>
          <?php if($this->type == 'teammember'): ?>
            <?php echo $this->htmlLink($user_item->getHref(), $user_item->getTitle(), array('title' => $user_item->getTitle())) ?>
          <?php else: ?>
            <?php echo $this->htmlLink($user_item->getHref(), $user_item->name, array('title' => $user_item->name)) ?>
          <?php endif; ?> 
        </div>
        <?php endif; ?>
        <?php if($user->designation && in_array('designation', $this->infoshow)): ?>
        <div class='sesteam_member_list_designation'>
          <?php echo $this->translate($user->designation); ?>
        </div>
        <?php endif; ?>
        <?php if($user->phone && in_array('phone', $this->infoshow)): ?>
          <div class='sesteam_member_list_contact_info'>
            <i class="fa fa-phone sesbasic_text_light"></i>
            <?php echo $user->phone ?>
          </div>
        <?php endif; ?>
        <?php if($user->location && in_array('location', $this->infoshow)): ?>
          <div class='sesteam_member_list_contact_info'>
            <i class="fa fa-map-marker sesbasic_text_light"></i>
            <?php echo $this->htmlLink('http://maps.google.com/?q='.urlencode($user->location), $user->location, array('target' => 'blank')) ?>
          </div>
        <?php endif; ?>
        <div class="sesteam_member_list_sidebar_social_icons sesteam-social-icon bordernone">
          <?php if($user->email && in_array('email', $this->infoshow)): ?>
            <a href="mailto:<?php echo $user->email ?>" title="<?php echo $user->email ?>">
               <i class="fa fa-envelope sesbasic_text_light"></i>
            </a> 
          <?php endif; ?>

        <?php if($user->website && in_array('website', $this->infoshow)): ?>
          <?php $website = (preg_match("#https?://#", $user->website) === 0) ? 'http://'.$user->website : $user->website; ?>
          <a href="<?php echo $website ?>" target="_blank" title="<?php echo $website ?>">
            <i class="fa fa-globe sesbasic_text_light"></i>
          </a> 
        <?php endif; ?>
        <?php if($user->facebook && in_array('facebook', $this->infoshow)): ?>
          <?php $facebook = (preg_match("#https?://#", $user->facebook) === 0) ? 'http://'.$user->facebook : $user->facebook; ?>
          <a href="<?php echo $facebook ?>" target="_blank"  title="<?php echo $facebook ?>">
            <i class="fa fa-facebook sesbasic_text_light"></i>
          </a> 
        <?php endif; ?>
        <?php if($user->twitter && in_array('twitter', $this->infoshow)): ?>
          <?php $twitter = (preg_match("#https?://#", $user->twitter) === 0) ? 'http://'.$user->twitter : $user->twitter; ?>
          <a href="<?php echo $twitter ?>" target="_blank"  title="<?php echo $twitter ?>">
            <i class="fa fa-twitter sesbasic_text_light"></i>
          </a>
        <?php endif; ?>
        <?php if($user->linkdin && in_array('linkdin', $this->infoshow)): ?>
          <?php $linkdin = (preg_match("#https?://#", $user->linkdin) === 0) ? 'http://'.$user->linkdin : $user->linkdin; ?>
          <a href="<?php echo $linkdin ?>" target="_blank" title="<?php echo $linkdin ?>">
            <i class="fa fa-linkedin sesbasic_text_light"></i>
          </a>
        <?php endif; ?>
        <?php if($user->googleplus && in_array('googleplus', $this->infoshow)): ?>
          <?php $googleplus = (preg_match("#https?://#", $user->googleplus) === 0) ? 'http://'.$user->googleplus : $user->googleplus; ?>
          <a href="<?php echo $googleplus ?>" target="_blank" title="<?php echo $googleplus ?>">
            <i class="fa fa-google-plus sesbasic_text_light"></i>
          </a>
        <?php endif; ?>
        </div>
        <?php if(!empty($this->infoshow) && in_array('viewMore', $this->infoshow)): ?>
          <div class="sesteam_member_list_more">
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
          </div>
        <?php endif; ?>
      </div>
    <?php endif; ?>
  </li>
  <?php endforeach; ?>
</ul>
<?php else: ?>
<ul class="sesteam_member_list">
  <?php foreach( $this->paginator as $user ):
    if($this->type == 'teammember') {
      $user_item = $this->item('user', $user->user_id);
    } else {
      $user_item = $user;
    }
  ?>
  <li style="width:<?php echo $this->width + 20 ?>px;">
      <div class="sesteam_member_list_photo">
        <div class="sesteam_member_list_photo_inner <?php if (!$this->viewType): ?>isround<?php endif; ?>" style="height:<?php echo $this->height ?>px;width:<?php echo $this->width ?>px;">
            <?php if($user->photo_id && $this->type == 'teammember'): ?>
              <?php echo $this->htmlLink($user_item->getHref(), $this->itemPhoto($user, 'thumb.profile', $user_item->getTitle()), array('title' => $user_item->getTitle())); ?>
            <?php else: ?>
              <?php echo $this->htmlLink($user_item->getHref(), $this->itemPhoto($user_item, 'thumb.profile', $user_item->getTitle()), array('title' => $user_item->getTitle())); ?>
            <?php endif; ?>
          <?php //echo $this->htmlLink($user_item->getHref(), $this->itemPhoto($user_item, 'thumb.profile', $user_item->getTitle()), array('title' => $user_item->getTitle())) ?>
        </div>
        <?php if(in_array('featured', $this->content_show) || in_array('sponsored', $this->content_show)): ?>
          <span class="sesteam_labels_container">
            <?php if($user->featured && in_array('featured', $this->content_show)): ?>
            	<span class="sesteam_label sesteam_label_featured"><?php echo $this->translate("FEATURED"); ?></span>
            <?php endif; ?>
            <?php if($user->sponsored && in_array('sponsored', $this->content_show)): ?>
            	<span class="sesteam_label sesteam_label_sponsored"><?php echo $this->translate("SPONSORED"); ?></span>
            <?php endif; ?>
          </span>
        <?php endif; ?>
      </div>
      <?php if(!empty($this->infoshow)): ?>
        <?php if(in_array('displayname', $this->infoshow)): ?>
          <div class='sesteam_member_list_name'>
          <?php if($this->type == 'teammember'): ?>
            <?php echo $this->htmlLink($user_item->getHref(), $user_item->getTitle(), array('title' => $user_item->getTitle())) ?>
          <?php else: ?>
            <?php echo $this->htmlLink($user_item->getHref(), $user_item->name, array('title' => $user_item->name)) ?>
          <?php endif; ?> 
          </div>
          <?php endif; ?>
          <?php if($user->designation && in_array('designation', $this->infoshow)): ?>
            <div class='sesteam_member_list_designation'>
              <?php echo $this->translate($user->designation); ?>
            </div>
          <?php endif; ?>
      <?php if($user->phone && in_array('phone', $this->infoshow)): ?>
        <div class='sesteam_member_list_contact_info'>
          <i class="fa fa-phone sesbasic_text_light"></i>
          <?php echo $user->phone ?>
        </div>
      <?php endif; ?>
      <?php if($user->location && in_array('location', $this->infoshow)): ?>
        <div class='sesteam_member_list_contact_info'>
          <i class="fa fa-map-marker sesbasic_text_light"></i>
          <?php echo $this->htmlLink('http://maps.google.com/?q='.urlencode($user->location), $user->location, array('target' => 'blank')) ?>
        </div>
      <?php endif; ?>
        <?php if($user->description && in_array('description', $this->infoshow)): ?>
        <div class='sesteam_member_list_des'>
          <?php echo $this->translate($user->description); ?>
          <?php if(!empty($this->infoshow) && in_array('viewMore', $this->infoshow)): ?>
            <span class="sesteam_member_list_more">
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
      <div class="sesteam_member_list_social_icons sesteam-social-icon">
        <?php if($user->email && in_array('email', $this->infoshow)): ?>
          <a href="mailto:<?php echo $user->email ?>" title="<?php echo $user->email ?>">
             <i class="fa fa-envelope sesbasic_text_light"></i>
          </a> 
        <?php endif; ?>

      <?php if($user->website && in_array('website', $this->infoshow)): ?>
        <a href="<?php echo $user->website ?>" target="_blank" title="<?php echo $user->website ?>">
          <i class="fa fa-globe sesbasic_text_light"></i>
        </a> 
      <?php endif; ?>
      <?php if($user->facebook && in_array('facebook', $this->infoshow)): ?>
        <a href="<?php echo $user->facebook ?>" target="_blank">
          <i class="fa fa-facebook sesbasic_text_light"></i>
        </a> 
      <?php endif; ?>
      <?php if($user->twitter && in_array('twitter', $this->infoshow)): ?>
        <a href="<?php echo $user->twitter ?>" target="_blank">
          <i class="fa fa-twitter sesbasic_text_light"></i>
        </a>
      <?php endif; ?>
      <?php if($user->linkdin && in_array('linkdin', $this->infoshow)): ?>
        <a href="<?php echo $user->linkdin ?>" target="_blank">
          <i class="fa fa-linkedin sesbasic_text_light"></i>
        </a>
      <?php endif; ?>
      <?php if($user->googleplus && in_array('googleplus', $this->infoshow)): ?>
        <a href="<?php echo $user->googleplus ?>" target="_blank">
          <i class="fa fa-google-plus sesbasic_text_light"></i>
        </a>
      <?php endif; ?>
      </div>
    <?php endif; ?>
  </li>
  <?php endforeach; ?>
</ul>
<?php endif; ?>