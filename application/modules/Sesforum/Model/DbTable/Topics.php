<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Topics.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesforum_Model_DbTable_Topics extends Engine_Db_Table
{
  protected $_rowClass = 'Sesforum_Model_Topic';

  public function getChildrenSelectOfSesforum($sesforum, $params)
  {
    $select = $this->select()->where('forum_id = ?', $sesforum->forum_id);
    return $select;
  }
}
