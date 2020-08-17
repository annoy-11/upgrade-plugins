<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesevent
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: account-details.tpl 2016-07-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php if(!$this->is_ajax){ 
echo $this->partial('dashboard/left-bar.tpl', 'estore', array(
	'store' => $this->store,
      )); ?>
	<div class="estore_dashboard_content sesbm sesbasic_clearfix">
<?php } ?>
<div class="estore_dashboard_form estore_dashboard_account_details">
    <ul class="estore_dashboard_sub_tabs">
        <li class="<?php echo $this->gateway_type == 'paypal' ? '_active' : ''; ?>"><a href="<?php echo $this->url(array('store_id' => $this->store->custom_url,'gateway_type'=>"paypal"), 'account_details', true); ?>" class="sesbasic_dashboard_nopropagate_content"><i class="fa fa-cc-paypal"></i><span><?php echo $this->translate('Paypal Details'); ?></span></a></li>
        <?php if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesadvpmnt') && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesadvpmnt.enable.package', 1)){ ?>
            <li class="<?php echo $this->gateway_type == 'stripe' ? '_active' : ''; ?>"><a href="<?php echo $this->url(array('store_id' => $this->store->custom_url,'gateway_type'=>"stripe"), 'account_details', true); ?>" class="sesbasic_dashboard_nopropagate_content"><i class="fa fa-cc-stripe"></i><span><?php echo $this->translate('Stripe Details'); ?></span></a></li>
        <?php } ?>
        <?php if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('epaytm')){ ?>
            <li class="<?php echo $this->gateway_type == 'paytm' ? '_active' : ''; ?>"><a href="<?php echo $this->url(array('store_id' => $this->store->custom_url,'gateway_type'=>"paytm"), 'account_details', true); ?>" class="sesbasic_dashboard_nopropagate_content"><i class="fa fa-cc-stripe"></i><span><?php echo $this->translate('Paytm Details'); ?></span></a></li>
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
