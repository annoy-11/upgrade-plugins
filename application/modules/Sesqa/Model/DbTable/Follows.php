<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Follows.php  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesqa_Model_DbTable_Follows extends Engine_Db_Table {

  protected $_rowClass = "Sesqa_Model_Follow";
  protected $_name = "sesqa_follows";

  public function getFollowers($viewer_id) {
    $select = $this->select()
            ->from($this->info('name'), 'resource_id')
            ->where('user_id = ?', $viewer_id);
    return $this->fetchAll($select);
  }

  public function getQuesitonFollowers($question_id) {
    $select = $this->select()
            ->from($this->info('name'), 'user_id')
            ->where('resource_id = ?', $question_id);
    return $this->fetchAll($select);
  }
}
