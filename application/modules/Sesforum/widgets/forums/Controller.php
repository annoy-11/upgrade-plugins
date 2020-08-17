<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesforum_Widget_ForumsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $params = array();
    if(isset($_POST['params']))
        $params = $_POST['params'];
    $request = Zend_Controller_Front::getInstance()->getRequest();
    $requestParams = $request->getParams();
    $category_id = $requestParams['category_id'];
    if ($category_id)
      $category_id = Engine_Api::_()->getDbTable('categories', 'sesforum')->getCategoryId($category_id);

    $this->view->cat2ndShow  = $params['cat2ndShow'] = isset($params['cat2ndShow']) ? $params['cat2ndShow'] : $this->_getParam('cat2ndShow',1);
    $this->view->cat3rdShow  = $params['cat3rdShow'] = isset($params['cat3rdShow']) ? $params['cat3rdShow'] :  $this->_getParam('cat3rdShow',1);
    $this->view->forumShow  = $params['forumShow'] = isset($params['forumShow']) ? $params['forumShow'] :  $this->_getParam('forumShow',1);
    $this->view->expandAbleCat  = $params['expandAbleCat'] = isset($params['expandAbleCat']) ? $params['expandAbleCat'] : $this->_getParam('expandAbleCat',1);
    $this->view->load_content  = $params['load_content'] = isset($params['load_content']) ? $params['load_content'] : $this->_getParam('load_content',"button");
    $this->view->widgetName = 'forums';
    $this->view->description_truncation_category  = $params['description_truncation_category'] = isset($params['description_truncation_category']) ? $params['description_truncation_category'] : $this->_getParam('description_truncation_category',45);
    $this->view->description_truncation_forum  = $params['description_truncation_forum'] = isset($params['description_truncation_forum']) ? $params['description_truncation_forum'] : $this->_getParam('description_truncation_forum',45);
    $this->view->is_ajax = $is_ajax = isset($_POST['is_ajax']) ? true : false;

    $page = isset($_POST['page']) ? $_POST['page'] : 1;

    $limit_data = $params['limit_data'] = isset($params['limit_data']) ? $params['limit_data'] : $this->_getParam('limit_data',10);
    $show_criterias = $params['show_criteria']  = isset($params['show_criteria']) ? $params['show_criteria'] : $this->_getParam('show_criteria', array('topicCount', 'postCount', 'postDetails'));
    if(is_array($show_criterias)){
      foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria} = $show_criteria;
    }
    $this->view->params = $params;

    $categoryTable = Engine_Api::_()->getDbtable('categories', 'sesforum');

    if($category_id){
        $select = $categoryTable->getCategoriesAssoc(array('limit'=>$limit_data,'category_id'=>$category_id));
        $this->view->category_id = $category_id;
    } else {
        $select = $categoryTable->getCategoriesAssoc(array('limit'=>$limit_data));
    }
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    $paginator->setItemCountPerPage($limit_data);
    $paginator->setCurrentPageNumber($page);
    $this->view->page = $page;
    $sesforumTable = Engine_Api::_()->getItemTable('sesforum_forum');
    $sesforumSelect = $sesforumTable->select()
      ->order('order ASC')
      ;


    $sesforums = array();
    foreach($sesforumTable->fetchAll() as $sesforum ) {
      if(Engine_Api::_()->authorization()->isAllowed($sesforum, null, 'view') ) {
        $order = $sesforum->order;
        while( isset($sesforums[$sesforum->category_id][$order]) ) {
          $order++;
        }
        $sesforums[$sesforum->category_id][$order] = $sesforum;
        ksort($sesforums[$sesforum->category_id]);
      }
    }
    $this->view->sesforums = $sesforums;
  }
}
