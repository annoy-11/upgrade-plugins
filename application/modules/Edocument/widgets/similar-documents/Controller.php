<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Edocument
 * @package    Edocument
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Edocument_Widget_SimilarDocumentsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    if (isset($_POST['params']))
      $params = json_decode($_POST['params'], true);

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $this->view->widgetIdentity = $this->_getParam('content_id', $view->identity);
    $this->view->is_ajax = $is_ajax = $this->_getParam('is_ajax', 0);

    if (!$is_ajax) {
      if (!Engine_Api::_()->core()->hasSubject())
        return $this->setNoRender();
      $subject = Engine_Api::_()->core()->getSubject();
      $category_id = $subject->category_id;
      if(!$category_id)
        return $this->setNoRender();
    } else if($is_ajax){
      $subject = Engine_Api::_()->getItem('edocument', $params['edocument_id']);
      $category_id = $params['category_id'];
      if(!$category_id)
        return $this->setNoRender();
    }

    if ($this->_getParam('showLimitData', 1))
      $this->view->widgetName = 'similar-documents';

    $this->view->socialshare_enable_plusicon = $socialshare_enable_plusicon =isset($params['socialshare_enable_plusicon']) ? $params['socialshare_enable_plusicon'] : $this->_getParam('socialshare_enable_plusicon', 1);

    $this->view->socialshare_icon_limit = $socialshare_icon_limit =isset($params['socialshare_icon_limit']) ? $params['socialshare_icon_limit'] : $this->_getParam('socialshare_icon_limit', 2);

    $this->view->height = isset($params['height']) ? $params['height'] : $this->_getParam('height', '264');
    $this->view->width = isset($params['width']) ? $params['width'] : $this->_getParam('width', '262');

    $this->view->title_truncation_list = isset($params['list_title_truncation']) ? $params['list_title_truncation'] : $this->_getParam('list_title_truncation', '45');

    $show_criterias = isset($params['show_criterias']) ? $params['show_criterias'] : $this->_getParam('show_criteria', array('like', 'comment', 'title', 'socialSharing', 'view', 'featuredLabel', 'sponsoredLabel', 'verifiedLabel', 'rating', 'by', 'favourite','category','favouriteButton','likeButton'));
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;

    $limit = isset($params['limit_data']) ? $params['limit_data'] : $this->_getParam('limit_data', 3);

    $this->view->params = array('show_criterias' => $show_criterias, 'limit_data' => $limit, 'category_id' => $category_id, 'list_title_truncation' => $this->view->title_truncation_list, 'height' => $this->view->height, 'width' => $this->view->width, 'socialshare_enable_plusicon' => $socialshare_enable_plusicon, 'socialshare_icon_limit' => $socialshare_icon_limit);

    $value['category_id'] = $category_id;
    $value['widgetName'] = 'Similar Documents';
    $this->view->page = $page = isset($_POST['page']) ? $_POST['page'] : 1;

    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('edocuments', 'edocument')->getEdocumentsPaginator($value);
    $paginator->setItemCountPerPage($limit);
    $paginator->setCurrentPageNumber($page);

    if ($paginator->getTotalItemCount() <= 0)
      return $this->setNoRender();
    if ($is_ajax)
      $this->getElement()->removeDecorator('Container');
  }
}
