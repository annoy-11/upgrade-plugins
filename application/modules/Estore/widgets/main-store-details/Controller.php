<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Estore_Widget_MainStoreDetailsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    if (!Engine_Api::_()->core()->hasSubject('stores'))
      return $this->setNoRender();
    $subject = Engine_Api::_()->core()->getSubject();
    $show_criterias = $this->_getParam('show_criteria', array('storePhoto', 'title', 'likeButton', 'favouriteButton', 'followButton', 'joinButton'));
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;
    //Set default title
    if (!$this->getElement()->getTitle())
      $this->getElement()->setTitle('Associated Sub Store');
    if (!$subject->parent_id)
      return $this->setNoRender();
    $this->view->store = Engine_Api::_()->getItem('stores', $subject->parent_id);
  }

}
