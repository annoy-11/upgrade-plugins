
<?php
if(!$this->is_ajax){
	echo $this->partial('dashboard/left-bar.tpl', 'estore', array('store' => $this->store));?>
<div class="estore_dashboard_content sesbm sesbasic_clearfix">
<?php } 
?>
<?php $defaultCurrency = Engine_Api::_()->estore()->defaultCurrency(); ?>
<div class="estore_dashboard_content_header sesbasic_clearfix">	
  <h3><?php echo $this->translate("Payments Received"); ?></h3>
  <p><?php echo $this->translate('Here, you are viewing the details of payments received from the website.') ?></p>
</div>
<?php if( isset($this->paymentRequests) && count($this->paymentRequests) > 0): ?>
<div class="estore_dashboard_table sesbasic_bxs">
  <form method="post" >
    <table>
      <thead>
        <tr>
          <th><?php echo $this->translate("Requested Amount") ?></th>
          <th><?php echo $this->translate("Released Amount") ?></th>
          <th><?php echo $this->translate("Released Date") ?></th>
          <th><?php echo $this->translate("Response Message") ?></th>
          <th><?php echo $this->translate("Status") ?></th>
          <th><?php echo $this->translate("Options") ?></th>
        </tr>
      </thead>
      <tbody>
        <?php 
          foreach ($this->paymentRequests as $item): ?>
        <tr>
          <td class="centerT"><?php echo Engine_Api::_()->estore()->getCurrencyPrice($item->requested_amount,$defaultCurrency); ?></td>
          <td class="centerT"><?php echo Engine_Api::_()->estore()->getCurrencyPrice($item->release_amount	,$defaultCurrency); ?></td>
          <td><?php echo $item->release_date ? ($item->release_date) :  '-'; ?></td>
          <td class="centerT"><?php echo $this->string()->truncate(empty($item->admin_message	) ? '-' : $item->admin_message, 30) ?></td>
          <td><?php echo ucfirst($item->state); ?></td>
          <td class="table_options">
         		<?php echo $this->htmlLink($this->url(array('action' => 'detail-payment', 'id' => $item->userpayrequest_id, 'store_id' => $this->store->custom_url), 'estore_dashboard', true), $this->translate(""), array('title' => $this->translate("View Details"), 'class' => 'openSmoothbox fa fa-eye')); ?>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
   </form>
</div>
<?php else: ?>
<div class="tip">
  <span>
    <?php echo $this->translate("No transactions have been made yet.") ?>
  </span>
</div>
<?php endif; ?>
</div>
</div>
</div>