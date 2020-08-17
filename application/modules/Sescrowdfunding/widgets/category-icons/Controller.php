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


class Sescrowdfunding_Widget_CategoryIconsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    if (Engine_Api::_()->core()->hasSubject()) {
      $category = Engine_Api::_()->core()->getSubject();
      $category_id = $category->category_id;
      $subcat_id = $category->subcat_id;
    }

    $this->view->height = $this->_getParam('height', '200');
    $this->view->width = $this->_getParam('width', '200');
    $this->view->alignContent = $this->_getParam('alignContent', 'center');
    $this->view->titleC = $this->_getParam('titleC','What are you in the mood for?');
    $params['criteria'] = $this->_getParam('criteria', '');
    $show_criterias = $this->_getParam('show_criteria', array('title', 'countCrowdfundings', 'icon'));

    if (in_array('countCrowdfundings', $show_criterias) || $params['criteria'] == 'most_crowdfunding')
      $params['countCrowdfundings'] = true;

    foreach ($show_criterias as $show_criteria)
      $this->view->$show_criteria = $show_criteria;
		$params['limit'] = $this->_getParam('limit_data',10);
		if(@$category_id) {
      $params['category_id'] = @$category_id;
      $params['subcat_id'] = $subcat_id;
      $params['widgetname'] = 'category-view';
    }

    // Get crowdfundings category
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('categories', 'sescrowdfunding')->getCategory($params);

    if (count($paginator) == 0)
      return;
  }
}
