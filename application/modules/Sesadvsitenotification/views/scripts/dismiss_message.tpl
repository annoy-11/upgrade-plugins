<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvsitenotification
 * @package    Sesadvsitenotification
 * @copyright  Copyright 2016-2017 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: dismiss_message.tpl 2017-01-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<h2><?php echo $this->translate("Advanced Site Notifications in Popups Plugin") ?></h2>
<div class="sesbasic_nav_btns">
  <a href="<?php echo $this->url(array('module' => 'sesbasic', 'controller' => 'settings', 'action' => 'contact-us'),'admin_default',true); ?>" class="request-btn">Feature Request</a>
</div>
<?php 
$sesadvsitenotification_adminmenu = Zend_Registry::isRegistered('sesadvsitenotification_adminmenu') ? Zend_Registry::get('sesadvsitenotification_adminmenu') : null;
if(!empty($sesadvsitenotification_adminmenu)) { ?>
  <?php if( count($this->navigation) ): ?>
    <div class='sesbasic-admin-navgation'>
      <?php echo $this->navigation()->menu()->setContainer($this->navigation)->render() ?>
    </div>
  <?php endif; ?>
<?php } ?>