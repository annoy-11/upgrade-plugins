<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesgroupforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Forums.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesgroupforum_Model_DbTable_Sesgroupforums extends Engine_Db_Table
{
  protected $_rowClass = 'Sesgroupforum_Model_Sesgroupforum';
  protected $_name = "sesgroupforum_forums";

  public function getChildrenSelectOfSesgroupforumCategory($category)
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
