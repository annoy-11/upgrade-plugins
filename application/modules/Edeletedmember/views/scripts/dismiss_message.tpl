<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Edeletedmember
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: dismiss_message.tpl 2019-11-04 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

?>

<h2><?php echo $this->translate("Deleted Members Plugin") ?></h2>
<div class="sesbasic_nav_btns">,
  <a href="<?php echo $this->url(array('module' => 'edeletedmember', 'controller' => 'settings', 'action' => 'help'),'admin_default',true); ?>" class="help-btn">Help Center</a>
</div>

<?php $edeletedmember_adminmenu = Zend_Registry::isRegistered('edeletedmember_adminmenu') ? Zend_Registry::get('edeletedmember_adminmenu') : null; ?>

<?php if(!empty($edeletedmember_adminmenu)) { ?>
  <?php if( count($this->navigation) ):?>
    <div class='sesbasic-admin-navgation'>
      <?php echo $this->navigation()->menu()->setContainer($this->navigation)->render(); ?>
    </div>
  <?php endif; ?>
<?php } ?>
