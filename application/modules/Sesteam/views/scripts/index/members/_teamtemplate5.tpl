<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesteam
 * @package    Sesteam
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _tematemplate5.tpl 2015-02-20 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesteam/externals/styles/styles.css'); ?>
<h3>
  <?php echo $this->translate(array('%s member found.', '%s members found.', $this->totalUsers),$this->locale()->toNumber($this->totalUsers)) ?>
</h3>
<?php $viewer = Engine_Api::_()->user()->getViewer();?>

<div class="sesteam_temp5_wrap">
  <div class="sesteam_temp5_list sesbasic_clearfix<?php if ($this->center_block): ?> iscenter<?php endif; ?>">
    <?php foreach( $this->users as $user ): ?>
      <div class="team_box">
        <div class="team_box_inner">
          <div class="team_member_thumbnail" style="height:<?php echo $this->height ?>px;width:<?php echo $this->width ?>px;">
              <?php echo $this->htmlLink($user->getHref(), $this->itemPhoto($user, 'thumb.profile', $user->getTitle()), array('title' => $user->getTitle())); ?>
          </div>
          <div class="team_member_info">
            <?php if(!empty($this->content_show) && in_array('displayname', $this->content_show)): ?>
              <p class='team_member_name'>
                  <?php echo $this->htmlLink($user->getHref(), $user->getTitle(), array('title' => $user->getTitle())) ?>              
              </p>
            <?php endif; ?>
            <?php $memberType = Engine_Api::_()->sesteam()->getProfileType($user); ?>
          <?php if($memberType && !empty($this->content_show) && in_array('profileType', $this->content_show)): ?>
              <p class='team_member_role'>
                <?php echo $memberType; ?>
              </p>
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
              <p class='team_member_role'>
                <?php echo $this->translate(array('%s year old', '%s years old', $age), $this->locale()->toNumber($age)); ?>
              </p>
            <?php endif; ?>
            <?php endif; ?>
            <?php //Show Profile Fields of members
              if(!empty($this->content_show) && in_array('profileField', $this->content_show)): ?>
                <p>
                  <?php echo $this->membersFieldValueLoop($user, $this->content_show, $this->labelBold,$this->profileFieldCount); ?>
                </p>
              <?php endif; ?>   
            
            <div class="sesteam-social-icon <?php if(empty($this->sesteam_social_border)): ?>bordernone<?php endif; ?>">
              <?php if($user->email && !empty($this->content_show) && in_array('email', $this->content_show)): ?>
                <a href="mailto:<?php echo $user->email ?>" title="<?php echo $user->email ?>">
                  <i class="fas fa-envelope"></i>
                </a> 
              <?php endif; ?>
              
              <?php if (Engine_Api::_()->sesteam()->hasCheckMessage($user) && !empty($this->content_show) && in_array('message', $this->content_show)): ?>
              <a href="<?php echo $this->baseUrl() ?>/messages/compose/to/<?php echo $user->user_id ?>" target="_parent" title="<?php echo $this->translate('Message'); ?>" class="smoothbox"><i class="fas fa-envelope sesbasic_text_light"></i></a>
              <?php endif; ?>              
              
              <?php $row = Engine_Api::_()->sesteam()->getBlock(array('user_id' => $user->getIdentity(), 'blocked_user_id' => $viewer->getIdentity())); ?>
              <?php if( $row == NULL && !empty($this->content_show) && in_array('addFriend', $this->content_show)): ?>
                <?php if( $this->viewer()->getIdentity()): ?>
                    <?php echo $this->userTeamFriendship($user); ?>
                <?php endif; ?>
              <?php endif; ?>
            </div>
          <?php if($user->status && !empty($this->content_show) && in_array('status', $this->content_show)): ?>
            <div class="team_member_more_link team_member_contact_info">
              <?php if(!empty($this->status)): ?>
                <?php $viewMoreText = $this->translate($this->viewMoreText) . ' &raquo;'; ?>
              <?php else: ?>
                <?php $viewMoreText = $this->translate("View Details") . '&raquo;'; ?>
              <?php endif; ?>
              <?php if($user->status): ?>
                <?php echo $this->htmlLink($user->getHref(), $viewMoreText, array()) ?>
              <?php endif; ?>
            </div>
          <?php endif; ?>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>