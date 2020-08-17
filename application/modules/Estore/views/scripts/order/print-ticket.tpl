<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_estore
 * @package    estore
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: print-ticket.tpl 2016-07-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/estore/externals/styles/print.css'); ?>
<link href="<?php $this->layout()->staticBaseUrl ?>application/modules/Estore/externals/styles/print.css" rel="stylesheet" media="print" type="text/css" />
<?php foreach($this->orderDetails as $keyDet => $item){ ?>
<div class="estore_ticket_container">
	<div class="estore_ticket_content">
  	<div class="estore_ticket_content_left">
    	<div class="estore_ticket_content_block estore_ticket_event_name">
      	<div class="estore_ticket_content_block_head"><?php echo $this->translate("Event"); ?></div>
        <div class="estore_ticket_content_block_content"><?php echo $this->event->getTitle(); ?></div>
      </div>
      <div class="estore_ticket_content_block estore_ticket_event_time">
      	<div class="estore_ticket_content_block_head"><?php echo $this->translate("Date+Time"); ?></div>
        <div class="estore_ticket_content_block_content">
        <?php $dateinfoParams['starttime'] = true; ?>
        <?php $dateinfoParams['endtime']  =  true; ?>
        <?php $dateinfoParams['timezone']  = true; ?>
        <?php $dateinfoParams['isPrint']  = true; ?>
        <?php echo $this->eventStartEndDates($this->event,$dateinfoParams); ?>
        </div>
      </div>
      <?php if($this->event->location && !$this->event->is_webinar && Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.enable.location', 1)){ ?>
      <div class="estore_ticket_content_block estore_ticket_event_vanue">
      	<?php 
        	$venue_name = '';
        	if($this->event->venue_name){ 
        		$venue_name = '<br />'.$this->event->venue_name;
         } ?>
      	<div class="estore_ticket_content_block_head"><?php echo $this->translate("Location"); ?></div>
        <div class="estore_ticket_content_block_content"><?php echo $this->event->location.$venue_name; ?></div>
      </div>
      <?php }else{ ?>
      		<div class="estore_ticket_content_block estore_ticket_event_vanue">
      	<div class="estore_ticket_content_block_head"><?php echo $this->translate("Location"); ?></div>
        <div class="estore_ticket_content_block_content"><?php echo $this->translate("Webinar Event"); ?></div>
      </div>
     <?php } ?>
    	<div class="estore_ticket_content_block estore_ticket_orderinfo">
      	<div class="estore_ticket_content_block_head"><?php echo $this->translate("Order Info"); ?></div>
        <div class="estore_ticket_content_block_content">
        	<?php echo $this->translate("Order #%s. Ordered by %s on %s", $this->order->order_id, $this->buyer->getTitle(), Engine_Api::_()->estore()->dateFormat($this->order->creation_date)); ?>
        </div>
      </div>
			<div class="estore_ticket_content_block estore_ticket_type">
      	<div class="estore_ticket_content_block_head"><?php echo $this->translate("Attendee Info"); ?></div>
        <div class="estore_ticket_content_block_content" style="font-size:13px"><?php echo $item->first_name.' '.$item->last_name; ?><br /><?php echo $item->mobile ?><br /><?php echo $item->email; ?></div>
      </div>
    </div>
    <div class="estore_ticket_content_right">
    	<div class="estore_ticket_event_photo">
      	<img src="<?php echo $this->event->getPhotoUrl(); ?>" alt="<?php echo $this->event->getTitle(); ?>" />
      </div>
    	<div class="estore_ticket_content_block estore_ticket_paymentstatus">
      	<div class="estore_ticket_content_block_head"><?php echo $this->translate("Payment Method"); ?></div>
        <div class="estore_ticket_content_block_content"><?php echo $this->order->gateway_type; ?></div>
      </div>
      <div class="estore_ticket_content_block estore_ticket_qrcode">
      		<?php $fileName = $item->getType().'_'.$item->getIdentity().'.png'; ?>
          <?php if(!file_exists(APPLICATION_PATH . DIRECTORY_SEPARATOR . 'public/estore_qrcode/'.$fileName)){ 
          			$fileName = Engine_Api::_()->estore()->generateQrCode($item->registration_number,$fileName);
          			}else{ 
          			$fileName = ( isset($_SERVER["HTTPS"]) && (strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] .Zend_Registry::get('StaticBaseUrl') .'/public/estore_qrcode/'.$fileName;
          		  }
          ?>
      		<img src="<?php echo $fileName; ?>" alt="<?php echo $item->registration_number; ?>" />
      
      </div>
    </div>
  </div>
  <div class="estore_ticket_btm">
  <?php if($this->event->ticket_description){ ?>
  <div class="estore_event_ticket_description"><?php echo $this->event->ticket_description; ?></div>
  <?php } ?>
  <?php if($this->event->ticket_logo || $this->event->logo_description){ ?>
  <div class="estore_ticket_logo">
   <?php if($this->event->logo_description){?>
   <div class="estore_logo_title">
  	<?php echo $this->translate(nl2br($this->event->logo_description)); ?>
   </div>
   <?php } ?>
   <?php if($this->event->ticket_logo){
   				$img_path = Engine_Api::_()->storage()->get($this->event->ticket_logo, '')->getPhotoUrl();
       if(strpos($img_path,'http') === FALSE)
				$path = 'http://' . $_SERVER['HTTP_HOST'] . $img_path;
			 else
				$path = $img_path;
   ?>
  	<img src="<?php echo $path; ?>" />
   <?php } ?>
  </div>
  <?php } ?>
 </div>
</div>
<?php } ?>
<style type="text/css" media="print">
  @page { size: landscape; }
</style>
<script type="application/javascript">
sesJqueryObject(document).ready(function(e){
		window.print();
});
</script>