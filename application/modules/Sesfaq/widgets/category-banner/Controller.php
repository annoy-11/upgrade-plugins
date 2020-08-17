<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfaq
 * @package    Sesfaq
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2017-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */



class Sesfaq_Widget_CategoryBannerController extends Engine_Content_Widget_Abstract {

  public function indexAction() { 
    
    if(!Engine_Api::_()->core()->hasSubject())
      return $this->setNoRender();
    
    $this->view->subject = $subject = Engine_Api::_()->core()->getSubject();
    $sesfaq_categories = Zend_Registry::isRegistered('sesfaq_categories') ? Zend_Registry::get('sesfaq_categories') : null;
    if(empty($sesfaq_categories)) {
      return $this->setNoRender();
    }
  }
}