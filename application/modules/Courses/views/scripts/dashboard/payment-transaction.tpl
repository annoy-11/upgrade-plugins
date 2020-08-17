<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: payment-transaction.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php
if(!$this->is_ajax){
	echo $this->partial('dashboard/left-bar.tpl', 'courses', array('course' => $this->course));?>
<div class="courses_dashboard_content sesbm sesbasic_clearfix">
<?php } 
?>
<?php $defaultCurrency = Engine_Api::_()->courses()->defaultCurrency(); ?>
<div class="courses_dashboard_content_header sesbasic_clearfix">	
  <h3><?php echo $this->translate("Payments Received"); ?></h3>
  <p><?php echo $this->translate('Here, you are viewing the details of payments received from the website.') ?></p>
</div>
<?php if( isset($this->paymentRequests) && count($this->paymentRequests) > 0): ?>
<div class="courses_dashboard_table sesbasic_bxs">
  <form method="post" >
    <table>
      <thead>
        <tr>
          <th><?php echo $this->translate("Requested Amount") ?></th>
          <th><?php echo $this->translate("Released Amount") ?></th>
          <th><?php echo $this->translate("Released Date") ?></th>
          <th><?php echo $this->translate("Response Message") ?></th>
          <th><?php echo $this->translate("Status") ?></th>
          <th><?php echo $this->translate("Options") ?></th>
        </tr>
      </thead>
      <tbody>
        <?php 
          foreach ($this->paymentRequests as $item): ?>
        <tr>
          <td class="centerT"><?php echo Engine_Api::_()->courses()->getCurrencyPrice($item->requested_amount,$defaultCurrency); ?></td>
          <td class="centerT"><?php echo Engine_Api::_()->courses()->getCurrencyPrice($item->release_amount	,$defaultCurrency); ?></td>
          <td><?php echo $item->release_date ? ($item->release_date) :  '-'; ?></td>
          <td class="centerT"><?php echo $this->string()->truncate(empty($item->admin_message	) ? '-' : $item->admin_message, 30) ?></td>
          <td><?php echo ucfirst($item->state); ?></td>
          <td class="table_options">
         		<?php echo $this->htmlLink($this->url(array('action' => 'detail-payment', 'id' => $item->userpayrequest_id, 'course_id' => $this->course->custom_url), 'courses_dashboard', true), $this->translate(""), array('title' => $this->translate("View Details"), 'class' => 'openSmoothbox fa fa-eye')); ?>
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
    <?php echo $this->translate("No transactions have been made yet.") ?>
  </span>
</div>
<?php endif; ?>
</div>
</div>
</div>
