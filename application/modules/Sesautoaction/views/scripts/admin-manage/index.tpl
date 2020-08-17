<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesautoaction
 * @package    Sesautoaction
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sesautoaction/views/scripts/dismiss_message.tpl';?>
<script type="text/javascript">
function multiDelete()
{
  return confirm("<?php echo $this->translate("Are you sure you want to delete the selected actions ?") ?>");
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
<h3><?php echo "Manage Auto Actions"; ?></h3>
<p>
	<?php echo $this->translate("This page lists all the auto actions content created by you. Here, you can also add and manage any number of auto actions content on your website.") ?>	
</p>
<br class="clear" />
<div class="sesautoaction_search_reasult">
	<?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesautoaction', 'controller' => 'manage', 'action' => 'create'), $this->translate("Create New Action"), array('class'=>'sesbasic_icon_add buttonlink')) ?>
</div>
<br />
<?php if( count($this->paginator) ): ?>
  <div class="sesautoaction_search_reasult">
    <?php echo $this->translate(array('%s action found.', '%s actions found', $this->paginator->getTotalItemCount()), $this->locale()->toNumber($this->paginator->getTotalItemCount())) ?>
  </div>
  <br />
  <form id='multidelete_form' method="post" action="<?php echo $this->url();?>" onSubmit="return multiDelete()">
  <table class='admin_table'>
    <thead>
      <tr>
        <th class='admin_table_short'><input onclick='selectAll();' type='checkbox' class='checkbox' /></th>
        <th class='admin_table_short'>ID</th>
        <th><?php echo $this->translate("Content Name") ?></th>
        <th><?php echo $this->translate("Resource Type") ?></th>
        <th align="center"><?php echo $this->translate("New Signup");?></th>
        <th align="center"><?php echo $this->translate("Status");?></th>
        <th><?php echo $this->translate("Options") ?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($this->paginator as $item): ?>
        <?php $resource = Engine_Api::_()->getItem($item->resource_type, $item->resource_id); ?>
        <tr>
          <td><input type='checkbox' class='checkbox' name='delete_<?php echo $item->action_id;?>' value='<?php echo $item->action_id ?>' /></td>
          <td><?php echo $item->action_id ?></td>
          <td><a href="<?php echo $resource->getHref(); ?>"><?php echo $resource->getTitle(); ?></a></td>
          <td><?php echo $item->resource_type; ?></td>
          
          <td class="admin_table_centered"><?php echo ( $item->newsignup ? $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesautoaction', 'controller' => 'manage', 'action' => 'newsignup', 'id' => $item->action_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesautoaction/externals/images/check.png', '', array('title' => $this->translate('Disable'))), array()) : $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesautoaction', 'controller' => 'manage', 'action' => 'newsignup', 'id' => $item->action_id), $this->htmlImage('application/modules/Sesautoaction/externals/images/error.png', '', array('title' => $this->translate('Enable')))) ) ?></td>
          
          <td class="admin_table_centered"><?php echo ( $item->enabled ? $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesautoaction', 'controller' => 'manage', 'action' => 'enabled', 'id' => $item->action_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesautoaction/externals/images/check.png', '', array('title' => $this->translate('Disable'))), array()) : $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesautoaction', 'controller' => 'manage', 'action' => 'enabled', 'id' => $item->action_id), $this->htmlImage('application/modules/Sesautoaction/externals/images/error.png', '', array('title' => $this->translate('Enable')))) ) ?></td>
          <td>
            <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesautoaction', 'controller' => 'manage', 'action' => 'edit', 'id' => $item->action_id, 'resource_type' => $item->resource_type), $this->translate("Edit")); ?>
            |
            <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesautoaction', 'controller' => 'manage', 'action' => 'delete', 'id' => $item->action_id), $this->translate("Delete"),array('class' => 'smoothbox')) ?>
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
      <?php echo $this->translate("There are no auto actions created by you yet.") ?>
    </span>
  </div>
<?php endif; ?>
