<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessportz
 * @package    Sessportz
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-04-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sessportz/externals/styles/styles.css'); ?>

<div class="sessportz_footer_newsletter sesbasic_clearfix sesbasic_bxs">
   <div class="sessportz_footer_newsletter_inner" style="background-image:url(<?php echo Engine_Api::_()->sessportz()->getFileUrl($this->bgimage); ?>);">
      <h2><?php echo $this->translate("SIGN UP FOR NEWSLETTER"); ?></h2>
      <p><?php echo $this->translate("Subscribe to our newsletter to get all the latest news and exclusive offers"); ?></p>
     <form>
      <p>
       <input name="email" id="sessportz_newsletter_email" type="email" placeholder="<?php echo $this->translate('Enter Your Email Address'); ?>"/>
       </p>
       <button id="sessportz_newsletter" type="submit">Subscribe</button>
     </forms>
  </div>
</div>
<script>
  sesJqueryObject(document).ready(function() {
    sesJqueryObject("#sessportz_newsletter_email").click(function(e) {
      e.preventDefault();
      var sesatoz_newsletter_email = sesJqueryObject('#sessportz_newsletter_email').val();
      if(sesatoz_newsletter_email)
        sendNewsletter();
    });
    
    sesJqueryObject('#sessportz_newsletter_email').keydown(function(e) {
      if (e.which === 13) {
        sendNewsletter();
      }
    });
  });
  
  function sendNewsletter() {
  
    var newsletteremail = sesJqueryObject('#sessportz_newsletter_email').val();
    if(newsletteremail == '')
      return;
    sesJqueryObject('#sessportz_newsletter_email').val('');
    en4.core.request.send(new Request.JSON({
      url: en4.core.baseUrl + 'sessportz/index/newsletter',
      data: {
        format: 'json',
        'email': newsletteremail,
      },
      onSuccess: function(responseJSON) {
        if(responseJSON.newsletteremail_id) {
          //location.reload();
        }
      }
    }));
  
  }
</script>
