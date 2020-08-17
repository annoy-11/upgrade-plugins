<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Otpsms
 * @package    Otpsms
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: verify.tpl  2018-11-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<!-- Login Form -->
<?php echo $this->form->render($this) ?>

<script type="text/javascript">
function sendLoginOptsms(obj,objName){
  
  var obj = sesJqueryObject(obj).closest('form');;
  console.log(sesJqueryObject(obj).find('.form-elements'));
  var value = sesJqueryObject(obj).find('.form-elements').find('#code-wrapper').find('#code-element').find('#code').val();
  if(!value || value == ""){
      sesJqueryObject(obj).find('.form-elements').find('#code-wrapper').find('#code-element').find('#code').css('border','1px solid red');
      return;
  }
  sesJqueryObject(obj).find('.form-elements').find('#code-wrapper').find('#code-element').find('#code').css('border','');
  var url = 'otpsms/index/verify-login';
  
  var elem = sesJqueryObject(obj).find('.form-elements').find('#buttons-wrapper').find('#buttons-element').find('#submit');
  otpsmsVerifyText = elem.html();
  if(elem.hasClass('active'))
    return;
  elem.addClass('active');
  resendHTML = elem.html();
  new Request.JSON({
   url: url,
    method: 'post',
    data: {
      user_id:<?php echo $this->user_id; ?>,
      code:sesJqueryObject(obj).find('.form-elements').find('#code-wrapper').find('#code-element').find('#code').val(),
      type:'login_template',
      format: 'json',
    },
    onRequest: function(){
      elem.html('<img src="application/modules/Core/externals/images/loading.gif" alt="Loading">');
    },
    onSuccess: function(responseJSON) {
      elem.removeClass('active');
      if (responseJSON.error == 1) {
        //show error
        var html = '<ul class="form-errors"><li><ul class="errors"><li>'+responseJSON.message+'</li></ul></li></ul>';
        sesJqueryObject(obj).find('.form-elements').parent().find('.form-errors').remove();
        sesJqueryObject(html).insertBefore(sesJqueryObject(obj).find('.form-elements'));
      }else{
        window.location.href = responseJSON.url;
        return;  
      }
      elem.html(otpsmsVerifyText);
    }
  }).send();
};
    var resendHTML;
    function resendLoginOtpCode(obj){
      if(sesJqueryObject('#resend').hasClass('active'))
        return;
      sesJqueryObject('#resend').addClass('active');
      resendHTML = sesJqueryObject('#resend').html();
      new Request.JSON({
          url: "<?php echo $this->url(array('module' => 'otpsms', 'controller' => 'index', 'action' => 'resend-login-code'), 'default', true); ?>",
          method: 'post',
          data: {
            format: 'json',
            user_id: "<?php echo $this->user_id; ?>",
          },
          onRequest: function(){
            sesJqueryObject('#resend').html('<img src="application/modules/Core/externals/images/loading.gif" alt="Loading">');
          },
          onSuccess: function(responseJSON) {
            sesJqueryObject('#resend').removeClass('active');
            sesJqueryObject('#resend').html(resendHTML);
            if (responseJSON.error == 1) {
                var html = '<ul class="form-errors"><li><ul class="errors"><li>'+responseJSON.message+'</li></ul></li></ul>';
                sesJqueryObject(obj).closest('form').find('.form-elements').parent().find('.form-errors').remove();
                sesJqueryObject(html).insertBefore(sesJqueryObject(obj).closest('form').find('.form-elements'));
            }else{
                sesJqueryObject(obj).closest('.form-elements').parent().find('.form-description').html(responseJSON.description);
            }
          }
        }).send();
    }
</script>