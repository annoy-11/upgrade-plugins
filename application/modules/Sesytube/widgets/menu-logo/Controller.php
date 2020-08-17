<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesytube
 * @package    Sesytube
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-02-01 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesytube_Widget_MenuLogoController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $this->view->logo = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesytube.logo', '');
    $this->view->footerlogo = $this->_getParam('logofooter',false);
    if($this->view->footerlogo){
     $this->view->logo  = $this->view->footerlogo;
    }
    $this->getElement()->removeDecorator('Container');
  }

}
