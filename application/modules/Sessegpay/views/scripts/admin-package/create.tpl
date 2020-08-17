<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessegpay
 * @package    Sessegpay
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: create.tpl  2019-02-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sessegpay/views/scripts/dismiss_message.tpl';?>
<h2>
  <?php echo $this->translate("Create Subscriptions") ?>
</h2>

<p>
  <?php echo $this->translate("") ?>
</p>
<br />

<div class="sesbasic_search_reasult">
	<a href="admin/sessegpay/package/plans" class="sesbasic_icon_back buttonlink">Back to Manage Subscription</a></div>

<br />
<div class="settings">
  <?php echo $this->form->render($this) ?>
</div>
<?php 
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>

<script type="application/javascript">
  sesJqueryObject('#type').change(function(e){
    var value = sesJqueryObject(this).val();
    if(value == 1){
       var type = "block";
       sesJqueryObject('#price-wrapper').css('display','none');
    }else{
      var type = "none";
      sesJqueryObject('#price-wrapper').css('display','block');
    }
    sesJqueryObject('#initial_price-wrapper').css('display',type);
    sesJqueryObject('#initial_length-wrapper').css('display',type);
    sesJqueryObject('#recurring_price-wrapper').css('display',type);
    sesJqueryObject('#recurring_length-wrapper').css('display',type);
    
    
  });
sesJqueryObject('#type').trigger('change');
</script>