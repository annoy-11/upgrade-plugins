<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<?php $widgetParams = $this->widgetParams; ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesgroup/externals/styles/styles.css'); ?>

<section class="sesgroup_welcome_home_block2 sesbasic_clearfix sesbasic_bxs">
	<div class="sesgroup_welcome_block_container">
		<div class="section_title">
			<h2><?php echo $this->translate("It's too easy to get started with your own Group in 3 steps:")?></h2>
			<p><?php echo $this->translate("You can connect with people who share your interests by joining a public or private Community in Social Engine. Stay up to date on what's happening in your Communities by seeing Community posts in your stream and getting notifications.")?></p>
		</div>
		<br/>
		<div class="block2_inner">
			<div class="inner_icon">
				<img src="application/modules/Sesgroup/externals/images/group_create.png" alt="" />
			</div>
			<h4><?php echo $this->translate("Create New Group")?></h4>
			<p><?php echo $this->translate("Why just only view Groups! Create your own too and get connected to the world.")?></p>
		</div>
		<div class="block2_inner">
			<div class="inner_icon">
				<img src="application/modules/Sesgroup/externals/images/dashboard_cog.png" alt="" />
			</div>
			<h4><?php echo $this->translate("Configure Additional Settings")?></h4>
			<p><?php echo $this->translate("You can also configure other additional settings for your groups after its creation with a great ease from group dashboard.")?></p>
		</div>
		<div class="block2_inner">
			<div class="inner_icon">
				<img src="application/modules/Sesgroup/externals/images/ready.png" alt="" />
			</div>
			<h4><?php echo $this->translate("Your Group is Ready!")?></h4>
			<p><?php echo $this->translate("Your group is now ready to be shared within this community and the outside world. Invite friends, family members to join your group.")?></p>
		</div>
	</div>
</section>