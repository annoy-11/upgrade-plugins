<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilelock
 * @package    Sesprofilelock
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Uservieweds.php 2016-04-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesprofilelock_Model_DbTable_Uservieweds extends Engine_Db_Table {

  protected $_rowClass = "Sesprofilelock_Model_Userviewed";

  public function getViewedUsers($params = array()) {
    $select = $this->select()
            ->where('viewedby_user_id =?', $params['subject_id'])
            ->order('creation_date DESC');
    return Zend_Paginator::factory($select);
  }

}
