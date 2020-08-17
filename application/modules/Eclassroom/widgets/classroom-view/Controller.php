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

class Eclassroom_Widget_ClassroomViewController extends Engine_Content_Widget_Abstract {

  public function indexAction() { 
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewerId = $viewer->getIdentity();
    $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('classroom_id', null);
    $classroom_id = Engine_Api::_()->getDbTable('classrooms', 'eclassroom')->getClassroomId($id);
    if (!Engine_Api::_()->core()->hasSubject())
      $this->view->classroom = $classroom = Engine_Api::_()->getItem('classroom', $classroom_id);
    else
      $this->view->classroom = $classroom = Engine_Api::_()->core()->getSubject();
    $classroomTable = Engine_Api::_()->getDbtable('classrooms', 'eclassroom');
    $owner = $classroom->getOwner();
    if( !$classroom->isOwner($viewer) ) {
        $classroomTable->update(array(
            'view_count' => new Zend_Db_Expr('view_count + 1'),
        ), array(
            'classroom_id = ?' => $classroom->getIdentity(),
        ));
    }
    $courses_widgets = Zend_Registry::isRegistered('courses_widgets') ? Zend_Registry::get('courses_widgets') : null;
    if(empty($courses_widgets))
      return $this->setNoRender();
    $this->view->cover_photo_height = $cover_photo_height = $this->_getParam('cover_photo_height', 400);
    $this->view->params = $params = Engine_Api::_()->courses()->getWidgetParams($this->view->identity);
    $params['tab_placement'] = isset($params['tab_placement']) ? isset($params['tab_placement']) : 'out';
    $show_criterias = $params['show_criteria'];
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;

    // Get category
    if (!empty($classroom->category_id))
    $this->view->category = Engine_Api::_()->getDbTable('categories', 'eclassroom')->find($classroom->category_id)->current();
    $this->view->classroomTags = $classroom->tags()->getTagMaps();
    $this->view->canComment = $classroom->authorization()->isAllowed($viewer, 'comment'); 
  }

}
