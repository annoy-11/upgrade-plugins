<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php if(!$this->is_search_ajax){ ?>
<div class="estore_dashboard_content_header sesbasic_clearfix">
  <h3><?php echo $this->translate("Manage Orders"); ?></h3>
  <p><?php echo $this->translate('Below, you can manage the orders for this product. You can use this page to monitor these orders. Entering criteria into the filter fields will help you find specific order.'); ?></p>
</div>
<div class="estore_browse_search estore_browse_search_horizontal estore_dashboard_search_form">
  <?php echo $this->searchForm->render($this); ?>
</div>
<?php } ?>
<div id="sesproduct_manage_order_content">
<div class="estore_dashboard_search_result">
	<?php echo $this->paginator->getTotalItemCount().$this->translate(' order(s) found.'); ?>
</div>
<?php if($this->paginator->getTotalItemCount() > 0): ?>
<?php $defaultCurrency = Engine_Api::_()->sesproduct()->defaultCurrency();?>
<div class="estore_dashboard_table sesbasic_bxs">
  <form id='multidelete_form' method="post">
    <table>
      <thead>
        <tr>
          <th class="centerT"><?php echo $this->translate("ID"); ?></th>
          <th><?php echo $this->translate("Buyer") ?></th>
          <th><?php echo $this->translate("Billing & Shipping Address") ?></th>
          <th><?php echo $this->translate("Email") ?></th>
          <th><?php echo $this->translate("Total Price") ?></th>
          <th><?php echo $this->translate("Commission") ?></th>
          <th><?php echo $this->translate("Status") ?></th>
          <th><?php echo $this->translate("Gateway") ?></th>
          <th><?php echo $this->translate("Order Date") ?></th>
          <th><?php echo $this->translate("Options") ?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($this->paginator as $item):  ?>
        <?php $addressTable =   Engine_Api::_()->getDbtable('addresses', 'sesproduct'); ?>
        <?php $shippingAddress  = $addressTable->getAddress(array('user_id'=>$item->user_id,'type'=>1)); ?>
        <?php $billingAddress =  $addressTable->getAddress(array('user_id'=>$item->user_id,'type'=>0)); ?>
        <tr>
        	<?php $product = Engine_Api::_()->getItem("sesproduct", $item->product_id); ?>
          <td class="centerT">
          	<a class="openSmoothbox" href="<?php echo $this->url(array('product_id' => $product->custom_url,'action'=>'view','order_id'=>$item->order_id), 'sesproduct_order', true); ?>"><?php echo '#'.$item->order_id ?></a>
         </td>
          <td>
              <?php $user = Engine_Api::_()->getItem('user',$item->user_id); ?>
              <a href="<?php echo $user->getHref(); ?>"><?php echo $shippingAddress[0]['first_name'].' '.$shippingAddress[0]['last_name']; ?></a>
          </td>
          <td>
            <?php echo $billingAddress[0]['city'].','.$billingAddress[0]['address'].','.$billingAddress[0]['zip_code'].'|'.$shippingAddress[0]['city'].','.$billingAddress[0]['address'].','.$billingAddress[0]['zip_code']; ?>
          </td>
          <td title="<?php echo $shippingAddress[0]['email']; ?>">
            <?php echo $shippingAddress[0]['email'] ? $this->string()->truncate($shippingAddress[0]['email'], 7) : '-'; ?>
          </td>
          <?php  $order = Engine_Api::_()->getItem('sesproduct_order', $item->order_id); ?>
          <td> <?php echo Engine_Api::_()->sesproduct()->getCurrencyPrice($order->total,$order->currency_symbol,$order->change_rate); ?></td>
          <td><?php echo  Engine_Api::_()->sesproduct()->getCurrencyPrice($item->commission_amount,$defaultCurrency); ?></td>
          <td><?php echo $item->state; ?></td> 
          <td><?php echo $item->gateway_type; ?></td> 
          <td title="<?php echo $item->creation_date; ?>"><?php echo $item->creation_date; ?></td> 
          <td class="table_options">
            <?php echo $this->htmlLink($this->url(array('product_id' => $product->custom_url,'action'=>'view','order_id'=>$item->order_id), 'sesproduct_order', true).'?order=view', $this->translate("View Order"), array('class' => 'openSmoothbox fa fa-eye')); ?>
            <?php echo $this->htmlLink($this->url(array('action' => 'view', 'order_id' => $item->order_id, 'product_id' => $product->custom_url,'format'=>'smoothbox'), 'sesproduct_order', true), $this->translate("Print Invoice"), array('class' => 'fa fa-print','target'=>'_blank')); ?>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
   </form>
</div>
<?php echo $this->paginationControl($this->paginator, null, array("_pagging.tpl", "sesproduct"),array('identityWidget'=>'manage_order')); ?>
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
	 var searchFormData = sesJqueryObject('#sesproduct_search_ticket_search').serialize();
		requestPagging= (new Request.HTML({
			method: 'post',
			'url': en4.core.baseUrl + "widget/index/mod/sesproduct/name/manage-orders",
			'data': {
				format: 'html',
				searchParams :searchFormData, 
				is_search_ajax:true,
				is_ajax : 1,
				page:pageNum,
				product_id:<?php echo $this->product_id; ?>,
			},
			onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
				sesJqueryObject('.sesbasic_loading_cont_overlay').css('display','none');
				sesJqueryObject('#sesproduct_manage_order_content').html(responseHTML);
			}
		}));
		requestPagging.send();
		return false;
}
</script>
<?php if($this->is_search_ajax) die; ?>
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
sesJqueryObject(document).on('click','.sesproduct_search_ticket_search',function(e){
	e.prproductDefault();
	sendParamInSearch = sesJqueryObject(this).attr('data-rel');
	sesJqueryObject('#sesproduct_search_ticket_search').trigger('click');
});
sesJqueryObject('#loadingimgsesproduct-wrapper').hide();
</script>
