<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $baseUrl = $this->layout()->staticBaseUrl; ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sescrowdfunding/externals/scripts/jquery.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sescrowdfunding/externals/scripts/responsiveslides.js'); ?>
<script type="text/javascript">
	// You can also use "$(window).load(function() {"
	sescfJqueryObject(function () {
		sescfJqueryObject("#sescf_profile_photos").responsiveSlides({
			maxwidth: 1000,
			speed: 800,
			nav: true
		});

	});
</script>
<!-- Slideshow 1 -->
<div class="sescf_photos_slideshow_wrapper">
  <ul class="sescf_photos_slideshow sesbasic_bxs" id="sescf_profile_photos">
    <?php foreach($this->paginator as $image): ?>
      <li>
        <img src="<?php echo $this->storage->get($image->file_id, '')->getPhotoUrl(); ?>" alt="" />
        <?php if($image->description): ?>
          <div class="sescf_photos_slideshow_caption">
            <?php echo $image->description; ?>
           </div>
        <?php endif; ?> 
      </li>
    <?php endforeach;?>
  </ul>
</div>

