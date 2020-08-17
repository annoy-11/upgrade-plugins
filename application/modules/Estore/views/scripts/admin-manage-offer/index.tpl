
<?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/dismiss_message.tpl';?>
<script type="text/javascript">
function multiDelete()
{
  return confirm("<?php echo $this->translate("Are you sure you want to delete the selected offers ?") ?>");
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
<h3><?php echo "Manage Custom Offers"; ?></h3>
<p>
	<?php echo $this->translate("This page lists all the custom Offers created by you. Here, you can also add and manage any number of offers on your website. You can place these offers anywhere on your website including the Landing Page and any other widgetized page of your choice.<br />You can add and manage any number of Offer Blocks in each custom offer. Each block is highly configurable and you can add title, description and additional button to each offer. Use 'Create New Custom Offer' link below to create new offer.<br />These Custom Offers will display in the 'Stores Marketplace - Custom Offers' widget from the Layout Editor on the pages of your choice.") ?>	
</p>
<br class="clear" />
<div class="estore_search_reasult">
	<?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'estore', 'controller' => 'manage-offer', 'action' => 'create-offer'), $this->translate("Create New Custom Offer"), array('class'=>'smoothbox estore_icon_add buttonlink')) ?>
</div>
<?php if( count($this->paginator) ): ?>
  <div class="estore_search_reasult">
    <?php echo $this->translate(array('%s offer found.', '%s offers found', $this->paginator->getTotalItemCount()), $this->locale()->toNumber($this->paginator->getTotalItemCount())) ?>
  </div>
  <form id='multidelete_form' method="post" action="<?php echo $this->url();?>" onSubmit="return multiDelete()">
  <table class='admin_table'>
    <thead>
      <tr>
        <th class='admin_table_short'><input onclick='selectAll();' type='checkbox' class='checkbox' /></th>
        <th class='admin_table_short'>ID</th>
        <th><?php echo $this->translate("Title") ?></th>
        <th align="center"><?php echo $this->translate("Number of Blocks") ?></th>
        <th><?php echo $this->translate("Creation Date") ?></th>
        <th><?php echo $this->translate("Offer Start Date") ?></th>
        <th><?php echo $this->translate("Offer End Date") ?></th>
        <th align="center"><?php echo $this->translate("Status");?></th>
        <th><?php echo $this->translate("Options") ?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($this->paginator as $item): ?>
        <tr>
          <td><input type='checkbox' class='checkbox' name='delete_<?php echo $item->offer_id;?>' value='<?php echo $item->offer_id ?>' /></td>
          <td><?php echo $item->offer_id ?></td>
          <td><?php echo $item->offer_name; ?></td>
          <?php $photos = Engine_Api::_()->getDbtable('slides', 'estore')->getSlides($item->offer_id, 'show_all'); ?>
          <td class="admin_table_centered"><?php echo $photos->getTotalItemCount(); ?></td>
          <td><?php echo $item->creation_date; ?></td>     
          <td>
            <?php if($item->offer_startdate) { ?>
            <?php echo $item->offer_startdate; ?>
            <?php } else { ?> --
             <?php } ?>
          </td>
          <td>
            <?php if($item->offer_enddate) { ?>
            <?php echo $item->offer_enddate; ?>
            <?php } else { ?> --
             <?php } ?>
          </td>
          <td class="admin_table_centered"><?php echo ( $item->enabled ? $this->htmlLink(array('route' => 'admin_default', 'module' => 'estore', 'controller' => 'manage-offer', 'action' => 'enabled', 'id' => $item->offer_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title' => $this->translate('Disable'))), array()) : $this->htmlLink(array('route' => 'admin_default', 'module' => 'estore', 'controller' => 'manage-offer', 'action' => 'enabled', 'id' => $item->offer_id), $this->htmlImage('application/modules/Sesbasic/externals/images/icons/error.png', '', array('title' => $this->translate('Enable')))) ) ?></td>
          <td>
          	<?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'estore', 'controller' => 'manage-offer', 'action' => 'manage', 'id' => $item->offer_id), $this->translate("Manage Blocks"), array()) ?>
            |
            <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'estore', 'controller' => 'manage-offer', 'action' => 'create-offer', 'id' => $item->offer_id), $this->translate("Edit"), array('class' => 'smoothbox')) ?>
            |
            <?php echo $this->htmlLink(
                array('route' => 'admin_default', 'module' => 'estore', 'controller' => 'manage-offer', 'action' => 'delete-offer', 'id' => $item->offer_id),
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
      <?php echo $this->translate("There are no custom offers created by you yet.") ?>
    </span>
  </div>
<?php endif; ?>
