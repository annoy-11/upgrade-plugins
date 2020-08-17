<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sestestimonial
 * @package    Sestestimonial
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Helptestimonials.php  2018-10-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sestestimonial_Model_DbTable_Helptestimonials extends Engine_Db_Table {

  protected $_rowClass = 'Sestestimonial_Model_Helptestimonial';

  public function checkHelpful($testimonial_id, $user_id) {

    $select = $this->select()
                    ->setIntegrityCheck(false)
                    ->where('testimonial_id = ?', $testimonial_id)
                    ->where('user_id = ?', $user_id)
                    ->limit(1);
    $row = $this->fetchAll($select);
    if (count($row) > 0) return true;
      return false;
  }

  public function getHelpfulvalue($testimonial_id, $user_id) {

    return $this->select()
      ->from($this->info('name'), 'helpfultestimonial')
      ->where('user_id = ?', $user_id)
      ->where('testimonial_id = ?', $testimonial_id)
      ->query()
      ->fetchColumn(0);
  }

  public function helpfulCount($testimonial_id, $helpfultestimonial) {

    $select = $this->select()
                    ->from($this->info('name'))
                    ->where('testimonial_id = ?', $testimonial_id)
                    ->where('helpfultestimonial = ?', $helpfultestimonial);
    $row = $this->fetchAll($select);
    $total = count($row);
    return $total;
  }

  public function setHelpful($testimonial_id, $user_id, $reason_id, $helpfultestimonial) {

    $testimonial_item = Engine_Api::_()->getItem('testimonial', $testimonial_id);

    $table  = Engine_Api::_()->getDbTable('helptestimonials', 'sestestimonial');
    $rName = $table->info('name');

    $select = $table->select()
                    ->from($rName)
                    ->where($rName.'.testimonial_id = ?', $testimonial_id)
                    ->where($rName.'.user_id = ?', $user_id);
    $row = $table->fetchRow($select);
    if (empty($row)) {
      Engine_Api::_()->getDbTable('helptestimonials', 'sestestimonial')->insert(array('testimonial_id' => $testimonial_id, 'user_id' => $user_id, 'reason_id' => $reason_id, 'helpfultestimonial' => $helpfultestimonial));

      if($helpfultestimonial == 1) {
        $testimonial_item->helpful_count++;
        $testimonial_item->save();
      } else if($helpfultestimonial == 2) {
        if($testimonial_item->helpful_count > 0) {
          $testimonial_item->helpful_count--;
          $testimonial_item->save();
        }
      }
    } else {
      Engine_Api::_()->getDbTable('helptestimonials', 'sestestimonial')->update(array('modified_date' => new Zend_Db_Expr('NOW()'), 'helpfultestimonial' => $helpfultestimonial, 'reason_id' => $reason_id),array('testimonial_id = ?' => $testimonial_id, 'user_id = ?' => $user_id));

      if($helpfultestimonial == 1) {
        $testimonial_item->helpful_count++;
        $testimonial_item->save();
      } else if($helpfultestimonial == 2) {
        if($testimonial_item->helpful_count > 0) {
          $testimonial_item->helpful_count--;
          $testimonial_item->save();
        }
      }
    }
  }

}
