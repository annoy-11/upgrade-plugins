<?php

/**

 */
?>
<?php
	$baseUrl = $this->layout()->staticBaseUrl;
	$this->headLink()->appendStylesheet($baseUrl . 'application/modules/Sespawsnclaws/externals/styles/styles.css');
?>


<div class="sespawsnclaws_gallery_section_wrapper sesbasic_bxs">
  <div class="sespawsnclaws_gallery_section">
    <div class="sespawsnclaws_section_container">
    	<div class="sespawsnclaws_section_header">
    		<h2>Our Gallery</h2>
      </div>
    </div>
    <div class="sespawsnclaws_gallery_section_photos">
    	<ul class="wow fadeInUp">
      	<?php foreach($this->results as $result) { ?>
      	<li><article>
        <a href="<?php echo $result->getHref(); ?>"><span class="bg_item_photo" style="background-image:url(<?php echo $result->getPhotoUrl(); ?>)"></span></a>
        </article></li>
        <?php } ?>
      </ul>
    </div>
  </div>
</div>
