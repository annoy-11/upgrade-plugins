<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Quicksignup
 * @package    Quicksignup
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Enablefields.php  2018-11-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Quicksignup_Model_DbTable_Enablefields extends Engine_Db_Table {

   function getField($name)
   {
       return $this->fetchRow($this->select()->where('type =?', $name));
   }
}
