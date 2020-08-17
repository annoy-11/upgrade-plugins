<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmaterial
 * @package    Sesmaterial
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Footerlinks.php 2018-07-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesmaterial_Model_DbTable_Footerlinks extends Engine_Db_Table {

  protected $_rowClass = "Sesmaterial_Model_Footerlink";

  public function getInfo($params = array()) {

    $socialTable = Engine_Api::_()->getDbTable('footerlinks', 'sesmaterial');
    $select = $socialTable->select()->order('footerlink_id ASC');

    if (isset($params['enabled']) && !empty($params['enabled'])) {
      $select = $select->where('enabled = ?', 1);
    }

    if (isset($params['sublink'])) {
      $select = $select->where('sublink = ?', $params['sublink']);
    }

    return $socialTable->fetchAll($select);
  }

  public function getFooterName($params = array()) {

    return $this->select()
                    ->from($this->info('name'), array('name'))
                    ->where('enabled = ?', 1)
                    ->where('footerlink_id =?', $params['footerlink_id'])
                    ->query()
                    ->fetchColumn();
  }

}
