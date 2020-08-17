<?php include APPLICATION_PATH .  '/application/modules/Sesblog/views/scripts/dismiss_message.tpl';?>
<div class="settings">
  <?php echo $this->form->render($this) ?>
</div>

<script type="application/javascript">

function enable_package(value){
		if(value == 1){
			document.getElementById('sesblogpackage_package_info-wrapper').style.display = 'block';	
			document.getElementById('sesblogpackage_payment_mod_enable-wrapper').style.display = 'block';	
		}else{
			document.getElementById('sesblogpackage_package_info-wrapper').style.display = 'none';	
			document.getElementById('sesblogpackage_payment_mod_enable-wrapper').style.display = 'none';		
		}
}
enable_package(document.getElementById('sesblogpackage_enable_package').value);
</script>
