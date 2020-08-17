<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Sesandroidapp
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: settings.tpl 2018-08-14 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php include APPLICATION_PATH .  '/application/modules/Sesapi/views/scripts/dismiss_message.tpl';?>
<h2>
  <?php echo $this->translate('Native Android Mobile App'); ?>
</h2>
<div class="sesandroidapp_nav_btns">
  <a href="<?php echo $this->url(array('module' => 'sesandroidapp', 'controller' => 'settings', 'action' => 'support'),'admin_default',true); ?>" target = "_blank" class="help-btn">Help</a>
</div>
<?php if( count($this->navigation)): ?>
  <div class='sesandroidapp-admin-navgation'> <?php echo $this->navigation()->menu()->setContainer($this->navigation)->render(); ?> </div>
<?php endif; ?>
<?php if( count($this->subnavigation)): ?>
  <div class='sesandroidapp-admin-navgation'> <?php echo $this->navigation()->menu()->setContainer($this->subnavigation)->render(); ?> </div>
<?php endif; ?>
<div class="settings sesandroidapp_admin_form sesandroidapp_notification">
  <div class='settings'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
