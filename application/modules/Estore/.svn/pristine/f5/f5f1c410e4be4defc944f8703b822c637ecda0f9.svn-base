<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: States.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Estore_Model_DbTable_States extends Engine_Db_Table {

  protected $_rowClass = 'Estore_Model_State';
 function getCount($country_id){
    $select = $this->select()->where('country_id =?',$country_id);
    return count($this->fetchAll($select));
 }
 function getStates($params = array()){
     $select = $this->select()->where('status =?',1)->order('name ASC')->where('country_id =?',$params['country_id']);
     return $this->fetchAll($select);
 }
}