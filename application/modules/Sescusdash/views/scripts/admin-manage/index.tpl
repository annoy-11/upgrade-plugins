<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescusdash
 * @package    Sescusdash
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-11-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sescusdash/views/scripts/dismiss_message.tpl';?>
<script type="text/javascript">
function multiDelete()
{
  return confirm("<?php echo $this->translate("Are you sure you want to delete the selected dashboards ?") ?>");
}
function selectAll()
{
  var i;
  var multidelete_form = $('multidelete_form');
  var inputs = multidelete_form.elements;
  for (i = 1; i < inputs.length; i++) {
    if (!inputs[i].disabled) {
      inputs[i].checked = inputs[0].checked;
    }
  }
}
</script>
<h3><?php echo "Manage Dashboard"; ?></h3>
<p>
	<?php echo $this->translate("This page lists all the Dashboard created by you. Here, you can also add and manage any number of dashboard  on your website. You can place these dashboards anywhere on your website including the Landing Page and any other widgetized page of your choice.") ?>	
</p>
<br class="clear" />
<div class="sescusdash_search_reasult">
	<?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sescusdash', 'controller' => 'manage', 'action' => 'create'), $this->translate("Create New Dashboard "), array('class'=>'smoothbox sescusdash_icon_add buttonlink')) ?>
</div>
<?php if( count($this->paginator) ): ?>
  <div class="sescusdash_search_reasult">
    <?php echo $this->translate(array('%s dashboard found.', '%s dashboards found', $this->paginator->getTotalItemCount()), $this->locale()->toNumber($this->paginator->getTotalItemCount())) ?>
  </div>
  <form id='multidelete_form' method="post" action="<?php echo $this->url();?>" onSubmit="return multiDelete()">
  <table class='admin_table'>
    <thead>
      <tr>
        <th class='admin_table_short'><input onclick='selectAll();' type='checkbox' class='checkbox' /></th>
        <th class='admin_table_short'>ID</th>
        <th><?php echo $this->translate("Title") ?></th>
        <th><?php echo $this->translate("Creation Date") ?></th>
        <th align="center"><?php echo $this->translate("Status");?></th>
        <th><?php echo $this->translate("Options") ?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($this->paginator as $item): ?>
        <tr>
          <td><input type='checkbox' class='checkbox' name='delete_<?php echo $item->dashboard_id;?>' value='<?php echo $item->dashboard_id ?>' /></td>
          <td><?php echo $item->dashboard_id ?></td>
          <td><?php echo $item->dashboard_name; ?></td>
          <td><?php echo $item->creation_date; ?></td>          
          <td class="admin_table_centered"><?php echo ( $item->enabled ? $this->htmlLink(array('route' => 'admin_default', 'module' => 'sescusdash', 'controller' => 'manage', 'action' => 'enabled', 'id' => $item->dashboard_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sescusdash/externals/images/check.png', '', array('title' => $this->translate('Disable'))), array()) : $this->htmlLink(array('route' => 'admin_default', 'module' => 'sescusdash', 'controller' => 'manage', 'action' => 'enabled', 'id' => $item->dashboard_id), $this->htmlImage('application/modules/Sescusdash/externals/images/error.png', '', array('title' => $this->translate('Enable')))) ) ?></td>
          <td>
          	<?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sescusdash', 'controller' => 'manage', 'action' => 'dashboard-links', 'id' => $item->dashboard_id), $this->translate("Manage Links"), array()) ?>
            |
            <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sescusdash', 'controller' => 'manage', 'action' => 'create', 'id' => $item->dashboard_id), $this->translate("Edit"), array('class' => 'smoothbox')) ?>
            |
            <?php echo $this->htmlLink(
                array('route' => 'admin_default', 'module' => 'sescusdash', 'controller' => 'manage', 'action' => 'delete-dashboard', 'id' => $item->dashboard_id),
                $this->translate("Delete"),
                array('class' => 'smoothbox')) ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <br />

  <div class='buttons'>

    <button type='submit'><?php echo $this->translate("Delete Selected") ?></button>
  </div>
  </form>

  <br />

  <div>
    <?php echo $this->paginationControl($this->paginator); ?>
  </div>

<?php else: ?>
  <br />
  <div class="tip">
    <span>
      <?php echo $this->translate("There are no dashboards created by you yet.") ?>
    </span>
  </div>
<?php endif; ?>
