<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesspectromedia
 * @package    Sesspectromedia
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: NotificationsController.php 2016-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesspectromedia_NotificationsController extends Core_Controller_Action_Standard {

  public function init() {
    $this->_helper->requireUser();
  }

  public function markreadmentionAction() {
    $action_id = $this->_getParam('actionid',0);
    if($action_id){
      $item = Engine_Api::_()->getItem('activity_notification',$action_id);
      if($item){
        $item->read = 1;
        $item->save();
      }
      echo 1;die;
    }
    echo 0;die;
  }
  public function pulldownAction() {

    $page = $this->_getParam('page');
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->notifications = $notifications = Engine_Api::_()->getDbtable('notifications', 'sesspectromedia')->getNotificationsPaginator($viewer);
    $notifications->setCurrentPageNumber($page);

    if ($notifications->getCurrentItemCount() <= 0 || $page > $notifications->getCurrentPageNumber()) {
      $this->_helper->viewRenderer->setNoRender(true);
      return;
    }

    Engine_Api::_()->getApi('message', 'sesspectromedia')->setUnreadNotification($viewer);

    // Force rendering now
    $this->_helper->viewRenderer->postDispatch();
    $this->_helper->viewRenderer->setNoRender(true);
  }
  public function hideAction()
  {
    $viewer = Engine_Api::_()->user()->getViewer();
		$notificationsTable = Engine_Api::_()->getDbtable('notifications', 'activity');
    $where = array(
      '`user_id` = ?' => $viewer->getIdentity(),
      '`read` = ?' => 0
    );
    $notificationsTable->update(array('read' => 1), $where);
   echo "true";die;
  }
}
