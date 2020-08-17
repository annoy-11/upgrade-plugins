
<?php
if(!$this->is_ajax){
	echo $this->partial('dashboard/left-bar.tpl', 'sesgroup', array('group' => $this->group));?>
<div class="sesgroup_dashboard_content sesbm sesbasic_clearfix">
<?php } 
?>
	<div class="sesgroup_dashboard_content_header sesbasic_clearfix">
		<h3><?php echo $this->translate('Sales Reports'); ?></h3>
    <p><?php echo $this->translate('Below, you can see the sales report of fees paid by members to submit entries in your paid group on this website. Entering criteria into the filter fields will help you find specific reports. You can also download the reports in csv and excel formats.'); ?></p>
  </div>
  <div class="sesgroup_browse_search sesbasic_browse_search_horizontal sesgroup_dashboard_search_form">
  	<?php echo $this->form->render($this); ?>
	</div>
<div class="sesgroup_dashboard_table_right_links">
	<a href="javascript:;"  class="sesgroup_report_download" data-rel="csv"><i class="fa fa-download sesbasic_text_light"></i><?php echo $this->translate("Download Report in CSV"); ?></a>
  <a href="javascript:;" class="sesgroup_report_download" data-rel="excel"><i class="fa fa-download sesbasic_text_light"></i><?php echo $this->translate("Download Report in Excel"); ?></a>
</div>
<?php if( isset($this->groupJoiningData) && count($this->groupJoiningData) > 0): ?>
<?php $defaultCurrency = Engine_Api::_()->egroupjoinfees()->defaultCurrency(); ?>
<div class="sesgroup_dashboard_table sesbasic_bxs">
  <form method="post" >
    <table>
      <thead>
        <tr>
          <th class="centerT"><?php echo $this->translate("S.No"); ?></th>
          <th><?php echo $this->translate("Date of Purchase") ?></th>
          <th><?php echo $this->translate("Quatity") ?></th>
          <th><?php echo $this->translate("Total Amount") ?></th>
        </tr>
      </thead>
      <tbody>
        <?php 
        	$counter = 1;
          foreach ($this->groupJoiningData as $item): ?>
        <tr>
          <td class="centerT"><?php echo $counter; ?></td>
          <td><?php echo Engine_Api::_()->egroupjoinfees()->dateFormat($item->creation_date); ?></td> 
          <td class="centerT"><?php echo $item->total_orders; ?></td>
          <td><?php echo Engine_Api::_()->egroupjoinfees()->getCurrencyPrice($item->totalAmountSale,$defaultCurrency); ?></td>
        </tr>
        <?php $counter++;
        			endforeach; ?>
      </tbody>
    </table>
   </form>
</div>
<?php else: ?>
<div class="tip">
  <span>
    <?php echo $this->translate("Currently no entry has been submitted to your paid group.") ?>
  </span>
</div>
<?php endif; ?>
<?php if(!$this->is_ajax){ ?>
    </div>
</div>
</div>
<?php  } ?>
<script type="application/javascript">
sesJqueryObject(document).on('click','.sesgroup_report_download',function(){
	var downloadType = 	sesJqueryObject(this).attr('data-rel');
	if(downloadType == 'csv'){
		sesJqueryObject('#csv').val('1');
	}else{
			sesJqueryObject('#excel').val('1');
	}
	sesJqueryObject('#sesgroup_search_form_sale_report').trigger('submit');
	sesJqueryObject('#csv').val('');
	sesJqueryObject('#excel').val('');
	
});
</script>
<style>
#startdate,
#enddate{ display:block !important;}
.widthClass{width:90px !important;}
</style>
<script type="application/javascript">
sesBasicAutoScroll('#startdate').addClass('widthClass');
sesBasicAutoScroll('#enddate').addClass('widthClass');
if(sesBasicAutoScroll('#startdate')){
	var FromEndDateSales;
	var selectedDateSales =  new Date(sesBasicAutoScroll('#startdate').val());
	sesBasicAutoScroll('#startdate').datepicker({
			format: 'yyyy-m-d',
			weekStart: 1,
			autoclose: true,
			endDate: FromEndDateSales, 
	}).on('changeDate', function(ev){
		selectedDateSales = ev.date;	
		sesBasicAutoScroll('#enddate').datepicker('setStartDate', selectedDateSales);
	});
	sesBasicAutoScroll('#enddate').datepicker({
			format: 'yyyy-m-d',
			weekStart: 1,
			autoclose: true,
			startDate: selectedDateSales,
	}).on('changeDate', function(ev){
		FromEndDateSales	= ev.date;	
		 sesBasicAutoScroll('#startdate').datepicker('setEndDate', FromEndDateSales);
	});	
}
</script>
