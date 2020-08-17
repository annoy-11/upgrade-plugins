<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Controller.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
class Epetition_Widget_ViewUpdateController extends Engine_Content_Widget_Abstract
{

  protected $_childCount;

  public function indexAction()
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    if (isset($_POST['params'])) {
      $params = json_decode($_POST['params'], true);
    }
    if (isset($_POST['searchParams']) && $_POST['searchParams']) {
      parse_str($_POST['searchParams'], $searchArray);
    }
    $this->view->is_ajax = $is_ajax = isset($_POST['is_ajax']) ? true : false;
    $this->view->page = $page = isset($_POST['page']) ? $_POST['page'] : $this->_getParam('page', 1);
    $this->view->limit = $limit = isset($_POST['limit']) ? $_POST['limit'] : $this->_getParam('itemCountPerPage', 10);
    $this->view->identity = $this->view->widgetId = $widgetId = (isset($_POST['widget_id']) ? $_POST['widget_id'] : $this->view->identity);
    if (!$is_ajax) {
      $this->view->subject = $subject = Engine_Api::_()->core()->getSubject();
      $this->view->allow_create = true;



      if (!Engine_Api::_()->core()->hasSubject('epetition')) {
        return $this->setNoRender();
      }


      $this->view->isAnnouncements = Engine_Api::_()->getDbtable('announcements', 'epetition')->isAnnouncement(array('epetition_id' => $subject->getIdentity()));
    }


    $this->view->epetition_id = $params['epetition_id'] = isset($_POST['epetition_id']) ? $_POST['epetition_id'] : $subject->getIdentity();
    $params['paginator'] = true;


    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('announcements', 'epetition')->getAnnouncementPaginator($params);



    //Set item count per page and current page number
    $paginator->setItemCountPerPage($limit);
    $paginator->setCurrentPageNumber($page);
    if ($is_ajax)
      $this->getElement()->removeDecorator('Container');
    else {
      if (!($this->view->allowedCreate && $this->view->cancreate && $viewer->getIdentity()) && $paginator->getTotalItemCount() == 0)
        return $this->setNoRender();
    }

//    //Add count to title if configured
    if ($paginator->getTotalItemCount() > 0) {
      $this->_childCount = $paginator->getTotalItemCount();
    }
  }

  public function getChildCount()
  {
    return $this->_childCount;
  }

}
