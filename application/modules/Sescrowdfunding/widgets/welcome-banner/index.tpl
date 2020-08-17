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
<div class="sescf_welcome_banner sesbasic_bxs sesbasic_clearfix">
  <div class="sescf_welcome_banner_inner" style="background-image:url(<?php echo $this->banner; ?>)">
    <div class="_container">
      <div class="sescf_welcome_banner_desc">
        <h2><?php echo $this->translate("We can't help everyone, but everyone can help someone."); ?></h2>
        <p><?php echo $this->translate("Giving is not just about making Donation, it is about making Difference!!"); ?></p>
        <div class="sescf_banner_btn">
          <a href="<?php echo $this->url(array('action' => 'create'), 'sescrowdfunding_general', true); ?>" class="color_btn"><?php echo $this->translate("Get Started"); ?></a>
          <a href="<?php echo $this->url(array('action' => 'home'), 'sescrowdfunding_general', true); ?>" class="nobg_btn"><?php echo $this->translate("Donate Now"); ?></a>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="sescf_welcome_banner_lower">
  <div class="_container">
    <div class="sescf_welcome_banner_lower_inner">
      <div class="sescf_welcome_banner_lower_text">
        <h4><?php echo $this->translate("Raise funds for anything."); ?></h4>
        <p><?php echo $this->translate("Combine the social power to help you achieve your Goals in raising funds."); ?></p>
      </div>
      <div class="sescf_welcome_banner_lower_btn">
        <a href="<?php echo $this->url(array('action' => 'create'), 'sescrowdfunding_general', true); ?>" class="color_btn"><?php echo $this->translate("Create Your Crowdfunding"); ?></a>
      </div>
    </div>
  </div>
</div>
