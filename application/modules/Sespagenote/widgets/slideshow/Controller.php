<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagenote
 * @package    Sespagenote
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-03-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespagenote_Widget_SlideshowController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->allparams = $allparams = $this->_getAllParams();
     $show_criterias = $allparams['show_criteria'];
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;
    $allparams['order'] = $allparams['info'];
    $sespagenote_widget = Zend_Registry::isRegistered('sespagenote_widget') ? Zend_Registry::get('sespagenote_widget') : null;
    if(empty($sespagenote_widget))
      return $this->setNoRender();
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('pagenotes', 'sespagenote')->getNotesPaginator($allparams);
    $paginator->setItemCountPerPage($allparams['limit_data']);
    $paginator->setCurrentPageNumber(1);
  }
}
