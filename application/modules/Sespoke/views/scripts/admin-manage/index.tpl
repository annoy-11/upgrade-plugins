<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespoke
 * @package    Sespoke
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2015-06-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php include APPLICATION_PATH .  '/application/modules/Sespoke/views/scripts/dismiss_message.tpl';?>
<script type="text/javascript">
function multiDelete()
{
  return confirm("<?php echo $this->translate('Are you sure you want to delete the selected entries?');?>");
}
function selectAll()
{
  var i;
  var multidelete_form = $('multidelete_form');
  var inputs = multidelete_form.elements;
  for (i = 1; i < inputs.length - 1; i++) {
    inputs[i].checked = inputs[0].checked;
  }
}
</script>
<h3><?php echo $this->translate("Manage Actions & Gifts") ?></h3>
<p>Here, you can manage all the action & gifts your users have send to each other.<br /><br />
<?php
$settings = Engine_Api::_()->getApi('settings', 'core');?>	
<?php $counter = $this->paginator->getTotalItemCount(); ?> 
<?php if( count($this->paginator) ): ?>
  <div class="sespoke_search_reasult">
    <?php echo $this->translate(array('%s entry found.', '%s entries found.', $counter), $this->locale()->toNumber($counter)) ?>
  </div>
<form id="multidelete_form" action="<?php echo $this->url();?>" onSubmit="return multiDelete()" method="POST">
  <table class='admin_table'>
    <thead>
      <tr>
        <th class='admin_table_short'><input onclick="selectAll()" type='checkbox' class='checkbox' /></th>
        <th class='admin_table_short'>ID</th>
        <th align="center"><?php echo $this->translate('Action') ?></th>
        <th align="center"><?php echo $this->translate('Action / Gift Name') ?></th>
        <th><?php echo $this->translate('Sender Name') ?></th>
        <th><?php echo $this->translate('Reciever Name') ?></th>        
        <th><?php echo $this->translate('Option') ?></th>
      </tr>
    </thead>
    <tbody>
        <?php foreach ($this->paginator as $item): ?>
         <?php $sender = Engine_Api::_()->getItem('user', $item->poster_id); ?>
         <?php $reciever = Engine_Api::_()->getItem('user', $item->receiver_id); ?>
         <?php $manageaction = Engine_Api::_()->getItem('sespoke_manageaction', $item->manageaction_id); ?>
          <tr>
            <td><input type='checkbox' class='checkbox' name='delete_<?php echo $item->poke_id;?>' value="<?php echo $item->poke_id ?>"/></td>
            <td><?php echo $item->getIdentity() ?></td>
            
            <td class="admin_table_centered"><?php echo ucfirst($manageaction->action); ?></td>
            <td class="admin_table_centered"><?php echo ucfirst($manageaction->name); ?></td>
            <td><?php echo $this->htmlLink($sender->getHref(), $sender->getTitle()); ?></td> 
            <td><?php echo $this->htmlLink($reciever->getHref(), $reciever->getOwner()); ?></td>
            <td>
              <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sespoke', 'controller' => 'admin-manage', 'action' => 'delete', 'id' => $item->poke_id), $this->translate("Delete"), array('class' => 'smoothbox')) ?>
            </td>
          </tr>
        <?php endforeach; ?>
    </tbody>
  </table>
  <br/>
  <div class='buttons'>
    <button type='submit'>
      <?php echo $this->translate('Delete Selected') ?>
    </button>
  </div>
</form>
<br />
<div>
  <?php echo $this->paginationControl($this->paginator); ?>
</div>
<?php else: ?>
  <div class="tip">
    <span>
      <?php echo $this->translate("There are no entries yet.") ?>
    </span>
  </div>
<?php endif; ?>