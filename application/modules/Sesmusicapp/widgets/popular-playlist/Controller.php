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
class Sesmusicapp_Widget_PopularPlaylistController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
		
    $coreApi = Engine_Api::_()->core();
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $authorizationApi = Engine_Api::_()->authorization();
    $this->view->width = $this->_getParam('width', 100);
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer->getIdentity();
    $this->view->showType = $this->_getParam('showType', 'gridview');
    $this->view->viewType = $this->_getParam('viewType', 'horizontal');
    $this->view->height = $this->_getParam('height', '200');

    $showOptionsType = $this->_getParam('showOptionsType', 'all');

    if ($showOptionsType == 'other') {
      $playlist = $coreApi->getSubject('sesmusic_playlist');
      if (!$playlist)
        return $this->setNoRender();
    }

    $this->view->canAddFavourite = $authorizationApi->isAllowed('sesmusic_album', $viewer, 'favourite_album');


    $this->view->albumlink = unserialize($settings->getSetting('sesmusic.albumlink'));
		
    $this->view->information = $information = $this->_getParam('information', array('featured', 'viewCount', 'title', 'postedby'));
		
    $params = array();
    if ($showOptionsType == 'recommanded') {
      $params['widgteName'] = 'Recommanded Playlist';
    } elseif ($showOptionsType == 'other') {
      $playlist_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('playlist_id');
      if ($playlist_id)
        $playlist = Engine_Api::_()->getItem('sesmusic_playlist', $playlist_id);
      $params['owner_id'] = $playlist->owner_id;
      $params['widgteName'] = 'Other Playlist';
      $params['playlist_id'] = $playlist->playlist_id;
    }
		
    $params['popularity'] = $this->_getParam('popularity', 'creation_date');
    $params['limit'] = $this->_getParam('limit', 3);
    $this->view->results = $results = Engine_Api::_()->getDbtable('playlists', 'sesmusic')->getPlaylistPaginator($params);
    if (count($this->view->results) <= 0)
      return $this->setNoRender();
  }
}