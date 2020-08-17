<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<section class="sescf_make_community sesbasic_clearfix sesbasic_bxs">
	<div class="sescf_make_community_inner">
		<div class="sescf_make_community_desc">
			<h2><?php echo $this->translate("Share your note worthy ideas and start raising funds to make them a reality!")?></h2>
			<p><?php echo $this->translate("Find a cause you believe in and help in making good things happen.")?></p>
			<div class="sescf_banner_btn">
				<a href="<?php echo $this->url(array('action' => 'create'), 'sescrowdfunding_general', true); ?>" target="_blank" class="color_btn"><?php echo $this->translate("Create Crowdfunding")?></a>
				<span class="or_add"><?php echo $this->translate("Or"); ?></span>
				<a href="<?php echo $this->url(array('action' => 'browse'), 'sescrowdfunding_category', true); ?>" target="_blank" class="color_btn"><?php echo $this->translate("Browse Categories")?></a>
			</div>
		</div>
	</div>
</section>
