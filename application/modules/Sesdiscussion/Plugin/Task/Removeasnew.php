<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdiscussion
 * @package    Sesdiscussion
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Removeasnew.php  2018-12-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesdiscussion_Plugin_Task_Removeasnew extends Core_Plugin_Task_Abstract {

  public function execute() {
  
    $db = Engine_Db_Table::getDefaultAdapter();
    
    if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.automaticallymarkasnew', 0)) {
      
      $days = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.newdays', 2);
      
      $discussionTable = Engine_Api::_()->getDbTable('discussions', 'sesdiscussion');
      $discussionTableName = $discussionTable->info('name');
      
      $minustime =  strtotime(date('Y-m-d H:i:s', strtotime('-'.$days.' day')));
      
      $select = $discussionTable->select()
                ->from($discussionTableName)
                ->where('new =?', 1)
                ->where("creation_date <= FROM_UNIXTIME(?)", $minustime);
      $paginator = Zend_Paginator::factory($select);
      foreach($paginator as $discussion) {
        $discussion->new = 0;
        $discussion->save();
      }
    }
  }
}