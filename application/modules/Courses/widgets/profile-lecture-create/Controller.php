<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Courses
 * @package    Courses
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2015-10-11 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Courses_Widget_ProfileLectureCreateController extends Engine_Content_Widget_Abstract {
  public function indexAction() {
    $subject = Engine_Api::_()->core()->getSubject();
    if($subject->getType() != "courses")
      return $this->setNoRender();
    // Get quick navigation
    $this->view->quickNavigation = $quickNavigation = Engine_Api::_()->getApi('menus', 'core')
            ->getNavigation('courses_lecture_quick');
  }
}
