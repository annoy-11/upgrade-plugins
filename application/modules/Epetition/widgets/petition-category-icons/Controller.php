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

class Epetition_Widget_PetitionCategoryIconsController extends Engine_Content_Widget_Abstract
{

  public function indexAction()
  {
    $this->view->height = $this->_getParam('height', '200');
    $this->view->width = $this->_getParam('width', '200');
    $this->view->alignContent = $this->_getParam('alignContent', 'center');
    $this->view->titleC = $this->_getParam('titleC', 'What are you in the mood for?');
    $params['criteria'] = $this->_getParam('criteria', '');
    $show_criterias = $this->_getParam('show_criteria', array('title','countPetitions', 'icon'));
    $epetition_categorypetition = Zend_Registry::isRegistered('epetition_categorypetition') ? Zend_Registry::get('epetition_categorypetition') : null;

    if (0) {
      return $this->setNoRender();
    }

    if (in_array('countPetitions', $show_criterias) || $params['criteria'] == 'most_petition')
      $params['countPetitions'] = true;

    foreach ($show_criterias as $show_criteria)
    {
    	$this->view->$show_criteria = $show_criteria;
    }
    $params['limit'] = $this->_getParam('limit_data', 10);
    // Get petitions category
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('categories', 'epetition')->getCategory($params);


    if (count($paginator) == 0)
    {  return $this->setNoRender();  }
  }

}
