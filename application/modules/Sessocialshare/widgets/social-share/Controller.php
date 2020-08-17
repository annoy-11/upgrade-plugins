<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessocialshare
 * @package    Sessocialshare
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2017-07-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sessocialshare_Widget_SocialShareController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
  
    $subject = '';
    if(Engine_Api::_()->core()->hasSubject() ) {
      $this->view->subject = $subject = Engine_Api::_()->core()->getSubject();
    }
    $this->view->shareText = $this->_getParam('shareText', "Share");
    $this->view->height = $this->_getParam('height', 64);
    $this->view->width = $this->_getParam('width', 64);
    $this->view->showCount = $this->_getParam('showCount', 1);
    $this->view->showTitle = $this->_getParam('showTitle', 1);
    $sessocialshare_widget = Zend_Registry::isRegistered('sessocialshare_widget') ? Zend_Registry::get('sessocialshare_widget') : null;
    if(empty($sessocialshare_widget)) {
      return $this->setNoRender();
    }
    $this->view->showCountnumber = $this->_getParam('showCountnumber', 100);
    $this->view->socialshare_enable_plusicon = $this->_getParam('socialshare_enable_plusicon', 1);
    $this->view->socialshare_icon_limit = $this->_getParam('socialshare_icon_limit', 4);
    $this->view->showTitleTip = $this->_getParam('showTitleTip', 1);
    
  }

}
