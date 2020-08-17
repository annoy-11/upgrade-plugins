<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seswishe
 * @package    Seswishe
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Wishes.php  2017-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seswishe_Model_DbTable_Wishes extends Core_Model_Item_DbTable_Abstract 
{
  protected $_rowClass = "Seswishe_Model_Wishe";
  
  /**
   * Gets a select object for the user's blog entries
   *
   * @param Core_Model_Item_Abstract $user The user to get the messages for
   * @return Zend_Db_Table_Select
   */
  public function getWishesSelect($params = array())
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    $table = Engine_Api::_()->getDbtable('wishes', 'seswishe');
    $rName = $table->info('name');
	$currentTime = date('Y-m-d H:i:s');

    $tmTable = Engine_Api::_()->getDbtable('TagMaps', 'core');
    $tmName = $tmTable->info('name');

    $select = $table->select();
    if(!empty($params['orderby']) && $params['orderby'] = 'random') { 
      $select->order('RAND()');
	}elseif ($params['orderby'] == 'week') {
        $endTime = date('Y-m-d H:i:s', strtotime("-1 week"));
        $select->where("DATE(".$rName.".creation_date) between ('$endTime') and ('$currentTime')");
     } elseif ($params['orderby'] == 'month') {
        $endTime = date('Y-m-d H:i:s', strtotime("-1 month"));
        $select->where("DATE(".$rName.".creation_date) between ('$endTime') and ('$currentTime')");
    }else {
      $select->order( !empty($params['orderby']) ? $params['orderby'].' DESC' : $rName.'.creation_date DESC' );
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
    } else {
      $param = array();
    }

    if( !empty($params['tag']) )
    {
      $select
        ->setIntegrityCheck(false)
        ->from($rName)
        ->joinLeft($tmName, "$tmName.resource_id = $rName.wishe_id")
        ->where($tmName.'.resource_type = ?', 'seswishe_wishe')
        ->where($tmName.'.tag_id = ?', $params['tag']);
    }

    // Could we use the search indexer for this?
    if( !empty($params['search']) )
    {
      $select->where($rName.".title LIKE ? OR ".$rName.".source LIKE ?", '%'.$params['search'].'%');
    }
    
    if(isset($params['wishe_id']) && !empty($params['wishe_id'])) {
      $select->where('wishe_id != ?', $params['wishe_id'])->where('owner_id = ?', $params['owner_id']);
    }
    
    //Category
    if(isset($params['category_id']) && !empty($params['category_id']))
      $select->where($rName . '.category_id = ?', $params['category_id']);
    if (isset($params['subcat_id']) && !empty($params['subcat_id']))
      $select->where($rName . '.subcat_id = ?', $params['subcat_id']);
    if (isset($params['subsubcat_id']) && !empty($params['subsubcat_id']))
      $select->where($rName . '.subsubcat_id = ?', $params['subsubcat_id']);
    
    if(isset($params['limit']) && !empty($params['limit'])) {
      $select->limit($params['limit']);
    }
    if(isset($params['owner_id']) && !empty($params['owner_id'])) {
      $select->where('owner_id =?', $params['owner_id']);
    }
    if( !empty($owner) ) {
      return $select;
    }
    
    if (isset($params['widget']) && $params['widget'] == 'oftheday') {
    
      $select->where($rName . '.offtheday =?', 1)
              ->where($rName . '.starttime <= DATE(NOW())')
              ->where($rName . '.endtime >= DATE(NOW())')
              ->order('RAND()')->limit(1);
    }

    if(isset($params['widget']) && !empty($params['widget'])) {
      return $this->fetchAll($select);
    }

    return $select;
  }

  /**
   * Gets a paginator for blogs
   *
   * @param Core_Model_Item_Abstract $user The user to get the messages for
   * @return Zend_Paginator
   */
  public function getWishesPaginator($params = array())
  {
    $paginator = Zend_Paginator::factory($this->getWishesSelect($params));
    if( !empty($params['page']) )
    {
      $paginator->setCurrentPageNumber($params['page']);
    }
    if( !empty($params['limit']) )
    {
      $paginator->setItemCountPerPage($params['limit']);
    }

    if( empty($params['limit']) )
    {
      $page = 10; //(int) Engine_Api::_()->getApi('settings', 'core')->getSetting('blog.page', 10);
      $paginator->setItemCountPerPage($page);
    }

    return $paginator;
  }
}