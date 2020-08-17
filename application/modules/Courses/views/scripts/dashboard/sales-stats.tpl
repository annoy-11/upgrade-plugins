<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: sales-stats.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php if(!$this->is_ajax){ 
  echo $this->partial('dashboard/left-bar.tpl', 'courses', array(
 	 'course' => $this->course,
  ));	
?>
<div class="courses_dashboard_content sesbm sesbasic_clearfix">
<?php $defaultCurrency = Engine_Api::_()->courses()->defaultCurrency(); ?>
  <div class="courses_dashboard_content_header sesbasic_clearfix">
    <h3><?php echo $this->translate("Sales Stats"); ?></h3>
  </div>
  <div class="courses_sale_stats_container sesbasic_bxs sesbasic_clearfix">
  	<div class="courses_sale_stats">
    	<span><?php echo $this->translate("Today"); ?></span>
      <span><?php echo Engine_Api::_()->courses()->getCurrencyPrice($this->todaySale,$defaultCurrency); ?></span>
    </div>
  	<div class="courses_sale_stats">
    	<span><?php echo $this->translate("This Week"); ?></span>
      <span><?php echo Engine_Api::_()->courses()->getCurrencyPrice($this->weekSale,$defaultCurrency); ?></span>
    </div>
  	<div class="courses_sale_stats">
    	<span><?php echo $this->translate("This Month"); ?></span>
      <span><?php echo Engine_Api::_()->courses()->getCurrencyPrice($this->monthSale,$defaultCurrency); ?></span>
    </div>
  </div>
  <div class="courses_dashboard_ticket_statics sesbasic_bxs sesbasic_clearfix">
   <div class="courses_dashboard_content_header sesbasic_clearfix">
      <h3><?php echo $this->translate("Order Statistics"); ?></h3>
    </div>
    <div class="courses_sale_stats_container sesbasic_bxs sesbasic_clearfix">
      <div class="courses_sale_stats"><span><?php echo $this->translate("Total Order"); ?></span><span><?php echo $this->courseStatsSale['totalOrder'] ?></span></div>
        <div class="courses_sale_stats"><span><?php echo $this->translate("Total Courses Sold"); ?></span><span><?php echo $this->courseStatsSale['total_courses'] ?></span></div>
        <div class="courses_sale_stats"><span><?php echo $this->translate("Total Commission Amount"); ?></span><span><?php echo Engine_Api::_()->courses()->getCurrencyPrice($this->courseStatsSale['commission_amount'],$defaultCurrency) ?> </span></div>
        <div class="courses_sale_stats"><span><?php echo $this->translate("Total Tax Amount"); ?></span><span><?php echo Engine_Api::_()->courses()->getCurrencyPrice($this->courseStatsSale['total_billingtax_cost'],$defaultCurrency); ?></span></div>
    </div>
  </div>
  <div class="course_dashboard_graph sesbasic_bxs">
    <div class="sesbasic_filter_tabs sesbasic_clearfix">
      <ul>
          <li><a href="javascript:;" rel="hourly" onclick="showIntervalData('hourly', this)" id="course-static-hourly" class="<?php if($this->view_type == 'hourly'):?>active<?php endif;?>"><?php echo $this->translate('Hourly');?></a></li>
          <li><a href="javascript:;" rel="daily" onclick="showIntervalData('daily', this)" id="course-static-daily" class="<?php if($this->view_type == 'daily'):?>active<?php endif;?>"><?php echo $this->translate('Daily');?></a></li>
          <li><a href="javascript:;" rel="weekly" onclick="showIntervalData('weekly', this)" id="course-static-weekly" class="<?php if($this->view_type == 'weekly'):?>active<?php endif;?>"><?php echo $this->translate('Weekly');?></a></li>
          <li><a href="javascript:;" rel="monthly" onclick="showIntervalData('monthly', this)" id="course-static-monthly" class="<?php if($this->view_type == 'monthly'):?>active<?php endif;?>"><?php echo $this->translate('Monthly');?></a></li>
      </ul>
    </div>
    <div id="chartxcontainer" class="clear course_dashboard_graph_box"><div class="sesbasic_loading_container" style="height:300px;"></div></div>
    <div id="course-graph-loading" class="sesbasic_loading_container course_entry_view_graph_box clear" style="display: none;"></div>
  </div>
  <script src="https://code.highcharts.com/highcharts.js"></script>
  <script src="https://code.highcharts.com/modules/series-label.js"></script>
  <script src="https://code.highcharts.com/modules/exporting.js"></script>
  <script src="https://code.highcharts.com/modules/export-data.js"></script>
</div>
</div>
</div>
<?php  } ?>
<script>
function setDateData(containerId,date,totalOrders,commissionAmount,totalAmount,totalTaxCost, totalAmountSale) {
    if(typeof date == 'undefined')  {
      date = [<?php echo implode(',',$this->date)?>];
    }
    if(typeof totalOrders == 'undefined')  {
      totalOrders = [<?php echo implode(',',$this->total_orders)?>];
    }
    if(typeof commissionAmount == 'undefined')  {
      commissionAmount = [<?php echo implode(',',$this->commission_amount)?>];
    }
    if(typeof totalAmount == 'undefined')  {
      totalAmount = [<?php echo implode(',',$this->total_amount)?>];
    }
    if(typeof totalTaxCost == 'undefined')  {
      totalTaxCost = [<?php echo implode(',',$this->total_tax_cost)?>];
    }
    if(typeof totalAmountSale == 'undefined')  {
      totalAmountSale = [<?php echo implode(',',$this->totalAmountSale)?>];
    }
  
  Highcharts.chart(containerId, {
      title: {
          text: 'Sale Repost'
      },
      subtitle: {
          text: ''
      },
      xAxis: { 
        categories: date,
        title: {text: 'Date'},    
      }, 
      yAxis: {
          title: {
              text: 'Amount'
          }
      },
      legend: {
          layout: 'vertical',
          align: 'right',
          verticalAlign: 'middle'
      },
      series: [/*{
          name: 'Total Orders',
          data: totalOrders
      },*/{
          name: 'Commission Amount',
          data: commissionAmount
      }, {
          name: 'Total Amount',
          data: totalAmount
      }, {
          name: 'Total Tax Cost',
          data: totalTaxCost
      }, {
          name: 'Total Sale Amount',
          data: totalAmountSale
      }],
      responsive: {
          rules: [{
              condition: {
                  maxWidth: 500
              },
              chartOptions: {
                  legend: {
                      layout: 'horizontal',
                      align: 'center',
                      verticalAlign: 'bottom'
                  }
              }
          }]
      }
  });
}
  sesJqueryObject(document).ready(function () {
    Highcharts.setOptions({
      global: {
        useUTC: false
      }
    });
    setDateData('chartxcontainer');
    sesJqueryObject('.highcharts-credits').hide();
  });
  function showIntervalData(interval, obj) {
    if(sesJqueryObject(obj).hasClass('active'))
      return;
    sesJqueryObject('#chartxcontainer').hide();
    sesJqueryObject('#course-graph-loading').show();
    sesJqueryObject('#course-static-monthly').removeClass('active');
    sesJqueryObject('#course-static-weekly').removeClass('active');
    sesJqueryObject('#course-static-daily').removeClass('active');
    sesJqueryObject('#course-static-hourly').removeClass('active');
    sesJqueryObject(obj).addClass('active');
    var url = "<?php echo $this->url(array('course_id' => $this->course->custom_url,'action'=>'sales-stats'), 'courses_dashboard', true); ?>"+'/interval/'+interval;
    var request = new Request.JSON({
      'url' : url,
      'method' : 'POST',
      'data':{
        'is_ajax':1,
        'course_id': '<?php echo $this->course->course_id;?>',
        'type':sesJqueryObject(obj).attr('rel'),
      },   
      onSuccess : function(responseJSON) {
        setDateData('chartxcontainer', responseJSON.date,responseJSON.total_orders, responseJSON.commission_amount,responseJSON.total_amount,responseJSON.total_tax_cost, responseJSON.totalAmountSale);
        sesJqueryObject('#course-graph-loading').hide();
        sesJqueryObject('#chartxcontainer').show();
      }
    });
    request.send();
  }
  
</script>
<?php if($this->is_ajax) die; ?>
