
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Estore/externals/styles/styles.css'); ?>
<div class="estore_form_popup">
  <?php if(!$this->errorMessage){ ?>
  	<?php echo $this->form->render() ?>
  <?php }else{ ?>
  	<div class="tip">
      <span>
        <?php echo $this->translate($this->message) ?>
      </span>
  	</div>
  <?php } ?>
</div>