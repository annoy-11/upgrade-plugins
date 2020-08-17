<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslandingpage
 * @package    Seslandingpage
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-02-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslandingpage_Widget_Design1Widget2Controller extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    
    $this->getElement()->removeDecorator('Title');
    $this->view->title = $this->_getParam('title', '');
    $this->view->description = $this->_getParam('description', null);
    $this->view->backgroundimage = $this->_getParam('backgroundimage', '');
    $seslandingpage_widget = Zend_Registry::isRegistered('seslandingpage_widget') ? Zend_Registry::get('seslandingpage_widget') : null;
    if(empty($seslandingpage_widget))
      return $this->setNoRender();
    $this->view->featureblock_id = $this->_getParam('featureblock_id', null);
    $this->view->featureblock = Engine_Api::_()->getItem('seslandingpage_featureblock', $this->view->featureblock_id);
	}
}
