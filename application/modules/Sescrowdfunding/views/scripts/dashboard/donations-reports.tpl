<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: donations-reports.tpl  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php if(!$this->is_ajax) {
	echo $this->partial('dashboard/left-bar.tpl', 'sescrowdfunding', array('crowdfunding' => $this->crowdfunding));?>
  <div class="sescrowdfunding_dashboard_content sesbm sesbasic_clearfix">
<?php } ?>
  <?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesevent/externals/styles/jquery.timepicker.css'); ?>
  <?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesevent/externals/styles/bootstrap-datepicker.css'); ?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery1.11.js'); ?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesevent/externals/scripts/jquery.timepicker.js'); ?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesevent/externals/scripts/bootstrap-datepicker.js'); ?>
	<div class="sescrowdfunding_dashboard_content_header sesbasic_clearfix">
		<h3><?php echo $this->translate('Donation Reports'); ?></h3>
    <p><?php echo $this->translate('Below, you can see the donation report of crowdfunding. Entering criteria into the filter fields will help you find specific reports. You can also download the reports in csv and excel formats.'); ?></p>
  </div>
  <div class="sesbasic_browse_search sesbasic_browse_search_horizontal sesbasic_dashboard_search_form">
  	<?php echo $this->form->render($this); ?>
	</div>
<?php if( isset($this->crowdfundingSaleData) && count($this->crowdfundingSaleData) > 0): ?>
<div class="sescf_donate_download_links sesbasic_dashboard_table_right_links">
	<a href="javascript:;"  class="sescrowdfunding_report_download" data-rel="csv"><i class="fa fa-download sesbasic_text_light"></i><?php echo $this->translate("Download Report in CSV"); ?></a>
  <a href="javascript:;" class="sescrowdfunding_report_download" data-rel="excel"><i class="fa fa-download sesbasic_text_light"></i><?php echo $this->translate("Download Report in Excel"); ?></a>
</div>
<?php endif; ?>
<?php if( isset($this->crowdfundingSaleData) && count($this->crowdfundingSaleData) > 0): ?>
<?php $defaultCurrency = Engine_Api::_()->sescrowdfunding()->defaultCurrency(); ?>
<div class="sescf_donation_reports_table sesbasic_dashboard_table sesbasic_bxs">
  <form method="post" >
    <table>
      <thead>
        <tr>
          <th class="centerT"><?php echo $this->translate("S.No"); ?></th>
           <th><?php echo $this->translate("Donor Name") ?></th>
          <th><?php echo $this->translate("Date of Donation") ?></th>
          <th class="centerT"><?php echo $this->translate("Total Amount") ?></th>
        </tr>
      </thead>
      <tbody>
        <?php 
        	$counter = 1;
          foreach ($this->crowdfundingSaleData as $item): 
          $user = Engine_Api::_()->getItem('user', $item->user_id); 
          ?>
        <tr>
          <td class="centerT"><?php echo $counter; ?></td>
          <td><?php echo $user->getTitle(); ?></td>
          <td><?php echo Engine_Api::_()->sesbasic()->dateFormat($item->creation_date); ?></td> 
          <td class="rightT"><?php echo $item->total_useramount <= 0 ? $this->translate('FREE') : Engine_Api::_()->sescrowdfunding()->getCurrencyPrice($item->total_useramount,$defaultCurrency); ?></td>
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
    <?php echo $this->translate("No one has donated yet.") ?>
  </span>
</div>
<?php endif; ?>
<?php if(!$this->is_ajax){ ?>
    </div>
</div>
</div>
<?php  } ?>
<script type="application/javascript">
sesJqueryObject(document).on('click','.sescrowdfunding_report_download',function(){
	var downloadType = 	sesJqueryObject(this).attr('data-rel');
	if(downloadType == 'csv'){
		sesJqueryObject('#csv').val('1');
	} else {
			sesJqueryObject('#excel').val('1');
	}
	sesJqueryObject('#sescrowdfunding_search_form_sale_report').trigger('submit');
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
