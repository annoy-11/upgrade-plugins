<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: dismiss_message.tpl 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<h2><?php echo $this->translate("Advanced Forums Plugin") ?></h2>
<div class="sesbasic_nav_btns">
  <a href="<?php echo $this->url(array('module' => 'sesforum', 'controller' => 'settings', 'action' => 'support'),'admin_default',true); ?>" class="help-btn">Help & Support</a>
</div>
<?php $sesforum_adminmenu = Zend_Registry::isRegistered('sesforum_adminmenu') ? Zend_Registry::get('sesforum_adminmenu') : null; ?>
<?php if($sesforum_adminmenu) { ?>
  <?php if( count($this->navigation) ): ?>
    <div class='sesbasic-admin-navgation'>
      <?php echo $this->navigation()->menu()->setContainer($this->navigation)->render(); ?>
    </div>
  <?php endif; ?>
<?php } ?>
