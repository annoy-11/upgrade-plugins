<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslinkedin
 * @package    Seslinkedin
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-05-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/themes/seslinkedin/landing_page.css'); ?>
  <div class="lp_video_section" style="background-image:url(application/modules/Seslinkedin/externals/images/video-bg-shape.png);">
     <div class="lp_container lp_video_inner">
         <div class="lp_video">
            <?php if($this->video_type == 'uploaded'): ?>
              <iframe src="<?php echo $this->video; ?>" type="video/mp4"></iframe>
            <?php else: ?>
                <?php echo $this->embedCode; ?>
            <?php endif; ?>
          </div>
         <div class="lp_intro_cont">
            <h2 class="_title"><?php echo $this->title; ?></h2>
            <h3 class="_subtitle"><?php echo $this->description; ?></h3> 
         </div>
     </div>
  </div>
