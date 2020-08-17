<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: dismiss_message.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $sespage_sespageadminmenu = Zend_Registry::isRegistered('sespage_sespageadminmenu') ? Zend_Registry::get('sespage_sespageadminmenu') : null;
$enableglocation = Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1);
?>
<h2><?php echo $this->translate("Page Directories Plugin") ?></h2>
<?php if($enableglocation) { ?>
  <?php include APPLICATION_PATH .  '/application/modules/Sesbasic/views/scripts/_mapKeyTip.tpl';?>
<?php } ?>
<?php if(!empty($sespage_sespageadminmenu)) { ?>
  <?php if( count($this->navigation) ): ?>
    <div class='sesbasic-admin-navgation'>
      <?php echo $this->navigation()->menu()->setContainer($this->navigation)->render(); ?>
    </div>
  <?php endif; ?>
<?php } ?>
