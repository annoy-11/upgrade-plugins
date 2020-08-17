<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessocialtube
 * @package    Sessocialtube
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sessocialtube_Widget_MenuLogoController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $this->view->logo = Engine_Api::_()->getApi('settings', 'core')->getSetting('sessocialtube.logo', '');
    $this->getElement()->removeDecorator('Container');
  }

}
