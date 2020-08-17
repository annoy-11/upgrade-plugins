<?php

?>
<div class="tip">
  <span>
    <?php if($this->package->message) { ?> 
      <?php echo $this->translate($this->package->message); ?>
    <?php } else { ?>
      <?php echo $this->translate($this->adminMessage); ?>
    <?php } ?>
  </span>
</div>