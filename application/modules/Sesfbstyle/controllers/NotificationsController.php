<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfbstyle
 * @package    Sesfbstyle
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: NotificationsController.php  2017-09-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesfbstyle_NotificationsController extends Core_Controller_Action_Standard {

  public function init() {
    $this->_helper->requireUser();
  }
  
	public function hideAction()
  {
    $viewer = Engine_Api::_()->user()->getViewer();
		$notificationsTable = Engine_Api::_()->getDbtable('notifications', 'activity');
    $where = array(
      '`user_id` = ?' => $viewer->getIdentity(),
      '`sm_read` = ?' => 0
    );
    $notificationsTable->update(array('sm_read' => 1), $where);
    echo "true";die;
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
    $this->view->notifications = $notifications = Engine_Api::_()->getDbtable('notifications', 'sesfbstyle')->getNotificationsPaginator($viewer);
    $notifications->setCurrentPageNumber($page);

    if ($notifications->getCurrentItemCount() <= 0 || $page > $notifications->getCurrentPageNumber()) {
      $this->_helper->viewRenderer->setNoRender(true);
      return;
    }
    
    Engine_Api::_()->getApi('message', 'sesfbstyle')->setUnreadNotification($viewer);

    // Force rendering now
    $this->_helper->viewRenderer->postDispatch();
    $this->_helper->viewRenderer->setNoRender(true);
  }

}