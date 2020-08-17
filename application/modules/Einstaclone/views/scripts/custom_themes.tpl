<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Einstaclone
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: custom_themes.tpl 2019-12-30 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<div class="einstaclone_styling_buttons">
  <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'einstaclone', 'controller' => 'settings', 'action' => 'add-custom-theme'), $this->translate("Add New Custom Theme"), array('class' => 'smoothbox einstaclone_button add_new_theme fa fa-plus', 'id' => 'custom_themes')); ?>
  <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'einstaclone', 'controller' => 'settings', 'action' => 'add-custom-theme', 'customtheme_id' => $this->customtheme_id), $this->translate("Edit Custom Theme Name"), array('class' => 'smoothbox einstaclone_button fa fa-edit', 'id' => 'edit_custom_themes')); ?>
  <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'einstaclone', 'controller' => 'settings', 'action' => 'delete-custom-theme', 'customtheme_id' => $this->customtheme_id), $this->translate("Delete Custom Theme"), array('class' => 'smoothbox einstaclone_button fa fa-times', 'id' => 'delete_custom_themes')); ?>
</div>
