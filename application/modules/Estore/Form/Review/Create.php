<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Create.php 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Estore_Form_Review_Create extends Engine_Form {


  protected $_reviewId;

  public function getReviewId() {
    return $this->_reviewId;
  }

  public function setReviewId($reviewId) {
    $this->_reviewId = $reviewId;
    return $this;
  }

  protected $_storeItem;

  public function getStoreItem() {
    return $this->_storeItem;
  }

  public function setStoreItem($storeItem) {
    $this->_storeItem = $storeItem;
    return $this;
  }

  public function init() {

    $this->setAttrib('id', 'estore_review_form');


    $this->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'estore', 'controller' => 'review', 'action' => 'create', 'object_id' => $this->getStoreItem()->getIdentity()), 'default', true));
    $reviewId = $this->getReviewId();

    $item = $this->getStoreItem();
    if ($reviewId) {
      $subject = Engine_Api::_()->getItem('estore_review', $reviewId);
    }

    $this->addElement('Dummy', 'review_star', array(
        'label' => 'Review',
        'decorators' => array(array('ViewScript', array(
                    'item' => $item,
                    'viewScript' => '/application/modules/Estore/views/scripts/review-rating.tpl',
                    'class' => 'form element')))
    ));

    $this->addElement('Dummy', 'review_parameters', array(
        'label' => 'Review',
        'decorators' => array(array('ViewScript', array(
                    'store' => $item,
                    'viewScript' => '/application/modules/Estore/views/scripts/review-parameters.tpl',
                    'class' => 'form element')))
    ));

    $this->addElement('Hidden', 'rate_value', array('order' => 878));
    $orderC = 881;
    if (isset($subject)) {
      $reviewParameters = Engine_Api::_()->getDbtable('parametervalues', 'estore')->getParameters(array('content_id' => $subject->getIdentity(), 'user_id' => $subject->owner_id));
      foreach ($reviewParameters as $val) {
        $this->addElement('Hidden', 'review_parameter_value_' . $val['parameter_id'], array('order' => $orderC++, 'value' => $val['rating'], 'class' => "estore_review_values"));
      }
    }
    if (Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.review.title', 1)) {
      $this->addElement('Text', 'title', array(
          'label' => 'Review Title',
          'allowEmpty' => false,
          'required' => true,
          'maxlength' => "255",
      ));
    }
    if (Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.show.pros', 1)) {
      $this->addElement('Text', 'pros', array(
          'label' => 'Pros',
          'allowEmpty' => false,
          'required' => true,
          'maxlength' => "255",
      ));
    }
    if (Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.show.cons', 1)) {
      $this->addElement('Text', 'cons', array(
          'label' => 'Cons',
          'allowEmpty' => false,
          'required' => true,
          'maxlength' => "255",
      ));
    }
    if (Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.show.tinymce', 1)) {
      $this->addElement('Textarea', 'description', array(
          'label' => 'Description',
          'allowEmpty' => false,
          'required' => true,
          'class' => 'estore_review_tinymce',
          'maxlength' => "300",
      ));
    }else{
			$this->addElement('Textarea', 'description', array(
          'label' => 'Description',
          'allowEmpty' => false,
          'required' => true,
          'maxlength' => "300",
      ));
		}
    if (Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.show.recommended', 1)) {
      $this->addElement('Radio', 'recommended', array(
          'label' => 'Recommended',
          'description' => 'Do you recommend this review to user?',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
          ),
          'value' => 1,
      ));
    }
    //Buttons
    $this->addElement('Button', 'submit', array(
        'label' => 'Submit',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array(
            'ViewHelper',
        ),
    ));
    $tabId = Engine_Api::_()->sesbasic()->pageTabIdOnPage('estore.member-reviews', 'user_profile_index', 'widget');
    $tabData = '';
    if ($tabId) {
      $tabData = '/tab/' . $tabId->content_id;
    }
    $this->addElement('Cancel', 'cancel', array(
        'label' => 'cancel',
        'link' => true,
        'href' => 'javascript:void(0);',
        'onclick' => 'closeReviewForm();',
        'prependText' => ' or ',
        'decorators' => array(
            'ViewHelper',
        ),
    ));
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons', array(
        'decorators' => array(
            'FormElements',
            'DivDivDivWrapper',
        ),
    ));
  }

}
