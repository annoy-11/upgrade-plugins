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
class Seseventmusic_Widget_PlayerController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $viewer = Engine_Api::_()->user()->getViewer();
    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('seseventmusic.checkmusic'))
      return $this->setNoRender();
    $this->view->downloadAlbumSong = Engine_Api::_()->authorization()->isAllowed('seseventmusic_album', $viewer, 'download_albumsong');
    $this->view->canAddPlaylistAlbumSong = Engine_Api::_()->authorization()->isAllowed('seseventmusic_album', $viewer, 'addplaylist_albumsong');
    //Songs settings.
    $this->view->songlink = unserialize(Engine_Api::_()->getApi('settings', 'core')->getSetting('seseventmusic.songlink'));
    $canView = Engine_Api::_()->authorization()->isAllowed('seseventmusic_album', $viewer, 'view');
    if (empty($canView))
      return $this->setNoRender();
  }

}