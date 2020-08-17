<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesevent
 * @package    Sesevent
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manage-orders.tpl 2016-07-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php if(!$this->is_ajax && !$this->is_search_ajax){ 
 echo $this->partial('dashboard/left-bar.tpl', 'estore', array(
	'store' => $this->store,
      )); ?>
     
	<div class="estore_dashboard_content sesbm sesbasic_clearfix">
	<?php
	 }
?>
    <div class="estore_dashboard_search_form estore_browse_search estore_browse_search_horizontal sesbasic_clearfix sesbasic_bxs"><?php echo $this->searchForm->render($this); ?></div>
	<div class="estore_dashboard_table sesbasic_bxs">
  <form id='multidelete_form' method="post">
    <table>
      <thead>
        <tr>
          <th class="centerT"><?php echo $this->translate("ID"); ?></th>
          <th><?php echo $this->translate("Total Item") ?></th>
           <th><?php echo $this->translate("Total Amount") ?></th>
           <th><?php echo $this->translate("shipping cost") ?></th>
            <th><?php echo $this->translate("Commission") ?></th>
          <th><?php echo $this->translate("Owner") ?></th>
          <th><?php echo $this->translate("Gateway Type") ?></th>
          <th><?php echo $this->translate("Status") ?></th>
           <th><?php echo $this->translate("Order Date") ?></th>
          <th><?php echo $this->translate("Options ") ?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($this->paginator as $item):?>
        <tr>
        	<?php $store = Engine_Api::_()->getItem("stores", $item->store_id); ?>
          <td class="centerT">
          	<a class="openSmoothbox" href="<?php echo $this->url(array('store_id' => $store->custom_url,'action'=>'view','order_id'=>$item->order_id), 'estore_order', true).'?order=view'; ?>"><?php echo '#'.$item->order_id ?></a></td>
          <td><?php echo $item->item_count; ?></td>
          <td>
              <?php echo Engine_Api::_()->estore()->getCurrencyPrice($item->total,$item->currency_symbol,$item->change_rate); ?>
          </td>
          <td>
              <?php echo Engine_Api::_()->estore()->getCurrencyPrice($item->total_shippingtax_cost,$item->currency_symbol,$item->change_rate); ?>
          </td>
           <td>
               <?php echo Engine_Api::_()->estore()->getCurrencyPrice($item->commission_amount,$item->currency_symbol,$item->change_rate); ?>
           </td>
          <td>
              <?php $user = Engine_Api::_()->getItem('user',$item->user_id) ?>
              <a href="<?php echo $user->getHref(); ?>"><?php echo $user->getTitle(); ?></a>
          </td>
          <td><?php echo $item->gateway_type; ?></td> 
          <td><?php echo ucwords($item->state); ?></td>
          <td><?php echo $item->creation_date; ?></td> 
          <td class="table_options">
            <?php echo $this->htmlLink($this->url(array('store_id' => $store->custom_url,'action'=>'view','order_id'=>$item->order_id), 'estore_order', true).'?order=view', $this->translate("View Order"), array('class' => 'openSmoothbox estore_basicbtn fa fa-eye')); ?>
            <?php echo $this->htmlLink($this->url(array('action' => 'view', 'order_id' => $item->order_id, 'store_id' => $store->custom_url,'format'=>'smoothbox'), 'estore_order', true), $this->translate("Print Invoice"), array('class' => 'estore_basicbtn fa fa-print','target'=>'_blank')); ?>
          </td>
          
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
   </form>
</div>
<?php if(!$this->is_ajax  && !$this->is_search_ajax){ ?>
	</div>
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
<script type="text/javascript">
  sesJqueryObject('#date_to-hour').attr('style','display:none !important');
  sesJqueryObject('#date_to-minute').attr('style','display:none !important');
  sesJqueryObject('#date_to-ampm').attr('style','display:none !important');
  sesJqueryObject('#date_from-hour').attr('style','display:none !important');
  sesJqueryObject('#date_from-minute').attr('style','display:none !important');
  sesJqueryObject('#date_from-ampm').attr('style','display:none !important');
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
sesJqueryObject(document).on('click','.estore_dashboard_search_form',function(e){
	e.preventDefault();
	sendParamInSearch = sesJqueryObject(this).attr('data-rel');
	sesJqueryObject('#manage_order_search_form').trigger('click');
});
sesJqueryObject('#loadingimgestore-wrapper').hide();
</script>

<?php if($this->is_ajax || $this->is_search_ajax) die; ?>
