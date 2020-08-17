<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: my-order.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php if(!$this->is_ajax && !$this->is_search_ajax){ ?>
  <?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Courses/externals/styles/style_dashboard.css'); ?>
  <?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/datepicker/bootstrap-datepicker.css'); ?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery1.11.js'); ?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/datepicker/jquery.timepicker.js'); ?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/datepicker/bootstrap-datepicker.js'); ?>
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
<div class="courses_dashboard_search_form courses_browse_search courses_browse_search_horizontal sesbasic_clearfix sesbasic_bxs"><?php echo $this->searchForm->render($this); ?></div>
	<div class="courses_dashboard_table sesbasic_bxs" id="manage-order">
<?php } ?>
  <?php if( count($this->paginator) ): ?>
    <form id='multidelete_form' method="post">
      <table>
        <thead>
          <tr>
            <th class="centerT"><?php echo $this->translate("Order Id"); ?></th>
            <th><?php echo $this->translate("Total Item") ?></th>
            <th><?php echo $this->translate("Total Amount") ?></th>
            <th><?php echo $this->translate("Billing Cost") ?></th>
            <th><?php echo $this->translate("Buyer Name") ?></th>
            <th><?php echo $this->translate("Gateway Type") ?></th>
            <th><?php echo $this->translate("Status") ?></th>
            <th><?php echo $this->translate("Order Date") ?></th>
            <th><?php echo $this->translate("Options") ?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($this->paginator as $item): ?>
          <tr id="order_id_<?php echo $item->order_id; ?>">
            <td class="centerT">
              <a class="openSmoothbox" href="<?php echo $this->url(array('action'=>'view','order_id'=>$item->order_id), 'courses_order', true); ?>"><?php echo '#'.$item->order_id ?></a></td>
            <td><?php echo $item->item_count; ?></td>
            <td><?php echo Engine_Api::_()->courses()->getCurrencyPrice($item->total_amount,$item->currency_symbol,$item->change_rate); ?></td>
            <td><?php echo Engine_Api::_()->courses()->getCurrencyPrice($item->total_billingtax_cost,$item->currency_symbol,$item->change_rate); ?></td>
            <td>
                <?php $user = Engine_Api::_()->getItem('user',$item->user_id) ?>
                <a href="<?php echo $user->getHref(); ?>"><?php echo $item->buyer_name; ?></a>
            </td>
            <td><?php echo $item->gateway_type; ?></td> 
            <td><?php echo $item->state; ?></td> 
            <td><?php echo $item->creation_date; ?></td> 
            <td class="table_options">
              <?php echo $this->htmlLink($this->url(array('action'=>'view','order_id'=>$item->order_id), 'courses_order', true).'?order=view', $this->translate("View Order"), array('class' => 'openSmoothbox courses_basicbtn fa fa-eye')); ?>
              <?php echo $this->htmlLink($this->url(array('action' => 'view', 'order_id' => $item->order_id,'format'=>'smoothbox'), 'courses_order', true), $this->translate("Print Invoice"), array('class' => 'courses_basicbtn fa fa-print','target'=>'_blank')); ?>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table><br/>
      <?php echo $this->paginationControl($this->paginator, null, array("_pagging.tpl", "courses"),array('identityWidget'=>false)); ?>
    </form>
    <br/>
  <?php else: ?>
    <?php  if(($this->paginator->getTotalItemCount() == 0) && !$this->is_search_ajax):  ?>
        <div class="sesbasic_tip clearfix">
          <img src="application/modules/Courses/externals/images/no-order.png" alt="" />
          <span class="sesbasic_text_light">
            <?php echo $this->translate('You have not placed any order yet. Be the first one to purchase course.') ?>
          </span>
        </div>
    <?php endif; ?>
    <?php  if(($this->paginator->getTotalItemCount() == 0) && $this->is_search_ajax):  ?>
      <div class="sesbasic_tip clearfix">
        <img src="application/modules/Courses/externals/images/no-order.png" alt="" />
        <span class="sesbasic_text_light">
          <?php echo $this->translate('There are no results that match your search. Please try again.') ?>
        </span>
      </div>
    <?php endif; ?>
  <?php endif; ?>
<?php if(!$this->is_ajax && !$this->is_search_ajax){ ?>
	</div>
</div>
<?php  } ?>
<style>
#date-date_from,
#date-date_to{ display:block !important;}
</style>
<script type="application/javascript">
<?php if(!$this->is_ajax && !$this->is_search_ajax){ ?>
  var requestedTab = "requested";
  var searchFormData = "";
<?php  } ?>
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
	sesJqueryObject('#courses_search_ticket_search').trigger('click');
});
sesJqueryObject('#courses-search-order-img').hide();
 sesJqueryObject(document).on('submit','#manage_order_search_form',function(event){
	event.preventDefault();
	if(requestedTab != "requested")
    return  false;
	searchFormData = sesJqueryObject(this).serialize(); console.log(searchFormData);
	sesJqueryObject('#courses-search-order-img').show();
	requestedTab = new Request.HTML({
			method: 'post',
			url :  en4.core.baseUrl + 'courses/manage-account/my-order',
			data : {
				format : 'html',
				searchParams :searchFormData, 
				is_search_ajax:true,
			},
			onComplete: function(response) {
				sesJqueryObject('#courses-search-order-img').hide();
				sesJqueryObject('.courses_dashboard_table').html(response);
				requestedTab ="requested";
			}
	}).send();
});

function paggingNumber(pageNum){ 
  sesJqueryObject('.sesbasic_loading_cont_overlay').css('display','block');
  requestViewMore = (new Request.HTML({
    method: 'post',
    'url': en4.core.baseUrl + 'courses/manage-account/my-order',
    'data': {
      format: 'html',
      page: pageNum,    
      searchParams :searchFormData,
      is_ajax : 1,
    },
    onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
      sesJqueryObject('sesbasic_loading_cont_overlay').remove();
      document.getElementById('manage-order').innerHTML =  responseHTML;
    }
  }));
  requestViewMore.send();
  return false;
}
</script>
<?php if($this->is_ajax || $this->is_search_ajax) die; ?>
