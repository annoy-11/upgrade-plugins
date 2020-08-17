<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbusiness_Widget_SlideshowController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $this->view->is_ajax = $is_ajax = isset($_POST['is_ajax']) ? true : false;
    $this->view->params = $params = Engine_Api::_()->sesbusiness()->getWidgetParams($this->view->identity);
    $limit_data = $params["limit_data"];
    $show_criterias = $params['show_criteria'];
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->page = $page;
    $value = array();
    $value['status'] = 1;
    $value['search'] = 1;
    $value['draft'] = "1";
    $params = array_merge($params, $value);
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('businesses', 'sesbusiness')
            ->getBusinessPaginator($params);
    $paginator->setItemCountPerPage($limit_data);
    $paginator->setCurrentPageNumber ($page);
    if ($is_ajax) {
      $this->getElement()->removeDecorator('Container');
    }
  }

}
