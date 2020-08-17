
<script type="text/javascript">
  function multiDelete()
  {
    return confirm("<?php echo $this->translate("Are you sure you want to delete the selected Taxes?") ?>");
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
<div class="sesbasic-form">
	<div>
    <div class="sesbasic-admin-sub-tabs">
      <ul class="navigation">
        <li class="<?php echo empty($this->type) ? 'active' : '' ?>">
          <a class="menu_estore_admin_main_taxes estore_admin_main_admintaxes" href="admin/estore/taxes/index/type/0">Admin Configured Taxes</a>
        </li>
        <li class="<?php echo !empty($this->type) ? 'active' : '' ?>">
          <a class="menu_estore_admin_main_taxes estore_admin_main_sellertaxes" href="admin/estore/taxes/index/type/1">Sellers Configured Taxes</a>
        </li>
      </ul>
    </div>
    <div class="clear sesbasic-form-cont">
      <h3><?php echo $this->translate("Manage Taxes") ?></h3>
      <p><?php echo $this->translate('This page lists all the taxes.'); ?></p>
      <br /><br />
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'estore', 'controller' => 'taxes', 'action' => 'index','type'=>$this->type), (empty($this->type) ? $this->translate("Back to Admin Configured Taxes") : $this->translate("Back to Seller Configured Taxes")), array('class' => ' buttonlink sesbasic_icon_back')); ?>
      
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'estore', 'controller' => 'taxes', 'action' => 'add-location','tax_id'=>$this->tax_id), $this->translate("Add Tax for Location"), array('class' => 'smoothbox buttonlink sesbasic_icon_add')); ?>
      <br /><br />
      <?php if (count($this->paginator)): ?>
        <form id='multidelete_form' method="post" action="<?php echo $this->url(); ?>" onSubmit="return multiDelete()">
          <table class='admin_table' style="width: 100%;">
            <thead>
              <tr>
                <th class='admin_table_short'><input onclick='selectAll();' type='checkbox' class='checkbox' /></th>
                <th class=""><?php echo $this->translate("Country"); ?></th>
                <th class=""><?php echo $this->translate("State"); ?></th>
                <th class="admin_table_centered"><?php echo $this->translate("Tax Rate"); ?></th>
                <th class="admin_table_centered"><?php echo $this->translate("Status") ?></th>
                <th><?php echo $this->translate("Creation Date"); ?></th>
                <th><?php echo $this->translate("Options") ?></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($this->paginator as  $item): ?>
                <tr>
                  <td><input type='checkbox' class='checkbox' name='delete_<?php echo $item->getIdentity() ?>' value="<?php echo $item->getIdentity(); ?>" /></td>
                  <td class=""><?php echo $item->country_id ? Engine_Api::_()->getItem('estore_country',$item->country_id)->name : "All Countries"; ?></td>
                  <td class=""><?php echo $item->state_id ? Engine_Api::_()->getItem('estore_state',$item->state_id)->name : "All States"; ?></td>
                  <td class='admin_table_bold admin-txt-normal admin_table_centered'>
                    <?php
                      echo $item->tax_type ? $item->value.'%' : Engine_Api::_()->estore()->getCurrencyPrice($item->value,Engine_Api::_()->estore()->getCurrentCurrency(),'');
                    ?>
                  </td>
                  <?php if (!empty($item->status)): ?>
                    <td align="center" class="admin_table_centered">
                      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'estore', 'controller' => 'taxes', 'action' => 'enable-location-tax', 'id' => $item->getIdentity()), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title' => $this->translate('Disable Tax')))) ?>
                    </td>
                  <?php else: ?>
                    <td align="center" class="admin_table_centered">
                      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'estore', 'controller' => 'taxes', 'action' => 'enable-location-tax', 'id' => $item->getIdentity()), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title' => $this->translate('Enable Tax')))) ?>
                    </td>
                  <?php endif; ?>
                  <td><?php echo $this->locale()->toDateTime($item->creation_date) ?></td>
                  <td>
                    <?php
                      echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'estore', 'controller' => 'taxes', 'action' => 'add-location', 'id' => $item->getIdentity()), $this->translate("Edit"),array('class'=>'smoothbox'));
                    ?>
                    |
                    <?php
                      echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'estore', 'controller' => 'taxes', 'action' => 'delete-location', 'id' => $item->getIdentity()), $this->translate("Delete"),array('class'=>'smoothbox'));
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
            <?php echo $this->translate("No tax created by you yet.") ?>
          </span>
        </div>
      <?php endif; ?>
    </div>
	</div>
</div>
