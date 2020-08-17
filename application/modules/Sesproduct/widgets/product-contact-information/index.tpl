<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<div class='sesproduct_owner_contact_details sesbasic_clearfix sesbasic_bxs'>
  <ul>
    <?php if( in_array('name',$this->info) && $this->subject->product_contact_name): ?>
      <li class="sesbasic_clearfix sesproduct_owner_contact_name">
        <?php echo nl2br($this->subject->product_contact_name) ?>
      </li>
    <?php endif ?>
    <?php if( in_array('email',$this->info) && $this->subject->product_contact_email): ?>
      <li class="sesbasic_clearfix" title='<?php echo $this->translate("Contact Email"); ?>'>
        <i class="fa fa-at sesbasic_text_light"></i>  
        <span><a href='mailto:<?php echo $this->subject->product_contact_email ?>' target="_blank" class="sesbasic_linkinherit"><?php echo $this->subject->product_contact_email ?></a></span>
      </li>
    <?php endif ?>
    <?php if( in_array('phone',$this->info) && $this->subject->product_contact_phone): ?>
      <li class="sesbasic_clearfix" title='<?php echo $this->translate("Contact Phone Number"); ?>'>
        <i class="fa fa-mobile sesbasic_text_light"></i>
        <span><?php echo ($this->subject->product_contact_phone) ?></span>
      </li>
    <?php endif ?>
    <?php if( in_array('facebook',$this->info) && $this->subject->product_contact_facebook): ?>
      <li class="sesbasic_clearfix">
        <i class="fa fa-facebook"></i>
        <span><a class="sesbasic_linkinherit" target="_blank" href='<?php echo parse_url($this->subject->product_contact_facebook, PHP_URL_SCHEME) === null ? 'https://' . $this->subject->product_contact_facebook : $this->subject->product_contact_facebook; ?>'><?php echo parse_url($this->subject->product_contact_facebook, PHP_URL_SCHEME) === null ? '' . $this->subject->product_contact_facebook : $this->subject->product_contact_facebook; ?>'</a></span>
      </li>
    <?php endif ?>
    <?php if( in_array('website',$this->info) && $this->subject->product_contact_website): ?>
      <li class="sesbasic_clearfix">
        <i class="fa fa-globe"></i>
        <span><a class="sesbasic_linkinherit" target="_blank" href='<?php echo parse_url($this->subject->product_contact_website, PHP_URL_SCHEME) === null ? 'http://' . $this->subject->product_contact_website : $this->subject->product_contact_website; ?>' title='<?php echo $this->translate("Website URL"); ?>'><?php echo parse_url($this->subject->product_contact_website, PHP_URL_SCHEME) === null ? '' . $this->subject->product_contact_website : $this->subject->product_contact_website; ?></a></span>
      </li>
    <?php endif ?>
    <li class="sesproduct_owner_contact_social" style="display: none;">
      <?php if( in_array('facebook',$this->info) && $this->subject->product_contact_facebook): ?>
        <a target="_blank" href='<?php echo parse_url($this->subject->product_contact_facebook, PHP_URL_SCHEME) === null ? 'https://' . $this->subject->product_contact_facebook : $this->subject->product_contact_facebook; ?>' title='<?php echo $this->translate("Facebook URL"); ?>'><i class="fa fa-facebook-square"></i></a>
      <?php endif ?>
      <?php if( in_array('website',$this->info) && $this->subject->product_contact_website): ?>
        <a target="_blank" href='<?php echo parse_url($this->subject->product_contact_website, PHP_URL_SCHEME) === null ? 'http://' . $this->subject->product_contact_website : $this->subject->product_contact_website; ?>' title='<?php echo $this->translate("Website URL"); ?>'><i class="fa fa-globe"></i></a>
      <?php endif ?>
    </li>
  </ul>
</div>
<script type="application/javascript">
var tabId_contactinfo = <?php echo $this->identity; ?>;
window.addEvent('domready', function() {
	tabContainerHrefSesbasic(tabId_contactinfo);	
});
</script>
