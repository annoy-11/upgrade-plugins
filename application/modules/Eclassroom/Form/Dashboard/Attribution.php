<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Attribution.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Eclassroom_Form_Dashboard_Attribution extends Engine_Form {
  protected $_classroomItem;
  public function getClassroomItem() {
    return $this->_classroomItem;
  }

  public function setClassroomItem($classroomItem) {
    $this->_classroomItem = $classroomItem;
    return $this;
  }
  public function init() {
    parent::init();
    //get current logged in user
    $this->setTitle('Post Attribution')
            ->setAttrib('id', 'classroom_attr_form')
            ->setAttrib('enctype', 'multipart/form-data')
            ->setMethod("POST");

    $attribution[1] = '<b>Post as '.$this->_classroomItem->getTitle().'</b><br>Your posts, likes and comments on this Classroom\'s timeline will be attributed to the Classroom by default. When you\'re creating or replying to a post, you will still have the option to post as yourself or another Classroom you manage.';

    $attribution[0] = '<b>Post as '.Engine_Api::_()->user()->getViewer()->getTitle().'</b></br>Your posts, likes and comments on this Classroom\'s timeline will be attributed to you by default. When you\'re creating or replying to a post, you will still have the option to post as this Classroom or another Classroom you manage.';

    $this->addElement('Radio', 'attribution', array(
          'label' => '',
          'description' => '',
          'multiOptions' => $attribution,
          'escape' => false,
      ));
  }
}
