<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seschristmas
 * @package    Seschristmas
 * @copyright  Copyright 2014-2015 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2014-11-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<html>
<head>
  <title><?php echo $this->translate("$this->pagename"); ?></title>
  <link href="<?php echo $this->baseUrl(); ?>/application/modules/Seschristmas/externals/styles/style_welcome.css" rel="stylesheet" />
  <script src="<?php echo $this->baseUrl(); ?>/application/modules/Seschristmas/externals/scripts/jquerymin.js"></script>
	<script>
    window.onload = function(){
      //canvas init
      var canvas = document.getElementById("canvas");
      var ctx = canvas.getContext("2d");
      
      //canvas dimensions
      var W = window.innerWidth;
      var H = window.innerHeight;
      canvas.width = W;
      canvas.height = H;
      
      //snowflake particles
      var mp = 50; //max particles
      var particles = [];
      for(var i = 0; i < mp; i++)
      {
        particles.push({
          x: Math.random()*W, //x-coordinate
          y: Math.random()*H, //y-coordinate
          r: Math.random()*4+1, //radius
          d: Math.random()*mp //density
        })
      }
      
      //Lets draw the flakes
      function draw()
      {
        ctx.clearRect(0, 0, W, H);
        ctx.fillStyle = "rgba(255, 255, 255, 0.8)";
        ctx.beginPath();
        for(var i = 0; i < mp; i++)
        {
          var p = particles[i];
          ctx.moveTo(p.x, p.y);
          ctx.arc(p.x, p.y, p.r, 0, Math.PI*2, true);
        }
        ctx.fill();
        update();
      }
      
      //Function to move the snowflakes
      //angle will be an ongoing incremental flag. Sin and Cos functions will be applied to it to create vertical and horizontal movements of the flakes
      var angle = 0;
      function update()
      {
        angle += 0.01;
        for(var i = 0; i < mp; i++)
        {
          var p = particles[i];
          //Updating X and Y coordinates
          //We will add 1 to the cos function to prevent negative values which will lead flakes to move upwards
          //Every particle has its own density which can be used to make the downward movement different for each flake
          //Lets make it more random by adding in the radius
          p.y += Math.cos(angle+p.d) + 1 + p.r/2;
          p.x += Math.sin(angle) * 2;
          
          //Sending flakes back from the top when it exits
          //Lets make it a bit more organic and let flakes enter from the left and right also.
          if(p.x > W+5 || p.x < -5 || p.y > H)
          {
            if(i%3 > 0) //66.67% of the flakes
            {
              particles[i] = {x: Math.random()*W, y: -10, r: p.r, d: p.d};
            }
            else
            {
              //If the flake is exitting from the right
              if(Math.sin(angle) > 0)
              {
                //Enter from the left
                particles[i] = {x: -5, y: Math.random()*H, r: p.r, d: p.d};
              }
              else
              {
                //Enter from the right
                particles[i] = {x: W+5, y: Math.random()*H, r: p.r, d: p.d};
              }
            }
          }
        }
      }
      //animation loop
      setInterval(draw, 33);
    }
    
    // Slideshow
    $("#christmas-welcome-slideshow > div:gt(0)").hide();
    setInterval(function() { 
      $('#christmas-welcome-slideshow > div:first')
        .fadeOut(1000)
        .next()
        .fadeIn(1000)
        .end()
        .appendTo('#christmas-welcome-slideshow');
    },  5000);
    
    // Add Body Class on load
     $(document).ready(function(e) {
    var setIntervalbody=
    setInterval(function() {
      $('#global_page_seschristmas-welcome-index').addClass('seschristmas-welcome-body');
      clearInterval(setIntervalbody);
    },  100);  
    });
  </script>
</head>
<body id="global_page_seschristmas-welcome-index">  
<div class="seschristmas-welcome-page-wrap">
  <div class="back-rays"></div>
  <canvas id="canvas"></canvas>
	<div class="top-left"></div>
  <div class="bottom-right"></div>
  <!--Counter-->
  <div class="counter">
  	<div class="title">
      <?php if($this->countdown): ?>
      <?php echo  $this->translate("Merry Christmas"); ?>
      <?php else: ?>
      <?php echo  $this->translate("Happy New Year"); ?>
      <?php endif; ?>
    </div>
    <div class="countdown">
    	<span id="timerdate" class="days"></span>
     	<span id="timertime" class="time"></span> 
     </div>
    <?php if (isset($_SESSION['seschristmaswelcome']) && $this->viewer_id) : ?>
      <div class="sitelink"><a href="<?php echo $this->final_url ?>">Go to Site &raquo;</a></div>
    <?php else: ?>
      <div class="sitelink"><a href="<?php echo $this->final_url ?>">Visit Site &raquo;</a></div>
    <?php endif; ?>
  </div>
  <!--Center Image-->
  <div class="sliderbackground-img"></div>
  <!--Image Slideshow-->
  <div id="christmas-welcome-slideshow">
     <div>
       <img src="<?php echo $this->baseUrl(); ?>/application/modules/Seschristmas/externals/images/welcome/slide1.png" alt="Happy Holidays" />
     </div>
     <div>
       <img src="<?php echo $this->baseUrl(); ?>/application/modules/Seschristmas/externals/images/welcome/slide2.png" alt="<?php echo $this->translate('Merry Christmas') ?>" />
     </div>
     <div>
       <img src="<?php echo $this->baseUrl(); ?>/application/modules/Seschristmas/externals/images/welcome/slide3.png" alt="<?php echo  $this->translate('Happy New Year') ?>" />
     </div>
  </div>
  <!--Footer-->
  <div class="seschristmas-welcome-page-footer">
  	<div class="seschristmas-welcome-page-footer-inner">
    	<div class="footer-img"></div>
    </div>
  </div>
</div>
  
<?php $year = date("Y"); 
$newYear = $year+1; 
$finalNewYear = "$newYear-01-01 12:00:00";
?>
<?php if($this->countdown) : ?>
<?php $exp_date = strtotime("$year-12-25 12:00:00"); ?>
<?php else:  ?>
<?php $exp_date = strtotime($finalNewYear); ?>
<?php endif; ?>
  
  <script>
  //time to Happy New year and Christmas
var server_end = <?php echo $exp_date; ?> * 1000;
var server_now = <?php echo $this->start_time ?> * 1000;
var client_now = new Date().getTime();
var end = server_end + (server_now - client_now);
var _second = 1000;
var _minute = _second * 60;
var _hour = _minute * 60;
var _day = _hour *24
var timer;
function showRemaining()
{

    var now = new Date();
 now.setTime(now.getTime() + 1000 * 600);
    var distance = end - now;
    if (distance < 0 ) {
   //window.location.reload();
     return;
    }
    var days = Math.floor(distance / _day);
    var hours = Math.floor( (distance % _day ) / _hour );
    var minutes = Math.floor( (distance % _hour) / _minute );
    var seconds = Math.floor( (distance % _minute) / _second );

    var timertime = document.getElementById('timertime');
    var timerdate = document.getElementById('timerdate');
    timertime.innerHTML = '';
    if (days) {
        timerdate.innerHTML = days + ' Days';
    } else {
    timerdate.innerHTML = 0 + ' Day';
    }
    if (hours) {
        timertime.innerHTML += hours + ':';
    } else {
      timertime.innerHTML += 00 + ':';
    }
    
    timertime.innerHTML += minutes + ':';
    timertime.innerHTML += seconds;
}

timer = setInterval(showRemaining, 1000);
</script>
<?php date_default_timezone_set($this->oldTz); ?>
<?php die; ?>