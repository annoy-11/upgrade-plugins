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
  <div class="sesweather_middle_block sesweather_bxs">
    <div class="sesweather_top_bar sesweather_bxs">
      <div class="sesweather_topbar_left_block">
        <div class="sesweather_map_marker">
          <img src="./application/modules/Sesweather/externals/images/mapmarker.png" class="" />
        </div>
        <div class="sesweather_map_location" id="sesweather_map_location_<?php echo $this->identity;?>">
          <p><?php echo $this->location;?></p>
        </div>
      </div>
      <div class="sesweather_topbar_right_block">
        <div class="weather_search_location">
          <?php echo $this->form->render($this); ?>
        </div>
      </div>
    </div>
    <div class="weather_middle_banner sesweather_bxs">
      <?php if($this->bgPhoto):?>
        <img src="<?php echo $this->baseUrl().'/'.$this->bgPhoto;?>" class="progress overall-progress" />
      <?php else:?>
        <img src="./application/modules/Sesweather/externals/images/weather_report.jpg" class="" />
      <?php endif;?>
    </div>
  <?php endif;?>
  <div id="sesweather_main_<?php echo $this->identity;?>" class="sesweather_cnt">
    <?php if($this->is_ajax):?>
      <div class="sesweather_main_content sesweather_bxs">
        <div class="content-temperature">
          <div class="temp_value">
            <h2><?php if($temUnit):?><?php echo round(($this->result['currently']['temperature'] - 32)*5/9);?><sup>o</sup>C<?php else:?><?php echo round($this->result['currently']['temperature']);?><sup>o</sup>F<?php endif;?></h2>
          </div>
          <div class="temp_description">
            <h4><?php echo $this->translate(ucwords(str_replace('-', ' ', $this->result['currently']['icon'])));?></h4>
            <?php if($temUnit):?>
              <h4>H <?php echo round(($this->result['daily']['data'][0]['temperatureHigh'] - 32)*5/9);?><sup>o</sup>C &nbsp; L<?php echo round(($this->result['daily']['data'][0]['temperatureLow'] - 32)*5/9);?><sup>o</sup>C</h4>
            <?php else:?>
              <h4>H <?php echo round($this->result['daily']['data'][0]['temperatureHigh']);?><sup>o</sup>F &nbsp; L<?php echo round($this->result['daily']['data'][0]['temperatureLow']);?><sup>o</sup>F</h4>
            <?php endif;?>
          </div>
        </div>
        <?php $message = '';?>
        <?php if ( $Hour >= 5 && $Hour <= 11 ):?>
          <?php $message = Zend_Registry::get('Zend_Translate')->_("Good Morning");?>
        <?php elseif( $Hour >= 12 && $Hour <= 18 ):?>
          <?php $message = Zend_Registry::get('Zend_Translate')->_("Good Afternoon");?>
        <?php elseif ( $Hour >= 19 || $Hour <= 4 ):?>
         <?php $message = Zend_Registry::get('Zend_Translate')->_("Good Evening");?>
        <?php endif;?>
        <h2 class="user_log"><i class="sesweather_wi <?php echo $this->result['currently']['icon'];?>"></i> &nbsp;<?php echo $message;?>&nbsp;<?php if($this->viewer()->getIdentity()):?><?php echo $this->viewer()->displayname;?><?php endif;?></h2>
        <p><?php echo $this->translate("It's ").$this->translate(ucwords(str_replace('-', ' ', $this->result['currently']['icon']))).$this->translate(' Right now ').'.'.$this->translate(' The Forecast today shows a low of ').round(($this->result['daily']['data'][0]['temperatureLow'] - 32)*5/9).$this->translate(' degree.');?></p>
      </div>
      <div class="weather_gray_table sesweather_bxs">
        <?php unset($this->result['hourly']['data'][0]);?>
        <?php $counter = 0;?>
        <?php foreach($this->result['hourly']['data'] as $result):?>
          <?php if($counter == 13):?>
            <?php break;?>
          <?php endif;?>
          <div class="sesweather_gray_table_block">
            <i class="sesweather_wi <?php echo $result['icon'];?>"></i>
            <?php if(date('g A',$result['time']) == '0 AM'):?>
              <h3><?php echo '12 AM';?></h3>
            <?php else:?>
              <h4><?php echo date('g A',$result['time']);?></h4>
            <?php endif;?>
            <?php if($temUnit):?>
              <p><?php echo round(($result['temperature'] - 32)*5/9);?><sup>o</sup>C</p>
            <?php else:?>
              <p><?php echo round($result['temperature']);?><sup>o</sup>F</p>
            <?php endif;?>
          </div>
        <?php endforeach;?>
      </div>
      <div class="sesweather_bottom_table sesweather_bxs">
        <?php unset($this->result['daily']['data'][0]);?>
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
    <?php else:?>
      <div class="sesweather_loading_cont_overlay" style="display:block;"></div>
    <?php endif;?>
  </div>
<?php if(empty($this->is_ajax)):?>
  </div>
  <script type='text/javascript'>
    function sesweatherchangelocation_<?php echo $this->identity;?>(lat,lng) {
      sesJqueryObject("#sesweather_main_<?php echo $this->identity;?>").html('<div class="sesweather_loading_cont_overlay" style="display:block;"></div>');
      (new Request.HTML({
        url: en4.core.baseUrl + "widget/index/mod/sesweather/name/<?php echo $this->widgetName; ?>",
        data: {
          'is_ajax':true,
          'weatherlat': lat,
          'weatherlng': lng,
          'widgetId': <?php echo $this->identity;?>,
          'timezone':Intl.DateTimeFormat().resolvedOptions().timeZone,
          'sesweather_location_search':<?php echo $this->canSearchLocation;?>,
          'weatherlocation':'<?php echo $this->location;?>',
          'sesweather_isintegrate':'<?php echo $this->sesweather_isintegrate;?>',
        },
        onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
          sesJqueryObject("#sesweather_main_<?php echo $this->identity;?>").replaceWith(responseHTML);
          sesJqueryObject("#sesweather_map_location_<?php echo $this->identity;?>").html('<p>'+sesJqueryObject("#locationSesList_<?php echo $this->identity;?>").val()+'</p>');
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
