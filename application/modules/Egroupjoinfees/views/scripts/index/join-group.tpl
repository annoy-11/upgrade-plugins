<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Egroupjoinfees
 * @package    Egroupjoinfees
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: join-group.tpl  2017-12-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Egroupjoinfees/externals/styles/styles.css'); ?>
<?php $currentCurrency = Engine_Api::_()->egroupjoinfees()->getCurrentCurrency(); ?>
<div id="popupcontainer" class="sesgroup_fees_process_popup sesbasic_bxs">
	<div class="sesgroup_fees_process_popup_content">
  <?php if($this->popupTitle){ ?>
  	<h3><?php echo $this->translate($this->popupTitle);?></h3>
    <?php } ?>
    <?php if($this->popupDescription){ ?>
    <p><?php echo $this->translate($this->popupDescription) ?></p>
    <?php } ?>
  	<div class="_btns sesbasic_clearfix">
      <button type="button" id="makePayment"><?php echo $this->translate('Make Payment'); ?></button>
      <button type="button" id="goBack"><?php echo $this->translate('Go back'); ?></span></button>
  	</div>
  </div>
</div>
<script type="application/javascript">
  sesJqueryObject(document).on('click','#makePayment',function(){
      sesJqueryObject('#popupcontainer').hide();
      sesJqueryObject('#checkoutform').show();
  });
  sesJqueryObject(document).on('click','#goBack',function(){
    window.history.go(-1);
  });
</script>

<div class="layout_middle">
  <?php $group = Engine_Api::_()->getItem('sesgroup_group',$this->group_id); ?>
  <div class="checkout_form" id="checkoutform" style="display:none;">
    <form method="get" action="<?php echo $this->escape($this->url(array('action' => 'process','module'=>'egroupjoinfees','controller'=>'index','plan_id'=>$this->plan->getIdentity()),'default',true)) ?>"
          class="global_form" enctype="application/x-www-form-urlencoded">
      <div>
        <div>
          <h3>
            <?php echo $this->translate('Make Payment to subscribe to ').$this->plan->title; ?>
          </h3>
          <?php if( $this->plan->recurrence ): ?>
          <p class="form-description">
            <?php echo $this->translate('') ?>
          </p>
          <?php endif; ?>
          <p style="font-weight: bold; padding-top: 15px; padding-bottom: 15px;">
            <?php if( $this->plan->recurrence ): ?>
              <?php echo $this->translate('Choose the gateway below to continue to make the payment of-') ?>
            <?php else: ?>
              <?php echo $this->translate('Please pay a one-time fee to continue:') ?>
            <?php endif; ?>
            <?php echo $this->plan->getPackageDescription(); ?>
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
        </div>
      </div>
      <input type="hidden" name="gateway_id" id="gateway_id" value="" />
    </form>
    <div class="sesbasic_loading_cont_overlay" style="display:none"></div>
    <?php if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('ecoupon')): ?>
      <?php  echo $this->partial('have_coupon.tpl','ecoupon',array('id'=>$group->group_id,'params'=>json_encode(array('resource_type'=>$group->getType(),'resource_id'=>$group->group_id,'is_package'=>0,'item_amount'=>$group->entry_fees)))); ?> 
    <?php endif; ?>
    
     <?php if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sescredit')) { ?>
		  <?php  echo $this->partial('apply_credit.tpl','sescredit',array('id'=>$group->group_id,'moduleName'=>'egroupjoinfees','item_price'=>$this->itemPrice,'item_id'=>$group->group_id)); ?> 
    <?php } ?>
    
  </div>  
</div>
<script type="application/javascript">
  var itemPrice<?php echo $group->group_id; ?> = '<?php echo $this->itemPrice; ?>';
</script>
