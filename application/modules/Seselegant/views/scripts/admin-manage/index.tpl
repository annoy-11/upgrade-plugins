<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Seselegant
 * @package    Seselegant
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-04-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>

<?php include APPLICATION_PATH .  '/application/modules/Seselegant/views/scripts/dismiss_message.tpl';?>

<h3><?php echo "Manage Menu Icons"; ?></h3>
<p><?php echo "Here, you can add icons for the Main Navigation Menu Items and Footer Menu Items on your website. You can also edit and delete the icons."; ?> </p>
<br />

<table class='admin_table elegant_manangemenu_table'>
  <thead>
    <tr>
      <th><?php echo $this->translate("Menu Item") ?></th>
      <th><?php echo $this->translate("Icon") ?></th>
      <th><?php echo $this->translate("Options") ?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($this->paginator as $item): ?>
      <tr>
        <td><?php echo $item->label ?></td>
        <?php $getRow = Engine_Api::_()->getDbTable('menusicons','sesbasic')->getRow($item->id); ?>

        <td><?php if(($getRow)):
          $photo = $this->storage->get($getRow->icon_id, '');
        ?>
          <?php $label = 'Edit';?>
          <img class="elegant_manangemenu_icon" alt="" src="<?php echo $photo ? $photo->getPhotoUrl() : ""; ?>" />
									<?php else:?>
          <?php $label = 'Add';?>
              -
									<?php endif;?></td>
									
									
        <td>
          <?php echo $this->htmlLink(
                array('route' => 'default', 'module' => 'seselegant', 'controller' => 'admin-manage', 'action' => 'upload-icon', 'id' => $item->id,'type' => 'main'),
                $label,
                array('class' => 'smoothbox')) ?>
                
          <?php if(($getRow)):?>
          | 
          <?php echo $this->htmlLink(
            array('route' => 'default', 'module' => 'seselegant', 'controller' => 'admin-manage', 'action' => 'delete-menu-icon', 'id' => $item->id, 'file_id' => $getRow->icon_id),
            $this->translate("Delete"),
            array('class' => 'smoothbox')) ?>
          <?php endif;?>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
