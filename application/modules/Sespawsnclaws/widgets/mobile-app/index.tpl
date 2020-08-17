<?php

?>
<?php
	$baseUrl = $this->layout()->staticBaseUrl;
	$this->headLink()->appendStylesheet($baseUrl . 'application/modules/Sespawsnclaws/externals/styles/styles.css');
?>


<div class="sespawsnclaws_mobileapp_section_wrapper sesbasic_bxs">
	<div class="sec_bg" id="particles-js"></div>
  <div class="sespawsnclaws_mobileapp_section sespawsnclaws_section_container">
    <section>
			<div class="sespawsnclaws_mobileapp_section_content wow fadeInLeft">
      	<h3><?php echo $this->translate("Don’t Limit your love for Pets to Web only! Now flourish it with Paws ‘n Claws in Apps also.")?></h3>
        <p><?php echo $this->translate("With Paws ‘n Claws, get access to petworking community on your smart mobile phones and know about Pet lovers, Pets, Blogs, Videos, Events, Photos and easily access them on your Palm.")?></p>
        <div class="sec_buttons">
        	<a href="" class="app_download_btn">
          	<img src="application/modules/Sespawsnclaws/externals/images/a-store.png" alt="" />
          </a>
        	<a href="" class="app_download_btn">
          	<img src="application/modules/Sespawsnclaws/externals/images/g-play.png" alt="" />
          </a>
        </div>
      </div>
      <div class="sespawsnclaws_mobileapp_section_img wow fadeInRight">
      	<img src="application/modules/Sespawsnclaws/externals/images/app-img.png" alt="" />
      </div>
    </section>
  </div>
</div>
<script src="<?php echo $baseUrl;?>application/modules/Sespawsnclaws/externals/scripts/particles.min.js"></script>
<script src="<?php echo $baseUrl;?>application/modules/Sespawsnclaws/externals/scripts/app.js"></script>