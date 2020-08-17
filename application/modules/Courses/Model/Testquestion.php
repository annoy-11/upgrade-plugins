<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Testquestion.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Courses_Model_Testquestion extends Core_Model_Item_Abstract
{
  // Properties
	protected $_searchTriggers = true;
  public function getCurrectAnswsers()
  {
    $table = Engine_Api::_()->getItemTable('courses_testanswer');
    $data =  $table->select()->from($table->info('name'),'testanswer_id')
              ->where('testquestion_id =?', $this->testquestion_id)
              ->where('is_true = ?', 1)->query()->fetchAll();
    foreach($data as $value){
      $courrectAnswers[] = $value['testanswer_id'];
    }
   return $courrectAnswers;
  }
}
