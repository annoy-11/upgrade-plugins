<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<div class="sesgroup_opningtime_block">
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