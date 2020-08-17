<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesevent
 * @package    Sesevent
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: eventsponsorship.tpl 2016-07-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php include APPLICATION_PATH .  '/application/modules/Sesevent/views/scripts/dismiss_message.tpl';?>
<div class='sesbasic-form sesbasic-categories-form'>
  <div>
    <?php if( count($this->subNavigation) ): ?>
      <div class='sesbasic-admin-sub-tabs'>
        <?php echo $this->navigation()->menu()->setContainer($this->subNavigation)->render();?>
      </div>
    <?php endif; ?>
    <?php if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('seseventsponsorship')): ?>
    <div class='sesbasic-form-cont'>
    <div class='clear'>
		  <div class='settings sesbasic_admin_form'>
		    <?php echo $this->form->render($this); ?>
		  </div>
		</div>
		</div>
    <?php else: ?>
			<?php $eventsponsorshipInstalled = Engine_Api::_()->sesbasic()->pluginInstalled('seseventsponsorship'); ?>
			<?php if(empty($eventsponsorshipInstalled)): ?>
				<div id="" class="ses_tip_red tip" style="margin:10px 10px 0;">
				  <span>
				    <?php echo 'At you site Advanced Event Sponsorship Extension is not installed. So, please purchase Advanced Event Sponsorship Extension from here.'; ?>
				  </span>
				</div>
			<?php elseif(!Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('seseventsponsorship')): ?>
      <div id="" class="ses_tip_red tip" style="margin:10px 10px 0;">
				  <span>
				    <?php echo 'At you site Advanced Event Tickets Extension is installed but not enable. So, you can enable this extension from "Manage Packages" section.'; ?>
				  </span>
				</div>
			<?php endif; ?>
    <?php endif; ?>
  </div>
</div>