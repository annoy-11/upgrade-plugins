<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesloginpopup
 * @package    Sesloginpopup
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: dismiss_message.tpl  2019-02-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<h2><?php echo $this->translate("Signin / Signup Popup & Page Plugin") ?></h2>
<?php $sesloginpopup_adminmenu = Zend_Registry::isRegistered('sesloginpopup_adminmenu') ? Zend_Registry::get('sesloginpopup_adminmenu') : null; ?>
<?php if($sesloginpopup_adminmenu) { ?>
  <?php if( count($this->navigation) ): ?>
    <div class='tabs'>
      <?php echo $this->navigation()->menu()->setContainer($this->navigation)->render(); ?>
    </div>
  <?php endif; ?>
<?php } ?>
