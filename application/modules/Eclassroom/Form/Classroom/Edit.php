<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Edit.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Eclassroom_Form_Classroom_Edit extends Eclassroom_Form_Classroom_Create {
  public function init() {
    parent::init();
    $this->setDescription('Edit your Classroom below, then click "Save Changes" to publish the Classroom.');
    $this->removeElement('cancel');
	$this->setTitle('Edit Classroom');
  }
}
