<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgrouppackage
 * @package    Sesgrouppackage
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: gateway.tpl  2018-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesgrouppackage/externals/styles/styles.css'); ?>

<div class="layout_middle sesgroup_dashboard_main_nav">
	<div class="generic_layout_container ">
    <div class="headline">
      <h2>
        <?php echo $this->translate('Groups');?>
      </h2>
      <?php if( count($this->navigation) > 0 ): ?>
        <div class="tabs">
          <?php
            // Render the menu
            echo $this->navigation()
              ->menu()
              ->setContainer($this->navigation)
              ->render();
          ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>
<?php $currentCurrency =  Engine_Api::_()->sesgrouppackage()->getCurrentCurrency(); ?>
<div class="layout_middle sesbasic_bxs">
	<div class="generic_layout_container">
    <div class="sesgroup_package_payment_process">
      <form method="get" action="<?php echo $this->escape($this->url(array('action' => 'process'))) ?>" enctype="application/x-www-form-urlencoded">
        <h3 class="_head"><?php echo $this->translate('Make Payment to subscribe to ').$this->package->title; ?></h3>
        <?php if( $this->package->recurrence ): ?>
          <p class="form-description">
            <?php echo $this->translate('') ?>
          </p>
        <?php endif; ?>
        <p class="_des">
          <?php if( $this->package->recurrence ): ?>
            <?php echo $this->translate('Choose the gateway below to continue to make the payment of-') ?>
          <?php else: ?>
            <?php echo $this->translate('Please pay a one-time fee to continue:') ?>
          <?php endif; ?>
          <b><?php echo $this->package->getPackageDescription(); ?></b>
        </p>
        <div class="form-elements">
          <div id="buttons-wrapper" class="form-wrapper">
            <?php foreach( $this->gateways as $gatewayInfo ):
              $gateway = $gatewayInfo['gateway'];
              $plugin = $gatewayInfo['plugin'];
              $first = ( !isset($first) ? true : false );
              $gatewayObject = $gateway->getGateway();
              $supportedCurrencies = $gatewayObject->getSupportedCurrencies();
              if(!in_array($currentCurrency,$supportedCurrencies))
                continue;
              ?>
              <?php if( !$first ): ?>
                <?php echo $this->translate('or') ?>
              <?php endif; ?>
              <button type="submit" name="execute" onclick="$('gateway_id').set('value', '<?php echo $gateway->gateway_id ?>')">
                <?php echo $this->translate('Pay with %1$s', $this->translate($gateway->title)) ?>
              </button>
            <?php endforeach; ?>
          </div>
        </div>
        <input type="hidden" name="gateway_id" id="gateway_id" value="" />
      </form>
    </div>
	</div>    
	<?php if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('ecoupon')): ?>
    <?php  echo $this->partial('have_coupon.tpl','ecoupon',array('id'=>$this->package->package_id,'params'=>json_encode(array('resource_type'=>$this->item->getType(),'resource_id'=>$this->item->group_id,'is_package'=>1,'package_type'=>$this->package->getType(),'package_id'=>$this->package->package_id)))); ?> 
	<?php endif; ?>
	<?php if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sescredit')) { ?>
		  <?php  echo $this->partial('apply_credit.tpl','sescredit',array('id'=>$this->package->package_id,'moduleName'=>'sesgrouppackage','item_price'=>$this->itemPrice,'item_id'=>$this->item->group_id)); ?> 
  <?php } ?>
</div>  
<script type="application/javascript">
  var itemPrice<?php echo $this->package->package_id; ?> = '<?php echo $this->itemPrice; ?>';
</script>
