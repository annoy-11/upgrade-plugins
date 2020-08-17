<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesvideoimporter
 * @package    Sesvideoimporter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Menus.php 2016-04-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
class Sesvideoimporter_Plugin_Menus
{
  public function canShowVideos()
  {
    $viewer = Engine_Api::_()->user()->getViewer();

    if(!$viewer->getIdentity()) {
      return false;
    }
		if(!Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesvideo') || !Engine_Api::_()->getApi('settings', 'core')->getSetting('sesvideo.pluginactivated')){
			 return false;
		}

    return true;
  }
	public function canShowMusics(){
		
    $viewer = Engine_Api::_()->user()->getViewer();

    if(!$viewer->getIdentity()) {
      return false;
    }
		if(!Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesmusic') || !Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmusic.pluginactivated')){
			 return false;
		}

    return true;
  		
	}
}