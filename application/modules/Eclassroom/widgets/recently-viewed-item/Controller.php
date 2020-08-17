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


class Eclassroom_Widget_RecentlyViewedItemController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->params = $params = Engine_Api::_()->eclassroom()->getWidgetParams($this->view->identity);  
    $type = $params['criteria'];
    if (($type == 'by_me' || $type == 'by_myfriend') && $this->view->viewer()->getIdentity() == 0)
      return $this->setNoRender();

    $show_criterias = $params['show_criteria'];
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;
    $value = array();
    $value['criteria'] = $type;
    $value['limit'] = $params['limit_data'];
    $value['type'] = 'classroom';
    $this->view->classrooms = $paginator = Engine_Api::_()->getDbTable('recentlyviewitems', 'eclassroom')->getitem($value);
    $this->view->getitem = true;
    if (count($paginator) == 0)
      return $this->setNoRender();
  }

}
