<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Controller.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Eclassroom_Widget_OpenHoursController extends Engine_Content_Widget_Abstract {
  public function indexAction() {
    $coreApi = Engine_Api::_()->core();
    if (!$coreApi->hasSubject('classroom'))
      return $this->setNoRender();
    $subject = $coreApi->getSubject();
    $table = Engine_Api::_()->getDbTable('openhours','eclassroom');
    $select = $table->select()
            ->from($table->info('name'))
            ->where('classroom_id =?', $subject->getIdentity());
    $result = $table->fetchRow($select);
    $color = "";
    $data = "";
    $hours = "";
    if($result){
       $params = json_decode($result->params,true);
       if($params['type'] == "selected"){
            unset($params['type']);
            for($i=date('N');$i<8;$i++){
                if(!empty($params[$i])){
                  $time = "";
                  foreach($params[$i] as $key=>$value){
                     $time .=  $value['starttime'].' - '.$value['endtime'].'<br>';
                  }
                  $hours .= '<div class="_day sesbasic_clearfix"><div class="label sesbasic_text_light">'.$this->getDay($i). '</div><div class="time">'.$time.'</div></div>';
                }else{
                  $hours .= '<div class="_day sesbasic_clearfix"><div class="label sesbasic_text_light">'.$this->getDay($i). '</div><div class="time _closed">'.'Closed</div></div>';
                }
            }
            for($i=1;$i<date('N');$i++){
                if(!empty($params[$i])){
                  $time = "";
                  foreach($params[$i] as $key=>$value){
                     $time .=  $value['starttime'].' - '.$value['endtime'].'<br>';
                  }
                  $hours .= '<div class="_day sesbasic_clearfix"><div class="label sesbasic_text_light">'.$this->getDay($i). '</div><div class="time">'.$time.'</div></div>';
                }else{
                  $hours .= '<div class="_day sesbasic_clearfix"><div class="label sesbasic_text_light">'.$this->getDay($i). '</div><div class="time _closed">'.'Closed</div></div>';
                }
            }
       }else if($params['type'] == "always"){
           $color = "green";
           $data = "Always Open";
       }else if($params['type'] == "notavailable"){
         return $this->setNoRender();
       }else if($params['type'] == "closed"){
           $color = "red";
           $data = "Permanently closed";
       }
    }else
        return $this->setNoRender();
    $this->view->hours = $hours;
    $this->view->data = $data;
    $this->view->color = $color;
		$this->view->result = $result;
  }

  function getDay($number){
    switch($number){
      case 1:
        return "Monday";
      break;
      case 2:
        return "Tuesday";
      break;
      case 3:
        return "Wednesday";
      break;
      case 4:
        return "Thursday";
      break;
      case 5:
        return "Friday";
      break;
      case 6:
        return "Saturday";
      break;
      case 7:
        return "Sunday";
      break;
    }
  }
}
