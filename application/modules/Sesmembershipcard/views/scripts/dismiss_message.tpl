<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmembershipcard
 * @package    Sesmembershipcard
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: dismiss_message.tpl  2019-02-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<h2><?php echo $this->translate("Membership Cards") ?></h2>
<?php $sesmembershipcard_adminmenu = Zend_Registry::isRegistered('sesmembershipcard_adminmenu') ? Zend_Registry::get('sesmembershipcard_adminmenu') : null; ?>
<?php if($sesmembershipcard_adminmenu) { ?>
  <?php if( count($this->navigation) ): ?>
    <div class='tabs'>
      <?php echo $this->navigation()->menu()->setContainer($this->navigation)->render(); ?>
    </div>
  <?php endif; ?>
<?php } ?>
