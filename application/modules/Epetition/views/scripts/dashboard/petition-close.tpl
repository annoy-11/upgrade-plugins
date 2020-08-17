<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: petition-close.tpl 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>

<?php echo $this->partial('dashboard/left-bar.tpl', 'epetition', array('petition' => $this->petition)); ?>
<div class="sesbasic_dashboard_content sesbm sesbasic_clearfix">
<?php if (!$this->petition['victory']) { ?>
     <p><?php echo $this->translate("Are you sure to close this Petition? If yes, then click below"); ?></p>
     <br />
    <button id="closepetition"><?php echo $this->translate("Close Petition");?></button>

<?php } else if ($this->petition['victory'] == 1) { ?>

    <h2><?php echo $this->translate("This Petition is victory done.");?></h2>
<?php } else { ?>

    <h2><?php echo $this->translate("This Petition is already close."); ?></h2>
<?php } ?>
</div>
<script>
    sesJqueryObject("#closepetition").click(function () {
        var url = "<?php echo $this->url(array('action' => 'petition-close', 'epetition_id' => $this->petition->custom_url), 'epetition_dashboard', true); ?>";
        sesJqueryObject.ajax({
            url: url,
            type: "POST",
            data: {id: '<?php echo $this->petition->epetition_id; ?>'},
            dataType: "json",
            success: function (html) {
                if (html['status']) {
                    alert(html['msg']);
                    location.reload();
                } else {
                    alert(html['msg']);
                }
            }
        });
    });
</script>