<?php ?>

<div class="header_google_ads">
  <?php
  $content =  $this->content()->renderWidget('sesadvancedheader.ad-campaign');
  echo preg_replace('#<script(.*?)>(.*?)</script>#is', '', $content)
  ?>
</div>
<script type="application/javascript">
  en4.core.runonce.add(function() {
    var url = '<?php echo $this->url(array('module' => 'core', 'controller' => 'utility', 'action' => 'advertisement'), 'default', true) ?>';
    var processClick = window.processClick = function(adcampaign_id, ad_id) {
      (new Request.JSON({
        'format': 'json',
        'url' : url,
        'data' : {
          'format' : 'json',
          'adcampaign_id' : adcampaign_id,
          'ad_id' : ad_id
        }
      })).send();
    }
  });
</script>