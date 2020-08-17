<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessportz
 * @package    Sessportz
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-04-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Sessportz_Widget_SearchController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $values = array();
    $values['enabled'] = 1;
    $values['limit'] = Engine_Api::_()->getApi('settings', 'core')->getSetting('sessportz.search.limit', '8');
    $availableTypes = Engine_Api::_()->getDbTable('managesearchoptions', 'sessportz')->getAllSearchOptions($values);
    $options = array();
    if (count($availableTypes) > 0) {
      foreach ($availableTypes as $index => $type) {
        $options[$type->type] = strtoupper('ITEM_TYPE_' . $type->type) . '_type_info_' . $type->file_id . '_type_info_' . $type->title;
      }
    }
    $sessportz_widget = Zend_Registry::isRegistered('sessportz_widget') ? Zend_Registry::get('sessportz_widget') : null;
    if(empty($sessportz_widget)) {
      return $this->setNoRender();
    }
    $this->view->types = array_merge(array('Everywhere' => 'Everywhere_type_info_'), $options);
  }

}
