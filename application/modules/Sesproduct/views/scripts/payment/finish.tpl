<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: finish.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesproduct/externals/styles/styles.css');?>
<div class="layout_middle sesbasic_bxs">
	<div class="generic_layout_container layout_core_content">
  	<?php if(empty($this->error)){ ?>
    	<div class="sesproduct_order_message_box sesproduct_order_success_box">
      	<i class="fa fa-check"></i>
        <div class="_cont">
          <h2><?php echo $this->translate("Thank you for shopping! Your order has been successfully placed."); ?></h2>
          <p class="_msg">
            <?php $orderids = ""; ?>
            <?php foreach($this->orders as $order){
                  $orderids .= '<a href="'.$this->url(array('action'=>'my-order','order_id'=>$order->getIdentity()),'estore_account',true).'">#'.$order->getIdentity().'</a> and ';
            } ?>
             <?php if($order->state != "complete"){
                echo $this->translate("Your order has been sent for the confirmation and after that you will receive the invoice of your order.");
             }else{
                echo $this->translate("You will soon receive your order confirmation with invoice.");
            	}
              if($this->viewer()->getIdentity()){
                  echo "<br>".$this->translate("Your Order Id is %s",trim($orderids,' and '));
              }
            ?>
          </p>
          <div class="_btns">
            <a href="<?php echo $this->url(array('action'=>"browse"),'sesproduct_general',true); ?>" class="sesbasic_link_btn">Continue Shopping</a>
            <?php if($this->viewer()->getIdentity()){ ?>
              <a href="<?php echo $this->url(array('action'=>"my-order"),'estore_account',true); ?>" class="sesbasic_link_btn">Go To My Order</a>
            <?php } ?>
          </div>
        </div>
    	</div>
    <?php }else{ ?>
    	<div class="sesproduct_order_message_box sesproduct_order_error_box">
      	<i class="fa fa-exclamation-triangle"></i>
        <div class="_cont">
          <h2><?php echo $this->translate("Error Occured"); ?></h2>
          <p class="sesproduct_order_error_msg _msg"><?php echo $this->error; ?></p>
        </div>
      </div>
    <?php } ?>
	</div>
</div>