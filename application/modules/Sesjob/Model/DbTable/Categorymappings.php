<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Categorymappings.php  2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesjob_Model_DbTable_Categorymappings extends Engine_Db_Table {

  protected $_rowClass = 'Sesjob_Model_Categorymapping';

  public function isCategoryMapped($params = array()) {

    $select = $this->select()
            ->from($this->info('name'), $params['column_name']);

    if (isset($params['category_id']))
      $select->where('category_id = ?', $params['category_id']);

    return $select = $select->query()->fetchColumn();
  }

}
