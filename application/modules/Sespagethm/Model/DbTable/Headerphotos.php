<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Seshtmlbackground
 * @package    Seshtmlbackground
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Headerphotos.php 2015-10-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagethm_Model_DbTable_Headerphotos extends Engine_Db_Table {
  protected $_rowClass = "Sespagethm_Model_Headerphoto";
  public function getPhotos($show_type = '') {
    $tableName = $this->info('name');
    $select = $this->select()->from($tableName);
    if($show_type != 'all') {
      $select->where('enabled =?', 1);
    }
    else
    $select ->order('order ASC');
    if($show_type != 'all') {
      $select->order('Rand()');
      $select->limit('1');
      return $this->fetchAll($select);
    }
    else
    return Zend_Paginator::factory($select);
  }

}
