<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Recentlyviewitems.php  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
class Sesqa_Model_DbTable_Recentlyviewitems extends Engine_Db_Table {
  
  protected $_name = 'sesqa_recentlyviewitems';
  protected $_rowClass = 'Sesqa_Model_Recentlyviewitem';
  
  public function getitem($params = array()) {
    $itemTable = Engine_Api::_()->getItemTable('sesqa_question');
    $itemTableName = $itemTable->info('name');
    $fieldName = 'question_id';
		$subquery = $this->select()->from($this->info('name'),array('*','MAX(creation_date) as maxcreadate'))->group($this->info('name').".resource_id")->order($this->info('name').".resource_id DESC");		
   
    if ($params['criteria'] == 'by_me') {
      $subquery->where($this->info('name') . '.owner_id =?', Engine_Api::_()->user()->getViewer()->getIdentity());
    } else if ($params['criteria'] == 'by_myfriend') {
      /* friends array */
      $friendIds = Engine_Api::_()->user()->getViewer()->membership()->getMembershipsOfIds();
      if (count($friendIds) == 0)
        return array();
      $subquery->where($this->info('name') . ".owner_id IN ('" . implode(',', $friendIds) . "')");
    }

   $select = $this->select()
            ->setIntegrityCheck(false)
            ->from(array('engine4_sesqa_recentlyviewitems' => $subquery))
            ->order('maxcreadate DESC')
            ->group($this->info('name') . '.resource_id')
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
    $select->joinLeft($itemTableName, $itemTableName . ".$fieldName =  " . $this->info('name') . '.resource_id', array('*'));
		$select->where($itemTableName.'.'.$fieldName.' != ?','');
    if(!empty($params['category_id']))
      $select->where($itemTableName.'.category_id=?',$params['category_id']);
     
    $select->where('search =?',1);
    $select->where('draft =?',1);
    return $this->fetchAll($select);
  }
}
