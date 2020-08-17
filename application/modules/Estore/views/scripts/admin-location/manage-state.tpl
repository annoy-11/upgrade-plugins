
<script type="text/javascript">

  function multiDelete()
  {
    return confirm("<?php echo $this->translate("Are you sure you want to delete the selected States?") ?>");
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
	<h3><?php echo $this->translate("%s - Manage States", $this->country); ?></h3>
</div>

<div class='admin_search sesbasic_search_form'>
  <?php echo $this->formFilter->render($this) ?>
</div>
<br />

<?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'estore', 'controller' => 'location', 'action' => 'index'), $this->translate("Back to Countries"), array('class' => 'sesbasic_icon_back buttonlink')); ?>
<?php 
echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'estore', 'controller' => 'location', 'action' => 'add-country', 'country_id' => $this->country_id), $this->translate("Add States"), array('class' => 'smoothbox buttonlink sesbasic_icon_add'));
?>

<br /><br />

<?php if (count($this->paginator)): ?>
  <form id='multidelete_form' method="post" action="<?php echo $this->url(); ?>" onSubmit="return multiDelete()">
    <table class='admin_table' style="width: 60%;">
      <thead>
        <tr>
          <th class='admin_table_short'><input onclick='selectAll();' type='checkbox' class='checkbox' /></th>
          <th class='admin_table_short' align="center"><?php echo $this->translate("ID"); ?></th>
          <th class=""><?php echo $this->translate("Country") ?></th>
          <th class=""><?php echo $this->translate("States") ?></th>
          <th align="center" class="admin_table_centered"><?php echo $this->translate("Status") ?></th>
          <th align="center" class="admin_table_centered"><?php echo $this->translate("Options") ?></th>
        </tr>
      </thead>
      
      <tbody>
        <?php foreach ($this->paginator as $item): ?>
          <tr>
            <td><input type='checkbox' class='checkbox' name='delete_<?php echo $item->getIdentity() ?>' value="<?php echo $item->getIdentity() ?>" /></td>
            <td align="center" class="admin_table_centered"><?php echo $item->getIdentity() ?></td>
            <td align="left" class=""><?php
              echo Engine_Api::_()->getItem('estore_country',$item->country_id)->name; ?>
            </td>
            <td align="left" class="">
              <?php echo  $item->name; ?>
            </td>
             <?php if (!empty($item->status)): ?>
                 <td align="center" class="admin_table_centered"><?php
                  echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'estore', 'controller' => 'location', 'action' => 'enable-state', 'id' => $item->getIdentity()), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title' => $this->translate('Disable State'))))
                ?></td>
              <?php else: ?>
                  <td align="center" class="admin_table_centered">
                  <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'estore', 'controller' => 'location', 'action' => 'enable-state', 'id' => $item->getIdentity()), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title' => $this->translate('Enable State'))))
          ?>
                  </td>
              <?php endif; ?>

            <td align="center" class="admin_table_centered">
              <?php
              echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'estore', 'controller' => 'location', 'action' => 'edit-state', 'id' => $item->getIdentity()), $this->translate("edit"), array('class' => 'smoothbox')) ; ?>
              |
              <?php
              echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'estore', 'controller' => 'location', 'action' => 'delete-state', 'id' => $item->getIdentity()), $this->translate("delete"), array('class' => 'smoothbox'))
              ?>
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

  <br/>
  <div>
  <?php echo $this->paginationControl($this->paginator); ?>
  </div>

<?php else: ?>
  <div class="tip">
    <span>
  <?php echo $this->translate("There are no states for this country.") ?>
    </span>
  </div>
<?php endif; ?>


