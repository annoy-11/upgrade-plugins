<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Emessages
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: editmessage.tpl 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>

<div class="emessages_popup sesbasic_bxs">
  <?php echo $this->form->setAttrib('class', 'emessages_popup_form')->render($this) ?>
</div>
<script type="application/javascript">
    en4.core.runonce.add(function() {
    sesJqueryObject("#message_text").attr('required','required');

	sesJqueryObject("#editmessageform").submit(function () {
        var text=sesJqueryObject("#message_text").val();
        if(text.length<1){ alert("Message Can not be blank"); return  false;  }
        sesJqueryObject.ajax({
            url: en4.core.baseUrl + 'emessages/messages/editmessagetext',
            dataType: 'text',
            data: {message_id: '<?php echo $this->message_id; ?>', message_text: text,},
            type: 'post',
            success: function(html){
                var arrays=jQuery.parseJSON( html);
                if(arrays['status']==1)
                {
                    parent.location.reload();
                    javascript:sessmoothboxclose();
                }
            }
        });
      return false;

    });
    });

</script>
