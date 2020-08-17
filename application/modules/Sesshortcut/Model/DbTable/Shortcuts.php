<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesshortcut
 * @package    Sesshortcut
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Shortcuts.php 2016-07-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesshortcut_Model_DbTable_Shortcuts extends Engine_Db_Table {

  protected $_rowClass = 'Sesshortcut_Model_Shortcut';
  protected $_name = 'sesshortcut_shortcuts';

  public function isShortcut($params = array()) {

    $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
    return $this->select()
                    ->where('resource_type = ?', $params['resource_type'])
                    ->where('resource_id = ?', $params['resource_id'])
                    ->where('poster_id = ?', $viewer_id)
                    ->query()
                    ->fetchColumn();
  }

  public function addShortcut(Core_Model_Item_Abstract $resource, Core_Model_Item_Abstract $poster) {

    $row = $this->getShortcut($resource, $poster);
    if (null !== $row)
      throw new Core_Model_Exception('Already liked');

    $row = $this->createRow();
    if (isset($row->resource_type))
      $row->resource_type = $resource->getType();

    $row->resource_id = $resource->getIdentity();
    $row->poster_id = $poster->getIdentity();
    $row->save();
    
    $row->order = $row->getIdentity();
    $row->save();
    return $row;
  }

  public function getShortcut(Core_Model_Item_Abstract $resource, Core_Model_Item_Abstract $poster) {

    $select = $this->getShortcutSelect($resource)
            ->where('poster_id = ?', $poster->getIdentity())
            ->limit(1);
    return $this->fetchRow($select);
  }

  public function getShortcutSelect(Core_Model_Item_Abstract $resource) {

    return $this->select()
                    ->where('resource_type = ?', $resource->getType())
                    ->where('resource_id = ?', $resource->getIdentity())
                    ->order('shortcut_id ASC');
  }

  public function getShortcutCount($params = array()) {

    $select = $this->select()
            ->from($this->info('name'), new Zend_Db_Expr('COUNT(1) as count'))
            ->where('resource_type = ?', $params['type'])
            ->where('poster_id = ?', $params['viewer_id']);
    $data = $select->query()->fetchAll();
    return (int) $data[0]['count'];
  }
  
  public function getShortcuts($poster_id) {
    $select = $this->select()->where('poster_id = ?', $poster_id)->order('order ASC');
    return $select->query()->fetchAll();
  }
}