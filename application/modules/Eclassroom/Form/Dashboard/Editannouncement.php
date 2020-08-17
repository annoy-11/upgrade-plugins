<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Editannouncement.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Eclassroom_Form_Dashboard_Editannouncement extends Eclassroom_Form_Dashboard_Postannouncement {

  public function init() {
    parent::init();
    $this->setDescription('');
    $this->removeElement('cancel');
    $this->setTitle('Edit Announcement');
  }

}
