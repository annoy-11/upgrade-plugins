<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: petition-letter.tpl 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php if (!$this->is_ajax) {
echo $this->partial('dashboard/left-bar.tpl', 'epetition', array('petition' => $this->petition));
?>
<div class="sesbasic_dashboard_content sesbm sesbasic_clearfix">
  <?php } ?>
    <p><?php echo $this->translate('This letter will be seen by the Decision maker on the Petition Profile page.'); ?></p><br />
  <div class="epetition_edit_location_form sesbasic_dashboard_form sesbm sesbasic_clearfix sesbasic_bxs"><?php echo $this->form->render($this); ?></div>


<script>
    var url = en4.core.baseUrl + "epetition/index/petletterupdate";
    sesJqueryObject("#send").click(function () {
        var epetition_id='<?php echo $this->petition['epetition_id']; ?>';
        if (confirm("Are you sure? Do you want to send for decision maker?")) {
            sesJqueryObject.ajax({
                url: url,
                type: "POST",
                data: {id : epetition_id},
                dataType: "json",
                success: function(html) {
                    if (html['status'])
                    {
                        sesJqueryObject("#send").remove();
                        alert(html['msg']);
                    }
                    else
                    {
                        alert(html['msg']);
                    }
                }
            });
        }
    });
</script>
