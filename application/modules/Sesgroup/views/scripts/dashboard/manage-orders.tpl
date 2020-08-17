
<?php if(!$this->is_ajax){ 
  echo $this->partial('dashboard/left-bar.tpl', 'sesgroup', array(
 	 'group' => $this->group,
  ));	
?>
	<div class="sesgroup_dashboard_content sesbm sesbasic_clearfix">
<?php } 
  echo $this->content()->renderWidget('egroupjoinfees.manage-orders', array('group_id' => $this->group->group_id));
?>
<?php if(!$this->is_ajax){ ?>
	</div>
  </div>
</div>
<?php  } ?>
<style>
#date-date_from,
#date-date_to{ display:block !important;}
</style>
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
</script>
<?php if($this->is_ajax) die; ?>
