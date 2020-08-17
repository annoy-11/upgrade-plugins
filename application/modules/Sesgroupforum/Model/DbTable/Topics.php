<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesgroupforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Topics.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesgroupforum_Model_DbTable_Topics extends Engine_Db_Table
{
  protected $_rowClass = 'Sesgroupforum_Model_Topic';

  public function getChildrenSelectOfSesgroupforum($sesgroupforum, $params)
  {
    $select = $this->select()->where('forum_id = ?', $sesgroupforum->forum_id);
    return $select;
  }
}
