<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessocialtube
 * @package    Sessocialtube
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>

<?php include APPLICATION_PATH .  '/application/modules/Sessocialtube/views/scripts/dismiss_message.tpl';?>


<div class='tabs'>
  <ul class="navigation">
    <li>
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sessocialtube', 'controller' => 'manage', 'action' => 'header-template'), $this->translate('Header Settings')) ?>
    </li>
    <li>
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sessocialtube', 'controller' => 'settings', 'action' => 'manage-search'), $this->translate('Manage Modules for Search')) ?>
    </li>
    <li class="active">
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sessocialtube', 'controller' => 'manage', 'action' => 'index'), $this->translate('Main Menu Icons')) ?>
    </li>
    <li>
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sessocialtube', 'controller' => 'manage', 'action' => 'manage-photos'), $this->translate('Header Background Images')) ?>
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
        <td>
					<?php if(!empty($result->file_id)):?>
						<?php $label = 'Edit';?>
						<img class="" alt="" src="<?php echo $this->storage->get($result->file_id, '')->getPhotoUrl(); ?>" />
					<?php else:?>
						<?php $label = 'Add';?>
						-
					<?php endif;?>
				</td>
        <td>
          <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sessocialtube', 'controller' => 'admin-manage', 'action' => 'upload-icon', 'id' => $result->id,'type' => 'main'), $label, array('class' => 'smoothbox')) ?>
          <?php if(!empty($result->file_id)):?>
          | 
          <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sessocialtube', 'controller' => 'admin-manage', 'action' => 'delete-menu-icon', 'file_id' => $result->file_id, 'id' => $result->id), $this->translate("Delete"),             array('class' => 'smoothbox')) ?>
          <?php endif;?>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>