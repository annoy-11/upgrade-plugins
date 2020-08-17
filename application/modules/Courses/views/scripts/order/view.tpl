<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: view.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<link href="<?php $this->layout()->staticBaseUrl ?>application/modules/Courses/externals/styles/admin/main.css" rel="stylesheet" media="print" type="text/css" />
<?php if($this->format == 'smoothbox' && empty($_GET['order'])){ ?>
<link href="<?php $this->layout()->staticBaseUrl ?>application/modules/Courses/externals/styles/styles.css" rel="stylesheet" media="print" type="text/css" />
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Courses/externals/styles/print.css'); ?>
<?php } ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Courses/externals/styles/styles.css'); ?> 
<div class="courses_invoice_page sesbasic_bxs sesbasic_clearfix">
  <div class="courses_invoice_page_inner">
     <div class="courses_invoice_header">
       <!--<a href="#"><img src="application/modules/Courses/externals/images/logo.png" /></a>-->
       <span>
          <span class="_num"><?php  echo $this->translate('Invoice #%s',$this->order->order_id); ?></span>
          <span class="_date sebasic_text_light"><?php echo $this->translate('Date: '); ?> <?php echo date('d M ,Y',strtotime($this->order->creation_date)); ?> </span>
       </span>
     </div>
     <?php    
        $orderaddressTable = Engine_Api::_()->getDbTable('orderaddresses','courses');
        $billingAddress = $orderaddressTable->getAddress(array('user_id'=>$this->order->user_id,'order_id'=>$this->order->order_id,'view'=>true));
     ?>
     <div class="courses_invoice_body sesbasic_bxs sesbasic_clearfix">
       <div class="courses_invoice_details">
          <div class="_right">
            <div class="_head">To:</div> 
            <div class="_name"><?php echo $billingAddress->first_name.' '.$billingAddress->last_name; ?></div>                                           
            <div class="_address sesbasic_text_light"><?php echo $billingAddress->address; ?></div>
            <div class="_email sesbasic_text_light"><?php echo $this->translate('Email: '); ?><?php echo $billingAddress->email; ?></div>
            <div class="_Phone sesbasic_text_light"><?php echo $this->translate('Phone: '); ?><?php echo $billingAddress->phone_number; ?></div>
          </div>
      </div>
      <div class="courses_invoice_table">
        <table>
            <thead>
                <tr>
                    <th class="center"><?php echo $this->translate('Course Order Id'); ?></th>
                    <th><?php echo $this->translate('Course Name'); ?></th>
                    <th class="right"><?php echo $this->translate('Price'); ?></th>
                    <th class="right"><?php echo $this->translate('Discount'); ?></th>
                    <th class="right"><?php echo $this->translate('Tax'); ?></th>
                    <th class="center"><?php echo $this->translate('Qty'); ?></th>
                    <th class="right"><?php echo $this->translate('Total'); ?></th>
                </tr>
            </thead>
            <tbody>
              <?php $savedMoney = 0; ?>
              <?php foreach($this->orderedCourses as $orderedCourse): ?>
                <tr>
                  <?php $savedMoney += $orderedCourse->discount; ?>
                    <td class="center sesbasic_text_light"><?php echo $orderedCourse->ordercourse_id; ?></td>
                    <td class="left strong sesbasic_text_light"><?php echo $orderedCourse->getTitle();?></td>
                    <td class="right sesbasic_text_light"><?php echo Engine_Api::_()->courses()->getCurrencyPrice($orderedCourse->price,$orderedCourse->currency_symbol,$orderedCourse->change_rate); ?></td>
                    <td class="right sesbasic_text_light"><?php echo Engine_Api::_()->courses()->getCurrencyPrice($orderedCourse->discount,$orderedCourse->currency_symbol,$orderedCourse->change_rate); ?></td>
                    <td class="right sesbasic_text_light"><?php echo Engine_Api::_()->courses()->getCurrencyPrice($orderedCourse->billingtax_cost,$orderedCourse->currency_symbol,$orderedCourse->change_rate); ?></td>
                    <td class="center sesbasic_text_light"><?php echo $this->translate('1'); ?></td>
                    <td class="right sesbasic_text_light"><?php echo Engine_Api::_()->courses()->getCurrencyPrice($orderedCourse->total,$orderedCourse->currency_symbol,$orderedCourse->change_rate); ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
        </table>
      </div>
      <table class="courses_invoice_total_table">
          <tbody>
              <tr>
                  <td class="left">
                      <strong><?php echo $this->translate('Subtotal'); ?></strong>
                  </td>
                  <td class="right sesbasic_text_light"><?php echo Engine_Api::_()->courses()->getCurrencyPrice($this->order->total_amount,$this->order->currency_symbol,$this->order->change_rate); ?></td>
              </tr>
              <?php if($savedMoney): ?>
                <tr>
                    <td class="left">
                        <strong><?php echo $this->translate('You saved'); ?></strong>
                    </td>
                    <td class="right sesbasic_text_light"><?php echo Engine_Api::_()->courses()->getCurrencyPrice($savedMoney,$this->order->currency_symbol,$this->order->change_rate); ?></td>
                </tr>
               <?php endif; ?>
          </tbody>
      </table>
    </div>
    <div class="courses_invoice_footer sesbasic_text_light">
      Copyright &copy; 2019. All Rights Reserved.
    </div>
  </div>
</div>
<?php if(empty($_GET['order'])){ ?>
<style type="text/css" media="print">
  @page { size: landscape; }
</style>
<script type="application/javascript">
sesJqueryObject(document).ready(function(e){
    window.print();
});
</script>
<?php } ?>
<style>#global_header,#global_footer{display:none}
</style>
