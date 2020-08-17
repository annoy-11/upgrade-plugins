<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Otpsms
 * @package    Otpsms
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-11-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Otpsms/views/scripts/dismiss_message.tpl';?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>
<script type="application/javascript">

sesJqueryObject(document).on('change','#type',function(){
	sesJqueryObject(this).closest('form').trigger('submit');
})
</script>
<div class='settings'>
  <form class="global_form">
    <div>
      <h3><?php echo $this->translate("Statistics") ?> </h3>
      <p class="description">
        <?php echo $this->translate("Below are some valuable statistics for the OTPs generated on your website:"); ?>
      </p>
		<div>
			3rd Party Service: 
		  <form method="get">
			 <select name="type"  id="type">
			   <option value="twilio" <?php if($this->service == "twilio") { echo "selected";} ?>>Twilio</option>
			   <option value="amazon" <?php if($this->service == "amazon") { echo "selected";} ?>>Amazon</option>
			 </select>
		  </form>
		</div>
		<br>
      <table class='admin_table' style="width: 50%;">
        <tbody>
          <tr>
            <td><strong class="bold"><?php echo "SMSes sent by Admin:" ?></strong></td>
            <td><?php echo $this->admin ? $this->admin : 0; ?></td>
          </tr>
           <tr>
            <td><strong class="bold"><?php echo "SMSes sent for Signup on site:" ?></strong></td>
            <td><?php echo $this->signup_template ? $this->signup_template : 0; ?></td>
          </tr>
            <td><strong class="bold"><?php echo "SMSes sent for Resetting (Forgot) Password on site: " ?></strong></td>
            <td><?php echo $this->forgot_template ? $this->forgot_template : 0; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "SMSes sent for Editing Phone Number on site:" ?></strong></td>
            <td><?php echo $this->edit_number_template ? $this->edit_number_template : 0; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "SMSes sent for Adding New Phone Number on site:" ?></strong></td>
            <td><?php echo $this->add_number_template ? $this->add_number_template : 0; ?></td>
          </tr>
		  <tr>
            <td><strong class="bold"><?php echo "SMSes sent for Login on site:" ?></strong></td>
            <td><?php echo $this->login_template ? $this->login_template : 0; ?></td>
          </tr>
          <tr>
          
        </tbody>
      </table>
    </div>
  </form>
</div>