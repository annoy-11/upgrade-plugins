<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Einstaclone
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Controller.php 2019-12-30 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */


class Einstaclone_Widget_MemberProfileUserInfoController extends Engine_Content_Widget_Abstract {

    public function indexAction() {
    
      // Don't render this if not authorized 
      $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer(); 
      if( !Engine_Api::_()->core()->hasSubject() ) { 
        return $this->setNoRender(); 
      }
      $this->view->viewer_id = $viewer->getIdentity();

      // Get subject and check auth 
      $this->view->subject = $subject = Engine_Api::_()->core()->getSubject('user'); 
      if( !$subject->authorization()->isAllowed($viewer, 'view') ) { 
        return $this->setNoRender(); 
      }
    
      //Multiple friend mode 
      $select = $subject->membership()->getMembersOfSelect(); 
      $paginator = Zend_Paginator::factory($select); 
      $followCount = $paginator->getTotalItemCount(); 
      $this->view->followCount = Engine_Api::_()->einstaclone()->number_format_short($followCount); 
      $this->view->postCount = Engine_Api::_()->einstaclone()->postCount($subject->getIdentity());
    
			$this->view->userNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('user_profile');
    }
}
