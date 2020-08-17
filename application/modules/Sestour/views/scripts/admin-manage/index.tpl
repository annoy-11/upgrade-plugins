<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sestour
 * @package    Sestour
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2017-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php include APPLICATION_PATH .  '/application/modules/Sestour/views/scripts/dismiss_message.tpl';?>
<script type="text/javascript">
function multiDelete()
{
  return confirm("<?php echo $this->translate("Are you sure you want to delete the selected tour ?") ?>");
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
<h3><?php echo "Manage Tour for Pages"; ?></h3>
<p>
	<?php echo $this->translate("Here you can create introduction tours for various pages of your site to highlight significant features. With tours created using this plugin your users can walk through your site’s important features without making any extra efforts.<br />This page lists all the introduction tours which you have created for the various pages. These tours can be easily edited / deleted / enabled / disabled. You can also automatically redirect users from 1 page to the other page in your tours.<br />By clicking on ‘Manage Tour Tips’ link you will be navigated to the Manage page of tour tips where you can add brief introduction with title and descriptions of Widgets/functionalities to give more clarity to your users.<br /><br />Note: After creating the tour, make sure to place the widget: “SES - Introduction Tour - Display Tour” widget on the associated widgetized page in the Layout Editor to display the tour.") ?>	
</p>
<br class="clear" />
<div class="sestour_search_reasult">
	<?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sestour', 'controller' => 'manage', 'action' => 'create-tour'), $this->translate("Create New Tour"), array('class'=>'smoothbox sestour_icon_add buttonlink')) ?>
</div>
<?php if( count($this->paginator) ): ?>
  <div class="sestour_search_reasult">
    <?php echo $this->translate(array('%s tour found.', '%s tours found.', $this->paginator->getTotalItemCount()), $this->locale()->toNumber($this->paginator->getTotalItemCount())) ?>
  </div>
  <form id='multidelete_form' method="post" action="<?php echo $this->url();?>" onSubmit="return multiDelete()">
  <table class='admin_table'>
    <thead>
      <tr>
        <th class='admin_table_short'><input onclick='selectAll();' type='checkbox' class='checkbox' /></th>
        <th class='admin_table_short'>ID</th>
        <th><?php echo $this->translate("Page Name") ?></th>
        <th align="center"><?php echo $this->translate("Status");?></th>
        <th><?php echo $this->translate("Options") ?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($this->paginator as $item): ?>
        <tr>
          <td><input type='checkbox' class='checkbox' name='delete_<?php echo $item->tour_id;?>' value='<?php echo $item->tour_id ?>' /></td>
          <td><?php echo $item->tour_id ?></td>
          <td><?php echo $item->title; ?></td>
          <td class="admin_table_centered"><?php echo ( $item->enabled ? $this->htmlLink(array('route' => 'admin_default', 'module' => 'sestour', 'controller' => 'manage', 'action' => 'enabled', 'id' => $item->tour_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title' => $this->translate('Disable'))), array()) : $this->htmlLink(array('route' => 'admin_default', 'module' => 'sestour', 'controller' => 'manage', 'action' => 'enabled', 'id' => $item->tour_id), $this->htmlImage('application/modules/Sesbasic/externals/images/icons/error.png', '', array('title' => $this->translate('Enable')))) ) ?></td>
          <td>
          	<?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sestour', 'controller' => 'manage', 'action' => 'manage-widgets', 'id' => $item->tour_id, 'page_id' => $item->page_id), $this->translate("Manage Tour Tips"), array()) ?>
            |
            <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sestour', 'controller' => 'manage', 'action' => 'create-tour', 'id' => $item->tour_id, 'page_id' => $item->page_id), $this->translate("Edit"), array('class' => 'smoothbox')) ?>
            |
            <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sestour', 'controller' => 'manage', 'action' => 'deletetour', 'id' => $item->tour_id), $this->translate("Delete"), array('class' => 'smoothbox')) ?>
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
      <?php echo $this->translate("There are no introduction tours on your website yet.") ?>
    </span>
  </div>
<?php endif; ?>