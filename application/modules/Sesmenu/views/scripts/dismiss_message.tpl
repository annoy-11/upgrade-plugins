<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmenu
 * @package    Sesmenu
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: dismiss_message.tpl  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<h2><?php echo $this->translate("Ultimate Menu Plugin") ?></h2>
<?php $sesmenu_adminmenu = Zend_Registry::isRegistered('sesmenu_adminmenu') ? Zend_Registry::get('sesmenu_adminmenu') : null; ?>
<?php if(!empty($sesmenu_adminmenu)): ?>
  <div class='sesbasic-admin-navgation'>
    <?php echo $this->navigation()->menu()->setContainer($this->navigation)->render(); ?>
  </div>
<?php endif; ?>
