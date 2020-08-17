<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesgroupforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Posts.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesgroupforum_Model_DbTable_Posts extends Engine_Db_Table
{
  protected $_rowClass = 'Sesgroupforum_Model_Post';

  public function getChildrenSelectOfSesgroupforumTopic($topic)
  {
    $select = $this->select()->where('topic_id = ?', $topic->topic_id);
    return $select;
  }

}
