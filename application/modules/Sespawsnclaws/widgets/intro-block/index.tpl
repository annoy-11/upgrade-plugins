<?php

?>
<?php
	$baseUrl = $this->layout()->staticBaseUrl;
	$this->headLink()->appendStylesheet($baseUrl . 'application/modules/Sespawsnclaws/externals/styles/styles.css');
  $this->headLink()->appendStylesheet($baseUrl . 'application/modules/Sespawsnclaws/externals/styles/animate.css');
  
  $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sespawsnclaws/externals/scripts/lity.js');
  $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sespawsnclaws/externals/styles/lity.css');
?>
<div class="sespawsnclaws_intro_section_wrapper sesbasic_bxs">
  <div class="sespawsnclaws_intro_section sespawsnclaws_section_container sespawsnclaws_section_spacing">
    <section>
      <div class="_left">
      	<img class="wow fadeIn" data-wow-delay="0.2s" src="application/modules/Sespawsnclaws/externals/images/intro-img.png" alt="" />
      
      	<div class="playbtn">
        	<span class="playbtn_bg">
          	<span class="circle c-1"></span><span class="circle c-2"></span><span class="circle c-3"></span>
          </span>
        	<a href="https://vimeo.com/19376057"  data-lity title="Watch Video"><i class="fa fa-play"></i></a>
        </div>
      </div>
      <div class="_right">
      	<div class="item wow fadeIn" data-wow-delay="0.4s">
        	<article>
            <div class="item_icon">
              <span class="item_icon_holder"><img src="application/modules/Sespawsnclaws/externals/images/is-f1.png" alt=""></span>
            </div>
            <div class="item_content">
              <div class="item_title"><?php echo $this->translate("Lovable Pets");?></div>
              <div class="item_des"><?php echo $this->translate("Share your experience of raising lovely pets with the world and get to know what they like.");?></div>
            </div>
        	</article>    
        </div>
        <div class="item wow fadeIn" data-wow-delay="0.6s">
        	<article>
            <div class="item_icon">
              <span class="item_icon_holder"><img src="application/modules/Sespawsnclaws/externals/images/is-f2.png" alt=""></span>
            </div>
            <div class="item_content">
              <div class="item_title"><?php echo $this->translate("Pets Showreel");?></div>
              <div class="item_des"><?php echo $this->translate("Watch your favourite pets videos and see how cute & bubbly they are!");?></div>
            </div>
					</article>
        </div>
        <div class="item wow fadeIn" data-wow-delay="0.8s">
        	<article>
            <div class="item_icon">
              <span class="item_icon_holder"><img src="application/modules/Sespawsnclaws/externals/images/is-f3.png" alt=""></span>
            </div>
            <div class="item_content">
              <div class="item_title"><?php echo $this->translate("Read about Pets");?></div>
              <div class="item_des"><?php echo $this->translate("Read & write about Pets to know what they love, hate, how they felt when they are happy or sad.");?></div>
            </div>
					</article>
        </div>
        <div class="item wow fadeIn" data-wow-delay="1s">
        	<article>
            <div class="item_icon">
              <span class="item_icon_holder"><img src="application/modules/Sespawsnclaws/externals/images/is-f4.png" alt=""></span>
            </div>
            <div class="item_content">
              <div class="item_title"><?php echo $this->translate("Pet Brunch");?></div>
              <div class="item_des"><?php echo $this->translate("Make yummy recipes & treats for your pets which they love the most to eat.");?> </div>
            </div>
					</article>
        </div>
      </div>
    </section>
  </div>
</div>
<script src="application/modules/Sespawsnclaws/externals/scripts/wow.min.js" type="text/javascript"></script>
<script>
var wow = new WOW ({
	offset:       75,          // distance to the element when triggering the animation (default is 0)
	mobile:       false,       // trigger animations on mobile devices (default is true)
});
wow.init();
</script>