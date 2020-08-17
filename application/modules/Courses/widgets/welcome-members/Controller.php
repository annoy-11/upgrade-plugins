<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Controller.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Courses_Widget_WelcomeMembersController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $this->getElement()->removeDecorator('Title');
    $this->view->heading = $this->_getParam('heading',"");
    $this->view->description = $this->_getParam('description',"");
    
    $showMemberLeft = $this->_getParam('showMemberLeft',1);
    $MemberLevelLeft = $this->_getParam('MemberLevelLeft',1); 
    $leftMemberCount = $this->_getParam('leftMemberCount',1); 
    
    $showMemberRight = $this->_getParam('showMemberRight',1);
    $MemberLevelRight = $this->_getParam('MemberLevelRight',1); 
    $rightMemberCount = $this->_getParam('rightMemberCount',1); 
    if($showMemberLeft && $MemberLevelLeft) {
      $this->view->leftpaginator = $leftpaginator = Engine_Api::_()->getDbTable('courses', 'courses')->getWelcomePageMember(array('member_level'=>$MemberLevelLeft));
      $leftpaginator->setItemCountPerPage($leftMemberCount);
      $this->view->leftMemberType = Engine_Api::_()->getItem('authorization_level', $MemberLevelLeft);
      
    }
    if($showMemberRight && $MemberLevelRight) {
      $this->view->rightpaginator = $rightpaginator = Engine_Api::_()->getDbTable('courses', 'courses')->getWelcomePageMember(array('member_level'=>$MemberLevelRight));
      $rightpaginator->setItemCountPerPage($rightMemberCount);
      $this->view->rightMemberType = Engine_Api::_()->getItem('authorization_level', $MemberLevelRight);
    }
  }
}
