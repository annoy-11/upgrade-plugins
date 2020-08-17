<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescrowdfunding_Widget_ProfileSimilarCrowdfundingsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    if (isset($_POST['params']))
      $params = json_decode($_POST['params'], true);

		$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
		$identity = $view->identity;
		$this->view->widgetIdentity = $this->_getParam('content_id', $identity);
		$this->view->is_ajax = $is_ajax = $this->_getParam('is_ajax', 0);

    if (!$is_ajax) {
      if (!Engine_Api::_()->core()->hasSubject())
        return $this->setNoRender();

      //Get subject and check auth
      $subject = Engine_Api::_()->core()->getSubject();
      $category_id = $subject->category_id;
      if(!$category_id)
        return $this->setNoRender();

    } else if($is_ajax){
			$subject = Engine_Api::_()->getItem('crowdfunding', $params['crowdfunding_id']);
      $category_id = $params['category_id'];
      if(!$category_id)
        return $this->setNoRender();
		}

		if ($this->_getParam('showLimitData', 1))
      $this->view->widgetName = 'profile-similar-crowdfundings';

		$this->view->height = isset($params['height']) ? $params['height'] : $this->_getParam('height', '264');

    $this->view->width = isset($params['width']) ? $params['width'] : $this->_getParam('width', '262');

		$this->view->title_truncation = isset($params['title_truncation']) ? $params['title_truncation'] : $this->_getParam('title_truncation', '45');

		$this->view->description_truncation = isset($params['description_truncation']) ? $params['description_truncation'] : $this->_getParam('description_truncation', '45');

		$this->view->view_type = isset($params['viewType']) ? $params['viewType'] : $this->_getParam('viewType', 'list');

    $show_criterias = isset($params['show_criterias']) ? $params['show_criterias'] : $this->_getParam('show_criteria', array('like', 'comment', 'title', 'socialSharing', 'view', 'featuredLabel', 'sponsoredLabel', 'verifiedLabel', 'rating', 'by', 'favourite','category','favouriteButton','likeButton'));

    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;

    $limit = isset($params['limit_data']) ? $params['limit_data'] : $this->_getParam('limit_data', 3);

    $this->view->params = array('show_criterias' => $show_criterias, 'limit_data' => $limit, 'category_id' => $category_id, 'title_truncation' => $this->view->title_truncation, 'height' => $this->view->height, 'width' => $this->view->width, 'description_truncation' => $this->view->description_truncation, 'view_type' => $this->view->view_type, 'crowdfunding_id' => $subject->crowdfunding_id);

    $value['category_id'] = $category_id;

    $value['widgetName'] = 'Similar Crowdfunding';

    $page = isset($_POST['page']) ? $_POST['page'] : 1;

    $value['crowdfunding_id'] = $subject->getIdentity();

    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('crowdfundings', 'sescrowdfunding')->getSescrowdfundingsPaginator($value);
		$paginator->setItemCountPerPage($limit);
		$this->view->page = $page;
		$paginator->setCurrentPageNumber($page);

		if ($paginator->getTotalItemCount() <= 0)
      return $this->setNoRender();

		if ($is_ajax)
      $this->getElement()->removeDecorator('Container');
  }
}
