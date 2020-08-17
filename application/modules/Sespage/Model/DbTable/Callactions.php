<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Callactions.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespage_Model_DbTable_Callactions extends Engine_Db_Table {

  public function getCallactions($params = array()) {
    $select = $this->select()
            ->from($this->info('name'))
            ->where('page_id =?', $params['page_id']);
   return $this->fetchRow($select);
  }  
}
