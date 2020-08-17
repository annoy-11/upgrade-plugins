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
  <div class="lp_post_job_section">
     <div class="lp_container lp_job_inner">
         <?php if(!empty($this->heading) && $this->heading != ''): ?>
            <div class="lp_job_head">
                <h2><?php echo $this->translate($this->heading); ?></h2>
            </div>
         <?php endif; ?>
         <div class="lp_intro_cont">
            <a href="<?php echo $this->buttonUrl; ?>" class="post_job"><?php echo $this->buttonText; ?></a>
         </div>
         <div class="lp_job_img">
             <img src="<?php echo $this->image; ?>" />
         </div>
     </div>
  </div>
