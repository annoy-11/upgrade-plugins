<?php

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/dashboard.css'); ?>
<?php if(!$this->is_search_ajax){ ?>
<div class="sesbasic_dashboard_content_header sesbasic_clearfix">
  <h3><?php echo $this->translate("Manage Orders"); ?></h3>
  <p><?php echo $this->translate('Below, you can manage the orders for subscription on your profile. You can use this page to monitor these orders. Entering criteria into the filter fields will help you find specific order.'); ?></p>
</div>
<div class="sesbasic_browse_search sesbasic_browse_search_horizontal sesbasic_dashboard_search_form">
  <?php echo $this->searchForm->render($this); ?>
</div>
<?php } ?>
<div id="sesevent_manage_order_content">

<?php if($this->paginator->getTotalItemCount() > 0): ?>
<div class="sesbasic_dashboard_search_result">
	<?php echo $this->translate(array('%s order found.', '%s orders found.', $this->paginator->getTotalItemCount()), $this->locale()->toNumber($this->paginator->getTotalItemCount())); ?>
</div>
<?php $defaultCurrency = Engine_Api::_()->sespaymentapi()->defaultCurrency(); ?>
<div class="sesbasic_dashboard_table sesbasic_bxs">
  <form id='multidelete_form' method="post">
    <table>
      <thead>
        <tr>
          <th class="centerT"><?php echo $this->translate("ID"); ?></th>
          <th><?php echo $this->translate("Subscriber Name") ?></th>
          <th><?php echo $this->translate("Subscriber Email") ?></th>
          <th><?php echo $this->translate("Order Total") ?></th>
          <th><?php echo $this->translate("Commision") ?></th>
          <th><?php echo $this->translate("Status") ?></th>
          <th><?php echo $this->translate("Gateway") ?></th>
          <th><?php echo $this->translate("Order Date") ?></th>
          <th><?php echo $this->translate("Options") ?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($this->paginator as $item): ?>
        <tr>
          <?php $user = Engine_Api::_()->getItem('user', $item->user_id) ?>
          <td class="centerT">
          	<!--<a class="openSmoothbox" href="<?php //echo $this->url(array('event_id' => $event->custom_url,'action'=>'view','order_id'=>$item->order_id), 'sesevent_order', true); ?>">-->
          	<b><?php echo '#'.$item->order_id ?></b>
          	<!--</a>-->
          </td>
          <td><a href="<?php echo $user->getHref(); ?>"><?php echo $user->getTitle(); ?></a></td>
          <td title="<?php echo $item->email; ?>"><?php echo $item->email ? $this->string()->truncate($item->email, 16) : '-'; ?></td>
          <td><?php echo Engine_Api::_()->sespaymentapi()->getCurrencyPrice(round($item->total_amount,2),$defaultCurrency); ?></td>
          <td><?php echo Engine_Api::_()->sespaymentapi()->getCurrencyPrice($item->commission_amount,$defaultCurrency); ?></td>
          <td><?php echo $item->state; ?></td> 
          <td><?php echo $item->gateway_type; ?></td> 
          <td title="<?php echo $item->creation_date; ?>"><?php echo $this->string()->truncate($item->creation_date, 20); ?></td> 
          <td class="table_options">
            <a href="<?php echo $user->getHref(); ?>"><i class="fa fa-eye"></i><?php echo $this->translate("View Profile"); ?></a>
            <?php //echo $this->htmlLink($this->url(array('event_id' => $event->custom_url,'action'=>'view','order_id'=>$item->order_id), 'sesevent_order', true).'?order=view', $this->translate("View Order"), array('class' => 'openSmoothbox fa fa-eye')); ?>
            <?php //echo $this->htmlLink($this->url(array('action' => 'view', 'order_id' => $item->order_id, 'resource_id' => $item->resource_id, 'resource_type' => $item->resource_type ,'format'=>'smoothbox'), 'sespaymentapi_order', true), $this->translate("Print Invoice"), array('class' => 'fa fa-print','target'=>'_blank')); ?>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
   </form>
</div>
<?php echo $this->paginationControl($this->paginator, null, array("_pagging.tpl", "sespaymentapi"),array('identityWidget'=>'manage_order')); ?>
<?php else: ?>
<div class="tip">
  <span>
    <?php echo $this->translate("No order has been placed yet.") ?>
  </span>
</div>
<?php endif; ?>
</div>
<script type="application/javascript">
var requestPagging;
function paggingNumbermanage_order(pageNum){
	 sesJqueryObject('.sesbasic_loading_cont_overlay').css('display','block');
	 var searchFormData = sesJqueryObject('#sesevent_search_ticket_search').serialize();
		requestPagging= (new Request.HTML({
			method: 'post',
			'url': en4.core.baseUrl + "widget/index/mod/sespaymentapi/name/manage-orders",
			'data': {
				format: 'html',
				searchParams :searchFormData, 
				is_search_ajax:true,
				is_ajax : 1,
				page:pageNum,
				resource_id:<?php echo $this->user_id; ?>,
				resource_type:'<?php echo $this->resource_type; ?>',
			},
			onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
				sesJqueryObject('.sesbasic_loading_cont_overlay').css('display','none');
				sesJqueryObject('#sesevent_manage_order_content').html(responseHTML);
			}
		}));
		requestPagging.send();
		return false;
}
</script>
<?php if($this->is_search_ajax) die; ?>

<script type="application/javascript">

  function executeAfterLoad() {
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
  sesJqueryObject(document).on('click','.sesevent_search_ticket_search',function(e){
    e.preventDefault();
    sendParamInSearch = sesJqueryObject(this).attr('data-rel');
    sesJqueryObject('#sesevent_search_ticket_search').trigger('click');
  });
  sesJqueryObject('#loadingimgsesevent-wrapper').hide();
</script>