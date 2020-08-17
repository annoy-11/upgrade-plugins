<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmusicapp
 * @package    Sesmusicapp
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-12-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesmusicapp_Widget_PopularArtistsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->viewType = $this->_getParam('viewType', 'gridview');
    $this->view->height = $this->_getParam('height', 200);
    $this->view->width = $this->_getParam('width', 100);
    $this->view->viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
		$this->view->information = $this->_getParam('information', array('favouritecount', 'rating'));

    $params = array();
    $params['popularity'] = $this->_getParam('popularity', 'favourite_count');
    $params['limit'] = $this->_getParam('limit', 3);

    $this->view->results = Engine_Api::_()->getDbtable('artists', 'sesmusic')->getArtistsPaginator($params);
    if (count($this->view->results) <= 0)
      return $this->setNoRender();
  }

}