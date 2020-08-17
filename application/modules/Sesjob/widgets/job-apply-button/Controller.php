<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesjob_Widget_JobApplyButtonController extends Engine_Content_Widget_Abstract {

    public function indexAction() {

        $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('job_id', null);
        $this->view->job_id = $job_id = Engine_Api::_()->getDbtable('jobs', 'sesjob')->getJobId($id);
        if(!Engine_Api::_()->core()->hasSubject())
        $sesjob = Engine_Api::_()->getItem('sesjob_job', $job_id);
        else
        $sesjob = Engine_Api::_()->core()->getSubject();
        $viewer = Engine_Api::_()->user()->getViewer();
        $this->view->viewer_id = $viewerId = $viewer->getIdentity();

        if(!empty($viewerId)) {

            $this->view->isApplied = Engine_Api::_()->getDbTable('applications', 'sesjob')->isApplied(array('job_id' => $sesjob->getIdentity(), 'owner_id' => $viewerId));
        }

    }
}
