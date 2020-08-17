<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Controller.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Eclassroom_Widget_ProfileInfoController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    // Get subject and check auth
    $this->view->subject = $subject = Engine_Api::_()->core()->getSubject('classroom');
    if (!$subject)
      return $this->setNoRender();

    $this->view->classroomTags = $subject->tags()->getTagMaps();
    $this->view->criteria = $this->_getParam('criteria', array('date', 'categories', 'like','member', 'comment', 'favourite', 'view', 'follow', 'owner','tag', 'creationDate'));
  }

}
