<?php ?>

<?php $transaction = $this->transaction;  ?>

<?php if($this->subject_id != $this->viewer_id): ?>
  <div class="user_subscribe_button">
    <?php if($transaction) { ?>
      <?php if(!(strtotime($transaction->expiration_date) <= time())){ ?>
        <div>Payment Status: <?php echo ucwords($transaction->state); ?></div>
        <div>Expired On: <?php echo date("M d,Y g:i A", strtotime($transaction->expiration_date)); ?></div>
      <?php } ?>
    <?php } else { ?>
    
    <?php	echo $this->htmlLink(array('route' => 'default', 'module' => 'sessubscribeuser', 'controller' => 'order', 'action' => 'process', 'package_id' => $this->package_id, 'user_id' => $this->subject_id, 'gateway_id' => 2), $this->translate("Click To Subscribe"), array('class' => 'sesbasic_link_btn')) ;	?>

    <?php } ?>
  </div>
<?php endif; ?>