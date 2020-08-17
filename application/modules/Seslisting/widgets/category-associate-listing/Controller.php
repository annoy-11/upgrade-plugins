<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslisting
 * @package    Seslisting
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-04-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Seslisting_Widget_CategoryAssociateListingController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $params = array();
    if (isset($_POST['params']))
      $params = json_decode($_POST['params'], true);
    $this->view->loadOptionData = $loadOptionData = isset($params['loadOptionData']) ? $params['loadOptionData'] : $this->_getParam('pagging', 'auto_load');
    $this->view->category_limit = $category_limit = isset($params['category_limit']) ? $params['category_limit'] : $this->_getParam('category_limit', '10');
    $this->view->listing_description_truncation = $listing_description_truncation = isset($params['listing_description_truncation']) ? $params['listing_description_truncation'] : $this->_getParam('listing_description_truncation', '300');
    $this->view->listing_limit = $listing_limit = isset($params['listing_limit']) ? $params['listing_limit'] : $this->_getParam('listing_limit', '8');
    $this->view->count_listing = $count_listing = isset($params['count_listing']) ? $params['count_listing'] : $this->_getParam('count_listing', '1');
    $this->view->width = $width = isset($params['width']) ? $params['width'] : $this->_getParam('width', '250px');
    $this->view->height = $height = isset($params['height']) ? $params['height'] : $this->_getParam('height', '160px');
    $this->view->seemore_text = $seemore_text = isset($params['seemore_text']) ? $params['seemore_text'] : $this->_getParam('seemore_text', '+ See all [category_name]');
    $this->view->allignment_seeall = $allignment_seeall = isset($params['allignment_seeall']) ? $params['allignment_seeall'] : $this->_getParam('allignment_seeall', 'left');
    $this->view->identityForWidget = $identityForWidget = isset($_POST['identity']) ? $_POST['identity'] : '';
    $this->view->popularity_listing = $popularity_listing = isset($params['popularity_listing']) ? $params['popularity_listing'] : $this->_getParam('popularity_listing', 'like_count');
    $criteriaData = isset($params['criteria']) ? $params['criteria'] : $this->_getParam('criteria', 'alphabetical');
    $this->view->is_ajax = $is_ajax = isset($_POST['is_ajax']) ? true : false;
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->widgetName = 'category-associate-listing';
    $show_criterias = isset($params['show_criterias']) ? $params['show_criterias'] : $this->_getParam('show_criteria', array('like', 'comment', 'view', 'rating', 'ratingStar', 'by', 'title', 'featuredLabel', 'sponsoredLabel', 'favourite', 'creationDate', 'readmore'));
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;
    if ($popularity_listing == 'featured' || $popularity_listing == 'sponsored') {
      $fixedData = $popularity_listing;
      $popularCol = '';
    } else {
      $fixedData = '';
      $popularCol = $popularity_listing;
    }
    // initialize type variable type
    $this->view->params = $params = array('loadOptionData' => $loadOptionData, 'category_limit' => $category_limit, 'listing_limit' => $listing_limit,'listing_description_truncation' => $listing_description_truncation, 'count_listing' => $count_listing, 'seemore_text' => $seemore_text, 'allignment_seeall' => $allignment_seeall, 'show_criterias' => $show_criterias, 'height' => $height, 'width' => $width, 'criteria' => $criteriaData, 'popularity_listing' => $popularity_listing);
    $listingData = $countArray = array();
    $this->view->paginatorCategory = $paginatorCategory = Engine_Api::_()->getDbTable('categories', 'seslisting')->getCategory(array('hasListing' => true, 'criteria' => $criteriaData, 'listingDesc' => 'desc'), array('paginator' => 'yes'));
    $paginatorCategory->setItemCountPerPage($category_limit);
    $paginatorCategory->setCurrentPageNumber($page);
    if ($paginatorCategory->getTotalItemCount() > 0) {
      foreach ($paginatorCategory as $key => $valuePaginator) {
        $countArray[] = $valuePaginator->total_listings_categories;
        $listingData['listing_data'][$valuePaginator->category_id] = Engine_Api::_()->getDbTable('seslistings', 'seslisting')->getSeslistingsPaginator(array('category_id' => $valuePaginator->category_id, 'status' => 1, 'limit' => $listing_limit, 'popularCol' => $popularCol, 'fixedData' => $fixedData, 'fetchAll' => 0), false);
      }
    } else {
      if (!$is_ajax)
        return $this->setNoRender();
    }
    $this->view->countArray = $countArray;
    $this->view->resultArray = $listingData;
    // Set item count per page and current page number
    $this->view->page = $page;
    $this->view->paginatorCategory = $paginatorCategory;
    if ($is_ajax) {
      $this->getElement()->removeDecorator('Container');
    }
  }

}
