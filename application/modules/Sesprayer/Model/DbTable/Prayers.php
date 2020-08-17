<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprayer
 * @package    Sesprayer
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Prayers.php  2017-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesprayer_Model_DbTable_Prayers extends Core_Model_Item_DbTable_Abstract
{
  protected $_rowClass = "Sesprayer_Model_Prayer";

  /**
   * Gets a select object for the user's blog entries
   *
   * @param Core_Model_Item_Abstract $user The user to get the messages for
   * @return Zend_Db_Table_Select
   */
  public function getPrayersSelect($params = array())
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    $table = Engine_Api::_()->getDbtable('prayers', 'sesprayer');
    $rName = $table->info('name');

    $receiversTable = Engine_Api::_()->getDbtable('receivers', 'sesprayer');
    $receiversTableName = $receiversTable->info('name');

    $tmTable = Engine_Api::_()->getDbtable('TagMaps', 'core');
    $tmName = $tmTable->info('name');

    $select = $table->select();

    if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesprayer.allowsendprayer', 0) && isset($params['actionname']) && $params['actionname'] == 'browseprayer') {
        $select
        ->setIntegrityCheck(false)
        ->from($rName)
        ->joinLeft($receiversTableName, "$receiversTableName.prayer_id = $rName.prayer_id", null)
        ->where($receiversTableName .'.resource_id = '.$viewer->getIdentity().' OR ' .$rName . '.posttype =?',0);
    }

    if(!empty($params['orderby']) && $params['orderby'] = 'random') {
      $select->order('RAND()');
    } elseif ($params['orderby'] == 'week') {
        $endTime = date('Y-m-d H:i:s', strtotime("-1 week"));
        $select->where("DATE(".$rName.".creation_date) between ('$endTime') and ('$currentTime')");
      } elseif ($params['orderby'] == 'month') {
        $endTime = date('Y-m-d H:i:s', strtotime("-1 month"));
        $select->where("DATE(".$rName.".creation_date) between ('$endTime') and ('$currentTime')");
      }
	else {
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
        ->joinLeft($tmName, "$tmName.resource_id = $rName.prayer_id")
        ->where($tmName.'.resource_type = ?', 'sesprayer_prayer')
        ->where($tmName.'.tag_id = ?', $params['tag']);
    }

    // Could we use the search indexer for this?
    if( !empty($params['search']) )
    {
      $select->where($rName.".title LIKE ? OR ".$rName.".source LIKE ?", '%'.$params['search'].'%');
    }

    if(isset($params['prayer_id']) && !empty($params['prayer_id'])) {
      $select->where('prayer_id != ?', $params['prayer_id'])->where('owner_id = ?', $params['owner_id']);
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
    if(isset($params['user_id']) && !empty($params['user_id'])) {
      $select->where('owner_id =?', $params['user_id']);
    }

    if(isset($params['userNetworksSearch']) && !empty($params['userNetworksSearch']))
    {
      $select->where($rName.'.owner_id IN (?)', $params['userNetworksSearch']);
    }

    if(isset($params['userlistsSearch']) && !empty($params['userlistsSearch'])) {
      $select->where($rName.'.owner_id IN (?)', $params['userlistsSearch']);
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
  public function getPrayersPaginator($params = array())
  {
    $paginator = Zend_Paginator::factory($this->getPrayersSelect($params));
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
