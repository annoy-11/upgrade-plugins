<?php

?>
<div class="headline">
  <h2><?php echo $this->translate('Wishes');?></h2>
  <?php if( count($this->navigation) > 0 ): ?>
    <div class="tabs">
      <?php  echo $this->navigation()->menu()->setContainer($this->navigation)->render();
      ?>
    </div>
  <?php endif; ?>
</div>