<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessreview
 * @package    Sesbusinessreview
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-11-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbusinessreview_Widget_BusinessReviewsController extends Engine_Content_Widget_Abstract {

  protected $_childCount;

  public function indexAction() {
    $viewer = Engine_Api::_()->user()->getViewer();
    if (isset($_POST['params']))
      $params = json_decode($_POST['params'], true);
    if (isset($_POST['searchParams']) && $_POST['searchParams'])
      parse_str($_POST['searchParams'], $searchArray);

    $this->view->is_ajax = $is_ajax = isset($_POST['is_ajax']) ? true : false;
    $this->view->business = $business = isset($_POST['business']) ? $_POST['business'] : 1;
    $this->view->limit = $limit = isset($_POST['limit']) ? $_POST['limit'] : $this->_getParam('limit_data', 10);
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $identity = $view->identity;
    $this->view->widgetId = $widgetId = isset($_POST['widgetId']) ? $_POST['widgetId'] : $identity;
    $this->view->loadOptionData = $loadOptionData = isset($_POST['loadOptionData']) ? $_POST['loadOptionData'] : $this->_getParam('pagging', 'auto_load');

    if (!$is_ajax) {
      $this->view->subject = $subject = Engine_Api::_()->core()->getSubject();
      if (!Engine_Api::_()->getApi('core', 'sesbusinessreview')->allowReviewRating())
        return $this->setNoRender();
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinessreview.allow.owner', 1)) {
        $allowedCreate = true;
      } else {
        if ($subject->owner_id == $viewer->getIdentity())
          $allowedCreate = false;
        else
          $allowedCreate = true;
      }
      $this->view->allowedCreate = $allowedCreate;
      $reviewTable = Engine_Api::_()->getDbtable('businessreviews', 'sesbusinessreview');
      if (!$viewer->getIdentity())
        $this->view->level_id = 5;
      else
        $this->view->level_id = $viewer;
      if (!Engine_Api::_()->sesbasic()->getViewerPrivacy('businessreview', 'view'))
        return $this->setNoRender();
      $this->view->isReview = $hasReview = $reviewTable->isReview(array('business_id' => $subject->getIdentity(), 'column_name' => 'review_id'));
      $this->view->cancreate = Engine_Api::_()->sesbasic()->getViewerPrivacy('businessreview', 'create');
      if ($hasReview && Engine_Api::_()->sesbasic()->getViewerPrivacy('businessreview', 'edit')) {
        $select = $reviewTable->select()
                ->where('business_id = ?', $subject->getIdentity())
                ->where('owner_id =?', $viewer->getIdentity());
        $reviewObject = $reviewTable->fetchRow($select);
        $this->view->form = $form = new Sesbusinessreview_Form_Review_Create(array('businessId' => $reviewObject->business_id, 'reviewId' => $reviewObject->review_id));
        $form->populate($reviewObject->toArray());
        $form->rate_value->setvalue($reviewObject->rating);
        $form->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sesbusinessreview', 'controller' => 'review', 'action' => 'edit', 'review_id' => $reviewObject->review_id), 'default', true));
      } else {
        $this->view->form = $form = new Sesbusinessreview_Form_Review_Create(array('businessId' => $subject->business_id));
      }
    }
    $value['search_text'] = isset($searchArray['search_text']) ? $searchArray['search_text'] : (isset($_GET['search_text']) ? $_GET['search_text'] : (isset($params['search_text']) ? $params['search_text'] : ''));
    $value['order'] = isset($searchArray['order']) ? $searchArray['order'] : (isset($_GET['order']) ? $_GET['order'] : (isset($params['order']) ? $params['order'] : ''));
    $value['review_stars'] = isset($searchArray['review_stars']) ? $searchArray['review_stars'] : (isset($_GET['review_stars']) ? $_GET['review_stars'] : (isset($params['review_stars']) ? $params['review_stars'] : ''));
    $value['review_recommended'] = isset($searchArray['review_recommended']) ? $searchArray['review_recommended'] : (isset($_GET['review_recommended']) ? $_GET['review_recommended'] : (isset($params['review_recommended']) ? $params['review_recommended'] : ''));
    $this->view->stats = isset($params['stats']) ? $params['stats'] : $this->_getParam('stats', array('featured', 'sponsored', 'likeCount', 'commentCount', 'viewCount', 'title', 'postedBy', 'pros', 'cons', 'description', 'creationDate', 'recommended', 'parameter', 'rating'));
    $this->view->socialshare_enable_plusicon = $socialshareIcon = $params['socialshare_enable_plusicon'] ? $params['socialshare_enable_plusicon'] : $this->_getParam('socialshare_enable_plusicon');
    $this->view->socialshare_icon_limit = $socialshareLimit = $params['socialshare_icon_limit'] ? $params['socialshare_icon_limit'] : $this->_getParam('socialshare_icon_limit');
    $this->view->params = array('stats' => $this->view->stats, 'search_text' => $value['search_text'], 'order' => $value['order'], 'review_stars' => $value['review_stars'], 'review_recommended' => $value['review_recommended'],'socialshare_enable_plusicon' => $socialshareIcon, 'socialshare_icon_limit'=>$socialshareLimit);
    $table = Engine_Api::_()->getItemTable('businessreview');
    $params = array('search_text' => $value['search_text'], 'info' => str_replace('SP', '_', $value['order']), 'review_stars' => $value['review_stars'], 'review_recommended' => $value['review_recommended']);

    $this->view->business_id = $params['business_id'] = isset($_POST['business_id']) ? $_POST['business_id'] : $subject->getIdentity();
    $select = $table->getBusinessReviewSelect($params);
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    //Set item count per business and current business number
    $paginator->setItemCountPerPage($limit);
    $paginator->setCurrentPageNumber($business);
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
