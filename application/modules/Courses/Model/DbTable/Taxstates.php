<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Taxstates.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Courses_Model_DbTable_Taxstates extends Engine_Db_Table {
  protected $_rowClass = 'Courses_Model_Taxstate';
  function getStates($params = array()){
      $tableName = $this->info('name');
      $select = $this->select()->from($tableName,'*')->setIntegrityCheck(false);
      $stateTable = Engine_Api::_()->getDbTable('states','courses')->info('name');
      $countryTable = Engine_Api::_()->getDbTable('countries','courses')->info('name');
      $select->joinLeft($countryTable,$countryTable.".country_id =".$tableName.".country_id",array('country_name' => 'name'));
      $select->joinLeft($stateTable,$stateTable.".state_id =".$tableName.".state_id",array('state_name' => 'name'));
      if(isset($_GET['status'])){
          $select->where('status =?',$_GET['status']);
      }
      $select->where('tax_id =?',$params['tax_id']);
      if(isset($_GET['tax_type'])){
          $select->where('tax_type =?',$_GET['tax_type']);
      }
      if(isset($_GET['title'])){
          $select->where("title LIKE ? ", '%' . $_GET['title'] . '%');
      }
      $select->order('taxstate_id DESC');
      return Zend_Paginator::factory($select);
  }
  function getOrderTaxes($params = array()){
        $user_billing_country = @$params['user_billing_country'];
        $user_billing_state = @$params['user_billing_state'];
        $select = $this->select()->from($this->info('name'),'*');

        $select->where("CASE WHEN type = 1 AND (country_id = 0 OR country_id = '".$user_billing_country ."') AND (state_id = 0 OR state_id = '".$user_billing_state."') THEN true ELSE false END");
     
        $select->where($this->info('name').'.status =?',1);
        $select->setIntegrityCheck(false)
                ->joinLeft('engine4_courses_taxes','engine4_courses_taxes.tax_id = '.$this->info('name').'.tax_id','title');
        $select->where('engine4_courses_taxes.course_id =?',$params['course_id']);
        $select->where('engine4_courses_taxes.status =?',1);
        $taxes = $this->fetchAll($select); 
        $taxArray = array();
        $orderPrice = $params['total_price'];
        $totalTaxPrice = 0;
        foreach($taxes as $tax){
            if($tax['tax_type'] == 0){
                //fixed price
               $price  = round($tax->value,2);
            }else{
                //percentage price
                $price = @round(($tax->value / 100) * $params['total_price'], 2);
            }
            if(!empty($taxArray[$tax->tax_id]['price'])){
                $price += $taxArray[$tax->tax_id]['price'];
            }
            $taxArray[$tax->tax_id]['tax_id'] = $tax->getIdentity();
            $taxArray[$tax->tax_id]['tax_title'] = $tax->title;
            $taxArray[$tax->tax_id]['price'] = $price;
            $totalTaxPrice += $price;
        }
        return array('taxes'=>$taxArray,'total_tax'=>$totalTaxPrice);
    }
}
