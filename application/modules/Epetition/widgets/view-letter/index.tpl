<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php echo $this->letter; ?>

<?php
if(isset($this->decisionmakers) && !empty($this->decisionmakers)) {  ?>
  <button class="button" onclick="approve('<?php echo $this->decisionmakers; ?>',2)"><?php echo $this->translate('Approve'); ?></button>
  <button class="button" onclick="approve('<?php echo $this->decisionmakers; ?>',3)"><?php echo $this->translate('Cancel'); ?></button>
<?php } ?>
<script>
  function approve(id,type) {
      if(confirm('Are you sure?'))
      {   var url = en4.core.baseUrl + "epetition/index/approveletter";
          sesJqueryObject.ajax({
              url: url,
              type: "POST",
              data: {id : id, type : type},
              dataType: "json",
              success: function(html) {
                  if (html['status']) {
                      sesJqueryObject(".button").remove();
                      alert(html['msg']);
                  }
                  else
                  {
                      alert(html['msg']);
                  }
              }
          });
      }
  }
</script>
