<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesteam
 * @package    Sesteam
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _tematemplate2.tpl 2015-02-20 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesteam/externals/styles/styles.css'); ?>
<h3>
  <?php echo $this->translate(array('%s member found.', '%s members found.', $this->totalUsers),$this->locale()->toNumber($this->totalUsers)) ?>
</h3>
<?php $viewer = Engine_Api::_()->user()->getViewer();?>

<div class="sesteam_temp2_wrap">
  <div class="sesteam_temp2_list sesbasic_clearfix<?php if ($this->center_block): ?> iscenter<?php endif; ?>">
    <?php foreach( $this->users as $user ): ?>
      <div class="team_box" style="width:<?php echo $this->width ?>px;">
        <div class="team_box_inner">
          <div class="team_member_thumbnail">
            <div class="team_member_thumbnail_inner" style="height:<?php echo $this->height ?>px;">
               <?php echo $this->htmlLink($user->getHref(), $this->itemPhoto($user, 'thumb.profile', $user->getTitle()), array('title' => $user->getTitle())); ?>
            </div>
          </div>
          <?php if(!empty($this->content_show) && in_array('displayname', $this->content_show)): ?>
            <p class='team_member_name'>
                <?php echo $this->htmlLink($user->getHref(), $user->getTitle(), array('title' => $user->getTitle())) ?>              
            </p>
          <?php endif; ?>
          <?php $memberType = Engine_Api::_()->sesteam()->getProfileType($user); ?>
          <?php if($memberType && !empty($this->content_show) && in_array('profileType', $this->content_show)): ?>
            <div class='team_member_role team_member_info'>
              <div class="team_member_info_label sesbasic_text_light">Profile Type</div>
              <div class="team_member_info_des"><?php echo $memberType; ?></div>
            </div>
          <?php endif; ?>
          <?php if($this->age): $age = 0; ?>  
            <?php $getFieldsObjectsByAlias = Engine_Api::_()->fields()->getFieldsObjectsByAlias($user); 
            if (!empty($getFieldsObjectsByAlias['birthdate'])) {
              $optionId = $getFieldsObjectsByAlias['birthdate']->getValue($user); 
              if (@$optionId->value) {
                $age = floor((time() - strtotime($optionId->value)) / 31556926);
              }
            }  
            ?>
            <?php if($age && $optionId->value): ?>
              <div class='team_member_role team_member_info'>
              <div class="team_member_info_label sesbasic_text_light">Age</div>
              <div class="team_member_info_des"><?php echo $this->translate(array('%s year old', '%s years old', $age), $this->locale()->toNumber($age)); ?></div>
              </div>
            <?php endif; ?>
          <?php endif; ?>
          <?php if($user->email && !empty($this->content_show) && in_array('email', $this->content_show)): ?>
            <div class='team_member_role team_member_info'>
              <div class="team_member_info_label sesbasic_text_light">Email</div>
              <div class="team_member_info_des">
                <a href="mailto:<?php echo $user->email ?>" title="<?php echo $user->email ?>">
                  <?php echo $user->email ?>
                </a> 
              </div>
            </div>
          <?php endif; ?>
          <?php //Show Profile Fields of members
          if(!empty($this->content_show) && in_array('profileField', $this->content_show)): ?>
            <div class='team_member_role team_member_info'>
              <div class="team_member_info_des"><?php echo $this->membersFieldValueLoop($user, $this->content_show, $this->labelBold,$this->profileFieldCount); ?></div>
            </div>
          <?php endif; ?>
          
          <?php $row = Engine_Api::_()->sesteam()->getBlock(array('user_id' => $user->getIdentity(), 'blocked_user_id' => $viewer->getIdentity())); ?>
          
          <?php if(!empty($this->content_show) && ($user->status || in_array('email', $this->content_show) || in_array('message', $this->content_show) || in_array('addFriend', $this->content_show) || Engine_Api::_()->sesteam()->hasCheckMessage($user) || $row == NULL)): ?>
            <div class="sesteam-social-links team_member_info">
              <?php if($viewer->getIdentity() == $user->user_id): ?>
              <?php if(in_array('email', $this->content_show)): ?>
               <div class="team_member_info_label sesbasic_text_light">Web</div>
              <?php endif; ?>
              <?php else: ?>
                <div class="team_member_info_label sesbasic_text_light">Web</div>
              <?php endif; ?>
              <div class="team_member_info_des sesbasic_text_light">
                <div class="sesteam-social-icon <?php if(empty($this->sesteam_social_border)): ?>bordernone<?php endif; ?>">
                  <?php if($user->email && !empty($this->content_show) && in_array('email', $this->content_show)): ?>
                    <a href="mailto:<?php echo $user->email ?>" title="<?php echo $user->email ?>">
                      <i class="fas fa-envelope sesbasic_text_light"></i>
                    </a> 
                  <?php endif; ?>
                  
                  <?php if (Engine_Api::_()->sesteam()->hasCheckMessage($user) && !empty($this->content_show) && in_array('message', $this->content_show)): ?>
                    <a href="<?php echo $this->baseUrl() ?>/messages/compose/to/<?php echo $user->user_id ?>" target="_parent" title="<?php echo $this->translate('Message'); ?>" class="smoothbox"><i class="fas fa-envelope sesbasic_text_light"></i></a>
                  <?php endif; ?> 
                  
                  
                  <?php if( $row == NULL && !empty($this->content_show) && in_array('addFriend', $this->content_show)): ?>
                    <?php if( $this->viewer()->getIdentity()): ?>
                      <?php echo $this->userTeamFriendship($user); ?>
                    <?php endif; ?>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          <?php endif; ?>

          <?php if($user->status && !empty($this->content_show) && in_array('status', $this->content_show)): ?>
            <div class='team_member_des team_member_info'>
              <div class="team_member_info_label sesbasic_text_light">About</div>
              <div class="team_member_info_des"><?php echo $this->translate($user->status); ?>
                 <?php if(!empty($this->content_show) && in_array('viewMore', $this->content_show)): ?>
                  <span class="team_member_more_link">
                    <?php if(!empty($this->viewMoreText)): ?>
                      <?php $viewMoreText = $this->translate($this->viewMoreText) . ' &raquo;'; ?>
                    <?php else: ?>
                      <?php $viewMoreText = $this->translate("more") . '&raquo;'; ?>
                    <?php endif; ?>
                    <?php if($user->status): ?>
                     <?php echo $this->htmlLink($user->getHref(), $viewMoreText, array()) ?>
                   <?php endif; ?>
                  </span>
                <?php endif; ?>
              </div>
            </div>
          <?php endif; ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>