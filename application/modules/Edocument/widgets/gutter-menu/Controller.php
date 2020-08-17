<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Edocument
 * @package    Edocument
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Edocument_Widget_GutterMenuController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    if(!Engine_Api::_()->core()->hasSubject('edocument') )
      return $this->setNoRender();

    $this->view->viewer = Engine_Api::_()->user()->getViewer();
    $this->view->subject = Engine_Api::_()->core()->getSubject();

    $this->view->gutterNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('edocument_gutter');
  }
}
