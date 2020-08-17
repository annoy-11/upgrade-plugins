<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesforum_Widget_postNewTopicController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $this->view->viewer =  $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->canPost = $canPost = Engine_Api::_()->authorization()->isAllowed('sesforum_forum', $viewer, 'topic_create');
    $this->view->postButton = $postButton = Engine_Api::_()->authorization()->isAllowed('sesforum_forum', $viewer, 'post');
    $this->view->width = $this->_getParam('width','180');

    $request = Zend_Controller_Front::getInstance()->getRequest();
    $requestParams = $request->getParams();
     if(!$requestParams['forum_id'])
        return $this->setNoRender();

    $this->view->sesforum=  $sesforum = Engine_Api::_()->getItem('sesforum_forum',$requestParams['forum_id']);
  }
}
