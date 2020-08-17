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
class Eclassroom_Widget_ServiceController extends Engine_Content_Widget_Abstract {

  protected $_childCount;

  public function indexAction() {

    // Get subject and check auth
    $subject = Engine_Api::_()->core()->getSubject('classroom');
    if (!$subject) {
      return $this->setNoRender();
    }
     $limit_data = $this->_getParam('limit_data',5);
    $show_criterias = $this->_getParam('show_criteria', array('title','creationDate','photo','description'));

    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;


    $this->getElement()->removeDecorator('Title');
    $this->view->height = 200;
    $this->view->width = 200;

    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('services', 'eclassroom')->getServiceMemers(array('classroom_id' => $subject->getIdentity(), 'widgettype' => 'widget','limit' => $limit_data));

    //Manage Apps Check
    $isCheck = Engine_Api::_()->getDbTable('manageclassroomapps', 'eclassroom')->isCheck(array('classroom_id' => $subject->getIdentity(), 'columnname' => 'service'));
    if(empty($isCheck))
      return $this->setNoRender();

    // Add count to title if configured
    if (count($paginator) > 0) {
      $this->_childCount = count($paginator);
    }
  }

  public function getChildCount() {
    return $this->_childCount;
  }
}
