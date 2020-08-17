<?php

class Seseventmusic_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $db = Engine_Db_Table::getDefaultAdapter();

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seseventmusic_admin_main', array(), 'seseventmusic_admin_main_settings');
    $this->view->subNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seseventmusic_admin_main_globalsettings', array(), 'seseventmusic_admin_main_subglobalsettings');

    $this->view->form = $form = new Seseventmusic_Form_Admin_Settings_Global();

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

      if (isset($_POST['seseventmusic_uploadoption']) && $_POST['seseventmusic_uploadoption'] == 'both' || $_POST['seseventmusic_uploadoption'] == 'soundCloud') {

        if (empty($_POST['seseventmusic_scclientid'])) {
          Engine_Api::_()->getApi('settings', 'core')->setSetting('seseventmusic.uploadoption', $_POST['seseventmusic_uploadoption']);
          $error = Zend_Registry::get('Zend_Translate')->_('SoundCloud Client Id * Please complete this field - it is required.');
          $form->getDecorator('errors')->setOption('escape', false);
          $form->addError($error);
          return;
        }

        if (empty($_POST['seseventmusic_scclientscreatid'])) {
          Engine_Api::_()->getApi('settings', 'core')->setSetting('seseventmusic.uploadoption', $_POST['seseventmusic_uploadoption']);
          $error = Zend_Registry::get('Zend_Translate')->_('SoundCloud Client Secret * Please complete this field - it is required.');
          $form->getDecorator('errors')->setOption('escape', false);
          $form->addError($error);
          return;
        }
      }

//       //Footer Page >> Placed player widget if not there.
//       $page_id = $db->select()
//               ->from('engine4_core_pages', 'page_id')
//               ->where('name = ?', 'footer')
//               ->limit(1)
//               ->query()
//               ->fetchColumn();
//       if ($page_id) {
//         $content_id = $db->select()
//                 ->from('engine4_core_content', 'content_id')
//                 ->where('name = ?', 'main')
//                 ->where('page_id = ?', $page_id)
//                 ->where('type = ?', 'container')
//                 ->limit(1)
//                 ->query()
//                 ->fetchColumn();
//         $widget_id = $db->select()
//                 ->from('engine4_core_content', 'content_id')
//                 ->where('name = ?', 'seseventmusic.player')
//                 ->where('page_id = ?', $page_id)
//                 ->where('type = ?', 'widget')
//                 ->limit(1)
//                 ->query()
//                 ->fetchColumn();
//         if (empty($widget_id) && $content_id) {
//           $db->query("INSERT IGNORE INTO `engine4_core_content` (`page_id`, `type`, `name`, `parent_content_id`, `order`, `params`, `attribs`) VALUES ('" . $page_id . "', 'widget', 'seseventmusic.player', '" . $content_id . "', '1', NULL, NULL);");
//         }
//       }


      $values = $form->getValues();
      include_once APPLICATION_PATH . "/application/modules/Seseventmusic/controllers/License.php";
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('seseventmusic.pluginactivated')) {

        foreach ($values as $key => $value) {
          Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
        }
        $form->addNotice('Your changes have been saved successfully.');
        $this->_helper->redirector->gotoRoute(array());
      }
    }
  }

  public function albumSettingsAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seseventmusic_admin_main', array(), 'seseventmusic_admin_main_settings');
    $this->view->subNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seseventmusic_admin_main_globalsettings', array(), 'seseventmusic_admin_main_subalbumssettings');

    $this->view->form = $form = new Seseventmusic_Form_Admin_Settings_AlbumSettings();

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

      $values = $form->getValues();
      if (isset($values['seseventmusic_albumlink']))
        $values['seseventmusic_albumlink'] = serialize($values['seseventmusic_albumlink']);
      else
        $values['seseventmusic_albumlink'] = serialize(array());
      if (empty($values['album_cover']))
        unset($values['album_cover']);
      if (empty($values['album_defaultphoto']))
        unset($values['album_defaultphoto']);
      foreach ($values as $key => $value) {
        Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
      }
      $form->addNotice('Your changes have been saved successfully.');
    }
  }

  public function songSettingsAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seseventmusic_admin_main', array(), 'seseventmusic_admin_main_settings');
    $this->view->subNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seseventmusic_admin_main_globalsettings', array(), 'seseventmusic_admin_main_subsongssettings');

    $this->view->form = $form = new Seseventmusic_Form_Admin_Settings_SongSettings();

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

      $values = $form->getValues();
      if (isset($values['seseventmusic_songlink']))
        $values['seseventmusic_songlink'] = serialize($values['seseventmusic_songlink']);
      else
        $values['seseventmusic_songlink'] = serialize(array());
      if (empty($values['albumsong_cover']))
        unset($values['albumsong_cover']);
      if (empty($values['albumsong_default']))
        unset($values['albumsong_default']);
      foreach ($values as $key => $value) {
        Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
      }
      $form->addNotice('Your changes have been saved successfully.');
    }
  }

  public function getAlbumsAction() {

    if (isset($_COOKIE['seseventmusic_oftheday']))
      $type = $_COOKIE['seseventmusic_oftheday'];
    else
      $type = 'album';

    if ($type == 'album') {
      $table = Engine_Api::_()->getDbtable('albums', 'seseventmusic');
      $id = 'album_id';
      $photo = 'thumb.icon';
      $label = 'title';
    } elseif ($type == 'albumsong') {
      $table = Engine_Api::_()->getDbtable('albumsongs', 'seseventmusic');
      $id = 'albumsong_id';
      $photo = 'thumb.profile';
      $label = 'title';
    }

    $data = array();
    $select = $table->select();
    $select->where('title  LIKE ? ', '%' . $this->_getParam('text') . '%')->order('title ASC')->limit('40');

    if ($type == 'album')
      $select->where("search = ?", 1);

    $results = $table->fetchAll($select);
    foreach ($results as $result) {

      if ($type == 'albumsong' && !$result->photo_id) {
        $album = Engine_Api::_()->getItem('seseventmusic_album', $result->album_id);
        $photoItem = $this->view->itemPhoto($album, $photo);
      } else {
        $photoItem = $this->view->itemPhoto($result, $photo);
      }

      $data[] = array(
          'id' => $result->$id,
          'label' => $result->$label,
          'photo' => $photoItem
      );
    }
    return $this->_helper->json($data);
  }

  //Statistics Action
  public function statisticAction() {

    //GET NAVIGATION
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seseventmusic_admin_main', array(), 'seseventmusic_admin_main_statistic');

    $albumTable = Engine_Api::_()->getDbtable('albums', 'seseventmusic');
    $albumTableName = $albumTable->info('name');

    //Total Albums
    $select = $albumTable->select()->from($albumTableName, 'count(*) AS totalalbum');
    $this->view->totalalbum = $select->query()->fetchColumn();

    //Total featured album
    $select = $albumTable->select()->from($albumTableName, 'count(*) AS totalfeatured')->where('featured =?', 1);
    $this->view->totalfeatured = $select->query()->fetchColumn();

    //Total sponsored album
    $select = $albumTable->select()->from($albumTableName, 'count(*) AS totalsponsored')->where('sponsored =?', 1);
    $this->view->totalsponsored = $select->query()->fetchColumn();

    //Total hot album
    $select = $albumTable->select()->from($albumTableName, 'count(*) AS totalhot')->where('hot =?', 1);
    $this->view->totalhot = $select->query()->fetchColumn();

    //Total favourite album
    $select = $albumTable->select()->from($albumTableName, 'count(*) AS totalfavourite')->where('hot =?', 1);
    $this->view->totalfavourite = $select->query()->fetchColumn();

    //Total rated album
    $select = $albumTable->select()->from($albumTableName, 'count(*) AS totalrated')->where('rating <>?', 0);
    $this->view->totalrated = $select->query()->fetchColumn();

    //Album Songs
    $albumSongsTable = Engine_Api::_()->getDbtable('albumsongs', 'seseventmusic');
    $albumsongsTableName = $albumSongsTable->info('name');

    //Total songs
    $select = $albumSongsTable->select()->from($albumsongsTableName, 'count(*) AS totalalbumsongs');
    $this->view->totalalbumsongs = $select->query()->fetchColumn();

    //Total featured songs
    $select = $albumSongsTable->select()->from($albumsongsTableName, 'count(*) AS totalfeaturedsongs')->where('featured =?', 1);
    $this->view->totalfeaturedsongs = $select->query()->fetchColumn();

    //Total sponsored songs
    $select = $albumSongsTable->select()->from($albumsongsTableName, 'count(*) AS totalsponsoredsongs')->where('sponsored =?', 1);
    $this->view->totalsponsoredsongs = $select->query()->fetchColumn();

    //Total hot songs
    $select = $albumSongsTable->select()->from($albumsongsTableName, 'count(*) AS totalhotsongs')->where('hot =?', 1);
    $this->view->totalhotsongs = $select->query()->fetchColumn();

    //Total favourite songs
    $select = $albumSongsTable->select()->from($albumsongsTableName, 'count(*) AS totalfavouritesongs')->where('favourite_count <>?', 0);
    $this->view->totalfavouritesongs = $select->query()->fetchColumn();

    //Total rated songs
    $select = $albumSongsTable->select()->from($albumsongsTableName, 'count(*) AS totalratedsongs')->where('rating <>?', 0);
    $this->view->totalratedsongs = $select->query()->fetchColumn();

  }
  
  public function showpopupAction() {
    
  }
  
  public function manageWidgetizePageAction() {

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seseventmusic_admin_main', array(), 'seseventmusic_admin_main_managewidgetizepage');

    $pagesArray = array('seseventmusic_index_home', 'seseventmusic_index_browse', 'seseventmusic_index_create', 'seseventmusic_album_edit', 'seseventmusic_album_view', 'seseventmusic_song_view');
    
    $this->view->pagesArray = $pagesArray;
  }

}