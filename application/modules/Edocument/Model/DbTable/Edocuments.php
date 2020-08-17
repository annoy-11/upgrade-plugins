<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Edocument
 * @package    Edocument
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Documents.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Edocument_Model_DbTable_Edocuments extends Engine_Db_Table {

  protected $_rowClass = "Edocument_Model_Edocument";
  protected $_name = "edocument_documents";

  /**
   * Gets a paginator for edocuments
   *
   * @param Core_Model_Item_Abstract $user The user to get the messages for
   * @return Zend_Paginator
   */
  public function getEdocumentsPaginator($params = array(), $customFields = array()) {

    $paginator = Zend_Paginator::factory($this->getEdocumentsSelect($params, $customFields));
    if( !empty($params['page']) )
        $paginator->setCurrentPageNumber($params['page']);
    if( !empty($params['limit']) )
        $paginator->setItemCountPerPage($params['limit']);

    if( empty($params['limit']) ) {
      $page = (int) Engine_Api::_()->getApi('settings', 'core')->getSetting('edocument.page', 10);
      $paginator->setItemCountPerPage($page);
    }

    return $paginator;
  }

  /**
   * Gets a select object for the user's edocument entries
   *
   * @param Core_Model_Item_Abstract $user The user to get the messages for
   * @return Zend_Db_Table_Select
   */
  public function getEdocumentsSelect($params = array(), $customFields = array()) {

    $viewer = Engine_Api::_()->user()->getViewer();
    $viewerId = $viewer->getIdentity();

    $documentTableName = $this->info('name');

    $select = $this->select()
                ->from($documentTableName)
                ->setIntegrityCheck(false);


    if( !empty($params['user_id']) && is_numeric($params['user_id']) )
        $select->where($documentTableName.'.owner_id = ?', $params['user_id']);

    if( !empty($params['user']) && $params['user'] instanceof User_Model_User )
        $select->where($documentTableName.'.owner_id = ?', $params['user']->getIdentity());

    if (isset($params['show']) && $params['show'] == 2 && $viewer->getIdentity()) {
      $users = $viewer->membership()->getMembershipsOfIds();
      if ($users)
        $select->where($documentTableName . '.owner_id IN (?)', $users);
      else
        $select->where($documentTableName . '.owner_id IN (?)', 0);
    }

    if( !empty($params['tag']) ) {
      $tmName = Engine_Api::_()->getDbtable('TagMaps', 'core')->info('name');
      $select->setIntegrityCheck(false)
            ->joinLeft($tmName, "$tmName.resource_id = $documentTableName.edocument_id")
            ->where($tmName.'.resource_type = ?', 'edocument')
            ->where($tmName.'.tag_id = ?', $params['tag']);
    }

    if (!empty($params['alphabet']) && $params['alphabet'] != 'all')
        $select->where($documentTableName . ".title LIKE ?", $params['alphabet'] . '%');

    $currentTime = date('Y-m-d H:i:s');
    if(isset($params['popularCol']) && !empty($params['popularCol'])) {
        if($params['popularCol'] == 'week') {
            $endTime = date('Y-m-d H:i:s', strtotime("-1 week"));
            $select->where("DATE(".$documentTableName.".creation_date) between ('$endTime') and ('$currentTime')");
        } elseif($params['popularCol'] == 'month') {
            $endTime = date('Y-m-d H:i:s', strtotime("-1 month"));
            $select->where("DATE(".$documentTableName.".creation_date) between ('$endTime') and ('$currentTime')");
        } else {
            $select = $select->order($documentTableName . '.' .$params['popularCol'] . ' DESC');
        }
    }

    if (isset($params['fixedData']) && !empty($params['fixedData']) && $params['fixedData'] != '')
        $select = $select->where($documentTableName . '.' . $params['fixedData'] . ' =?', 1);

    if (isset($params['featured']) && !empty($params['featured']))
        $select = $select->where($documentTableName . '.featured =?', 1);

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
        $select->where($documentTableName . ".publish_date <= '$currentTime' OR " . $documentTableName . ".publish_date = ''");
        $select->where($documentTableName.'.is_approved = ?',(bool) 1)->where($documentTableName.'.draft = ?',(bool) 0)->where($documentTableName.'.search = ?', (bool) 1);
    }else
        $select->where($documentTableName.'.owner_id = ?',$viewerId);

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
		$select->where($documentTableName . '.edocument_id =?', $params['edocument_id']);

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

  public function getDocument($params = array()) {

    $documentTableName = $this->info('name');
    $select = $this->select()
                    ->where($documentTableName.'.draft = ?', 0)
                    ->where($documentTableName.".title LIKE ? OR ".$documentTableName.".body LIKE ?", '%'.$params['text'].'%')
                    ->where($documentTableName.".search = ?", 1)
                    ->order('creation_date DESC');
    return $this->fetchAll($select);
  }

  public function getOfTheDayResults() {
    return $this->select()
	      ->from($this->info('name'), 'edocument_id')
	      ->where('offtheday =?', 1)
	      ->where('starttime <= DATE(NOW())')
	      ->where('endtime >= DATE(NOW())')
	      ->order('RAND()')
	      ->query()
	      ->fetchColumn();
  }

  public function checkCustomUrl($value = '', $edocument_id = '') {
    $select = $this->select('edocument_id')->where('custom_url = ?', $value);
    if ($edocument_id)
      $select->where('edocument_id !=?', $edocument_id);
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
        $edocument_id = $slug;
      } else
        $edocument_id = $row->edocument_id;
      return $edocument_id;
    }
    return '';
  }
}
