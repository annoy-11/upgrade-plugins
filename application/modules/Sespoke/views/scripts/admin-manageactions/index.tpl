<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespoke
 * @package    Sespoke
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2015-07-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>

<?php include APPLICATION_PATH .  '/application/modules/Sespoke/views/scripts/dismiss_message.tpl';?>
<h3 style="margin-bottom:6px;"><?php echo $this->translate("Manage Actions & Gifts"); ?></h3>
<p><?php echo $this->translate("Here, you can add and manage all actions & gifts created by you. You can also enable / disable any action or gift anytime."); ?></p>
<br style="clear:both;" />
<?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sespoke', 'controller' => 'manageactions', 'action' => 'add'), $this->translate("Add New Action or Gift"), array('class'=>'buttonlink sespoke_icon_add'));
?>
<br /><br />

<?php if(count($this->paginator)): ?>
<form id='multidelete_form'>
  <table class='admin_table' style="width:100%;">
    <thead>
      <tr>
        <th align="left">
          <?php echo $this->translate("Type"); ?>
        </th>
        <th align="left">
          <?php echo $this->translate("Name"); ?>
        </th>
        <th align="left">
          <?php echo $this->translate("Verb"); ?>
        </th>
        <th align="center">
          <?php echo $this->translate("Enabled"); ?>
        </th>
        <th align="center">
          <?php echo $this->translate("Enabled For Activity Feeds"); ?>
        </th>
        <th align="center">
          <?php echo $this->translate("Enabled For Profile Options"); ?>
        </th>
        <th align="left">
          <?php echo $this->translate("Options"); ?>
        </th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($this->paginator as $item): ?>
      <tr>
        <td><?php if( !empty($item->action) ){ echo ucfirst($item->action); }else { echo '-'; } ?></td>
        <td><?php if( !empty($item->name) ){ echo $item->name; }else { echo '-'; } ?></td>
        <td ><?php if( !empty($item->verb) ){ echo $item->verb; } else { echo '-'; } ?></td>
        <td class="admin_table_centered"><?php echo ( $item->enabled ? $this->htmlLink(array('route' => 'admin_default', 'module' => 'sespoke', 'controller' => 'manageactions', 'action' => 'enabled', 'manageaction_id' => $item->manageaction_id, 'param' => 'action'), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sespoke/externals/images/check.png', '', array('title' => $this->translate('Disable'))), array())  : $this->htmlLink(array('route' => 'admin_default', 'module' => 'sespoke', 'controller' => 'manageactions', 'action' => 'enabled', 'manageaction_id' => $item->manageaction_id, 'param' => 'action' ), $this->htmlImage('application/modules/Sespoke/externals/images/error.png', '', array('title' => $this->translate('Enable')))) ) ?></td >
       <td class="admin_table_centered"><?php echo ( $item->enable_activity ? $this->htmlLink(array('route' => 'admin_default', 'module' => 'sespoke', 'controller' => 'manageactions', 'action' => 'enabled', 'manageaction_id' => $item->manageaction_id, 'param' => 'activity'), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sespoke/externals/images/check.png', '', array('title' => $this->translate('Disable For Activity'))), array())  : $this->htmlLink(array('route' => 'admin_default', 'module' => 'sespoke', 'controller' => 'manageactions', 'action' => 'enabled', 'manageaction_id' => $item->manageaction_id, 'param' => 'activity'), $this->htmlImage('application/modules/Sespoke/externals/images/error.png', '', array('title' => $this->translate('Enable For Activity')))) ) ?></td>
      <td class="admin_table_centered"><?php echo ( $item->enabled_gutter ? $this->htmlLink(array('route' => 'admin_default', 'module' => 'sespoke', 'controller' => 'manageactions', 'action' => 'enabled', 'manageaction_id' => $item->manageaction_id, 'param' => 'gutter', 'enabled_gutter' => $item->enabled_gutter), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sespoke/externals/images/check.png', '', array('title' => $this->translate('Disable For Gutter Menu'))), array())  : $this->htmlLink(array('route' => 'admin_default', 'module' => 'sespoke', 'controller' => 'manageactions', 'action' => 'enabled', 'manageaction_id' => $item->manageaction_id, 'param' => 'gutter', 'enabled_gutter' => $item->enabled_gutter), $this->htmlImage('application/modules/Sespoke/externals/images/error.png', '', array('title' => $this->translate('Enable For Gutter Menu')))) ) ?></td>        
        <td>
          <?php	echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sespoke', 'controller' => 'manageactions', 'action' => 'edit', 'manageaction_id' => $item->manageaction_id), $this->translate("Edit")) ;	?>
          <?php if(empty($item->default)):?>
          | <a href="<?php echo $this->url(array('action' => 'delete', 'manageaction_id' => $item->manageaction_id)) ?>" class="smoothbox"><?php echo $this->translate("Delete") ?>
          </a>
          <?php endif; ?>
        </td>
      </tr>
      <?php  endforeach; ?>
    </tbody>
  </table>
</form>
<br />
<div>
  <?php echo $this->paginationControl($this->paginator); ?>
</div>
<?php else: ?>
<div class="tip">
  <span>
    <?php echo $this->translate("Currently, you have not created any action or gift.") ?>
  </span>
</div>
<?php endif; ?>