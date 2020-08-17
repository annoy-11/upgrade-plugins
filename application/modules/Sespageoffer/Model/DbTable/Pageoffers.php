<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespageoffer
 * @package    Sespageoffer
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Pageoffers.php  2019-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespageoffer_Model_DbTable_Pageoffers extends Core_Model_Item_DbTable_Abstract
{
  protected $_rowClass = "Sespageoffer_Model_Pageoffer";

  public function getOfTheDayResults() {

    $select = $this->select()
            ->from($this->info('name'), array('*'))
            ->where('offtheday =?', 1)
            ->where('startdate <= DATE(NOW())')
            ->where('enddate >= DATE(NOW())')
            ->order('RAND()')
            ->limit(1);
    return $this->fetchRow($select);
  }

  public function getOffersSelect($params = array()) {

    $viewer = Engine_Api::_()->user()->getViewer();
    $viewerId = $viewer->getIdentity();

    $table = Engine_Api::_()->getDbtable('pageoffers', 'sespageoffer');
    $rName = $table->info('name');

    $tmTable = Engine_Api::_()->getDbtable('TagMaps', 'core');
    $tmName = $tmTable->info('name');

    $pTable = Engine_Api::_()->getDbtable('pages', 'sespage');
    $pTableName = $pTable->info('name');

    $select = $table->select()
        ->setIntegrityCheck(false)
        ->from($rName)
        ->joinLeft($pTableName, "$pTableName.page_id = $rName.parent_id", null)
        ->where($rName.'.draft = ?', 0)
        ->where($rName.'.search = ?', 1);

    if(!empty($params['order']) && !in_array($params['order'], array('featured', 'sponsored'))) {
        $select->order( !empty($params['order']) ? $params['order'].' DESC' : $rName.'.creation_date DESC' );
    }

    if(!empty($params['order']) && $params['order'] == 'featured') {
        $select->where($rName.'.featured =?', 1);
    } else if(!empty($params['order']) && $params['order'] == 'sponsored') {
        $select->where($rName.'.sponsored =?', 1);
    }

    if(!empty($params['order']) && $params['order'] == 'featured') {
        $select->where($rName.'.featured =?', 1);
    } else if(!empty($params['order']) && $params['order'] == 'hot') {
        $select->where($rName.'.hot =?', 1);
    } else if(!empty($params['order']) && $params['order'] == 'new') {
        $select->where($rName.'.new =?', 1);
    }

    if( !empty($params['user_id']) && is_numeric($params['user_id']) )
    {
      $owner = Engine_Api::_()->getItem('user', $params['user_id']);
      $select = $this->getProfileItemsSelect($owner, $select);
    } elseif( !empty($params['user']) && $params['user'] instanceof User_Model_User ) {
      $owner = $params['user'];
      $select = $this->getProfileItemsSelect($owner, $select);
    } elseif( isset($params['users']) ) {
      $str = (string) ( is_array($params['users']) ? "'" . join("', '", $params['users']) . "'" : $params['users'] );
      $select->where($rName.'.owner_id in (?)', new Zend_Db_Expr($str));
      if( !in_array($viewer->level_id, $this->_excludedLevels) ) {
        $select->where($rName.".view_privacy != ? ", 'owner');
      }
    } else {
        $param = array();
        //$select = $this->getItemsSelect($params, $select);
    }

    if (!empty($params['alphabet']))
      $select->where($rName . '.title LIKE ?', "{$params['alphabet']}%");

    if (isset($params['widgtename']) && $params['widgtename'] == "You May Also Like") {
      $offerIds = Engine_Api::_()->sespage()->likeIds(array('type' => 'pageoffer', 'id' => $viewerId));
      $select->where($rName . '.pageoffer_id NOT IN(?)', $offerIds);
    }

    if(!empty($params['widgtename']) && $params['widgtename'] == 'other') {
        $select->where($rName.'.owner_id =?', $params['owner_id'])
                ->where($rName.'.pageoffer_id <> ?', $params['pageoffer_id']);
    }

    if( !empty($params['tag'])) {
      $select
        ->joinLeft($tmName, "$tmName.resource_id = $rName.pageoffer_id")
        ->where($tmName.'.resource_type = ?', 'pageoffer')
        ->where($tmName.'.tag_id = ?', $params['tag']);
    }

    if( !empty($params['page_id']) && isset($params['page_id'])) {
      $select->where($rName.'.parent_id = ?', $params['page_id']);
    }

    if( isset($params['draft']) )
    {
      $select->where($rName.'.draft = ?', $params['draft']);
    }

    // Could we use the search indexer for this?
    if( !empty($params['search']) ) {
      $select->where($rName.".title LIKE ? OR ".$rName.".body LIKE ?", '%'.$params['search'].'%');
    }

    if( !empty($params['visible']) ) {
      $select->where($rName.".search = ?", $params['visible']);
    }

    if (isset($params['widgtename']) && $params['widgtename'] == "You May Also Like")
    {
        $select->order('RAND() DESC');
    }

    if( !empty($owner) ) {
      return $select;
    }
    if (isset($params['fetchAll'])) {
      return $this->fetchAll($select);
    } else {
      return $this->getAuthorisedSelect($select);
    }
  }

  public function getOffersPaginator($params = array()) {

    $paginator = Zend_Paginator::factory($this->getOffersSelect($params));
    if( !empty($params['page']) )
    {
      $paginator->setCurrentPageNumber($params['page']);
    }
    if( !empty($params['limit']) )
    {
      $paginator->setItemCountPerPage($params['limit']);
    }
    if( !empty($params['limit_data']) )
    {
      $paginator->setItemCountPerPage($params['limit_data']);
    }
    return $paginator;
  }
}
