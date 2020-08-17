<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbody
 * @package    Sesbody
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageController.php  2019-02-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbody_AdminManageController extends Core_Controller_Action_Admin {

  //For write constant in xml file during upgradation
	public function constantxmlAction() {
	
    $bodyFontFamily = Engine_Api::_()->sesbody()->getContantValueXML('sesbody_body_fontfamily');
    if(empty($bodyFontFamily)) {
      Engine_Api::_()->sesbody()->readWriteXML('sesbody_body_fontfamily', 'Arial, Helvetica, sans-serif');
      Engine_Api::_()->sesbody()->readWriteXML('sesbody_body_fontsize', '13px');
    }
    $headingFontFamily = Engine_Api::_()->sesbody()->getContantValueXML('sesbody_heading_fontfamily');
    if(empty($headingFontFamily)) {
      Engine_Api::_()->sesbody()->readWriteXML('sesbody_heading_fontfamily', 'Arial, Helvetica, sans-serif');
      Engine_Api::_()->sesbody()->readWriteXML('sesbody_heading_fontsize', '17px');
    }
    $tabFontFamily = Engine_Api::_()->sesbody()->getContantValueXML('sesbody_tab_fontfamily');
    if(empty($tabFontFamily)) {
      Engine_Api::_()->sesbody()->readWriteXML('sesbody_tab_fontfamily', 'Arial, Helvetica, sans-serif');
      Engine_Api::_()->sesbody()->readWriteXML('sesbody_tab_fontsize', '15px');
    }
		$referralurl = $this->_getParam('referralurl', false);
		if($referralurl == 'install') {
			$this->_redirect('install/manage');
		} elseif($referralurl == 'query') {
			$this->_redirect('install/manage/complete');
		}
	}
}
