<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinesspackage
 * @package    Sesbusinesspackage
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php $transaction = $this->transaction; 
$item = $this->business;
$package = $this->package;
$isrenew = $package->is_renew_link;
$renew_link_days = $package->renew_link_days;
?>
<div class="sesbusiness_package_details sesbasic_bxs">
  <?php if($package->isFree()){ ?>
    <div class="sesbasic_clearfix _paymnt_free"><span>Payment Status:</span> <span>FREE</span></div>
  <?php }else{ ?>
    <?php if($transaction){ ?>
    <?php if(!(strtotime($transaction->expiration_date) <= time())){ ?>
      <div class="sesbasic_clearfix _paymnt_status"><span>Payment Status:</span> <span><strong><?php echo ucwords($transaction->state); ?></strong></span></div>
      <div class="sesbasic_clearfix _paymnt_date"><span>Expired On: </span> <span><?php echo date("M d,Y g:i A", strtotime($transaction->expiration_date)); ?></span></div>
    <?php } ?>
    <?php if($package->isOneTime()){
      if($isrenew){
        if(!empty($transaction->expiration_date) && $transaction->expiration_date != '3000-00-00 00:00:00'){
          $datediff = strtotime($transaction->expiration_date) - time();
          $daysLeft =  floor($datediff/(60*60*24));
          if($daysLeft <= $renew_link_days || strtotime($transaction->expiration_date) <= time()){ ?>
          <div class="sesbasic_clearfix"><a href="<?php echo $this->url(array('business_id' => $item->business_id,'action'=>'index'), 'sesbusinesspackage_payment', true); ?>" class="sesbusiness_payment_btn sesbasic_animation"><i class="fa fa-paypal"></i><span><?php echo $this->translate("Reniew Business Payment"); ?></span></a></div>
         <?php 	
          }
        }else{ ?>
          <div class="sesbasic_clearfix _paymnt_status"><span>Payment Status:</span> <span><?php echo ucwords($transaction->state); ?></span></div>
       <?php
        }
      }
     ?>
    <?php } ?>
    <?php }else{  ?>
      <div>
        <a href="<?php echo $this->url(array('business_id' => $item->business_id,'action'=>'index'), 'sesbusinesspackage_payment', true); ?>" class="sesbusiness_payment_btn sesbasic_animation"><i class="fa fa-money"></i><span><?php echo $this->translate("Make Payment"); ?></span></a>
      </div>
    <?php } ?>
  <?php } ?>
</div>  