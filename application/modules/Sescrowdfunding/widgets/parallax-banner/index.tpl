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

<div class="sescf_parallax_banner sesbasic_bxs sesbasic_clearfix">
  <div class="sescf_parallax_banner_inner" style="background-image:url(<?php echo $this->banner; ?>);">
    <div class="_container">
      <div class="sescf_parallax_banner_desc">
        <h2><?php echo $this->translate("Charity Sees The Need, Not The Cause"); ?></h2>
        <p><?php echo $this->translate("We understand that asking for charity is not a business and if someone is asking for charity or donation, then the person is really in need, so we appeal to all the donors to donate at their best and help fundraisers."); ?></p>
        <div class="sescf_banner_btn">
          <a href="<?php echo $this->url(array('action' => 'create'), 'sescrowdfunding_general', true); ?>" class="color_btn"><?php echo $this->translate("Start Crowdfunding"); ?></a>
          <a href="<?php echo $this->url(array('action' => 'home'), 'sescrowdfunding_general', true); ?>" class="nobg_btn"><?php echo $this->translate("Know More"); ?></a>
        </div>
      </div>
    </div>
  </div>
</div>
