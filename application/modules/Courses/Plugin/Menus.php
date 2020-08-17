<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Menus.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Courses_Plugin_Menus {

  public function canCreateCourses() {
    // Must be logged in
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!$viewer || !$viewer->getIdentity()) {
      return false;
    }
    if (!Engine_Api::_()->authorization()->isAllowed('courses', $viewer, 'create') || Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.enable.course', 1)) {
      return false;
    }
    return true;
  }  
  public function canClaimCourses() { 
    // Must be able to view Course
    $viewer = Engine_Api::_()->user()->getViewer();
    if(!$viewer || !$viewer->getIdentity() )
      return false;
    if(Engine_Api::_()->authorization()->getPermission($viewer, 'courses', 'auth_claim'))
      return true;
    return false;
  }
  public function canQuickCreateCourses(){
    $viewer = Engine_Api::_()->user()->getViewer();
     $subject = Engine_Api::_()->core()->getSubject();
     $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    if ((!$viewer || !$viewer->getIdentity()) && ($subject->owner_id == $viewer->getIdentity())) {
      return false;
    }
    if (!Engine_Api::_()->authorization()->isAllowed('courses', $viewer, 'create')) {
      return false;
    }
    return array(
            'label' => $view->translate('Create Course'),
            'class' => 'buttonlink icon_courses_new',
            'route' => 'courses_general',
            'params' => array(
                'action' => 'create',
                'classroom_id' => $subject->getIdentity(),
            )
    );
  }
  public function canQuickCreateLecture(){
    $viewer = Engine_Api::_()->user()->getViewer();
     $subject = Engine_Api::_()->core()->getSubject();
     $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    if ((!$viewer || !$viewer->getIdentity()) && ($subject->owner_id == $viewer->getIdentity())) {
      return false; 
    }
    if (!Engine_Api::_()->authorization()->isAllowed('courses', $viewer, 'create')) {
      return false;
    }
    return array(
            'label' => $view->translate('Create Lecture'),
            'class' => 'buttonlink icon_courses_new',
            'route' => 'lecture_general',
            'params' => array(
                'action' => 'create',
                'course_id' => $subject->getIdentity(),
            )
    );
  }
    function canViewMultipleCurrency(){
      if(!Engine_Api::_()->getDbtable("modules", "core")->isModuleEnabled("sesmultiplecurrency"))
          return false;
      else
          return true;
    }
    function addtocart(){ 
      $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
      $settings =  Engine_Api::_()->getApi('settings', 'core');
      $label = "";
      $class = "";
      if($settings->getSetting('courses.cartviewtype',1)== 1) {
        $label = $view->translate('Add To Cart');
      }elseif($settings->getSetting('courses.cartviewtype', 1) == 2) {
        $class = 'cart_icon';
      }else if($settings->getSetting('courses.cartviewtype', 1) == 3){       
         $class = 'cart_icon cart_icon_text';
      }
      return array(   
            'label' => $label,
            'class' => 'sesbasic_icon_edit '.$class,
            'route' => 'courses_cart',
            'params' => array(
                'module' => 'courses',
            )
      );
    } 
    public function myReviews() {
      $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
      $navigation = Engine_Api::_()
                    ->getApi('menus', 'core')
                    ->getNavigation('courses_main_myreviews', array());
      $routData = $navigation->toArray()[0];
      if(count($routData) <= 0)
       return false;
      if(count($routData) > 1)
        $routData['label'] = $view->translate('My Review');
      return $routData;
    } 
    public function myAccount() {
      $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
      $navigation = Engine_Api::_()
                    ->getApi('menus', 'core')
                    ->getNavigation('courses_main_account', array());
      $routData = $navigation->toArray()[0];
      if(count($routData) <= 0)
        return false;
      if(count($routData) > 1)
        $routData['label'] = $view->translate('My Account');
      return $routData;
    }
    public function onMenuInitialize_CoursesReviewProfileEdit() {
        $viewer = Engine_Api::_()->user()->getViewer();
        $review = Engine_Api::_()->core()->getSubject();
        $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
        if (!(Engine_Api::_()->getApi('settings', 'core')->getSetting('courses.allow.review', 0)))
            return false;
        if (!$viewer->getIdentity())
            return false;
        if (!$review->authorization()->isAllowed($viewer, 'edit'))
            return false;
        return array(
            'label' => $view->translate('Edit Review'),
            'class' => 'smoothbox sesbasic_icon_edit',
            'route' => 'coursesreview_view',
            'params' => array(
                'action' => 'edit-review',
                'review_id' => $review->getIdentity(),
                'slug' => $review->getSlug(),
            )
        );
    }
    public function onMenuInitialize_CoursesReviewProfileReport() {
        $viewer = Engine_Api::_()->user()->getViewer();
        $review = Engine_Api::_()->core()->getSubject();
        $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
        if (!(Engine_Api::_()->getApi('settings', 'core')->getSetting('courses.show.report', 1)))
            return false;
        if (!$viewer->getIdentity())
            return false;
        return array(
            'label' => $view->translate('Report'),
            'class' => 'smoothbox sesbasic_icon_report',
            'route' => 'default',
            'params' => array(
                'module' => 'core',
                'controller' => 'report',
                'action' => 'create',
                'subject' => $review->getGuid(),
                'format' => 'smoothbox',
            ),
        );
    }
    public function onMenuInitialize_CoursesReviewProfileShare() {
        $viewer = Engine_Api::_()->user()->getViewer();
        $review = Engine_Api::_()->core()->getSubject();
        $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
        if (!(Engine_Api::_()->getApi('settings', 'core')->getSetting('courses.allow.share', 1)))
            return false;
        if (!$viewer->getIdentity())
            return false;
        if (!$viewer->getIdentity())
            return false;
        return array(
            'label' => $view->translate('Share'),
            'class' => 'smoothbox sesbasic_icon_share',
            'route' => 'default',
            'params' => array(
                'module' => 'activity',
                'controller' => 'index',
                'action' => 'share',
                'type' => $review->getType(),
                'id' => $review->getIdentity(),
                'format' => 'smoothbox',
            ),
        );
    }
    public function onMenuInitialize_CoursesReviewProfileDelete() {
        $viewer = Engine_Api::_()->user()->getViewer();
        $review = Engine_Api::_()->core()->getSubject();
        $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
        if (!$viewer->getIdentity())
            return false;
        if (!$review->authorization()->isAllowed($viewer, 'delete'))
            return false;
        return array(
            'label' => $view->translate('Delete Review'),
            'class' => 'smoothbox sesbasic_icon_delete',
            'route' => 'coursesreview_view',
            'params' => array(
                'action' => 'delete',
                'review_id' => $review->getIdentity(),
                'format' => 'smoothbox',
            ),
        );
    }
    public function onMenuInitialize_CoursesGutterEreview(){
      return true;
    }
    public function onMenuInitialize_CoursesGutterList($row) {
      if( !Engine_Api::_()->core()->hasSubject() )
          return false;
      $subject = Engine_Api::_()->core()->getSubject();
      if( $subject instanceof User_Model_User ) {
          $user_id = $subject->getIdentity();
      } else if( $subject instanceof Courses_Model_Course) {
          $user_id = $subject->owner_id;
      } else {
          return false;
      }
      return array(
        'label' => 'View All User Courses',
                'class'=>'buttonlink icon_courses_viewall',
        'icon' => 'application/modules/Sesbasic/externals/images/edit.png',
        'route' => 'courses_general',
        'params' => array(
            'action' => 'browse',
            'user_id' => $user_id,
        )
      );
    }
    public function onMenuInitialize_CoursesGutterShare($row) {
        $viewer = Engine_Api::_()->user()->getViewer();
        if( !$viewer->getIdentity() || !Engine_Api::_()->getApi('settings', 'core')->getSetting('courses.enable.sharing', 1))
            return false;
        if( !Engine_Api::_()->core()->hasSubject() )
            return false;
        $subject = Engine_Api::_()->core()->getSubject();
        if( !($subject instanceof Courses_Model_Course) )
            return false;
        // Modify params
        $params = $row->params;
        $params['params']['type'] = $subject->getType();
        $params['params']['id'] = $subject->getIdentity();
        $params['params']['format'] = 'smoothbox';
        return $params;
    }
    public function onMenuInitialize_CoursesGutterReport($row) {
        $viewer = Engine_Api::_()->user()->getViewer();
        if( !$viewer->getIdentity() || !Engine_Api::_()->getApi('settings', 'core')->getSetting('courses.enable.report', 1))
            return false;
        if( !Engine_Api::_()->core()->hasSubject() )
            return false;
        $subject = Engine_Api::_()->core()->getSubject();
        if( ($subject instanceof Courses_Model_Course) &&
            $subject->owner_id == $viewer->getIdentity() ) {
            return false;
        } else if( $subject instanceof User_Model_User &&
            $subject->getIdentity() == $viewer->getIdentity() ) {
            return false;
        }
        // Modify params
        $subject = Engine_Api::_()->core()->getSubject();
        $params = $row->params;
        $params['params']['subject'] = $subject->getGuid();
        return $params;
    }
    public function onMenuInitialize_CoursesGutterDashboard($row) {
        if( !Engine_Api::_()->core()->hasSubject())
          return false;
        $viewer = Engine_Api::_()->user()->getViewer();
        $courses = Engine_Api::_()->core()->getSubject('courses');
        $isCourseAdmin = Engine_Api::_()->courses()->isCourseAdmin($courses, 'edit');
        if(!$isCourseAdmin)
          return false;
        // Modify params
        $params = $row->params;
        $params['params']['course_id'] = $courses->custom_url;
        return $params;
    }
    public function onMenuInitialize_CoursesGutterDelete($row) {
        if( !Engine_Api::_()->core()->hasSubject())
         return false;
        $viewer = Engine_Api::_()->user()->getViewer();
        $courses = Engine_Api::_()->core()->getSubject('courses');
        if(!$courses->authorization()->isAllowed($viewer, 'delete'))
          return false;
        $params = $row->params;
        $params['params']['course_id'] = $courses->getIdentity();
        return $params;
    }
    public function onMenuInitialize_CourseslectureProfileEdit($row) {
      if( !Engine_Api::_()->core()->hasSubject())
        return false;
      $viewer = Engine_Api::_()->user()->getViewer();
      $lecture = Engine_Api::_()->core()->getSubject('courses_lecture');
      if(!Engine_Api::_()->authorization()->getPermission($viewer, 'courses', 'lec_edit'))
        return false;
      if(($viewer->getIdentity() != $lecture->owner_id) && !$viewer->isAdmin())
        return false;
      return array(
          'route' => 'lecture_general',
          'class' => 'smoothbox sesbasic_icon_edit',
          'params' => array(
              'action' => 'edit',
              'lecture_id' => $lecture->getIdentity(),
              'format' => 'smoothbox',
          ),
      );
    }
    public function onMenuInitialize_CourseslectureProfileDelete($row) {
      if( !Engine_Api::_()->core()->hasSubject())
        return false;
      $viewer = Engine_Api::_()->user()->getViewer();
      $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
      $lecture = Engine_Api::_()->core()->getSubject('courses_lecture');
      if(!Engine_Api::_()->authorization()->getPermission($viewer, 'courses', 'lec_delete'))
        return false;
       return array(
            'label' => $view->translate('Delete Lecture'),
            'class' => 'smoothbox sesbasic_icon_delete',
            'route' => 'lecture_general',
            'params' => array(
                'action' => 'delete',
                'lecture_id' => $lecture->getIdentity(),
                'format' => 'smoothbox',
            ),
      );
    } 
    public function onMenuInitialize_CourseslectureProfileReport($row) {
      $viewer = Engine_Api::_()->user()->getViewer();
      $lecture = Engine_Api::_()->core()->getSubject();
      if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('courses.allow.report', 1))
      return false;
      if($lecture->owner_id == $viewer->getIdentity())
        return false;
      if (!$viewer->getIdentity())
        return false;
      return array(
          'label' => 'Report',
          'class' => 'smoothbox sesbasic_icon_report',
          'route' => 'default',
          'params' => array(
              'module' => 'core',
              'controller' => 'report',
              'action' => 'create',
              'subject' => $lecture->getGuid(),
              'format' => 'smoothbox',
          ),
      );
  }
}
