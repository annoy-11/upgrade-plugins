
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Estore/externals/styles/style_dashboard.css'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/datepicker/bootstrap-datepicker.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery1.11.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/datepicker/jquery.timepicker.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/datepicker/bootstrap-datepicker.js'); ?>
<?php $baseURL = $this->layout()->staticBaseUrl; ?>

<script type="text/javascript">
var currentOrder = '<?php echo $this->order ?>';
var currentOrderDirection = '<?php echo $this->order_direction ?>';
var changeOrder = function(order, default_direction){
  // Just change direction
  if( order == currentOrder ) {
    $('order_direction').value = ( currentOrderDirection == 'ASC' ? 'DESC' : 'ASC' );
  } else {
    $('order').value = order;
    $('order_direction').value = default_direction;
  }
  $('filter_form').submit();
}
</script>

<script type="text/javascript">

  function multiDelete() {
    return confirm("<?php echo $this->translate('Are you sure you want to delete the selected reviews?');?>");
  }

  function selectAll() {
    var i;
    var multidelete_form = $('multidelete_form');
    var inputs = multidelete_form.elements;
    for (i = 1; i < inputs.length; i++) {
      if (!inputs[i].disabled) {
        inputs[i].checked = inputs[0].checked;
      }
    }
  }
    
</script>
<?php if(!$this->is_ajax && !$this->is_search_ajax){ ?>
<div class="estore_dashboard_search_form estore_browse_search estore_browse_search_horizontal sesbasic_clearfix sesbasic_bxs"><?php echo $this->searchForm->render($this); ?></div>
	<div class="estore_dashboard_table sesbasic_bxs">
<?php } ?>
  <form id='multidelete_form' method="post">
    <table>
      <thead>
        <tr>
          <th class='admin_table_short'><input onclick='selectAll();' type='checkbox' class='checkbox' /></th>
          <th class="centerT"><?php echo $this->translate("ID"); ?></th>
          <th><?php echo $this->translate("Total Item") ?></th>
           <th><?php echo $this->translate("Total Amount") ?></th>
           <th><?php echo $this->translate("shipping cost") ?></th>
          <th><?php echo $this->translate("Owner") ?></th>
          <th><?php echo $this->translate("Gateway Type") ?></th>
          <th><?php echo $this->translate("Status") ?></th>
           <th><?php echo $this->translate("Order Date") ?></th>
          <th><?php echo $this->translate("Options") ?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($this->paginator as $item): ?>
        <tr id="order_id_<?php echo $item->order_id; ?>">
         <td><input type='checkbox' class='checkbox' name='delete_<?php echo $item->order_id;?>' value="<?php echo $item->order_id; ?>" /></td>
        	<?php $store = Engine_Api::_()->getItem("stores", $item->store_id); ?>
          <td class="centerT">
          	<a class="openSmoothbox" href="<?php echo $this->url(array('store_id' => $store->custom_url,'action'=>'view','order_id'=>$item->order_id), 'estore_order', true); ?>"><?php echo '#'.$item->order_id ?></a></td>
          <td><?php echo $item->item_count; ?></td>
          <td><?php echo $item->total; ?></td>
          <td><?php echo $item->total_shippingtax_cost; ?></td>
          <td>
              <?php $user = Engine_Api::_()->getItem('user',$item->user_id) ?>
              <a href="<?php echo $user->getHref(); ?>"><?php echo $user->getTitle(); ?></a>
          </td>
          <td><?php echo $item->gateway_type; ?></td> 
          <td><?php echo $item->state; ?></td> 
          <td><?php echo $item->creation_date; ?></td> 
          <td class="table_options">
            <?php echo $this->htmlLink($this->url(array('store_id' => $store->custom_url,'action'=>'view','order_id'=>$item->order_id), 'estore_order', true).'?order=view', $this->translate("View Order"), array('class' => 'openSmoothbox estore_basicbtn fa fa-eye')); ?>
            <?php echo $this->htmlLink($this->url(array('action' => 'view', 'order_id' => $item->order_id, 'store_id' => $store->custom_url,'format'=>'smoothbox'), 'estore_order', true), $this->translate("Print Invoice"), array('class' => 'estore_basicbtn fa fa-print','target'=>'_blank')); ?>
             <a href="javascript:void(0);" onclick="deleteOrder('<?php echo $item->order_id; ?>')" id="order_<?php echo $item->order_id; ?>"><?php echo $this->translate("Delete"); ?></a>
          </td>
          
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table><br/>
     <div class='buttons'>
				      <button type='submit'><?php echo $this->translate("Delete Selected") ?></button>
    </div>
   </form>
<?php if(!$this->is_ajax && !$this->is_search_ajax){ ?>
	</div>
</div>
<?php  } ?>
<style>
#date-date_from,
#date-date_to{ display:block !important;}
</style>
<script type="application/javascript">
var requestPagging;
function paggingNumbermanage_order(pageNum){
	 sesJqueryObject('.sesbasic_loading_cont_overlay').css('display','block');
	 var searchFormData = sesJqueryObject('#sesevent_search_ticket_search').serialize();
		requestPagging= (new Request.HTML({
			method: 'post',
			'url': en4.core.baseUrl + "estore/dashboard/manage-orders",
			'data': {
				format: 'html',
				searchParams :searchFormData, 
				is_search_ajax:true,
				is_ajax : 1,
				page:pageNum,
			},
			onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
				sesJqueryObject('.sesbasic_loading_cont_overlay').css('display','none');
				sesJqueryObject('.estore_dashboard_content').html(responseHTML);
			}
		}));
		requestPagging.send();
		return false;
}
</script>
<script type="application/javascript">
function executeAfterLoad(){
	if(!sesBasicAutoScroll('#date-date_to').length )
		return;
	var FromEndDateOrder;
	var selectedDateOrder =  new Date(sesBasicAutoScroll('#date-date_to').val());
	sesBasicAutoScroll('#date-date_to').datepicker({
			format: 'yyyy-m-d',
			weekStart: 1,
			autoclose: true,
			endDate: FromEndDateOrder, 
	}).on('changeDate', function(ev){
		selectedDateOrder = ev.date;	
		sesBasicAutoScroll('#date-date_from').datepicker('setStartDate', selectedDateOrder);
	});
	sesBasicAutoScroll('#date-date_from').datepicker({
			format: 'yyyy-m-d',
			weekStart: 1,
			autoclose: true,
			startDate: selectedDateOrder,
	}).on('changeDate', function(ev){
		FromEndDateOrder	= ev.date;	
		 sesBasicAutoScroll('#date-date_to').datepicker('setEndDate', FromEndDateOrder);
	});	
}
executeAfterLoad();
sesJqueryObject(document).on('click','.sesevent_search_ticket_search',function(e){
	e.preventDefault();
	sendParamInSearch = sesJqueryObject(this).attr('data-rel');
	sesJqueryObject('#sesevent_search_ticket_search').trigger('click');
});

sesJqueryObject('#loadingimgestore-wrapper').hide();
 sesJqueryObject(document).on('submit','#manage_order_search_form',function(event){
	event.preventDefault();
	var searchFormData = sesJqueryObject(this).serialize();
	sesJqueryObject('#loadingimgestore-wrapper').show();
	new Request.HTML({
			method: 'post',
			url :  en4.core.baseUrl + 'estore/manage/my-order/',
			data : {
				format : 'html',
				searchParams :searchFormData, 
				is_search_ajax:true,
			},
			onComplete: function(response) {
				sesJqueryObject('#loadingimgestore-wrapper').hide();
				sesJqueryObject('.estore_dashboard_table').html(response);
			}
	}).send();
});

function deleteOrder(order_id){
var confirmDelete = confirm('Are you sure you want to delete?');
if(confirmDelete){
sesJqueryObject("#order_"+order_id).html('<img src="application/modules/Core/externals/images/loading.gif" alt="Loading" />');
	new Request.HTML({
			method: 'post',
			url :  en4.core.baseUrl + 'estore/manage/my-order/',
			data : {
				format : 'html',
				order_id :order_id, 
				is_ajax:true,
			},
			onComplete: function(responseTree, responseElements, responseHTML, responseJavaScript) {
				var obj = jQuery.parseJSON(responseHTML);
        if(obj.status == "1"){ 
           sesJqueryObject("#order_id_"+order_id).remove();
        } else {
           sesJqueryObject("#order_"+order_id).html("Delete"); 
        }
			}
	}).send();
}
}
</script>
<?php if($this->is_ajax || $this->is_search_ajax) die; ?>
