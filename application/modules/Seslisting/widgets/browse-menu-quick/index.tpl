<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslisting
 * @package    Seslisting
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-04-13 00:00:00 SocialEngineSolutions $
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
