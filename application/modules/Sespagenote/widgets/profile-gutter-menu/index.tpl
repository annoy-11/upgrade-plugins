<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesinterest
 * @package    Sesinterest
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-03-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php
  // Render the menu
  echo $this->navigation()
    ->menu()
    ->setContainer($this->gutterNavigation)
    ->setUlClass('navigation')
    ->render();
?>
