<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Offers.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */


class Courses_Model_DbTable_Offers extends Engine_Db_Table {

  protected $_rowClass = "Courses_Model_Offer";

  public function getOffers($param = array()) {
    $tableName = $this->info('name');
    $offerSlides = Engine_Api::_()->getDbtable('slides', 'courses')->info('name');
    $select = $this->select()->setIntegrityCheck(false)
            ->from($tableName);
    //$select->joinLeft($offerSlides, $offerSlides . '.offer_id = ' . $tableName . '.offer_id AND '.$offerSlides .'.enabled = 1',null);
    if (isset($param['fetchAll'])) {
      $select->where($tableName.'.enabled =?', 1);
      return $this->fetchAll($select);
      }
    return Zend_Paginator::factory($select);
  }
}
