<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Coursesalbum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Controller.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Coursesalbum_Widget_RecentlyViewedAlbumsController extends Engine_Content_Widget_Abstract {
  public function indexAction() {
    $this->view->allParams = $allParams = $this->_getAllParams(); 
    $userId = Engine_Api::_()->user()->getViewer()->getIdentity(); 
    $params['limit'] = $allParams['limit_data'];
    $params['criteria'] = $criteria = $allParams['criteria'];
    $params['type'] = 'coursesalbum_album';
    $params['showdefaultalbum'] = $allParams['showdefaultalbum'];
    if(($criteria == 'by_me' || $criteria == 'by_myfriend') && $userId == 0) {
        return $this->setNoRender();
    }
  	$result = Engine_Api::_()->getDbTable('recentlyviewitems', 'courses')->getitem($params);
		if(count($result) == 0)
            return $this->setNoRender();
		$this->view->results = $result;
	}
}
