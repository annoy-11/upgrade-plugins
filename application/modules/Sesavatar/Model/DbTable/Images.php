<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesavatar
 * @package    Sesavatar
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Images.php  2018-09-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesavatar_Model_DbTable_Images extends Engine_Db_Table {

  protected $_rowClass = 'Sesavatar_Model_Image';
  
  public function getPaginator($params = array()) {
    return Zend_Paginator::factory($this->getImages($params));
  }
  
  public function getImages($params = array()) {
  
    $select = $this->select()->where('file_id <>?', 0)->order('order ASC');
    
    if(isset($params) && $params['enabled'] == 1)
      $select->where('enabled =?', 1);

    if(!empty($params['limit'])) {
      $select->limit($params['limit']);
    }
    if(!empty($params['fetchAll']))
      return $this->fetchAll($select);
    return $select;
  }
}
