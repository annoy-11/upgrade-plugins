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

<!--Weather Middle Bar block-->

<div class="sesweather_middle_block sesweather_bxs">
  <!--Weather Middle_Bar top_bar-->
  <div class="sesweather_top_bar sesweather_bxs">
    <!--Weather top-left bar-->
    <div class="sesweather_topbar_left_block">
      <div class="sesweather_map_marker">
        <img src="/sesforsmt/application/modules/Core/externals/images/mapmarker.png" class="" />
      </div>
      <div class="sesweather_map_location">
        <p>Kanpur, UttarPradesh</p>
      </div>
    </div>
    <!--/Weather Top Left bar-->
    <!--Weather Top Right Bar-->
    <div class="sesweather_topbar_right_block">
      <div class="weather_search_location">
        <form action="">
          <input type="text" placeholder="Search Location" name="search">
          <button type="submit"><i class="fa fa-search"></i></button>
        </form>
      </div>
    </div>
    <!--/Weather Top Right bar-->
  </div>
  <!--/Weather middle_Bar Top_bar-->

  <!--Weather Middle banner section-->
  <div class="weather_middle_banner sesweather_bxs">
    <img src="/sesforsmt/application/modules/Core/externals/images/weather_report.jpg" class="" />
  </div>
  <!--/Weather Middle banner section-->

  <!--Weather Main Content section-->
  <div class="sesweather_main_content sesweather_bxs">
    <div class="content-temperature">
      <div class="temp_value">
        <h1>77<sup>o</sup>C</h1>
      </div>
      <div class="temp_description">
        <h4>Partly Cloud</h4>
        <h4>H 33<sup>o</sup>C &nbsp; L 45<sup>o</sup>C</h4>
      </div>
    </div>
    <h2 class="user_log"><img src="/sesforsmt/application/modules/Core/externals/images/rainy-6.svg" class="" /> &nbsp;Good Afternoon, User!</h2>
    <p>It's Cloudy Right now in Kanpur, UttarPradesh. The Forecast today shows a low of 27 degree.</p>
  </div>
  <!--/Weather Main content Section-->

  <!--Weather Gray table section-->
  <div class="weather_gray_table sesweather_bxs">
    <!--Weather gray table block-->
    <div class="sesweather_gray_table_block">
      <img src="/sesforsmt/application/modules/Core/externals/images/rainy-6.svg" class="" />
      <h3>3 AM</h3>
      <p>67<sup>o</sup>C</p>
    </div>
    <!--/Weather gray table block-->
    <!--Weather gray table block-->
    <div class="sesweather_gray_table_block">
      <img src="/sesforsmt/application/modules/Core/externals/images/rainy-6.svg" class="" />
      <h3>4 AM</h3>
      <p>44<sup>o</sup>C</p>
    </div>
    <!--/Weather gray table block-->
    <!--Weather gray table block-->
    <div class="sesweather_gray_table_block">
      <img src="/sesforsmt/application/modules/Core/externals/images/night.svg" class="" />
      <h3>5 AM</h3>
      <p>56<sup>o</sup>C</p>
    </div>
    <!--/Weather gray table block-->
    <!--Weather gray table block-->
    <div class="sesweather_gray_table_block">
      <img src="/sesforsmt/application/modules/Core/externals/images/day.svg" class="" />
      <h3>6 AM</h3>
      <p>78<sup>o</sup>C</p>
    </div>
    <!--/Weather gray table block-->
    <!--Weather gray table block-->
    <div class="sesweather_gray_table_block">
      <img src="/sesforsmt/application/modules/Core/externals/images/thunder.svg" class="" />
      <h3>7 AM</h3>
      <p>23<sup>o</sup>C</p>
    </div>
    <!--/Weather gray table block-->
    <!--Weather gray table block-->
    <div class="sesweather_gray_table_block">
      <img src="/sesforsmt/application/modules/Core/externals/images/rainy-6.svg" class="" />
      <h3>8 AM</h3>
      <p>33<sup>o</sup>C</p>
    </div>
    <!--/Weather gray table block-->
    <!--Weather gray table block-->
    <div class="sesweather_gray_table_block">
      <img src="/sesforsmt/application/modules/Core/externals/images/snowy-6.svg" class="" />
      <h3>9 AM</h3>
      <p>11<sup>o</sup>C</p>
    </div>
    <!--/Weather gray table block-->
  </div>
  <!--/Weather Gray table section-->

  <!--Weather Bottom table Section-->
  <div class="sesweather_bottom_table sesweather_bxs">
    <!--Weather Day list-->
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
          <span class="gray-shade"><span>H 33 <sup>o</sup>C</span>&nbsp;<span>L 27 <sup>o</sup>C</span></span>
        </div>
      </div>
    </div>
    <!--/Weather Day list-->
    <!--Weather Day list-->
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
          <span><span>H 33 <sup>o</sup>C</span>&nbsp;<span>L 27 <sup>o</sup>C</span></span>
        </div>
      </div>
    </div>
    <!--/Weather Day list-->
    <!--Weather Day list-->
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
          <span><span>H 33 <sup>o</sup>C</span>&nbsp;<span>L 27 <sup>o</sup>C</span></span>
        </div>
      </div>
    </div>
    <!--/Weather Day list-->
    <!--Weather Day list-->
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
          <span><span>H 33 <sup>o</sup>C</span>&nbsp;<span>L 27 <sup>o</sup>C</span></span>
        </div>
      </div>
    </div>
    <!--/Weather Day list-->
    <!--Weather Day list-->
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
          <span><span>H 33 <sup>o</sup>C</span>&nbsp;<span>L 27 <sup>o</sup>C</span></span>
        </div>
      </div>
    </div>
    <!--/Weather Day list-->
    <!--Weather Day list-->
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
          <span><span>H 33 <sup>o</sup>C</span>&nbsp;<span>L 27 <sup>o</sup>C</span></span>
        </div>
      </div>
    </div>
    <!--/Weather Day list-->
  </div>
  <!--/Weather Bottom table Section-->
</div>
<!--/Weather middle Bar block-->
