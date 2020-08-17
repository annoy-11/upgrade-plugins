<?php

?>
<script type="application/javascript">

sesJqueryObject(document).on('submit','#manage_order_search_form',function(event) {
	if(sesJqueryObject('#manage_order_search_form').hasClass('transaction_form_box')){
		var widgetName = 'manage-transactions';	
	} else if(sesJqueryObject('#manage_order_search_form').hasClass('search_ticket')){
		var widgetName = 'search-ticket';	
	} else if(sesJqueryObject('#manage_order_search_form').hasClass('subscribers_form_box')){
		var widgetName = 'manage-subscribers';	
	} else
    var widgetName = 'manage-orders';
    
	event.preventDefault();
	var searchFormData = sesJqueryObject(this).serialize();
	sesJqueryObject('#loadingimgsesevent-wrapper').show();
	
	if(widgetName == 'manage-subscribers') {
    var url = en4.core.baseUrl + 'widget/index/mod/sesmembersubscription/name/'+widgetName;
	} else {
    var url = en4.core.baseUrl + 'widget/index/mod/sespaymentapi/name/'+widgetName;
	}
	
	new Request.HTML({
			method: 'post',
			url : url,
			data : {
				format : 'html',
				user_id:'<?php echo $this->user_id ? $this->user_id : $this->user->getIdentity(); ?>',
				searchParams :searchFormData, 
				is_search_ajax:true,
			},
			onComplete: function(response) {
				sesJqueryObject('#loadingimgsesevent-wrapper').hide();
				sesJqueryObject('#sesevent_manage_order_content').html(response);
			}
	}).send();
});

</script>