<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _customPriceRang.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/datepicker/jquery.timepicker.css'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/datepicker/bootstrap-datepicker.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery1.11.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/datepicker/jquery.timepicker.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/datepicker/bootstrap-datepicker.js'); ?>
<style>
#sesproduct_schedule_end_date{display:block !important;}
</style>
 <div id="rangeBox">
      <div id="sliderBox">
        <span>Price</span>
        <input type="range" id="slider0to50" step="1" min="0" max="50" name="price_min1">
        <input type="range" id="slider51to100" step="1" min="50" max="100" name="price_max1">
       </div>
      <!--<div id="inputRange">
        <input type="number" step="1" min="0" max="50" placeholder="Min" name="price_min" id="min" >
        <input type="number" step="1" min="51" max="100" placeholder="Max" name="price_max" id="max">
       </div>-->
    </div>
<script type="application/javascript">
  var sliderLeft=document.getElementById("slider0to50");
  var sliderRight=document.getElementById("slider51to100");
  var inputMin=document.getElementById("min");
  var inputMax=document.getElementById("max");
  function sliderLeftInput(){
    sliderLeft.value=inputMin.value;
  }
  function sliderRightInput(){
    sliderRight.value=(inputMax.value);
  }
  inputMin.addEventListener("change",sliderLeftInput);
  inputMax.addEventListener("change",sliderRightInput);
  function inputMinSliderLeft(){
    inputMin.value=sliderLeft.value;
  }
  function inputMaxSliderRight(){
    inputMax.value=sliderRight.value;
  }
  sliderLeft.addEventListener("change",inputMinSliderLeft);
  sliderRight.addEventListener("change",inputMaxSliderRight);
</script>
