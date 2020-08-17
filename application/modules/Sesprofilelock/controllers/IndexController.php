<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilelock
 * @package    Sesprofilelock
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php 2016-04-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesprofilelock_IndexController extends Core_Controller_Action_Standard {

  protected $_user;

  public function init() {

    // Can specifiy custom id
    $id = $this->_getParam('id', null);
    $subject = null;
    if (null === $id) {
      $subject = Engine_Api::_()->user()->getViewer();
      Engine_Api::_()->core()->setSubject($subject);
    } else {
      $subject = Engine_Api::_()->getItem('user', $id);
      Engine_Api::_()->core()->setSubject($subject);
    }

    // Set up require's
    $this->_helper->requireUser();
    $this->_helper->requireSubject();
    $this->_helper->requireAuth()->setAuthParams($subject, null, 'edit');

    $contextSwitch = $this->_helper->contextSwitch;
    $contextSwitch->initContext();
    $this->_helper->content->setEnabled();
  }

  public function indexAction() {

    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesprofilelock.lockedlink', 1)) {
      $this->_forward('requireauth', 'error', 'core');
      return;
    }

    $viewer = Engine_Api::_()->user()->getViewer();
    $viewer_id = $viewer->getIdentity();

    if (empty($viewer_id)) {
      $this->_forward('requireauth', 'error', 'core');
      return;
    } elseif (!isset($_SESSION['sesuserlocked']) && !empty($viewer_id)) {
      $this->_forward('requiresubject', 'error', 'core');
      return;
    }

    $sesproflelock_popupinfo = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesprofilelock.popupinfo');
    $this->view->sesproflelock_popupinfovalue = unserialize($sesproflelock_popupinfo);

    $table = Engine_Api::_()->getDbTable('slideimages', 'sesprofilelock');
    $this->view->storage = Engine_Api::_()->storage();
    $select = $table->select()->order('order ASC');
    $this->view->paginator = $table->fetchAll($select);

    $db = Engine_Db_Table::getDefaultAdapter();
    $select = new Zend_Db_Select($db);
    $params = $select
            ->from('engine4_core_content', 'params')
            ->where('name =?', 'core.menu-logo')
            ->query()
            ->fetchAll(Zend_Db::FETCH_COLUMN);
    if(count($params)) {
      $params = Zend_Json_Decoder::decode($params[0]);
      if (isset($params) && !empty($params['logo'])) {
        $this->view->logo = $params['logo'];
      }
    } else {
      $this->view->logo = '';
    }

    $userlockedSession = new Zend_Session_Namespace('sesuserlocked');
    $this->view->form = $form = new Sesprofilelock_Form_Userunlocked();
    if (isset($userlockedSession))
      $this->view->viewer = $viewer;
  }
  public function lockedAction() {
    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesprofilelock.lockedlink', 1)) {
      $this->_forward('requireauth', 'error', 'core');
      return;
    }
    $userlockedsession = new Zend_Session_Namespace('sesuserlocked');
    $userlockedsession->sesuserlocked = 1;
    $executeUrl = ( _ENGINE_SSL ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . Zend_Registry::get('Zend_View')->baseUrl();
    $final_url = $executeUrl . '/sesprofilelock/index';
    header("Location: $final_url");
  }
  public function redirectAction() {
    $db = Engine_Db_Table::getDefaultAdapter();
    $select = new Zend_Db_Select($db);
    $params = $select
            ->from('engine4_core_content', 'params')
            ->where('name =?', 'core.menu-logo')
            ->query()
            ->fetchAll(Zend_Db::FETCH_COLUMN);
    if(count($params)) {
      $params = Zend_Json_Decoder::decode($params[0]);
      if (isset($params) && !empty($params['logo'])) {
        $this->view->logo = $params['logo'];
      }
    } else {
      $this->view->logo = '';
    }

    $sesproflelock_popupinfo = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesprofilelock.popupinfo');
    $this->view->sesproflelock_popupinfovalue = unserialize($sesproflelock_popupinfo);

    $table = Engine_Api::_()->getDbTable('slideimages', 'sesprofilelock');
    $this->view->storage = Engine_Api::_()->storage();
    $select = $table->select()->order('order ASC');
    $this->view->paginator = $table->fetchAll($select);

    $this->view->form = $form = new Sesprofilelock_Form_Userunlocked();
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();

    // Not a post
    if (!$this->getRequest()->isPost()) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('No action taken');
      return;
    }

    // Form not valid
    if (!$form->isValid($this->getRequest()->getPost())) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid data');
      return;
    }

    $password = $_POST['password'];
    $user_table = Engine_Api::_()->getDbtable('users', 'user');
    $staticSalt = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.secret', 'staticSalt');
    $final_password = md5($staticSalt . $password . $viewer->salt);

    if ($viewer->password != $final_password) {
      $form->addError('Please enter the correct password.');
      return;
    }
    unset($_SESSION['sesuserlocked']);
    $this->_helper->redirector->gotoRoute(array(), 'user_login', true);
  }

  public function blockedAction() {

    $user = Engine_Api::_()->core()->getSubject();
    $this->view->form = $form = new Sesprofilelock_Form_Blocked(array('item' => $user));

    if (!$this->getRequest()->isPost()) {
      return;
    }

    if (!$form->isValid($this->getRequest()->getPost())) {
      return;
    }

    $sesvalues = $form->getValues();

    if (isset($sesvalues['blocked_levels'])) {
      $blocked_levels = serialize($sesvalues['blocked_levels']);
    } else {
      $blocked_levels = serialize(array());
    }

    if (isset($sesvalues['blocked_networks'])) {
      $blocked_networks = serialize($sesvalues['blocked_networks']);
    } else {
      $blocked_networks = serialize(array());
    }

    if (isset($sesvalues['toValues']) && !empty($sesvalues['toValues'])) {
      $toValues = explode(",", $sesvalues['toValues']);
    }

    unset($sesvalues['to']);

    $userblockTable = Engine_Api::_()->getDbtable('block', 'user');
    // Process form
    $userTable = Engine_Api::_()->getItemTable('user');
    $db = $userTable->getAdapter();
    // Save
    $db->beginTransaction();

    try {

      $user->blocked_levels = $blocked_levels;
      $user->blocked_networks = $blocked_networks;
      $user->save();
      if (isset($toValues) && $toValues) {
        foreach ($toValues as $toValue) {
          $usersBlock = $userblockTable->createRow();
          $usersBlock->user_id = $user->user_id;
          $usersBlock->blocked_user_id = $toValue;
          $usersBlock->save();
        }
      }

      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }

    $form->addNotice(Zend_Registry::get('Zend_Translate')->_('Settings were successfully saved.'));
  }

  public function getmemberAction() {

    $sesdata = array();
    $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
    $usersBlocksTable = Engine_Api::_()->getDbtable('block', 'user');
    $select = $usersBlocksTable->select()
            ->where('user_id =?', $viewer_id);
    $results = $usersBlocksTable->fetchAll($select);

    $user_id_array = array();
    foreach ($results as $result) {
      $user_id_array[] = $result->blocked_user_id;
    }

    $usersTable = Engine_Api::_()->getDbtable('users', 'user');
    $select = $usersTable->select()
            ->where('user_id <> ?', $viewer_id)
            ->where('displayname  LIKE ? ', '%' . $this->_getParam('value') . '%');
    if ($user_id_array) {
      $select = $select->where('user_id NOT IN (?)', (array) $user_id_array);
    }
    $select = $select->order('displayname ASC')->limit('40');
    $results = $usersTable->fetchAll($select);

    foreach ($results as $result) {
      $user = Engine_Api::_()->getItem('user', $result->user_id);
      $userPhoto = $this->view->itemPhoto($user, 'thumb.icon');
      $sesdata[] = array(
          'id' => $result->user_id,
          'label' => $result->displayname,
          'photo' => $userPhoto
      );
    }
    return $this->_helper->json($sesdata);
  }

  public function unblockAction() {
    $user_id = $this->_getParam('user_id', null);
    $blocked_user_id = $this->_getParam('blocked_user_id', null);
    if ($user_id && $blocked_user_id) {
      Engine_Api::_()->getDbtable('block', 'user')->delete(array('user_id =?' => $user_id, 'blocked_user_id = ?' => $blocked_user_id));
      $this->view->blocked_id = 1;
    }
  }

}
