<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Likestores.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Estore_Model_DbTable_Likestores extends Engine_Db_Table {
  protected $_searchTriggers = false;

    public function getLikes($resourceId) {

    $select = $this->select()
            ->from($this->info('name'), 'owner_id')
            ->where('resource_id = ?', $resourceId);
    return $this->fetchAll($select);
  }
}
