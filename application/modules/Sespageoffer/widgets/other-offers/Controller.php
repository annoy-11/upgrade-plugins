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

class Sespageoffer_Widget_OtherOffersController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    if (!Engine_Api::_()->core()->hasSubject('pageoffer'))
        return $this->setNoRender();

    if(Engine_Api::_()->core()->hasSubject('pageoffer'))
        $subject = Engine_Api::_()->core()->getSubject('pageoffer');

    $this->view->params = $this->view->allParams = $allParams = $this->_getAllParams();
    $show_criterias = $allParams['show_criteria'];
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;
    $allParams['owner_id'] = $subject->owner_id;
    $allParams['pageoffer_id'] = $subject->getIdentity();
    $allParams['widgtename'] = 'other';
    $allParams['order'] = $allParams['info'];
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('pageoffers', 'sespageoffer')->getOffersPaginator($allParams);

    if ($paginator->getTotalItemCount() == 0) {
      return $this->setNoRender();
    }
  }
}
