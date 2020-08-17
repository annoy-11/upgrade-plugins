<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmusicapp
 * @package    Sesmusicapp
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: dismiss_message.tpl  2018-12-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<h2><?php echo $this->translate("Custom Music for Mobile Apps Extension") ?></h2>
<?php $sesmusicapp_adminmenu = Zend_Registry::isRegistered('sesmusicapp_adminmenu') ? Zend_Registry::get('sesmusicapp_adminmenu') : null; ?>
<?php if($sesmusicapp_adminmenu) { ?>
  <?php if( count($this->navigation) ): ?>
    <div class='tabs'>
      <?php echo $this->navigation()->menu()->setContainer($this->navigation)->render(); ?>
    </div>
  <?php endif; ?>
<?php } ?>
