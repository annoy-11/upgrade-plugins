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

class Sesbusinessoffer_Widget_SlideshowController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->params = $this->view->allparams = $allparams = $this->_getAllParams();
     $show_criterias = $allparams['show_criteria'];
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;
    $allparams['order'] = $allparams['info'];
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('businessoffers', 'sesbusinessoffer')->getOffersPaginator($allparams);
    $paginator->setItemCountPerPage($allparams['limit_data']);
    $paginator->setCurrentPageNumber(1);
    $sesbusinessoffer_widget = Zend_Registry::isRegistered('sesbusinessoffer_widget') ? Zend_Registry::get('sesbusinessoffer_widget') : null;
    if(empty($sesbusinessoffer_widget))
      return $this->setNoRender();
  }
}
