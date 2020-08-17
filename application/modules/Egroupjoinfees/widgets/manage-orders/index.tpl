<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Egroupjoinfees
 * @package    Egroupjoinfees
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2017-12-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php if(!$this->is_search_ajax){ ?>
<div class="sesbasic_dashboard_content_header sesbasic_clearfix">
  <h3><?php echo $this->translate("Manage Entry Orders"); ?></h3>
  <p><?php echo $this->translate('Below, you can manage the entry orders for this group. You can use this page to monitor these orders. Entering criteria into the filter fields will help you find specific order.'); ?></p>
</div>
<div class="sesbasic_browse_search sesbasic_browse_search_horizontal sesbasic_dashboard_search_form">
  <?php echo $this->searchForm->render($this); ?>
</div>
<?php } ?>
<div id="sesgroup_manage_order_content">
<div class="sesgroup_dashboard_search_result">
	<?php echo $this->paginator->getTotalItemCount().$this->translate(' order(s) found.'); ?>
</div>
<?php if($this->paginator->getTotalItemCount() > 0): ?>
<?php $defaultCurrency = Engine_Api::_()->egroupjoinfees()->defaultCurrency(); ?>
<div class="sesgroup_dashboard_table sesbasic_bxs">
  <form id='multidelete_form' method="post">
    <table>
      <thead>
        <tr>
          <th class="centerT"><?php echo $this->translate("Order ID"); ?></th>
          <th><?php echo $this->translate("Buyer") ?></th>
          <th><?php echo $this->translate("Email") ?></th>
          <th><?php echo $this->translate("Order Total") ?></th>
          <th><?php echo $this->translate("Commission") ?></th>
          <th><?php echo $this->translate("Status") ?></th>
          <th><?php echo $this->translate("Gateway") ?></th>
          <th><?php echo $this->translate("Order Date") ?></th>
          <th><?php echo $this->translate("Options") ?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($this->paginator as $item): ?>
        <tr>
        	<?php $group = Engine_Api::_()->getItem("sesgroup_group", $item->group_id); ?>
          <td class="centerT">
          	<a class="openSmoothbox" href="<?php echo $this->url(array('group_id' => $group->custom_url,'action'=>'view','order_id'=>$item->order_id), 'egroupjoinfees_order', true).'?order=view'; ?>"><?php echo '#'.$item->order_id; ?></a>
          </td>
          <td>
              <?php $user = Engine_Api::_()->getItem('user',$item->owner_id); ?>
              <a href="<?php echo $user->getHref(); ?>"><?php echo $user->getTitle(); ?></a>
          </td>
          <td title="<?php echo $user->email; ?>"><?php echo $user->email ? $this->string()->truncate($user->email, 7) : '-'; ?></td>
          <td><?php echo Engine_Api::_()->egroupjoinfees()->getCurrencyPrice(round($item->total_amount,2),$defaultCurrency); ?></td>
          <td><?php echo Engine_Api::_()->egroupjoinfees()->getCurrencyPrice($item->commission_amount,$defaultCurrency); ?></td>
          <td><?php echo $item->state; ?></td> 
          <td><?php echo $item->gateway_type; ?></td> 
          <td title="<?php echo Engine_Api::_()->egroupjoinfees()->dateFormat($item->creation_date); ?>"><?php echo $this->string()->truncate(Engine_Api::_()->egroupjoinfees()->dateFormat($item->creation_date), 10); ?></td> 
          <td class="table_options">
            <a href="<?php echo $this->url(array('group_id' => $group->custom_url,'action'=>'view','order_id'=>$item->order_id), 'egroupjoinfees_order', true).'?order=view'; ?>" class="openSmoothbox"><i class=" fa fa-eye"></i> <?php echo $this->translate("View Order") ?></a>
          	<a href="<?php echo $this->url(array('action' => 'view', 'order_id' => $item->order_id, 'group_id' => $group->custom_url,'format'=>'smoothbox'), 'egroupjoinfees_order', true); ?>" target="_blank"><i class=" fa fa-print"></i> <?php echo $this->translate("Print Invoice") ?></a>            
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
   </form>
</div>
<?php echo $this->paginationControl($this->paginator, null, array("_pagging.tpl", "sesgroup"),array('identityWidget'=>'manage_order')); ?>
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
	 var searchFormData = sesJqueryObject('#sesgroup_search_ticket_search').serialize();
		requestPagging= (new Request.HTML({
			method: 'post',
			'url': en4.core.baseUrl + "widget/index/mod/sesgroup/name/manage-orders",
			'data': {
				format: 'html',
				searchParams :searchFormData, 
				is_search_ajax:true,
				is_ajax : 1,
				page:pageNum,
				group_id:<?php echo $this->group_id; ?>,
			},
			onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
				sesJqueryObject('.sesbasic_loading_cont_overlay').css('display','none');
				sesJqueryObject('#sesgroup_manage_order_content').html(responseHTML);
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
sesJqueryObject(document).on('click','.sesgroup_search_ticket_search',function(e){
	e.prgroupDefault();
	sendParamInSearch = sesJqueryObject(this).attr('data-rel');
	sesJqueryObject('#sesgroup_search_ticket_search').trigger('click');
});
sesJqueryObject('#loadingimgsesgroup-wrapper').hide();
</script>
