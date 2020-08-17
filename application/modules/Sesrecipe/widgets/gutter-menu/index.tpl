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
<?php
  // Render the menu
  echo $this->navigation()
    ->menu()
    ->setContainer($this->gutterNavigation)
    ->setUlClass('navigation recipes_gutter_options')
    ->render();
?>
