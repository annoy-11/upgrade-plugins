<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslisting
 * @package    Seslisting
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Categorymappings.php  2019-04-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslisting_Model_DbTable_Categorymappings extends Engine_Db_Table {

  protected $_rowClass = 'Seslisting_Model_Categorymapping';

  public function isCategoryMapped($params = array()) {

    $select = $this->select()
            ->from($this->info('name'), $params['column_name']);

    if (isset($params['category_id']))
      $select->where('category_id = ?', $params['category_id']);

    return $select = $select->query()->fetchColumn();
  }

}
