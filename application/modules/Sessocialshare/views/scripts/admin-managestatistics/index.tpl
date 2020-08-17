<?php
/**
 * SocialEngine
 *
 * @category   Application_Core
 * @package    Core
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: index.tpl 9861 2013-02-12 02:25:28Z john $
 * @author     John
 */
?>
<?php if(empty($this->is_ajax)) { ?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sessocialshare/externals/scripts/chart.js'); 
  $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');
  ?>
  <?php include APPLICATION_PATH .  '/application/modules/Sessocialshare/views/scripts/dismiss_message.tpl';?>
  
  <h3><?php echo $this->translate("Share Statistics on Outside Social Network Services") ?></h3>
  <p><?php echo $this->translate("Here, you can observer the statistics of links shared from your website on other social networking services. The filters below allow you to observe various metrics and their change over different time periods.") ?></p>
  <br />  
  <div class="admin_search sessocialshare_stats_search_form">
    <div class="search">
      <?php echo $this->filterForm->render($this) ?>
    </div>
  </div>
  <br />
<?php } ?>
<?php if(empty($this->is_ajax)) { ?>
  <div style="position:relative;" id="sessocialshare_main_stats">
<?php } ?>
	<div class="sessocialshare_stats_container">
    <div id="sessosh_statscontent" class="sessocialshare_stats_table">
    	<div class="sessocialshare_stats_total"><?php echo $this->translate('Total Share Count: %s', $this->totalCount); ?></div>
      <div style="border-color:#3B5998;">
        <span><?php echo "Facebook" ?></span>
        <span style="color:#3B5998;"><?php if($this->facebook) { echo $this->facebook; } else { echo '0'; } ?></span>
      </div>
      <div style="border-color:#4099FF;">
        <span><?php echo "Twitter" ?></span>
        <span style="color:#4099FF;"><?php if($this->twitter) { echo $this->twitter; } else { echo '0'; } ?></span>
      </div>
      <div style="border-color:#cb2027;">
        <span><?php echo "Pinterest" ?></span>
        <span style="color:#cb2027;"><?php if($this->pinterest) { echo $this->pinterest; } else { echo '0'; } ?></span>
      </div>
      <div style="border-color:#DC4E41;">
        <span><?php echo "Google Plus" ?></span>
        <span style="color:#DC4E41;"><?php if($this->googleplus) { echo $this->googleplus; } else { echo '0'; } ?></span>
      </div>
      <div style="border-color:#0077b5;">
        <span><?php echo "Linkedin" ?></span>
        <span style="color:#0077b5;"><?php if($this->linkedin) { echo $this->linkedin; } else { echo '0'; } ?></span>
      </div>
      <div style="border-color:#db4437;">
        <span><?php echo "Gmail" ?></span>
        <span style="color:#db4437;"><?php if($this->gmail) { echo $this->gmail; } else { echo '0'; } ?></span>
      </div>
      <div style="border-color:#2E4F6E;">
        <span><?php echo "Tumblr" ?></span>
        <span style="color:#2E4F6E;"><?php if($this->tumblr) { echo $this->tumblr; } else { echo '0'; } ?></span>
      </div>
      <div style="border-color:#000;">
        <span><?php echo "Digg" ?></span>
        <span style="color:#000;"><?php if($this->digg) { echo $this->digg; } else { echo '0'; } ?></span>
      </div>
      <div style="border-color:#EE4813;">
        <span><?php echo "Stumbleupon" ?></span>
        <span style="color:#EE4813;"><?php if($this->stumbleupon) { echo $this->stumbleupon; } else { echo '0'; } ?></span>
      </div>
      <div style="border-color:#039;">
        <span><?php echo "Myspace" ?></span>
        <span style="color:#039;"><?php if($this->myspace) { echo $this->myspace; } else { echo '0'; } ?></span>
      </div>
      <div style="border-color:#0084FF;">
        <span><?php echo "Facebook Messager" ?></span>
        <span style="color:#0084FF;"><?php if($this->facebookmessager) { echo $this->facebookmessager; } else { echo '0'; } ?></span>
      </div>
      <div style="border-color:#EC2127;">
        <span><?php echo "Rediff" ?></span>
        <span style="color:#EC2127;"><?php if($this->rediff) { echo $this->rediff; } else { echo '0'; } ?></span>
      </div>
      <div style="border-color:#FFA500;">
        <span><?php echo "Google Bookmark" ?></span>
        <span style="color:#FFA500;"><?php if($this->googlebookmark) { echo $this->googlebookmark; } else { echo '0'; } ?></span>
      </div>
      <div style="border-color:#EC2127;">
        <span><?php echo "Flipboard" ?></span>
        <span style="color:#EC2127;"><?php if($this->flipboard) { echo $this->flipboard; } else { echo '0'; } ?></span>
      </div>
      <div style="border-color:#00AFF0;">
        <span><?php echo "Skype" ?></span>
        <span style="color:#00AFF0;"><?php if($this->skype) { echo $this->skype; } else { echo '0'; } ?></span>
      </div>
      <div style="border-color:#00E676;">
        <span><?php echo "Whatsapp" ?></span>
        <span style="color:#00E676;"><?php if($this->whatsapp) { echo $this->whatsapp; } else { echo '0'; } ?></span>
      </div>
      <div style="border-color:#787878;">
        <span><?php echo "Email" ?></span>
        <span style="color:#787878;"><?php if($this->email) { echo $this->email; } else { echo '0'; } ?></span>
      </div>
      <div style="border-color:#436eab;">
        <span><?php echo "VK" ?></span>
        <span style="color:#436eab;"><?php if($this->vk) { echo $this->vk; } else { echo '0'; } ?></span>
      </div>
      <div style="border-color:#7f40bd;">
        <span><?php echo "Yahoo" ?></span>
        <span style="color:#7f40bd;"><?php if($this->yahoo) { echo $this->yahoo; } else { echo '0'; } ?></span>
      </div>
    </div>
  	<div id="piechart" class="sessocialshare_stats_chart"></div>
  	<div class="sesbasic_loading_cont_overlay" id="sessocialshare_loading_cont_overlay"></div>
  	<div id="error_message" class="tip" style="display:none;">
      <span>
        <?php echo "There are no no results.";?>
      </span>
    </div>
	</div>
<?php if(empty($this->is_ajax)) { ?>
</div>
<?php } ?>

<script type="text/javascript">
 
  var pageurl1 = 0;
  function showsearch() {
  
    if(sesJqueryObject('#pageurlsearcha').hasClass('block')) {
      sesJqueryObject('#pageurl1-wrapper').hide();
      sesJqueryObject('#pageurl-wrapper').show();
      sesJqueryObject('#pageurlsearcha').addClass('none').removeClass('block');
      sesJqueryObject('#pageurlsearcha').html('Show Page URLs');
      sesJqueryObject('#pageurl1').val('');
      pageurl1 = 0;
    } else {
      sesJqueryObject('#pageurl1-wrapper').show();
      pageurl1 = 1;
      sesJqueryObject('#pageurl-wrapper').hide();
      sesJqueryObject('#pageurlsearcha').removeClass('none').addClass('block');
      sesJqueryObject('#pageurlsearcha').html('Enter Page URL');
    }
  }

  sesJqueryObject(document).ready(function() {
    
    <?php if(empty($this->is_ajax)): ?>
      sesJqueryObject('#pageurl1-wrapper').hide();
    <?php endif; ?>
    
    sesJqueryObject('#sessocialshare_stats').submit(function(e) {

      e.preventDefault();
      
      $('sessocialshare_loading_cont_overlay').style.display='block';
      searchStats = new Request.HTML({
        method: 'post',
        'url': en4.core.baseUrl + 'admin/sessocialshare/managestatistics',
        'data': {
          format: 'html',    
          params : sesJqueryObject(this).serialize(),
          pageurl1: pageurl1,
          is_ajax : 1,
        },
        onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {

          <?php if($this->pageurlcount == 0) { ?>
            sesJqueryObject('#piechart').hide();
            sesJqueryObject('#error_message').show();
          <?php } else { ?>
            drawChart();
            sesJqueryObject('#piechart').show();
            sesJqueryObject('#error_message').hide();
          <?php } ?>
          sesJqueryObject('#sessocialshare_main_stats').html(responseHTML);
          $('sessocialshare_loading_cont_overlay').style.display='none';
        }
      });
      searchStats.send();
      return false;
    
    });

  });

  google.charts.load("current", {packages:["corechart"]});
  google.charts.setOnLoadCallback(drawChart);
  
  function drawChart() {
    var data = google.visualization.arrayToDataTable([
      ['Language', 'Speakers (in millions)'],
      ['Facebook', <?php if($this->facebook) { echo $this->facebook; } else { echo '0'; } ?>], 
      ['Twitter', <?php if($this->twitter) { echo $this->twitter; } else { echo '0'; } ?>],
      ['Pinterest', <?php if($this->pinterest) { echo $this->pinterest; } else { echo '0'; } ?>],
      ['Google Plus', <?php if($this->googleplus) { echo $this->googleplus; } else { echo '0'; } ?>],
      ['Linkedin', <?php if($this->linkedin) { echo $this->linkedin; } else { echo '0'; } ?>],
      ['Gmail', <?php if($this->gmail) { echo $this->gmail; } else { echo '0'; } ?>],
      ['Tumblr', <?php if($this->tumblr) { echo $this->tumblr; } else { echo '0'; } ?>], 
      ['Digg', <?php if($this->digg) { echo $this->digg; } else { echo '0'; } ?>],
      ['Stumbleupon', <?php if($this->stumbleupon) { echo $this->stumbleupon; } else { echo '0'; } ?>],
      ['Myspace', <?php if($this->myspace) { echo $this->myspace; } else { echo '0'; } ?>], 
      ['Facebook Messager', <?php if($this->facebookmessager) { echo $this->facebookmessager; } else { echo '0'; } ?>], 
      ['Rediff', <?php if($this->rediff) { echo $this->rediff; } else { echo '0'; } ?>],
      ['Google Bookmark', <?php if($this->googlebookmark) { echo $this->googlebookmark; } else { echo '0'; } ?>], 
      ['Flipboard', <?php if($this->flipboard) { echo $this->flipboard; } else { echo '0'; } ?>], 
      ['Skype', <?php if($this->skype) { echo $this->skype; } else { echo '0'; } ?>],
      ['Whatsapp', <?php if($this->whatsapp) { echo $this->whatsapp; } else { echo '0'; } ?>],
      ['Email', <?php if($this->email) { echo $this->email; } else { echo '0'; } ?>],
      ['VK', <?php if($this->vk) { echo $this->vk; } else { echo '0'; } ?>],
      ['Yahoo', <?php if($this->yahoo) { echo $this->yahoo; } else { echo '0'; } ?>],
    ]);

     var options = {
      //title: 'Social Share Statistics',
      chartArea:{left:200,top:20},
      //legend: 'top',
       //backgroundColor:'red',
//       pieSliceText: 'label',
//       slices: {  4: {offset: 0.2},
//                 12: {offset: 0.3},
//                 14: {offset: 0.4},
//                 15: {offset: 0.5},
//       },
        slices: {
          0: { color: '#3B5998' },
          1: { color: '#4099FF' },
          2: { color: '#cb2027' },
          3: { color: '#DC4E41' },
          4: { color: '#0077b5' },
          5: { color: '#db4437' },
          6: { color: '#2E4F6E' },
          7: { color: '#000' },
          8: { color: '#EE4813' },
          9: { color: '#003399' },
          10: { color: '#3B5998' },
          11: { color: '#EC2127' },
          12: { color: '#FFA500' },
          13: { color: '#EC2127' },
          14: { color: '#00AFF0' },
          15: { color: '#00E676' },
          16: { color: '#787878' },
          17: { color: '#436eab' },
          18: { color: '#7f40bd' },
        }
     };

    var chart = new google.visualization.PieChart(document.getElementById('piechart'));
    chart.draw(data, options);
  }
</script>