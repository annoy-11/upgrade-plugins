<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesnews
 * @package    Sesnews
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-02-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesnews_Widget_NewsCategoryIconsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->height = $this->_getParam('height', '200');
    $this->view->width = $this->_getParam('width', '200');
    $this->view->alignContent = $this->_getParam('alignContent', 'center');
    $this->view->titleC = $this->_getParam('titleC','What are you in the mood for?');
    $params['criteria'] = $this->_getParam('criteria', '');
    $show_criterias = $this->_getParam('show_criteria', array('title', 'countNews', 'icon'));
    $sesnews_categorynews = Zend_Registry::isRegistered('sesnews_categorynews') ? Zend_Registry::get('sesnews_categorynews') : null;
    if(0) {
      return $this->setNoRender();
    }
    if (in_array('countNews', $show_criterias) || $params['criteria'] == 'most_news')
      $params['countNews'] = true;

    foreach ($show_criterias as $show_criteria)
      $this->view->$show_criteria = $show_criteria;
		$params['limit'] = $this->_getParam('limit_data',10);
    // Get news category
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('categories', 'sesnews')->getCategory($params);

    if (count($paginator) == 0)
      return;
  }

}
