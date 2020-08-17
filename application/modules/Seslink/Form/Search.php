<?php

class Seslink_Form_Search extends Engine_Form
{
  public function init()
  {
    $this
      ->setAttribs(array(
        'id' => 'filter_form',
        'class' => 'global_form_box',
      ))
      ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()))
      ->setMethod('GET')
      ;
    
    $this->addElement('Text', 'search', array(
      'label' => 'Search Links',
    ));
    
    $request = Zend_Controller_Front::getInstance()->getRequest();
    $getModuleName = $request->getModuleName();
    $getControllerName = $request->getControllerName();
    $getActionName = $request->getActionName();

    if($getActionName != 'manage') {
    
      $this->addElement('Select', 'orderby', array(
        'label' => 'Popularity Criteria',
        'multiOptions' => array(
          '' => '',
          'creation_date' => 'Recently Created',
          'like_count' => 'Most Liked',
          'comment_count' => 'Most Commented',
          'view_count' => 'Most Viewed',
          'modified_date' => 'Recently Modified',
        ),
      ));
      
      $this->addElement('Select', 'show', array(
        'label' => 'Show',
        'multiOptions' => array(
          '1' => 'Everyone\'s Links',
          '2' => 'Only My Friends\' Links',
        ),
      ));
    }

    $this->addElement('Button', 'find', array(
      'type' => 'submit',
      'label' => 'Search',
      'ignore' => true,
      'order' => 10000001,
    ));

    $this->addElement('Hidden', 'page', array(
      'order' => 100
    ));

    $this->addElement('Hidden', 'tag', array(
      'order' => 101
    ));

  }
}