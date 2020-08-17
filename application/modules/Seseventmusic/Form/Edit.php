<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventmusic
 * @package    Seseventmusic
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Edit.php 2015-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Seseventmusic_Form_Edit extends Seseventmusic_Form_Create {

  public function init() {

    $album_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('album_id');
    if ($album_id)
      $album = Engine_Api::_()->getItem('seseventmusic_album', $album_id);
    parent::init();

    $this->setAttrib('id', 'form-upload-music')
            ->setAttrib('name', 'playlist_edit')
            ->setAttrib('enctype', 'multipart/form-data')
            ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()));

    //Pre-fill form values
    $this->addElement('Hidden', 'album_id');
    $this->removeElement('fancyuploadfileids');

    
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper')
    ));

    $this->addElement('Cancel', 'cancel', array(
        'label' => 'Cancel',
        'link' => true,
        'prependText' => ' or ',
        'href' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'view', 'album_id' => $album_id, 'slug' => $album->getSlug()), 'seseventmusic_album_view', true),
        'decorators' => array(
            'ViewHelper'
        )
    ));
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
  }

  public function populate($album) {

    $this->setTitle('Edit Album');

    foreach (array('album_id' => $album->getIdentity(), 'title' => $album->getTitle(), 'description' => $album->description, 'search' => $album->search) as $key => $value) {
      if ($value)
        $this->getElement($key)->setValue($value);
    }

    //If this is THE profile playlist, hide the title/desc fields
    if ($album->special) {
      $this->removeElement('title');
      $this->removeElement('description');
      $this->removeElement('label');
      $this->removeElement('search');
    }

    //AUTHORIZATIONS
    $auth = Engine_Api::_()->authorization()->context;

    $auth_view = $this->getElement('auth_view');
    if ($auth_view) {
      $lowest_viewer = array_pop(array_keys($this->_roles));
      foreach (array_reverse(array_keys($this->_roles)) as $role) {
        if ($auth->isAllowed($album, $role, 'view')) {
          $lowest_viewer = $role;
        }
      }
      $auth_view->setValue($lowest_viewer);
    }

    $auth_comment = $this->getElement('auth_comment');
    if ($auth_comment) {
      $lowest_commenter = array_pop(array_keys($this->_roles));
      foreach (array_reverse(array_keys($this->_roles)) as $role) {
        if ($auth->isAllowed($album, $role, 'comment')) {
          $lowest_commenter = $role;
        }
      }
      $auth_comment->setValue($lowest_commenter);
    }
  }

  public function saveValues() {

    $album = parent::saveValues();
    $values = $this->getValues();
    if ($album && $album->isEditable()) {
      if (!$album->special) {
        $album->title = $values['title'];
        $album->description = $values['description'];
        $album->search = $values['search'];
        if (isset($values['label']))
          $album->label = $values['label'];
      }
      $album->save();

      //Rebuild privacy
      $actionTable = Engine_Api::_()->getDbtable('actions', 'activity');
      foreach ($actionTable->getActionsByObject($album) as $action) {
        $actionTable->resetActivityBindings($action);
      }

      return $album;
    } else {
      return false;
    }
  }

}