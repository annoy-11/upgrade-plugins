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
<div class="sesteam_temp5_wrap">
  <?php if($this->teampage_title): ?>
    <div class="team_page_heading"><?php echo $this->teampage_title; ?></div>
  <?php endif; ?>
  <?php if($this->teampage_description): ?>
    <p class="team_page_description"><?php echo $this->teampage_description; ?></p>
  <?php endif; ?>
  <div class="sesteam_temp5_list sestheme_highlighted_member">
    <?php //foreach( $this->paginator as $user ):
    $user = $this->results;
    if($this->type == 'teammember') {
      $user_item = $this->item('user', $user->user_id);
    } else {
      $user_item = $user; //$this->item('user', $user->user_id);
    }
     ?>
      <div class="team_box">
        <div class="team_box_inner">
          <div class="team_member_thumbnail">
            <?php if($user->photo_id && $this->type == 'teammember'): ?>
              <?php echo $this->htmlLink($user_item->getHref(), $this->itemPhoto($user, 'thumb.profile', $user_item->getTitle()), array('title' => $user_item->getTitle())); ?>
            <?php else: ?>
              <?php echo $this->htmlLink($user_item->getHref(), $this->itemPhoto($user_item, 'thumb.profile', $user_item->getTitle()), array('title' => $user_item->getTitle())); ?>
            <?php endif; ?>
             <?php //echo $this->htmlLink($user_item->getHref(), $this->itemPhoto($user_item, 'thumb.profile', $user_item->getTitle()), array('title' => $user_item->getTitle())) ?>
            <?php echo $this->itemPhoto($user_item, 'thumb.profile', $user_item->getTitle()) ?>
          </div>
          <?php if($this->content_show): ?>
          <div class="team_member_info">
            <?php if(!empty($this->content_show) && in_array('displayname', $this->content_show)): ?>
              <p class='team_member_name'>
                <?php if($this->type == 'teammember'): ?>
                  <?php echo $this->htmlLink($user_item->getHref(), $user_item->getTitle(), array('title' => $user_item->getTitle())) ?>
                <?php else: ?>
                  <?php echo $this->htmlLink($user_item->getHref(), $user_item->name, array('title' => $user_item->name)) ?>
                <?php endif; ?>              
              </p>
            <?php endif; ?>
            <?php if($user->designation_id && $user->designation && !empty($this->content_show) &&  in_array('designation', $this->content_show)): ?>
              <p class='team_member_role'>
                <?php echo $this->translate($user->designation); ?>
              </p>
            <?php endif; ?>
            
            <?php if(!empty($this->content_show) && in_array('location', $this->content_show)): ?>
              <p class="team_member_contact_info">
                <?php if($user->location): ?>
                  <i class="fa fa-map-marker"></i>
                  <?php echo $this->htmlLink('http://maps.google.com/?q='.urlencode($user->location), $user->location, array('target' => 'blank')) ?>
                <?php endif; ?>
              </p>
            <?php endif; ?>
            <?php if(!empty($this->content_show) && in_array('phone', $this->content_show)): ?>
              <p class="team_member_contact_info">
                <?php if($user->phone): ?>
                  <i class="fa fa-phone"></i>
                  <?php echo $user->phone ?>
                <?php endif; ?>  
              </p>
            <?php endif; ?>
            <div class="sesteam-social-icon">
              <?php if($user->email && !empty($this->content_show) && in_array('email', $this->content_show)): ?>
                <a href="mailto:<?php echo $user->email ?>" title="<?php echo $user->email ?>">
                  <i class="fa fa-envelope"></i>
                </a> 
              <?php endif; ?>
              <?php if($user->website && !empty($this->content_show) && in_array('website', $this->content_show)): ?>
                <?php $website = (preg_match("#https?://#", $user->website) === 0) ? 'http://'.$user->website : $user->website; ?>
                <a href="<?php echo $website ?>" target="_blank" title="<?php echo $website ?>">
                  <i class="fa fa-globe"></i>
                </a> 
              <?php endif; ?>
              <?php if($user->facebook && !empty($this->content_show) && in_array('facebook', $this->content_show)): ?>
                <?php $facebook = (preg_match("#https?://#", $user->facebook) === 0) ? 'http://'.$user->facebook : $user->facebook; ?>
                <a href="<?php echo $facebook ?>" target="_blank" title="<?php echo $facebook ?>">
                  <i class="fa fa-facebook"></i>
                </a> 
              <?php endif; ?>
              <?php if($user->twitter && !empty($this->content_show) && in_array('twitter', $this->content_show)): ?>
                <?php $twitter = (preg_match("#https?://#", $user->twitter) === 0) ? 'http://'.$user->twitter : $user->twitter; ?>
                <a href="<?php echo $twitter ?>" target="_blank" title="<?php echo $twitter ?>">
                  <i class="fa fa-twitter"></i>
                </a>
              <?php endif; ?>
              <?php if($user->linkdin && !empty($this->content_show) && in_array('linkdin', $this->content_show)): ?>
                <?php $linkdin = (preg_match("#https?://#", $user->linkdin) === 0) ? 'http://'.$user->linkdin : $user->linkdin; ?>
                <a href="<?php echo $linkdin ?>" target="_blank" title="<?php echo $linkdin ?>">
                  <i class="fa fa-linkedin"></i>
                </a>
              <?php endif; ?>
              <?php if($user->googleplus && !empty($this->content_show) && in_array('googleplus', $this->content_show)): ?>
                <?php $googleplus = (preg_match("#https?://#", $user->googleplus) === 0) ? 'http://'.$user->googleplus : $user->googleplus; ?>
                <a href="<?php echo $googleplus ?>" target="_blank" title="<?php echo $googleplus ?>">
                  <i class="fa fa-google-plus"></i>
                </a>
              <?php endif; ?>
            </div>
            <?php if(!empty($this->content_show) && in_array('viewMore', $this->content_show)): ?>
              <div class="team_member_more_link team_member_contact_info">
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
        </div>
      </div>
    <?php //endforeach; ?>
  </div>
</div>