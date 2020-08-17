<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Einstaclone
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: dismiss_message.tpl 2019-12-30 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<h2><?php echo $this->translate("Insta Clone Theme") ?></h2>
<div class="einstaclone_nav_btns">
  <a href="<?php echo $this->url(array('module' => 'einstaclone', 'controller' => 'settings', 'action' => 'support'),'admin_default',true); ?>" class="help-btn">Help & Support</a>
</div>

<?php $einstaclone_adminmenu = Zend_Registry::isRegistered('einstaclone_adminmenu') ? Zend_Registry::get('einstaclone_adminmenu') : null; ?>
<?php if(!empty($einstaclone_adminmenu)) { ?>
  <?php if( count(@$this->navigation) ): ?>
    <div class='tabs'>
      <?php echo $this->navigation()->menu()->setContainer($this->navigation)->render(); ?>
    </div>
  <?php endif; ?>
<?php } ?>
