<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Emessages
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: changegroupname.tpl 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<div class="emessages_popup sesbasic_bxs">
  <?php echo $this->form->setAttrib('class', 'emessages_popup_form')->render($this) ?>
</div>
<script type="application/javascript">
    en4.core.runonce.add(function() {
    sesJqueryObject("#grouptitle").attr('required','required');
	sesJqueryObject("#grouptitle").val('<?php echo $this->groupname; ?>');
	sesJqueryObject("#groupimage").attr('accept','image/*');
	sesJqueryObject("#changegroupnameform").submit(function () {
        var file_data = sesJqueryObject('#groupimage').prop('files')[0];
        var form_data = new FormData();
        form_data.append('file', file_data);
        form_data.append('grouptitle',sesJqueryObject("#grouptitle").val());
        form_data.append('groupid','<?php echo $this->groupid;  ?>');
        sesJqueryObject.ajax({
            url: en4.core.baseUrl + 'emessages/messages/changegroupnameandimage',
            dataType: 'text',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
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
