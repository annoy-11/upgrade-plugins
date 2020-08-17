<?php
?>
<div class="sesfbstyle_styling_buttons">
<?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesfbstyle', 'controller' => 'admin-settings', 'action' => 'add-custom-theme'), $this->translate("Add New Custom Theme"), array('class' => 'smoothbox sesfbstyle_button fa fa-plus', 'id' => 'custom_themes')); ?>
<?php //if($this->customtheme_id): ?>
	<?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesfbstyle', 'controller' => 'admin-settings', 'action' => 'add-custom-theme', 'customtheme_id' => $this->customtheme_id), $this->translate("Edit Custom Theme Name"), array('class' => 'smoothbox sesfbstyle_button fa fa-pencil', 'id' => 'edit_custom_themes')); ?>
	<?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesfbstyle', 'controller' => 'admin-settings', 'action' => 'delete-custom-theme', 'customtheme_id' => $this->customtheme_id), $this->translate("Delete Custom Theme"), array('class' => 'smoothbox sesfbstyle_button fa fa-close', 'id' => 'delete_custom_themes')); ?>
	<a href="javascript:void(0);" class="sesfbstyle_button fa fa-close disabled" id="deletedisabled_custom_themes" style="display: none;"><?php echo $this->translate("Delete Custom Theme"); ?></a>
<?php //endif; ?>
</div>