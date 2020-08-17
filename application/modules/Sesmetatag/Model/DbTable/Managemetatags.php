<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmetatag
 * @package    Sesmetatag
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Managemetatags.php 2017-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesmetatag_Model_DbTable_Managemetatags extends Engine_Db_Table {

  protected $_rowClass = 'Sesmetatag_Model_Managemetatag';

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