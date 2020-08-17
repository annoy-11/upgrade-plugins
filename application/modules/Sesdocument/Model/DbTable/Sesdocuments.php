<?php

class Sesdocument_Model_DbTable_Sesdocuments extends Engine_Db_Table {


  protected $_rowClass = 'Sesdocument_Model_Sesdocument';
  protected $_name = 'sesdocument_sesdocuments';

  /**
   * Gets a paginator for sesdocuments
   *
   * @param Core_Model_Item_Abstract $user The user to get the messages for
   * @return Zend_Paginator
   */
  public function getSesdocumentsPaginator($params = array(), $customFields = array()) {

    $paginator = Zend_Paginator::factory($this->getSesdocumentsSelect($params, $customFields));
    if( !empty($params['page']) )
    $paginator->setCurrentPageNumber($params['page']);
    if( !empty($params['limit']) )
    $paginator->setItemCountPerPage($params['limit']);

    if( empty($params['limit']) ) {
      $page = (int) Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdocument.page', 10);
      $paginator->setItemCountPerPage($page);
    }

    return $paginator;
  }

  /**
   * Gets a select object for the user's sesdocument entries
   *
   * @param Core_Model_Item_Abstract $user The user to get the messages for
   * @return Zend_Db_Table_Select
   */
  public function getSesdocumentsSelect($params = array(), $customFields = array()) {

    $viewer = Engine_Api::_()->user()->getViewer();
    $viewerId = $viewer->getIdentity();
    $tableLocationName = Engine_Api::_()->getDbtable('locations', 'sesbasic')->info('name');
    $documentTable = Engine_Api::_()->getDbtable('sesdocuments', 'sesdocument');
    $documentTableName = $documentTable->info('name');

    $select = $documentTable->select()->setIntegrityCheck(false)->from($documentTableName);

    if( !empty($params['user_id']) && is_numeric($params['user_id']) )
    $select->where($documentTableName.'.user_id = ?', $params['user_id']);

    if(isset($params['parent_type']))
      $select->where($documentTableName.'.parent_type = ?', $params['parent_type']);

    if( !empty($params['user']) && $params['user'] instanceof User_Model_User )
    $select->where($documentTableName.'.user_id = ?', $params['user']->getIdentity());

    if (isset($params['show']) && $params['show'] == 2 && $viewer->getIdentity()) {
      $users = $viewer->membership()->getMembershipsOfIds();
      if ($users)
      $select->where($documentTableName . '.user_id IN (?)', $users);
      else
      $select->where($documentTableName . '.user_id IN (?)', 0);
    }

    if( !empty($params['tag']) ) {
      $tmName = Engine_Api::_()->getDbtable('TagMaps', 'core')->info('name');
      $select->setIntegrityCheck(false)->joinLeft($tmName, "$tmName.resource_id = $documentTableName.sesdocument_id")
	    ->where($tmName.'.resource_type = ?', 'sesdocument')
	    ->where($tmName.'.tag_id = ?', $params['tag']);
    }

    if (!empty($params['alphabet']) && $params['alphabet'] != 'all')
    $select->where($documentTableName . ".title LIKE ?", $params['alphabet'] . '%');

    $currentTime = date('Y-m-d H:i:s');
    if(isset($params['popularCol']) && !empty($params['popularCol'])) {
			if($params['popularCol'] == 'week') {
				$endTime = date('Y-m-d H:i:s', strtotime("-1 week"));
				$select->where("DATE(".$documentTableName.".creation_date) between ('$endTime') and ('$currentTime')");
			}
			elseif($params['popularCol'] == 'month') {
				$endTime = date('Y-m-d H:i:s', strtotime("-1 month"));
        $select->where("DATE(".$documentTableName.".creation_date) between ('$endTime') and ('$currentTime')");
			}
			else {
				$select = $select->order($documentTableName . '.' .$params['popularCol'] . ' DESC');
			}
    }

    if (isset($params['fixedData']) && !empty($params['fixedData']) && $params['fixedData'] != '')
    $select = $select->where($documentTableName . '.' . $params['fixedData'] . ' =?', 1);

    if (isset($params['featured']) && !empty($params['featured']))
    $select = $select->where($documentTableName . '.featured =?', 1);

    if (isset($params['hot']) && !empty($params['hot']))
    $select = $select->where($documentTableName . '.hot =?', 1);

    if (isset($params['verified']) && !empty($params['verified']))
    $select = $select->where($documentTableName . '.verified =?', 1);

    if (isset($params['sponsored']) && !empty($params['sponsored']))
    $select = $select->where($documentTableName . '.sponsored =?', 1);

    if (!empty($params['category_id']))
    $select = $select->where($documentTableName . '.category_id =?', $params['category_id']);

    if (!empty($params['subcat_id']))
    $select = $select->where($documentTableName . '.subcat_id =?', $params['subcat_id']);

    if (!empty($params['subsubcat_id']))
    $select = $select->where($documentTableName . '.subsubcat_id =?', $params['subsubcat_id']);

    if( isset($params['draft']) )
    $select->where($documentTableName.'.draft = ?', $params['draft']);

    if( !empty($params['text']) )
    $select->where($documentTableName.".title LIKE ? OR ".$documentTableName.".body LIKE ?", '%'.$params['text'].'%');

    if( !empty($params['date']) )
    $select->where("DATE_FORMAT(" . $documentTableName.".creation_date, '%Y-%m-%d') = ?", date('Y-m-d', strtotime($params['date'])));

		if( !empty($params['start_date']) )
    $select->where($documentTableName.".creation_date = ?", date('Y-m-d', $params['start_date']));

    if( !empty($params['end_date']) )
    $select->where($documentTableName.".creation_date < ?", date('Y-m-d', $params['end_date']));

    if( !empty($params['visible']) )
    $select->where($documentTableName.".search = ?", $params['visible']);

		if(!isset($params['manage-widget'])) {
			$select->where($documentTableName.'.is_approved = ?',(bool) 1)->where($documentTableName.'.search = ?', (bool) 1);
		}else
			$select->where($documentTableName.'.user_id = ?',$viewerId);

		if (isset($params['criteria'])) {
			if ($params['criteria'] == 1)
			$select->where($documentTableName . '.featured =?', '1');
			else if ($params['criteria'] == 2)
			$select->where($documentTableName . '.sponsored =?', '1');
			else if ($params['criteria'] == 3)
			$select->where($documentTableName . '.featured = 1 OR ' . $documentTableName . '.sponsored = 1');
			else if ($params['criteria'] == 4)
			$select->where($documentTableName . '.featured = 0 AND ' . $documentTableName . '.sponsored = 0');
			else if ($params['criteria'] == 6)
			$select->where($documentTableName . '.verified =?', '1');
			else if ($params['criteria'] == 7)
			$select->where($documentTableName . '.hot =?', '1');
		}

		if (isset($params['order']) && !empty($params['order'])) {
      if ($params['order'] == 'week') {
        $endTime = date('Y-m-d H:i:s', strtotime("-1 week"));
        $select->where("DATE(".$documentTableName.".creation_date) between ('$endTime') and ('$currentTime')");
      } elseif ($params['order'] == 'month') {
        $endTime = date('Y-m-d H:i:s', strtotime("-1 month"));
        $select->where("DATE(".$documentTableName.".creation_date) between ('$endTime') and ('$currentTime')");
      }
    }

    if (isset($params['widgetName']) && !empty($params['widgetName']) && $params['widgetName'] == 'Similar Documents') {
      if(!empty($params['widgetName'])) {
        $select->where($documentTableName.'.category_id =?', $params['category_id']);
      }
    }

		if(isset($params['similar_document']))
		$select->where($documentTableName . '.parent_id =?', $params['document_id']);

		if (isset($customFields['has_photo']) && !empty($customFields['has_photo'])) {
      $select->where($documentTableName . '.photo_id != ?', "0");
    }

		if (isset($params['criteria'])) {
			switch ($params['info']) {
				case 'recently_created':
					$select->order($documentTableName . '.creation_date DESC');
					break;
				case 'most_viewed':
					$select->order($documentTableName . '.view_count DESC');
					break;
				case 'most_liked':
					$select->order($documentTableName . '.like_count DESC');
					break;
				case 'most_favourite':
					$select->order($documentTableName . '.favourite_count DESC');
					break;
				case 'most_commented':
					$select->order($documentTableName . '.comment_count DESC');
					break;
				case 'most_rated':
					$select->order($documentTableName . '.rating DESC');
					break;
				case 'random':
					$select->order('Rand()');
					break;
			}
		}
		if(!empty($params['getdocument']))	{
			$select->where($documentTableName.".title LIKE ? OR ".$documentTableName.".body LIKE ?", '%'.$params['textSearch'].'%')->where($documentTableName.".search = ?", 1);
		}

        $select->order( !empty($params['orderby']) ? $params['orderby'].' DESC' : $documentTableName.'.creation_date DESC' );

        if(isset($params['fetchAll'])) {
            if(!isset($params['rss'])) {
                if(empty($params['limit']))
                    $select->limit(3);
                else
                    $select->limit($params['limit']);
            }
            return $this->fetchAll($select);
        }
        else
        return $select;
  }


  public function getDocumentPaginator($params = array()) {
    return Zend_Paginator::factory($this->getDocumentSelect($params));
  }
   public function getDocumentSelect($params = array()) {

   		$select = $this->select();
       $tableTagmap = Engine_Api::_()->getDbtable('tagMaps', 'core');
    $tableTagName = $tableTagmap->info('name');
    $tableTag = Engine_Api::_()->getDbtable('tags', 'core');
    $tableMainTagName = $tableTag->info('name');
    $viewer = Engine_Api::_()->user()->getViewer();
    $viewer_id = $viewer->getIdentity();
     $table = Engine_Api::_()->getItemTable('sesdocument');

    $documentTableName = $table->info('name');
    $likesTable = Engine_Api::_()->getDbtable('likes', 'core');
    $likesTableName = $likesTable->info('name');
    if (isset($params['text']) && $params['text']) {
      $search_text = $params['text'];
      $select->where($documentTableName.".description LIKE '%$search_text%' or ".$documentTableName.".title LIKE '%$search_text%'");
    }
      if (empty($params['widgetManage'])){
      $select->where($documentTableName.'.draft = ?',(bool) 1);
      $select->where($documentTableName.'.is_approved = ?',(bool) 1);
      $select->where($documentTableName.'.search = ?', (bool) 1);
    }


    if (isset($params['widgetName']) && $params['widgetName'] == 'oftheday') {
        $select->where($documentTableName . '.offtheday =?', '1')
            ->where($documentTableName . '.startdate <= DATE(NOW())')
            ->where($documentTableName . '.enddate >= DATE(NOW())')
            ->order('RAND()');
    }

    if (isset($params['manageorder']) && !empty($params['manageorder'])){
    if($params['manageorder'] == 'like'){
        $likeTable = Engine_Api::_()->getDbTable('likes', 'core');
        $likeTableName = $likeTable->info('name');
        $select->where($likeTableName.'.resource_type =?', 'sesdocument')
                 ->where($likeTableName.'.poster_id =?', $viewer_id)
                 ->order($likeTableName . '.like_id DESC');
            $select = $select->setIntegrityCheck(false);
            $select = $select->joinLeft($likeTableName, "$likeTableName.resource_id=$documentTableName.sesdocument_id", NULL);
            $select = $select->where($documentTableName.'.sesdocument_id != ?', '');
            $select = $select->where($likeTableName.'.like_id != ?', '');
    }else if($params['manageorder'] == 'verified'){
        $select->where($documentTableName.'.verified =?',1);
        $select->where($documentTableName.'.user_id =?',$viewer_id);
    }else if($params['manageorder'] == 'sponsored'){
        $select->where($documentTableName.'.sponsored =?',1);
        $select->where($documentTableName.'.user_id =?',$viewer_id);
    }else if($params['manageorder'] == 'featured'){
        $select->where($documentTableName.'.featured =?',1);
        $select->where($documentTableName.'.user_id =?',$viewer_id);
    }else if($params['manageorder'] == 'favourite'){
          $favTable = Engine_Api::_()->getDbTable('favourites', 'sesdocument');
          $favTableName = $favTable->info('name');
          $select->where($favTableName.'.resource_type =?', 'sesdocument')
                 ->where($favTableName.'.user_id =?', $viewer_id)
                 ->order($favTableName . '.favourite_id DESC');
            $select = $select->setIntegrityCheck(false);
            $select = $select->joinLeft($favTableName, "$favTableName.resource_id=$documentTableName.sesdocument_id", NULL);
            $select = $select->where($documentTableName.'.sesdocument_id != ?', '');
            $select = $select->where($favTableName.'.favourite_id != ?', '');
    } else
        $select->where($documentTableName.'.user_id =?',$viewer_id);
    }
     if (isset($params['criteria'])) {
      if ($params['criteria'] == 1)
        $select->where($documentTableName . '.featured =?', '1');
      else if ($params['criteria'] == 2)
        $select->where($documentTableName . '.sponsored =?', '1');
      else if ($params['criteria'] == 6)
        $select->where($documentTableName . '.verified =?', '1');
      else if ($params['criteria'] == 3)
        $select->where($documentTableName . '.featured = 1 OR ' . $documentTableName . '.sponsored = 1');
      else if ($params['criteria'] == 4)
        $select->where($documentTableName . '.featured = 0 AND ' . $documentTableName . '.sponsored = 0');
    }
//tags
        if(isset($params['tag_id']) && !empty($params['tag_id'])){
      $select->joinLeft($tableTagName, $tableTagName . '.resource_id=' . $documentTableName . '.sesdocument_id',null)
                    ->joinLeft($tableMainTagName, $tableMainTagName . '.tag_id = ' . $tableTagName . '.tag_id',null)  ;
      $select->where("$tableTagName.tag_id  = ?",$params['tag_id']);
    }

// categories

    if(isset($params['category_id']) && ($params['category_id'] != '' || $params['category_id'] === 0))
      $select->where($documentTableName . '.category_id = ?', $params['category_id']);
    else if(isset($params['getcategory0']) && !empty($params['category_id']))
      $select->where($documentTableName . '.category_id = ?', $params['category_id']);

      switch ($params['info']) {
        case 'most_viewed':
        $select->order('view_count DESC');
          break;
        case 'most_liked':
          $select->order('like_count DESC');
          break;
        case 'most_commented':
          $select->order('comment_count DESC');
          break;
        case "favourite_count":
          $select->order($documentTableName . '.favourite_count DESC');
          break;
        case "most_favourite":
          $select->order($documentTableName . '.favourite_count DESC');
          break;
        case "sponsored" :
          $select->where($documentTableName . '.sponsored' . ' = 1')
                  ->order($documentTableName . '.sesdocument_id DESC');
          break;
        case "verified" :
          $select->where($documentTableName . '.verified' . ' = 1')
                  ->order($documentTableName . '.sesdocument_id DESC');
          break;
        case "featured" :
          $select->where($documentTableName . '.featured' . ' = 1')
                  ->order($documentTableName . '.sesdocument_id DESC');
          break;

          case "recently_created":
          $select->order($eventTableName . '.creation_date DESC');
          break;
      }


      switch ($params['order']) {
        case 'view_count DESC':
         $select->order('view_count DESC');
          break;
        case 'like_count DESC':
          $select->order('like_count DESC');
          break;
        case 'comment_count DESC':
          $select->order('comment_count DESC');
          break;
        case 'creation_date ASC':
          $select->order( 'creation_date DESC');
          break;
        case "rate_count DESC":
          $select->order( '.rate_count DESC');
          break;
        case "sponsored" :
          $select->where($documentTableName . '.sponsored' . ' = 1')
                  ->order($documentTableName . '.sesdocument_id DESC');
          break;
        case "verified" :
          $select->where($documentTableName . '.verified' . ' = 1')
                  ->order($documentTableName . '.sesdocument_id DESC');
          break;
        case "featured" :
          $select->where($documentTableName . '.featured' . ' = 1')
                  ->order($documentTableName . '.sesdocument_id DESC');
          break;

          case "favourite_count DESC":
           $select->order( 'favourite_count DESC');
          break;
      }

    if(isset($params['mostSPliked_id'])){

      $userId = $params['mostSPliked_id'];

       if($userId){
      $select-> where($documentTableName.'.user_id =?',$userId);
             $select =  $select-> order($documentTableName .'.like_count DESC');
           }

    }  else if(isset($params['mostSPcommented_id'])){
      $userId = $params['mostSPcommented_id'];
      if($userId){
      $select-> where($documentTableName.'.user_id = ?',$userId);
           $select =  $select->order($documentTableName . '.comment_count DESC');
         }

    }
      else if(isset($params['recentlySPcreated_id'])){
        $userId = $params['recentlySPcreated_id'];
        if($userId){
      $select-> where($documentTableName.'.user_id = ?',$userId);
             $select =  $select->order($documentTableName . '.creation_date DESC');
           }

    }
      else if(isset($params['mostSPrated_id'])){
        $userId = $params['mostSPrated_id'];
        if($userId){
      $select-> where($documentTableName.'.user_id = ?',$userId);

             $select =  $select->order($documentTableName . '.rate_count DESC');
           }

    }
     else  if(isset($params['featured_id'])){
      $userId = $params['featured_id'];
      if($userId){
      $select-> where($documentTableName.'.user_id = ?',$userId);
             $select =   $select->where($documentTableName . '.sponsored' . ' = 1')
                  ->order($documentTableName . '.sesdocument_id DESC');
                }

    }
     else  if(isset($params['sponsored_id'])){
      $userId = $params['sponsored_id'];
      if($userId){
        $select->where($documentTableName . '.sponsored' . ' = 1');
                 $select =  $select-> where($documentTableName.'.user_id = ?',$userId)
                  ->order($documentTableName . '.sesdocument_id DESC');
      }
    }
     else  if(isset($params['verified_id'])){
      $userId = $params['verified_id'];
      if($userId){
       $select-> where($documentTableName.'.user_id = ?',$userId);
               $select =  $select  ->where($documentTableName . '.verified' . ' = 1');
                 $select =  $select->order($documentTableName . '.sesdocument_id DESC');
      }

    }
      else if(isset($params['mostSPfavourite_id'])){
        $userId = $params['mostSPfavourite_id'];
        if($userId){
      $select-> where($documentTableName.'.user_id = ?',$userId);
             $select =  $select->order($documentTableName . '.favourite_count DESC');
         }
    }
      else {
        $userId = $params['mostSPviewed_id'];
        if($userId){
      $select-> where($documentTableName.'.user_id = ?',$userId);
              $select = $select->order($documentTableName . '.view_count DESC');
        }

    }

    if (!empty($params['alphabet']))
      $select->where($documentTableName . '.title LIKE ?', "{$params['alphabet']}%");

    if (isset($params['limit']) && !empty($params['limit']))
      $select->limit($params['limit']);
    if(!empty($params['limit_data']))
      $select->limit($params['limit_data']);
    if(isset($params['orderby'])){
      $select->order($documentTableName.'.'.$params['orderby'] .' DESC');
    }


    if (isset($params['fetchAll'])) {
      return $this->fetchAll($select);
    } else {
      return $select;
    }


    }

  public function checkCustomUrl($value = '', $document_id = '') {
    $select = $this->select('document_id')->where('custom_url = ?', $value);
    if ($document_id)
      $select->where('document_id !=?', $document_id);
    return $select->query()->fetchColumn();
  }
   public function getDocumentId($slug = null) {
    if ($slug) {
      $tableName = $this->info('name');
      $select = $this->select()
              ->from($tableName)
              ->where($tableName . '.custom_url = ?', $slug);
      $row = $this->fetchRow($select);
      if (empty($row)) {
        $event_id = $slug;
      } else
        $document_id = $row->sesdocument_id;
      return $document_id;
    }
    return '';
  }




}
