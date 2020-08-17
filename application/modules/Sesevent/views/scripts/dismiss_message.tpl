<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesevent
 * @package    Sesevent
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: dismiss_message.tpl 2016-07-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<style>
.ses_tip_red > span {
background-color:red;
color: white;
}
</style>

<?php if(0): ?>
<?php $eventticketInstalled = Engine_Api::_()->sesbasic()->pluginInstalled('seseventticket'); ?>
<?php if(empty($eventticketInstalled)): ?>
	<div id="" class="ses_tip_red tip">
	  <span>
	    <?php echo 'At you site Advanced Event Tickets Extension is not installed.'; ?>
	  </span>
	</div>
<?php elseif(!Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('seseventticket')): ?>
	<div id="" class="ses_tip_red tip">
	  <span>
	    <?php echo 'At you site Advanced Event Tickets Extension is installed but not enable.'; ?>
	  </span>
	</div>
<?php endif; ?>

<?php $eventsponsorshipInstalled = Engine_Api::_()->sesbasic()->pluginInstalled('seseventsponsorship'); ?>
<?php if(empty($eventsponsorshipInstalled)): ?>
	<div id="" class="ses_tip_red tip">
	  <span>
	    <?php echo 'At you site Advanced Event Sponsorship Extension is not installed.'; ?>
	  </span>
	</div>
<?php elseif(!Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('seseventsponsorship')): ?>
	<div id="" class="ses_tip_red tip">
	  <span>
	    <?php echo 'At you site Advanced Event Sponsorship Extension is installed but not enable.'; ?>
	  </span>
	</div>
<?php endif; ?>
<?php endif; ?>

<h2><?php echo $this->translate("Advanced Events Plugin") ?></h2>
<?php if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesbasic'))
	{
		include APPLICATION_PATH .  '/application/modules/Sesbasic/views/scripts/_mapKeyTip.tpl'; 
	} else { ?>
		 <div class="tip"><span><?php echo $this->translate("This plugin requires \"<a href='https://socialnetworking.solutions/social-engine/socialenginesolutions-basic-required-plugin/' target='_blank'>SocialNetworking.Solutions (SNS) Basic Required Plugin </a>\" to be installed and enabled on your website for Location and various other featrures to work. Please get the plugin from <a href='https://socialnetworking.solutions/social-engine/socialenginesolutions-basic-required-plugin/' target='_blank'>here</a> to install and enable on your site."); ?></span></div>
	<?php } ?>

<?php $seseventvideoEnable = Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('seseventvideo');  ?>
<?php if(count($this->navigation) ): ?>
  <div class='tabs'>
		<ul>
		  <?php foreach( $this->navigation as $navigationMenu ):
				$explodedal = explode(' ', $navigationMenu->class);
			?>
		    <?php if(empty($seseventvideoEnable) && end($explodedal) == 'sesevent_admin_main_seseventvideo') continue; ?>
		    <li <?php if ($navigationMenu->active): ?><?php echo "class='active'";?><?php endif; ?>>
		      <?php echo $this->htmlLink($navigationMenu->getHref(), $this->translate($navigationMenu->getLabel()), array(
		        'class' => $navigationMenu->getClass())); ?>
		    </li>
		  <?php endforeach; ?>
		</ul>
  </div>
<?php endif; ?>
