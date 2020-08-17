<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesseo
 * @package    Sesseo
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Managemetatags.php  2019-03-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesseo_Model_DbTable_Managemetatags extends Engine_Db_Table {

  protected $_rowClass = 'Sesseo_Model_Managemetatag';

  public function getPageData($params = array()) {

    $select = $this->select()
            ->from($this->info('name'), array('*'))
            ->where('page_id = ?', $params['page_id'])
            ->where('enabled =?', 1)
            ->limit(1);
    return $this->fetchRow($select);
  }

  public function getAllPages($params = array()) {

    $results = $this->select()->query()->fetchAll();
    return $results;
  }
}
