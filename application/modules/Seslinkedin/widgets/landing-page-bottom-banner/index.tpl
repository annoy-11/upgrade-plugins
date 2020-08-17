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
  <div class="lp_bottom_banner_section">
     <div class="lp_container">
        <?php if(!empty($this->heading) && $this->heading != ''): ?>
            <h2><?php echo $this->translate($this->heading); ?></h2>
          <?php endif; ?>
          <?php if(!empty($this->buttonText) && $this->buttonText != ''): ?>
            <a href="<?php echo $this->buttonUrl; ?>"><?php echo $this->translate($this->buttonText); ?></a>
           <?php endif; ?>
            <div class="_img">
            <img src="<?php echo $this->image; ?>" />
            </div>
     </div>
  </div>
