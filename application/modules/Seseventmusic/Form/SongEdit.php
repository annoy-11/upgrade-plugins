<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventmusic
 * @package    Seseventmusic
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: SongEdit.php 2015-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Seseventmusic_Form_SongEdit extends Engine_Form {

  public function init() {

    $albumsong_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('albumsong_id');
    if ($albumsong_id)
      $album_song = Engine_Api::_()->getItem('seseventmusic_albumsong', $albumsong_id);

    $this->setTitle('Edit Songs')
            ->setDescription('Here, you can edit the song information.');

    $this->addElement('Text', 'title', array(
        'label' => 'Song Name',
        'placeholder' => 'Enter Song Name',
        'maxlength' => '63',
        'filters' => array(
            new Engine_Filter_Censor(),
            new Engine_Filter_StringLength(array('max' => '63')),
        )
    ));

    $this->addElement('Textarea', 'description', array(
        'label' => 'Song Description',
        'placeholder' => 'Enter Song Description',
        'maxlength' => '300',
        'filters' => array(
            'StripTags',
            new Engine_Filter_Censor(),
            new Engine_Filter_StringLength(array('max' => '300')),
            new Engine_Filter_EnableLinks(),
        ),
    ));


    $this->addElement('Textarea', 'lyrics', array(
        'label' => 'Song Lyrics',
        'placeholder' => 'Enter Song Lyrics',
        'filters' => array(
            'StripTags',
            new Engine_Filter_Censor(),
            new Engine_Filter_EnableLinks(),
        ),
    ));

    $albumsong_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('albumsong_id');
    if ($albumsong_id)
      $albumsong = Engine_Api::_()->getItem('seseventmusic_albumsong', $albumsong_id);

    $this->addElement('File', 'song_cover', array(
        'label' => 'Song Cover Photo',
        'onchange' => 'showReadImage(this,"song_cover_preview")',
    ));

    $this->song_cover->addValidator('Extension', false, 'jpg,png,gif,jpeg');
    if ($albumsong_id && $albumsong && $albumsong->song_cover) {
      $img_path = Engine_Api::_()->storage()->get($albumsong->song_cover, '')->getPhotoUrl();
      $path = $img_path;
      if (isset($path) && !empty($path)) {
	$this->addElement('Image', 'song_cover_preview', array(
	    'label' => 'Song Cover Preview',
	    'src' => $path,
	    'width' => 100,
	    'height' => 100,
	));
      }
    } else {
      $this->addElement('Image', 'song_cover_preview', array(
	'label' => 'Song Cover Preview',
	'src' => $path,
	'width' => 100,
	'height' => 100,
      ));
    }
    if ($albumsong->song_cover) {
      $this->addElement('Checkbox', 'remove_song_cover', array(
          'label' => 'Yes, remove song cover.'
      ));
    }

    //Init album art
    $this->addElement('File', 'file', array(
        'label' => 'Song Main Photo',
        'onchange' => 'showReadImage(this,"song_mainphoto_preview")',
    ));

    $this->file->addValidator('Extension', false, 'jpg,png,gif,jpeg');
    if ($albumsong_id && $albumsong && $albumsong->photo_id) {
      $img_path = Engine_Api::_()->storage()->get($albumsong->photo_id, '')->getPhotoUrl();
      $path = $img_path;
      if (isset($path) && !empty($path)) {
	$this->addElement('Image', 'song_mainphoto_preview', array(
	    'label' => 'Song Main Photo Preview',
	    'src' => $path,
	    'width' => 100,
	    'height' => 100,
	));
      }
    } else {
      $this->addElement('Image', 'song_mainphoto_preview', array(
	'label' => 'Song Main Photo Preview',
	'src' => $path,
	'width' => 100,
	'height' => 100,
      ));
    }
    if ($albumsong->photo_id) {
      $this->addElement('Checkbox', 'remove_photo', array(
          'label' => 'Yes, remove song photo.'
      ));
    }

    $viewer = Engine_Api::_()->user()->getViewer();
    $downloadAlbumSong = Engine_Api::_()->authorization()->isAllowed('seseventmusic_album', $viewer, 'download_albumsong');
    if ($downloadAlbumSong) {
      $this->addElement('Checkbox', 'download', array(
          'label' => 'Do you want to download this song?',
          'value' => 1,
      ));
    }

    //Element: execute
    $this->addElement('Button', 'execute', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array(
            'ViewHelper',
        ),
    ));

    // Element: cancel
    $this->addElement('Cancel', 'cancel', array(
        'label' => 'cancel',
        'link' => true,
        'prependText' => ' or ',
        'href' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'view', 'albumsong_id' => $albumsong_id, 'slug' => $albumsong->getSlug()), 'seseventmusic_albumsong_view', true),
        'onclick' => '',
        'decorators' => array(
            'ViewHelper',
        ),
    ));

    // DisplayGroup: buttons
    $this->addDisplayGroup(array(
        'execute',
        'cancel',
            ), 'buttons', array(
        'decorators' => array(
            'FormElements',
            'DivDivDivWrapper'
        ),
    ));
  }

}