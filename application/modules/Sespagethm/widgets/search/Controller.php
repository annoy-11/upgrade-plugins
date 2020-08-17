<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagethm
 * @package    Sespagethm
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Sespagethm_Widget_SearchController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $values = array();
    $values['enabled'] = 1;
    $values['limit'] = Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagethm.search.limit', '8');
    $availableTypes = Engine_Api::_()->getDbTable('managesearchoptions', 'sespagethm')->getAllSearchOptions($values);
    $options = array();
    if (count($availableTypes) > 0) {
      foreach ($availableTypes as $index => $type) {
        $options[$type->type] = strtoupper('ITEM_TYPE_' . $type->type) . '_type_info_' . $type->file_id . '_type_info_' . $type->title;
      }
    }
    $sespagethm_widget = Zend_Registry::isRegistered('sespagethm_widget') ? Zend_Registry::get('sespagethm_widget') : null;
    if(empty($sespagethm_widget)) {
      return $this->setNoRender();
    }
    $this->view->types = array_merge(array('Everywhere' => 'Everywhere_type_info_'), $options);
  }

}
