<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Einstaclone
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Controller.php 2019-12-30 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */


class Einstaclone_Widget_SearchController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewerId = $viewer->getIdentity();

    $values = array();
    $values['enabled'] = 1;
    $values['limit'] = Engine_Api::_()->getApi('settings', 'core')->getSetting('einstaclone.search.limit', '8');
    $availableTypes = Engine_Api::_()->getDbTable('managesearchoptions', 'einstaclone')->getAllSearchOptions($values);
    $options = array();
    if (count($availableTypes) > 0) {
      foreach ($availableTypes as $index => $type) {
        $options[$type->type] = strtoupper('ITEM_TYPE_' . $type->type) . '_type_info_' . $type->file_id . '_type_info_' . $type->title;
      }
    }
    $this->view->types = array_merge(array('Everywhere' => 'Everywhere_type_info_'), $options);
    $einstaclone_browse = Zend_Registry::isRegistered('einstaclone_browse') ? Zend_Registry::get('einstaclone_browse') : null;
    if(empty($einstaclone_browse))
      return $this->setNoRender();
    $this->view->searchleftoption = Engine_Api::_()->getApi('settings', 'core')->getSetting('einstaclone.searchleftoption', 1);
  }
}
