<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdemouser
 * @package    Sesdemouser
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2015-10-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesdemouser_Widget_DemoUsersController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    
    $settings = Engine_Api::_()->getApi('settings', 'core');
    
    $this->view->showside = $settings->getSetting('sesdemouser.showside', 'left');
    $this->view->designshow = $settings->getSetting('sesdemouser.designshow', 'gridView');
    $this->view->headingText = $settings->getSetting('sesdemouser.headingText', "Site Tour with Test Users");    
    $this->view->innerText = $settings->getSetting('sesdemouser.innerText', 'Choose a test user to login and take a site tour.');
    $limit = $settings->getSetting('sesdemouser.limit',6);
    $this->view->defaultimage = $settings->getSetting('sesdemouser.defaultimage', '');
    
    $sesdemouser_demouser = Zend_Registry::isRegistered('sesdemouser_demouser') ? Zend_Registry::get('sesdemouser_demouser') : null;
    if(empty($sesdemouser_demouser)) {
	    return $this->setNoRender();
    }

    $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
    if ($viewer_id)
      return $this->setNoRender();

    $this->view->results = Engine_Api::_()->getDbtable('demousers', 'sesdemouser')->getDemoUsers(array('widgettype' => 'widget', 'limit' => $limit));

    if (count($this->view->results) == 0)
      return $this->setNoRender();
  }

}
