<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: sales-reports.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php
if(!$this->is_ajax){
	echo $this->partial('dashboard/left-bar.tpl', 'courses', array('course' => $this->course));?>
<div class="courses_dashboard_content sesbm sesbasic_clearfix">
<?php }
?>
<div class="courses_dashboard_content_header sesbasic_clearfix">
  <h3><?php echo $this->translate('Sales Reports'); ?></h3>
  <p><?php echo $this->translate('Below, you can see the sales report of tickets sold from this website. Entering criteria into the filter fields will help you find specific reports. You can also download the reports in csv and excel formats.'); ?></p>
</div>
<div class="courses_browse_search courses_browse_search_horizontal courses_dashboard_search_form">
  <?php echo $this->form->render($this); ?>
</div>
<div class="courses_dashboard_table_right_links">
	<a href="javascript:;"  class="courses_report_download" data-rel="csv"><i class="fa fa-download sesbasic_text_light"></i><?php echo $this->translate("Download Report in CSV"); ?></a>
  <a href="javascript:;" class="courses_report_download" data-rel="excel"><i class="fa fa-download sesbasic_text_light"></i><?php echo $this->translate("Download Report in Excel"); ?></a>
</div>
<?php if( isset($this->coursesSaleData) && count($this->coursesSaleData) > 0): ?>
<?php $defaultCurrency = Engine_Api::_()->courses()->defaultCurrency(); ?>
<div class="courses_dashboard_table sesbasic_bxs">
  <form method="post" >
    <table>
      <thead>
        <tr>
          <th class="centerT"><?php echo $this->translate("S.No"); ?></th>
          <th><?php echo $this->translate("Date of Purchase") ?></th>
          <th><?php echo $this->translate("Quatity") ?></th>
          <th><?php echo $this->translate("Total Tax Amount") ?></th>
          <th><?php echo $this->translate("Commission Amount") ?></th>
          <th><?php echo $this->translate("Total Amount") ?></th>
        </tr>
      </thead>
      <tbody>
        <?php 
        	$counter = 1;
          foreach ($this->coursesSaleData as $item): ?>
        <tr>
          <td class="centerT"><?php echo $counter; ?></td>
          <td><?php echo ($item->creation_date); ?></td>
          <td class="centerT"><?php echo $item->total_orders; ?></td>
          <td><?php echo Engine_Api::_()->courses()->getCurrencyPrice($item->total_billingtax_cost,$defaultCurrency); ?></td>
          <td><?php echo Engine_Api::_()->courses()->getCurrencyPrice($item->commission_amount,$defaultCurrency); ?></td>
          <td><?php echo $item->total_amount <= 0 ? $this->translate('FREE') : Engine_Api::_()->courses()->getCurrencyPrice($item->total_amount,$defaultCurrency); ?></td>
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
    <?php echo $this->translate("No Course sold yet.") ?>
  </span>
</div>
<?php endif; ?>
<?php if(!$this->is_ajax){ ?>
    </div>
</div>
</div>
<?php  } ?>
<script type="application/javascript">
sesJqueryObject(document).on('click','.courses_report_download',function(){
	var downloadType = 	sesJqueryObject(this).attr('data-rel');
	if(downloadType == 'csv'){
		sesJqueryObject('#csv').val('1');
	}else{
			sesJqueryObject('#excel').val('1');
	}
	sesJqueryObject('#courses_search_form_sale_report').trigger('submit');
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

