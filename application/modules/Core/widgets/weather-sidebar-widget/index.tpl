<?php
/**
 * SocialEngine
 *
 * @category   Application_Core
 * @package    Core
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: index.tpl 9747 2012-07-26 02:08:08Z john $
 * @author     John
 */
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Core/externals/styles/style_weather.css'); ?>

<!--Weather Side Bar block-->

<div class="sesweather_sidebar_block sesweather_bxs">
  <div class="sesweather_top_bar sesweather_bxs">
    <div class="weather_icon">
      <img src="/sesforsmt/application/modules/Core/externals/images/weather.svg" alt="map_marker" class="" />
    </div>
    <div class="weather_date">
      <p>9 Aug 2018 - Sat</p>
    </div>
    <div class="reload_icon">
      <i class="fa fa-refresh" aria-hidden="true"></i>
    </div>
  </div>
  <div class="sesweather_clearfix"></div>
  <div class="sesweather_top_lower sesweather_bxs">
    <p>Partly Cloud</p>
    <h1 class="main_temp">77<sup>o</sup>C</h1>
    <p><span>H 33 <sup>o</sup>C</span><span>L 27 <sup>o</sup>C</span></p>
    <h4 class="user_log"><img src="/sesforsmt/application/modules/Core/externals/images/day.svg" class="" />&nbsp;Goodafter Noon User!</h4>
  </div>
  <div class="sesweather_bottom_table sesweather_bxs">
    <div class="day_wise_list">
      <div class="day_name">
        <h5>Sunday</h5>
        <p>Partly Cloud</p>
      </div>
      <div class="day_weather">
        <div class="day_weather_img">
          <img src="/sesforsmt/application/modules/Core/externals/images/rainy-6.svg" alt="map_marker" class="" />
        </div>
        <div class="day_weather_value">
          <span class="gray-shade"><span>H 33 <sup>o</sup>C</span><span>L 27 <sup>o</sup>C</span></span>
        </div>
      </div>
    </div>
    <div class="day_wise_list">
      <div class="day_name">
        <h5>Monday</h5>
        <p>Partly Cloud</p>
      </div>
      <div class="day_weather">
        <div class="day_weather_img">
          <img src="/sesforsmt/application/modules/Core/externals/images/snowy-6.svg" alt="map_marker" class="" />
        </div>
        <div class="day_weather_value">
          <span><span>H 33 <sup>o</sup>C</span><span>L 27 <sup>o</sup>C</span></span>
        </div>
      </div>
    </div>
    <div class="day_wise_list">
      <div class="day_name">
        <h5>Tuesday</h5>
        <p>Partly Cloud</p>
      </div>
      <div class="day_weather">
        <div class="day_weather_img">
          <img src="/sesforsmt/application/modules/Core/externals/images/rainy-6.svg" alt="map_marker" class="" />
        </div>
        <div class="day_weather_value">
          <span><span>H 33 <sup>o</sup>C</span><span>L 27 <sup>o</sup>C</span></span>
        </div>
      </div>
    </div>
    <div class="day_wise_list">
      <div class="day_name">
        <h5>Wednesday</h5>
        <p>Partly Cloud</p>
      </div>
      <div class="day_weather">
        <div class="day_weather_img">
          <img src="/sesforsmt/application/modules/Core/externals/images/night.svg" alt="map_marker" class="" />
        </div>
        <div class="day_weather_value">
          <span><span>H 33 <sup>o</sup>C</span><span>L 27 <sup>o</sup>C</span></span>
        </div>
      </div>
    </div>
    <div class="day_wise_list">
      <div class="day_name">
        <h5>Thursday</h5>
        <p>Partly Cloud</p>
      </div>
      <div class="day_weather">
        <div class="day_weather_img">
          <img src="/sesforsmt/application/modules/Core/externals/images/day.svg" alt="map_marker" class="" />
        </div>
        <div class="day_weather_value">
          <span><span>H 33 <sup>o</sup>C</span><span>L 27 <sup>o</sup>C</span></span>
        </div>
      </div>
    </div>
    <div class="day_wise_list">
      <div class="day_name">
        <h5>Friday</h5>
        <p>Partly Cloud</p>
      </div>
      <div class="day_weather">
        <div class="day_weather_img">
          <img src="/sesforsmt/application/modules/Core/externals/images/rainy-6.svg" alt="map_marker" class="" />
        </div>
        <div class="day_weather_value">
          <span><span>H 33 <sup>o</sup>C</span><span>L 27 <sup>o</sup>C</span></span>
        </div>
      </div>
    </div>
  </div>
</div>

