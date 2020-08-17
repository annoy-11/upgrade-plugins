<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessoffer
 * @package    Sesbusinessoffer
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: dismiss_message.tpl  2019-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<h2><?php echo $this->translate("Business Offers Extension") ?></h2>
<?php $sesbusinessoffer_adminmenu = Zend_Registry::isRegistered('sesbusinessoffer_adminmenu') ? Zend_Registry::get('sesbusinessoffer_adminmenu') : null; ?>
<?php if($sesbusinessoffer_adminmenu) { ?>
  <?php if(count($this->navigation) ): ?>
    <div class='sesbasic-admin-navgation'>
      <?php echo $this->navigation()->menu()->setContainer($this->navigation)->render(); ?>
    </div>
  <?php endif; ?>
<?php } ?>
