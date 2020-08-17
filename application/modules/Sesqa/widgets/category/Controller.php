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



class Sesqa_Widget_CategoryController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->image = $image = $this->_getParam('image', 1);
    $this->view->storage = Engine_Api::_()->storage();

    $this->view->categories = Engine_Api::_()->getDbTable('categories', 'sesqa')->getCategory();
    $sesqa_widget = Zend_Registry::isRegistered('sesqa_widget') ? Zend_Registry::get('sesqa_widget') : null;
    if(empty($sesqa_widget)) {
      return $this->setNoRender();
    }
    if(count($this->view->categories) <= 0)
      return $this->setNoRender();
  }
}
