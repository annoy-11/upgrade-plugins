<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seschristmas
 * @package    Seschristmas
 * @copyright  Copyright 2014-2015 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: WelcomeController.php 2014-11-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Seschristmas_WelcomeController extends Core_Controller_Action_Standard {

  public function init() {

    // @todo this may not work with some of the content stuff in here, double-check
    $subject = null;
    if (!Engine_Api::_()->core()->hasSubject()) {

      $id = Engine_Api::_()->user()->getViewer()->getIdentity();

      if (null !== $id) {
        $subject = Engine_Api::_()->getItem('user', $id);
        Engine_Api::_()->core()->setSubject($subject);
      }
    }
  }

  public function indexAction() {

    $api_settings = Engine_Api::_()->getApi('settings', 'core');
    $this->view->pagename = $api_settings->getSetting('seschristmas.pagename', "Welcome Page");
    $this->view->viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
    $base_url = ( _ENGINE_SSL ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . Zend_Registry::get('Zend_View')->baseUrl();
    
    $url_string = Zend_Controller_Front::getInstance()->getRequest()->getRequestUri();
    if (strstr($url_string, '/index.php/')) {
      $this->view->final_url = $base_url . '/index.php/welcome/christmas?christmas=1';
    } else{
      $this->view->final_url = $base_url . '/welcome/christmas?christmas=1';
    }
    
    $viewer = Engine_Api::_()->user()->getViewer();
    $timezone = Engine_Api::_()->getApi('settings', 'core')->core_locale_timezone;
    if ($viewer->getIdentity()) {
      $timezone = $viewer->timezone;
    }

    $this->view->oldTz = date_default_timezone_get();
    date_default_timezone_set($timezone);

    $starttime = date("Y-m-d h:i:s");
    $this->view->start_time = strtotime($starttime);


    $welcome_page = $api_settings->getSetting('seschristmas.welcome', 1);
    $this->view->countdown = $api_settings->getSetting('seschristmas.welcomecountdown', 1);
    if (empty($welcome_page)) {
      $this->_forward('requiresubject', 'error', 'core');
      return;
    }
  }

  public function myfriendwishesAction() {

    $this->view->owner_id = Engine_Api::_()->core()->getSubject()->getIdentity();

    $wish = Engine_Api::_()->getApi('settings', 'core')->getSetting('seschristmas.wish', 1);
    if (empty($wish)) {
      $this->_forward('requiresubject', 'error', 'core');
      return;
    }

    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer_id = $viewer->getIdentity();
    if (empty($viewer_id)) {
      $this->_forward('requiresubject', 'error', 'core');
      return;
    }
    $limit = Engine_Api::_()->getApi('settings', 'core')->getSetting('seschristmas.wisheslimit', 10);
    $this->view->showviewmore = Engine_Api::_()->getApi('settings', 'core')->getSetting('seschristmas.showviewmore', 2);

    $friendids = $viewer->membership()->getMembershipsOfIds();
    $this->view->friendcount = count($friendids);

    $christmasTable = Engine_Api::_()->getDbtable('christmas', 'seschristmas');
    $this->view->has_wish = $christmasTable->getWish(array('owner_id' => $viewer_id));
    $this->view->viewmore = $this->_getParam('viewmore', 0);
    $this->view->count = 0;

    if ($this->view->friendcount > 0) {
      $select = $christmasTable->getFriendWishs(array('friend_ids' => $friendids));
      $this->view->paginator = $paginator = Zend_Paginator::factory($select);
      $paginator->setItemCountPerPage($limit);
      $paginator->setCurrentPageNumber($this->_getParam('page', 1));
      $this->view->count = $paginator->getTotalItemCount();
    }

    // Render
    if (!$this->view->viewmore) {
      $this->_helper->content->setEnabled();
    }
  }

  public function wishesAction() {

    $this->view->owner_id = Engine_Api::_()->core()->getSubject()->getIdentity();

    $wish = Engine_Api::_()->getApi('settings', 'core')->getSetting('seschristmas.wish', 1);
    if (empty($wish)) {
      $this->_forward('requiresubject', 'error', 'core');
      return;
    }

    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer_id = $viewer->getIdentity();
    $limit = Engine_Api::_()->getApi('settings', 'core')->getSetting('seschristmas.wisheslimit', 10);
    $this->view->showviewmore = Engine_Api::_()->getApi('settings', 'core')->getSetting('seschristmas.showviewmore', 2);

    $christmasTable = Engine_Api::_()->getDbtable('christmas', 'seschristmas');
    $this->view->has_wish = $christmasTable->getWish(array('owner_id' => $viewer_id));
    $select = $christmasTable->getAllWishs();

    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    $this->view->viewmore = $this->_getParam('viewmore', 0);
    $paginator->setItemCountPerPage($limit);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
    $this->view->count = $paginator->getTotalItemCount();

    // Render
    if (!$this->view->viewmore)
      $this->_helper->content->setEnabled();
  }

  public function createAction() {

    $christmasTable = Engine_Api::_()->getDbtable('christmas', 'seschristmas');
    $wish = Engine_Api::_()->getApi('settings', 'core')->getSetting('seschristmas.wish', 1);
    if (empty($wish)) {
      $this->_forward('requiresubject', 'error', 'core');
      return;
    }

    $viewer = Engine_Api::_()->user()->getViewer();
    $viewer_id = $viewer->getIdentity();
    if (empty($viewer_id)) {
      $this->_forward('requiresubject', 'error', 'core');
      return;
    }

    $has_wish = $christmasTable->getWish(array('owner_id' => $viewer_id));
    if (!empty($has_wish)) {
      $this->_forward('requiresubject', 'error', 'core');
      return;
    }

    $this->view->form = $form = new Seschristmas_Form_Create();

    if (!$this->getRequest()->isPost()) {
      return;
    }

    if (!$form->isValid($this->getRequest()->getPost())) {
      return;
    }


    $db = $christmasTable->getAdapter();
    $db->beginTransaction();

    try {

      $values = $form->getValues();
      $christmas = $christmasTable->createRow();
      $values['owner_id'] = $viewer->getIdentity();
      $christmas->setFromArray($values);
      $christmas->save();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }


    if ($this->_getParam('widget') == 1) {
      return $this->_forward('success', 'utility', 'core', array(
                  'messages' => array(Zend_Registry::get('Zend_Translate')->_('Your wish has been successfully saved.')),
                  'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'wishes'), 'seschristmas_general', true),
                  'layout' => 'default-simple',
                  'parentRefresh' => true,
      ));
    } else {
      return $this->_forward('success', 'utility', 'core', array(
                  'messages' => array(Zend_Registry::get('Zend_Translate')->_('Your wish has been successfully saved.')),
                  'layout' => 'default-simple',
                  'parentRefresh' => true,
      ));
    }
  }

  public function editAction() {

    $wish = Engine_Api::_()->getApi('settings', 'core')->getSetting('seschristmas.wish', 1);
    if (empty($wish)) {
      $this->_forward('requiresubject', 'error', 'core');
      return;
    }

    $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
    if (empty($viewer_id)) {
      $this->_forward('requiresubject', 'error', 'core');
      return;
    }

    $christmas = Engine_Api::_()->getItem('seschristmas_christmas', $this->_getParam('christmas_id'));

    $this->view->form = $form = new Seschristmas_Form_Edit();

    $form->populate($christmas->toArray());

    if (!$this->getRequest()->isPost()) {
      return;
    }
    if (!$form->isValid($this->getRequest()->getPost())) {
      return;
    }

    $db = $christmas->getTable()->getAdapter();
    $db->beginTransaction();

    try {
      $values = $form->getValues();
      $christmas->setFromArray($values);
      $christmas->save();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }

    if ($this->_getParam('widget') == 1) {
      return $this->_forward('success', 'utility', 'core', array(
                  'messages' => array(Zend_Registry::get('Zend_Translate')->_('Your changes have been saved.')),
                  'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'wishes'), 'seschristmas_general', true),
                  'layout' => 'default-simple',
                  'parentRefresh' => true,
      ));
    } else {
      return $this->_forward('success', 'utility', 'core', array(
                  'messages' => array(Zend_Registry::get('Zend_Translate')->_('Your changes have been saved.')),
                  'layout' => 'default-simple',
                  'parentRefresh' => true,
      ));
    }
  }

  public function deleteAction() {

    $wish = Engine_Api::_()->getApi('settings', 'core')->getSetting('seschristmas.wish', 1);
    if (empty($wish)) {
      $this->_forward('requiresubject', 'error', 'core');
      return;
    }

    $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
    if (empty($viewer_id)) {
      $this->_forward('requiresubject', 'error', 'core');
      return;
    }

    // In smoothbox
    $this->_helper->layout->setLayout('default-simple');

    $christmas = Engine_Api::_()->getItem('seschristmas_christmas', $this->_getParam('christmas_id'));
    $this->view->form = $form = new Seschristmas_Form_Delete();
    if (!$christmas) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_("Wish doesn't exist or not authorized to delete.");
      return;
    }

    if (!$this->getRequest()->isPost()) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method.');
      return;
    }

    $db = $christmas->getTable()->getAdapter();
    $db->beginTransaction();

    try {
      $christmas->delete();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    $this->view->message = Zend_Registry::get('Zend_Translate')->_('Your wish has been deleted.');
    return $this->_forward('success', 'utility', 'core', array('parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'wishes'), 'seschristmas_general', true), 'messages' => Array($this->view->message)
    ));
  }

}
