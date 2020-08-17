<?php

class Seseventmusic_Widget_RecentlyViewedItemController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $authorizationApi = Engine_Api::_()->authorization();
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer->getIdentity();
    $this->view->content_type = $type = $this->_getParam('category', 'seseventmusic_album');
    $this->view->viewType = $this->_getParam('viewType', 'listView');
    $userId = Engine_Api::_()->user()->getViewer()->getIdentity();
    if (($type == 'by_me' || $type == 'by_myfriend') && $userId == 0) {
      return $this->setNoRender();
    }

    $limit = $this->_getParam('limit_data', 10);
    $this->view->type = $criteria = $this->_getParam('criteria', 'by_me');
    $this->view->height = $defaultHeight = isset($params['height']) ? $params['height'] : $this->_getParam('height', '180');
    $this->view->width = $defaultWidth = isset($params['width']) ? $params['width'] : $this->_getParam('width', '180');
    $this->view->title_truncation = $title_truncation = isset($params['title_truncation']) ? $params['title_truncation'] : $this->_getParam('title_truncation', '45');
    $this->view->information = $this->_getParam('information', array('likeCount', 'commentCount', 'ratingCount', 'postedby', 'viewCount'));

    $this->view->canAddFavourite = $authorizationApi->isAllowed('seseventmusic_album', $viewer, 'addfavourite_album');

    if (!$settings->getSetting('seseventmusic.checkmusic'))
      return $this->setNoRender();

    $this->view->albumlink = unserialize($settings->getSetting('seseventmusic.albumlink'));

    $allowShowRating = $settings->getSetting('seseventmusic.ratealbum.show', 1);
    $allowRating = $settings->getSetting('seseventmusic.album.rating', 1);
    if ($allowRating == 0) {
      if ($allowShowRating == 0)
        $showRating = false;
      else
        $showRating = true;
    }
    else
      $showRating = true;
    $this->view->showRating = $showRating;


    //Songs Settings
    //Songs settings.
    $this->view->songlink = unserialize($settings->getSetting('seseventmusic.songlink'));

    $this->view->information = $this->_getParam('information', array('featuredLabel', 'sponsoredLabel', 'newLabel', 'likeCount', 'commentCount', "downloadCount", 'viewCount', 'title', 'postedby'));

    if (!$settings->getSetting('seseventmusic.checkmusic'))
      return $this->setNoRender();

    $this->view->addfavouriteAlbumSong = $authorizationApi->isAllowed('seseventmusic_album', $viewer, 'addfavourite_albumsong');

    $allowShowRating = $settings->getSetting('seseventmusic.ratealbumsong.show', 1);
    $allowRating = $settings->getSetting('seseventmusic.albumsong.rating', 1);
    if ($allowRating == 0) {
      if ($allowShowRating == 0)
        $showRating = false;
      else
        $showRating = true;
    }
    else
      $showRating = true;
    $this->view->showAlbumSongRating = $showRating;


    if ($type == 'seseventmusic_album') {
      $params = array('type' => 'seseventmusic_album', 'limit' => $limit, 'criteria' => $criteria);
    } else if ($type == 'seseventmusic_albumsong') {
      $params = array('type' => 'seseventmusic_albumsong', 'limit' => $limit, 'criteria' => $criteria);
    }
    else
      return $this->setNoRender();

    $result = Engine_Api::_()->getDbtable('recentlyviewitems', 'seseventmusic')->getitem($params);
    if (count($result) == 0)
      return $this->setNoRender();

    $this->view->results = $result->toArray();
    $this->view->typeWidget = $type;
  }

}
