<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesemoji
 * @package    Sesemoji
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Emojis.php  2017-11-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesemoji_Model_DbTable_Emojis extends Engine_Db_Table {

  protected $_rowClass = 'Sesemoji_Model_Emoji';
  
  public function getPaginator($params = array()) {
  
    return Zend_Paginator::factory($this->getEmojis($params));
  }
  
  public function getEmojis($params = array()) {
    

    $select = $this->select()->order('order ASC');
    if(empty($params['admin'])) {
        $viewer = Engine_Api::_()->user()->getViewer();
        
        $enableEmojisCategories = (array) Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('sesemoji', $viewer, 'emojiscategories');
        if(!empty($enableEmojisCategories)) {
        $select->where('emoji_id IN (?)', $enableEmojisCategories);
        }
    }


    if(!empty($params['fetchAll'])){
      return $this->fetchAll($select);  
    }
    return $select;
    
  }
}