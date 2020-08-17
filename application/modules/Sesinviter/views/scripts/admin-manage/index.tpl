<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesinviter
 * @package    Sesinviter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2015-06-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php include APPLICATION_PATH .  '/application/modules/Sesinviter/views/scripts/dismiss_message.tpl';?>
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


<h3><?php echo $this->translate("Manage Invites") ?></h3>
<p>This page lists all of the invites your users have sent to their friends. You can use this page to monitor these invites entry and delete offensive material if necessary. Entering criteria into the filter fields will help you find specific invitation. Leaving the filter fields blank will show all the invitation entry on your social network.<br /><br />
<br />
<?php
$settings = Engine_Api::_()->getApi('settings', 'core');?>	
<div class='admin_search sesbasic_search_form'>
  <?php echo $this->formFilter->render($this) ?>
</div>
<br />
<?php $counter = $this->paginator->getTotalItemCount(); ?> 
<?php if( count($this->paginator) ): ?>
  <div class="sesbasic_search_reasult">
    <?php echo $this->translate(array('%s invite found.', '%s invites found.', $counter), $this->locale()->toNumber($counter)) ?>
  </div>
<form id="multidelete_form" action="<?php echo $this->url();?>" onSubmit="return multiDelete()" method="POST">
  <table class='admin_table'>
    <thead>
      <tr>
        <th class='admin_table_short'><input onclick="selectAll()" type='checkbox' class='checkbox' /></th>
        <th class='admin_table_short'>ID</th>
        <th><?php echo $this->translate('Sender Email') ?></th>
        <th align="center"><?php echo $this->translate('Sender Name') ?></th>
        <th align="center"><?php echo $this->translate('Recipent Name') ?></th>
        <th><?php echo $this->translate('Recipent Email') ?></th>
        <th><?php echo $this->translate('Invite Type') ?></th>
        <th><?php echo $this->translate('Options') ?></th>
      </tr>
    </thead>
    <tbody>
        <?php foreach ($this->paginator as $item): ?>
          <tr>
            <td><input type='checkbox' class='checkbox' name='delete_<?php echo $item->invite_id;?>' value="<?php echo $item->invite_id ?>"/></td>
            <td><?php echo $item->invite_id ?></td>
            <?php $sender = Engine_Api::_()->getItem('user', $item->sender_id); ?>
            <td><?php echo $sender->email; ?></td> 
            <td class="admin_table_centered"><?php echo $this->htmlLink($sender->getHref(), $sender->getTitle()); ?></td>
            <?php if($item->new_user_id) { ?>
              <?php $recipentsender = Engine_Api::_()->getItem('user', $item->new_user_id); ?>
              <td><?php echo $this->htmlLink($recipentsender->getHref(), $recipentsender->getTitle()); ?></td>
            <?php } else { ?>
              <td class="admin_table_centered"><?php echo "---"; ?></td>
            <?php } ?>
            <td><?php echo $item->recipient_email; ?></td>
            <td><?php echo ucwords($item->import_method) ?></td>
            <td>
              <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesinviter', 'controller' => 'admin-manage', 'action' => 'delete', 'id' => $item->invite_id), $this->translate("Delete"), array('class' => 'smoothbox')) ?>
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
      <?php echo $this->translate("There are no invitations yet.") ?>
    </span>
  </div>
<?php endif; ?>
