<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescommunityads
 * @package    Sescommunityads
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: create.tpl  2018-10-09 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php include APPLICATION_PATH .  '/application/modules/Sescommunityads/views/scripts/dismiss_message.tpl';?>
<div class="sesbasic_search_reasult">
	<a href="admin/sescommunityads/package/manage" class="sesbasic_icon_back buttonlink">Back to Manage Packages</a></div>
<div class="settings sesbasic_admin_form">
  <?php echo $this->form->render($this) ?>
</div>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>
<script type="application/javascript">
sesJqueryObject('#click_type').change(function(e){
    var value = sesJqueryObject(this).val();
   sesJqueryObject('#click_limit-label').find('.optional').html(sesJqueryObject('#click_type').attr('data-title-'+value)); 
   sesJqueryObject('#click_limit-element').find('.description').html(sesJqueryObject('#click_type').attr('data-description-'+value));  
   if(sesJqueryObject('#package_type').val() == 'recurring' && value == "perday"){
      sesJqueryObject('#click_limit-wrapper').hide();
   }else
    sesJqueryObject('#click_limit-wrapper').show(); 
});
sesJqueryObject('#click_type').trigger('change');
sesJqueryObject('#is_renew_link').change(function(e){
  var value = sesJqueryObject(this).val();
  if(value == 1)
    sesJqueryObject('#renew_link_days-wrapper').show();
  else
      sesJqueryObject('#renew_link_days-wrapper').hide();
});
sesJqueryObject('#is_renew_link').trigger('change');

sesJqueryObject('#package_type').change(function(e){
  var value = sesJqueryObject(this).val();
  if(value == "recurring"){
    sesJqueryObject('#is_renew_link-wrapper').hide();
    sesJqueryObject('#renew_link_days-wrapper').hide();
    sesJqueryObject('#duration-wrapper').show();
    sesJqueryObject('#recurrence-wrapper').show();
  }else{
    sesJqueryObject('#is_renew_link-wrapper').show();
    if(sesJqueryObject('#is_renew_link').val() == 1)
    sesJqueryObject('#renew_link_days-wrapper').show();
    sesJqueryObject('#duration-wrapper').hide();
    sesJqueryObject('#recurrence-wrapper').hide();
  }  
  if(sesJqueryObject('#package_type').val() == 'recurring' && sesJqueryObject('#click_type').val() == "perday"){
      sesJqueryObject('#click_limit-wrapper').hide();
   }else
    sesJqueryObject('#click_limit-wrapper').show();   
})
sesJqueryObject('#package_type').trigger('change');

function sponsored(){
  var isSponsored = sesJqueryObject('#sponsored').is(':checked');
  if(isSponsored){
    sesJqueryObject('#sponsored_days-wrapper').show();
  }else{
    sesJqueryObject('#sponsored_days-wrapper').hide(); 
  }  
}
sponsored();
sesJqueryObject('#sponsored').click(function(e){
  sponsored();
});

function featred(){
  var isfeatured = sesJqueryObject('#featured').is(':checked');
  if(isfeatured){
    sesJqueryObject('#featured_days-wrapper').show();
  }else{
    sesJqueryObject('#featured_days-wrapper').hide(); 
  }  
}
featred();
sesJqueryObject('#featured').click(function(e){
  featred();
});
sesJqueryObject('.global_form').submit(function(e){
  if(sesJqueryObject('#package_type').val() == "nonRecurring"){
    sesJqueryObject('#duration-select').val('forever');
    sesJqueryObject('#recurrence-text').val('1');  
  }  
  return true;
})
</script>