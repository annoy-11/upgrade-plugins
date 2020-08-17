<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesprofilefield_Widget_ProfileInformationsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    // Don't render this if not authorized
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    if( !Engine_Api::_()->core()->hasSubject() ) {
      return $this->setNoRender();
    }

    // Get subject and check auth
    $this->view->subject = $subject = Engine_Api::_()->core()->getSubject('user');
//    if( !$subject->authorization()->isAllowed($viewer, 'view'))
//      return $this->setNoRender();

    $this->view->viewer_id = $viewer_id = $viewer->getIdentity();

    $this->view->subject_id = $subject_id = $subject->getIdentity();

    $this->view->skills = $skills = Engine_Api::_()->getDbtable('skills', 'sesprofilefield')->getSkills(array('user_id' => $subject_id, 'column_name' => '*'));

    $this->view->educationEntries = $educationEntries = Engine_Api::_()->getDbTable('educations', 'sesprofilefield')->getAllEducations($subject_id);

    $this->view->certificationEntries = $certificationEntries = Engine_Api::_()->getDbTable('certifications', 'sesprofilefield')->getAllCertifications($subject_id);

    $this->view->awardEntries = $awardEntries = Engine_Api::_()->getDbTable('awards', 'sesprofilefield')->getAllAwards($subject_id);
    $sesprofilefield_widget = Zend_Registry::isRegistered('sesprofilefield_widget') ? Zend_Registry::get('sesprofilefield_widget') : null;
    if(empty($sesprofilefield_widget))
      return $this->setNoRender();
    $this->view->experienceEntries = $experienceEntries = Engine_Api::_()->getDbTable('experiences', 'sesprofilefield')->getAllExperiences($subject_id);

    $this->view->organizationEntries = $organizationEntries = Engine_Api::_()->getDbTable('organizations', 'sesprofilefield')->getAllOrganizations($subject_id);

    $this->view->projectEntries = $projectEntries = Engine_Api::_()->getDbTable('projects', 'sesprofilefield')->getAllProjects($subject_id);

    $this->view->languages = $languages = Engine_Api::_()->getDbtable('languages', 'sesprofilefield')->getLanguages(array('user_id' => $subject_id, 'column_name' => '*'));

    $this->view->courseEntries = $courseEntries = Engine_Api::_()->getDbTable('courses', 'sesprofilefield')->getAllCourses($subject_id);


    $allowprofile = Engine_Api::_()->authorization()->getPermission($subject, 'sesprofilefield', 'allowprofile');
    $this->view->allowprofile = $allowprofile = json_decode($allowprofile);
    if(!empty($viewer_id) && count($allowprofile) == 0)
        return $this->setNoRender();
    $this->view->exper_count = Engine_Api::_()->authorization()->getPermission($subject, 'sesprofilefield', 'exper_count');
    $this->view->edution_count = $edution_count = Engine_Api::_()->authorization()->getPermission($subject, 'sesprofilefield', 'edution_count');
    $this->view->skill_count = $skill_count = Engine_Api::_()->authorization()->getPermission($subject, 'sesprofilefield', 'skill_count');
    $this->view->cer_count = $cer_count = Engine_Api::_()->authorization()->getPermission($subject, 'sesprofilefield', 'cer_count');
    $this->view->awards_count = $awards_count = Engine_Api::_()->authorization()->getPermission($subject, 'sesprofilefield', 'awards_count');
    $this->view->org_count = $org_count = Engine_Api::_()->authorization()->getPermission($subject, 'sesprofilefield', 'org_count');
    $this->view->course_count = $course_count = Engine_Api::_()->authorization()->getPermission($subject, 'sesprofilefield', 'course_count');
    $this->view->project_count = $project_count = Engine_Api::_()->authorization()->getPermission($subject, 'sesprofilefield', 'project_count');
    $this->view->lng_count = $lng_count = Engine_Api::_()->authorization()->getPermission($subject, 'sesprofilefield', 'lng_count');

    if(count($experienceEntries) == 0 && count($educationEntries) == 0 && count($skills) == 0 && count($certificationEntries) == 0 && count($awardEntries) == 0 && count($organizationEntries) == 0 && count($courseEntries) == 0 && count($projectEntries) == 0 && count($languages) == 0)
        return $this->setNoRender();

  }
}
