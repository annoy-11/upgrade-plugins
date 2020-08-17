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

class Sescrowdfunding_Widget_ManageReceivedDonationsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    if(empty($viewer->getIdentity()))
      return $this->setNoRender();

    $values['user_id'] = $viewer->getIdentity();
    $values['fetchAll'] = 1;
    $getCrowdfundings = Engine_Api::_()->getItemTable('crowdfunding')->getSescrowdfundingsSelect($values);

    $crowdfundingIds = array('0');
    foreach($getCrowdfundings as $getCrowdfunding) {
      $crowdfundingIds[] = $getCrowdfunding->crowdfunding_id;
    }

    $orders = Engine_Api::_()->getDbTable('orders', 'sescrowdfunding')->getAllDonations(array('crowdfundingIds' => $crowdfundingIds));
    $paginator = Zend_Paginator::factory($orders);
    $paginator->setItemCountPerPage(10);
    $this->view->paginator = $paginator->setCurrentPageNumber($_GET['page']);
  }
}
