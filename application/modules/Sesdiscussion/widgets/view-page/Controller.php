<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesdiscussion_Widget_ViewPageController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

        $this->view->allParams = $allParams = $this->_getAllParams();
        $this->view->createform = $createform = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.createform', 1);
        $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
        $this->view->viewer_id = $viewer->getIdentity();
        $discussion_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('discussion_id', 0);
        $this->view->discussion = $discussion = Engine_Api::_()->getItem('discussion', $discussion_id);
        $this->view->owner = $owner = $discussion->getOwner();
        $this->view->canEdit = Engine_Api::_()->authorization()->isAllowed('discussion', $viewer, 'edit');
        $this->view->canDelete = Engine_Api::_()->authorization()->isAllowed('discussion', $viewer, 'delete');
        $this->view->discussionTags = $discussion->tags()->getTagMaps();
  }
}
