<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagethm
 * @package    Sespagethm
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>

<?php include APPLICATION_PATH .  '/application/modules/Sespagethm/views/scripts/dismiss_message.tpl';?>


<div class='tabs'>
  <ul class="navigation">
    <li>
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sespagethm', 'controller' => 'manage', 'action' => 'header-template'), $this->translate('Header Settings')) ?>
    </li>
    <li>
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sespagethm', 'controller' => 'settings', 'action' => 'manage-search'), $this->translate('Manage Modules for Search')) ?>
    </li>
    <li class="active">
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sespagethm', 'controller' => 'manage', 'action' => 'index'), $this->translate('Main Menu Icons')) ?>
    </li>
  </ul>
</div>

<h3><?php echo "Manage Menu Icons"; ?></h3>
<p><?php echo "Here, you can manage & add icons for the Main Navigation Menu Items on your website. You can also edit and delete the icons."; ?> </p>
<br />
<table class='admin_table' style="width:50%;">
  <thead>
    <tr>
      <th><?php echo $this->translate("Menu Name") ?></th>
      <th><?php echo $this->translate("Icon") ?></th>
      <th><?php echo $this->translate("Options") ?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($this->paginator as $result):  ?>
      <tr>
        <td><?php echo $result->label ?></td>
        <?php $getRow = Engine_Api::_()->getDbTable('menusicons','sesbasic')->getRow($result->id); ?>
        <td>
					<?php if(($getRow)): ?>
          <?php $photo = $this->storage->get($getRow->icon_id, ''); ?>
          <?php $label = 'Edit';?>
          <img class="" alt="" src="<?php echo $photo ? $photo->getPhotoUrl() : ""; ?>" />
					<?php else:?>
          <?php $label = 'Add';?> - <?php endif;?>
			  </td>
        <td>
          <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sespagethm', 'controller' => 'admin-manage', 'action' => 'upload-icon', 'id' => $result->id,'type' => 'main'), $label, array('class' => 'smoothbox')) ?>
          <?php if($getRow):?>
          | 
          <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sespagethm', 'controller' => 'admin-manage', 'action' => 'delete-menu-icon', 'file_id' => $result->file_id, 'id' => $result->id), $this->translate("Delete"),             array('class' => 'smoothbox')) ?>
          <?php endif;?>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
