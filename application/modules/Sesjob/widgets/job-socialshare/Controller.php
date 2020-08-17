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

class Sesjob_Widget_JobSocialshareController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('job_id', null);
    $this->view->design_type = $this->_getParam('socialshare_design', 1);
    $job_id = Engine_Api::_()->getDbtable('jobs', 'sesjob')->getJobId($id);
    if(!Engine_Api::_()->core()->hasSubject())
    $this->view->sesjob = Engine_Api::_()->getItem('sesjob_job', $job_id);
    else
    $this->view->sesjob = Engine_Api::_()->core()->getSubject();
  }

}
