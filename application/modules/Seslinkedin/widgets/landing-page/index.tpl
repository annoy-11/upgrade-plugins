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
<div class="landingpage_main sesbasic_bxs sesbasic_clearfix">
  <div class="lp_intro_section">
     <div class="lp_container lp_intro_inner">
         <div class="lp_intro_cont">
         <?php if(!empty($this->heading) && $this->heading != ''): ?>
            <h1><?php echo $this->translate($this->heading); ?></h1>
         <?php endif; ?>
        <?php
        if(!empty($this->search)) {
            if(defined('sesadvancedsearch') && Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesadvancedsearch')){
            echo $this->content()->renderWidget("advancedsearch.search");
                } else { 
                    echo $this->content()->renderWidget("seslinkedin.search"); 
            }
        }
        ?>
         </div>
         <div class="lp_intro_img">
             <img src="<?php echo $this->image; ?>" />
         </div>
     </div>
  </div>
</div>
