<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmember
 * @package    Sesmember
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesmember_Widget_MemberFeaturedPhotosController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id');
    $this->view->user_id = 0;
    $this->view->viewer_id = 0;
    $objectId = 0;
    if (null !== $id) {
      $subject = Engine_Api::_()->user()->getUser($id);
      $this->view->user_id = $objectId = $subject->user_id;
    }
    $this->view->sesalbumenabled = $sesalbumenabled = Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesalbum');
    $this->view->viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
    if (Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('album') || $sesalbumenabled)
      $this->view->photos = Engine_Api::_()->getDbTable('members', 'sesmember')->getFeaturedPhotos($objectId);
    else
      $this->setNoRender();
    if ((count($this->view->photos) == 0 && $this->view->viewer_id != $subject->getIdentity()) || (count($this->view->photos) == 0 && $this->view->viewer_id == 0)) {
      $this->setNoRender();
    }
  }

}
