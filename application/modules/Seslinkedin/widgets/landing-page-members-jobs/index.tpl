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
  <div class="lp_members_jobs_section">
     <div class="lp_container lp_members_jobs_inner">
         <div>
            <img src="<?php echo $this->fe1img; ?>" />
            <?php if(!empty($this->fe1heading) && $this->fe1heading != ''): ?>
                <h2><?php echo $this->translate($this->fe1heading); ?></h2>
            <?php endif; ?>
            <a href="<?php echo $this->fe1buttonUrl; ?>"><?php echo $this->fe1buttonText; ?></a>
         </div>
         <div>
            <img src="<?php echo $this->fe2img; ?>" />
            <?php if(!empty($this->fe2heading) && $this->fe2heading != ''): ?>
                <h2><?php echo $this->translate($this->fe2heading); ?></h2>
            <?php endif; ?>
            <a href="<?php echo $this->fe2buttonUrl; ?>"><?php echo $this->fe2buttonText; ?></a>
         </div> 
     </div>
  </div>
