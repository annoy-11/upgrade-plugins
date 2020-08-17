<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sestwitterclone
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2019-06-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Sestwitterclone_Widget_SearchController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewerId = $viewer->getIdentity();

    $values = array();
    $values['enabled'] = 1;
    $values['limit'] = Engine_Api::_()->getApi('settings', 'core')->getSetting('sestwitterclone.search.limit', '8');
    $availableTypes = Engine_Api::_()->getDbTable('managesearchoptions', 'sestwitterclone')->getAllSearchOptions($values);
    $options = array();
    if (count($availableTypes) > 0) {
      foreach ($availableTypes as $index => $type) {
        $options[$type->type] = strtoupper('ITEM_TYPE_' . $type->type) . '_type_info_' . $type->file_id . '_type_info_' . $type->title;
      }
    }
    $this->view->types = array_merge(array('Everywhere' => 'Everywhere_type_info_'), $options);
  }
}
