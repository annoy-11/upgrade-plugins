<?php include APPLICATION_PATH .  '/application/modules/Sesblog/views/scripts/dismiss_message.tpl';?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/pinboardcomment.js');?>
<div class="settings">
  <?php echo $this->form->render($this) ?>
</div>
<script type="application/javascript">
function showRenewData(value){
	if(value == 1){
		document.getElementById('renew_link_days-wrapper').style.display = 'block';
	}else
		document.getElementById('renew_link_days-wrapper').style.display = 'none';
}
function checkOneTime(value){
	if(value == 'forever'){
		document.getElementById('is_renew_link-wrapper').style.display = 'block';
		document.getElementById('renew_link_days-wrapper').style.display = 'block';
	}else{
		document.getElementById('is_renew_link-wrapper').style.display = 'none';
		document.getElementById('renew_link_days-wrapper').style.display = 'none';
	}
}
document.getElementById("recurrence-select").onclick = function(e){
  var value = this.value;
	checkOneTime(value);
	var value = document.getElementById('is_renew_link').value;
	showRenewData(value);
};
window.addEvent('domready',function(){
	var value = document.getElementById('recurrence-select').value;
	checkOneTime(value);
	var value = document.getElementById('is_renew_link').value;
	showRenewData(value);
});
sesJqueryObject(document).ready(function(){
	checkboxXhecked();
});
function checkboxXhecked(){
	var elem = sesJqueryObject('.moduled-checkbox');
	for(i=0;i<elem.length;i++){
		var id = sesJqueryObject(elem[i]).attr('id').replace('modules-','');
		if(sesJqueryObject(elem[i]).is(":checked")){
			sesJqueryObject('#'+id+'_count-wrapper').show();
		}else{
			sesJqueryObject('#'+id+'_count-wrapper').hide();			
		}
	}	
}
sesJqueryObject('.moduled-checkbox').change(function(e){
	checkboxXhecked();
});
</script>