<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: finish.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Courses/externals/styles/styles.css');?>
<div class="layout_middle sesbasic_bxs">
	<div class="generic_layout_container layout_core_content">
  	<?php if(empty($this->error)){ ?>
    	<div class="courses_order_message_box courses_order_success_box">
      	<i class="fa fa-check"></i>
        <div class="_cont">
          <h2><?php echo $this->translate("Thank you for shopping! Your order has been successfully placed."); ?></h2>
          <p class="_msg">
            <?php $orderid = ""; ?>
            <?php 
                  //$orderid .= '<a href="'.$this->url(array('action'=>'my-order','order_id'=>$order->getIdentity()),'courses_account',true).'"></a>';
             ?>
             <?php if($order->state != "complete"){
                echo $this->translate("Your order has been sent for the confirmation and after that you will receive the invoice of your order.");
             }else{
                echo $this->translate("You will soon receive your order confirmation with invoice.");
            	}
              if($this->viewer()->getIdentity()){
                  echo "<br>".$this->translate("Your Order Id is %s",$this->order->order_id);
              }
            ?>
          </p>
          <div class="_btns">
            <a href="<?php echo $this->url(array('action'=>"browse"),'courses_general',true); ?>" class="sesbasic_link_btn"><?php echo $this->translate('Continue Shopping'); ?></a>
            <?php if($this->viewer()->getIdentity()){ ?>
              <a href="<?php echo $this->url(array('action'=>"my-order"),'courses_account',true); ?>" class="sesbasic_link_btn"><?php echo $this->translate('Go To My Order'); ?></a>
            <?php } ?>
          </div>
        </div>
    	</div>
    <?php }else{ ?>
    	<div class="courses_order_message_box courses_order_error_box">
      	<i class="fa fa-exclamation-triangle"></i>
        <div class="_cont">
          <h2><?php echo $this->translate("Error Occured"); ?></h2>
          <p class="courses_order_error_msg _msg"><?php echo $this->error; ?></p>
        </div>
      </div>
    <?php } ?>
	</div>
</div>
