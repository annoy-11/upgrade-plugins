<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Linkbusinesses.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesbusiness_Model_DbTable_Linkbusinesses extends Engine_Db_Table {

  protected $_rowClass = "Sesbusiness_Model_Linkbusiness";

  public function getLinkBusinessesPaginator($params = array()) {
    return Zend_Paginator::factory($this->getLinkBusinessSelect($params));
  }

  public function getLinkBusinessSelect($params = array()) {
    $businessTable = Engine_Api::_()->getDbTable('businesses', 'sesbusiness');
    $businessTableName = $businessTable->info('name');
    $linkbusinessTableName = $this->info('name');
    $select = $businessTable->select()->setIntegrityCheck(false);
    $select->from($businessTableName);
    $select->join($linkbusinessTableName, "$linkbusinessTableName.link_business_id = $businessTableName.business_id", 'active')
            ->where($linkbusinessTableName . '.business_id = ?', $params['business_id']);
    return $select;
  }

}
