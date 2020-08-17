<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
 <?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Courses/externals/styles/style_dashboard.css'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/datepicker/bootstrap-datepicker.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery1.11.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/datepicker/jquery.timepicker.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/datepicker/bootstrap-datepicker.js'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Courses/externals/styles/style_dashboard.css'); ?>
<?php 
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');
?>
<style>
#date-date_to{display:block !important;}
#date-date_from{display:block !important;}
</style>
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

  function multiDelete() {
    return confirm("<?php echo $this->translate('Are you sure you want to delete the selected tickets?');?>");
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
<?php include APPLICATION_PATH .  '/application/modules/Courses/views/scripts/dismiss_message.tpl';?>
<div>
<h3><?php echo $this->translate("Manage Orders") ?></h3>
<p><?php echo $this->translate('This page lists all of the orders which are purchased from your website. You can use this page to monitor these orders. Entering criteria into the filter fields will help you find specific ticket order. Leaving the filter fields blank will show all the orders on your social network.'); ?></p>
<br />
    <?php $defaultCurrency = Engine_Api::_()->courses()->defaultCurrency(); ?>
    <div class='admin_search sesbasic_search_form'>
      <?php echo $this->formFilter->render($this) ?>
    </div>
    <br />
    <?php $counter = $this->paginator->getTotalItemCount(); ?>
    <?php if( count($this->paginator)): ?>
      <div class="sesbasic_search_reasult">
        <?php echo $this->translate(array('%s order found.', '%s orders found.', $counter), $this->locale()->toNumber($counter)) ?>
      </div>
        <div class="clear" style="overflow: auto;">
         <form id='multidelete_form' method="post">
        <table class='admin_table'>
          <thead>
            <tr>
              <th class='admin_table_short'><input onclick='selectAll();' type='checkbox' class='checkbox' /></th>
              <th class='admin_table_short'><a href="javascript:void(0);" onclick="javascript:changeOrder('order_id', 'DESC');"><?php echo $this->translate("ID") ?></a></th>
              <th><?php echo $this->translate("Owner Name") ?></th>
              <th class="admin_table_centered"><?php echo $this->translate("Status") ?></th>
              <th class="admin_table_centered"><?php echo $this->translate("Payment Type") ?></th>
              <th class="admin_table_centered"><?php echo $this->translate("Total Amount"); ?></th>
              <th class="admin_table_centered"><?php echo $this->translate("Ordered Date"); ?></th>
              <th><?php echo $this->translate("Options") ?></th>
            </tr>
          </thead>
        
          <tbody>
            <?php foreach ($this->paginator as $item): ?>
            <tr>
            <td><input type='checkbox' class='checkbox' name='delete_<?php echo $item->order_id;?>' value="<?php echo $item->order_id; ?>" /></td>
            <td><?php echo $this->htmlLink($this->url(array('action'=>'view','order_id'=>$item->order_id), 'courses_order', true).'?order=view', $item->order_id, array('title' => $this->translate($item->order_id), 'class' => 'smoothbox')); ?></td>
            <td class="admin_table_centered">
              <?php
                echo Engine_Api::_()->getItem('user',$item->user_id);
              ?>
            </td>
            <td class="admin_table_centered">
              <?php echo $this->partial('orderStatus.tpl','courses',array('item'=>$item)); ?>
            </td>
            <td class="admin_table_centered">
              <?php echo $item->gateway_type; ?>
            </td>
            <td class="admin_table_centered">
              <?php echo Engine_Api::_()->courses()->getCurrencyPrice(round($item->total_amount,2),$defaultCurrency); ?>
            </td>
            <td class="admin_table_centered">
              <?php echo $item->creation_date; ?>
            </td>
              <td class="admin_table_centered">
              <?php if(($item->gateway_id == 20 || $item->gateway_id == 21) && $item->state == "processing"){ ?>
                <?php echo $this->htmlLink($this->url(array('action'=>'payment-approve','order_id'=>$item->order_id,'module'=>'courses','controller'=>'orders'), 'admin_default', true), $this->translate("Approve Payment"), array('title' => $this->translate("Approve Payment"), 'class' => 'smoothbox')); ?>
                |
              <?php } ?>
                <?php echo $this->htmlLink($this->url(array('action'=>'view','order_id'=>$item->order_id), 'courses_order', true).'?order=view', $this->translate("View Order"), array('title' => $this->translate("View Order"), 'class' => 'smoothbox')); ?>
                |
                <?php echo $this->htmlLink($this->url(array('action'=>'view','order_id'=>$item->order_id), 'courses_order', true), $this->translate("Print Invoice"), array('title' => $this->translate("Print Invoice"), 'target' => '_blank')); ?>

                <?php if($item->state == "Processing"){ ?>
                |
                <?php echo $this->htmlLink($this->url(array('action'=>'payment-cancel','order_id'=>$item->order_id,'module'=>'courses','controller'=>'orders'), 'admin_default', true), $this->translate("Cancel Order"), array('title' => $this->translate("Cancel Order"), 'class' => 'smoothbox')); ?>
                <?php } ?>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table><br/>
        <div class='buttons'>
            <button type='submit'><?php echo $this->translate("Delete Selected") ?></button>
        </div>
   </form>
</div>
  <br/>
  <div>
    <?php echo $this->paginationControl($this->paginator); ?>
  </div>
<?php else:?>
  <div class="tip">
    <span>
      <?php echo $this->translate("Nobody has placed an order yet on your website.") ?>
    </span>
  </div>
<?php endif; ?>
</div>
</div>
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

  function changeOrderStatus(order_id,object) {
      sesJqueryObject('img_'+order_id).show();
      var formData = new FormData(sesJqueryObject(object).closest('form')[0]);
      var form = sesJqueryObject(object);
      sesJqueryObject.ajax({
          type:'POST',
          dataType:'html',
          url: 'admin/courses/orders/change-order-status/order_id/'+order_id,
          data:formData,
          cache:false,
          contentType: false,
          processData: false,
          success:function(response){
              sesJqueryObject('img_'+order_id).hide();
              var data = sesJqueryObject.parseJSON(response);
              if(data.status == 1){
                  sesJqueryObject(object).closest('td').html(data.message);
              }else{
                  alert('Something went wrong, please try again later');
              }
          },
          error: function(data){
              //silence
              sesJqueryObject('img_'+order_id).hide();
              alert('Something went wrong, please try again later');
          }
      });
  }
  sesJqueryObject(document).on('click','.courses_change_type',function () {
    if(sesJqueryObject(this).hasClass('active')){
        sesJqueryObject(this).removeClass('active');
        sesJqueryObject(this).parent().parent().find('form').hide();
        return;
    }else{
        sesJqueryObject(this).addClass('active');
        sesJqueryObject(this).parent().parent().find('form').show();
        return;
    }
  });
</script>
