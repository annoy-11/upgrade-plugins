<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesbrowserpush
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Jobs.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbrowserpush_Plugin_Task_Jobs extends Core_Plugin_Task_Abstract {
  public function execute() {
    $table = Engine_Api::_()->getDbTable('scheduleds','sesbrowserpush');
    $tableName = $table->info('name');
    $select = $table->select()->from($tableName)->where('scheduled_time IS NOT NULL AND scheduled_time != ""')->where('scheduled_time <= ?',date('Y-m-d H:i:s'))->where('sent =?',0);
    $results = $table->fetchAll($select);
    foreach($results as $values){
      Engine_Api::_()->sesbrowserpush()->sendNotification($values);
    }
  }
}
