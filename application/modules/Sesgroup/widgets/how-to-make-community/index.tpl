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
<section class="sesgroup_welcome_home_block3 sesbasic_clearfix sesbasic_bxs">
	<div class="sesgroup_welcome_block_container">
		<div class="block3_inner">
			<h2><?php echo $this->translate("Don't miss out on what's happening in your community")?></h2>
			<p><?php echo $this->translate("Its very easy to find your own Groups or create new one.")?></p>
			<div class="block_btn_link">
				<a href="group-communities/manage" target="_blank" class="btn btn-primary"><?php echo $this->translate("Find Your Group")?></a>
				<span class="or_add"><?php echo $this->translate("Or")?></span>
				<a href="group-communities/create" target="_blank" class="btn btn-primary"><?php echo $this->translate("Create New Group")?></a>
			</div>
		</div>
	</div>
</section>
