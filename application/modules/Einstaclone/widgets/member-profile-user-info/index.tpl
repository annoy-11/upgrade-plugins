<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Einstaclone
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-12-30 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Einstaclone/externals/styles/styles.css'); 
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Einstaclone/externals/scripts/member/membership.js'); 
?>
<div class="einstaclone_member_profile">
   <div class="einstaclone_member_profile_inner">
      <div class="einstaclone_member_profile_info">
        <?php if($this->viewer_id) { ?>
          <span class="coverphoto_navigation">
            <i class="fa fa-cog" aria-hidden="true"></i>
            <ul>
              <?php foreach( $this->userNavigation as $link ): ?>
                <li>
                  <?php echo $this->htmlLink($link->getHref(), $this->translate($link->getLabel()), array(
                    'class' => 'buttonlink' . ( $link->getClass() ? ' ' . $link->getClass() : '' ),
                    'style' => $link->get('icon') ? 'background-image: url('.$link->get('icon').');' : '',
                    'target' => $link->get('target'),
                  )) ?>
                </li>
              <?php endforeach; ?>
            </ul>
          </span>
        <?php } ?>
         <div class="_img">
           <?php echo $this->itemPhoto($this->subject, 'thumb.profile', true); ?>
         </div>
         <div class="_cont">
           <h2><?php echo $this->translate('%1$s', $this->subject()->getTitle()); ?></h2> 
           <h3><?php echo $this->subject->username; ?></h3> 
           <?php if($this->subject()->status) { ?>
            <h4><?php echo $this->viewMore($this->getHelper('getActionContent')->smileyToEmoticons($this->subject()->status)) ?></h4> 
           <?php } ?>
           <ul>
            <li><span><?php echo $this->postCount; ?></span><?php echo $this->translate(" posts"); ?></li> 
            <li>
              <?php $direction = Engine_Api::_()->getApi('settings', 'core')->getSetting('user.friends.direction'); 
              if ( $direction == 0 ): ?> 
                <span><?php echo $this->subject->member_count ?></span><?php echo $this->translate(' followers'); ?> 
              <?php else: ?> 
                <span><?php echo $this->subject->member_count; ?></span><?php echo $this->translate(' friends'); ?> 
              <?php endif; ?> 
            </li> 
            <li><span><?php echo $this->followCount; ?></span><?php echo $this->translate(" following"); ?></li>
           </ul>
           <div class="einsta_profile_btns">
              <?php if($this->viewer->getIdentity() && $this->subject->getIdentity() != $this->viewer->getIdentity()){ ?>
                <?php
                  $subject = $this->subject;
                  $viewer = $this->viewer;
                ?>
                <?php include APPLICATION_PATH .  '/application/modules/Einstaclone/views/scripts/_addfriend_button.tpl';?>
              <?php } ?>

              <?php if(Engine_Api::_()->einstaclone()->hasCheckMessage($this->subject)){ ?>
                <a href="messages/compose/to/<?php echo $this->subject->getIdentity(); ?>/format/smoothbox" class="msg smoothbox" target=""><i class="fa fa-comments"></i><span><?php echo $this->translate("Send Message"); ?></span></a>
              <?php } ?>
           </div>
         </div>
      </div>
   </div>
</div>
