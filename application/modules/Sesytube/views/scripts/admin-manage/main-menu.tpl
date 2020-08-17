<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesytube
 * @package    Sesytube
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: main-menu.tpl  2019-02-01 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<h2>
  <?php echo $this->translate("YouTube Theme Plugin") ?>
</h2>

<?php if( count($this->navigation) ): ?>
  <div class='tabs'>
    <?php echo $this->navigation()->menu()->setContainer($this->navigation)->render();?>
  </div>
<?php endif; ?>

<div class='tabs'>
  <ul class="navigation">
    <li>
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesytube', 'controller' => 'manage'), $this->translate('Manage Mini Menu')) ?>
    </li>
    <li class="active">
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesytube', 'controller' => 'manage', 'action' => 'main-menu'), $this->translate('Manage Main Menu')) ?>
    </li>
    <li>
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesytube', 'controller' => 'manage', 'action' => 'footer-menu'), $this->translate('Manage Footer Menu')) ?>
    </li>
  </ul>
</div>

<table class='admin_table ytube_manangemenu_table'>
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
          <img class="ytube_manangemenu_icon" alt="" src="<?php echo $this->storage->get($item->file_id, '')->getPhotoUrl(); ?>" />
									<?php else:?>
              -
									<?php endif;?></td>
        <td>
          <?php echo $this->htmlLink(
                array('route' => 'default', 'module' => 'sesytube', 'controller' => 'admin-manage', 'action' => 'upload-icon', 'id' => $item->id,'type' => 'main'),
                $this->translate("Edit Icon"),
                array('class' => 'smoothbox')) ?>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
