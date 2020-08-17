<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventpdfticket
 * @package    Seseventpdfticket
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: pdfContent.tpl 2016-03-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<!DOCTYPE html>
<html>
<base href="" />
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<meta charset="utf-8">
<title></title>
</head>
<body>
<span id="global_content_simple">
<table cellpadding="0" cellspacing="0" border="0" style="width:800px;margin:0 auto;">
  <tr>
    <td><table border="0" cellpadding="0"  cellspacing="0" style="border-collapse:collapse;font:normal 13px Arial,Helvetica,sans-serif;border:5px solid #ddd;background-color:#fff;" width="100%">
        <tr valign="top">
          <td style="border-right:5px solid #ddd;width:590px;"><div>
              <table cellpadding="0" cellspacing="0" width="100%">
                <tr>
                  <td style="border-bottom:5px solid #ddd;height:105px;position:relative;" colspan="2"><div style="color:#999;font-size:14px;left:5px;position:absolute;top:5px;"><?php echo $view->translate('Event') ?></div>
                    <div style="font-size:20px;padding-top:40px;position:inherit;text-align:center;"><?php echo $event->getTitle(); ?></div></td>
                </tr>
                <tr>
                  <td style="border-bottom:5px solid #ddd;border-right:5px solid #ddd;height:120px;width:280px;position:relative;"><div style="color:#999;font-size:14px;left:5px;position:absolute;top:5px;"><?php echo $view->translate('Date+Time') ?></div>
                    <div style="bottom:5px;font-size:13px;text-align:right;padding:0 10px;right:5px;max-width:90%;"> 
                    	<?php 
                        $dateinfoParams['starttime'] = true;
                        $dateinfoParams['endtime']  =  true;
                        $dateinfoParams['timezone']  = true; 
                        $dateinfoParams['isPrint']  = true; 
                        $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
                        echo $view->eventStartEndDates($event, $dateinfoParams);
                      ?>
                     </div></td>
                  <td style="border-bottom:5px solid #ddd;height:120px;width:275px;position:relative;"><div style="color:#999;font-size:14px;left:5px;position:absolute;top:5px;"><?php echo $view->translate("Location"); ?></div>
                    <div style="bottom:5px;font-size:13px;right:5px;max-width:90%;text-align:right;padding:0 10px;">
                    	<?php 
                        if($event->location && !$event->is_webinar && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesevent.enable.location', 1)) {
                          $venue_name = '';
                          if($event->venue_name){ 
                            $venue_name = $event->venue_name;
                          }
                          $location = $event->location . $venue_name;
                        } else {
                          $location = $view->translate('Webinar Event');
                        }
                        echo $location;
                      ?>
                    </div></td>
                </tr>
                <tr>
                  <td style="border-bottom:5px solid #ddd;position:relative;" colspan="2">
                  <div style="color:#999;font-size:14px;left:5px;position:absolute;top:5px;"><?php echo $view->translate("Order Info"); ?>
                  </div>
                    <div style="margin:30px 5px 20px;text-align:right;"> <?php echo $view->translate("Order") ?> #<?php echo $eventOrder->getIdentity(); ?>. <?php echo $view->translate("Ordered by") ?> <?php echo $user->displayname; ?> <?php echo $view->translate("on").' '.Engine_Api::_()->sesevent()->dateFormat($eventOrder->creation_date); ?>  </div></td>
                </tr>
                <tr>
                  <td style="position:relative;" colspan="2"><div style="color:#999;font-size:14px;left:5px;position:absolute;top:5px;"><?php echo $view->translate("Attendee Info"); ?></div>
                    <div style="margin:30px 5px 20px;text-align:right;"><?php echo $orderDetail->first_name .' '. $orderDetail->last_name ?><br />
                      <?php echo $orderDetail->mobile ; ?><br />
                      <?php echo $orderDetail->email; ?>
                    </div>
                  </td>
                </tr>
              </table>
            </div></td>
          <td style="width:238px;"><div>
              <table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                  	<?php 
                    	if (strpos($event->getPhotoUrl(), 'http') === FALSE) {
		                    $imageurl =  (isset($_SERVER["HTTPS"]) && (strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] .Zend_Registry::get('StaticBaseUrl').$event->getPhotoUrl();
                      }else{
                      	$imageurl = $event->getPhotoUrl();
                      }
                    ?>                
                  <td><div style="height:129px;padding:10px;margin-bottom:20px;"> <img alt="<?php echo $event->getTitle(); ?>" src="<?php echo $imageurl; ?>" style="height:100%;object-fit:contain;width:218px" /> </div></td>
                </tr>
                <tr>
                  <td><div style="padding-top:8px;position:relative;border-bottom:5px solid #ddd;">
                      <div style="color:#999;font-size:14px;left:5px;position:absolute;top:5px;"><?php echo $view->translate("Payment Method"); ?></div>
                      <div style="font-size:17px;margin:15px 0;text-align:center;"><?php echo $eventOrder->gateway_type; ?></div>
                    </div></td>
                </tr>
                <?php
                	if($orderDetail->registration_number) {
                    $fileName = $orderDetail->getType().'_'.$orderDetail->getIdentity().'.png';
                    if(!file_exists(APPLICATION_PATH . DIRECTORY_SEPARATOR . 'public/sesevent_qrcode/'.$fileName)){ 
                      $fileName = Engine_Api::_()->sesevent()->generateQrCode($orderDetail->registration_number,$fileName);
                    } else{ 
                      $fileName = ( isset($_SERVER["HTTPS"]) && (strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] .Zend_Registry::get('StaticBaseUrl') .'/public/sesevent_qrcode/'.$fileName;
                    }
                  }else
                    $qrCode = '';
                   if(isset($fileName)){
                ?>
                <tr>
                  <td style="display:block;float:left;position:relative;text-align:center;width:100%;padding-top:20px;height:150px;"><img alt="5ef46426" src="<?php echo $fileName; ?>" style="max-width:100px;" /></td>
                </tr>
               <?php } ?>
              </table>
            </div></td>
        </tr>
      </table></td>
  </tr>
 <?php if($event->ticket_logo || $event->logo_description){ ?>  
  <tr>
    <td><table cellpadding="0" cellspacing="0" border="0" style="font:normal 13px Arial,Helvetica,sans-serif;">
        <tr>
        <?php if($event->logo_description){?>
          <td> <?php echo $event->logo_description; ?> </td>
        <?php } ?>
          <?php if($event->ticket_logo){
             $img_path = Engine_Api::_()->storage()->get($event->ticket_logo, '')->getPhotoUrl();
             if(strpos($img_path,'http') === FALSE)
              $path = 'http://' . $_SERVER['HTTP_HOST'] . $img_path;
             else
              $path = $img_path;
         ?>
          <td style="width:238px;"><img alt="" src="<?php echo $path; ?>" style="max-width:100px;" /></td>
         <?php } ?>
        </tr>
      </table></td>
  </tr>
<?php } ?>

</table>
</span>
</body>
</html>