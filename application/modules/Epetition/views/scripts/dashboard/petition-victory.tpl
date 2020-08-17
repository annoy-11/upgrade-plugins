<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: petition-victory.tpl 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php
echo $this->partial('dashboard/left-bar.tpl', 'epetition', array(
  'petition' => $this->petition,
));

?>
<?php if (isset($this->status)) { ?>

    <h2><?php  $this->translate("Please click the button for victory"); ?></h2>
    <button id="victory"><?php  echo $this->translate("Victory"); ?></button>

<?php } else { ?>

    <h2><?php echo $this->message; ?></h2>

<?php } ?>

<script>
    sesJqueryObject('#victory').click(function () {
        if(confirm('Are you sure? Do you want to add this petition victory'))
        {
            var url=en4.core.baseUrl+"petitions/dashboard/victory/<?php echo $this->petition['custom_url']; ?>";
            sesJqueryObject.ajax({
                url: url,
                type: "POST",
                data: {id : '<?php echo $this->petition['epetition_id']; ?>'},
                dataType: "json",
                success: function(html)
                {
                    if(html['status'])
                    {
                        alert(html['msg']);
                        location.reload();
                    }
                }
            });

        }
    });
</script>
