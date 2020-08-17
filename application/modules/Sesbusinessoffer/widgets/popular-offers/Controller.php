<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessoffer
 * @package    Sesbusinessoffer
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbusinessoffer_Widget_PopularOffersController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->params = $this->view->allParams = $allParams = $this->_getAllParams();
    $show_criterias = $allParams['show_criteria'];
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;
    $allParams['order'] = $allParams['info'];
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('businessoffers', 'sesbusinessoffer')->getOffersPaginator($allParams);
    $sesbusinessoffer_widget = Zend_Registry::isRegistered('sesbusinessoffer_widget') ? Zend_Registry::get('sesbusinessoffer_widget') : null;
    if(empty($sesbusinessoffer_widget))
      return $this->setNoRender();
    if ($paginator->getTotalItemCount() == 0) {
      return $this->setNoRender();
    }
  }
}
