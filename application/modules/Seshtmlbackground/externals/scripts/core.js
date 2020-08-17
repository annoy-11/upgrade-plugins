sesJqueryObject(document).on('click','.seshtmlbackground_pln_btn',function(e){
	var dataid = sesJqueryObject(this).attr('data-url');
	console.log(dataid);
	sesJqueryObject('#login_seshtml_btn_'+dataid).removeClass('active');
	sesJqueryObject('#signup_seshtml_btn_'+dataid).removeClass('active');
	sesJqueryObject(this).addClass('active');
	var elemid = sesJqueryObject(this).attr('id');
	elemid = elemid.replace('_'+dataid,'');
	elemid =  elemid.replace(/_/g,'');
	if(elemid == 'signupseshtmlbtn'){
		elemid = elemid+'_'+dataid;
		sesJqueryObject('.'+elemid).show();
        sesJqueryObject('#signup_account_form').show();
		sesJqueryObject('.loginseshtmlbtn_'+dataid).hide();
	}else{
		elemid = elemid+'_'+dataid;
		sesJqueryObject('.'+elemid).show();
		sesJqueryObject('.signupseshtmlbtn_'+dataid).hide();
		sesJqueryObject('#signup_account_form').hide();
	}
});