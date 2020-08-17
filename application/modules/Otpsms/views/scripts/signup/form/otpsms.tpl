<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Otpsms
 * @package    Otpsms
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: otpsms.tpl  2018-11-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php echo $this->form->render($this) ?>
<?php $skip = new Zend_Session_Namespace('Otpsms_SkipEnable');
if($skip->skip):?>
<script type="text/javascript">
    document.getElementById("otpsms_signup_verify").submit();
</script>
<?php endif; ?>
<script type="text/javascript">
//<![CDATA[
    var resendHTML;
    function resendOtpCode(){
      if(sesJqueryObject('#resend').hasClass('active'))
        return;
      sesJqueryObject('#resend').addClass('active');
      resendHTML = sesJqueryObject('#resend').html();
      new Request.JSON({
          url: "<?php echo $this->url(array('module' => 'otpsms', 'controller' => 'index', 'action' => 'verify-code'), 'default', true); ?>",
          method: 'post',
          data: {
            format: 'json',
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