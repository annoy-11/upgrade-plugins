<?php

?>

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sessocialshare/externals/styles/styles.css'); ?>

<div class="sessocialshare_email_page_wrapper sesbasic_bxs">
  <a title="<?php echo $this->translate('Close'); ?>" class="sessmoothbox_close_btn fa fa-close" href="javascript:void(0);" onclick="window.close()"></a>
  <div id="sessocialshare_email_form">
    <div class="sessocialshare_email_form">
      <div class="sessocialshare_email_cont">
        <h2><?php echo $this->translate("Email a Friend"); ?></h2>
        <p><?php if($this->item) { ?><b><?php echo $this->item->getTitle(); ?></b><span><?php echo ((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $this->item->getHref(); ?></span><?php } else { ?> <b><?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sessocialshare.popsharetitle', 'Share you Content'); ?></b><span><?php echo $this->url; ?></span><?php } ?></p>
      </div>
      <?php echo $this->form->render($this) ?>
      <div class="sesbasic_loading_cont_overlay" id="sessocialshare_loading_cont_overlay"></div>
    </div>
	</div>
</div>

<script type="application/javascript">

  function validateEmail(email) {
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    return emailReg.test( email );
  }

  sesJqueryObject(document).ready(function() {
  
    sesJqueryObject('#sessocialshare_invite').submit(function(e) {
    
      e.preventDefault();
      
      var sender_name = sesJqueryObject('#sender_name').val();
      if(sender_name.length <= 0) {
        alert('Please enter your name.');
        return;
      }
      
      var sender_email = sesJqueryObject('#sender_email').val();
      if(sender_email.length <= 0) {
        alert('Please enter valid your email address.');
        return;
      }
      var sendmeailstr_array = sender_email.split(',');
      for(var i = 0; i < sendmeailstr_array.length; i++) {
        // Trim the excess whitespace.
        sendmeailstr_array[i] = sendmeailstr_array[i].replace(/^\s*/, "").replace(/\s*$/, "");
        // Add additional code here, such as:
        if(validateEmail(sendmeailstr_array[i])) {
      
        } else {
          alert('Please enter valid sender email address.');
          return;
        }
      }

      var subscribe_email = sesJqueryObject('#reciver_emails').val();
      if(subscribe_email.length <= 0) {
        alert('Please enter valid receiver email address.');
        return;
      }
      
      var str_array = subscribe_email.split(',');
      for(var i = 0; i < str_array.length; i++) {
        // Trim the excess whitespace.
        str_array[i] = str_array[i].replace(/^\s*/, "").replace(/\s*$/, "");
        // Add additional code here, such as:
        if(validateEmail(str_array[i])) {
      
        } else {
          alert('Please enter valid receiver email address.');
          return;
        }
      }
      
      var message = sesJqueryObject('#message').val();
      if(message.length <= 0) {
        alert('Please enter note.');
        return;
      }
      
			$('sessocialshare_loading_cont_overlay').style.display='block';
      invitepeoplesessocialshare = new Request.HTML({
        method: 'post',
        'url': en4.core.baseUrl + 'sessocialshare/index/emailsent/',
        'data': {
          format: 'html',    
          params : sesJqueryObject(this).serialize(), 
          resource_type: '<?php echo $this->resource_type ?>',
          resource_id: '<?php echo $this->resource_id ?>',
          url: '<?php echo $this->url ?>',
          is_ajax : 1,
        },
        onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        
          var response = sesJqueryObject.parseJSON( responseHTML );

          if(response.emails_sent) {
						$('sessocialshare_loading_cont_overlay').style.display='none';
            sesJqueryObject('#sessocialshare_invite').fadeOut("slow", function(){
              sesJqueryObject('#sessocialshare_invite').remove();
            });
            document.getElementById('sessocialshare_email_form').innerHTML = "<div class='sessocialshare_email_success_message'><i class='fa fa-check'></i><span>Message sent!</span></div>";
          } else {
						$('sessocialshare_loading_cont_overlay').style.display='none';
            sesJqueryObject('#sessocialshare_invite').fadeOut("slow", function(){
              sesJqueryObject('#sessocialshare_invite').remove();
            });
            document.getElementById('sessocialshare_email_form').innerHTML = "<div class='sessocialshare_email_success_message'><i class='fa fa-check'></i><span>Message sent!</span></div>";
          }
          setTimeout(function() {
            window.close();
          }, 4000 );
        }
      });
      invitepeoplesessocialshare.send();
      return false;
    });
  });
</script>  