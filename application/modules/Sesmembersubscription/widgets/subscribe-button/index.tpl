<?php ?>

<?php $transaction = $this->transaction;  ?>
<div class="sesmembersubscription_subscribe_option">
  <?php if($this->viewer_id && $this->subject_id != $this->viewer_id): ?>
    <?php if($transaction) { ?>
      <?php if(!(strtotime($transaction->expiration_date) <= time())){ ?>
        <span class="sesmembersubscription_subscribe_payment_info">
          <span><?php echo $this->translate("Payment Status:"); ?></span>
          <span><b><?php echo ucwords($transaction->state); ?></b></span>
        </span>
        <span class="sesmembersubscription_subscribe_payment_info">
          <span><?php echo $this->translate("Renew On: "); ?></span>
          <span><b><?php echo date("M d,Y g:i A", strtotime($transaction->expiration_date)); ?></b></span>
        </span>
        <?php 
        // Try to cancel recurring payments in the gateway
        if( !empty($transaction->gateway_id) && !empty($transaction->gateway_profile_id) && empty($transaction->gateway_transaction_id) ) { ?>
        	<div class="sesmembersubscription_subscribe_button">
          	<?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sespaymentapi', 'controller' => 'index', 'action' => 'cancel-profile', 'transaction_id' => $transaction->getIdentity()), $this->translate("Cancel Subscription"), array('class' => 'smoothbox sesmembersubscription_button'));	?>
          </div>
        <?php } ?>
      <?php } ?>
    <?php } else { ?>
      <div class="sesmembersubscription_subscribe_button">
        <span class="sesmembersubscription_subscribe_payment_txt"><?php echo  $this->package->getPackageDescription(array('type' => 'user')); ?></span>
        <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesmembersubscription', 'controller' => 'order', 'action' => 'process', 'package_id' => $this->package_id, 'user_id' => $this->subject_id, 'gateway_id' => 2), $this->translate("Subscribe to This Profile"), array('class' => 'sesmembersubscription_button')) ;	?>
      </div>
    <?php } ?>
  <?php elseif(empty($this->viewer_id)): ?>
    <div class="sesmembersubscription_subscribe_button">
      <span class="sesmembersubscription_subscribe_payment_txt"><?php echo  $this->package->getPackageDescription(array('type' => 'user')); ?></span>
      <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesmembersubscription', 'controller' => 'order', 'action' => 'process', 'package_id' => $this->package_id, 'user_id' => $this->subject_id, 'gateway_id' => 2), $this->translate("Subscribe to This Profile"), array('class' => 'sesmembersubscription_button')) ;	?>
    </div>
  <?php endif; ?>
</div>  