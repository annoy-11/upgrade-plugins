<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Cpnysubscribes.php  2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesjob_Model_DbTable_Cpnysubscribes extends Engine_Db_Table {

  protected $_rowClass = "Sesjob_Model_Cpnysubscribe";

  public function isCpnysubscribe($params = array()) {

    $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
    return $this->select()
                    ->where('resource_type = ?', $params['resource_type'])
                    ->where('resource_id = ?', $params['resource_id'])
                    ->where('poster_id = ?', $viewer_id)
                    ->query()
                    ->fetchColumn();
  }

  public function getItemfav($resource_type, $itemId) {
    $tableFav = Engine_Api::_()->getDbtable('cpnysubscribes', 'sesjob');
    $tableMainFav = $tableFav->info('name');
    $select = $tableFav->select()->from($tableMainFav)->where('resource_type =?', $resource_type)->where('poster_id =?', Engine_Api::_()->user()->getViewer()->getIdentity())->where('resource_id =?', $itemId);
    return $tableFav->fetchRow($select);
  }

  public function getCpnysubscribeSelect(Core_Model_Item_Abstract $resource) {

    return $this->select()
                    ->where('resource_type = ?', $resource->getType())
                    ->where('resource_id = ?', $resource->getIdentity())
                    ->order('cpnysubscribe_id ASC');
  }

  public function getCpnysubscribe(Core_Model_Item_Abstract $resource, Core_Model_Item_Abstract $poster) {

    $select = $this->getCpnysubscribeSelect($resource)
            ->where('poster_id = ?', $poster->getIdentity())
            ->limit(1);
    return $this->fetchRow($select);
  }

  public function addCpnysubscribe(Core_Model_Item_Abstract $resource, Core_Model_Item_Abstract $poster) {

    $row = $this->getCpnysubscribe($resource, $poster);
    if (null !== $row)
      throw new Core_Model_Exception('Already subscribe.');

    $row = $this->createRow();
    if (isset($row->resource_type))
      $row->resource_type = $resource->getType();
    $row->resource_id = $resource->getIdentity();
    $row->poster_id = $poster->getIdentity();
    $row->save();
    if (isset($resource->subscribe_count)) {
      $resource->subscribe_count++;
      $resource->save();
    }
    return $row;
  }

  public function removeCpnysubscribe(Core_Model_Item_Abstract $resource, Core_Model_Item_Abstract $poster) {

    $row = $this->getCpnysubscribe($resource, $poster);
    if (null === $row)
      throw new Core_Model_Exception('No subscribe to remove');

    $row->delete();
    if (isset($resource->subscribe_count)) {
      $resource->subscribe_count--;
      $resource->save();
    }
    return $this;
  }

  public function getAllsubscribes($params = array()) {
    $select = $this->select()
            ->from($this->info('name'))
            ->where('resource_id =?', $params['resource_id']);
    return $this->fetchAll($select);
  }

  public function getCpnysubscribes($params = array()) {

    $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
    $select = $this->select()
            ->from($this->info('name'))
            ->where('resource_type =?', $params['resource_type'])
            ->where('poster_id =?', $viewer_id);
    return Zend_Paginator::factory($select);
  }

}
