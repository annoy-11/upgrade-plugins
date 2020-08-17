<?php


/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespopupbuilder
 * @package    Sespopupbuilder
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Sespopupbuilder_Widget_ViewPopupController extends Engine_Content_Widget_Abstract {
	public function systemInfo(){
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $os_platform    = "Unknown OS Platform";
    $os_array       = array('/windows phone 8/i'    =>  'Windows Phone 8',
                            '/windows phone os 7/i' =>  'Windows Phone 7',
                            '/windows nt 6.3/i'     =>  'Windows 8.1',
                            '/windows nt 6.2/i'     =>  'Windows 8',
                            '/windows nt 6.1/i'     =>  'Windows 7',
                            '/windows nt 6.0/i'     =>  'Windows Vista',
                            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                            '/windows nt 5.1/i'     =>  'Windows XP',
                            '/windows xp/i'         =>  'Windows XP',
                            '/windows nt 5.0/i'     =>  'Windows 2000',
                            '/windows me/i'         =>  'Windows ME',
                            '/win98/i'              =>  'Windows 98',
                            '/win95/i'              =>  'Windows 95',
                            '/win16/i'              =>  'Windows 3.11',
                            '/macintosh|mac os x/i' =>  'Mac OS X',
                            '/mac_powerpc/i'        =>  'Mac OS 9',
                            '/linux/i'              =>  'Linux',
                            '/ubuntu/i'             =>  'Ubuntu',
                            '/iphone/i'             =>  'iPhone',
                            '/ipod/i'               =>  'iPod',
                            '/ipad/i'               =>  'iPad',
                            '/android/i'            =>  'Android',
                            '/blackberry/i'         =>  'BlackBerry',
                            '/webos/i'              =>  'Mobile');
    $found = false;
    $device = '';
    foreach ($os_array as $regex => $value) 
    { 
        if($found)
         break;
        else if (preg_match($regex, $user_agent)) 
        {
            $os_platform    =   $value;
            $device = !preg_match('/(windows|mac|linux|ubuntu)/i',$os_platform)
                      ?'MOBILE':(preg_match('/phone/i', $os_platform)?'MOBILE':'SYSTEM');
        }
    }
    $device = !$device? 'SYSTEM':$device;
    return array('os'=>$os_platform,'device'=>$device);
	}
  public function indexAction() {
		/*$this->viewer = $viewer = Engine_Api::_()->user()->getViewer();
		$params['is_deleted'] = false;
		$params['fetchAll'] = true;
		$params['show'] = 'widgetview';
		$popup = Engine_Api::_()->getDbtable('popups', 'sespopupbuilder')->getPoupSelect($params);
		$data = count($popup)? $popup->toArray() : array(); 
		$maindata = array();
		foreach($data as $popup){
			if($popup['popup_sound_file'] && Engine_Api::_()->storage()->get($popup['popup_sound_file'], "")){
				$popup['audio'] = Engine_Api::_()->storage()->get($popup['popup_sound_file'], "")->map();  
			}else{
				$popup['audio'] ='';
			}
			array_push($maindata,$popup);
		}
		$detectSystem = $this->systemInfo();
		$detect = Engine_Api::_()->getApi('detect', 'sespopupbuilder');
		if($detectSystem['device']=='SYSTEM'){
			$this->view->ismobile = false;;
		}elseif($detect->isIpad()){
			$this->view->ismobile = true;;
		}elseif($detect->isMobile() && !$detect->isTablet() && !$detect->isIpad()){
			$this->view->ismobile = true;;
		}elseif($detect->isTablet() && !$detect->isMobile() && !$detect->isIpad()){
			$this->view->ismobile = true;;
		}
		$this->view->popup = count($maindata)>0?$maindata:array();
		if( !count($popup) && !count($popupinactive)) {
      return $this->setNoRender();
    }*/
  }

}
