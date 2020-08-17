<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvancedheader
 * @package    Sesadvancedheader
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-02-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesadvancedheader_Widget_CustomNavigationMenuController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
  
    $this->view->widgetParams = $widgetParams = $this->_getAllParams();
    
  }
}