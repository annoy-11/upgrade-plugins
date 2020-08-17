<?php 
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: edit-column.tpl 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */ 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sespagebuilder/views/scripts/dismiss_message.tpl';?>
<?php
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jscolor/jscolor.js');
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js');
?>
<?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sespagebuilder', 'controller' => 'progressbars', 'action' => 'manage-progressbar','content_id' => $this->content_id), $this->translate("Back to Manage Progress Bar Values"), array('class'=>'sesbasic_icon_back buttonlink')) ?>
<br /><br />
<div class='clear sesbasic_admin_form sespagebuilder_tabs_content_form'>
  <div class='settings'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>