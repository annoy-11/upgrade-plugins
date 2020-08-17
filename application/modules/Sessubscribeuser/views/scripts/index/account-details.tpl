<?php

?>
<div class="headline">
  <h2>
    <?php echo $this->translate('Edit My Profile');?>
  </h2>
  <div class="tabs">
    <?php
      // Render the menu
      echo $this->navigation()
        ->menu()
        ->setContainer($this->navigation)
        ->render();
    ?>
  </div>
</div>
<div class="settings">
  <?php echo $this->form->render($this) ?>
</div>
