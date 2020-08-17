<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesweather
 * @package    Sesweather
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-08-24 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

 ?>
<?php ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesweather/externals/styles/style_weather.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesweather/externals/scripts/core.js'); ?>
<?php if ($this->timezone):?>
<?php $currentTimezone = date_default_timezone_get();?>
<?php date_default_timezone_set($this->timezone);?>
<?php endif;?>
<?php $temUnit = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesweather.tempunit',1);?>
<?php if(empty($this->is_ajax)):?>
<div class="sesweather_<?php if($this->template):?>Dark_bg_block<?php else:?>Light_bg_block<?php endif;?> sesweather_bxs sesweather_clearfix" <?php if(!empty($this->bgPhoto)):?>style="background-image:url(<?php echo $this->bgPhoto; ?>"<?php endif;?>>
<div class="sesweather_top_bar sesweather_clearfix">
  <?php if($this->canSearchLocation):?>
  <div class="sesweather_select_box">
    <?php echo $this->form->render($this); ?>
    <p><?php echo $this->translate('Enter Your Place');?></p>
  </div>
  <?php endif;?>
  <div class="sesweather_tabs">
    <div class="weather_view_format_tabs weather_view_format_tabs_<?php echo $this->identity;?>">
      <button class="tablinks sesweather_button_tabs active" data-rel="dayforecast"><?php echo $this->translate('7 Day Forecast');?></button>
      <button class="tablinks sesweather_button_tabs" data-rel="hourly"><?php echo $this->translate('Hourly');?></button>
    </div>
  </div>
</div>
<?php endif;?>
<div id="sesweather_main_<?php echo $this->identity;?>" class="sesweather_cnt">
  <?php if($this->is_ajax):?>
  <div class="sesweather_middle_content">
    <div class="weather_icon">
      <i class="sesweather_wi <?php echo $this->result['currently']['icon'];?>"></i>
      <?php if($temUnit):?>
      <h2><?php echo round(($this->result['currently']['temperature'] - 32)*5/9);?><sup>o</sup>C</h2>
      <?php else:?>
      <h2><?php echo round($this->result['currently']['temperature']);?><sup>o</sup>F</h2>
      <?php endif;?>
    </div>
    <div class="weather_desc">
      <h2><?php echo $this->translate($this->result['currently']['summary']);?></h2>
      <div class="weather_detail_desc">
        <div class="weather_part_desc">
          <?php if($temUnit):?>
          	<p><?php echo $this->translate('Feels Like ');?><span><?php echo round(($this->result['currently']['apparentTemperature'] - 32)*5/9);?><sup>o</sup>C</span></p>
          <?php else:?>
          	<p><?php echo $this->translate('Feels Like ');?><span><?php echo round($this->result['currently']['apparentTemperature']);?><sup>o</sup>F</span></p>
          <?php endif;?>
          <p><?php echo $this->translate('Visibility ');?><span><?php echo round(($this->result['currently']['visibility']*1.609));?>Km</span></p>
        </div>
        <div class="weather_part_desc">
          <p><?php echo $this->translate('Wind ');?><i class="fa fa-angle-double-up"></i><span><?php echo round(($this->result['currently']['windSpeed']*1.609344));?> Km/h</span></p>
          <p><?php echo $this->translate('Humidity ');?><span><?php echo ($this->result['currently']['humidity']*100);?>%</span></p>
        </div>
        <div class="weather_part_desc">
          <p><?php echo $this->translate('Barometer ');?><span><?php echo $this->result['currently']['pressure'].'Mb';?></span></p>
          <p><?php echo $this->translate('Due Point ');?><span><?php echo round(($this->result['currently']['dewPoint'] - 32)*5/9);?><sup>o</sup></span></p>
        </div>
      </div>
    </div>
  </div>
  <div class="sesweather_middle_bottom_block dayforecast">
    <?php foreach($this->result['daily']['data'] as $result):?>
    <div class="sesweather_bottom_day">
      <div class="day_name">
        <h4><?php echo $this->translate(date('l',$result['time']));?></h4>
      </div>
      <div class="sesweather_bottom_day_expand">
        <div class="non-expand">
          <div class="day_weather">
            <i class="sesweather_wi <?php echo $result['icon'];?>"></i>
            <p><?php echo $this->translate(ucwords(str_replace('-', ' ', $result['icon'])));?></p>
            <?php if($temUnit):?>
            <h3><?php echo round(($result['temperatureHigh'] - 32)*5/9);?><sup>o</sup>C</h3>
            <?php else:?>
            <h3><?php echo round($result['temperatureHigh']);?><sup>o</sup>F</h3>
            <?php endif;?>
            <span><i class="sesweather_wi humidity"></i>&nbsp;<?php echo ($result['humidity']*100).'%';?></span>
          </div>
        </div>
        <div class="border"></div>
        <div class="expand_desc">
          <div class="expand_list">
            <div class="desc_left">
              <i class="sesweather_wi precipitation"></i>
              <p><?php echo $this->translate('Precipitation-').($result['precipProbability']*100).'%';?></p>
            </div>
          </div>
          <div class="expand_list">
            <div class="desc_left">
              <i class="sesweather_wi wind"></i>
              <p><?php echo $this->translate('Wind');?>-<?php echo round($result['windSpeed']*1.609344).$this->translate(' Km/h SSW');?></p>
            </div>
          </div>
          <div class="expand_list">
            <div class="desc_left">
              <i class="sesweather_wi humidity"></i>
              <p><?php echo $this->translate('Humidity-').($result['humidity']*100).'%';?></p>
            </div>
          </div>
          <div class="expand_list">
            <div class="desc_left">
              <i class="sesweather_wi clear-day"></i>
              <p><?php echo $this->translate('UV Index-').$result['uvIndex'];?></p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php endforeach;?>
  </div>
  <div class="sesweather_middle_bottom_block hourly" style="display:none;">
    <?php $counter = 0;?>
    <?php foreach($this->result['hourly']['data'] as $result):?>
    <?php if($counter == 13):?>
    <?php break;?>
    <?php endif;?>
    <div class="sesweather_bottom_day">
      <div class="day_name">
        <?php if(date('g A',$result['time']) == '0 AM'):?>
        <h4><?php echo '12 AM';?></h4>
        <?php else:?>
        <h4><?php echo date('g A',$result['time']);?></h4>
        <?php endif;?>
      </div>
      <div class="day_weather">
        <i class="sesweather_wi <?php echo $result['icon'];?>"></i>
        <?php if($temUnit):?>
        <h3><?php echo round(($result['temperature'] - 32)*5/9);?> <sup>o</sup>C</h3>
        <?php else:?>
        <h3><?php echo round($result['temperature']);?> <sup>o</sup>F</h3>
        <?php endif;?>
        <span><i class="sesweather_wi humidity"></i>&nbsp;<?php echo ($result['humidity']*100).'%';?></span>
      </div>
    </div>
    <?php $counter++;?>
    <?php endforeach;?>
  </div>
  <?php else:?>
  <div class="sesweather_loading_cont_overlay" style="height:100%;display:block;"></div>
  <?php endif;?>
</div>
<?php if(empty($this->is_ajax)):?>
</div>
<script type='text/javascript'>
    function sesweatherchangelocation_<?php echo $this->identity;?>(lat,lng) {
        sesJqueryObject("#sesweather_main_<?php echo $this->identity;?>").html('<div class="sesweather_loading_cont_overlay" style="height:100%;display:block;"></div>');
        (new Request.HTML({
            url: en4.core.baseUrl + "widget/index/mod/sesweather/name/<?php echo $this->widgetName; ?>",
            data: {
                'is_ajax':true,
                'weatherlat': lat,
                'weatherlng': lng,
                'widgetId': <?php echo $this->identity;?>,
        'timezone':Intl.DateTimeFormat().resolvedOptions().timeZone,
            'sesweather_location_search':<?php echo $this->canSearchLocation;?>,
        'sesweather_temdesign':<?php echo $this->template;?>,
        'sesweather_isintegrate':'<?php echo $this->sesweather_isintegrate;?>',
    },
        onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
            sesJqueryObject("#sesweather_main_<?php echo $this->identity;?>").replaceWith(responseHTML);
            var reltype = sesJqueryObject(".weather_view_format_tabs_<?php echo $this->identity;?>").find(".sesweather_button_tabs.active").data('rel');
            sesJqueryObject(".weather_view_format_tabs_<?php echo $this->identity;?>").find('.sesweather_button_tabs').removeClass('active');
            sesJqueryObject(".weather_view_format_tabs_<?php echo $this->identity;?>").find(".sesweather_button_tabs[data-rel="+reltype+"]").trigger('click');
        }
    })).send();
    }
    window.addEvent('domready', function() {
      <?php if(!empty($this->lat)):?>
        sesweatherchangelocation_<?php echo $this->identity;?>(<?php echo $this->lat;?>,<?php echo $this->lng;?>);
      <?php endif;?>
    });
</script>
<?php endif;?>
<?php if($currentTimezone):?>
<?php date_default_timezone_set($currentTimezone);?>
<?php endif;?>
<?php if(!empty($this->is_ajax)):die;?>
<?php endif;?>
