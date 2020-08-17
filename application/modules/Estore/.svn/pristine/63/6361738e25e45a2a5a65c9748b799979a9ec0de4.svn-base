<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Estore_Widget_StoreReviewsController extends Engine_Content_Widget_Abstract {

  protected $_childCount;

  public function indexAction() {
    $viewer = Engine_Api::_()->user()->getViewer();
    if (isset($_POST['params']))
      $params = json_decode($_POST['params'], true);
    if (isset($_POST['searchParams']) && $_POST['searchParams'])
      parse_str($_POST['searchParams'], $searchArray);

    $this->view->is_ajax = $is_ajax = isset($_POST['is_ajax']) ? true : false;
    $this->view->page = $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->limit = $limit = isset($_POST['limit']) ? $_POST['limit'] : $this->_getParam('limit_data', 10);
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $identity = $view->identity;
    $this->view->widgetId = $widgetId = isset($_POST['widgetId']) ? $_POST['widgetId'] : $identity;

    $this->view->loadOptionData = $loadOptionData = isset($_POST['loadOptionData']) ? $_POST['loadOptionData'] : $this->_getParam('pagging', 'auto_load');

    if (!$is_ajax) {
      $this->view->subject = $subject = Engine_Api::_()->core()->getSubject();

      if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.allow.review', 1))
        return $this->setNoRender();
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.allow.owner', 1)) {
        $allowedCreate = true;
      } else {
        if ($subject->store_id == $viewer->getIdentity())
          $allowedCreate = false;
        else
          $allowedCreate = true;
      }
      $this->view->allowedCreate = $allowedCreate;
      $reviewTable = Engine_Api::_()->getDbtable('reviews', 'estore');
      if (!$viewer->getIdentity())
        $this->view->level_id = 5;
      else
        $this->view->level_id = $viewer;

      if (!Engine_Api::_()->sesbasic()->getViewerPrivacy('estore_review', 'view'))
        return $this->setNoRender();
      $this->view->isReview = $hasReview = $reviewTable->isReview(array('store_id' => $subject->getIdentity(), 'column_name' => 'review_id'));
      $this->view->cancreate = Engine_Api::_()->sesbasic()->getViewerPrivacy('estore_review', 'create');

      if ($hasReview && Engine_Api::_()->sesbasic()->getViewerPrivacy('estore_review', 'edit')) {
        $select = $reviewTable->select()
                ->where('store_id = ?', $subject->getIdentity())
                ->where('owner_id =?', $viewer->getIdentity());
        $reviewObject = $reviewTable->fetchRow($select);
        $this->view->form = $form = new Estore_Form_Review_Create(array( 'reviewId' => $reviewObject->review_id, 'storeItem' =>$subject));
        $form->populate($reviewObject->toArray());
        $form->rate_value->setvalue($reviewObject->rating);
        $form->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'estore', 'controller' => 'review', 'action' => 'edit', 'review_id' => $reviewObject->review_id), 'default', true));
    } else {
        $this->view->form = $form = new Estore_Form_Review_Create(array('storeItem' =>$subject));
      }
    }
    $value['search_text'] = isset($searchArray['search_text']) ? $searchArray['search_text'] : (isset($_GET['search_text']) ? $_GET['search_text'] : (isset($params['search_text']) ? $params['search_text'] : ''));
    $value['order'] = isset($searchArray['order']) ? $searchArray['order'] : (isset($_GET['order']) ? $_GET['order'] : (isset($params['order']) ? $params['order'] : ''));
    $value['review_stars'] = isset($searchArray['review_stars']) ? $searchArray['review_stars'] : (isset($_GET['review_stars']) ? $_GET['review_stars'] : (isset($params['review_stars']) ? $params['review_stars'] : ''));
    $value['review_recommended'] = isset($searchArray['review_recommended']) ? $searchArray['review_recommended'] : (isset($_GET['review_recommended']) ? $_GET['review_recommended'] : (isset($params['review_recommended']) ? $params['review_recommended'] : ''));

    $this->view->stats = isset($params['stats']) ? $params['stats'] : $this->_getParam('stats', array('featured', 'sponsored', 'likeCount', 'commentCount', 'viewCount', 'title', 'postedBy', 'pros', 'cons', 'description', 'creationDate', 'recommended', 'parameter', 'rating'));

    $this->view->params = array('stats' => $this->view->stats, 'search_text' => $value['search_text'], 'order' => $value['order'], 'review_stars' => $value['review_stars'], 'review_recommended' => $value['review_recommended']);

    $table = Engine_Api::_()->getItemTable('estore_review');
    $params = array('search_text' => $value['search_text'], 'info' => str_replace('SP', '_', $value['order']), 'review_stars' => $value['review_stars'], 'review_recommended' => $value['review_recommended']);


    $this->view->store_id = $params['store_id'] = isset($_POST['store_id']) ? $_POST['store_id'] : $subject->getIdentity();
    $select = $table->getStoreReviewSelect($params);
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    //Set item count per page and current page number
    $paginator->setItemCountPerPage($limit);
    $paginator->setCurrentPageNumber($page);
    if ($is_ajax) {
      $this->getElement()->removeDecorator('Container');
    }
    if ($paginator->getTotalItemCount() > 0) {
      $this->_childCount = $paginator->getTotalItemCount();
    }
  }

  public function getChildCount() {
    return $this->_childCount;
  }

}
