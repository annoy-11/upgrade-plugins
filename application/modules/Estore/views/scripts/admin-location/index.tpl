
<script type="text/javascript">

  function multiDelete()
  {
    return confirm("<?php echo $this->translate("Are you sure you want to delete the selected Countries? It will not be recoverable after being deleted.") ?>");
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

<?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/dismiss_message.tpl';?>
<div class='settings clr'>
	<h3><?php echo $this->translate("Manage Shipping Locations"); ?></h3>
	<p class="description"><?php echo $this->translate('This page lists all the shipping locations added by you. You can add and manage various countries and their states from below. Stores owners will be able to choose to sell their products to these locations only. Also, buyers will be able to make their purchases in these locations only. To new locations click on "Add Country" link below. You can also choose to enable or disable the locations. You can even manage their states.');?></p>
</div>

<div class='admin_search sesbasic_search_form'>
  <?php echo $this->formFilter->render($this) ?>
</div>
<br />

<?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'estore', 'controller' => 'location', 'action' => 'add-country'), $this->translate("Add Country"), array('class' => 'smoothbox buttonlink sesbasic_icon_add')); ?>
<?php // echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'estore', 'controller' => 'location', 'action' => 'import'), $this->translate("Import Locations"), array('class' => 'buttonlink estore_icon_import')); ?>

<br /><br />

<?php if (count($this->paginator)): ?>
  <form id='multidelete_form' method="post" action="<?php echo $this->url(); ?>" onSubmit="return multiDelete()">
    <table class='admin_table' style="width: 50%;">
      <thead>
        <tr>
          <th class='admin_table_short'><input onclick='selectAll();' type='checkbox' class='checkbox' /></th>
          <th class=""><?php echo $this->translate("Country"); ?></th>
          <th class="admin_table_centered"><?php echo $this->translate("States"); ?></th>
          <th class="admin_table_centered"><?php echo $this->translate("Status") ?></th>
          <th class="admin_table_centered"><?php echo $this->translate("Options") ?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($this->paginator as  $item): ?>
          <tr>
            <td><input type='checkbox' class='checkbox' name='delete_<?php echo $item->getIdentity() ?>' value="<?php echo $item->getIdentity(); ?>" /></td>
            <td class=""><?php echo $item->name; ?></td>
            <td class='admin_table_bold admin-txt-normal admin_table_centered'>
              <?php
                echo Engine_Api::_()->getDbtable('states', 'estore')->getCount($item->getIdentity());
              ?>
            </td>
            <?php if (!empty($item->status)): ?>
              <td align="center" class="admin_table_centered">
                <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'estore', 'controller' => 'location', 'action' => 'enable-country', 'id' => $item->getIdentity()), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title' => $this->translate('Disable Country')))) ?>
              </td>
            <?php else: ?>
              <td align="center" class="admin_table_centered">
                <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'estore', 'controller' => 'location', 'action' => 'enable-country', 'id' => $item->getIdentity()), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title' => $this->translate('Enable Country')))) ?>
              </td>
            <?php endif; ?>
            <td align="left" class="admin_table_centered">
              <?php
                echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'estore', 'controller' => 'location', 'action' => 'manage-state', 'id' => $item->getIdentity()), $this->translate("Manage States"));
              ?>

            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <br />
    <div class='buttons fleft clr mtop10'>
      <button type='submit'><?php echo $this->translate("Delete Selected") ?></button>
    </div>
  </form>

  <br />
  
  <div>
    <?php echo $this->paginationControl($this->paginator); ?>
  </div>
  
<?php else: ?>
  <div class="tip">
    <span>
      <?php echo $this->translate("No locations selected yet.") ?>
    </span>
  </div>
<?php endif; ?>
