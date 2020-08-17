<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessocialtube
 * @package    Sessocialtube
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Sessocialtube_Widget_SearchController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $values = array();
    $values['enabled'] = 1;
    $values['limit'] = Engine_Api::_()->getApi('settings', 'core')->getSetting('sessocialtube.search.limit', '8');
    $availableTypes = Engine_Api::_()->getDbTable('managesearchoptions', 'sessocialtube')->getAllSearchOptions($values);
    if (count($availableTypes) > 0) {
      $options = array();
      foreach ($availableTypes as $index => $type) {
        $options[$type->type] = strtoupper('ITEM_TYPE_' . $type->type) . '_type_info_' . $type->file_id . '_type_info_' . $type->title;
      }
    }
    $this->view->types = array_merge(array('Everywhere' => 'Everywhere_type_info_'), $options);
  }

}
