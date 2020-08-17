<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmaterial
 * @package    Sesmaterial
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2018-07-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Sesmaterial_Widget_SearchController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $values = array();
    $values['enabled'] = 1;
    $values['limit'] = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmaterial.search.limit', '8');
    $availableTypes = Engine_Api::_()->getDbTable('managesearchoptions', 'sesmaterial')->getAllSearchOptions($values);
    $options = array();
    if (count($availableTypes) > 0) {
      foreach ($availableTypes as $index => $type) {
        $options[$type->type] = strtoupper('ITEM_TYPE_' . $type->type) . '_type_info_' . $type->file_id . '_type_info_' . $type->title;
      }
    }
    $sesmaterial_widget = Zend_Registry::isRegistered('sesmaterial_widget') ? Zend_Registry::get('sesmaterial_widget') : null;
    if(empty($sesmaterial_widget)) {
      return $this->setNoRender();
    }
    $this->view->types = array_merge(array('Everywhere' => 'Everywhere_type_info_'), $options);
  }

}
