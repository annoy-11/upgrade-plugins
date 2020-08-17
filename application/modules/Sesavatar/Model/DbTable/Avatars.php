<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesavatar
 * @package    Sesavatar
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Avatars.php  2018-09-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesavatar_Model_DbTable_Avatars extends Engine_Db_Table {

  protected $_rowClass = 'Sesavatar_Model_Avatar';

  public function rowExists($id) {

    $db = Engine_Db_Table::getDefaultAdapter();

    $select = $this->select()
                    ->where('user_id = ?', $id)
                    ->limit(1);
    $results = $this->fetchRow($select);
    return $results;
  }

  public function removeExists($like_id) {

    $db = Engine_Db_Table::getDefaultAdapter();

    $db->query('DELETE FROM `engine4_sesadvancedactivity_activitylikes` WHERE `engine4_sesadvancedactivity_activitylikes`.`activity_like_id` = "'.$like_id.'";');
  }

  public function isRowExists($id, $file_id = 0, $type = 'avatar') {

    $db = Engine_Db_Table::getDefaultAdapter();
    
    $viewer = Engine_Api::_()->user()->getViewer();
    $viewer_id = $viewer->getIdentity();
    
    $avatar_id = $this->select()
            ->from($this->info('name'), 'avatar_id')
            ->where('user_id =?', $id)
            ->query()
            ->fetchColumn();

    if(empty($avatar_id)) {
    
        $row = $this->createRow();
        $row->user_id = $viewer_id;
        $row->userphoto_id = $viewer->photo_id;
        
        if($type == 'avatar') {
          $row->image_id = $file_id;
        } else if($type == 'ingo') {
          $row->avatar_ingo_id = $file_id;
          $row->modified_date = date('Y-m-d H:i:s');
        }
        $row->save();
        
        //Save in user table for
        $viewer->photo_id = $file_id;
        $viewer->save();
        
        return $row;
    } else if(!empty($avatar_id)) {

      if($type == 'avatar') {
        $db->update('engine4_sesavatar_avatars', array('image_id' => $file_id, 'modified_date' => date('Y-m-d H:i:s')), array('avatar_id =?' => $avatar_id, 'user_id =?' => $id));
      } else if($type == 'ingo') {
        $db->update('engine4_sesavatar_avatars', array('avatar_ingo_id' => $file_id, 'modified_date' => date('Y-m-d H:i:s')), array('avatar_id =?' => $avatar_id, 'user_id =?' => $id));
      }
      
      //Save in user table for
      $viewer->photo_id = $file_id;
      $viewer->save();
    }
  }
}
