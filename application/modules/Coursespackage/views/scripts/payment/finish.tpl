<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Coursespackage
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: finish.tpl 2019-11-05 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Coursespackage/externals/styles/styles.css'); ?>
<div class="layout_middle">
  <div class="generic_layout_container layout_core_content">
    <div class="coursespackage_payment_process_complete_page sesbasic_bxs">
      <form method="get" action="<?php echo $this->escape($this->url(array('classroom_id'=>$this->classroom_id), 'eclassroom_dashboard', true)) ?>" enctype="application/x-www-form-urlencoded">
        <?php if( $this->status == 'pending' ): ?>
          <div class="coursespackage_payment_process_complete">
            <i><img src="application/modules/Coursespackage/externals/images/wait.png" alt=""></i>
            <span class="_text _wait"><?php echo $this->translate('Payment Pending') ?></span>
            <p class="form-description">
              <?php echo $this->translate('Thank you for submitting your ' .
                  'payment. Your payment is currently pending - your account ' .
                  'will be activated when we are notified that the payment has ' .
                  'completed successfully. Please return to our login page ' .
                  'when you receive an email notifying you that the payment ' .
                  'has completed.') ?>
            </p>
            <div id="buttons-wrapper" class="coursespackage_payment_process_complete_btn">
              <button type="submit">
                <?php echo $this->translate('Go to Classroom Dashboard') ?>
              </button>
            </div>
          </div>
        <?php elseif( $this->status == 'active' ): ?>
          <div class="coursespackage_payment_process_complete">
            <i><img src="application/modules/Sespage/externals/images/success.png" alt=""></i>
            <span class="_text"><?php echo $this->translate('Payment Completed') ?></span>
            <p class="form-description">
              <?php echo $this->translate('Thank you! Your payment has ' . 'completed successfully.') ?>
            </p>
            <div id="buttons-wrapper" class="coursespackage_payment_process_complete_btn">
              <button type="submit">
                <?php echo $this->translate('Go to Classroom Dashboard') ?>
              </button>
            </div>
          </div>
        <?php else: //if( $this->status == 'failed' ): ?>
          <div class="coursespackage_payment_process_complete">
            <i><img src="application/modules/Coursespackage/externals/images/fail.png" alt=""></i>
            <span class="_text _errot"><?php echo $this->translate('Payment Failed') ?></span>
            <p class="form-description">
              <?php if( empty($this->error) ): ?>
                <?php echo $this->translate('Our payment processor has notified ' .
                    'us that your payment could not be completed successfully. ' .
                    'We suggest that you try again with another credit card ' .
                    'or funding source.') ?>
                <?php else: ?>
                  <?php echo $this->translate($this->error) ?>
                <?php endif; ?>
            </p>
            <div id="buttons-wrapper" class="coursespackage_payment_process_complete_btn">
                <button type="submit">
                  <?php echo $this->translate('Go to Classroom Dashboard') ?>
                </button>
              </div>
					</div>              
        <?php endif; ?>
      </form>
    </div>
  </div>
</div>  
