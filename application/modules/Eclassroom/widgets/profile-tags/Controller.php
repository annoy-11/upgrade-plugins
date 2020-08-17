<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Controller.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */


class Eclassroom_Widget_ProfileTagsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $subject = Engine_Api::_()->core()->getSubject();
    $subject_id = $subject->getIdentity();
    if(empty($subject_id))
      return $this->setNoRender();

    $this->view->paginator = $paginator = Engine_Api::_()->eclassroom()->tagCloudItemCore('', $subject_id);
    $paginator->setItemCountPerPage($this->_getParam('itemCountPerPage', '25'));
    $paginator->setCurrentPageNumber (1);
    if( $paginator->getTotalItemCount() <= 0 )
      return $this->setNoRender();
  }
}
