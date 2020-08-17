<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageController.php 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagebuilder_AdminManageController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')
            ->getNavigation('sespagebuilder_admin_main', array(), 'sespagebuilder_admin_main_manage');

    $this->view->pages = Engine_Api::_()->getItemTable('sespagebuilder_pagebuilder')->getFixedpages();

    $languageList = Zend_Registry::get('Zend_Translate')->getList();
    $db = Engine_Db_Table::getDefaultAdapter();
    foreach ($languageList as $language) {
      if ($language == 'en')
        continue;
      $coulmnName = $language . '_body';
      $column = $db->query("SHOW COLUMNS FROM engine4_sespagebuilder_pagebuilders LIKE '$coulmnName'")->fetch();
      if (empty($column)) {
        $db->query("ALTER TABLE `engine4_sespagebuilder_pagebuilders` ADD $coulmnName LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `body`");
      }
    }
  }

  public function createAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')
            ->getNavigation('sespagebuilder_admin_main', array(), 'sespagebuilder_admin_main_manage');

    $this->view->form = $form = new Sespagebuilder_Form_Admin_Manage_Create();

    // If not post or form not valid, return
    if (!$this->getRequest()->isPost())
      return;

    if (!$form->isValid($this->getRequest()->getPost()))
      return;

    // Process
    $pagebuilderTable = Engine_Api::_()->getItemTable('sespagebuilder_pagebuilder');
    $values = $form->getValues();

    $menuTitle = addslashes($_POST['title']);
    $bannedFixedpageUrlTable = Engine_Api::_()->getDbtable('bannedwords', 'sespagebuilder');
    $bannedWordsNew = preg_split('/\s*[,\n]+\s*/', $values['pagebuilder_url']);
    $isExistWord = $bannedFixedpageUrlTable->isWordBanned($values['pagebuilder_url']);
    if ($isExistWord)
      return $form->addError('Please select another Fixed Page URL
, it is already exist.');

    if (!preg_match('/^[a-z][a-z0-9-_]*$/i', $values['pagebuilder_url']))
      return $form->addError('Special characters are not allowed in the URL.');

    $db = Engine_Db_Table::getDefaultAdapter();
    $db = $pagebuilderTable->getAdapter();
    $db->beginTransaction();

    try {
      $fixedPage = $pagebuilderTable->createRow();

      $topStructure = Engine_Api::_()->fields()->getFieldStructureTop('user');
      if ($topStructure[0]->getChild()->type == 'profile_type') {
        $profileTypeField = $topStructure[0]->getChild();
        $options = $profileTypeField->getOptions();

        $options = $profileTypeField->getElementParams('user');
        unset($options['options']['order']);
        unset($options['options']['multiOptions']['']);
        foreach ($options['options']['multiOptions'] as $key => $option) {
          $optionValues[] = $key;
        }
      }
      if (@$values['profile_types'])
        $values['profile_types'] = json_encode($values['profile_types']);
      else
        $values['profile_types'] = json_encode($optionValues);

      $networkValues = array();
      foreach (Engine_Api::_()->getDbtable('networks', 'network')->fetchAll() as $network) {
        $networkValues[] = $network->network_id;
      }
      if (@$values['networks'])
        $values['networks'] = json_encode($values['networks']);
      else
        $values['networks'] = json_encode($networkValues);
      $values['member_levels'] = json_encode($values['member_levels']);
      $fixedPage->setFromArray($values);
      $fixedPage->save();
      $pagebuilderId = $fixedPage->pagebuilder_id;
      $page_id = Engine_Api::_()->sespagebuilder()->checkPage('sespagebuilder_index_' . $pagebuilderId, $menuTitle);
      $fixedPage->page_id = $page_id;
      $fixedPage->save();
      $routeName = 'sespagebuilder_index_' . $pagebuilderId;
      $menuName = 'core_main_sespagebuilder_' . $pagebuilderId;

      if ($_POST['show_menu'] == 0) {
        $db->query("INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
              ('" . $menuName . "', 'sespagebuilder', '" . $menuTitle . "', 'Sespagebuilder_Plugin_Menus::canViewFixedpage', '{\"route\":\"$routeName\", \"pagebuilder_id\":\"$pagebuilderId\"}', 'core_mini', '', 999)");
      } else if ($_POST['show_menu'] == 1) {
        $db->query("INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
              ('" . $menuName . "', 'sespagebuilder', '" . $menuTitle . "', 'Sespagebuilder_Plugin_Menus::canViewFixedpage', '{\"route\":\"$routeName\", \"pagebuilder_id\":\"$pagebuilderId\"}', 'core_main', '', 999)");
      } else if ($_POST['show_menu'] == 2) {
        $db->query("INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
              ('" . $menuName . "', 'sespagebuilder', '" . $menuTitle . "', 'Sespagebuilder_Plugin_Menus::canViewFixedpage', '{\"route\":\"$routeName\", \"pagebuilder_id\":\"$pagebuilderId\"}', 'core_footer', '', 999)");
      }
      
      if($values['search']) {
        $db->query('INSERT IGNORE INTO `engine4_core_search` (`type`, `id`, `title`, `description`, `keywords`, `hidden`) VALUES ("sespagebuilder_pagebuilder", "'.$pagebuilderId.'", "'.$values['html_title'].'", "'.$values['description'].'", "'.$values['html_keywords'].'", "");');
      }

      // Commit
      $db->commit();
      $bannedFixedpageUrlTable->setWords($bannedWordsNew);

      Engine_Api::_()->getDbTable('pages', 'core')->update(array(
          'title' => $_POST['html_title'],
          'description' => $_POST['description'],
          'keywords' => $_POST['html_keywords'],
          'search' => $_POST['search'],
              ), array(
          'page_id = ?' => $page_id,
      ));

      if (isset($_POST['save']))
        return $this->_helper->redirector->gotoRoute(array('action' => 'edit', 'id' => $pagebuilderId));
      else
        return $this->_helper->redirector->gotoRoute(array('action' => 'index'));
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
  }

  public function editAction() {

    $this->view->pagebuilder_id = $pagebuilderId = $this->_getParam('id');
    $fixedPage = Engine_Api::_()->getItem('sespagebuilder_pagebuilder', $pagebuilderId);

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')
            ->getNavigation('sespagebuilder_admin_main', array(), 'sespagebuilder_admin_main_manage');

    $this->view->form = $form = new Sespagebuilder_Form_Admin_Manage_Edit();
    $page_id = Engine_Api::_()->sespagebuilder()->getWidgetizePageId($pagebuilderId);
    $widgetizePage = Engine_Api::_()->getItem('core_page', $page_id);
    $form->html_title->setValue($widgetizePage->title);
    $form->description->setValue($widgetizePage->description);
    $form->html_keywords->setValue($widgetizePage->keywords);
    $form->search->setValue($widgetizePage->search);

    $menuItemtable = Engine_Api::_()->getDbTable('MenuItems', 'core');
    $menuType = $menuItemtable->select()
            ->from($menuItemtable->info('name'), 'menu')
            ->where('name =?', "core_main_sespagebuilder_$pagebuilderId")
            ->query()
            ->fetchColumn();

    if ($menuType == 'core_mini')
      $form->show_menu->setValue('0');
    elseif ($menuType == 'core_main')
      $form->show_menu->setValue('1');
    elseif ($menuType == 'core_footer')
      $form->show_menu->setValue('2');
    else
      $form->show_menu->setValue('3');

    if (!$fixedPage->status)
      $form->removeElement('draft');

    $fixedPage['member_levels'] = json_decode($fixedPage['member_levels']);
    $fixedPage['networks'] = json_decode($fixedPage['networks']);
    $fixedPage['profile_types'] = json_decode($fixedPage['profile_types']);

    // Populate form
    $form->populate($fixedPage->toArray());

    // Check post/form
    if (!$this->getRequest()->isPost())
      return;

    if (!$form->isValid($this->getRequest()->getPost()))
      return;

    // Process
    $db = Engine_Db_Table::getDefaultAdapter();
    $db->beginTransaction();

    try {
      $values = $form->getValues();
      
        $bannedFixedpageUrlTable = Engine_Api::_()->getDbtable('bannedwords', 'sespagebuilder');
        $bannedWordsNew = preg_split('/\s*[,\n]+\s*/', $values['pagebuilder_url']);
        if($values['pagebuilder_url'] != $fixedPage->pagebuilder_url){
          $isExistWord = $bannedFixedpageUrlTable->isWordBanned($values['pagebuilder_url']);
          if ($isExistWord) {
            return $form->addError('Please select another Fixed Page URL, it is already exist.');
          }
        }
      

      $values['member_levels'] = json_encode($values['member_levels']);
      $networkValues = array();
      foreach (Engine_Api::_()->getDbtable('networks', 'network')->fetchAll() as $network) {
        $networkValues[] = $network->network_id;
      }
      if ($values['networks'])
        $values['networks'] = json_encode($values['networks']);
      else
        $values['networks'] = json_encode($networkValues);

      $topStructure = Engine_Api::_()->fields()->getFieldStructureTop('user');
      if ($topStructure[0]->getChild()->type == 'profile_type') {
        $profileTypeField = $topStructure[0]->getChild();
        $options = $profileTypeField->getOptions();
        $options = $profileTypeField->getElementParams('user');
        unset($options['options']['order']);
        unset($options['options']['multiOptions']['']);
        foreach ($options['options']['multiOptions'] as $key => $option) {
          $optionValues[] = $key;
        }
      }
      if ($values['profile_types'])
        $values['profile_types'] = json_encode($values['profile_types']);
      else
        $values['profile_types'] = json_encode($optionValues);
      $fixedPage->setFromArray($values);
      $fixedPage->modified_date = date('Y-m-d H:i:s');
      $fixedPage->save();
      
      //Menu Order
      $db = Engine_Db_Table::getDefaultAdapter();
      $select = new Zend_Db_Select($db);
      $menu = $select->from('engine4_core_menuitems')
              ->where('name = ?', "core_main_sespagebuilder_$pagebuilderId")
              ->query()
              ->fetchObject();
      $order = $menu->order;
      
      if (!empty($menuType))
        $menuItemtable->delete(array('name =?' => "core_main_sespagebuilder_$pagebuilderId"));

      $routeName = 'sespagebuilder_index_' . $pagebuilderId;
      $menuName = 'core_main_sespagebuilder_' . $pagebuilderId;

      $menuTitle = addslashes($_POST['title']);

      if ($_POST['show_menu'] == 1) {
        $db->query("INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
              ('" . $menuName . "', 'sespagebuilder', '" . $menuTitle . "', 'Sespagebuilder_Plugin_Menus::canViewFixedpage', '{\"route\":\"$routeName\", \"pagebuilder_id\":\"$pagebuilderId\"}', 'core_main', '', '".$order."')");
      } else if ($_POST['show_menu'] == 0) {
        $db->query("INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
              ('" . $menuName . "', 'sespagebuilder', '" . $menuTitle . "', 'Sespagebuilder_Plugin_Menus::canViewFixedpage', '{\"route\":\"$routeName\", \"pagebuilder_id\":\"$pagebuilderId\"}', 'core_mini', '', '".$order."')");
      } else if ($_POST['show_menu'] == 2) {
        $db->query("INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
              ('" . $menuName . "', 'sespagebuilder', '" . $menuTitle . "', 'Sespagebuilder_Plugin_Menus::canViewFixedpage', '{\"route\":\"$routeName\", \"pagebuilder_id\":\"$pagebuilderId\"}', 'core_footer', '', '".$order."')");
      }

      Engine_Api::_()->getDbTable('pages', 'core')->update(array(
          'title' => $_POST['html_title'],
          'displayname' => $_POST['title'],
          'description' => $_POST['description'],
          'keywords' => $_POST['html_keywords'],
          'search' => $_POST['search'],
              ), array(
          'page_id = ?' => $page_id,
      ));

      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }

    if (isset($_POST['save']))
      return $this->_helper->redirector->gotoRoute(array('action' => 'edit', 'id' => $pagebuilderId));
    else
      return $this->_helper->redirector->gotoRoute(array('action' => 'index'));
  }

  public function deleteAction() {

    $this->_helper->layout->setLayout('admin-simple');
    $this->view->pagebuilder_id = $id = $this->_getParam('id');

    $this->view->form = $form = new Sesbasic_Form_Admin_Delete();
    $form->setTitle('Delete This Page?');
    $form->setDescription('Are you sure that you want to delete this page entry? It will not be recoverable after being deleted.');
    $form->submit->setLabel('Delete');

    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();

      try {
        $fixedPage = Engine_Api::_()->getItem('sespagebuilder_pagebuilder', $id);
        $pageName = "sespagebuilder_index_$id";
        if (!empty($pageName)) {

          $page_id = $db->select()
                  ->from('engine4_core_pages', 'page_id')
                  ->where('name = ?', $pageName)
                  ->limit(1)
                  ->query()
                  ->fetchColumn();
          Engine_Api::_()->getDbTable('content', 'core')->delete(array('page_id =?' => $page_id));
          Engine_Api::_()->getDbTable('pages', 'core')->delete(array('page_id =?' => $page_id));
        }

        Engine_Api::_()->getDbtable('menuItems', 'core')->delete(array('name =?' => 'core_main_sespagebuilder_' . $id));
        $pageUrl = $fixedPage->pagebuilder_url;
        Engine_Api::_()->getDbTable('bannedwords', 'sespagebuilder')->delete(array('word LIKE ?' => '%'.$pageUrl.'%'));
        $fixedPage->delete();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }

      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('You have been deleted row successfully.')
      ));
    }
  }

  public function checkurlAction() {

    $data = array();
    $url = $this->_getParam('pagebuilder_url');
    $pagebuilderId = $this->_getParam('pagebuilder_id');
    if ($pagebuilderId) {
      $fixedPage = Engine_Api::_()->getItem('sespagebuilder_pagebuilder', $pagebuilderId);
      if ($fixedPage->pagebuilder_url == $url) {
        $data[] = array('error' => '');
        return $this->_helper->json($data);
      }
    }

    if (empty($url))
      $error = 'Url can not be left empty, please enter a URL.';
    else {
      $bannedFixedpageUrlTable = Engine_Api::_()->getDbtable('bannedwords', 'sespagebuilder');
      $isExistWord = $bannedFixedpageUrlTable->isWordBanned($url);
      if ($isExistWord)
        $error = 'Please select another Fixed Page URL, it is already exist.';
      elseif (!preg_match('/^[a-z][a-z0-9-_]*$/i', $url))
        $error = 'Special characters are not allowed in the URL.';
      else
        $error = '';
    }
    $data[] = array('error' => $error);
    return $this->_helper->json($data);
  }

  public function enableAction() {

    $pagebuilderId = $this->_getParam('id');
    if (!empty($pagebuilderId)) {
      $page = Engine_Api::_()->getItem('sespagebuilder_pagebuilder', $pagebuilderId);
      $page->enable = !$page->enable;
      $page->save();
    }
    $this->_redirect('admin/sespagebuilder/manage');
  }

}
