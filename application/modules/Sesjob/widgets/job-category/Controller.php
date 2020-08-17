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

class Sesjob_Widget_JobCategoryController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $this->view->height = $this->_getParam('height', '150px');
    $this->view->width = $this->_getParam('width', '292px');
    $params['criteria'] = $this->_getParam('criteria', '');
		$params['limit'] = $this->_getParam('limit', 0);
		$params['job_required'] = $this->_getParam('job_required',0);
    $show_criterias = $this->_getParam('show_criteria', array('title', 'countJobs', 'icon'));
    if (in_array('countJobs', $show_criterias))
      $params['countJobs'] = true;
		if($params['job_required'])
			$params['jobRequired'] = true;
		$this->view->show_criterias = $show_criterias;
    foreach ($show_criterias as $show_criteria)
      $this->view->$show_criteria = $show_criteria;
    // Get videos
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('categories', 'sesjob')->getCategory($params);
    if (count($paginator) == 0)
      return;
  }

}
