<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Create.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Eclassroom_Form_Review_Create extends Engine_Form {
    protected $_reviewId;
    protected $_classroomItem;
    protected $_widgetId;
    public function getReviewId() {
        return $this->_reviewId;
    }
    public function setReviewId($reviewId) {
        $this->_reviewId = $reviewId;
        return $this;
    }
    public function setWidgetId($widgetId) {
      $this->_widgetId = $widgetId;
    }
    public function getClassroomItem() {
        return $this->_classroomItem;
    }
    public function setClassroomItem($classroomItem) {
        $this->_classroomItem = $classroomItem;
        return $this;
    }
    public function init() {
        $setting = Engine_Api::_()->getApi('settings', 'core');
        $this->setAttrib('id', 'eclassroom_review_form');
        $this->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'eclassroom', 'controller' => 'review', 'action' => 'create', 'object_id' => $this->getClassroomItem()->getIdentity()), 'default', true)); 
        $reviewId = $this->getReviewId();
        $item = $this->getClassroomItem();
        if ($reviewId) { 
            $subject = Engine_Api::_()->getItem('eclassroom_review', $reviewId);
        }
        $this->addElement('Dummy', 'review_star', array(
            'label' => 'Review',
            'decorators' => array(array('ViewScript', array(
                'item' => $item,
                'viewScript' => '/application/modules/Eclassroom/views/scripts/review-rating.tpl',
                'class' => 'form element')))
        ));
        $this->addElement('Dummy', 'review_parameters', array(
            'label' => 'Review',
            'decorators' => array(array('ViewScript', array(
                'item' => $item,
                'viewScript' => '/application/modules/Eclassroom/views/scripts/review-parameters.tpl',
                'class' => 'form element')))
        ));
        $this->addElement('Hidden', 'rate_value', array('order' => 878));
        $orderC = 881;
        if (isset($subject)) {
            $reviewParameters = Engine_Api::_()->getDbtable('parametervalues', 'eclassroom')->getParameters(array('content_id' => $subject->getIdentity(), 'user_id' => $subject->owner_id));
            foreach ($reviewParameters as $val) {
                $this->addElement('Hidden', 'review_parameter_value_' . $val['parameter_id'], array('order' => $orderC++, 'value' => $val['rating'], 'class' => "reviewparameter eclassroom_review_values"));
            }
        }
        if ($setting->getSetting('eclassroom.review.title', 1)) {
            $this->addElement('Text', 'title', array(
                'label' => 'Review Title',
                'allowEmpty' => false,
                'required' => true,
                'maxlength' => "255",
            ));
        }
        if ($setting->getSetting('eclassroom.show.pros', 1)) {
            $this->addElement('Text', 'pros', array(
                'label' => 'Pros',
                'allowEmpty' => false,
                'required' => true,
                'maxlength' => "255",
            ));
        }
        if ($setting->getSetting('eclassroom.show.cons', 1)) {
            $this->addElement('Text', 'cons', array(
                'label' => 'Cons',
                'allowEmpty' => false,
                'required' => true,
                'maxlength' => "255",
            ));
        }
        if ($setting->getSetting('eclassroom.review.summary', 1)) {
            $this->addElement('Textarea', 'description', array(
                'label' => 'Description',
                'allowEmpty' => false,
                'required' => true,
                'class' => $setting->getSetting('eclassroom.show.tinymce', 1) ? 'eclassroom_review_tinymce': '',
                'maxlength' => "300",
            ));
        }
        if ($setting->getSetting('eclassroom.show.recommended', 1)) {
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
        $this->addElement('Hidden', 'widget_id',array(
          'order' => 848,
          'value'=> @$this->_widgetId
        ));
        //Buttons
        $this->addElement('Button', 'submit', array(
            'label' => 'Submit',
            'type' => 'submit',
            'ignore' => true,
            'decorators' => array(
                'ViewHelper',
            ),
        ));
        $tabId = Engine_Api::_()->sesbasic()->pageTabIdOnPage('eclassroom.profile-reviews', 'eclassroom_profile_index', 'widget');
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
