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

class Seslisting_Widget_ListingCategoryController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $this->view->height = $this->_getParam('height', '150px');
    $this->view->width = $this->_getParam('width', '292px');
    $params['criteria'] = $this->_getParam('criteria', '');
		$params['limit'] = $this->_getParam('limit', 0);
		$params['listing_required'] = $this->_getParam('listing_required',0);
    $show_criterias = $this->_getParam('show_criteria', array('title', 'countListings', 'icon'));
    if (in_array('countListings', $show_criterias))
      $params['countListings'] = true;
		if($params['listing_required'])
			$params['listingRequired'] = true;
		$this->view->show_criterias = $show_criterias;
    foreach ($show_criterias as $show_criteria)
      $this->view->$show_criteria = $show_criteria;
    // Get videos
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('categories', 'seslisting')->getCategory($params);
    if (count($paginator) == 0)
      return;
  }

}
