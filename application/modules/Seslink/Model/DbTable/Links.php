<?php

class Seslink_Model_DbTable_Links extends Core_Model_Item_DbTable_Abstract 
{
  protected $_rowClass = "Seslink_Model_Link";
  
  /**
   * Gets a select object for the user's link entries
   *
   * @param Core_Model_Item_Abstract $user The user to get the messages for
   * @return Zend_Db_Table_Select
   */
  public function getLinksSelect($params = array())
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    $table = Engine_Api::_()->getDbtable('links', 'seslink');
    $rName = $table->info('name');

    $tmTable = Engine_Api::_()->getDbtable('TagMaps', 'core');
    $tmName = $tmTable->info('name');
    //$tmTable = Engine_Api::_()->getDbtable('tagmaps', 'link');
    //$tmName = $tmTable->info('name');

    $select = $table->select();
    if(@$params['orderby'] == 'random')
      $select->order('RAND() DESC');
    else
      $select->order( !empty($params['orderby']) ? $params['orderby'].' DESC' : $rName.'.creation_date DESC' );

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
      
//       if( !in_array($viewer->level_id, $this->_excludedLevels) ) {
//         $select->where("view_privacy != ? ", 'owner');
//       }
    }

    if( !empty($params['tag']) )
    {
      $select
        ->setIntegrityCheck(false)
        ->from($rName)
        ->joinLeft($tmName, "$tmName.resource_id = $rName.link_id")
        ->where($tmName.'.resource_type = ?', 'seslink_link')
        ->where($tmName.'.tag_id = ?', $params['tag']);
    }

    // Could we use the search indexer for this?
    if( !empty($params['search']) )
    {
      $select->where($rName.".title LIKE ? OR ".$rName.".body LIKE ?", '%'.$params['search'].'%');
    }
    
    if(isset($params['link_id']) && !empty($params['link_id'])) {
      $select->where('link_id != ?', $params['link_id'])->where('owner_id = ?', $params['owner_id']);
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

    if( !empty($owner) ) {
      return $select;
    }

    if(isset($params['widget']) && !empty($params['widget'])) {
      return $this->fetchAll($select);
    }
    
    return $this->getAuthorisedSelect($select);
  }

  /**
   * Gets a paginator for links
   *
   * @param Core_Model_Item_Abstract $user The user to get the messages for
   * @return Zend_Paginator
   */
  public function getLinksPaginator($params = array())
  {
    $paginator = Zend_Paginator::factory($this->getLinksSelect($params));
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
      $page = 10; //(int) Engine_Api::_()->getApi('settings', 'core')->getSetting('link.page', 10);
      $paginator->setItemCountPerPage($page);
    }

    return $paginator;
  }
}