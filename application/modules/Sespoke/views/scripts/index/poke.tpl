<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespoke
 * @package    Sespoke
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: poke.tpl 2015-07-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sespoke/externals/styles/styles.css'); ?>
<div class="sespoke_action_popup">
<form method="post">
  <div>
    <?php if($this->isPoke): ?>
    	<div class="sespoke_action_popup_title">
      	<?php echo $this->translate("ALERT"); ?>
      </div>
    <?php else: ?>
    	<div class="sespoke_action_popup_title">
        <?php if($this->action == 'action'): ?>
          <?php echo $this->translate(ucfirst($this->manageaction->name)) . ' ' . $this->item->getTitle(); ?>
        <?php else: ?>
          <?php echo $this->translate("Send "); echo $this->translate(ucfirst($this->manageaction->name)); ?>
        <?php endif; ?>
      </div>
    <?php endif; ?>
    <div class="sespoke_action_popup_content sespoke_clearfix">
      <div class="sespoke_action_popup_photo floatL">
    		<?php echo $this->htmlLink($this->item->getHref(), $this->itemPhoto($this->item, 'thumb.profile'), array('class' => '', 'title' => $this->item->getTitle(), 'target' => '_parent')); ?>
    	</div>
    	<div class="sespoke_action_popup_des">
      	<p>
          <?php if($this->isPoke): ?>
          <?php if($this->action == 'gift'): ?>
            <?php echo $this->translate("You have already send "); ?><?php echo $this->translate($this->manageaction->name);?>. <?php echo ' '. $this->translate($this->item->getTitle()). ' ';?><?php echo $this->translate(" has not responded to your sent "); ?><?php echo $this->translate($this->manageaction->name); ?>.
          <?php else: ?>
            <?php echo $this->translate("You have already "); ?><?php echo $this->translate($this->manageaction->name). ' ';?><?php echo $this->translate($this->item->getTitle());?>. <?php echo ' ' .$this->translate($this->item->getTitle()). ' ';?><?php echo $this->translate(" has not responded to your last ");?><?php echo $this->translate($this->manageaction->name);?>
          <?php endif; ?>
          <?php else: ?>
          <?php if($this->action == 'gift'): ?>
            <?php echo $this->translate("Send this "); ?><?php echo $this->translate($this->manageaction->name); ?><?php echo $this->translate(" to "); ?><?php echo $this->translate($this->item->getTitle()); ?>.
          <?php else: ?>
            <?php echo $this->translate("You "); ?><?php echo $this->translate($this->manageaction->name). ' '; ?> <?php echo $this->translate($this->item->getTitle()); ?>. <?php echo $this->translate($this->item->getTitle());?> <?php echo $this->translate(" will informed of this on home page."); ?>
          <?php endif; ?>
          <?php endif; ?>
        </p>
        <?php if($this->isPoke): ?>
          <button onclick='javascript:parent.Smoothbox.close()'><?php echo $this->translate("Okay") ?></button>
        <?php else: ?>
          <input type="hidden" name="confirm"/>
          <?php if($this->action == 'gift'): ?>
          <button type='submit'><?php echo $this->translate("Send") ?></button>&nbsp;&nbsp;
          <?php else: ?>
          <button type='submit'><?php echo $this->translate(ucfirst($this->manageaction->name)) ?></button>&nbsp;&nbsp;
          <?php endif; ?>
          <?php echo $this->translate("or") ?>
          <a href='javascript:void(0);' onclick='javascript:parent.Smoothbox.close()'><?php echo $this->translate("Cancel") ?></a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</form>
</div>