<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagereview
 * @package    Sespagereview
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-11-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagereview_Widget_BrowseReviewsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

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

    $show_criterias = $this->_getParam('show_criteria', array('featuredLabel', 'verifiedLabel'));
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;

    $value['search_text'] = isset($searchArray['search_text']) ? $searchArray['search_text'] : (isset($_GET['search_text']) ? $_GET['search_text'] : (isset($params['search_text']) ? $params['search_text'] : ''));
    $value['order'] = isset($searchArray['order']) ? $searchArray['order'] : (isset($_GET['order']) ? $_GET['order'] : (isset($params['order']) ? $params['order'] : ''));
    $value['review_stars'] = isset($searchArray['review_stars']) ? $searchArray['review_stars'] : (isset($_GET['review_stars']) ? $_GET['review_stars'] : (isset($params['review_stars']) ? $params['review_stars'] : ''));
    $value['review_recommended'] = isset($searchArray['review_recommended']) ? $searchArray['review_recommended'] : (isset($_GET['review_recommended']) ? $_GET['review_recommended'] : (isset($params['review_recommended']) ? $params['review_recommended'] : ''));
    $this->view->stats = isset($params['stats']) ? $params['stats'] : $this->_getParam('stats', array('featured', 'sponsored', 'likeCount', 'commentCount', 'viewCount', 'title', 'postedBy', 'pros', 'cons', 'description', 'creationDate', 'recommended', 'parameter', 'rating'));
    $this->view->width = $width = isset($params['width']) ? $params['width'] : $this->_getParam('width', '100');
    $this->view->height = $height = isset($params['height']) ? $params['height'] : $this->_getParam('height', '100');
    $this->view->socialshare_enable_plusicon = $socialshareIcon = $params['socialshare_enable_plusicon'] ? $params['socialshare_enable_plusicon'] : $this->_getParam('socialshare_enable_plusicon');
    $this->view->socialshare_icon_limit = $socialshareLimit = $params['socialshare_icon_limit'] ? $params['socialshare_icon_limit'] : $this->_getParam('socialshare_icon_limit');
    $this->view->title_truncation = $params['title_truncation'] ? $params['title_truncation'] : 15;
    $this->view->description_truncation = $params['description_truncation'] ? $params['description_truncation'] : 45;
    $this->view->params = array('stats' => $this->view->stats, 'search_text' => $value['search_text'], 'order' => $value['order'], 'review_stars' => $value['review_stars'], 'review_recommended' => $value['review_recommended'], 'width' => $width, 'height' => $height, 'socialshare_enable_plusicon' => $socialshareIcon, 'socialshare_icon_limit' => $socialshareLimit);
    $params = array('search_text' => $value['search_text'], 'info' => str_replace('SP', '_', $value['order']), 'review_stars' => $value['review_stars'], 'review_recommended' => $value['review_recommended']);

    $select = Engine_Api::_()->getItemTable('pagereview')->getPageReviewSelect($params);
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    //Set item count per page and current page number
    $paginator->setItemCountPerPage($limit);
    $paginator->setCurrentPageNumber($page);
    if ($is_ajax) {
      $this->getElement()->removeDecorator('Container');
    }
  }

}
