<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Bootstrap.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Courses_Bootstrap extends Engine_Application_Bootstrap_Abstract
{
    public function __construct($application) { 
    parent::__construct($application);
    $front = Zend_Controller_Front::getInstance();
    $front->registerPlugin(new Courses_Plugin_Core);
    $baseURL = Zend_Registry::get('StaticBaseUrl');
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $this->initViewHelperPath();
    $headScript = new Zend_View_Helper_HeadScript();
    define('CLASSROOMSHOWUSERDETAIL', Engine_Api::_()->getApi('settings', 'core')->getSetting('classroom.identity.privacy', 1));

    $isCoursesEnable = 0;
    if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('courses')) {
      $isCoursesEnable = 1;
    }
    @define('COURSESENABLED', $isCoursesEnable);
    @define('COURSESPACKAGE', $isCoursesEnable);

    if (Engine_Api::_()->getApi('settings', 'core')->getSetting('classroom.enable.location', 1))
      $headScript->appendFile('https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=' . Engine_Api::_()->getApi('settings', 'core')->getSetting('ses.mapApiKey', ''));

    if (strpos(str_replace('/', '', $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']), str_replace('/', '', $_SERVER['SERVER_NAME'] . 'admin')) === FALSE) {

      $headScript = new Zend_View_Helper_HeadScript();
      $headScript->appendFile($baseURL . 'application/modules/Sesbasic/externals/scripts/flexcroll.js');
      $headScript->appendFile(Zend_Registry::get('StaticBaseUrl') . 'application/modules/Sesbasic/externals/scripts/jquery.flex-images.js');
    }

    if (!class_exists('Core_Model_Like', false))
        include_once APPLICATION_PATH . '/application/modules/Core/Model/Like.php';
        Engine_Api::_()->getDbTable('likes', 'core')->setRowClass('Courses_Model_Like');

    if (!class_exists('Core_Model_Comment', false))
        include_once APPLICATION_PATH . '/application/modules/Core/Model/Comment.php';
        Engine_Api::_()->getDbTable('comments', 'core')->setRowClass('Courses_Model_Comment');

  }
  
  protected function _initFrontController() {
    $this->initActionHelperPath();
    include APPLICATION_PATH . '/application/modules/Courses/controllers/Checklicense.php';
  }
}
