<?php ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seslink/externals/styles/styles.css'); ?>
<?php if( $this->form ): ?>
	<div class="seslink_browse_search sesbasic_bxs sesbasic_clearfix <?php if($this->viewType == 'horizontal') { ?> seslink_browse_search_horrizontal<?php } ?>">
  	<?php echo $this->form->render($this) ?>
  </div>
<?php endif ?>
