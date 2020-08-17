<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesspectromedia
 * @package    Sesspectromedia
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesspectromedia_Widget_MenuLogoController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $this->view->logo = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesspectromedia.logo', '');
    $this->getElement()->removeDecorator('Container');
  }

}
