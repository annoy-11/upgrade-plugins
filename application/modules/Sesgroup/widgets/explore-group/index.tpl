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

<section class="sesgroup_welcome_home_block1 sesbasic_clearfix sesbasic_bxs">
	<div class="sesgroup_welcome_block_container">
		<div class="block_left_desc">
			<h2><?php echo $this->translate("It's Easy to Stay Connected to Your Community, Wherever You Are.")?></h2>
			<p><?php echo $this->translate("People are \"communal\" by nature as they can be engaged around their functions, disciplines, information needs and professions, to name a few. When we build relationships with people, whether it's in a direct way or indirectly communities are built. You can easily create your Groups on this website and get connected with the people.")?></p>
			<p><?php echo $this->translate("With the help of Groups you can:")?></p>	
			<ul>
				<li><?php echo $this->translate("<strong>Build professional relationships</strong> and networks of trust.")?></li>
				<li><?php echo $this->translate("<strong>Bring together people </strong> with common interests or profiles.")?></li>
				<li><?php echo $this->translate("<strong>Engage </strong>specific groups of people.")?></li>
				<li><?php echo $this->translate("And much more.")?></li>
			</ul>	
			<div class="block_btn_link">
				<a href="/group-communities/browse" class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp; <?php echo $this->translate("Join New Groups")?></a>
				<a href="/group-communities/categories" class="btn btn-primary"><i class="fa fa-th"></i>&nbsp; <?php echo $this->translate("Explore Categories")?></a>
			</div>
		</div>
		<div class="block_right_img">
			<img src="application/modules/Sesgroup/externals/images/group_community.png" alt="" />
		</div>
	</div>
</section>