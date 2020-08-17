<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Sesforum_Widget_BreadcrumbController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $coreApi = Engine_Api::_()->core();

    $this->view->fontSize  = $this->_getParam('fontSize',24);
    $this->view->subject = $coreApi->hasSubject('sesforum_forum') ? $coreApi->getSubject('sesforum_forum') : null;
    $this->view->subjectTopic = $coreApi->hasSubject('sesforum_topic') ? $coreApi->getSubject('sesforum_topic') : null;
    $sesforum_widgets = Zend_Registry::isRegistered('sesforum_widgets') ? Zend_Registry::get('sesforum_widgets') : null;
    if(empty($sesforum_widgets))
      return $this->setNoRender();
    $this->view->subjectCategory = $coreApi->hasSubject('sesforum_category') ? $coreApi->getSubject('sesforum_category') : null;
  }

}
