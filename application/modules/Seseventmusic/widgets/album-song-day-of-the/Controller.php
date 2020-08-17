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
class Seseventmusic_Widget_AlbumSongDayOfTheController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->contentType = $contentType = $this->_getParam('contentType', 'album');
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer->getIdentity();

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $authorizationApi = Engine_Api::_()->authorization();
    $favouriteTable = Engine_Api::_()->getDbTable('favourites', 'seseventmusic');

    if (!$settings->getSetting('seseventmusic.checkmusic'))
      return $this->setNoRender();

    if ($contentType == 'album') {

      $item = Engine_Api::_()->getDbtable('albums', 'seseventmusic')->getOfTheDayResults();

      //Get all settings
      $this->view->information = $this->_getParam('information', array('featured', 'sponsored', 'hot', 'likeCount', 'commentCount', 'viewCount', 'ratingCount', 'songsCount', 'title', 'postedby'));

      $this->view->canAddFavourite = $authorizationApi->isAllowed('seseventmusic_album', $viewer, 'addfavourite_album');

      if ($item && $item->album_id)
        $this->view->isFavourite = $favouriteTable->isFavourite(array('resource_type' => "seseventmusic_album", 'resource_id' => $item->album_id));

      $this->view->albumlink = unserialize($settings->getSetting('seseventmusic.albumlink'));

      $this->view->allowShowRating = $allowShowRating = $settings->getSetting('seseventmusic.ratealbum.show', 1);
      $this->view->allowRating = $allowRating = $settings->getSetting('seseventmusic.album.rating', 1);
      if ($allowRating == 0) {
        if ($allowShowRating == 0)
          $showRating = false;
        else
          $showRating = true;
      }
      else
        $showRating = true;
      $this->view->showRating = $showRating;

      $this->view->album = $item; //Engine_Api::_()->getItem('seseventmusic_album', $item->album_id);
      if (empty($this->view->album))
        return $this->setNoRender();
    } elseif ($contentType == 'albumsong') {

      $item = Engine_Api::_()->getDbtable('albumsongs', 'seseventmusic')->getOfTheDayResults();
      //Get all settings
      $this->view->information = $this->_getParam('information', array('featured', 'sponsored', 'hot', 'likeCount', 'commentCount', 'viewCount', 'ratingCount', 'title', 'postedby'));

      //Songs settings.
      $this->view->songlink = unserialize($settings->getSetting('seseventmusic.songlink'));

      //Favourite work
      if ($item)
        $this->view->isFavourite = $favouriteTable->isFavourite(array('resource_type' => "seseventmusic_albumsong", 'resource_id' => $item->albumsong_id));

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

      //Album and Song object according to song_id and alsbum_id: Written by SocialEngineSolutions
      $this->view->song = $song = $item; //Engine_Api::_()->getItem('seseventmusic_albumsong', $item->albumsong_id);
      if ($song)
        $this->view->album = Engine_Api::_()->getItem('seseventmusic_album', $song->album_id);
      if (empty($song))
        return $this->setNoRender();
    }
  }

}