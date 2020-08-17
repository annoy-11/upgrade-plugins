<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Upsells.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Courses_Model_DbTable_Upsells extends Engine_Db_Table {
   function create($params = array()){
        $row = $this->createRow();
        $row->setFromArray($params);
        $row->save();
    }
    function getSells($params = array()){
      $select = $this->select()->where('course_id =?',$params['course_id']);
      return $this->fetchAll($select);
    }
    public function getUpsellPaginator($params = array(), $customFields = array()) {
        $paginator = Zend_Paginator::factory($this->getCoursessSelect($params, $customFields));
        if( !empty($params['page']) )
        $paginator->setCurrentPageNumber($params['page']);
        if( !empty($params['limit']) )
        $paginator->setItemCountPerPage($params['limit']);

        if( empty($params['limit']) ) {
        $page = (int) Engine_Api::_()->getApi('settings', 'core')->getSetting('courses.page', 10);
        $paginator->setItemCountPerPage($page);
        }
        return $paginator;
    }
    public function getCoursessSelect($params = array(), $customFields = array()) {
        $viewer = Engine_Api::_()->user()->getViewer();
        $viewerId = $viewer->getIdentity();
        $upsellTableName = $this->info('name');
        $courseTable = Engine_Api::_()->getDbtable('courses', 'courses');
        // $select->where();
        $select = $courseTable->select()->setIntegrityCheck(false)->from($courseTableName);
        $courseTableName = $courseTable->info('name');
    //      if( !empty($params['course_id']) && is_numeric($params['course_id']) ){
    //
    //         $select->joinLeft($upsellTableName, $upsellTableName . '.course_id = ' . $courseTableName . '.course_id',null)
    //         ->where($courseTableName . '.course_id IN SEL',);
    //     }

        if( !empty($params['classroom_id']) && is_numeric($params['classroom_id']) )
            $select->where($courseTableName.'.classroom_id = ?', $params['classroom_id']);
        if( !empty($params['course_id']) && is_numeric($params['course_id']) )
            $select->where($courseTableName.'.course_id = ?', $params['course_id']);
        if( !empty($params['title']))
        $select->where($courseTableName . ".title LIKE ?", $params['title'] . '%');
        if( !empty($params['user_id']) && is_numeric($params['user_id']) )
            $select->where($courseTableName.'.owner_id = ?', $params['user_id']);
        if(isset($params['parent_type']))
            $select->where($courseTableName.'.parent_type = ?', $params['parent_type']);
        if(!empty($params['user']) && $params['user'] instanceof User_Model_User )
            $select->where($courseTableName.'.owner_id = ?', $params['user']->getIdentity());
        if(!empty($params['user']) && $params['user'] instanceof User_Model_User )
            $select->where($courseTableName.'.owner_id = ?', $params['user']->getIdentity());
        if (isset($params['show']) && $params['show'] == 2 && $viewer->getIdentity()) {
        $users = $viewer->membership()->getMembershipsOfIds();
        if ($users)
        $select->where($courseTableName . '.owner_id IN (?)', $users);
        else
        $select->where($courseTableName . '.owner_id IN (?)', 0);
        }
        if (isset($params['wishlist_id'])) {
            $wishlistTable = Engine_Api::_()->getDbtable('wishlists', 'courses');
            $wishlistTableName = $wishlistTable->info('name');
            $select->joinLeft($wishlistTableName, $wishlistTableName . '.course_id = ' . $courseTableName . '.course_id',null)
            ->where($wishlistTableName.'.wishlist_id = ?',$params['wishlist_id']);
        }
        if( !empty($params['tag']) ) {
        $tmName = Engine_Api::_()->getDbtable('TagMaps', 'core')->info('name');
        $select->setIntegrityCheck(false)->joinLeft($tmName, "$tmName.resource_id = $courseTableName.course_id")
            ->where($tmName.'.resource_type = ?', 'courses')
            ->where($tmName.'.tag_id = ?', $params['tag']);
        }
        if (!empty($params['alphabet']) && $params['alphabet'] != 'all')
            $select->where($courseTableName . ".title LIKE ?", $params['alphabet'] . '%');
        $currentTime = date('Y-m-d H:i:s');
        if(isset($params['popularCol']) && !empty($params['popularCol'])) {
                if($params['popularCol'] == 'week') {
                    $endTime = date('Y-m-d H:i:s', strtotime("-1 week"));
                    $select->where("DATE(".$courseTableName.".creation_date) between ('$endTime') and ('$currentTime')");
                }
                elseif($params['popularCol'] == 'month') {
                    $endTime = date('Y-m-d H:i:s', strtotime("-1 month"));
            $select->where("DATE(".$courseTableName.".creation_date) between ('$endTime') and ('$currentTime')");
                }
                else {
                    $select = $select->order($courseTableName . '.' .$params['popularCol'] . ' DESC');
                }
        }
        if (isset($params['fixedData']) && !empty($params['fixedData']) && $params['fixedData'] != '')
            $select = $select->where($courseTableName . '.' . $params['fixedData'] . ' =?', 1);
        if (isset($params['featured']) && !empty($params['featured']))
            $select = $select->where($courseTableName . '.featured =?', 1);
        if (isset($params['verified']) && !empty($params['verified']))
        $select = $select->where($courseTableName . '.verified =?', 1);

        if (isset($params['sponsored']) && !empty($params['sponsored']))
            $select = $select->where($courseTableName . '.sponsored =?', 1);
        if (!empty($params['category_id']))
            $select = $select->where($courseTableName . '.category_id =?', $params['category_id']);
        if (!empty($params['subcat_id']))
            $select = $select->where($courseTableName . '.subcat_id =?', $params['subcat_id']);
        if (!empty($params['subsubcat_id']))
            $select = $select->where($courseTableName . '.subsubcat_id =?', $params['subsubcat_id']);
        if( isset($params['draft']) )
            $select->where($courseTableName.'.draft = ?', $params['draft']);
        if( !empty($params['text']) )
            $select->where($courseTableName.".title LIKE ? OR ".$courseTableName.".body LIKE ?", '%'.$params['text'].'%');
        if( !empty($params['date']) )
            $select->where("DATE_FORMAT(" . $courseTableName.".creation_date, '%Y-%m-%d') = ?", date('Y-m-d', strtotime($params['date'])));
        if( !empty($params['start_date']) )
            $select->where($courseTableName.".creation_date = ?", date('Y-m-d', $params['start_date']));

        if( !empty($params['end_date']) )
            $select->where($courseTableName.".creation_date < ?", date('Y-m-d', $params['end_date']));
        if( !empty($params['visible']) )
            $select->where($courseTableName.".search = ?", $params['visible']);
        if(!isset($params['manage-widget'])) {
            $select->where($courseTableName . ".starttime <= '$currentTime' OR " . $courseTableName . ".starttime IS NULL");
            $select->where($courseTableName.'.is_approved = ?',(bool) 1)->where($courseTableName.'.search = ?', (bool) 1);
        }else
            $select->where($courseTableName.'.owner_id = ?',$viewerId);

        if (isset($params['criteria'])) {
            if ($params['criteria'] == 1)
            $select->where($courseTableName . '.featured =?', '1');
            else if ($params['criteria'] == 2)
            $select->where($courseTableName . '.sponsored =?', '1');
            else if ($params['criteria'] == 3)
            $select->where($courseTableName . '.featured = 1 OR ' . $courseTableName . '.sponsored = 1');
            else if ($params['criteria'] == 4)
            $select->where($courseTableName . '.featured = 0 AND ' . $courseTableName . '.sponsored = 0');
            else if ($params['criteria'] == 6)
            $select->where($courseTableName . '.verified =?', '1');
            else if ($params['criteria'] == 7)
            $select->where($courseTableName . '.discount =?', '1');
        }
        if (isset($params['order']) && !empty($params['order'])) {
        if ($params['order'] == 'week') {
            $endTime = date('Y-m-d H:i:s', strtotime("-1 week"));
            $select->where("DATE(".$courseTableName.".creation_date) between ('$endTime') and ('$currentTime')");
        } elseif ($params['order'] == 'month') {
            $endTime = date('Y-m-d H:i:s', strtotime("-1 month"));
            $select->where("DATE(".$courseTableName.".creation_date) between ('$endTime') and ('$currentTime')");
        }
        }
        if (isset($params['widgetName']) && !empty($params['widgetName']) && $params['widgetName'] == 'Similar Products') {
        if(!empty($params['widgetName'])) {
            $select->where($courseTableName.'.category_id =?', $params['category_id']);
        }
        }
        if(isset($params['similar_product']))
            $select->where($courseTableName . '.parent_id =?', $params['course_id']);
        if (isset($customFields['has_photo']) && !empty($customFields['has_photo'])) {
        $select->where($courseTableName . '.photo_id != ?', "0");
        }
        if (isset($params['criteria'])) {
            switch ($params['info']) {
                case 'recently_created':
                    $select->order($courseTableName . '.creation_date DESC');
                    break;
                case 'most_viewed':
                    $select->order($courseTableName . '.view_count DESC');
                    break;
                case 'most_liked':
                    $select->order($courseTableName . '.like_count DESC');
                    break;
                case 'most_favourite':
                    $select->order($courseTableName . '.favourite_count DESC');
                    break;
                case 'most_commented':
                    $select->order($courseTableName . '.comment_count DESC');
                    break;
                case 'most_rated':
                    $select->order($courseTableName . '.rating DESC');
                    break;
                case 'brand':
                    $select->order($courseTableName . '.brand DESC');
                    break;
                case 'discount':
                    $select->order($courseTableName . '.discount DESC');
                    break;
                case 'cheapest':
                    $select->where($courseTableName . '.price DESC');
                    break;
                case 'popular':
                    $select->where($courseTableName . '.view_count DESC');
                    break;
                case 'category':
                    $select->where($courseTableName . '.category_id DESC');
                    break;
                case 'myProduct':
                    $select->where($courseTableName.'.owner_id = ?',$viewerId);
                    $select->where($courseTableName . '.course_id DESC');
                    break;
                case 'random':
                    $select->order('Rand()');
                    break;
            }
        }
        if(!empty($params['getproduct']))	{
            $select->where($courseTableName.".title LIKE ? OR ".$courseTableName.".body LIKE ?", '%'.$params['textSearch'].'%')->where($courseTableName.".search = ?", 1);
        }
        if (!empty($params['resource_type']) && !empty($params['resource_id'])) {
        $select->where($courseTableName . '.resource_type =?', $params['resource_type'])
                ->where($courseTableName . '.resource_id =?', $params['resource_id']);
        } else if(!empty($params['resource_type'])) {
        $select->where($courseTableName . '.resource_type =?', $params['resource_type']);
        }
        $select->order( !empty($params['orderby']) ? $params['orderby'].' DESC' : $courseTableName.'.creation_date DESC' );

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

}
