<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: account-details.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php if(!$this->is_ajax){ 
echo $this->partial('dashboard/left-bar.tpl', 'courses', array(
	'course' => $this->course,
      )); ?>
	<div class="courses_dashboard_content sesbm sesbasic_clearfix">
<?php } ?>
<div class="courses_dashboard_form courses_dashboard_account_details">
    <ul class="courses_dashboard_sub_tabs">
        <li class="<?php echo $this->gateway_type == 'paypal' ? '_active' : ''; ?>"><a href="<?php echo $this->url(array('course_id' => $this->course->custom_url,'gateway_type'=>"paypal"), 'courses_account_details', true); ?>" class="sesbasic_dashboard_nopropagate_content"><i class="fa fa-cc-paypal"></i><span><?php echo $this->translate('Paypal Details'); ?></span></a></li>
        <?php if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesadvpmnt') && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesadvpmnt.enable.package', 1)){ ?>
            <li class="<?php echo $this->gateway_type == 'stripe' ? '_active' : ''; ?>"><a href="<?php echo $this->url(array('course_id' => $this->course->custom_url,'gateway_type'=>"stripe"), 'courses_account_details', true); ?>" class="sesbasic_dashboard_nopropagate_content"><i class="fa fa-cc-stripe"></i><span><?php echo $this->translate('Stripe Details'); ?></span></a></li>
        <?php } ?>
        <?php if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('epaytm')){ ?>
            <li class="<?php echo $this->gateway_type == 'paytm' ? '_active' : ''; ?>"><a href="<?php echo $this->url(array('course_id' => $this->course->custom_url,'gateway_type'=>"paytm"), 'courses_account_details', true); ?>" class="sesbasic_dashboard_nopropagate_content"><i class="fa fa-cc-paytm"></i><span><?php echo $this->translate('Paytm Details'); ?></span></a></li>
        <?php } ?>
        
    </ul>
	<?php echo $this->form->render() ?>

</div>
<?php if(!$this->is_ajax){ ?>
    </div>
	</div>
</div>
<?php  } ?>
<?php if($this->is_ajax) die; ?>
