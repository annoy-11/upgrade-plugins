<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Request.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesgroup_Form_Member_Request extends Engine_Form {

  public function init() {
    $this
            ->setTitle('Request Group Membership')
            ->setDescription('Would you like to request membership in this Group?')
            ->setMethod('POST')
            ->setAction($_SERVER['REQUEST_URI']);
    $groupId = Zend_Controller_Front::getInstance()->getRequest()->getParam('group_id', 0);
    $group = Engine_Api::_()->getItem('sesgroup_group', $groupId);
    if (!empty($group->questitle1)) {
      $this->addElement('Textarea', 'answerques1', array(
          'label' => $group->questitle1,
          'description' => '',
          'allowEmpty' => false,
          'required' => true,
      ));
    }
    if (!empty($group->questitle2)) {
      $this->addElement('Textarea', 'answerques2', array(
          'label' => $group->questitle2,
          'description' => '',
          'allowEmpty' => false,
          'required' => true,
      ));
    }
    if (!empty($group->questitle3)) {
      $this->addElement('Textarea', 'answerques3', array(
          'label' => $group->questitle3,
          'description' => '',
          'allowEmpty' => false,
          'required' => true,
      ));
    }
    if (!empty($group->questitle4)) {
      $this->addElement('Textarea', 'answerques4', array(
          'label' => $group->questitle4,
          'description' => '',
          'allowEmpty' => false,
          'required' => true,
      ));
    }
    if (!empty($group->questitle5)) {
      $this->addElement('Textarea', 'answerques5', array(
          'label' => $group->questitle5,
          'description' => '',
          'allowEmpty' => false,
          'required' => true,
      ));
    }
    $ruleTable = Engine_Api::_()->getDbTable('rules', 'sesgroup') ;
    $select = $ruleTable->select()
            ->from($ruleTable->info('name'))
            ->where('group_id =?', $groupId);
    $rules = $ruleTable->fetchAll($select);
    if(empty($_GET['sesapi_platform']) || $_GET['sesapi_platform'] == 2){
      foreach ($rules as $rule) {
        $dummyTitle = "dummytitle".$rule->rule_id;
        $dummyBody = "dummybody".$rule->rule_id;
        $this->addElement('Dummy', $dummyTitle, array(
            'label' => "$rule->title",
        ));
        $this->getElement($dummyTitle)->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
         $this->addElement('Dummy', $dummyBody, array(
            'label' => "$rule->body",
        ));
        $this->getElement($dummyBody)->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
      }
    }else{
      foreach ($rules as $rule) {
        $dummyTitle = "dummytitle".$rule->rule_id;
        $dummyBody = "dummybody".$rule->rule_id;
        $this->addElement('Text', $dummyTitle, array(
            'description' => "$rule->title",
            'label'=>'',
        ));
        //$this->getElement($dummyTitle)->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
         $this->addElement('Text', $dummyBody, array(
            'description' => "$rule->body",
            'label'=>'',
        ));
        //$this->getElement($dummyBody)->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
      }
    }
    $this->addElement('Button', 'submit', array(
        'label' => 'Send Request',
        'ignore' => true,
        'decorators' => array('ViewHelper'),
        'type' => 'submit'
    ));

    $this->addElement('Cancel', 'cancel', array(
        'prependText' => ' or ',
        'label' => 'cancel',
        'link' => true,
        'href' => '',
        'onclick' => 'parent.Smoothbox.close();',
        'decorators' => array(
            'ViewHelper'
        ),
    ));

    $this->addDisplayGroup(array(
        'submit',
        'cancel'
            ), 'buttons');
  }

}
