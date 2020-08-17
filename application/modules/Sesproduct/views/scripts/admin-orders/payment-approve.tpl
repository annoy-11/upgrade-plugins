<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: payment-approve.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<form method="post">
<div class='clear'>
  <div class='settings global_form_popup'>
    <h2>Approve Payment</h2>
    <div>
      Here, approve payment made for the order: <?php echo $this->htmlLink($this->url(array('store_id' => $this->store->custom_url,'action'=>'view','order_id'=>$this->order->order_id), 'estore_order', true).'?order=view', '#'.$this->order->order_id, array('title' => $this->translate($this->order->order_id), 'class' => 'smoothbox')); ?>

      <?php if($this->order->gateway_id == 20){ orderCheques?>
      <div>
        <span>Cheque Number</span>
        <span><?php echo $this->orderCheques->cheque_number ?></span>
      </div>
      <div>
        <span>Name</span>
        <span><?php echo $this->orderCheques->name ?></span>
      </div>
      <div>
        <span>Account Number</span>
        <span><?php echo $this->orderCheques->account_number ?></span>
      </div>
      <div>
        <span>Routing Number</span>
        <span><?php echo $this->orderCheques->routing_number ?></span>
      </div>
      <?php } ?>

      <div id="buttons-wrapper" class="form-wrapper">
        <div id="buttons-element" class="form-element">
          <button name="submit" id="submit" type="submit">Approve Payment</button>
          or <a name="cancel" id="cancel" type="button" href="javascript:void(0);" onclick="javascript:parent.Smoothbox.close()">cancel</a></div></div>
    </div>
  </div>
</div>
</form>