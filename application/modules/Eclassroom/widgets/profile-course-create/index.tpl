<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Eclassroom
 * @package    Eclassroom
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2015-10-11 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<?php if( count($this->quickNavigation) > 0 ): ?>
  <div class="quicklinks sesbasic_create_btn">
    <?php
      // Render the menu
      echo $this->navigation()
        ->menu()
        ->setContainer($this->quickNavigation)
        ->render();
    ?>
  </div>
<?php endif; ?>
