<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagereview
 * @package    Sespagereview
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Add.php  2018-11-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespagereview_Form_Admin_Parameter_Add extends Engine_Form {

  public function init() {

    $this->setMethod('post');
    $category_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id', 0);
    $reviewParameters = Engine_Api::_()->getDbtable('parameters', 'sespagereview')->getParameterResult(array('category' => $category_id));
    $this->setMethod('post');
    if (count($reviewParameters)) {
      foreach ($reviewParameters as $val) {
        $this->addElement('Text', 'sespagereview_review_' . $val['parameter_id'], array(
            'label' => '',
            'class' => 'sespagereview_added_parameter',
            'allowEmpty' => true,
            'value' => $val['title'],
            'required' => false,
            'maxlength' => "255",
        ));
      }
    }
    $this->addElement('Dummy', 'addmore', array('content' => '
      <div><input type="text" name="parameters[]" value="" class="reviewparameter"><a href="javascript:;" class="removeAddedElem fa fa-trash">Remove</a></div>
      <a href="javascript:;" id="addmoreelem" class="fa fa-plus">Add more parameters</a>
    '));
    $this->addElement('Hidden', 'deletedIds', array('order' => 999));
    $this->addElement('Button', 'submit', array(
        'label' => 'Add',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper')
    ));
    $this->addElement('Cancel', 'cancel', array(
        'label' => 'Cancel',
        'link' => true,
        'prependText' => ' or ',
        'href' => '',
        'onClick' => 'javascript:parent.Smoothbox.close();',
        'decorators' => array(
            'ViewHelper'
        )
    ));
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
  }

}