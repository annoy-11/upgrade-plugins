<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: payment-approve.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<form method="post">
<div class='clear'>
  <div class='settings global_form_popup'>
    <h2>Approve Payment</h2>
    <div>
      Here, approve payment made for the order: <?php echo $this->htmlLink($this->url(array('course_id' => $this->course->custom_url,'action'=>'view','order_id'=>$this->order->order_id), 'courses_order', true).'?order=view', '#'.$this->order->order_id, array('title' => $this->translate($this->order->order_id), 'class' => 'smoothbox')); ?>
      <div id="buttons-wrapper" class="form-wrapper">
        <div id="buttons-element" class="form-element">
          <button name="submit" id="submit" type="submit">Approve Payment</button>
          or <a name="cancel" id="cancel" type="button" href="javascript:void(0);" onclick="javascript:parent.Smoothbox.close()">cancel</a></div></div>
    </div>
  </div>
</div>
</form>
