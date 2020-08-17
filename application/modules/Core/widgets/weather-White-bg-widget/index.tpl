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

<!--Weather Middle bar Light Bg block-->

  <div class="sesweather_Light_bg_block sesweather_bxs">
    <!--Weather Middle bar Light_bg top-bar-->
    <div class="sesweather_top_bar sesweather_bxs">
      <div class="sesweather_select_box">
        <form>
          <select>
            <option>Kanpur, UttarPradesh</option>
            <option>New Delhi, India</option>
            <option>Gandhi Nagar, Gujarat</option>
          </select>
          <label>Enter Your Place</label>
        </form>
      </div>
      <div class="sesweather_tabs">
        <div class="weather_view_format_tabs">
          <button class="tablinks" onclick="openFormat(event, 'dayforecast')" id="defaultOpen">7 Day Forecast</button>
          <button class="tablinks second" onclick="openFormat(event, 'hourly')">Hourly</button>
        </div>
        <div id="dayforecast" class="tabcontent">
          <span onclick="this.parentElement.style.display='none'" class="topright"></span>
         
        </div>
        <div id="hourly" class="tabcontent">
          <span onclick="this.parentElement.style.display='none'" class="topright"></span>
        </div>
      </div>
    </div>
    <!--/Weather Middle bar Light_bg top-bar-->

    <!--Weather Middle bar Light_bg content section-->
    <div class="sesweather_middle_content">
      <div class="weather_icon">
        <img src="./application/modules/Core/externals/images/weather_icon.png" class="" />
        <h2>77<sup>o</sup>C</h2>
      </div>
      <div class="weather_desc">
        <h2>Overcast Clouds</h2>
        <div class="weather_detail_desc">
          <div class="weather_part_desc">
            <p>Feels Like 39<sup>o</sup>C</p>
            <p>Visibility 2Km</p>
          </div>
          <div class="weather_part_desc">
            <p>Wind <i class="fa fa-angle-double-up"></i> 13 Km/h</p>
            <p>Humidity 84%</p>
          </div>
          <div class="weather_part_desc">
            <p>Barometer 1002.00 Mb</p>
            <p>Due Point 27<sup>o</sup></p>
          </div>
        </div>
      </div>
    </div>
    <!--/Weather Middle bar Light_bg content section-->

    <!--Weather Middle bar Light_bg bottom section-->
    <div class="sesweather_middle_bottom_block">
      <div class="sesweather_bottom_day">
        <div class="day_name">
          <h4>Tuesday</h4>
        </div>
        <div class="sesweather_bottom_day_expand">
          <div class="non-expand">
            <div class="day_weather">
              <img src="./application/modules/Core/externals/images/rainy-6.svg" class="" />
              <p>Mostly Sunny</p>
              <h3>90 <sup>o</sup>C</h3>
              <span><img src="./application/modules/Core/externals/images/measure.png" class="" />&nbsp;30%</span>
            </div>
          </div>
          <div class="border"></div>
          <div class="expand_desc">
            <div class="expand_list">
              <div class="desc_left">
                <img src="./application/modules/Core/externals/images/precipitation2.png" class="" />
                <p>Precipitation-30%</p>
              </div>
            </div>
            <div class="expand_list">
              <div class="desc_left">
                <img src="./application/modules/Core/externals/images/wind2.png" class="" />
                <p>Wind-9mph SSW</p>
              </div>
            </div>
            <div class="expand_list">
              <div class="desc_left">
                <img src="./application/modules/Core/externals/images/measure.png" class="" />
                <p>Humidity-70%</p>
              </div>
            </div>
            <div class="expand_list">
              <div class="desc_left">
                <img src="./application/modules/Core/externals/images/sun2.png" class="" />
                <p>UV-Very High</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="sesweather_bottom_day">
        <div class="day_name">
          <h4>Wednesday</h4>
        </div>
        <div class="sesweather_bottom_day_expand">
          <div class="non-expand">
            <div class="day_weather">
              <img src="./application/modules/Core/externals/images/rainy-6.svg" class="" />
              <p>Mostly Sunny</p>
              <h3>90 <sup>o</sup>C</h3>
              <span><img src="./application/modules/Core/externals/images/measure.png" class="" />&nbsp;30%</span>
            </div>
          </div>
          <div class="border"></div>
          <div class="expand_desc">
            <div class="expand_list">
              <div class="desc_left">
                <img src="./application/modules/Core/externals/images/precipitation2.png" class="" />
                <p>Precipitation-30%</p>
              </div>
            </div>
            <div class="expand_list">
              <div class="desc_left">
                <img src="./application/modules/Core/externals/images/wind2.png" class="" />
                <p>Wind-9mph SSW</p>
              </div>
            </div>
            <div class="expand_list">
              <div class="desc_left">
                <img src="./application/modules/Core/externals/images/measure.png" class="" />
                <p>Humidity-70%</p>
              </div>
            </div>
            <div class="expand_list">
              <div class="desc_left">
                <img src="./application/modules/Core/externals/images/sun2.png" class="" />
                <p>UV-Very High</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="sesweather_bottom_day">
        <div class="day_name">
          <h4>Thursday</h4>
        </div>
        <div class="sesweather_bottom_day_expand">
          <div class="non-expand">
            <div class="day_weather">
              <img src="./application/modules/Core/externals/images/rainy-6.svg" class="" />
              <p>Mostly Sunny</p>
              <h3>90 <sup>o</sup>C</h3>
              <span><img src="./application/modules/Core/externals/images/measure.png" class="" />&nbsp;30%</span>
            </div>
          </div>
          <div class="border"></div>
          <div class="expand_desc">
            <div class="expand_list">
              <div class="desc_left">
                <img src="./application/modules/Core/externals/images/precipitation2.png" class="" />
                <p>Precipitation-30%</p>
              </div>
            </div>
            <div class="expand_list">
              <div class="desc_left">
                <img src="./application/modules/Core/externals/images/wind2.png" class="" />
                <p>Wind-9mph SSW</p>
              </div>
            </div>
            <div class="expand_list">
              <div class="desc_left">
                <img src="./application/modules/Core/externals/images/measure.png" class="" />
                <p>Humidity-70%</p>
              </div>
            </div>
            <div class="expand_list">
              <div class="desc_left">
                <img src="./application/modules/Core/externals/images/sun2.png" class="" />
                <p>UV-Very High</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="sesweather_bottom_day">
        <div class="day_name">
          <h4>Friday</h4>
        </div>
        <div class="sesweather_bottom_day_expand">
          <div class="non-expand">
            <div class="day_weather">
              <img src="./application/modules/Core/externals/images/rainy-6.svg" class="" />
              <p>Mostly Sunny</p>
              <h3>90 <sup>o</sup>C</h3>
              <span><img src="./application/modules/Core/externals/images/measure.png" class="" />&nbsp;30%</span>
            </div>
          </div>
          <div class="border"></div>
          <div class="expand_desc">
            <div class="expand_list">
              <div class="desc_left">
                <img src="./application/modules/Core/externals/images/precipitation2.png" class="" />
                <p>Precipitation-30%</p>
              </div>
            </div>
            <div class="expand_list">
              <div class="desc_left">
                <img src="./application/modules/Core/externals/images/wind2.png" class="" />
                <p>Wind-9mph SSW</p>
              </div>
            </div>
            <div class="expand_list">
              <div class="desc_left">
                <img src="./application/modules/Core/externals/images/measure.png" class="" />
                <p>Humidity-70%</p>
              </div>
            </div>
            <div class="expand_list">
              <div class="desc_left">
                <img src="./application/modules/Core/externals/images/sun2.png" class="" />
                <p>UV-Very High</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="sesweather_bottom_day">
        <div class="day_name">
          <h4>Saturday</h4>
        </div>
        <div class="sesweather_bottom_day_expand">
          <div class="non-expand">
            <div class="day_weather">
              <img src="./application/modules/Core/externals/images/rainy-6.svg" class="" />
              <p>Mostly Sunny</p>
              <h3>90 <sup>o</sup>C</h3>
              <span><img src="./application/modules/Core/externals/images/measure.png" class="" />&nbsp;30%</span>
            </div>
          </div>
          <div class="border"></div>
          <div class="expand_desc">
            <div class="expand_list">
              <div class="desc_left">
                <img src="./application/modules/Core/externals/images/precipitation2.png" class="" />
                <p>Precipitation-30%</p>
              </div>
            </div>
            <div class="expand_list">
              <div class="desc_left">
                <img src="./application/modules/Core/externals/images/wind2.png" class="" />
                <p>Wind-9mph SSW</p>
              </div>
            </div>
            <div class="expand_list">
              <div class="desc_left">
                <img src="./application/modules/Core/externals/images/measure.png" class="" />
                <p>Humidity-70%</p>
              </div>
            </div>
            <div class="expand_list">
              <div class="desc_left">
                <img src="./application/modules/Core/externals/images/sun2.png" class="" />
                <p>UV-Very High</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="sesweather_bottom_day">
        <div class="day_name">
          <h4>Sunday</h4>
        </div>
        <div class="sesweather_bottom_day_expand">
          <div class="non-expand">
            <div class="day_weather">
              <img src="./application/modules/Core/externals/images/rainy-6.svg" class="" />
              <p>Mostly Sunny</p>
              <h3>90 <sup>o</sup>C</h3>
              <span><img src="./application/modules/Core/externals/images/measure.png" class="" />&nbsp;30%</span>
            </div>
          </div>
          <div class="border"></div>
          <div class="expand_desc">
            <div class="expand_list">
              <div class="desc_left">
                <img src="./application/modules/Core/externals/images/precipitation2.png" class="" />
                <p>Precipitation-30%</p>
              </div>
            </div>
            <div class="expand_list">
              <div class="desc_left">
                <img src="./application/modules/Core/externals/images/wind2.png" class="" />
                <p>Wind-9mph SSW</p>
              </div>
            </div>
            <div class="expand_list">
              <div class="desc_left">
                <img src="./application/modules/Core/externals/images/measure.png" class="" />
                <p>Humidity-70%</p>
              </div>
            </div>
            <div class="expand_list">
              <div class="desc_left">
                <img src="./application/modules/Core/externals/images/sun2.png" class="" />
                <p>UV-Very High</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="sesweather_bottom_day">
        <div class="day_name">
          <h4>Monday</h4>
        </div>
        <div class="sesweather_bottom_day_expand">
          <div class="non-expand">
            <div class="day_weather">
              <img src="./application/modules/Core/externals/images/rainy-6.svg" class="" />
              <p>Mostly Sunny</p>
              <h3>90 <sup>o</sup>C</h3>
              <span><img src="./application/modules/Core/externals/images/measure.png" class="" />&nbsp;30%</span>
            </div>
          </div>
          <div class="border"></div>
          <div class="expand_desc">
            <div class="expand_list">
              <div class="desc_left">
                <img src="./application/modules/Core/externals/images/precipitation2.png" class="" />
                <p>Precipitation-30%</p>
              </div>
            </div>
            <div class="expand_list">
              <div class="desc_left">
                <img src="./application/modules/Core/externals/images/wind2.png" class="" />
                <p>Wind-9mph SSW</p>
              </div>
            </div>
            <div class="expand_list">
              <div class="desc_left">
                <img src="./application/modules/Core/externals/images/measure.png" class="" />
                <p>Humidity-70%</p>
              </div>
            </div>
            <div class="expand_list">
              <div class="desc_left">
                <img src="./application/modules/Core/externals/images/sun2.png" class="" />
                <p>UV-Very High</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--/Weather Middle bar Light_bg bottom section-->

    <!--Weather Middle bar hourly view-->

    <div class="sesweather_middle_bottom_block" style="display:none;" id="hourly">
      <div class="sesweather_bottom_day">
        <div class="day_name">
          <h4>Right Now</h4>
        </div>
        <div class="expand_desc">
          <div class="expand_list">
            <div class="desc_left">
              <img src="./application/modules/Core/externals/images/precipitation2.png" class="" />
              <p>Precipitation-30%</p>
            </div>
          </div>
          <div class="expand_list">
            <div class="desc_left">
              <img src="./application/modules/Core/externals/images/wind2.png" class="" />
              <p>Wind-9mph SSW</p>
            </div>
          </div>
          <div class="expand_list">
            <div class="desc_left">
              <img src="./application/modules/Core/externals/images/measure.png" class="" />
              <p>Humidity-70%</p>
            </div>
          </div>
          <div class="expand_list">
            <div class="desc_left">
              <img src="./application/modules/Core/externals/images/sun2.png" class="" />
              <p>UV-Very High</p>
            </div>
          </div>
        </div>
      </div>
      <div class="sesweather_bottom_day">
        <div class="day_name">
          <h4>6 PM</h4>
        </div>
        <div class="day_weather">
          <img src="./application/modules/Core/externals/images/rainy-6.svg" class="" />
          <h3>90 <sup>o</sup>C</h3>
          <span><img src="./application/modules/Core/externals/images/measure.png" class="" />&nbsp;30%</span>
        </div>
      </div>
      <div class="sesweather_bottom_day">
        <div class="day_name">
          <h4>7 PM</h4>
        </div>
        <div class="day_weather">
          <img src="./application/modules/Core/externals/images/rainy-6.svg" class="" />
          <h3>90 <sup>o</sup>C</h3>
          <span><img src="./application/modules/Core/externals/images/measure.png" class="" />&nbsp;30%</span>
        </div>
      </div>
      <div class="sesweather_bottom_day">
        <div class="day_name">
          <h4>8 PM</h4>
        </div>
        <div class="day_weather">
          <img src="./application/modules/Core/externals/images/rainy-6.svg" class="" />
          <h3>90 <sup>o</sup>C</h3>
          <span><img src="./application/modules/Core/externals/images/measure.png" class="" />&nbsp;30%</span>
        </div>
      </div>
      <div class="sesweather_bottom_day">
        <div class="day_name">
          <h4>9 PM</h4>
        </div>
        <div class="day_weather">
          <img src="./application/modules/Core/externals/images/rainy-6.svg" class="" />
          <h3>90 <sup>o</sup>C</h3>
          <span><img src="./application/modules/Core/externals/images/measure.png" class="" />&nbsp;30%</span>
        </div>
      </div>
      <div class="sesweather_bottom_day">
        <div class="day_name">
          <h4>10 PM</h4>
        </div>
        <div class="day_weather">
          <img src="./application/modules/Core/externals/images/rainy-6.svg" class="" />
          <h3>90 <sup>o</sup>C</h3>
          <span><img src="./application/modules/Core/externals/images/measure.png" class="" />&nbsp;30%</span>
        </div>
      </div>
      <div class="sesweather_bottom_day">
        <div class="day_name">
          <h4>11 PM</h4>
        </div>
        <div class="day_weather">
          <img src="./application/modules/Core/externals/images/rainy-6.svg" class="" />
          <h3>90 <sup>o</sup>C</h3>
          <span><img src="./application/modules/Core/externals/images/measure.png" class="" />&nbsp;30%</span>
        </div>
      </div>
      <div class="sesweather_bottom_day">
        <div class="day_name">
          <h4>12 PM</h4>
        </div>
        <div class="day_weather">
          <img src="./application/modules/Core/externals/images/rainy-6.svg" class="" />
          <h3>90 <sup>o</sup>C</h3>
          <span><img src="./application/modules/Core/externals/images/measure.png" class="" />&nbsp;30%</span>
        </div>
      </div>
      <div class="sesweather_bottom_day">
        <div class="day_name">
          <h4>13 PM</h4>
        </div>
        <div class="day_weather">
          <img src="./application/modules/Core/externals/images/rainy-6.svg" class="" />
          <h3>90 <sup>o</sup>C</h3>
          <span><img src="./application/modules/Core/externals/images/measure.png" class="" />&nbsp;30%</span>
        </div>
      </div>
      <div class="sesweather_bottom_day">
        <div class="day_name">
          <h4>14 PM</h4>
        </div>
        <div class="day_weather">
          <img src="./application/modules/Core/externals/images/rainy-6.svg" class="" />
          <h3>90 <sup>o</sup>C</h3>
          <span><img src="./application/modules/Core/externals/images/measure.png" class="" />&nbsp;30%</span>
        </div>
      </div>
      <div class="sesweather_bottom_day">
        <div class="day_name">
          <h4>15 PM</h4>
        </div>
        <div class="day_weather">
          <img src="./application/modules/Core/externals/images/rainy-6.svg" class="" />
          <h3>90 <sup>o</sup>C</h3>
          <span><img src="./application/modules/Core/externals/images/measure.png" class="" />&nbsp;30%</span>
        </div>
      </div>
      <div class="sesweather_bottom_day">
        <div class="day_name">
          <h4>16 PM</h4>
        </div>
        <div class="day_weather">
          <img src="./application/modules/Core/externals/images/rainy-6.svg" class="" />
          <h3>90 <sup>o</sup>C</h3>
          <span><img src="./application/modules/Core/externals/images/measure.png" class="" />&nbsp;30%</span>
        </div>
      </div>
    </div>
<!--/Weather Middle bar Light Bg block-->


<script>

  //tabs

function openFormat(evt, weatherName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
      tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(weatherName).style.display = "block";
  evt.currentTarget.className += " active";
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();



</script>
<!--/Weather Middle bar Light Bg block-->
