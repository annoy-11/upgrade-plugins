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

class Sesjob_Widget_JobCategoryIconsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->height = $this->_getParam('height', '200');
    $this->view->width = $this->_getParam('width', '200');
    $this->view->alignContent = $this->_getParam('alignContent', 'center');
    $this->view->titleC = $this->_getParam('titleC','What are you in the mood for?');
    $params['criteria'] = $this->_getParam('criteria', '');
    $show_criterias = $this->_getParam('show_criteria', array('title', 'countJobs', 'icon'));
    $sesjob_categoryjob = Zend_Registry::isRegistered('sesjob_categoryjob') ? Zend_Registry::get('sesjob_categoryjob') : null;
    if(0) {
      return $this->setNoRender();
    }
    if (in_array('countJobs', $show_criterias) || $params['criteria'] == 'most_job')
      $params['countJobs'] = true;

    foreach ($show_criterias as $show_criteria)
      $this->view->$show_criteria = $show_criteria;
		$params['limit'] = $this->_getParam('limit_data',10);
    // Get jobs category
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('categories', 'sesjob')->getCategory($params);

    if (count($paginator) == 0)
      return;
  }

}
