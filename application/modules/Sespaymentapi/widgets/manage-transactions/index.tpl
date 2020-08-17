<?php

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/dashboard.css'); ?>
<?php if(!$this->is_search_ajax){ ?>
<div class="sesbasic_dashboard_content_header sesbasic_clearfix">
  <h3><?php echo $this->translate("Manage Transactions"); ?></h3>
  <p><?php echo $this->translate('Below, you can manage the transactions for the payment made on this website. You can use this page to monitor your transactions. Entering criteria into the filter fields will help you find specific transaction.'); ?></p>
</div>
<div class="sesbasic_browse_search sesbasic_browse_search_horizontal sesbasic_dashboard_search_form">
  <?php echo $this->searchForm->render($this); ?>
</div>
<?php } ?>
<div id="sesevent_manage_order_content">

<?php if($this->paginator->getTotalItemCount() > 0): ?>
<div class="sesbasic_dashboard_search_result">
	<?php echo $this->translate(array('%s transaction found.', '%s transactions found.', $this->paginator->getTotalItemCount()), $this->locale()->toNumber($this->paginator->getTotalItemCount())); ?>
</div>
<?php $defaultCurrency = Engine_Api::_()->sespaymentapi()->defaultCurrency(); ?>
<div class="sesbasic_dashboard_table sesbasic_bxs">
  <form id='multidelete_form' method="post">
    <table>
      <thead>
        <tr>
          <th class="centerT"><?php echo $this->translate("ID"); ?></th>
          <th><?php echo $this->translate("Owner Name") ?></th>
          <th><?php echo $this->translate("Owner Email") ?></th>
          <th><?php echo $this->translate("Total Amount") ?></th>
          <th><?php echo $this->translate("Transaction Date") ?></th>
          <th><?php echo $this->translate("Option") ?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($this->paginator as $item): ?>
        <tr>
          <?php $user = Engine_Api::_()->getItem($item->resource_type, $item->resource_id) ?>
          <td class="centerT">
          	<!--<a class="openSmoothbox" href="<?php //echo $this->url(array('event_id' => $event->custom_url,'action'=>'view','order_id'=>$item->order_id), 'sesevent_order', true); ?>">-->
          	<?php echo '#'.$item->transaction_id ?>
          	<!--</a>-->
          </td>
          <td><a href="<?php echo $user->getHref(); ?>"><?php echo $user->getTitle(); ?></a></td>
          <td title="<?php echo $user->email; ?>"><?php echo $user->email ? $this->string()->truncate($user->email, 16) : '-'; ?></td>
          <td><?php echo Engine_Api::_()->sespaymentapi()->getCurrencyPrice(round($item->amount,2),$defaultCurrency); ?></td>
          <td title="<?php echo $item->timestamp; ?>"><?php echo $this->string()->truncate($item->timestamp, 20); ?></td> 
          <td class="table_options">
            <a class="fa fa-eye" href="<?php echo $user->getHref(); ?>"><?php echo $this->translate("View Profile"); ?></a>
            <?php $getRefundEntry = Engine_Api::_()->getDbTable('refundrequests', 'sespaymentapi')->getRefundEntry(array('transaction_id' => $item->transaction_id)); ?>
            <?php if(empty($getRefundEntry)) { ?> 
              <?php echo $this->htmlLink($this->url(array('action' => 'refund-request', 'transaction_id' => $item->transaction_id, 'user_id' => $user->getIdentity(),'format'=>'smoothbox'), 'sespaymentapi_extended', true), $this->translate("Refund Request"), array('class' => 'smoothbox')); ?>
            <?php } else { ?>
              <a href="javascript:void(0);" title="<?php echo $this->translate('You have already sent refund request for this transaction'); ?>"><?php echo $this->translate('Refund Request'); ?></a>
            <?php } ?>
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
    <?php echo $this->translate("No, transaction has been made yet.") ?>
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
			'url': en4.core.baseUrl + "widget/index/mod/sespaymentapi/name/manage-transactions",
			'data': {
				format: 'html',
				searchParams :searchFormData, 
				is_search_ajax:true,
				is_ajax : 1,
				page:pageNum,
				user_id:<?php echo $this->user_id; ?>,
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