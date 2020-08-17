<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescrowdfunding_Widget_ProfileDonorsController extends Engine_Content_Widget_Abstract {

    protected $_childCount;
  public function indexAction() {


    if (isset($_POST['params']))
      $params = json_decode($_POST['params'], true);

    $this->view->viewmore = $viewmore =  $this->_getParam('viewmore', 0);

    if(empty($viewmore)) {
      $subject = Engine_Api::_()->core()->getSubject();
      if(empty($subject))
        return $this->setNoRender();
    }

    if ($this->view->viewmore)
      $this->getElement()->removeDecorator('Container');
    $this->view->show_criteria = $show_criteria = isset($params['show_criteria']) ? $params['show_criteria'] : $this->_getParam('show_criteria', array('donation_amount', 'see_all', 'date'));

//     if(is_array($show_criterias)) {
//       foreach ($show_criterias as $show_criteria)
//       $this->view->{$show_criteria . 'Active'} = $show_criteria;
//     }

    $recent = isset($params['order']) ? $params['order'] : 'recent';
    $page = isset($params['page']) ? $params['page'] : $this->_getParam('page', 1);
    $fetchAll = isset($params['fetchAll']) ? $params['fetchAll'] : 0;
    $itemCount = isset($params['itemCount']) ? $params['itemCount'] : $this->_getParam('itemCount', 10);
    $crowdfunding_id = isset($params['crowdfunding_id']) ? $params['crowdfunding_id'] : $subject->crowdfunding_id;

    $this->view->all_params = $values = array('crowdfunding_id' => $crowdfunding_id, 'itemCount' => $itemCount, 'order' => $recent, 'fetchAll' => $fetchAll, 'show_criteria' => $show_criteria);

    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('orders', 'sescrowdfunding')->getAllDoners($values);

    $paginator->setItemCountPerPage($itemCount);
    $paginator->setCurrentPageNumber($page);
    $this->view->count = $paginator->getTotalItemCount();

    if($paginator->getTotalItemCount() <= 0)
      return $this->setNoRender();

    // Add count to title if configured
    if( $this->_getParam('titleCount', false) && $paginator->getTotalItemCount() > 0 ) {
        $this->_childCount = $paginator->getTotalItemCount();
    }
  }

    public function getChildCount() {
        return $this->_childCount;
    }
}
