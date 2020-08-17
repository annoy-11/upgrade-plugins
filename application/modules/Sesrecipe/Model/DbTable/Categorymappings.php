<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecipe
 * @package    Sesrecipe
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Categorymappings.php 2018-05-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesrecipe_Model_DbTable_Categorymappings extends Engine_Db_Table {

  protected $_rowClass = 'Sesrecipe_Model_Categorymapping';

  public function isCategoryMapped($params = array()) {

    $select = $this->select()
            ->from($this->info('name'), $params['column_name']);

    if (isset($params['category_id']))
      $select->where('category_id = ?', $params['category_id']);

    return $select = $select->query()->fetchColumn();
  }

}
