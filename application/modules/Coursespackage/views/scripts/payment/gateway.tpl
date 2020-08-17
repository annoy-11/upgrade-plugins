<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Coursespackage
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: gateway.tpl 2019-11-05 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sespagepackage/externals/styles/styles.css'); ?>
<?php $settings = Engine_Api::_()->getApi('settings', 'core');?>
<div class="layout_middle sespage_dashboard_main_nav">
	<div class="generic_layout_container ">
    <div class="headline">
      <h2>
        <?php echo $this->translate('Pages');?>
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
<div class="layout_middle sesbasic_bxs">
	<div class="generic_layout_container">
    <div class="sespage_package_payment_process">
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
              ?>
              <?php if( !$first ): ?>
                <?php echo $this->translate('or') ?>
              <?php endif; ?>
              <button class="sesbasic_animation" type="submit" name="execute" onclick="$('gateway_id').set('value', '<?php echo $gateway->gateway_id ?>')">
                <?php echo $this->translate('Pay with %1$s', $this->translate($gateway->title)) ?>
              </button>
            <?php endforeach; ?>
          </div>
        </div>
        <input type="hidden" name="gateway_id" id="gateway_id" value="" />
      </form>
    </div>
    <?php if($this->package->isOneTime()):?>
      <div class="coursespackage_account_details_box">
          <h3><?php echo $this->translate("Pay Via Bank Transfer");?></h3>
          <p><?php echo $this->translate("If you want make payment via Bank Transfer, then send the payment to bank account details mentioned below:");?></p>
          <p><?php echo $this->translate('After making payment, submit your details, transaction receipt or screenshot by clicking on <b>"Submit Payments Details"</b> button below.');?></p>
              <div class="coursespackage_account_details sesbasic_bxs">
                  <div class="_header _field">
                    <div class="_label" style="padding: 0;">&nbsp;</div>
                    <div class="_element">
                      <div>1</div>
                      <div>2</div>
                      <div>3</div>
                    </div>
                  </div>
                  <div class="_field">
                    <div class="_label"><?php echo $this->translate('Account Name');?>:</div>
                    <div class="_element">
                      <div class="_box _bank1"><?php echo $settings->getSetting('coursespackage.admin.account1.name', '');?></div>
                      <div class="_box _bank2"><?php echo $settings->getSetting('coursespackage.admin.account2.name', '');?></div>
                      <div class="_box _bank3"><?php echo $settings->getSetting('coursespackage.admin.account3.name', '');?></div>
                    </div>
                  </div>
                  <div class="_field">
                    <div class="_label"><?php echo $this->translate('Branch Name');?>:</div>
                    <div class="_element">
                      <div class="_box _bank1"><?php echo $settings->getSetting('coursespackage.admin.bank1.name', '');?></div>
                      <div class="_box _bank2"><?php echo $settings->getSetting('coursespackage.admin.bank2.name', '');?></div>
                      <div class="_box _bank3"><?php echo $settings->getSetting('coursespackage.admin.bank3.name', '');?></div>
                    </div>
                  </div>
                  <div class="_field">
                    <div class="_label"><?php echo $this->translate('Branch Code ');?>:</div>
                    <div class="_element">
                      <div class="_box _bank1"><?php echo $settings->getSetting('coursespackage.admin.account1.ifsccode', '');?></div>
                      <div class="_box _bank2"><?php echo $settings->getSetting('coursespackage.admin.account2.ifsccode', '');?></div>
                      <div class="_box _bank3"><?php echo $settings->getSetting('coursespackage.admin.account3.ifsccode', '');?></div>
                    </div>
                  </div>
                  <div class="_field">
                    <div class="_label"><?php echo $this->translate('Account No');?>:</div>
                    <div class="_element">
                      <div class="_box _bank1"><?php echo $settings->getSetting('coursespackage.admin.account1.no', '');?></div>
                      <div class="_box _bank2"><?php echo $settings->getSetting('coursespackage.admin.account2.no', '');?></div>
                      <div class="_box _bank3"><?php echo $settings->getSetting('coursespackage.admin.account3.no', '');?></div>
                    </div>
                  </div>
                   <div class="_field">
                      <div class="_label"><?php echo $this->translate('Iban No');?>:</div>
                      <div class="_element">
                        <div class="_box _bank1"><?php echo $settings->getSetting('coursespackage.admin.account1.swiftcode', '');?></div>
                        <div class="_box _bank2"><?php echo $settings->getSetting('coursespackage.admin.account2.swiftcode', '');?></div>
                        <div class="_box _bank3"><?php echo $settings->getSetting('coursespackage.admin.account3.swiftcode', '');?></div>
                      </div>
                    </div>
              </div>
              <div class="coursespackage_account_details_btn">
                <a href="<?php echo $this->url(array('page_id' => $this->item->page_id,'action'=>'fill-details'), 'coursespackage_payment', true); ?>" class="sessmoothbox sesbasic_animation"><i class="fa fa-file-text-o "></i><?php echo $this->translate("Submit Payment Details") ?></a>
              </div>	
          </div>
        <?php endif;?>
	</div>    
</div>  
