<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvancedheader
 * @package    Sesadvancedheader
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: custom_headers.tpl  2019-02-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<div class="sesadvancedheader_styling_buttons">
<?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesadvancedheader', 'controller' => 'admin-settings', 'action' => 'add-custom-header'), $this->translate("Add New Color Scheme"), array('class' => 'smoothbox header_button fa fa-plus', 'id' => 'custom_headers')); ?>
<?php //if($this->customheader_id): ?>
	<?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesadvancedheader', 'controller' => 'admin-settings', 'action' => 'add-custom-header'), $this->translate("Edit Color Scheme"), array('class' => 'seschangeHeaderName header_button fa fa-pencil', 'id' => 'edit_custom_headers')); ?>
	<?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesadvancedheader', 'controller' => 'settings', 'action' => 'delete-custom-header'), $this->translate("Delete Color Scheme"), array('class' => 'header_button fa fa-close', 'id' => 'delete_custom_headers')); ?>
	<a href="javascript:void(0);" class="header_button fa fa-close disabled" id="deletedisabled_custom_headers" style="display: none;"><?php echo $this->translate("Delete Color Scheme"); ?></a>
<?php //endif; ?>
</div>
