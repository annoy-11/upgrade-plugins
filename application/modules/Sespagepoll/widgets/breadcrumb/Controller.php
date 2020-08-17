<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagepoll
 * @package    Sespagepoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-10-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespagepoll_Widget_BreadcrumbController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $coreApi = Engine_Api::_()->core();
    if (!$coreApi->hasSubject('sespagepoll_poll'))
      return $this->setNoRender();
    $this->view->subject = $coreApi->getSubject();
  }

}
