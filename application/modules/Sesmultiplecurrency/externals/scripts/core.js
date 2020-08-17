
sesJqueryObject(document).on('click','#sesmultiplecurrency_btn_currency',function(){
	if(sesJqueryObject(this).hasClass('active')){
		sesJqueryObject(this).removeClass('active');
		sesJqueryObject('#sesmultiplecurrency_currency_change').hide();
	}else{
		sesJqueryObject(this).addClass('active');
		sesJqueryObject('#sesmultiplecurrency_currency_change').show();	
	}
});
//currency change
sesJqueryObject(document).on('click','ul#sesmultiplecurrency_currency_change_data li > a',function(){
	var currencyId = sesJqueryObject(this).attr('data-rel');
	setSesCookie('sesmultiplecurrency_currencyId',currencyId,365);
	location.reload();
});
function setSesCookie(cname, cvalue, exdays) {
	var d = new Date();
	d.setTime(d.getTime() + (exdays*24*60*60*1000));
	var expires = "expires="+d.toGMTString();
	document.cookie = cname + "=" + cvalue + "; " + expires+';path=/;';
} 