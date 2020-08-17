<?php

?>

<?php include APPLICATION_PATH .  '/application/modules/Sesevent/views/scripts/dismiss_message.tpl';?>
<div class='clear'>
	<?php if( $this->form ): ?>
	  <div class="settings sesbasic_admin_form">
	    <?php echo $this->form->render($this) ?>
	  </div>
	<?php else: ?>
	  <div class="tip">
	    Your message has been queued for sending.
	  </div>
	<?php endif; ?>
</div>