<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: payment-requests.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php
if(!$this->is_ajax){
	echo $this->partial('dashboard/left-bar.tpl', 'courses', array(
	'course' => $this->course,
      )); ?>
<div class="courses_dashboard_content sesbm sesbasic_clearfix">
<?php } 
?>
<?php  $defaultCurrency = Engine_Api::_()->courses()->defaultCurrency(); ?>
<div class="courses_dashboard_content_header sesbasic_clearfix">	
  <h3><?php echo $this->translate("Make Payment Request"); ?></h3>
    <?php if($this->thresholdAmount > 0){ ?>
    <div class="courses_dashboard_threshold_amt"><?php echo $this->translate("Threshold Amount:"); ?> <b><?php echo Engine_Api::_()->courses()->getCurrencyPrice($this->thresholdAmount,$defaultCurrency); ?></b></div>
    <?php } ?>
</div>
<?php if(!count($this->userGateway)){ ?>
	<div class="tip">
  <span>    
    <?php echo $this->translate('Payment details not submited yet %1$sClick Here%2$s to submit.', '<a href="'.$this->url(array('course_id' => $this->course->custom_url,'action'=>'account-details'), 'courses_dashboard', true).'">', '</a>'); ?>
  </span>
</div>
<?php } ?>
<?php $orderDetails = $this->orderDetails; ?>
<div class="courses_sale_stats_container sesbasic_bxs sesbasic_clearfix">
	<div class="courses_sale_stats">
  	<span><?php echo $this->translate("Total Orders"); ?></span>
    <span><?php echo $orderDetails['totalOrder'];?></span>
  </div>
  <div class="courses_sale_stats">
  	<span><?php echo $this->translate("Total Tax Amount"); ?></span>
    <span><?php echo Engine_Api::_()->courses()->getCurrencyPrice($orderDetails['total_billingtax_cost'],$defaultCurrency); ?></span>
  </div>
  <div class="courses_sale_stats">
        <span><?php echo $this->translate("Total Comission Amount"); ?></span>
        <span><?php echo Engine_Api::_()->courses()->getCurrencyPrice($orderDetails['commission_amount'],$defaultCurrency); ?></span>
    </div>
  <div class="courses_sale_stats">
  	<span><?php echo $this->translate("Total Remaining Amount"); ?></span>
    <span><?php echo Engine_Api::_()->courses()->getCurrencyPrice($this->remainingAmount,$defaultCurrency); ?></span>
	</div>
</div>


<?php if($this->remainingAmount >= $this->thresholdAmount && count($this->userGateway) && !count($this->isAlreadyRequests)){ ?>
<div class="courses_request_payment_link ">	
	<a href="<?php echo $this->url(array('course_id' => $this->course->custom_url,'action'=>'payment-request'), 'courses_dashboard', true); ?>" class="openSmoothbox sesbasic_button fa fa-money"><?php echo $this->translate("Make Request For Payment."); ?></a>
</div>
<?php } ?>
<?php if( isset($this->paymentRequests) && count($this->paymentRequests) > 0): ?>
<div class="courses_dashboard_table sesbasic_bxs">
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
          <td class="centerT"><?php echo Engine_Api::_()->courses()->getCurrencyPrice($item->requested_amount,$defaultCurrency); ?></td>
          <td><?php echo $item->creation_date; ?></td>
          <td class="centerT"><?php echo $item->state != 'pending' ? Engine_Api::_()->courses()->getCurrencyPrice($item->release_amount	,$defaultCurrency) :  "-"; ?></td>
          <td><?php echo $item->release_date && (bool)strtotime($item->release_date) && $item->state != 'pending' ? Engine_Api::_()->courses()->dateFormat($item->release_date) :  '-'; ?></td> 
          <td><?php echo ucfirst($item->state); ?></td>
          <td class="table_options">
          	<?php if ($item->state == 'pending'){ ?>
                <?php echo $this->htmlLink($this->url(array('course_id' => $this->course->custom_url,'action'=>'payment-request','id'=>$item->userpayrequest_id), 'courses_dashboard', true), $this->translate(""), array('class' => 'openSmoothbox fa fa-pencil','title'=>$this->translate("Edit Request"))); ?>
                <?php echo $this->htmlLink($this->url(array('action' => 'delete-payment', 'id' => $item->userpayrequest_id, 'course_id' => $this->course->custom_url), 'courses_dashboard', true), $this->translate(""), array('class' => 'openSmoothbox fa fa-trash','title'=>$this->translate("Delete Request"))); ?>
            <?php } ?>
            		<?php echo $this->htmlLink($this->url(array('action' => 'detail-payment', 'id' => $item->userpayrequest_id, 'course_id' => $this->course->custom_url), 'courses_dashboard', true), $this->translate(""), array('class' => 'openSmoothbox fa fa-eye','title'=>$this->translate("View Details"))); ?>
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
