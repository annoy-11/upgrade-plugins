<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventmusic
 * @package    Seseventmusic
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Menus.php 2015-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Seseventmusic_Plugin_Menus {

  public function onMenuInitialize_SeseventmusicMainManage() {

    //Must be logged in
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!$viewer || !$viewer->getIdentity())
      return false;

    //Must be able to create albums
    if (!Engine_Api::_()->authorization()->isAllowed('seseventmusic_album', $viewer, 'create'))
      return false;

    return true;
  }
  
    public function onMenuInitialize_SeseventmusicQuickCreate() {

    //Must be logged in
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!$viewer || !$viewer->getIdentity())
      return false;

    //Must be able to create albums
    if (!Engine_Api::_()->authorization()->isAllowed('seseventmusic_album', $viewer, 'create'))
      return false;

    return true;
  }

  public function onMenuInitialize_SeseventmusicMainCreate() {

    //Must be logged in
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!$viewer || !$viewer->getIdentity())
      return false;

    //Must be able to create albums
    if (!Engine_Api::_()->authorization()->isAllowed('seseventmusic_album', $viewer, 'create'))
      return false;

    return true;
  }

  public function onMenuInitialize_SeseventmusicMainBrowse() {

    $viewer = Engine_Api::_()->user()->getViewer();

    //Must be able to view albums
    if (!Engine_Api::_()->authorization()->isAllowed('seseventmusic_album', $viewer, 'view'))
      return false;

    return true;
  }

  public function onMenuInitialize_SeseventmusicProfileEdit() {

    $viewer = Engine_Api::_()->user()->getViewer();
    $album = Engine_Api::_()->core()->getSubject();

    if ($album->getType() !== 'seseventmusic_album')
      throw new Seseventmusic_Model_Exception('Whoops, not a music album!');

    if (!$viewer->getIdentity() || !$album->authorization()->isAllowed($viewer, 'edit'))
      return false;

    return array(
        'label' => 'Edit Album',
        'icon' => 'application/modules/Seseventmusic/externals/images/edit.png',
        'route' => 'seseventmusic_album_specific',
        'params' => array(
            'action' => 'edit',
            'album_id' => $album->getIdentity(),
            'slug' => $album->getSlug(),
        )
    );
  }

  public function onMenuInitialize_SeseventmusicProfileReport() {

    $viewer = Engine_Api::_()->user()->getViewer();
    $album = Engine_Api::_()->core()->getSubject();
    
    $albumlink = unserialize(Engine_Api::_()->getApi('settings', 'core')->getSetting('seseventmusic.albumlink'));
    if(empty($albumlink))
	    return false;
	  if(!in_array('report', $albumlink))
	    return false;
	    
    if ($album->getType() !== 'seseventmusic_album')
      throw new Seseventmusic_Model_Exception('This music album does not exist.');

    if (!$viewer->getIdentity())
      return false;

    return array(
        'label' => 'Report',
        'icon' => 'application/modules/Seseventmusic/externals/images/report.png',
        'class' => 'smoothbox',
        'route' => 'default',
        'params' => array(
            'module' => 'core',
            'controller' => 'report',
            'action' => 'create',
            'subject' => $album->getGuid(),
            'format' => 'smoothbox',
        ),
    );
  }

  public function onMenuInitialize_SeseventmusicProfileShare() {

    $viewer = Engine_Api::_()->user()->getViewer();
    $album = Engine_Api::_()->core()->getSubject();
    
    $albumlink = unserialize(Engine_Api::_()->getApi('settings', 'core')->getSetting('seseventmusic.albumlink'));
    if(empty($albumlink))
	    return false;
	  if(!in_array('share', $albumlink))
	    return false;

    if ($album->getType() !== 'seseventmusic_album')
      throw new Seseventmusic_Model_Exception('This music album does not exist.');

    if (!$viewer->getIdentity())
      return false;

    return array(
        'label' => 'Share',
        'icon' => 'application/modules/Seseventmusic/externals/images/share.png',
        'class' => 'smoothbox',
        'route' => 'default',
        'params' => array(
            'module' => 'activity',
            'controller' => 'index',
            'action' => 'share',
            'type' => $album->getType(),
            'id' => $album->getIdentity(),
            'format' => 'smoothbox',
        ),
    );
  }

  public function onMenuInitialize_SeseventmusicProfileDelete() {

    $viewer = Engine_Api::_()->user()->getViewer();
    $album = Engine_Api::_()->core()->getSubject();

    if ($album->getType() !== 'seseventmusic_album')
      throw new Seseventmusic_Model_Exception('This music album does not exist.');

    if (!$album->authorization()->isAllowed($viewer, 'delete'))
      return false;

    return array(
        'label' => 'Delete Album',
        'icon' => 'application/modules/Seseventmusic/externals/images/delete.png',
        'class' => 'smoothbox',
        'route' => 'seseventmusic_general',
        'params' => array(
            'action' => 'delete',
            'album_id' => $album->getIdentity(),
            'format' => 'smoothbox',
        ),
    );
  }

  public function onMenuInitialize_SeseventmusicProfileCreate() {

    $viewer = Engine_Api::_()->user()->getViewer();
    $album = Engine_Api::_()->core()->getSubject();

    if ($album->getType() !== 'seseventmusic_album')
      throw new Seseventmusic_Model_Exception('This music album does not exist.');

    if (!$album->authorization()->isAllowed($viewer, 'create'))
      return false;

    return array(
        'label' => 'Upload Songs',
        'icon' => 'application/modules/Seseventmusic/externals/images/new.png',
        'route' => 'seseventmusic_general',
        'params' => array(
            'action' => 'create',
        ),
    );
  }

  //Song View Page Options
  public function onMenuInitialize_SeseventmusicSongProfileEdit() {

    $viewer = Engine_Api::_()->user()->getViewer();
    $song = Engine_Api::_()->core()->getSubject();
    $album = Engine_Api::_()->getItem('seseventmusic_album', $song->album_id);

    if ($song->getType() !== 'seseventmusic_albumsong')
      throw new Seseventmusic_Model_Exception('Whoops, not a music album!');

    if (!$viewer->getIdentity() || !$album->authorization()->isAllowed($viewer, 'edit'))
      return false;

    return array(
        'label' => 'Edit Song',
        'icon' => 'application/modules/Seseventmusic/externals/images/edit.png',
        'route' => 'seseventmusic_albumsong_specific',
        'params' => array(
            'action' => 'edit',
            'albumsong_id' => $song->getIdentity(),
        )
    );
  }

  public function onMenuInitialize_SeseventmusicSongProfileReport() {

    $viewer = Engine_Api::_()->user()->getViewer();
    $song = Engine_Api::_()->core()->getSubject();
    
    $songlink = unserialize(Engine_Api::_()->getApi('settings', 'core')->getSetting('seseventmusic.songlink'));
    if(empty($songlink))
	    return false;
	  if(!in_array('report', $songlink))
	    return false;

    if ($song->getType() !== 'seseventmusic_albumsong')
      throw new Seseventmusic_Model_Exception('This music album does not exist.');

    if (!$viewer->getIdentity())
      return false;

    return array(
        'label' => 'Report',
        'icon' => 'application/modules/Seseventmusic/externals/images/report.png',
        'class' => 'smoothbox',
        'route' => 'default',
        'params' => array(
            'module' => 'core',
            'controller' => 'report',
            'action' => 'create',
            'subject' => $song->getGuid(),
            'format' => 'smoothbox',
        ),
    );
  }

  public function onMenuInitialize_SeseventmusicSongProfilePrint() {

    $viewer = Engine_Api::_()->user()->getViewer();
    $song = Engine_Api::_()->core()->getSubject();

    if ($song->getType() !== 'seseventmusic_albumsong')
      throw new Seseventmusic_Model_Exception('This music album does not exist.');

    if (!$viewer->getIdentity())
      return false;

    return array(
        'label' => 'Print',
        'icon' => 'application/modules/Seseventmusic/externals/images/print.png',
        'route' => 'seseventmusic_albumsong_specific',
        'params' => array(
            'action' => 'print',
            'albumsong_id' => $song->getIdentity()
        ),
    );
  }

  public function onMenuInitialize_SeseventmusicSongProfileShare() {

    $viewer = Engine_Api::_()->user()->getViewer();
    $song = Engine_Api::_()->core()->getSubject();
    
    $songlink = unserialize(Engine_Api::_()->getApi('settings', 'core')->getSetting('seseventmusic.songlink'));
    if(empty($songlink))
	    return false;
	  if(!in_array('share', $songlink))
	    return false;
	  
    if ($song->getType() !== 'seseventmusic_albumsong')
      throw new Seseventmusic_Model_Exception('This music album does not exist.');

    if (!$viewer->getIdentity())
      return false;

    return array(
        'label' => 'Share',
        'icon' => 'application/modules/Seseventmusic/externals/images/share.png',
        'class' => 'smoothbox',
        'route' => 'default',
        'params' => array(
            'module' => 'activity',
            'controller' => 'index',
            'action' => 'share',
            'type' => $song->getType(),
            'id' => $song->getIdentity(),
            'format' => 'smoothbox',
        ),
    );
  }

  public function onMenuInitialize_SeseventmusicSongProfileDelete() {

    $viewer = Engine_Api::_()->user()->getViewer();
    $song = Engine_Api::_()->core()->getSubject();
    $album = Engine_Api::_()->getItem('seseventmusic_album', $song->album_id);

    if ($song->getType() !== 'seseventmusic_albumsong')
      throw new Seseventmusic_Model_Exception('This music album does not exist.');

    if (!$album->authorization()->isAllowed($viewer, 'delete'))
      return false;

    return array(
        'label' => 'Delete Song',
        'icon' => 'application/modules/Seseventmusic/externals/images/delete.png',
        'class' => 'smoothbox',
        'route' => 'seseventmusic_albumsong_specific',
        'params' => array(
            'action' => 'delete',
            'albumsong_id' => $song->getIdentity(),
            'format' => 'smoothbox',
        ),
    );
  }

  public function onMenuInitialize_SeseventmusicSongProfileDownload() {

    $viewer = Engine_Api::_()->user()->getViewer();
    $song = Engine_Api::_()->core()->getSubject();

    if ($song->getType() !== 'seseventmusic_albumsong')
      throw new Seseventmusic_Model_Exception('This album song does not exist.');

    if (!$viewer->getIdentity())
      return false;

    return array(
        'label' => 'Download',
        'icon' => 'application/modules/Seseventmusic/externals/images/doenload.png',
        'route' => 'seseventmusic_albumsong_specific',
        'params' => array(
            'action' => 'download-song',
            'albumsong_id' => $song->getIdentity()
        ),
    );
  }
}