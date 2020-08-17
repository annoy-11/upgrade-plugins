<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesytube
 * @package    Sesytube
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-02-01 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php include APPLICATION_PATH .  '/application/modules/Sesytube/views/scripts/dismiss_message.tpl';?>
<div class='tabs'>
  <ul class="navigation">
    <li>
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesytube', 'controller' => 'manage', 'action' => 'header-settings'), $this->translate('Header Settings')) ?>
    </li>
    <li  class="active">
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesytube', 'controller' => 'manage', 'action' => 'index'), $this->translate('Main Menu Icons')) ?>
    </li>
    <li>
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesytube', 'controller' => 'manage', 'action' => 'mini-menu-icons'), $this->translate('Mini Menu icons')) ?>
    </li>
    <li>
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesytube', 'controller' => 'menu'), $this->translate('Mini Menu')) ?>
    </li>
  </ul>
</div>
<h3><?php echo "Manage Main Menu Icons"; ?></h3>
<p><?php echo "Here, you can add icons for the Main Navigation Menu Items of your website. You can also edit and delete the icons."; ?> </p>
<br />

<table class='admin_table ytube_manangemenu_table'>
  <thead>
    <tr>
      <th><?php echo $this->translate("Menu Item") ?></th>
      <th><?php echo $this->translate("Normal Icon") ?></th>
      <th><?php echo $this->translate("Active Icon") ?></th>
      <th><?php echo $this->translate("Options") ?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($this->paginator as $item): ?>
      <tr id="<?php echo $item->id; ?>">
        <td><?php echo $item->label ?></td>
        
        <?php $getRow = Engine_Api::_()->getDbTable('menusicons','sesbasic')->getRow($item->id); ?>
        
        <td>
        <?php if(($getRow)):
        $photo = $this->storage->get($getRow->icon_id, '');
        ?>
        <?php $label = 'Edit';?>
        <img class="ytube_manangemenu_icon" alt="" src="<?php echo $photo ? $photo->getPhotoUrl() : ""; ?>" />
        <?php else:?>
        <?php $label = 'Add';?>
        -
        <?php endif;?>
        </td>
        <td>
        <?php if(($getRow)):
        $photo = $this->storage->get($getRow->activeicon, '');
        ?>
        <?php $label = 'Edit';?>
        <img class="ytube_manangemenu_icon" alt="" src="<?php echo $photo ? $photo->getPhotoUrl() : ""; ?>" />
        <?php else:?>
        <?php $label = 'Add';?>
        -
        <?php endif;?>
        </td>
									
        <td>
        
          <?php echo $this->htmlLink(
                array('route' => 'default', 'module' => 'sesytube', 'controller' => 'admin-manage', 'action' => 'upload-icon', 'id' => $item->id,'type' => 'main'),
                $label,
                array('class' => 'smoothbox')) ?>
          <?php if(($getRow)):?>
          | 
          <?php echo $this->htmlLink(
            array('route' => 'default', 'module' => 'sesytube', 'controller' => 'admin-manage', 'action' => 'delete-menu-icon', 'id' => $item->id, 'file_id' => $getRow->icon_id),
            $this->translate("Delete"),
            array('class' => 'smoothbox')) ?>
          <?php endif;?>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
