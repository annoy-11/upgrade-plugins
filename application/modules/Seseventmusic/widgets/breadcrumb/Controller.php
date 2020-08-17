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
class Seseventmusic_Widget_BreadcrumbController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $coreApi = Engine_Api::_()->core();
    $this->view->viewPageType = $viewPageType = $this->_getParam('viewPageType', 'album');

    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('seseventmusic.checkmusic'))
      return $this->setNoRender();

    if ($viewPageType == 'album') {

      if (!$coreApi->hasSubject('seseventmusic_album'))
        return $this->setNoRender();

      $this->view->album = $album = $coreApi->getSubject('seseventmusic_album');
      $this->view->event = Engine_Api::_()->getItem('sesevent_event', $album->resource_id);
    } elseif ($viewPageType == 'song') {

      if (!$coreApi->hasSubject('seseventmusic_albumsong'))
        return $this->setNoRender();

      $this->view->albumSong = $albumSong = $coreApi->getSubject('seseventmusic_albumsong');

      $this->view->album = $album = Engine_Api::_()->getItem('seseventmusic_album', $albumSong->album_id);
      $this->view->event = Engine_Api::_()->getItem('sesevent_event', $album->resource_id);
    }
  }

}