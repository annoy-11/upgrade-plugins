<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: checkout.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesevent/externals/styles/styles.css'); ?>
<div class="layout_middle sesbasic_bxs">
	<div class="sesevent_ticket_checkout_page sesbasic_clearfix">
    <div class="sesevent_ticket_order_page_right">
      <div class="sesevent_ticket_order_info_box sesbm sesbasic_bxs">
        <span class="sesevent_ticket_order_info_box_title"><?php echo $this->translate("Order Information"); ?>
          <a href="<?php echo $this->url(array('event_id' => $this->event->custom_url), 'sesevent_ticket', true); ?>" class="fa fa-close" title="Cancel Order"></a>
        </span>
        <div class="sesevent_ticket_order_info">
          <div class="sesbasic_clearfix">
          <div class="sesevent_ticket_order_info_photo">
            <?php echo $this->htmlLink($this->event->getHref(), $this->itemPhoto($this->event, 'thumb.icon')) ?>
          </div>
          <div class="sesevent_ticket_order_info_name"><?php echo $this->htmlLink($this->event->getHref(),$this->event->getTitle()); ?></div>
          </div>
          <div class="sesevent_ticket_order_info_stats sesbasic_clearfix">
          <?php if($this->event->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesevent_enable_location', 1)){ ?>
            <span>
              <i class="fa fa-map-marker sesbasic_text_light" title="<?php echo $this->event->location; ?>"></i>
              <span>	
                <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)) { ?><a href="<?php echo $this->url(array('resource_id' => $this->event->event_id,'resource_type'=>'sesproduct','action'=>'get-direction'), 'sesbasic_get_direction', true) ;?>" class="opensmoothboxurl" title="<?php echo $this->event->location;?>"><?php echo $this->event->location;?></a><?php } else { ?><?php echo $this->event->location;?><?php } ?>
              </span>
            </span>
            <?php } ?>
            <span>
              <i class="fa fa-calendar sesbasic_text_light" title=""></i>
              <span>
                <?php echo Engine_Api::_()->sesevent()->dateFormat($this->event->starttime,'changetimezone',$this->event); ?> to <?php echo Engine_Api::_()->sesevent()->dateFormat($this->event->endtime,'changetimezone',$this->event); ?>
               </span>
            </span>
          </div>
          <div class="sesevent_ticket_order_info_summary sesbm">
            <span class="sesevent_ticket_order_info_box_title"><?php echo $this->translate("Order Summary"); ?></span>
          <?php foreach($this->ticketDetail->toArray() as $valTicket){ ?>
            <p class="sesbasic_clearfix">
              <span><?php echo $valTicket['title'] .' X '.$valTicket['quantity']; ?></span>
              <span><?php echo Engine_Api::_()->sesevent()->getCurrencyPrice($valTicket['price']*$valTicket['quantity']); ?></span>
            </p>
          <?php } ?>
            <p class="sesbasic_clearfix">
              <span><?php echo $this->translate("Total Tax"); ?></span>
              <span><?php echo Engine_Api::_()->sesevent()->getCurrencyPrice(($this->order->total_service_tax+$this->order->total_entertainment_tax)); ?></span>
            </p>
            <p class="sesbasic_clearfix">
              <span><?php echo $this->translate("Grand Total"); ?></span>
              <span><?php echo Engine_Api::_()->sesevent()->getCurrencyPrice(($this->order->total_service_tax+$this->order->total_entertainment_tax+$this->order->total_amount)); ?></span>
            </p>
          </div>
        </div>
      </div>
    </div>
    
    <div class="sesevent_checkout_form">
    <form method="get" action="<?php echo $this->escape($this->url(array('action' => 'process'))) ?>" enctype="application/x-www-form-urlencoded">
        <div class="sesevent_checkout_form_title">
        	<?php echo $this->translate('Pay') ?>
        </div>
        <div id="buttons-wrapper" class="sesevent_checkout_form_btns">
          <?php foreach( $this->gateways as $gatewayInfo ):
                $gateway = $gatewayInfo['gateway'];
                $plugin = $gatewayInfo['plugin'];
                ?>
        <button type="submit" name="execute"  onclick="$('gateway_id').set('value', '<?php echo $gateway->gateway_id ?>')">
          <?php echo $this->translate('Pay with %1$s', $this->translate($gateway->title)) ?>
        </button>
        <?php endforeach; ?>
      </div>
      <input type="hidden" name="gateway_id" id="gateway_id" value="" />
    </form>
    <div class="sesbasic_loading_cont_overlay" style="display:none"></div>
    </div>
  </div>
</div>
