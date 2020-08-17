<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: dismiss_message.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php $courses_adminmenu = Zend_Registry::isRegistered('courses_adminmenu') ? Zend_Registry::get('courses_adminmenu') : null; ?>
<h2><?php echo $this->translate("Courses - Learning Management System"); ?></h2>
<div class="sesbasic_nav_btns">
  <a href="<?php echo $this->url(array('module' => 'courses', 'controller' => 'settings', 'action' => 'support'),'admin_default',true); ?>" class="help-btn">Help & Support</a>
</div>
<?php include APPLICATION_PATH .  '/application/modules/Sesbasic/views/scripts/_mapKeyTip.tpl';?>

<?php if(!empty($courses_adminmenu)) { ?>
  <?php if( count($this->navigation) ): ?>
    <div class='sesbasic-admin-navgation'>
      <?php echo $this->navigation()->menu()->setContainer($this->navigation)->render(); ?>
    </div>
  <?php endif; ?>
  <?php if(!empty($this->subNavigation) && count($this->subNavigation) ): ?>
    <div class='sesbasic-admin-sub-tabs'>
      <?php echo $this->navigation()->menu()->setContainer($this->subNavigation)->render();?>
    </div>
  <?php endif; ?>
<?php } ?>
