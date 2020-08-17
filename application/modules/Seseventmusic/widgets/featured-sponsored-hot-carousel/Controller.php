<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventmusic
 * @package    Seseventmusic
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2015-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Seseventmusic_Widget_FeaturedSponsoredHotCarouselController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $authorizationApi = Engine_Api::_()->authorization();
    $this->view->contentType = $contentType = $this->_getParam('contentType', 'albums');
    $this->view->viewType = $this->_getParam('viewType', 'horizontal');
    $this->view->height = $this->_getParam('height', '200');
    $this->view->width = $this->_getParam('width', '180');
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer->getIdentity();
    $settings = Engine_Api::_()->getApi('settings', 'core');

    //Album Settings
    $this->view->albumlink = unserialize($settings->getSetting('seseventmusic.albumlink'));

    //Songs Settings
    $this->view->songlink = unserialize($settings->getSetting('seseventmusic.songlink'));

    $this->view->canAddFavourite = $authorizationApi->isAllowed('seseventmusic_album', $viewer, 'addfavourite_album');

    $this->view->addfavouriteAlbumSong = $authorizationApi->isAllowed('seseventmusic_album', $viewer, 'addfavourite_albumsong');

    //Album Rating Work
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

    //Song Rating Work
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


    $params = array();
    $params['popularity'] = $this->_getParam('popularity', 'creation_date');
    $params['displayContentType'] = $this->_getParam('displayContentType', 'featured');
    $params['limit'] = $this->_getParam('limit', 3);

    if (!$settings->getSetting('seseventmusic.checkmusic'))
      return $this->setNoRender();

    $this->view->information = $this->_getParam('information', array('featured', 'sponsored', 'hot', 'likeCount', 'commentCount', 'viewCount', 'songsCount', 'title', 'postedby', 'ratingCount'));

    if ($contentType == 'albums') {

      $params['column'] = array('album_id', 'title', 'description', 'photo_id', 'owner_id', 'view_count', 'like_count', 'comment_count', 'song_count', 'featured', 'hot', 'sponsored', 'rating', 'special');

      $this->view->results = $results = Engine_Api::_()->getDbtable('albums', 'seseventmusic')->widgetResults($params);
    } elseif ($contentType == 'songs') {

      $params['column'] = array('album_id', "albumsong_id", 'title', 'description', 'photo_id', 'view_count', 'like_count', 'comment_count', 'download_count', 'featured', 'hot', 'sponsored', 'rating', 'track_id', 'song_url', 'file_id', 'play_count');

      $this->view->results = $results = Engine_Api::_()->getDbtable('albumsongs', 'seseventmusic')->widgetResults($params);
    }

    if (count($results) <= 0)
      return $this->setNoRender();
  }

}