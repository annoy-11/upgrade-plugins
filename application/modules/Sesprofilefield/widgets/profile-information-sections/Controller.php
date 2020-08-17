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

class Sesprofilefield_Widget_ProfileInformationSectionsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    // Don't render this if not authorized
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    if( !Engine_Api::_()->core()->hasSubject() ) {
      return $this->setNoRender();
    }

    // Get subject and check auth
    $this->view->subject = $subject = Engine_Api::_()->core()->getSubject('user');
    if( !$subject->authorization()->isAllowed($viewer, 'view') ) {
      return $this->setNoRender();
    }
    $this->view->viewer_id = $viewer_id = $viewer->getIdentity();
    $this->view->subject_id = $subject_id = $subject->getIdentity();

    $allowprofile = Engine_Api::_()->authorization()->getPermission($viewer, 'sesprofilefield', 'allowprofile');
    $sesprofilefield_widget = Zend_Registry::isRegistered('sesprofilefield_widget') ? Zend_Registry::get('sesprofilefield_widget') : null;
    if(empty($sesprofilefield_widget))
      return $this->setNoRender();
    $this->view->allowprofile = $allowprofile = json_decode($allowprofile);
    if(count($allowprofile) == 0)
        return $this->setNoRender();

    $this->view->exper_count = Engine_Api::_()->authorization()->getPermission($viewer, 'sesprofilefield', 'exper_count');
    $this->view->edution_count = Engine_Api::_()->authorization()->getPermission($viewer, 'sesprofilefield', 'edution_count');
    $this->view->skill_count = Engine_Api::_()->authorization()->getPermission($viewer, 'sesprofilefield', 'skill_count');
    $this->view->cer_count = Engine_Api::_()->authorization()->getPermission($viewer, 'sesprofilefield', 'cer_count');
    $this->view->awards_count = Engine_Api::_()->authorization()->getPermission($viewer, 'sesprofilefield', 'awards_count');
    $this->view->org_count = Engine_Api::_()->authorization()->getPermission($viewer, 'sesprofilefield', 'org_count');
    $this->view->course_count = Engine_Api::_()->authorization()->getPermission($viewer, 'sesprofilefield', 'course_count');
    $this->view->project_count = Engine_Api::_()->authorization()->getPermission($viewer, 'sesprofilefield', 'project_count');
    $this->view->lng_count = Engine_Api::_()->authorization()->getPermission($viewer, 'sesprofilefield', 'lng_count');

    $this->view->skills = Engine_Api::_()->getDbtable('skills', 'sesprofilefield')->getSkills(array('user_id' => $subject_id, 'column_name' => '*'));

    $this->view->educationEntries = $educationEntries = Engine_Api::_()->getDbTable('educations', 'sesprofilefield')->getAllEducations($subject_id);

    $this->view->certificationEntries = $certificationEntries = Engine_Api::_()->getDbTable('certifications', 'sesprofilefield')->getAllCertifications($subject_id);

    $this->view->awardEntries = $awardEntries = Engine_Api::_()->getDbTable('awards', 'sesprofilefield')->getAllAwards($subject_id);

    $this->view->experienceEntries = $experienceEntries = Engine_Api::_()->getDbTable('experiences', 'sesprofilefield')->getAllExperiences($subject_id);

    $this->view->organizationEntries = $organizationEntries = Engine_Api::_()->getDbTable('organizations', 'sesprofilefield')->getAllOrganizations($subject_id);

    $this->view->projectEntries = $projectEntries = Engine_Api::_()->getDbTable('projects', 'sesprofilefield')->getAllProjects($subject_id);

    $this->view->languages = Engine_Api::_()->getDbtable('languages', 'sesprofilefield')->getLanguages(array('user_id' => $subject_id, 'column_name' => '*'));

    $this->view->courseEntries = $courseEntries = Engine_Api::_()->getDbTable('courses', 'sesprofilefield')->getAllCourses($subject_id);

    if($subject_id != $viewer_id)
      return $this->setNoRender();
	}
}
