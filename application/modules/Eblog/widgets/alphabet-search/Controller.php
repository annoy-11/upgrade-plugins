<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Eblog_Widget_AlphabetSearchController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
  
    $this->view->alphbet_array = array('all' => "#", "a" => "A", "b" => "B", "c" => "C", "d" => "D", "e" => "E", "f" => "F", "g" => "G", "h" => "H", "i" => "I", "j" => "J", "k" => "K", "l" => "L", "m" => "M", "n" => "N", "o" => "O", "p" => "P", "q" => "Q", "r" => "R", "s" => "S", "t" => "T", "u" => "U", "v" => "V", "w" => "W", "x" => "X", "y" => "Y", "z" => "Z");
    
  }
}
