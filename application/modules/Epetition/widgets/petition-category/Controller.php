<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Controller.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Epetition_Widget_PetitionCategoryController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
	  $this->view->height = $this->_getParam('height', '150px');
    $this->view->width = $this->_getParam('width', '292px');
    $params['criteria'] = $this->_getParam('criteria', '');
		$params['limit'] = $this->_getParam('limit', 0);
		$params['petition_required'] = $this->_getParam('petition_required',0);
    $show_criterias = $this->_getParam('show_criteria', array('title', 'countPetitions', 'icon'));
    if (in_array('countPetitions', $show_criterias))
      $params['countPetitions'] = true;
		if($params['petition_required'])
			$params['petitionRequired'] = true;
		$this->view->show_criterias = $show_criterias;
    foreach ($show_criterias as $show_criteria)
      $this->view->$show_criteria = $show_criteria;
    // Get videos
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('categories', 'epetition')->getCategory($params);
    if (count($paginator) == 0)
      return;

  }

}
