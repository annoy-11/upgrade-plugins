<?php
 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Courses/externals/styles/owl.carousel.min.css'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Courses/externals/styles/styles.css'); ?>
<?php 
  $baseURL = $this->layout()->staticBaseUrl;
  $this->headScript()->appendFile($baseURL . 'application/modules/Courses/externals/scripts/jquery.js');
  $this->headScript()->appendFile($baseURL . 'application/modules/Courses/externals/scripts/owl.carousel.js'); 
  $item = $this->item;
?>
<div class="courses_custom_offers" id="courses_custom_offers<?php echo $this->offer_id; ?>">
  <!--Design 1-->
  <?php if($this->design == 'design1') { ?>
  <section class="courses_welcome_offerblk sesbasic_clearfix sesbasic_bxs">
    <?php if($this->show_timer == 'yes' || !empty($this->heading)) { ?>
    <div class="courses_custom_dealtime">
      <h2><?php echo $this->heading; ?> </h2>
     <?php $offer = Engine_Api::_()->getItem('courses_offer',$this->offer_id); ?>
      <div class="deal_time" id ="deal_time<?php echo $this->offer_id; ?>" data-start-date ="<?php echo $offer->offer_startdate; ?>" data-end-date ="<?php echo $offer->offer_enddate; ?>">
        <?php if($this->show_timer == 'yes') { ?>
            <div class="_img">
                <img src="./application/modules/Courses/externals/images/clock.png"/>
            </div>
            <div class="_time">
                <h3><span class="_hour timer" id="timer<?php echo $this->offer_id; ?>"></span></h3>
            </div>
        <?php } ?>
      </div>
    </div>
  <?php } ?>
    <div class="offersblk_inner">
      <div class="container">
        <?php foreach($this->paginator as $offers) { ?>
        <a href="<?php echo $offers->url; ?>" target="_blank">
          <div class="offer_blk" style="height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height ?>;width:<?php echo is_numeric($this->width) ? $this->width.'px' : $this->width ?>;">
          <img src="<?php echo $offers->getPhotoUrl(); ?>"/>
          <div class="_desc">
            <h5><?php echo $offers->title; ?></h5>
            <p><?php echo $offers->description; ?></p>
            <a href="<?php echo $offers->url; ?>" target="_blank"><i class="fa fa-plus"></i>&nbsp;<?php echo $this->button_title; ?></a>
          </div>
        </div></a>
      <?php } ?>
      </div>
    </div>
  </section>
  <!--Design1 Ends-->
  <?php } ?>
     
  <?php if($this->design == 'design2') { ?>
    <div class="courses_welcome_branddiscount sesbasic_clearfix sesbasic_bxs">
       <?php if($this->show_timer == 'yes' || !empty($this->heading)) { ?>
      <div class="courses_custom_dealtime">
        <h2><?php echo $this->heading; ?> </h2>
        <?php $offer = Engine_Api::_()->getItem('courses_offer',$this->offer_id); ?>
        <div class="deal_time" id ="deal_time<?php echo $this->offer_id; ?>" data-start-date ="<?php echo $offer->offer_startdate; ?>" data-end-date ="<?php echo $offer->offer_enddate; ?>">
         <?php if($this->show_timer == 'yes') { ?>
            <div class="_img">
                <img src="./application/modules/Courses/externals/images/clock.png"/>
            </div>
            <div class="_time">
                <h3><span class="_hour timer" id="timer<?php echo $this->offer_id; ?>"></span></h3>
            </div>
        <?php } ?>
      </div>
    </div>
    <?php } ?>
    <div class="brand_inner">
      <div class="container">
       <?php foreach($this->paginator as $offers) { ?>
        <a href="<?php echo $offers->url; ?>" target="_blank">
          <div class="brands_discount" style="height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height ?>;width:<?php echo is_numeric($this->width) ? $this->width.'px' : $this->width ?>;">
          <img src="<?php echo $offers->getPhotoUrl(); ?>"/>
          <div class="_desc">
            <h3><?php echo $offers->title; ?></h3>
            <p><?php echo $offers->description; ?></p>
            <a href="<?php echo $offers->url; ?>" target="_blank"><i class="fa fa-plus"></i>&nbsp;<?php echo $this->button_title; ?></a>
          </div>
        </div></a>
        <?php } ?>
      </div>
    </div>
  </div>
  <?php } ?>

  <?php if($this->design == 'design3') { ?>
  <section class="courses_courses_carousel sesbasic_clearfix sesbasic_bxs">
  <?php if($this->show_timer == 'yes' || !empty($this->heading)) { ?>
    <div class="courses_custom_dealtime">
      <h2><?php echo $this->heading; ?> </h2>
      <?php $offer = Engine_Api::_()->getItem('courses_offer',$this->offer_id); ?>
      <div class="deal_time" id ="deal_time<?php echo $this->offer_id; ?>" data-start-date ="<?php echo $offer->offer_startdate; ?>" data-end-date ="<?php echo $offer->offer_enddate; ?>">
         <?php if($this->show_timer == 'yes') { ?>
            <div class="_img">
                <img src="./application/modules/Courses/externals/images/clock.png"/>
            </div>
            <div class="_time">
                <h3><span class="_hour timer" id="timer<?php echo $this->offer_id; ?>"></span></h3>
            </div>
        <?php } ?>
     </div>
    </div>
   <?php } ?>
    <div clas="courses_browseprdt">
    	<div class="courses_welcomep_courses owl-carousel owl-theme">
    	  <?php foreach($this->paginator as $offers) { ?>
        <div class="item" style="height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height ?>;">
          <img src="<?php echo $offers->getPhotoUrl(); ?>"/>
          <div class="_desc">
            <h3><?php echo $offers->title; ?></h3>
            <p><?php echo $offers->description; ?></p>
            <a href="<?php echo $offers->url; ?>" target="_blank"><i class="fa fa-plus"></i>&nbsp;<?php echo $this->button_title; ?></a>
          </div>
        </div>
      <?php } ?>
      </div>
    </div>
  </section>
  <?php  } ?>
  <!--Design3 Ends-->

  <!--Design4 -->
  <?php if($this->design == 'design4') { ?>
  <section class="courses_carousel_deals sesbasic_clearfix sesbasic_bxs">
    <div class="courses_welcome_offer">
      <?php if($this->show_timer == 'yes' || !empty($this->heading)) { ?>
      <div class="courses_custom_dealtime">
        <h2><?php echo $this->heading; ?> </h2>    
          <?php $offer = Engine_Api::_()->getItem('courses_offer',$this->offer_id); ?>
            <div class="deal_time"  id ="deal_time<?php echo $this->offer_id; ?>" data-start-date ="<?php echo $offer->offer_startdate; ?>" data-end-date ="<?php echo $offer->offer_enddate; ?>">
        <?php if($this->show_timer == 'yes') { ?>
            <div class="_img">
                <img src="./application/modules/Courses/externals/images/clock.png"/>
            </div>
        
            <div class="_time">
                <h3><span class="_hour timer" id="timer<?php echo $this->offer_id; ?>"></span></h3>
            </div>
        <?php } ?>
        </div>
      </div>
      <?php  } ?>
      <div class="courses_welcomep_deals owl-carousel owl-theme">
       <?php foreach($this->paginator as $offers) { ?>
        <div class="item" style="height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height ?>;">
          <img src="<?php echo $offers->getPhotoUrl(); ?>"/>
          <div class="_desc">
            <h3><?php echo $offers->title; ?></h3>
            <p><?php echo $offers->description; ?></p>
            <a href="<?php echo $offers->url; ?>" target="_blank"><i class="fa fa-plus"></i>&nbsp;<?php echo $this->button_title; ?></a>
          </div>
        </div>
      <?php } ?>
      </div>
    </div>
  </section>
  <?php  } ?>
  <!--Design4 Ends-->

  <!--Design5-->
  <?php if($this->design == 'design5') { ?>
  <div class="courses_welcome_discovercourses sesbasic_clearfix sesbasic_bxs">
    <?php if($this->show_timer == 'yes' || !empty($this->heading)) { ?>
    <div class="courses_custom_dealtime">
      <h2><?php echo $this->heading; ?> </h2>    
          <?php $offer = Engine_Api::_()->getItem('courses_offer',$this->offer_id); ?>
          <div class="deal_time" id ="deal_time<?php echo $this->offer_id; ?>" data-start-date ="<?php echo $offer->offer_startdate; ?>" data-end-date ="<?php echo $offer->offer_enddate; ?>">
         <?php if($this->show_timer == 'yes') { ?>
            <div class="_img">
                <img src="./application/modules/Courses/externals/images/clock.png"/>
            </div>
       
            <div class="_time">
                <h3><span class="_hour timer" id="timer<?php echo $this->offer_id; ?>"></span></h3>
            </div>
        <?php } ?>
      </div>
    </div>
     <?php } ?>
    <div class="discover_inner">
      <div class="container">
        <?php $counter = 1; ?>
         <?php foreach($this->paginator as $offers) { ?>
         <?php $discoverClass = 0; ?>
          <?php $discoverClass = $counter > 3 ? 'discover_large' : 'discover_bottom'; ?>
          <div class="<?php echo $discoverClass; ?>">
          <?php $class = 0; ?>
           <?php if($counter > 3) { ?>
           <?php $class =  'd_courses' ; ?>
            <?php  } else { ?>
                  <?php $class =  $counter > 1 ? 'discover_smb' : 'discover_lgb' ; ?>
           <?php  } ?>
            <div class="<?php echo $class; ?>">
              <div class="_imgsec">
                <a href="<?php echo $offers->url; ?>" target="_blank"><img src="<?php echo $offers->getPhotoUrl(); ?>" alt=""/></a>
              </div>
              <div class="_desc">
                <a href="<?php echo $offers->url; ?>" target="_blank"><h3><?php echo $offers->title; ?></h3></a>
                <p class="sesbasic_text_light"><?php echo $offers->description; ?></p>
                <a href="<?php echo $offers->url; ?>" target="_blank"><i class="fa fa-plus"></i>&nbsp;<?php echo $this->button_title; ?></a>
              </div>
            </div>
          </div>
      <?php $counter++; } ?>
    </div>
  </div>
  <?php  } ?>
</div>
<!--Design5 Ends-->
<script type="text/javascript">
sesJqueryObject(document).ready(function(){
  var $target = sesJqueryObject("#timer<?php echo $this->offer_id; ?>");
  var dealTime = sesJqueryObject("#deal_time<?php echo $this->offer_id; ?>");
  if(dealTime == "undefined")
    return false;
  var startTime = dealTime.data('start-date');
  var startOfferTime = new Date(startTime).getTime();
  var endTime = dealTime.data('end-date');
  var endOffertime = new Date(endTime).getTime();
  var countDownDate = new Date(startTime).getTime();
  var classes = ['hide', 'show'];
  var current = 0;
  setTimer = setInterval(function() {
    var now = new Date().getTime();
    if(startOfferTime > now)
        return false;
  // Find the distance between now and the count down date
  var distance = endOffertime - now;
 if(now > endOffertime) {
    coursesJqueryObject("#courses_custom_offers<?php echo $this->offer_id; ?>").parents('.layout_courses_custom_offer').remove();
    clearInterval(setTimer);
    return false;
 }
  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

  // Display the result in the element with id="demo"
  var time = days + "d " + hours + "h "+ minutes + "m " + seconds + "s ";
  $target.html(time);
    $target.removeClass(classes[current]);
    current = (current+1)%classes.length;
    $target.addClass(classes[current]);
  }, 1000); // 1000 ms loop
});

var offerEndRequest;
function endOffer(offerId)
	{
		if(typeof offerEndRequest != 'undefined'){
			offerEndRequest.cancel();
		}
    offerEndRequest = (new Request.HTML({
		  method: 'post',
		  'url': en4.core.baseUrl + 'widget/index/mod/courses/name/custom-offer',
		  'data': {
			offerId: offerId,
			is_offer_end : 1,
			
		  },
		  onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {			  
		  }
		})).send();
}
coursesJqueryObject('.courses_welcomep_courses').owlCarousel({
  margin: 10,
  nav: true,
  autoplay:true,
  loop:false,
  items:4,
  smartSpeed :900,
  navText : ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"],
  responsiveClass:true,
  responsive: {
    0: {
      items: 1
    },
    600: {
      items: 3
    },
    1000: {
      items: 4
    }
  }
});
coursesJqueryObject('.courses_welcomep_deals').owlCarousel({
  margin: 10,
  nav: true,
  autoplay:true,
  loop:false,
  items:4,
  smartSpeed :900,
  navText : ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"],
  responsiveClass:true,
  responsive: {
    0: {
      items: 1
    },
    600: {
      items: 3
    },
    1000: {
      items: 4
    }
  }
});

</script>
