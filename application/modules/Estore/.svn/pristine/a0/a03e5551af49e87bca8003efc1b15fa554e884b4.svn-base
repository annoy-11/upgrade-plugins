<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _newLabel.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php if(isset($this->contactDetailActive) && (isset($store->store_contact_phone) || isset($store->store_contact_email) || isset($store->store_contact_website))):?>
  <div class="estore_seller_info">
    <?php  if($store->store_contact_phone):?>    
      <div class="_stats sesbasic_text_light">
        <?php if(ESTORESHOWCONTACTDETAIL == 1):?>
          <a href="javascript:void(0);" onclick="sessmoothboxDialoge('<?php echo $store->store_contact_phone ;?>');"><?php echo $this->translate("View Phone No")?></a>
        <?php else:?>
          <a href="<?php echo $this->url(array('action' => 'show-login-page'),'estore_general',true);?>" class="smoothbox"><?php echo $this->translate("View Phone No")?></a>
        <?php endif;?>
      </div>
    <?php  endif;?>
    <?php  if($store->store_contact_email):?>
      <div class="_stats sesbasic_text_light">
        <?php if(ESTORESHOWCONTACTDETAIL == 1):?>
          <a href='mailto:<?php echo $store->store_contact_email ?>'><?php echo $this->translate("Send Email")?></a>
        <?php else:?>
          <a href="<?php echo $this->url(array('action' => 'show-login-page'),'estore_general',true);?>" class="smoothbox"><?php echo $this->translate("Send Email")?></a>
        <?php endif;?>
      </div>
    <?php  endif;?>
    <?php  if($store->store_contact_website):?>
      <div class="_stats sesbasic_text_light">
        <?php if(ESTORESHOWCONTACTDETAIL == 1):?>
          <a href="<?php echo parse_url($store->store_contact_website, PHP_URL_SCHEME) === null ? 'http://' . $store->store_contact_website : $store->store_contact_website; ?>" target="_blank"><?php echo $this->translate("Visit Website")?></a>
        <?php else:?>
          <a href="<?php echo $this->url(array('action' => 'show-login-page'),'estore_general',true);?>" class="smoothbox"><?php echo $this->translate("Visit Website")?></a>
        <?php endif;?>
      </div>
    <?php  endif;?>
  </div>
<?php endif;?>
