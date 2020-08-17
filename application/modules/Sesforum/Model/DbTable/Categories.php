<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Categories.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesforum_Model_DbTable_Categories extends Engine_Db_Table
{
  protected $_rowClass = 'Sesforum_Model_Category';
  public function getCategoriesAssoc($params = null)
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    if(!$viewer->getIdentity()) {
        $levelId = 5;
    } else {
        $levelId = $viewer->level_id;
    }
    $select = $this->select()
        ->from($this, "*");
        $select->order('order ASC');
        $select->where("privacy LIKE ? ", '%' . $levelId . '%');
        //->query();
         if(isset($params['limit'])) {
            $select->limit($params['limit']);
        }
        if(isset($params['category_id']) && isset($params['widget'])) {
           $select->where('subcat_id = ? OR subsubcat_id = ?', $params['category_id']);
        } elseif(isset($params['category_id'])) {
           $select->where('category_id = ?', $params['category_id']);
        } else {
             $select->where('subcat_id = ?', 0);
            $select->where('subsubcat_id = ?', 0);
        }
        if(isset($params['fetchAll'])) {
         return $this->fetchAll($select);
        }
      return $select;
  }
  public function getCategories($params = null)
  {
        $select = $this->select()
            ->from($this, "*");
                $select->where('subcat_id = ?', 0);
            $select->where('subsubcat_id = ?', 0);
            $select->order('order ASC');
          $stmt =  $select->query();
            if(isset($params['limit'])) {
                $select->limit($params['limit']);
            }

        $data = array('' => '');
        foreach( $stmt->fetchAll() as $category ) {
          $data[$category['category_id']] = $category['title'];
        }

        return $data;

    }
  public function slugExists($slug = '', $id = '') {

    if ($slug != '') {

      $tableName = $this->info('name');
      $select = $this->select()
              ->from($tableName)
              ->where($tableName . '.slug = ?', $slug);

      if ($id != '') {
        $select = $select->where('category_id != ?', $id);
      }

      $row = $this->fetchRow($select);
      if (empty($row)) {
        return true;
      } else
        return false;
    }
    return false;
  }
   public function getCategoryId($slug = null) {

    if ($slug) {
      $tableName = $this->info('name');
      $select = $this->select()
              ->from($tableName)
              ->where($tableName . '.slug = ?', $slug);
      $row = $this->fetchRow($select);
      if (empty($row))
        $category_id = $slug;
      else
        $category_id = $row->category_id;
    }

    if (isset($category_id))
      return $category_id;
    else
      return;
  }
  public function getSubCat($category_id) {

    $select = $this->select()->where('subcat_id = ?', $category_id)->order('order ASC');
    return $this->fetchAll($select);
  }
  public function getSubSubCat($subcat_id) {

    $select = $this->select()->where('subsubcat_id = ?', $subcat_id)->order('order ASC');
    return $this->fetchAll($select);
  }
}
