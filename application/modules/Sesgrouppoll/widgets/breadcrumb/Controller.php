<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgrouppoll
 * @package    Sesgrouppoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-11-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesgrouppoll_Widget_BreadcrumbController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $coreApi = Engine_Api::_()->core();
    if (!$coreApi->hasSubject('sesgrouppoll_poll'))
      return $this->setNoRender();
    $this->view->subject = $coreApi->getSubject();
  }

}
