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
class Seslisting_Widget_CategoryCarouselController extends Engine_Content_Widget_Abstract {
  public function indexAction() {

    $this->view->socialshare_enable_plusicon = $this->_getParam('socialshare_enable_plusicon', 1);
    $this->view->socialshare_icon_limit = $this->_getParam('socialshare_icon_limit', 2);

    $this->view->height = $this->_getParam('height', '310');
    $this->view->width = $this->_getParam('width', '400');
    $this->view->speed = $this->_getParam('speed', '300');
    $this->view->autoplay = $this->_getParam('autoplay', '1');
    $this->view->isfullwidth = $this->_getParam('isfullwidth', '1');
    $this->view->description_truncation_grid = $this->_getParam('description_truncation_grid', '100');
    $this->view->title_truncation_grid = $this->_getParam('title_truncation_grid', '45');
    $show_criterias = isset($values['show_criterias']) ? $values['show_criterias'] : $this->_getParam('show_criteria', array( 'title', 'countListings', 'icon','socialshare'));

    foreach ($show_criterias as $show_criteria)
    $this->view->{$show_criteria . 'Active'} = $show_criteria;
    $this->view->criteria =$params['criteria'] = $this->_getParam("criteria",array('alphabetical','most_listing','admin_order'));
    $limit = $this->_getParam('limit_data', 15);
    if($limit)
    $params['limit'] = $limit;
		if (in_array('countListings', $show_criterias))
		$params['countListings'] = true;
    $this->view->paginator = Engine_Api::_()->getDbTable('categories', 'seslisting')->getCategory($params);
    if (count($this->view->paginator) == 0)
    return $this->setNoRender();
  }
}
