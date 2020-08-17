<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: orderStatus.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>

<?php

$item = $this->item;
if($item->state == "processing"){ ?>

<?php if($item->gateway_id == 21 || $item->gateway_id == 20){ ?>
  <?php echo $this->translate("Approval Pending"); ?>
<?php }else{ ?>
  <div><?php echo $this->translate("Processing"); ?><a href="javascript:;" class="courses_change_type"><i class="fa fa-chevron-down"></i></a></div>
  <form method="post" class="process_form_order_courses" style="display: none;">
    <select name="status">
      <option value="1"><?php echo $this->translate("Processing"); ?></option>
      <option value="2"><?php echo $this->translate("On Hold"); ?></option>
      <option value="3"><?php echo $this->translate("Fraud"); ?></option>
      <option value="4"><?php echo $this->translate("Completed"); ?></option>
    </select>
    <input type="checkbox" checked="checked" value="1" name="notify_buyer"><?php echo $this->translate("Notify and Email to Buyer"); ?>
    <input type="checkbox" checked="checked" value="1" name="notify_seller"><?php echo $this->translate("Notify and Email to Course Owner"); ?>
    <a href="javascript:void(0)" onclick="changeOrderStatus(<?php echo $item->order_id; ?>,this)"><?php echo $this->translate("Change"); ?></a>
    <div class="img_<?php echo $item->order_id; ?>" style="display: none">
      <img src="application/modules/Core/externals/images/loading.gif" height="15" width="15">
    </div>
  </form>
  <?php } ?>
<?php }else if($item->state == "complete"){ ?>
<?php echo $this->translate("Completed"); ?>
<?php }else if($item->state == "initial"){ ?>
<?php echo $this->translate("Payment Pending"); ?>
<?php }else{ ?>
<?php echo ucfirst($item->state); ?>
<?php } ?>
