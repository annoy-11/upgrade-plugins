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
class Seseventmusic_Widget_AlbumCoverController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $authorizationApi = Engine_Api::_()->authorization();
    $ratingTable = Engine_Api::_()->getDbTable('ratings', 'seseventmusic');

    $this->view->album = $album = Engine_Api::_()->core()->getSubject('seseventmusic_album');
    if (!$album)
      return $this->setNoRender();

    if (!$settings->getSetting('seseventmusic.checkmusic'))
      return $this->setNoRender();

    $viewer = Engine_Api::_()->user()->getViewer();
    
    

    $this->view->albumCover = $settings->getSetting('seseventmusic.show.albumcover', 1);
    $this->view->viewer_id = $viewer->getIdentity();
    $this->view->height = $this->_getParam('height', 400);
    $this->view->mainPhotoHeight = $this->_getParam('mainPhotoHeight', 350);
    $this->view->mainPhotowidth = $this->_getParam('mainPhotowidth', 350);
    $this->view->albumCoverPhoto = $settings->getSetting('seseventmusic.albumcover.photo');

    //Can delete
    $this->view->canEdit = $authorizationApi->isAllowed('sesevent_event', $viewer, 'edit');
    
    $this->view->canDelete = $authorizationApi->isAllowed('sesevent_event', $viewer, 'delete');

    $this->view->canAddFavourite = $authorizationApi->isAllowed('seseventmusic_album', $viewer, 'addfavourite_album');

    $this->view->albumlink = unserialize($settings->getSetting('seseventmusic.albumlink'));

    //Favourite work
    $this->view->isFavourite = Engine_Api::_()->getDbTable('favourites', 'seseventmusic')->isFavourite(array('resource_type' => "seseventmusic_album", 'resource_id' => $album->getIdentity()));

    //Rating work
    $this->view->mine = $mine = true;
    if (!$viewer->isSelf($album->getOwner()))
      $this->view->mine = $mine = false;

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

    if ($showRating) {
      $this->view->canRate = $canRate = $authorizationApi->isAllowed('seseventmusic_album', $viewer, 'rating_album');
      $this->view->allowRateAgain = $allowRateAgain = $settings->getSetting('seseventmusic.ratealbum.again', 1);
      $this->view->allowRateOwn = $allowRateOwn = $settings->getSetting('seseventmusic.ratealbum.own', 1);

      if ($canRate == 0 || $allowRating == 0)
        $allowRating = false;
      else
        $allowRating = true;

      if ($allowRateOwn == 0 && $mine)
        $allowMine = false;
      else
        $allowMine = true;

      $this->view->allowMine = $allowMine;
      $this->view->allowRating = $allowRating;
      $this->view->rating_type = $rating_type = 'seseventmusic_album';
      $this->view->rating_count = $ratingTable->ratingCount($album->getIdentity(), $rating_type);
      $this->view->rated = $rated = $ratingTable->checkRated($album->getIdentity(), $viewer->getIdentity(), $rating_type);

      if (!$allowRateAgain && $rated)
        $rated = false;
      else
        $rated = true;
      $this->view->ratedAgain = $rated;
    }
    //End rating work

    $this->view->information = $this->_getParam('information', array('featured', 'sponsored', 'hot', 'postedBy', 'creationDate', 'commentCount', 'viewCount', 'likeCount', 'ratingCount', 'description', 'ratingStars', 'favouriteCount', 'uploadButton', 'editButton', 'deleteButton', 'share', 'report', 'downloadButton', 'addFavouriteButton', 'photo', "category"));
  }

}