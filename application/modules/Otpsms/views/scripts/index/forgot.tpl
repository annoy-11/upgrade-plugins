<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Otpsms
 * @package    Otpsms
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: forgot.tpl  2018-11-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php if( empty($this->codesend) ): ?>
  <?php echo $this->form->render($this) ?>
<?php else: ?>
  <?php if(!empty($this->codesend)){ ?>
  <?php echo $this->formCode->render($this) ?>
  
  <script type="text/javascript">
//<![CDATA[
var submitHTML;
sesJqueryObject(document).on('submit','#otpsms_signup_verify',function(e){
  e.preventDefault();
  if(!sesJqueryObject('#code').val()){
    sesJqueryObject('#code').css('border','1px solid red');
    return;  
  }
  submitHTML = sesJqueryObject('#submit').html();
  sesJqueryObject('#code').css('border','');
  if(sesJqueryObject('#submit').hasClass('active'))
   return;
  sesJqueryObject('#submit').addClass('active');
  new Request.JSON({
      url: "<?php echo $this->url(array('module' => 'otpsms', 'controller' => 'index', 'action' => 'verify-forgot','user_id'=>$this->user_id), 'default', true); ?>",
      method: 'post',
      data: {
        format: 'json',
        value : sesJqueryObject('#code').val(),
      },
      onRequest: function(){
        sesJqueryObject('#submit').html('<img src="application/modules/Core/externals/images/loading.gif" alt="Loading">');
      },
      onSuccess: function(responseJSON) {
        sesJqueryObject('#resend').removeClass('active');
        if (responseJSON.error == 1) {
           sesJqueryObject('#resend').html(submitHTML);
           sesJqueryObject('#code-element').append('<span style="color:red">'+responseJSON.message+'</span>');
        }else{
           window.location.href = responseJSON.url;
        }
      }
    }).send();    
});

var resendHTML;
function resendOtpCode(){
  if(sesJqueryObject('#resend').hasClass('active'))
    return;
  sesJqueryObject('#resend').addClass('active');
  resendHTML = sesJqueryObject('#resend').html();
  new Request.JSON({
      url: "<?php echo $this->url(array('module' => 'otpsms', 'controller' => 'index', 'action' => 'verify-code','type'=>'forgot_template','user_id'=>$this->user_id), 'default', true); ?>",
      method: 'post',
      data: {
        format: 'json',
        'number' : "<?php echo $this->number; ?>",
      },
      onRequest: function(){
        sesJqueryObject('#resend').html('<img src="application/modules/Core/externals/images/loading.gif" alt="Loading">');
      },
      onSuccess: function(responseJSON) {
        sesJqueryObject('#resend').removeClass('active');
        if (responseJSON.message) {
          sesJqueryObject('#resend').html(resendHTML);
        }
      }
    }).send();
}

</script>
  
  
  <?php }else{ ?>
  <div class="tip">
    <span>
      <?php echo $this->translate("USER_VIEWS_SCRIPTS_AUTH_FORGOT_DESCRIPTION") ?>
    </span>
  </div>
  <?php } ?>
<?php endif; ?>
