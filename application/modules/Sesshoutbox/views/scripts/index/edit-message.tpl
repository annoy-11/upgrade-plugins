<?php

?>
<script>
  
  function editMessage(formObject) {
  
    var validationFm = false;
    if(validationFm) {
      
      var input = sesJqueryObject(formObject);
      alert('<?php echo $this->translate("Please fill the red mark fields"); ?>');
      if(typeof objectError != 'undefined') {
        var errorFirstObject = sesJqueryObject(objectError).parent().parent();
          sesJqueryObject('html, body').animate({
          scrollTop: errorFirstObject.offset().top
        }, 2000);
      }
      return false;
    } else {
      submitShoutboxEditMessage(formObject);
    }
  }

  function submitShoutboxEditMessage(formObject) {
  
    var content_id = '<?php echo $this->content_id; ?>';
    sesJqueryObject('#sesshoutbox_message_overlay').show();
    var formData = new FormData(formObject);
    formData.append('is_ajax', 1);
    formData.append('content_id', '<?php echo $this->content_id; ?>');
    //formData.append('message_id', <?php //echo $this->message_id; ?>);
    sesJqueryObject.ajax({
      url: "sesshoutbox/index/edit-message/",
      type: "POST",
      contentType:false,
      processData: false,
      cache: false,
      data: formData,
      success: function(response) {
              
        var result = sesJqueryObject.parseJSON(response);
        if(result.status == 1) {
          
          sesJqueryObject('#sesshoutbox_message_overlay').hide();
          sesJqueryObject('#sessmoothbox_container').html("<div id='messagesuccess_message' class='sesshoutbox_success_message messagesuccess_message'><i class='fa-check-circle-o'></i><span>Your message is successfully added.</span></div>");

          sesJqueryObject('#messagesuccess_message').fadeOut("slow", function(){
            setTimeout(function() {
              sessmoothboxclose();
            }, 1000);
          });
          
          if($('sesshoutbox_message_boy_'+content_id)) {
            sesJqueryObject('#sesshoutbox_message_boy_'+content_id).html(result.message);
          }
        }
      }
    });
  }

</script>
<div class="sesshoutbox_editmsg_form sesshoutbox_edit_message_form">
<div class="sesbasic_loading_cont_overlay" id="sesshoutbox_message_overlay"></div>
<?php if(empty($this->is_ajax)) { ?>
  <?php echo $this->form->render($this);?>
<?php } ?>
</div>
