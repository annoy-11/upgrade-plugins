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

class Seslisting_Widget_ListingCategoryIconsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->height = $this->_getParam('height', '200');
    $this->view->width = $this->_getParam('width', '200');
    $this->view->alignContent = $this->_getParam('alignContent', 'center');
    $this->view->titleC = $this->_getParam('titleC','What are you in the mood for?');
    $params['criteria'] = $this->_getParam('criteria', '');
    $show_criterias = $this->_getParam('show_criteria', array('title', 'countListings', 'icon'));
    $seslisting_categorylisting = Zend_Registry::isRegistered('seslisting_categorylisting') ? Zend_Registry::get('seslisting_categorylisting') : null;
    if(0) {
      return $this->setNoRender();
    }
    if (in_array('countListings', $show_criterias) || $params['criteria'] == 'most_listing')
      $params['countListings'] = true;

    foreach ($show_criterias as $show_criteria)
      $this->view->$show_criteria = $show_criteria;
		$params['limit'] = $this->_getParam('limit_data',10);
    // Get listings category
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('categories', 'seslisting')->getCategory($params);

    if (count($paginator) == 0)
      return;
  }

}
