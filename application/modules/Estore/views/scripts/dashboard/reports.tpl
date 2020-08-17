<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: reports.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Estore/externals/styles/jquery.timepicker.css'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Estore/externals/styles/bootstrap-datepicker.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery1.11.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Estore/externals/scripts/jquery.timepicker.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Estore/externals/scripts/bootstrap-datepicker.js'); ?>
<?php ?>
<?php if(!$this->is_ajax){ 
echo $this->partial('dashboard/left-bar.tpl', 'estore', array(
	'store' => $this->store,
      ));	
?>

	<div class="estore_dashboard_content sesbm sesbasic_clearfix sesbasic_bxs">
    <div class="estore_dashboard_content_header sesbasic_clearfix">
      <h3><?php echo $this->translate('Store Reports'); ?></h3>
      <p><?php echo $this->translate(''); ?></p>
    </div>
<?php }	?>
  <div class="estore_browse_search estore_browse_search_horizontal estore_dashboard_search_form">
  	<?php echo $this->form->render() ?>
  </div>
<?php if(!$this->is_ajax){ ?>
  </div>
</div>
</div>
<?php  } ?>
<?php if($this->is_ajax) die; ?>
<script type="application/javascript">
sesJqueryObject(document).on('click','#submit_form_sales_report',function(){
  var downloadType = 	sesJqueryObject('#report_type').val();
  if(downloadType == 'csv'){
    sesJqueryObject('#csv').val('1');
  }else{
    sesJqueryObject('#excel').val('1');
  }
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
