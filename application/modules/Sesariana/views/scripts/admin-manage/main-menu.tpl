<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesariana
 * @package    Sesariana
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: main-menu.tpl 2016-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>

<h2>
  <?php echo $this->translate("Ariana Theme Plugin") ?>
</h2>

<?php if( count($this->navigation) ): ?>
  <div class='tabs'>
    <?php echo $this->navigation()->menu()->setContainer($this->navigation)->render();?>
  </div>
<?php endif; ?>

<div class='tabs'>
  <ul class="navigation">
    <li>
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesariana', 'controller' => 'manage'), $this->translate('Manage Mini Menu')) ?>
    </li>
    <li class="active">
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesariana', 'controller' => 'manage', 'action' => 'main-menu'), $this->translate('Manage Main Menu')) ?>
    </li>
    <li>
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesariana', 'controller' => 'manage', 'action' => 'footer-menu'), $this->translate('Manage Footer Menu')) ?>
    </li>
  </ul>
</div>

<table class='admin_table ariana_manangemenu_table'>
  <thead>
    <tr>
      <th><?php echo $this->translate("Label") ?></th>
      <th><?php echo $this->translate("Icon") ?></th>
      <th><?php echo $this->translate("Options") ?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($this->paginator as $item): ?>
      <tr>
        <td><?php echo $item->label ?></td>
        <td><?php if(!empty($item->file_id)):?>
          <img class="ariana_manangemenu_icon" alt="" src="<?php echo $this->storage->get($item->file_id, '')->getPhotoUrl(); ?>" />
									<?php else:?>
              -
									<?php endif;?></td>
        <td>
          <?php echo $this->htmlLink(
                array('route' => 'default', 'module' => 'sesariana', 'controller' => 'admin-manage', 'action' => 'upload-icon', 'id' => $item->id,'type' => 'main'),
                $this->translate("Edit Icon"),
                array('class' => 'smoothbox')) ?>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>