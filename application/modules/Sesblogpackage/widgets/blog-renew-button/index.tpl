<?php $transaction = $this->transaction; 
			$item = $this->blog;
      $package = $this->package;
      $isrenew = $package->is_renew_link;
      $renew_link_days = $package->renew_link_days;
?>

<?php if($package->isFree()){ ?>
	<div>Payment Status: FREE</div>
<?php }else{ ?>
  <?php if($transaction){ ?>
  <?php if(!(strtotime($transaction->expiration_date) <= time())){ ?>
  <div>Payment Status: <?php echo ucwords($transaction->state); ?></div>
  <div>Expired On: <?php echo date("M d,Y g:i A", strtotime($transaction->expiration_date)); ?></div>
  <?php } ?>
  <?php if($package->isOneTime()){
  	if($isrenew){
    	if(!empty($transaction->expiration_date) && $transaction->expiration_date != '3000-00-00 00:00:00'){
      	$datediff = strtotime($transaction->expiration_date) - time();
			 	$daysLeft =  floor($datediff/(60*60*24));
        if($daysLeft <= $renew_link_days || strtotime($transaction->expiration_date) <= time()){ ?>
       	<a href="<?php echo $this->url(array('blog_id' => $item->blog_id,'action'=>'index'), 'sesblogpackage_payment', true); ?>" class="sesbasic_link_btn">		<?php echo $this->translate("Reniew Blog Payment"); ?></a>
       <?php 	
        }
      }else{ ?>
      <div>Payment Status: <?php echo ucwords($transaction->state); ?></div>
     <?php
      }
    }
   ?>
  <?php } ?>
  <?php }else{  ?>
  	<div>
    	<a href="<?php echo $this->url(array('blog_id' => $item->blog_id,'action'=>'index'), 'sesblogpackage_payment', true); ?>" class="sesbasic_link_btn">		<?php echo $this->translate("Make Payment"); ?></a>
    </div>
  <?php } ?>
<?php } ?>