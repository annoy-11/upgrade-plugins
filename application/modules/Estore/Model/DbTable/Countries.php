<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Countries.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Estore_Model_DbTable_Countries extends Engine_Db_Table {

  protected $_rowClass = 'Estore_Model_Country';
  function getCountries(){
      $select = $this->select()->where('status =?',1)->order('name ASC');
      return $this->fetchAll($select);

  }
}