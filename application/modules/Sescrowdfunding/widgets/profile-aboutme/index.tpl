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
<div class="sesbasic_clearfix sesbasic_bxs sescf_owner_information">
	<ul class="sesbasic_clearfix">
    <?php if($this->crowdfunding->crowdfunding_contact_name): ?>
      <li>
        <span><?php echo $this->translate("Full Name")?></span>
        <span><?php echo $this->crowdfunding->crowdfunding_contact_name; ?></span>
      </li>
    <?php endif; ?>
    <?php if($this->crowdfunding->crowdfunding_contact_email): ?>
      <li>
        <span><?php echo $this->translate("Email:")?></span>
        <span>
          <a href='mailto:<?php echo $this->crowdfunding->crowdfunding_contact_email ?>' target="_blank">
            <?php echo $this->crowdfunding->crowdfunding_contact_email; ?>
          </a>
        </span> 
      </li>
    <?php endif; ?>
    <?php if($this->crowdfunding->crowdfunding_contact_country): ?>
      <li>
        <span><?php echo $this->translate("Country:")?></span>
        <span><?php echo $this->crowdfunding->crowdfunding_contact_country; ?></span>
      </li>
    <?php endif; ?>
    <?php if($this->crowdfunding->crowdfunding_contact_state): ?>
      <li>
        <span><?php echo $this->translate("State:")?></span>
        <span><?php echo $this->crowdfunding->crowdfunding_contact_state; ?></span>
      </li>
    <?php endif; ?>
    <?php if($this->crowdfunding->crowdfunding_contact_city): ?>
      <li>
        <span><?php echo $this->translate("City:")?></span>
        <span><?php echo $this->crowdfunding->crowdfunding_contact_city; ?></span>
      </li>
    <?php endif; ?>
    <?php if($this->crowdfunding->crowdfunding_contact_street): ?>
      <li>
        <span><?php echo $this->translate("Street:")?></span>
        <span><?php echo $this->crowdfunding->crowdfunding_contact_street; ?></span>
      </li>
    <?php endif; ?>
    <?php if($this->crowdfunding->crowdfunding_contact_phone): ?>
      <li>
        <span><?php echo $this->translate("Phone:")?></span>
        <span><?php echo $this->crowdfunding->crowdfunding_contact_phone; ?></span>
      </li>
    <?php endif; ?>
    <?php if($this->crowdfunding->crowdfunding_contact_website): ?>
      <li>
        <span><?php echo $this->translate("Website URL: "); ?></span>
        <span><a class="" target="_blank" href='<?php echo parse_url($this->crowdfunding->crowdfunding_contact_website, PHP_URL_SCHEME) === null ? 'http://' . $this->crowdfunding->crowdfunding_contact_website : $this->crowdfunding->crowdfunding_contact_website; ?>' title='<?php echo $this->translate("Website URL"); ?>'><?php echo $this->crowdfunding->crowdfunding_contact_website; ?></a></span>
      </li>
    <?php endif; ?>
    <?php if($this->crowdfunding->crowdfunding_contact_facebook): ?>
      <li>
        <span><?php echo $this->translate("Facebook URL: "); ?></span>
        <span><a class="" target="_blank" href='<?php echo parse_url($this->crowdfunding->crowdfunding_contact_facebook, PHP_URL_SCHEME) === null ? 'https://' . $this->crowdfunding->crowdfunding_contact_facebook : $this->crowdfunding->crowdfunding_contact_facebook; ?>'><?php echo $this->crowdfunding->crowdfunding_contact_facebook; ?></a></span>
      </li>
    <?php endif; ?>    
    <?php if($this->crowdfunding->crowdfunding_contact_twitter): ?>
      <li>
        <span><?php echo $this->translate("Twitter URL: "); ?></span>
        <span><a class="" target="_blank" href='<?php echo parse_url($this->crowdfunding->crowdfunding_contact_twitter, PHP_URL_SCHEME) === null ? 'https://' . $this->crowdfunding->crowdfunding_contact_twitter : $this->crowdfunding->crowdfunding_contact_twitter; ?>'><?php echo $this->crowdfunding->crowdfunding_contact_twitter; ?></a></span>
      </li>
    <?php endif; ?>    
    <?php if($this->crowdfunding->crowdfunding_contact_aboutme): ?>
      <li>
      	<span><?php echo $this->translate("About Me")?></span>
        <span><?php echo $this->crowdfunding->crowdfunding_contact_aboutme; ?></span>
      </li>
    <?php endif; ?>
	</ul>
</div>
