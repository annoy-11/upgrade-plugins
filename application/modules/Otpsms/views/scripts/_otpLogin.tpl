<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Otpsms
 * @package    Otpsms
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _otpLogin.tpl  2018-11-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<div id="otp-wrapper" class="form-wrapper">
  <div id="otp-label" class="form-label"></div>
  <div id="otp-element" class="form-element sesbasic_clearfix">
    <span class="sesbasic_text_light">Or</span> <a href="javascript:void(0);" class="sendOtpsms" onClick="sendOptsms(this,'<?php echo $this->emailFieldName; ?>')">Send OTP</a>
		<img class="_loadingimg" src="application/modules/Core/externals/images/loading.gif" alt="Loading" style="display:none;">
  </div>
</div>
<script type="application/javascript">
function sendOptsms(obj,objName){
  var elem = sesJqueryObject(obj);
  
  var formObject = elem.closest('form');
  var parentElem = elem.closest('.form-elements');
  var emailObj = parentElem.find('#'+objName+'-wrapper').find('#'+objName+'-element').find('#'+objName);
  var value = emailObj.val();
  if(!value || value == ""){
    emailObj.css('border','1px solid red');
    return;
  }
	sesJqueryObject(elem).parent().find('img').show();
  emailObj.css('border','');
  var formData = new FormData(formObject[0]);
  formData.append('emailField',value);
  sesJqueryObject.ajax({
    url:  en4.core.staticBaseUrl+'otpsms/index/login-otp/',
    type: "POST",
    contentType:false,
    processData: false,
		cache: false,
		data: formData,
		success: function(response){
      sesJqueryObject(elem).parent().find('img').hide();
			var data = JSON.parse(response);
      if(data.error == 1){
        //show error
        var html = '<ul class="form-errors"><li><ul class="errors"><li>'+data.message+'</li></ul></li></ul>';
        parentElem.parent().find('.form-errors').remove();
        sesJqueryObject(html).insertBefore(parentElem);
      }else{
        //show form
        sesJqueryObject(formObject).parent().find('.otpsms_form_back').remove();
        sesJqueryObject(formObject).parent().find('#otpsms_signup_verify').remove();
        sesJqueryObject(formObject).hide();
        var dataform = "<div class='otpsms_form_back'><a href='javascript:;' class='otpsms_back_form otpsms_icon_back buttonlink'>back to form</a></div>"+data.form;
        sesJqueryObject(dataform).insertBefore(sesJqueryObject(formObject));
      }
		}
  });
};
sesJqueryObject(document).on('click','.otpsms_back_form',function(e){
  var parentElem = sesJqueryObject(this).parent().parent();
  parentElem.find('.otpsms_form_back').hide();
  parentElem.find('#otpsms_signup_verify, #otpsms_login_verify').hide();
  parentElem.find('.otpsms_login_form, #user_form_login').show();
});
</script>
<script type="text/javascript">
//<![CDATA[
var resendHTML;
function resendLoginData(obj){
  var elem = sesJqueryObject(obj);
  if(elem.hasClass('active'))
    return;
  elem.addClass('active');
  resendHTML = elem.html();
  new Request.JSON({
     url: "<?php echo $this->url(array('module' => 'otpsms', 'controller' => 'index', 'action' => 'resend-login-code'), 'default', true); ?>",
      method: 'post',
      data: {
        user_id:sesJqueryObject(obj).closest('.form-elements').find('#email_data').val(),
        type:'login_template',
        format: 'json',
      },
      onRequest: function(){
        elem.html('<img src="application/modules/Core/externals/images/loading.gif" alt="Loading">');
      },
      onSuccess: function(responseJSON) {
        elem.removeClass('active');
          sesJqueryObject(obj).closest('.form-elements').parent().find('.form-errors').remove();
        if (responseJSON.error == 1) {
            sesJqueryObject(obj).closest('.form-elements').parent().find('.form-description').html('');
          //show error
          var html = '<ul class="form-errors"><li><ul class="errors"><li>'+responseJSON.message+'</li></ul></li></ul>';
          sesJqueryObject(html).insertBefore(sesJqueryObject(obj).closest('.form-elements'));
        }else{
            sesJqueryObject(obj).closest('.form-elements').parent().find('.form-description').html(responseJSON.description);
        }
        elem.html(resendHTML);
      }
    }).send();
}
</script>