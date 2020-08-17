<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: manage-orders.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Courses/externals/styles/style_dashboard.css'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/datepicker/bootstrap-datepicker.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery1.11.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/datepicker/jquery.timepicker.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/datepicker/bootstrap-datepicker.js'); ?>

<?php if(!$this->is_ajax && !$this->is_search_ajax){ 
 echo $this->partial('dashboard/left-bar.tpl', 'eclassroom', array(
	'classroom' => $this->classroom,
      )); ?>
<div class="classroom_dashboard_content sesbm sesbasic_clearfix">
<div class="classroom_dashboard_search_form classroom_browse_search classroom_browse_search_horizontal sesbasic_clearfix sesbasic_bxs"><?php echo $this->searchForm->render($this); ?></div>
	<div class="classroom_dashboard_table sesbasic_bxs">
<?php
  }
?>
  <form id='multidelete_form' method="post">
    <table>
      <thead>
        <tr>
          <th class="centerT"><?php echo $this->translate("ID"); ?></th>
          <th><?php echo $this->translate("Total Item") ?></th>
           <th><?php echo $this->translate("Total Amount") ?></th>
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
        	<?php $classroom = Engine_Api::_()->getItem("classroom", $item->classroom_id); ?>
          <td class="centerT">
          	<a class="openSmoothbox" href="<?php echo $this->url(array('classroom_id' => $classroom->custom_url,'action'=>'view','order_id'=>$item->order_id), 'courses_order', true).'?order=view'; ?>"><?php echo '#'.$item->order_id ?></a></td>
          <td><?php echo $item->item_count; ?></td>
          <td>
              <?php echo Engine_Api::_()->courses()->getCurrencyPrice($item->total,$item->currency_symbol,$item->change_rate); ?>
          </td>
           <td>
               <?php echo Engine_Api::_()->courses()->getCurrencyPrice($item->commission_amount,$item->currency_symbol,$item->change_rate); ?>
           </td>
          <td>
              <?php $user = Engine_Api::_()->getItem('user',$item->user_id) ?>
              <a href="<?php echo $user->getHref(); ?>"><?php echo $user->getTitle(); ?></a>
          </td>
          <td><?php echo $item->gateway_type; ?></td> 
          <td><?php echo ucwords($item->state); ?></td>
          <td><?php echo $item->creation_date; ?></td> 
          <td class="table_options">
            <?php echo $this->htmlLink($this->url(array('classroom_id' => $classroom->custom_url,'action'=>'view','order_id'=>$item->order_id), 'courses_order', true).'?order=view', $this->translate("View Order"), array('class' => 'openSmoothbox eclassroom_basicbtn fa fa-eye')); ?>
            <?php echo $this->htmlLink($this->url(array('action' => 'view', 'order_id' => $item->order_id, 'classroom_id' => $classroom->custom_url,'format'=>'smoothbox'), 'courses_order', true), $this->translate("Print Invoice"), array('class' => 'eclassroom_basicbtn fa fa-print','target'=>'_blank')); ?>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
   </form>
<?php if(!$this->is_ajax  && !$this->is_search_ajax){ ?>
</div>

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
			'url': en4.core.baseUrl + "eclassroom/dashboard/manage-orders",
			'data': {
				format: 'html',
				searchParams :searchFormData, 
				is_search_ajax:true,
				is_ajax : 1,
				page:pageNum,
			},
			onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
				sesJqueryObject('.sesbasic_loading_cont_overlay').css('display','none');
				sesJqueryObject('.classroom_dashboard_content').html(responseHTML);
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

sesJqueryObject(document).on('submit','#manage_order_search_form',function(event){
	event.preventDefault();
	var searchFormData = sesJqueryObject(this).serialize();
	sesJqueryObject('#classroom-search-order-img').show();
	new Request.HTML({
			method: 'post',
			url :  '<?php echo $this->url(array('classroom_id' => $this->classroom->custom_url, 'action'=>'manage-orders'), 'eclassroom_dashboard', true); ?>',
			data : {
				format : 'html',
				searchParams :searchFormData, 
				is_search_ajax:true,
			},
			onComplete: function(response) {
				sesJqueryObject('#classroom-search-order-img').hide();
				sesJqueryObject('.classroom_dashboard_table').html(response);
			}
	}).send();
});

</script>
<?php if($this->is_ajax || $this->is_search_ajax) die; ?>
