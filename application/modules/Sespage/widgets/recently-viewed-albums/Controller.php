<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
class Sespage_Widget_RecentlyViewedAlbumsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
  
		$this->view->allParams = $allParams = $this->_getAllParams();
		$userId = Engine_Api::_()->user()->getViewer()->getIdentity();
		$params['limit'] = $allParams['limit_data'];
		$params['criteria'] = $criteria = $allParams['criteria'];
		$params['type'] = 'sespage_album';
		$params['showdefaultalbum'] = $allParams['showdefaultalbum'];
		if(($criteria == 'by_me' || $criteria == 'by_myfriend') && $userId == 0) {
      return $this->setNoRender();
		}
  	$result = Engine_Api::_()->getDbTable('recentlyviewitems', 'sespage')->getitem($params);
		if(count($result) == 0)
				return $this->setNoRender();
		$this->view->results = $result->toArray();
	}
}