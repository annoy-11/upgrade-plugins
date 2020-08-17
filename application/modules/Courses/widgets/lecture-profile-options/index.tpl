<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php
  // Render the menu
  echo $this->navigation()
    ->menu()
    ->setContainer($this->gutterNavigation)
    ->setUlClass('navigation courses_lecture_profile_options')
    ->render();
?>
