<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfaq
 * @package    Sesfaq
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Helpfaqs.php  2017-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesfaq_Model_DbTable_Helpfaqs extends Engine_Db_Table {

  protected $_rowClass = 'Sesfaq_Model_Helpfaq';
  
  public function checkHelpful($faq_id, $user_id) {
  
    $select = $this->select()
                    ->setIntegrityCheck(false)
                    ->where('faq_id = ?', $faq_id)
                    ->where('user_id = ?', $user_id)
                    ->limit(1);
    $row = $this->fetchAll($select);
    if (count($row) > 0) return true;
      return false;
  }
  
  public function getHelpfulvalue($faq_id, $user_id) {
  
    return $this->select()
      ->from($this->info('name'), 'helpfulfaq')
      ->where('user_id = ?', $user_id)
      ->where('faq_id = ?', $faq_id)
      ->query()
      ->fetchColumn(0);
  }

  public function helpfulCount($faq_id, $helpfulfaq) {

    $select = $this->select()
                    ->from($this->info('name'))
                    ->where('faq_id = ?', $faq_id)
                    ->where('helpfulfaq = ?', $helpfulfaq);
    $row = $this->fetchAll($select);
    $total = count($row);
    return $total;
  }
  
  public function setHelpful($faq_id, $user_id, $reason_id, $helpfulfaq) {
  
    $faq_item = Engine_Api::_()->getItem('sesfaq_faq', $faq_id);
    
    $table  = Engine_Api::_()->getDbTable('helpfaqs', 'sesfaq');
    $rName = $table->info('name');

    $select = $table->select()
                    ->from($rName)
                    ->where($rName.'.faq_id = ?', $faq_id)
                    ->where($rName.'.user_id = ?', $user_id);
    $row = $table->fetchRow($select);
    if (empty($row)) {
      Engine_Api::_()->getDbTable('helpfaqs', 'sesfaq')->insert(array('faq_id' => $faq_id, 'user_id' => $user_id, 'reason_id' => $reason_id, 'helpfulfaq' => $helpfulfaq));
      
      if($helpfulfaq == 1) {
        $faq_item->helpful_count++;
        $faq_item->save();
      } else if($helpfulfaq == 2) {
        if($faq_item->helpful_count > 0) {
          $faq_item->helpful_count--;
          $faq_item->save();
        }
      }
    } else {
      Engine_Api::_()->getDbTable('helpfaqs', 'sesfaq')->update(array('modified_date' => new Zend_Db_Expr('NOW()'), 'helpfulfaq' => $helpfulfaq, 'reason_id' => $reason_id),array('faq_id = ?' => $faq_id, 'user_id = ?' => $user_id));
      
      if($helpfulfaq == 1) {
        $faq_item->helpful_count++;
        $faq_item->save();
      } else if($helpfulfaq == 2) {
        if($faq_item->helpful_count > 0) {
          $faq_item->helpful_count--;
          $faq_item->save();
        }
      }
    }
  }
  
}