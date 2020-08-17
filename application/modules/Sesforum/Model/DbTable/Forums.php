<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Forums.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesforum_Model_DbTable_Forums extends Engine_Db_Table
{
  protected $_rowClass = 'Sesforum_Model_Forum';

  public function getChildrenSelectOfSesforumCategory($category)
  {
    return $this->select()->where('category_id = ?', $category->category_id);
  }


  public function getForums()
  {
    $stmt = $this->select()
        ->from($this, array('forum_id', 'title'))
        ->query();

    $data = array('' => 'All Forums');
    foreach( $stmt->fetchAll() as $category ) {
      $data[$category['forum_id']] = $category['title'];
    }

    return $data;
  }
}
