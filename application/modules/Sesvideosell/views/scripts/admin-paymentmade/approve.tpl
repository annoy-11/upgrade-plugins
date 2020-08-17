<?php

?>
<?php if(!$this->disable_gateway){ ?>
<div class=''>
  <div class='settings'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<?php }else{?>
	  <div class="tip">
    <span>
      <?php echo $this->translate("Video Owner has not enabled the payment gateway.") ?>
    </span>
  </div>
<?php } ?>
