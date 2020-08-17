<?php ?>
<script type="text/javascript">
  function multiDelete()
  {
    return confirm("<?php echo $this->translate("Are you sure you want to delete the selected Taxes? It will not be recoverable after being deleted.") ?>");
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
      <?php if(empty($this->type)){ ?>
      	<h3><?php echo $this->translate("Manage Admin Configured Taxes") ?></h3>
      <p><?php echo $this->translate('This page lists all the taxes which are created and configured by you from here. These taxes will apply on all the products purchased from your website. The taxes can be applicable based on the billing or shipping location of buyers.'); ?></p>
      <?php }else{ ?>
      	<h3><?php echo $this->translate("Manage Sellers Configured Taxes") ?></h3>
      	<p><?php echo $this->translate('This page lists all the taxes which are created and configured by sellers on your website. These taxes will apply on per store basis. The taxes can be applicable based on the billing or shipping location of buyers.'); ?></p>
      <?php } ?>
      <br />
      <div class='admin_search estore_search_form'>
        <?php echo $this->search->render($this) ?>
      </div>
      <br />
      <?php if(!$this->type){ ?>
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'estore', 'controller' => 'taxes', 'action' => 'add-tax'), $this->translate("Add New Tax"), array('class' => 'smoothbox buttonlink sesbasic_icon_add')); ?>
      <?php } ?>
      <br /><br />
      <?php if (count($this->paginator)): ?>
        <form id='multidelete_form' method="post" action="<?php echo $this->url(); ?>" onSubmit="return multiDelete()">
          <table class='admin_table' style="width:100%;">
            <thead>
              <tr>
                <th class='admin_table_short'><input onclick='selectAll();' type='checkbox' class='checkbox' /></th>
                <th class=""><?php echo $this->translate("Tax Title"); ?></th>
                <?php if($this->type){ ?>
                <th class=""><?php  echo $this->translate("Store Name"); ?></th>
                <?php } ?>
                <th class="admin_table_centered"><?php echo $this->translate("Applicable Location"); ?></th>
                <th class="admin_table_centered"><?php echo $this->translate("Status") ?></th>
                <th><?php echo $this->translate("Options") ?></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($this->paginator as  $item): ?>
                <tr>
                  <td><input type='checkbox' class='checkbox' name='delete_<?php echo $item->getIdentity() ?>' value="<?php echo $item->getIdentity(); ?>" /></td>
                  <td class=""><?php echo $item->title; ?></td>
                  <?php if($this->type){ ?>
                  <td>
                  <?php
                    $store = Engine_Api::_()->getItem('stores',$item->store_id); ?>
                  <a href="<?php echo $store->getHref(); ?>"><?php echo $store->getTitle(); ?></a>
                  </td>
                  <?php } ?>
                  <td class='admin_table_bold admin-txt-normal admin_table_centered'>
                    <?php
                      echo !$item->type ? "Shipping Address" : "Billing Address";
                    ?>
                  </td>
                  <?php if (!empty($item->status)): ?>
                    <td align="center" class="admin_table_centered">
                      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'estore', 'controller' => 'taxes', 'action' => 'enable-tax', 'id' => $item->getIdentity()), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title' => $this->translate('Disable Tax')))) ?>
                    </td>
                  <?php else: ?>
                    <td align="center" class="admin_table_centered">
                      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'estore', 'controller' => 'taxes', 'action' => 'enable-tax', 'id' => $item->getIdentity()), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title' => $this->translate('Enable Tax')))) ?>
                    </td>
                  <?php endif; ?>
                  <td>
                    <?php
                      echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'estore', 'controller' => 'taxes', 'action' => 'manage-tax', 'id' => $item->getIdentity(),'type'=>$this->type), $this->translate("Manage States"));
                    ?>
                    |
                    <?php
                      echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'estore', 'controller' => 'taxes', 'action' => 'edit-tax', 'id' => $item->getIdentity()), $this->translate("Edit"),array('class'=>'smoothbox'));
                    ?>
                    |
                    <?php
                      echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'estore', 'controller' => 'taxes', 'action' => 'delete-tax', 'id' => $item->getIdentity()), $this->translate("Delete"),array('class'=>'smoothbox'));
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
            <?php if($this->type){ ?>
              <?php echo $this->translate("Currently no sellers have created tax yet.") ?>
            <?php } else { ?>
              <?php echo $this->translate("Currently there are no admin taxes yet.") ?>
            <?php } ?>
          </span>
        </div>
      <?php endif; ?>
    </div>
	</div>
</div>
