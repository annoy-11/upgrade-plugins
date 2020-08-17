<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesalbum
 * @package    Sesdemouser
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php 2015-06-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesdemouser_Plugin_Core {

	public function onRenderLayoutDefault($event,$mode=null) {

		if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdemouser.pluginactivated')) {
			$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
			$viewer = Engine_Api::_()->user()->getViewer();
			$results = Engine_Api::_()->getDbtable('demousers', 'sesdemouser')->getDemoUsers(array('widgettype' => 'widget'));
			$userIdsArray = array();
			foreach($results as $result) {
				$userIdsArray[] = $result->user_id;
			}

			if($userIdsArray && in_array($viewer->getIdentity(), $userIdsArray) && $viewer->getIdentity()) {
				$script = 'sesJqueryObject(document).ready(function() {
					if($$(".user_settings_password")){
						sesJqueryObject(".user_settings_password").hide();
					}
					if($$(".user_settings_delete")){
						sesJqueryObject(".user_settings_delete").hide();
					}
				});';
		    $view->headScript()->appendScript($script);
	    }
    }
	}
}
