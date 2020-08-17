<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesevent
 * @package    Sesevent
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Recentlyviewitems.php 2016-07-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesdocument_Model_DbTable_Recentlyviewitems extends Engine_Db_Table
{
	protected $_name = 'sesdocument_recentlyviewitems';
  protected $_rowClass = 'Sesdocument_Model_Recentlyviewitem';
	public function getitem($params = array()){
			$itemTable = Engine_Api::_()->getItemTable('sesdocument');
			$itemTableName = $itemTable->info('name');

		$subquery = $this->select()->from($this->info('name'),array('*','MAX(creation_date) as maxcreadate'))->group($this->info('name').".resource_id")->where($this->info('name').'.resource_type =?', $params['type']);
        if($params['criteria'] == 'by_me'){
			$subquery->where($this->info('name').'.owner_id =?',Engine_Api::_()->user()->getViewer()->getIdentity());
		}else if($params['criteria'] == 'by_myfriend'){
		/*friends array*/
			$friendIds = Engine_Api::_()->user()->getViewer()->membership()->getMembershipsOfIds();
			if(count($friendIds) == 0)
				return array();
			$subquery->where($this->info('name').".owner_id IN ('".implode(',',$friendIds)."')");
		}
		$select = $this->select()
                                ->from(array('engine4_sesdocument_recentlyviewitems' => $subquery))
                                ->where($this->info('name').'.resource_type = ?' ,$params['type'])
                                ->setIntegrityCheck(false)
                                ->joinLeft($itemTableName, $itemTableName . '.sesdocument_id = ' . $this->info('name') . '.resource_id', 'sesdocument_id')
                                ->order('maxcreadate DESC')
                                ->where($itemTableName.'.sesdocument_id != ?','')
                                ->group($this->info('name').'.resource_id');
        if(!empty($params['order'])) {
            $currentTime = date('Y-m-d H:i:s');
            $select->where("(endtime >= '".$currentTime."') || (endtime > '".$currentTime."' && starttime > '".$currentTime."')");
        }


		if(isset( $params['limit'])){
			$select->limit( $params['limit'])	;
		}
			return $this->fetchAll($select);
	}
}
