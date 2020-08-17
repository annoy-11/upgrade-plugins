<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Endorsements.php  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesprofilefield_Model_DbTable_Endorsements extends Engine_Db_Table
{
  protected $_rowClass = "Sesprofilefield_Model_Endorsement";
  protected $_custom = false;

  public function __construct($config = array())
  {
    if( get_class($this) !== 'Sesprofilefield_Model_DbTable_Endorsements' ) {
      $this->_custom = true;
    }

    parent::__construct($config);
  }

  public function getEndorsmentTable()
  {
    return $this;
  }

  public function addEndorsment(Core_Model_Item_Abstract $resource, Core_Model_Item_Abstract $poster)
  {
    $row = $this->getEndorsment($resource, $poster);
    if( null !== $row )
    {
      throw new Core_Model_Exception('Already Endorsment');
    }

    $table = $this->getEndorsmentTable();
    $row = $table->createRow();

    if( isset($row->resource_type) )
    {
      $row->resource_type = $resource->getType();
    }

    $row->resource_id = $resource->getIdentity();
    $row->poster_type = $poster->getType();
    $row->poster_id = $poster->getIdentity();
    $row->save();

    if( isset($resource->skill_count) )
    {
      $resource->skill_count++;
      $resource->save();
    }

    return $row;
  }

  public function removehasEndorsment(Core_Model_Item_Abstract $resource, Core_Model_Item_Abstract $poster)
  {
    $row = $this->getEndorsment($resource, $poster);
    if( null === $row )
    {
      throw new Core_Model_Exception('No endorsement to remove');
    }

    $row->delete();

    if( isset($resource->skill_count) )
    {
      $resource->skill_count--;
      $resource->save();
    }

    return $this;
  }

  public function isEndorsment(Core_Model_Item_Abstract $resource, Core_Model_Item_Abstract $poster)
  {
    return ( null !== $this->getEndorsment($resource, $poster) );
  }

  public function getEndorsment(Core_Model_Item_Abstract $resource, Core_Model_Item_Abstract $poster)
  {
    $table = $this->getEndorsmentTable();
    $select = $this->getEndorsmentSelect($resource)
      ->where('poster_type = ?', $poster->getType())
      ->where('poster_id = ?', $poster->getIdentity())
      ->limit(1);

    return $table->fetchRow($select);
  }

  public function getEndorsmentSelect(Core_Model_Item_Abstract $resource)
  {
    $select = $this->getEndorsmentTable()->select();

    if( !$this->_custom )
    {
      $select->where('resource_type = ?', $resource->getType());
    }

    $select
      ->where('resource_id = ?', $resource->getIdentity())
      ->order('endorsement_id ASC');

    return $select;
  }

  public function getEndorsmentPaginator(Core_Model_Item_Abstract $resource)
  { 
    $paginator = Zend_Paginator::factory($this->getEndorsmentSelect($resource));
    $paginator->setItemCountPerPage(3);
    $paginator->count();
    $pages = $paginator->getPageRange();
    $paginator->setCurrentPageNumber($pages);
    return $paginator;
  }

  public function getEndorsmentCount(Core_Model_Item_Abstract $resource)
  {
    if( isset($resource->skill_count) )
    {
      return $resource->skill_count;
    }

    $select = new Zend_Db_Select($this->getEndorsmentTable()->getAdapter());
    $select
      ->from($this->getEndorsmentTable()->info('name'), new Zend_Db_Expr('COUNT(1) as count'));

    if( !$this->_custom )
    {
      $select->where('resource_type = ?', $resource->getType());
    }

    $select->where('resource_id = ?', $resource->getIdentity());

    $data = $select->query()->fetchAll();
    return (int) $data[0]['count'];
  }
}