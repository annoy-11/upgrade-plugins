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

class Sescrowdfunding_Widget_TopDonorsSidebarController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    if (isset($_POST['params']))
      $params = json_decode($_POST['params'], true);

    $this->view->viewmore = $viewmore =  $this->_getParam('viewmore', 0);

    if ($this->view->viewmore)
      $this->getElement()->removeDecorator('Container');

    $this->view->show_criteria = $show_criteria = isset($params['show_criteria']) ? $params['show_criteria'] : $this->_getParam('show_criteria', array('donation_amount', 'see_all', 'date'));

    $page = isset($params['page']) ? $params['page'] : $this->_getParam('page', 1);
    $fetchAll = isset($params['fetchAll']) ? $params['fetchAll'] : 0;
    $itemCount = isset($params['itemCount']) ? $params['itemCount'] : $this->_getParam('itemCount', 10);

    $this->view->all_params = $values = array('itemCount' => $itemCount, 'fetchAll' => $fetchAll, 'show_criteria' => $show_criteria);

    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('orders', 'sescrowdfunding')->topAllDoners($values);

    $paginator->setItemCountPerPage($itemCount);
    $paginator->setCurrentPageNumber($page);
    $this->view->count = $paginator->getTotalItemCount();

    if($paginator->getTotalItemCount() <= 0)
      return $this->setNoRender();
  }
}
