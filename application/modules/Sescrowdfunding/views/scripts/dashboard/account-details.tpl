<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: accouunt-details.tpl  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php if(!$this->is_ajax) { 
  echo $this->partial('dashboard/left-bar.tpl', 'sescrowdfunding', array('crowdfunding' => $this->crowdfunding,      )); 
?>
	<div class="sescrowdfunding_dashboard_content sesbm sesbasic_clearfix">
    <ul class="_reviewstype">
        <?php if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesadvpmnt') && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesadvpmnt.enable.package', 1)){ ?>
            <li class="_active"><a href="<?php echo $this->url(array('module' => 'sescrowdfunding', 'controller' => 'dashboard', 'action' => 'account-details','crowdfunding_id' => $this->crowdfunding->custom_url,'gateway_type'=>"stripe"), 'default', true); ?>" class="sesbasic_dashboard_nopropagate_content dashboard_a_link"><i class="fa fa-star"></i> <?php echo $this->translate('Stripe Details'); ?></a></li>
        <?php } ?>
        <?php if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('epaytm')){ ?>
            <li class="<?php echo $this->gateway_type == 'paytm' ? '_active' : ''; ?>"><a href="<?php echo $this->url(array('module' => 'sescrowdfunding', 'controller' => 'dashboard','action' => 'account-details','crowdfunding_id' => $this->crowdfunding->custom_url,'gateway_type'=>"paytm"), 'default', true); ?>" class="sesbasic_dashboard_nopropagate_content"><i class="fa fa-cc-stripe"></i><span><?php echo $this->translate('Paytm Details'); ?></span></a></li>
        <?php } ?>
            <li><a href="<?php echo $this->url(array('module' => 'sescrowdfunding', 'controller' => 'dashboard', 'action' => 'account-details','crowdfunding_id' => $this->crowdfunding->custom_url,'gateway_type'=>"paypal"), 'default', true); ?>" class="sesbasic_dashboard_nopropagate_content dashboard_a_link"><i class="fa fa-star"></i> <?php echo $this->translate('Paypal Details'); ?></a></li>
    </ul>
<?php } ?>
  <div class="sescrowdfunding_dashboard_form">
    <?php echo $this->form->render() ?>
  </div>
<?php if(!$this->is_ajax) { ?>
    </div>
</div>
</div>
<?php  } ?>
<?php if($this->is_ajax) die; ?>
