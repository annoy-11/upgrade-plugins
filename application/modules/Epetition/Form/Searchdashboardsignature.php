<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Searchdashboardsignature.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Epetition_Form_Searchdashboardsignature extends Engine_Form
{
   public function  init()
   {
     $this->addElement('text', 'name', array(
       'label' => 'Search By Name',
     ));
     $this->addElement('text', 'from_date', array(
       'label' => 'Search By From Date',
       'description'=>'Enter Date in (YYYY-mm-dd) formate'
     ));
     $this->addElement('text', 'to_date', array(
       'label' => 'Search By To Date',
       'description'=>'Enter Date in (YYYY-mm-dd) formate'
     ));
     $this->addElement('Hidden','user_id',array('order'=>999));
     $this->addElement('Button', 'submit', array(
       'label' => 'Submit',
       'type' => 'submit',
       'ignore' => true
     ));


   }
}
