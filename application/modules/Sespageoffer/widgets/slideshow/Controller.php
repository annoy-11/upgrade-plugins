<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespageoffer
 * @package    Sespageoffer
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespageoffer_Widget_SlideshowController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->params = $this->view->allparams = $allparams = $this->_getAllParams();
     $show_criterias = $allparams['show_criteria'];
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;
    $allparams['order'] = $allparams['info'];
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('pageoffers', 'sespageoffer')->getOffersPaginator($allparams);
    $paginator->setItemCountPerPage($allparams['limit_data']);
    $paginator->setCurrentPageNumber(1);
  }
}
