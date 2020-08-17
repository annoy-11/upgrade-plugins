<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecipe
 * @package    Sesrecipe
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2018-05-07 00:00:00 SocialEngineSolutions $
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
