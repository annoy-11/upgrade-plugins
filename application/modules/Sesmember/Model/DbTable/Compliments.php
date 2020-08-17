<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmember
 * @package    Sesmember
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id Compliments.php 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesmember_Model_DbTable_Compliments extends Engine_Db_Table {

  protected $_rowClass = "Sesmember_Model_Compliment";
  protected $_name = "sesmember_compliments";

  function getComplementsParameters($params = array()) {
    $tablename = $this->info('name');
    $select = $this->select()->from($tablename);
    return $this->fetchAll($select);
  }

}
