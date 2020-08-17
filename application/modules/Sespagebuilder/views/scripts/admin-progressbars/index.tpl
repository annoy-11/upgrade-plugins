<?php 
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */ 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sespagebuilder/views/scripts/dismiss_message.tpl';?>
<h3>
  <?php echo $this->translate('Manage Progress Bars') ?>
</h3>
<p>
  <?php echo 'This page lists all the progress bars created by you using this plugin. You can create new progress bars by using “Create New Progress Bar” link.' ?>
</p>
<br />	
<div>
  <?php echo $this->htmlLink(array('action' => 'create', 'reset' => false), $this->translate("Create New Progress Bar"),array('class' => 'buttonlink sesbasic_icon_add')) ?>
</div>
<br />
<?php if( count($this->pages) > 0): ?>
<form id='multidelete_form' method="post" action="<?php echo $this->url();?>" >
  <table class='admin_table' style="width:60%;">
    <thead>
      <tr>
        <th>ID</th>
        <th><?php echo $this->translate("Progress Bar Name") ?></th>
        <th><?php echo $this->translate("Type") ?></th>
        <th><?php echo $this->translate("Options") ?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($this->pages as $item): ?>
      <tr>
        <td><?php echo $item->progressbar_id ?></td>
        <td><?php echo $item->title; ?></td>
         <td><?php echo ucfirst($item->type); ?></td>
        <td>
          <?php echo $this->htmlLink(array('route' => 'admin_default','module' => 'sespagebuilder', 'controller' => 'progressbars', 'action' => 'edit', 'id' => $item->progressbar_id ), $this->translate("Edit")) ?>
          |
          <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sespagebuilder', 'controller' => 'progressbars', 'action' => 'delete', 'id' => $item->progressbar_id ), $this->translate("Delete"), array('class' => 'smoothbox')) ?>
          |
          <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sespagebuilder', 'controller' => 'progressbars', 'action' => 'manage-progressbar', 'content_id' => $item->progressbar_id ), $this->translate("Manage Progress Bar Values")) ?>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</form>
<?php else: ?>
<div class="tip">
  <span>
    <?php echo $this->translate("You have not created any Progress Bar yet.") ?>
  </span>
</div>
<?php endif; ?>
