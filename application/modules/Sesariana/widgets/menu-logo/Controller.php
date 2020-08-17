<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesariana
 * @package    Sesariana
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesariana_Widget_MenuLogoController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $this->view->logo = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesariana.logo', '');
    $this->view->footerlogo = $this->_getParam('logofooter',false);
    if($this->view->footerlogo){
     $this->view->logo  = $this->view->footerlogo;
    }
    $this->getElement()->removeDecorator('Container');
  }

}
