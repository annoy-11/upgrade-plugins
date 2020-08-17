<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesteam
 * @package    Sesteam
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php 2015-02-20 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesteam_IndexController extends Core_Controller_Action_Standard {

  public function teamAction() {
    //Render
    $this->_helper->content->setEnabled();
  }

  public function browseAction() {
    //Render
    $this->_helper->content->setEnabled();
  }

  public function nonsiteteamAction() {
    //Render
    $this->_helper->content->setEnabled();
  }

  public function browsenonsiteteamAction() {
    //Render
    $this->_helper->content->setEnabled();
  }

  public function viewAction() {
    //Render
    $this->_helper->content->setEnabled();
  }

  public function searchAction() {

    $data = array();
    $table = Engine_Api::_()->getDbtable('teams', 'sesteam');
    $select = $table->select()
            ->where('name  LIKE ? ', '%' . $this->_getParam('text') . '%')
            ->where('type  = ? ', $this->_getParam('commonsearch'))
            ->where('enabled  = ? ', 1)
            ->order('name ASC')
            ->limit('40');
    $users = $table->fetchAll($select);
    foreach ($users as $user) {
      $data[] = array(
          'id' => $user->team_id,
          'label' => $user->name,
      );
    }
    return $this->_helper->json($data);
  }

  //Browse Members Page
  public function browseMembersAction() {

    $tableContent = Engine_Api::_()->getDbtable('content', 'core');
    $tableContentName = $tableContent->info('name');
    $db = Engine_Db_Table::getDefaultAdapter();
    $page_id = $db->select()
            ->from('engine4_core_pages', 'page_id')
            ->where('name = ?', 'sesteam_index_browse-members')
            ->limit(1)
            ->query()
            ->fetchColumn();
    $params = $tableContent->select()
            ->from($tableContentName, array('params'))
            ->where('page_id = ?', $page_id)
            ->where('name = ?', 'sesteam.browse-members')
            ->query()
            ->fetchColumn();

    if (!empty($params)) {
      $params = Zend_Json_Decoder::decode($params);
      $this->view->height = $params['height'];
      $this->view->width = $params['width'];
      $this->view->center_block = $params['center_block'];
      $this->view->viewMoreText = $params['viewMoreText'];
      $this->view->profileFieldCount = $params['profileFieldCount'];
      $this->view->labelBold = $params['labelBold'];
      $limitMembers = $params['limitMembers'];
      $popularity = $params['popularity'];
      $this->view->age = $params['age'];
      $this->view->content_show = $params['sesteam_contentshow'];
      $this->view->template_settings = $params['sesteam_template'];
      $this->view->sesteam_social_border = $params['sesteam_social_border'];
    }

    $require_check = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.general.browse', 1);
    if (!$require_check) {
      if (!$this->_helper->requireUser()->isValid())
        return;
    }
    if (!$this->_executeSearch($limitMembers, $popularity)) {
      // throw new Exception('error');
    }

    if ($this->_getParam('ajax')) {
      $this->renderScript('_browseUsers.tpl');
    }

    if (!$this->_getParam('ajax')) {
      // Render
      $this->_helper->content->setEnabled();
    }
  }

  protected function _executeSearch($limitMembers, $popularity) {

    // Check form
    $form = new User_Form_Search(array(
        'type' => 'user'
    ));

    if (!$form->isValid($this->_getAllParams())) {
      $this->view->error = true;
      $this->view->totalUsers = 0;
      $this->view->userCount = 0;
      $this->view->page = 1;
      return false;
    }

    $this->view->form = $form;

    // Get search params
    $page = (int) $this->_getParam('page', 1);
    $ajax = (bool) $this->_getParam('ajax', false);
    $options = $form->getValues();

    // Process options
    $tmp = array();
    $originalOptions = $options;
    foreach ($options as $k => $v) {
      if (null == $v || '' == $v || (is_array($v) && count(array_filter($v)) == 0)) {
        continue;
      } else if (false !== strpos($k, '_field_')) {
        list($null, $field) = explode('_field_', $k);
        $tmp['field_' . $field] = $v;
      } else if (false !== strpos($k, '_alias_')) {
        list($null, $alias) = explode('_alias_', $k);
        $tmp[$alias] = $v;
      } else {
        $tmp[$k] = $v;
      }
    }
    $options = $tmp;

    // Get table info
    $table = Engine_Api::_()->getItemTable('user');
    $userTableName = $table->info('name');

    $searchTable = Engine_Api::_()->fields()->getTable('user', 'search');
    $searchTableName = $searchTable->info('name');

    //extract($options); // displayname
    $profile_type = @$options['profile_type'];
    $displayname = @$options['displayname'];
    if (!empty($options['extra'])) {
      extract($options['extra']); // is_online, has_photo, submit
    }

    // Contruct query
    $select = $table->select()
            //->setIntegrityCheck(false)
            ->from($userTableName)
            ->joinLeft($searchTableName, "`{$searchTableName}`.`item_id` = `{$userTableName}`.`user_id`", null)
            //->group("{$userTableName}.user_id")
            ->where("{$userTableName}.search = ?", 1)
            ->where("{$userTableName}.enabled = ?", 1);

    $searchDefault = true;

    // Build the photo and is online part of query
    if (isset($has_photo) && !empty($has_photo)) {
      $select->where($userTableName . '.photo_id != ?', "0");
      $searchDefault = false;
    }

    if (isset($is_online) && !empty($is_online)) {
      $select
              ->joinRight("engine4_user_online", "engine4_user_online.user_id = `{$userTableName}`.user_id", null)
              ->group("engine4_user_online.user_id")
              ->where($userTableName . '.user_id != ?', "0");
      $searchDefault = false;
    }

    // Add displayname
    if (!empty($displayname)) {
      $select->where("(`{$userTableName}`.`username` LIKE ? || `{$userTableName}`.`displayname` LIKE ?)", "%{$displayname}%");
      $searchDefault = false;
    }

    // Build search part of query
    $searchParts = Engine_Api::_()->fields()->getSearchQuery('user', $options);
    foreach ($searchParts as $k => $v) {
      $select->where("`{$searchTableName}`.{$k}", $v);

      if (isset($v) && $v != "") {
        $searchDefault = false;
      }
    }

//    if ($searchDefault) {
//      $select->order("{$userTableName}.lastlogin_date DESC");
//    } else {
//      $select->order("{$userTableName}.displayname ASC");
//    }

    if ($popularity == 'creation_date') {
      $select->order("{$userTableName}.creation_date DESC");
    } elseif ($popularity == 'modified_date') {
      $select->order("{$userTableName}.modified_date DESC");
    } elseif ($popularity == 'alphabetic') {
      $select->order("{$userTableName}.displayname ASC");
    }

    // Build paginator
    $paginator = Zend_Paginator::factory($select);
    $paginator->setItemCountPerPage($limitMembers);
    $paginator->setCurrentPageNumber($page);

    $this->view->page = $page;
    $this->view->ajax = $ajax;
    $this->view->users = $paginator;
    $this->view->totalUsers = $paginator->getTotalItemCount();
    $this->view->userCount = $paginator->getCurrentItemCount();
    $this->view->topLevelId = $form->getTopLevelId();
    $this->view->topLevelValue = $form->getTopLevelValue();
    $this->view->formValues = array_filter($originalOptions);

    return true;
  }

}