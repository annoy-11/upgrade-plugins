<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprayer
 * @package    Sesprayer
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Recentlyviewitems.php  2017-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesprayer_Model_DbTable_Recentlyviewitems extends Engine_Db_Table {

  protected $_name = 'sesprayer_recentlyviewitems';
  protected $_rowClass = 'Sesprayer_Model_Recentlyviewitem';

  public function getitem($params = array()) {

    $prayerTableName = Engine_Api::_()->getItemTable('sesprayer_prayer')->info('name');

    $select = $this->select()
            ->setIntegrityCheck(false)
            ->from($this->info('name'), array('*'))
            ->where('resource_type = ?', 'sesprayer_prayer')
            ->order('creation_date DESC')
            ->limit($params['limit']);

    if ($params['criteria'] == 'by_me') {
      $select->where($this->info('name') . '.owner_id =?', Engine_Api::_()->user()->getViewer()->getIdentity());
    } else if ($params['criteria'] == 'by_myfriend') {
      /* friends array */
      $friendIds = Engine_Api::_()->user()->getViewer()->membership()->getMembershipsOfIds();
      if (count($friendIds) == 0)
        return array();
      $select->where($this->info('name') . ".owner_id IN ('" . implode(',', $friendIds) . "')");
    }
    $select->joinLeft($prayerTableName, $prayerTableName . ".prayer_id =  " . $this->info('name') . '.resource_id', null);
    return $this->fetchAll($select);
  }
}