<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: insights.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php if(!$this->is_ajax){ echo $this->partial('dashboard/left-bar.tpl', 'sesgroup', array('group' => $this->group));?>
  <div class="sesgroup_dashboard_content sesbm sesbasic_clearfix sesbasic_bxs">
    <div class="sesgroup_dashboard_content_header sesbasic_clearfix">
      <h3><?php echo $this->translate('Group Statstics'); ?></h3>
      <p><?php echo $this->translate(''); ?></p>
    </div>
<?php }	?>
<?php if(!$this->is_ajax):?>
  <div class="sesgroup_dashboard_graph sesbasic_bxs">
    <div class="sesbasic_filter_tabs sesbasic_clearfix">
      <ul>
        <?php if(1):?>
          <li><a href="javascript:;" rel="hourly" onclick="showIntervalData('hourly', this)" id="group-static-hourly" class="<?php if($this->view_type == 'hourly'):?>active<?php endif;?>"><?php echo $this->translate('Hourly');?></a></li>
        <?php endif;?>
        <?php if(1):?>
          <li><a href="javascript:;" rel="daily" onclick="showIntervalData('daily', this)" id="group-static-daily" class="<?php if($this->view_type == 'daily'):?>active<?php endif;?>"><?php echo $this->translate('Daily');?></a></li>
        <?php endif;?>
        <?php if(1):?>
          <li><a href="javascript:;" rel="weekly" onclick="showIntervalData('weekly', this)" id="group-static-weekly" class="<?php if($this->view_type == 'weekly'):?>active<?php endif;?>"><?php echo $this->translate('Weekly');?></a></li>
        <?php endif;?>
        <?php if(1):?>
          <li><a href="javascript:;" rel="monthly" onclick="showIntervalData('monthly', this)" id="group-static-monthly" class="<?php if($this->view_type == 'monthly'):?>active<?php endif;?>"><?php echo $this->translate('Monthly');?></a></li>
        <?php endif;?>
      </ul>
    </div>
    <div id="chartxcontainer" class="clear sesgroup_dashboard_graph_box"><div class="sesbasic_loading_container" style="height:300px;"></div></div>
    <div id="sesgroup-graph-loading" class="sesbasic_loading_container sesgroup_entry_view_graph_box clear" style="display: none;"></div>
  </div>
  <script src="https://code.highcharts.com/highcharts.js"></script>
<?php endif;?>
<?php if(!$this->is_ajax){ ?>
  </div>
</div>
</div>
<?php  } ?>
<?php if($this->is_ajax) die; ?>

<script type='text/javascript'>//<![CDATA[
function setDateData(containerId,likeCount, commentCount, favouriteCount,viewCount, date,likeHeadingTitle,likBaseTitle,commentHeadingTitle,commentBaseTitle, favouriteHeadingTitle,favouriteBaseTitle, viewHeadingTitle,viewBaseTitle) {
  var jsarrya =date;
    if(typeof date == 'undefined')  {
      jsarrya = [<?php echo implode(',',$this->date)?>];
    }
    if(typeof likeCount == 'undefined')  {
      likeCount = [<?php echo implode(',',$this->like_count)?>];
    }
    if(typeof commentCount == 'undefined')  {
      commentCount = [<?php echo implode(',',$this->comment_count)?>];
    }
    if(typeof favouriteCount == 'undefined')  {
      favouriteCount = [<?php echo implode(',',$this->favourite_count)?>];
    }
    if(typeof viewCount == 'undefined')  {
      viewCount = [<?php echo implode(',',$this->view_count)?>];
    }
    if(typeof likeHeadingTitle == 'undefined')  {
      likeHeadingTitle = '<?php echo $this->likeHeadingTitle?>';
    }
    if(typeof likBaseTitle == 'undefined')  {
      likBaseTitle = '<?php echo $this->likeXAxisTitle?>';
    }
    if(typeof commentHeadingTitle == 'undefined')  {
      commentHeadingTitle = '<?php echo $this->commentHeadingTitle?>';
    }
    if(typeof commentBaseTitle == 'undefined')  {
      commentBaseTitle = '<?php echo $this->commentXAxisTitle?>';
    }
    if(typeof favouriteHeadingTitle == 'undefined')  {
      favouriteHeadingTitle = '<?php echo $this->favouriteHeadingTitle?>';
    }
    if(typeof favouriteBaseTitle == 'undefined')  {
      favouriteBaseTitle = '<?php echo $this->favouriteXAxisTitle?>';
    }
    if(typeof viewHeadingTitle == 'undefined')  {
      viewHeadingTitle = '<?php echo $this->viewHeadingTitle?>';
    }
    if(typeof viewBaseTitle == 'undefined')  {
      viewBaseTitle = '<?php echo $this->viewXAxisTitle?>';
    }
    Highcharts.chart(containerId, {
      chart: {
        type: 'spline',
        animation: Highcharts.svg,
        marginRight: 10 ,
      },
      title: {text: '',},    
	  xAxis: { 
        categories: jsarrya,
         title: {text: 'Date'},    
         }, 
        yAxis: {
         title: {text: 'Count'},
         tooltip: {
             shared: !0,
             crosshairs: !0
         },
        plotOptions: {
          line: {
            dataLabels: {
              enabled: !1
            },
            enableMouseTracking: !0
          },
          credits: {
            enabled: !1
          },
          plotLines: [{
              value: 0,
              width: 1,
              color: '#808080'
          }]
        },
        series: {
            allowPointSelect: true,
            marker: {
                enabled: true
            }
        }
      },
      series: [{
        name: likBaseTitle,
        data: likeCount,
        color:"<?php echo $this->params['likelinecolor'];?>"      
      },
      {
        name: commentBaseTitle,
        data: commentCount,
        color:"<?php echo $this->params['commentlinecolor'];?>"      
      },
      {
        name: favouriteBaseTitle,
        data: favouriteCount,
        color:"<?php echo $this->params['favouritelinecolor'];?>"      
      },
      {
        name: viewBaseTitle,
        data: viewCount,
        color:"<?php echo $this->params['viewlinecolor'];?>"      
      }]
    });
  }
  sesJqueryObject(document).ready(function () {
    Highcharts.setOptions({
      global: {
        useUTC: false
      }
    });
   setDateData('chartxcontainer');
  });
//]]> 
  function showIntervalData(interval, obj) {
    if(sesJqueryObject(obj).hasClass('active'))
      return;
    sesJqueryObject('#chartxcontainer').hide();
    sesJqueryObject('#sesgroup-graph-loading').show();
    sesJqueryObject('#group-static-monthly').removeClass('active');
    sesJqueryObject('#group-static-weekly').removeClass('active');
    sesJqueryObject('#group-static-daily').removeClass('active');
    sesJqueryObject('#group-static-hourly').removeClass('active');
    sesJqueryObject(obj).addClass('active');
    var url = "<?php echo $this->url(array('group_id' => $this->group->custom_url,'action'=>'insights'), 'sesgroup_dashboard', true); ?>"+'/interval/'+interval;
    var request = new Request.JSON({
      'url' : url,
      'method' : 'POST',
      'data':{
        'is_ajax':1,
        'group_id': '<?php echo $this->group->group_id;?>',
        'type':sesJqueryObject(obj).attr('rel'),
        'widget_id':'<?php echo $this->widgetId;?>',
      },   
      onSuccess : function(responseJSON) {
        setDateData('chartxcontainer', responseJSON.likeCount,responseJSON.commentCount, responseJSON.favouriteCount,responseJSON.viewCount,responseJSON.date, responseJSON.likeHeadingTitle, responseJSON.likeXAxisTitle, responseJSON.commentHeadingTitle, responseJSON.commentXAxisTitle,responseJSON.favouriteHeadingTitle, responseJSON.favouriteXAxisTitle,responseJSON.viewHeadingTitle, responseJSON.viewXAxisTitle);
        sesJqueryObject('#sesgroup-graph-loading').hide();
        sesJqueryObject('#chartxcontainer').show();
      }
    });
    request.send();
  }
</script>