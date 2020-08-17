<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 

class Sespage_Widget_MainPageDetailsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    if (!Engine_Api::_()->core()->hasSubject('sespage_page'))
      return $this->setNoRender();
    $subject = Engine_Api::_()->core()->getSubject();
    $show_criterias = $this->_getParam('show_criteria', array('pagePhoto', 'title', 'likeButton', 'favouriteButton', 'followButton', 'joinButton'));
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;
    //Set default title
    if (!$this->getElement()->getTitle())
      $this->getElement()->setTitle('Associated Sub Page');
    if (!$subject->parent_id)
      return $this->setNoRender();
    $this->view->page = Engine_Api::_()->getItem('sespage_page', $subject->parent_id);
  }

}
