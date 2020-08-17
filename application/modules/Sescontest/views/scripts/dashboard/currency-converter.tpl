<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sescontest/externals/styles/styles.css'); ?>
<div class="sescontest_currency_converter_popup">
	<?php echo $this->form->render() ?>
</div>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl .'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>

<script type="application/javascript">
sesJqueryObject ('#converter_price-wrapper').hide();

sesJqueryObject (document).on('submit','#sescontest_currency_converter',function(e){
		e.preventDefault();
		
		if(sesJqueryObject('#main_price').val() == ''){
				sesJqueryObject('#main_price').css('border','1px solid red');
				return false;
		}else{
				sesJqueryObject('#main_price').css('border','');
		}
		sesJqueryObject('#sesbasic_loading_cont_overlay_con').show();
		new Request.JSON({
      method: 'post',
      url : sesJqueryObject(this).attr('action'),
      data : {
        format : 'json',
				curr:sesJqueryObject('#currency').val(),
				val:sesJqueryObject('#main_price').val(),
				is_ajax:true,
      },
      onComplete: function(response) {
				sesJqueryObject('#sesbasic_loading_cont_overlay_con').hide();
				sesJqueryObject('#converter_price-wrapper').show();
				sesJqueryObject('#converter_price').val(response);
			}
    }).send();
});
</script>