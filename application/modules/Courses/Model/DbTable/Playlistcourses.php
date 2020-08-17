<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Playlistcourses.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */


class Courses_Model_DbTable_Playlistcourses extends Engine_Db_Table {

  protected $_name = 'courses_playlistcourses';
  protected $_rowClass = 'Courses_Model_Playlistcourse';

  public function getPlaylistCourses($params = array()) {
    return $this->select()
                    ->from($this->info('name'), $params['column_name'])
                    ->where('wishlist_id = ?', $params['wishlist_id'])
                    ->query()
                    ->fetchAll();
  }
  public function playlistCoursesCount($params = array()) {
    $row = $this->select()
            ->from($this->info('name'))
            ->where('wishlist_id = ?', $params['wishlist_id'])
            ->query()
            ->fetchAll();
    $total = count($row);
    return $total;
  }
  public function checkCoursesAlready($params = array()) {
    return $this->select()
                ->from($this->info('name'), $params['column_name'])
                ->where('wishlist_id = ?', $params['wishlist_id'])
                ->where('file_id = ?', $params['file_id'])
                ->limit(1)
                ->query()
                ->fetchColumn();
  }
  public function getWishedCourses($params = array()) {
    $courseTable = Engine_Api::_()->getDbtable('courses', 'courses');
    $courseTableName =$courseTable->info('name');
    $playlistTable = $this->info('name');
    $select =  $courseTable->select()
                    ->setIntegrityCheck(false)
                    ->from($courseTableName,'*')
                     ->where('wishlist_id = ?', $params['wishlist_id'])
                    ->joinLeft($playlistTable, $courseTableName . '.course_id = ' . $playlistTable . '.course_id',null) ;
    return $courseTable->fetchAll($select);

  }

}
