<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<div class="eclassroom_opningtime_block">
	<div class="_timezone"><?php echo $this->result->timezone;?></div>
  <?php
    if($this->data != ""){ ?>
    <div class="_text" style="color:<?php echo $this->color; ?>">
      <strong><?php  echo $this->data; ?></strong>
    </div>
  <?php }else{ ?>
    <div class="openHours opningtime">
      <?php echo $this->hours ; ?>
    </div>
  <?php } ?>
</div>
<script type="text/javascript">
sesJqueryObject(document).ready(function(){
    sesJqueryObject(".opningtime").click(function(){
        sesJqueryObject(".opningtime").toggleClass("showall");
    });
});
</script>
