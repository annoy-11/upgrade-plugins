<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesariana
 * @package    Sesariana
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-04-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesariana_Widget_CustomNavigationMenuController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    
    $this->view->backgroundimage = $this->_getParam('backgroundimage', '');
    $this->view->height = $this->_getParam('height','150');
    $this->view->textalignment = $this->_getParam('textalignment', 'center');
    
  }

}