<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmemveroth
 * @package    Sesmemveroth
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-03-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $sesmemberModuleEnabled = Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesmember'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesmemveroth/externals/styles/styles.css'); ?>

<?php //if (!empty($this->viewer_id)): ?>
	<div class="sesbasic_clearfix sesbasic_bxs sesmemveroth_button_block">
    <?php if(count($this->allRequests) >= $this->vifitionlmt) { ?>
    	<div class="sesmemveroth_verify_msg sesbasic_clearfix sesbasic_bg">
        <?php if(in_array('badge', $this->allParams['showdetails'])) { ?>
        	<i><img src="<?php echo $this->verifybadge; ?>" alt="" /></i>
         <?php } ?>
        <span><?php echo $this->translate("Verified Member"); ?></span>
      </div>
    <?php } ?>

    <?php if($this->isVerify) { ?>
      <?php if($this->verification->admin_approved) { ?>
        <div class="sesmemveroth_verify_block_msg"><?php echo $this->translate("You have verified this member."); ?></div>
      <?php } else { ?>
        <div class="sesmemveroth_verify_block_msg"><?php echo $this->translate("Your request for verifying %s is waiting admin approval.", $this->subject->getTitle()); ?></div>
      <?php } ?>
      <div class="sesmemveroth_action_buttons">
        <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmemveroth.enablecomment', 1) && $this->edit) { ?>
          <a href="<?php echo $this->url(array('module' => 'sesmemveroth', 'controller' => 'index', 'action' => 'verification', 'id' => $this->subject_id, 'verification_id' => $this->isVerify), 'default', true); ?>" class="smoothbox">
            <i class="sesbasic_icon_edit"></i>
            <span><?php if($this->verification->admin_approved) { ?><?php echo $this->translate("Edit") ?><?php } else { ?><?php echo $this->translate("Edit Request") ?><?php } ?></span>
          </a>
        <?php } ?>
        <?php if($this->cancel) { ?>
          <a href="<?php echo $this->url(array('module' => 'sesmemveroth', 'controller' => 'index', 'action' => 'cancel', 'id' => $this->subject_id, 'verification_id' => $this->isVerify), 'default', true); ?>" class="smoothbox">
						<i class="<?php if(!$this->verification->admin_approved) { ?>sesbasic_icon_cancel<?php } else { ?>sesbasic_icon_delete<?php } ?>"></i>
            <span><?php if(!$this->verification->admin_approved) { ?><?php echo $this->translate("Cancel Request") ?><?php } else { ?><?php echo $this->translate("Remove"); ?><?php } ?></span>
        	</a>
        <?php } ?>
      </div>  
    <?php } else if($this->enableverification == 2 && $this->allow && $this->enbeveriftion && in_array('button', $this->allParams['showdetails']) && $this->viewer_id != $this->subject_id) { ?>
    	<div class="sesmemveroth_verify_button">
        <a href="<?php echo $this->url(array('module' => 'sesmemveroth', 'controller' => 'index', 'action' => 'verification', 'id' => $this->subject_id), 'default', true); ?>" class="smoothbox sesbasic_link_btn">
          <span><?php echo $this->translate("Verify %s", $this->subject->getTitle()) ?></span>
        </a>
      </div>
    <?php } else if(!$sesmemberModuleEnabled && $this->enableverification == 1 && $this->allow && $this->enbeveriftion && in_array('button', $this->allParams['showdetails']) && count($this->allViewerRequests) >= $this->verificationViewerlimit && $this->viewer_id != $this->subject_id) { ?>
    	<div class="sesmemveroth_verify_button">
        <a href="<?php echo $this->url(array('module' => 'sesmemveroth', 'controller' => 'index', 'action' => 'verification', 'id' => $this->subject_id), 'default', true); ?>" class="smoothbox sesbasic_link_btn">
          <span><?php echo $this->translate("Verify %s", $this->subject->getTitle()) ?></span>
        </a>
      </div>
    <?php } ?>
    
    <?php if(count($this->allRequests) > 0 && in_array('details', $this->allParams['showdetails'])) { ?>
      <div class="sesmemveroth_verify_block_msg">
      <?php if($this->viewer_id == $this->subject_id) { ?>
        <?php echo $this->translate("You have been verified by "); ?>
      <?php } else { ?>
        <?php echo $this->translate("%s has been verified by ", $this->subject->getTitle()); ?>
      <?php } ?>
      <?php echo $this->translate(array('%s member', '%s members', count($this->allRequests)), $this->locale()->toNumber(count($this->allRequests))) ?>&nbsp;&nbsp;<a class="sessmoothbox" href="<?php echo $this->url(array('module' => 'sesmemveroth', 'controller' => 'index', 'action' => 'view', 'resource_id' => $this->subject_id), 'default', true); ?>"><?php echo $this->translate("View Details"); ?></a>
    	</div>
    <?php } ?>
  </div>
<?php //endif; ?>
