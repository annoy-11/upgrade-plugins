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

class Sescrowdfunding_Widget_CategoryAssociateCrowdfundingController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $params = array();
    if (isset($_POST['params']))
      $params = json_decode($_POST['params'], true);

    $this->view->loadOptionData = $loadOptionData = isset($params['loadOptionData']) ? $params['loadOptionData'] : $this->_getParam('pagging', 'autoload');

    $this->view->category_limit = $category_limit = isset($params['category_limit']) ? $params['category_limit'] : $this->_getParam('category_limit', '10');

    $this->view->crowdfunding_description_truncation = $crowdfunding_description_truncation = isset($params['crowdfunding_description_truncation']) ? $params['crowdfunding_description_truncation'] : $this->_getParam('crowdfunding_description_truncation', '300');

    $this->view->crowdfunding_limit = $crowdfunding_limit = isset($params['crowdfunding_limit']) ? $params['crowdfunding_limit'] : $this->_getParam('crowdfunding_limit', '8');

    $this->view->count_crowdfunding = $count_crowdfunding = isset($params['count_crowdfunding']) ? $params['count_crowdfunding'] : $this->_getParam('count_crowdfunding', '1');

    $this->view->width = $width = isset($params['width']) ? $params['width'] : $this->_getParam('width', '250px');

    $this->view->height = $height = isset($params['height']) ? $params['height'] : $this->_getParam('height', '160px');

    $this->view->seemore_text = $seemore_text = isset($params['seemore_text']) ? $params['seemore_text'] : $this->_getParam('seemore_text', '+ See all [category_name]');

    $this->view->allignment_seeall = $allignment_seeall = isset($params['allignment_seeall']) ? $params['allignment_seeall'] : $this->_getParam('allignment_seeall', 'left');

    $this->view->identityForWidget = $identityForWidget = isset($_POST['identity']) ? $_POST['identity'] : '';
    $this->view->popularity_crowdfunding = $popularity_crowdfunding = isset($params['popularity_crowdfunding']) ? $params['popularity_crowdfunding'] : $this->_getParam('popularity_crowdfunding', 'like_count');
    $criteriaData = isset($params['criteria']) ? $params['criteria'] : $this->_getParam('criteria', 'alphabetical');

    $this->view->is_ajax = $is_ajax = isset($_POST['is_ajax']) ? true : false;
    $page = isset($_POST['page']) ? $_POST['page'] : 1;

    $this->view->widgetName = 'category-associate-crowdfunding';

    $show_criterias = isset($params['show_criterias']) ? $params['show_criterias'] : $this->_getParam('show_criteria', array('like', 'comment', 'view', 'rating', 'ratingStar', 'by', 'title', 'featuredLabel', 'sponsoredLabel', 'favourite', 'creationDate', 'readmore'));

    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;

    if ($popularity_crowdfunding == 'featured' || $popularity_crowdfunding == 'sponsored') {
      $fixedData = $popularity_crowdfunding;
      $popularCol = $popularity_crowdfunding;
    } else {
        $fixedData = '';
        switch ($popularity_crowdfunding) {
            case 'viewcount':
                $popularity_crowdfunding = 'view_count';
                break;
            case 'likecount':
                $popularity_crowdfunding = 'like_count';
                break;
            case 'commentcount':
                $popularity_crowdfunding = 'comment_count';
                break;
            case 'rating':
                $popularity_crowdfunding = 'rating';
                break;
            case 'creationdate':
                default:
                $popularity_crowdfunding = 'creation_date';
                break;
        }
        $popularCol = $popularity_crowdfunding;
    }

    $this->view->params = $params = array('loadOptionData' => $loadOptionData, 'category_limit' => $category_limit, 'crowdfunding_limit' => $crowdfunding_limit,'crowdfunding_description_truncation' => $crowdfunding_description_truncation, 'count_crowdfunding' => $count_crowdfunding, 'seemore_text' => $seemore_text, 'allignment_seeall' => $allignment_seeall, 'show_criterias' => $show_criterias, 'height' => $height, 'width' => $width, 'criteria' => $criteriaData, 'popularity_crowdfunding' => $popularity_crowdfunding);
    $crowdfundingData = $countArray = array();

    $this->view->paginatorCategory = $paginatorCategory = Engine_Api::_()->getDbTable('categories', 'sescrowdfunding')->getCategory(array('hasCrowdfunding' => true, 'criteria' => $criteriaData, 'crowdfundingDesc' => 'desc', 'paginator' => 'yes'));

    $paginatorCategory->setItemCountPerPage($category_limit);
    $paginatorCategory->setCurrentPageNumber($page);

    if ($paginatorCategory->getTotalItemCount() > 0) {
      foreach ($paginatorCategory as $key => $valuePaginator) {
        $countArray[] = $valuePaginator->total_crowdfundings_categories;
        $crowdfundingData['crowdfunding_data'][$valuePaginator->category_id] = Engine_Api::_()->getDbTable('crowdfundings', 'sescrowdfunding')->getSescrowdfundingsPaginator(array('category_id' => $valuePaginator->category_id, 'status' => 1, 'limit_data' => $crowdfunding_limit, 'popularCol' => $popularCol, 'fixedData' => $fixedData), false);
      }
    } else {
      if (!$is_ajax)
        return $this->setNoRender();
    }

    $this->view->countArray = $countArray;
    $this->view->resultArray = $crowdfundingData;

    $this->view->page = $page;
    $this->view->paginatorCategory = $paginatorCategory;
    if ($is_ajax) {
      $this->getElement()->removeDecorator('Container');
    }
  }
}
