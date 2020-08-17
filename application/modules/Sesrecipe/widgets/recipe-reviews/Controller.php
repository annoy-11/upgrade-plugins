<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecipe
 * @package    Sesrecipe
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2018-05-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesrecipe_Widget_RecipeReviewsController extends Engine_Content_Widget_Abstract {
  protected $_childCount;
  public function indexAction() {

		$viewer = Engine_Api::_()->user()->getViewer();
		if (isset($_POST['params']))
		$params = json_decode($_POST['params'], true);
		if (isset($_POST['searchParams']) && $_POST['searchParams'])
		parse_str($_POST['searchParams'], $searchArray);

		$this->view->is_ajax = $is_ajax = isset($_POST['is_ajax']) ? true : false;
		$this->view->page = $page = isset($_POST['page']) ? $_POST['page'] : $this->_getParam('page', 1);
		$this->view->limit = $limit = isset($_POST['limit']) ? $_POST['limit'] : $this->_getParam('limit_data', 10);
		
		$this->view->socialshare_enable_plusicon = $socialshare_enable_plusicon = isset($_POST['socialshare_enable_plusicon']) ? $_POST['socialshare_enable_plusicon'] : $this->_getParam('socialshare_enable_plusicon', 1);
		$this->view->socialshare_icon_limit = $socialshare_icon_limit = isset($_POST['socialshare_icon_limit']) ? $_POST['socialshare_icon_limit'] : $this->_getParam('socialshare_icon_limit', 2);
		
		$this->view->loadOptionData = isset($_POST['loadOptionData']) ? $_POST['loadOptionData'] : $this->_getParam('pagging', 'auto_load');
    $this->view->widgetId = isset($_POST['widgetId']) ? $_POST['widgetId'] : $this->view->identity;
    $sesrecipe_reviews = Zend_Registry::isRegistered('sesrecipe_reviews') ? Zend_Registry::get('sesrecipe_reviews') : null;

		if (!$is_ajax) {
		  $this->view->subject  = $subject = Engine_Api::_()->core()->getSubject();
			$this->view->allow_create = true;
			
			if(!$is_ajax && Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesrecipepackage') && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipepackage.enable.package', 1)){
				$package = $subject->getPackage();
				$viewAllowed = $package->getItemModule('review');
				if(!$viewAllowed)
					return $this->setNoRender();
			}

			if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.allow.review', 1))
			return $this->setNoRender();
			if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.allow.owner', 1))
			$allowedCreate = true;	
			else{
				if($subject->user_id == $viewer->getIdentity())	
				$allowedCreate = false;
				else
				$allowedCreate = true;
			}
			$this->view->allowedCreate = $allowedCreate;
			
			if (!Engine_Api::_()->core()->hasSubject('sesrecipe_recipe'))
		  return $this->setNoRender();
			
			if (!Engine_Api::_()->authorization()->getPermission($viewer, 'sesrecipe_review', 'view'))
			return $this->setNoRender();
    
			$this->view->isReview = Engine_Api::_()->getDbtable('reviews', 'sesrecipe')->isReview(array('recipe_id' => $subject->getIdentity()));
			$this->view->cancreate = Engine_Api::_()->authorization()->getPermission($viewer, 'sesrecipe_review', 'create'); 
    }
    
		$value['search_text'] = isset($searchArray['search_text']) ? $searchArray['search_text'] : (isset($_GET['search_text']) ? $_GET['search_text'] : (isset($params['search_text']) ? $params['search_text'] : ''));
		$value['order'] = isset($searchArray['order']) ? $searchArray['order'] : (isset($_GET['order']) ? $_GET['order'] : (isset($params['order']) ? $params['order'] : ''));
		$value['review_stars'] = isset($searchArray['review_stars']) ? $searchArray['review_stars'] : (isset($_GET['review_stars']) ? $_GET['review_stars'] : (isset($params['review_stars']) ? $params['review_stars'] : ''));
		$value['review_recommended'] = isset($searchArray['review_recommended']) ? $searchArray['review_recommended'] : (isset($_GET['review_recommended']) ? $_GET['review_recommended'] : (isset($params['review_recommended']) ? $params['review_recommended'] : ''));
    if (empty($sesrecipe_reviews))
      return $this->setNoRender();
		$this->view->stats = isset($params['stats']) ? $params['stats'] : $this->_getParam('stats', array('featured','likeCount', 'commentCount', 'viewCount', 'title', 'postedBy', 'pros', 'cons', 'description', 'creationDate', 'recommended','parameter','rating','likeButton', 'socialSharing'));
			
		$this->view->params = array('stats' => $this->view->stats, 'search_text' => $value['search_text'], 'order' => $value['order'], 'review_stars' => $value['review_stars'], 'review_recommended' => $value['review_recommended']);
    
		$params = array('search_text' => $value['search_text'], 'info' => str_replace('SP', '_', $value['order']), 'review_stars' => $value['review_stars'], 'review_recommended' => $value['review_recommended']);
		$this->view->recipe_id = $params['recipe_id'] = isset($_POST['recipe_id']) ? $_POST['recipe_id'] : $subject->getIdentity();
		$params['paginator'] = true;

    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('reviews', 'sesrecipe')->getRecipeReviewSelect($params);
    //Set item count per page and current page number
    $paginator->setItemCountPerPage($limit);
    $paginator->setCurrentPageNumber($page);	
    if ($is_ajax)
    $this->getElement()->removeDecorator('Container');
    else {
			if(!($this->view->allowedCreate && $this->view->cancreate && $viewer->getIdentity()) &&  $paginator->getTotalItemCount() == 0 )
			return $this->setNoRender();
	  }
		
		//Add count to title if configured
    if ($paginator->getTotalItemCount() > 0)
      $this->_childCount = $paginator->getTotalItemCount();
  }
  
  public function getChildCount() {
    return $this->_childCount;
  }
}
