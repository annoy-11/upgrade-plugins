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

class Sesbusinessoffer_Widget_OtherOffersController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    if (!Engine_Api::_()->core()->hasSubject('businessoffer'))
        return $this->setNoRender();

    if(Engine_Api::_()->core()->hasSubject('businessoffer'))
        $subject = Engine_Api::_()->core()->getSubject('businessoffer');

    $this->view->params = $this->view->allParams = $allParams = $this->_getAllParams();
    $show_criterias = $allParams['show_criteria'];
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;
    $allParams['owner_id'] = $subject->owner_id;
    $allParams['businessoffer_id'] = $subject->getIdentity();
    $allParams['widgtename'] = 'other';
    $allParams['order'] = $allParams['info'];
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('businessoffers', 'sesbusinessoffer')->getOffersPaginator($allParams);

    if ($paginator->getTotalItemCount() == 0) {
      return $this->setNoRender();
    }
  }
}
