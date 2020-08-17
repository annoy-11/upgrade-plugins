<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Otpsms
 * @package    Otpsms
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: integration.tpl  2018-11-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php include APPLICATION_PATH .  '/application/modules/Otpsms/views/scripts/dismiss_message.tpl';?>
<h2>3rd Party Services Integration</h2>
<p>Here, you can configure the 3rd party services to enable OTP signup and login on your website. You can also enable or disable any service anytime.</p>
<br>

<table class="admin_table" style="width: 100%;">
  <thead>
    <tr>
      <th align="left" style="width: 50%;">Title</th>
      <th align="center" class="center" style="width: 25%;">Status</th>
      <th align="left" style="width: 25%;">Options</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td align="left" style="width: 50%;">Amazon</td>
      <td class="admin_table_centered" style="width: 25%;">
        <a href="<?php echo $this->url(array('module'=>'otpsms','controller'=>'settings','action'=>'enable-service','type'=>'amazon'),'admin_default',true); ?>">
          <?php if($this->enabledService == "amazon"){ ?>
            <img src="application/modules/Sesbasic/externals/images/icons/check.png" alt="" title="Disable">
          <?php }else{ ?>
            <img src="application/modules/Sesbasic/externals/images/icons/error.png" alt="" title="Enable">
          <?php  } ?>
        </a>
      </td>
      <td align="left" style="width: 25%;">
        <a href="<?php echo $this->url(array('module'=>'otpsms','controller'=>'settings','action'=>'amazon'),'admin_default',true); ?>"> Edit </a>
     </td>
    </tr>
    <tr>
      <td align="left" style="width: 50%;">Twilio</td>
      <td class="admin_table_centered" style="width: 25%;">
        <a href="<?php echo $this->url(array('module'=>'otpsms','controller'=>'settings','action'=>'enable-service','type'=>'twilio'),'admin_default',true); ?>">
          <?php if($this->enabledService == "twilio"){ ?>
            <img src="application/modules/Sesbasic/externals/images/icons/check.png" alt="" title="Disable">
          <?php }else{ ?>
            <img src="application/modules/Sesbasic/externals/images/icons/error.png" alt="" title="Enable">
          <?php  } ?>
        </a>
      </td>
      <td align="left" style="width: 25%;">
        <a href="<?php echo $this->url(array('module'=>'otpsms','controller'=>'settings','action'=>'twilio'),'admin_default',true); ?>"> Edit </a>
      </td>
    </tr>
  </tbody>
</table>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>
