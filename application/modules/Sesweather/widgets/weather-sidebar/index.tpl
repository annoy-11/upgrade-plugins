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
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesweather/externals/styles/style_weather.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesweather/externals/scripts/core.js'); ?>
<?php if ($this->timezone):?>
  <?php $currentTimezone = date_default_timezone_get();?>
  <?php date_default_timezone_set($this->timezone);?>
  <?php $Hour = date('G');?>
<?php endif;?>
<?php $temUnit = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesweather.tempunit',1);?>

<?php if(empty($this->is_ajax)):?>
  <div class="sesweather_sidebar_block sesweather_bxs">
<?php endif;?>
  <div id="sesweather_main_<?php echo $this->identity;?>" class="sesweather_cnt">
    <?php if($this->is_ajax):?>
      <div class="sesweather_top_bar sesweather_bxs sesweather_clearfix">
        <div class="weather_icon">
          <i class="sesweather_wi cloudy"></i>
        </div>
        <div class="weather_date">
          <p><?php echo date('j',$this->result['daily']['data']['0']['time']);?>&nbsp;<?php echo $this->translate(date('M',$this->result['daily']['data']['0']['time']));?>&nbsp;<?php echo date('Y',$this->result['daily']['data']['0']['time']);?> - <?php echo $this->translate(date('D',$this->result['daily']['data']['7']['time']));?></p>
        </div>
        <div class="reload_icon">
          <a href="javascript:void(0);" onclick="sesweatherchangelocation_<?php echo $this->identity;?>(<?php echo $this->lat;?>,<?php echo $this->lng;?>);"><i class="fa fa-refresh" aria-hidden="true"></i></a>
        </div>
      </div>
      <div class="sesweather_top_lower sesweather_bxs">
        <p class="_tt"><?php echo $this->translate(ucwords(str_replace('-', ' ', $this->result['currently']['icon'])));?></p>
        <h2 class="main_temp"><?php if($temUnit):?><?php echo round(($this->result['currently']['temperature'] - 32)*5/9);?><sup>o</sup>C<?php else:?><?php echo round($this->result['currently']['temperature']);?><sup>o</sup>F<?php endif;?></h2>
        <?php if($temUnit):?>
          <p class="_bt"><span>H <?php echo round(($this->result['daily']['data'][0]['temperatureHigh'] - 32)*5/9);?><sup>o</sup>C</span><span> L <?php echo round(($this->result['daily']['data'][0]['temperatureLow'] - 32)*5/9);?><sup>o</sup>C</span></p>
        <?php else:?>
          <p class="_bt"><span>H <?php echo round($this->result['daily']['data'][0]['temperatureHigh']);?><sup>o</sup>F</span><span>  L <?php echo round($this->result['daily']['data'][0]['temperatureLow']);?><sup>o</sup>F</span></p>
        <?php endif;?>
        <?php $message = '';?>
        <?php if ( $Hour >= 5 && $Hour <= 11 ):?>
          <?php $message = Zend_Registry::get('Zend_Translate')->_("Good Morning");?>
        <?php elseif( $Hour >= 12 && $Hour <= 18 ):?>
          <?php $message = Zend_Registry::get('Zend_Translate')->_("Good Afternoon");?>
        <?php elseif ( $Hour >= 19 || $Hour <= 4 ):?>
         <?php $message = Zend_Registry::get('Zend_Translate')->_("Good Evening");?>
        <?php endif;?>
        <h4 class="user_log"><i class="sesweather_wi <?php echo $this->result['currently']['icon'];?>"></i> &nbsp;<?php echo $message;?>&nbsp;<?php if($this->viewer()->getIdentity()):?><?php echo $this->viewer()->displayname;?><?php endif;?></h4>
      </div>
      <?php if($this->showdays):?>
        <div class="sesweather_bottom_table sesweather_bxs">
          <?php foreach($this->result['daily']['data'] as $result):?>
            <div class="day_wise_list">
              <div class="day_name">
                <h5><?php echo $this->translate(date('l',$result['time']));?></h5>
                <p><?php echo $this->translate(ucwords(str_replace('-', ' ', $result['icon'])));?></p>
              </div>
              <div class="day_weather">
                <div class="day_weather_img">
                  <i class="sesweather_wi <?php echo $result['icon'];?>"></i>
                </div>
                <div class="day_weather_value">
                  <?php if($temUnit):?>
                    <span class="gray-shade"><span >H <?php echo round(($result['temperatureHigh'] - 32)*5/9);?><sup>o</sup>C</span><span> L <?php echo round(($result['temperatureLow'] - 32)*5/9);?><sup>o</sup>C</span></span>
                  <?php else:?>
                    <span class="gray-shade"><span>H <?php echo round($result['temperatureHigh']);?><sup>o</sup>F</span><span>  L <?php echo round($result['temperatureLow']);?><sup>o</sup>F</span></span>
                  <?php endif;?>
                </div>
              </div>
            </div>
          <?php endforeach;?>
        </div>
      <?php endif;?>
    <?php else:?>
      <div class="sesweather_loading_cont_overlay"></div>
    <?php endif;?>
  </div>
<?php if(empty($this->is_ajax)):?>
  </div>
  <script type='text/javascript'>
    function sesweatherchangelocation_<?php echo $this->identity;?>(lat,lng) {
      sesJqueryObject("#sesweather_main_<?php echo $this->identity;?>").html('<div class="sesweather_loading_cont_overlay"></div>');
      (new Request.HTML({
        url: en4.core.baseUrl + "widget/index/mod/sesweather/name/<?php echo $this->widgetName; ?>",
        data: {
          'is_ajax':true,
          'weatherlat': lat,
          'weatherlng': lng,
          'widgetId': <?php echo $this->identity;?>,
          'timezone':Intl.DateTimeFormat().resolvedOptions().timeZone,
          'sesweather_isintegrate':'<?php echo $this->sesweather_isintegrate;?>',
        },
        onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
          sesJqueryObject("#sesweather_main_<?php echo $this->identity;?>").replaceWith(responseHTML);
        }
      })).send();  
    }
    window.addEvent('domready', function() {
      sesweatherchangelocation_<?php echo $this->identity;?>(<?php echo $this->lat;?>,<?php echo $this->lng;?>);
    });
  </script>
<?php endif;?>
<?php if($currentTimezone):?>
  <?php date_default_timezone_set($currentTimezone);?>
<?php endif;?>
<?php if(!empty($this->is_ajax)):die;?>
<?php endif;?>