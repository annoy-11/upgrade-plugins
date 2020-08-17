<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seschristmas
 * @package    Seschristmas
 * @copyright  Copyright 2014-2015 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2014-11-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Seschristmas_Widget_ChristmasPageController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->openTab = $this->_getParam('openTab', 1);
    $welcome_page = Engine_Api::_()->getApi('settings', 'core')->getSetting('seschristmas.welcome', 1);
    if (empty($welcome_page)) {
      return $this->setNoRender();
    }

    $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
    if (empty($viewer_id)) {
      return $this->setNoRender();
    }
  }

}
