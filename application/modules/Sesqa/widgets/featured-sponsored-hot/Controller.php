<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesqa_Widget_FeaturedSponsoredHotController extends Engine_Content_Widget_Abstract {
  public function indexAction() {
    $this->view->params = $params = Engine_Api::_()->sesqa()->getWidgetParams($this->view->identity);
    $this->view->show_criterias = $params['show_criteria'];
    $category_id = $this->_getParam('category_id',0);
    $value['limit'] = $params['limit_data'];
    $value['criteria'] = $params['criteria'];
    $value['info'] = $params['info'];
    $value['order'] = $params['order'];
    $value['fetchAll'] = true;
    $value['category_id'] = $category_id;
    $value['locationEnable']  = $this->_getParam('locationEnable','0');
    $sesqa_widget = Zend_Registry::isRegistered('sesqa_widget') ? Zend_Registry::get('sesqa_widget') : null;
    if(empty($sesqa_widget)) {
      return $this->setNoRender();
    }
    $this->view->results = Engine_Api::_()->getDbTable('questions', 'sesqa')->getQuestions($value);
    if (count($this->view->results) <= 0)
      return $this->setNoRender();
  }
}
