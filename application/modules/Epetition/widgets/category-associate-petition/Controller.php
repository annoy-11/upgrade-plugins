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

class Epetition_Widget_CategoryAssociatePetitionController extends Engine_Content_Widget_Abstract
{

	public function indexAction()
	{
		$params = array();
		if (isset($_POST['params']))
		{
			$params = json_decode($_POST['params'], true);
		}
		$this->view->allParams = $this->_getAllParams();
		$this->view->loadOptionData = $loadOptionData = isset($params['loadOptionData']) ? $params['loadOptionData'] : $this->_getParam('pagging', 'auto_load');
		$this->view->category_limit = $category_limit = isset($params['category_limit']) ? $params['category_limit'] : $this->_getParam('category_limit', '10');
		$this->view->petition_description_truncation = $petition_description_truncation = isset($params['petition_description_truncation']) ? $params['petition_description_truncation'] : $this->_getParam('petition_description_truncation', '300');
		$this->view->petition_limit = $petition_limit = isset($params['petition_limit']) ? $params['petition_limit'] : $this->_getParam('petition_limit', '8');
		$this->view->count_petition = $count_petition = isset($params['count_petition']) ? $params['count_petition'] : $this->_getParam('count_petition', '1');
		$this->view->width = $width = isset($params['width']) ? $params['width'] : $this->_getParam('width', '250px');
		$this->view->height = $height = isset($params['height']) ? $params['height'] : $this->_getParam('height', '160px');
		$this->view->seemore_text = $seemore_text = isset($params['seemore_text']) ? $params['seemore_text'] : $this->_getParam('seemore_text', '+ See all [category_name]');
		$this->view->allignment_seeall = $allignment_seeall = isset($params['allignment_seeall']) ? $params['allignment_seeall'] : $this->_getParam('allignment_seeall', 'left');
		$this->view->identityForWidget = $identityForWidget = isset($_POST['identity']) ? $_POST['identity'] : '';
		$this->view->popularity_petition = $popularity_petition = isset($params['popularity_petition']) ? $params['popularity_petition'] : $this->_getParam('popularity_petition', 'like_count');
		$criteriaData = isset($params['criteria']) ? $params['criteria'] : $this->_getParam('criteria', 'alphabetical');
		$this->view->is_ajax = $is_ajax = isset($_POST['is_ajax']) ? true : false;
		$page = isset($_POST['page']) ? $_POST['page'] : 1;
		$this->view->widgetName = 'category-associate-petition';
		$show_criterias = isset($params['show_criterias']) ? $params['show_criterias'] : $this->_getParam('show_criteria', array('like', 'comment', 'view', 'rating', 'ratingStar', 'by', 'title', 'featuredLabel', 'sponsoredLabel', 'favourite', 'creationDate', 'readmore'));
		foreach ($show_criterias as $show_criteria)
			$this->view->{$show_criteria . 'Active'} = $show_criteria;
		if ($popularity_petition == 'featured' || $popularity_petition == 'sponsored') {
			$fixedData = $popularity_petition;
			$popularCol = '';
		} else {
			$fixedData = '';
			$popularCol = str_replace('SP', '_',$popularity_petition);;
		}
		// initialize type variable type
		$this->view->params = $params = array('loadOptionData' => $loadOptionData, 'category_limit' => $category_limit, 'petition_limit' => $petition_limit, 'petition_description_truncation' => $petition_description_truncation, 'count_petition' => $count_petition, 'seemore_text' => $seemore_text, 'allignment_seeall' => $allignment_seeall, 'show_criterias' => $show_criterias, 'height' => $height, 'width' => $width, 'criteria' => $criteriaData, 'popularity_petition' => $popularity_petition);
		$petitionData = $countArray = array();
		$this->view->paginatorCategory = $paginatorCategory = Engine_Api::_()->getDbTable('categories', 'epetition')->getCategory(array('hasPetition' => false, 'criteria' => $criteriaData, 'petitionDesc' => 'desc'), array('paginator' => 'yes'));
		$paginatorCategory->setItemCountPerPage($category_limit);
		$paginatorCategory->setCurrentPageNumber($page);
		if ($paginatorCategory->getTotalItemCount() > 0) {
			foreach ($paginatorCategory as $key => $valuePaginator) {
				$countArray[] = isset($valuePaginator->total_petitions_categories) ? $valuePaginator->total_petitions_categories : 0;
				$petitionData['petition_data'][$valuePaginator->category_id] = Engine_Api::_()->getDbTable('epetitions', 'epetition')->getEpetitionsPaginator(array('category_id' => $valuePaginator->category_id, 'status' => 1, 'limit' => $petition_limit, 'popularCol' => $popularCol, 'fixedData' => $fixedData, 'fetchAll' => 0), false);
			}
		} else {
			if (!$is_ajax)
				return $this->setNoRender();
		}
		$this->view->countArray = $countArray;
		$this->view->resultArray = $petitionData;
		// Set item count per page and current page number
		$this->view->page = $page;
		$this->view->paginatorCategory = $paginatorCategory;
		if ($is_ajax) {
			$this->getElement()->removeDecorator('Container');
		}

	}

}
