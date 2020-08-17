<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Controller.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Courses_Widget_PopularOwnerPhotoController extends Engine_Content_Widget_Abstract {

  public function indexAction() { 
     $value['limit'] = $this->_getParam('limit_data', 5);
    $this->view->title = $this->_getParam('showTitle', 1);
    $this->view->height = $this->_getParam('height', '180');
    $this->view->width = $this->_getParam('width', '180');
    $this->view->title_truncation_list = $this->_getParam('title_truncation_list', '45');
    $this->view->title_truncation_grid = $this->_getParam('title_truncation_grid', '45');
    $show_criterias = isset($value['show_criterias']) ? $value['show_criterias'] : $this->_getParam('show_criteria', array('like', 'title', 'socialSharing', 'view', 'featuredLabel', 'sponsoredLabel', 'likeButton'));
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;
    $this->view->view_type = $this->_getParam('viewType', 'list');
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('courses', 'courses')->getPopularInstructor($value);
     $paginator->setItemCountPerPage($value['limit']);
    if ($paginator->getTotalItemCount() <= 0)
      return $this->setNoRender();
  }

}
