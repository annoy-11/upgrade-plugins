
<?php
if(!$this->is_ajax){
	echo $this->partial('dashboard/left-bar.tpl', 'sesgroup', array('group' => $this->group));?>
<div class="sesgroup_dashboard_content sesbm sesbasic_clearfix">
<?php } 
?>
<?php $defaultCurrency = Engine_Api::_()->egroupjoinfees()->defaultCurrency(); ?>
<div class="sesgroup_dashboard_content_header sesbasic_clearfix">	
  <h3><?php echo $this->translate("Make Payment Request"); ?></h3>
  <p>
    <?php echo $this->translate('Here you can see the Total Entries submitted in your group,Total Amount Received, Total Commission of site admin, and the Total Remaining Amount that you can request from the site admin to release. <br><br>
Note : You will be able to "Make Payment Request" only if the "Total Remaining Amount" is greater than or equal to "Threshold Amount."'); ?>
  </p>
    <?php if($this->thresholdAmount > 0){ ?>
    <div class="sesgroup_db_dashboard_threshold_amt"><?php echo $this->translate("Threshold Amount:"); ?> <b><?php echo Engine_Api::_()->egroupjoinfees()->getCurrencyPrice($this->thresholdAmount,$defaultCurrency); ?></b></div>
    <?php } ?>
</div>
<?php if(!count($this->userGateway)){ ?>
	<div class="tip">
  <span>    
    <?php echo $this->translate('You have not submitted your payment gateway details. %1$sClick Here%2$s to submit the details and proceed with the payment request.', '<a href="'.$this->url(array('group_id' => $this->group->custom_url,'action'=>'account-details'), 'sesgroup_dashboard', true).'">', '</a>'); ?>
  </span>
</div>
<?php } ?>
<?php $orderDetails = $this->orderDetails; ?>
<div class="sesgroup_db_sale_stats_container sesbasic_bxs sesbasic_clearfix sesgroup_db_sale_stats_t">
	<div class="sesgroup_db_sale_stats">
  	<section>
      <span><?php echo $this->translate("Total Orders"); ?></span>
      <span><?php echo $orderDetails['totalOrder'];?></span>
		</section>
  </div>
	<div class="sesgroup_db_sale_stats">
  	<section>
      <span><?php echo $this->translate("Total Amount"); ?></span>
      <span><?php echo Engine_Api::_()->egroupjoinfees()->getCurrencyPrice($orderDetails['totalAmountSale'],$defaultCurrency); ?></span>
  	</section>
  </div>
  <div class="sesgroup_db_sale_stats">
		<section>
      <span><?php echo $this->translate("Total Commission Amount"); ?></span>
      <span><?php echo Engine_Api::_()->egroupjoinfees()->getCurrencyPrice($orderDetails['commission_amount'],$defaultCurrency); ?></span>
		</section>
  </div>
  <div class="sesgroup_db_sale_stats">
		<section>
      <span><?php echo $this->translate("Total Remaining Amount"); ?></span>
      <span><?php echo Engine_Api::_()->egroupjoinfees()->getCurrencyPrice($this->remainingAmount,$defaultCurrency); ?></span>
		</section>
	</div>
</div>

<?php if($this->remainingAmount && $this->remainingAmount >= $this->thresholdAmount && count($this->userGateway) && !count($this->isAlreadyRequests)){ ?>
<div class="sesgroup_db_request_payment_link ">	
	<a href="<?php echo $this->url(array('group_id' => $this->group->custom_url,'action'=>'payment-request'), 'sesgroup_dashboard', true); ?>" class="openSmoothbox sesbasic_button"><i class=" fa fa-money"></i><span><?php echo $this->translate("Make Request For Payment"); ?></span></a>
</div>
<?php } ?>
<?php if( isset($this->paymentRequests) && count($this->paymentRequests) > 0): ?>
<div class="sesgroup_dashboard_table sesbasic_bxs">
  <form method="post" >
    <table>
      <thead>
        <tr>
          <th class="centerT"><?php echo $this->translate("Request Id"); ?></th>
           <th><?php echo $this->translate("Amount Requested") ?></th>
          <th><?php echo $this->translate("Requested Date") ?></th>
          <th><?php echo $this->translate("Release Amount") ?></th>
          <th><?php echo $this->translate("Release Date") ?></th>
          <th><?php echo $this->translate("Status") ?></th>
          <th><?php echo $this->translate("Options") ?></th>
        </tr>
      </thead>
      <tbody>
        <?php 
          foreach ($this->paymentRequests as $item): ?>
        <tr>
          <td class="centerT"><?php echo $item->userpayrequest_id; ?></td>
          <td class="centerT"><?php echo Engine_Api::_()->egroupjoinfees()->getCurrencyPrice($item->requested_amount,$defaultCurrency); ?></td>
          <td><?php echo Engine_Api::_()->sesbasic()->dateFormat($item->creation_date	); ?></td> 
          <td class="centerT"><?php echo $item->state != 'pending' ? Engine_Api::_()->egroupjoinfees()->getCurrencyPrice($item->release_amount	,$defaultCurrency) :  "-"; ?></td>
          <td><?php echo $item->release_date && (bool)strtotime($item->release_date) && $item->state != 'pending' ? Engine_Api::_()->egroupjoinfees()->dateFormat($item->release_date) :  '-'; ?></td> 
          <td><?php echo ucfirst($item->state); ?></td>
          <td class="table_options">
          	<?php if ($item->state == 'pending'){ ?>
                <?php echo $this->htmlLink($this->url(array('group_id' => $this->group->custom_url,'action'=>'payment-request','id'=>$item->userpayrequest_id), 'sesgroup_dashboard', true), $this->translate(""), array('class' => 'openSmoothbox fa fa-pencil','title'=>$this->translate("Edit Request"))); ?>
                <?php echo $this->htmlLink($this->url(array('action' => 'delete-payment', 'id' => $item->userpayrequest_id, 'group_id' => $this->group->custom_url), 'sesgroup_dashboard', true), $this->translate(""), array('class' => 'openSmoothbox fa fa-trash','title'=>$this->translate("Delete Request"))); ?>
            <?php } ?>
            		<?php echo $this->htmlLink($this->url(array('action' => 'detail-payment', 'id' => $item->userpayrequest_id, 'group_id' => $this->group->custom_url), 'sesgroup_dashboard', true), $this->translate(""), array('class' => 'openSmoothbox fa fa-eye','title'=>$this->translate("View Details"))); ?>
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
    <?php echo $this->translate("You do not have any pending payment request yet.") ?>
  </span>
</div>
<?php endif; ?>
</div>
</div>
</div>
