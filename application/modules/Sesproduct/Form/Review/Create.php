<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Create.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesproduct_Form_Review_Create extends Engine_Form {


    protected $_reviewId;

    public function getReviewId() {
        return $this->_reviewId;
    }

    public function setReviewId($reviewId) {
        $this->_reviewId = $reviewId;
        return $this;
    }

    protected $_storeItem;

    public function getProductItem() {
        return $this->_storeItem;
    }

    public function setProductItem($storeItem) {
        $this->_storeItem = $storeItem;
        return $this;
    }

    public function init() {

        $this->setAttrib('id', 'sesproduct_review_form');


        $this->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sesproduct', 'controller' => 'review', 'action' => 'create', 'object_id' => $this->getProductItem()->getIdentity()), 'default', true));
        $reviewId = $this->getReviewId();

        $item = $this->getProductItem();
        if ($reviewId) {
            $subject = Engine_Api::_()->getItem('sesproductreview', $reviewId);
        }

        $this->addElement('Dummy', 'review_star', array(
            'label' => 'Review',
            'decorators' => array(array('ViewScript', array(
                'item' => $item,
                'viewScript' => '/application/modules/Sesproduct/views/scripts/review-rating.tpl',
                'class' => 'form element')))
        ));

        $this->addElement('Dummy', 'review_parameters', array(
            'label' => 'Review',
            'decorators' => array(array('ViewScript', array(
                'product' => $item,
                'viewScript' => '/application/modules/Sesproduct/views/scripts/review-parameters.tpl',
                'class' => 'form element')))
        ));

        $this->addElement('Hidden', 'rate_value', array('order' => 878));
        $orderC = 881;
        if (isset($subject)) {
            $reviewParameters = Engine_Api::_()->getDbtable('parametervalues', 'sesproduct')->getParameters(array('content_id' => $subject->getIdentity(), 'user_id' => $subject->owner_id));
            foreach ($reviewParameters as $val) {
                $this->addElement('Hidden', 'review_parameter_value_' . $val['parameter_id'], array('order' => $orderC++, 'value' => $val['rating'], 'class' => "reviewparameter sesproduct_review_values"));
            }
        }
        if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.review.title', 1)) {
            $this->addElement('Text', 'title', array(
                'label' => 'Review Title',
                'allowEmpty' => false,
                'required' => true,
                'maxlength' => "255",
            ));
        }
        if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.show.pros', 1)) {
            $this->addElement('Text', 'pros', array(
                'label' => 'Pros',
                'allowEmpty' => false,
                'required' => true,
                'maxlength' => "255",
            ));
        }
        if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.show.cons', 1)) {
            $this->addElement('Text', 'cons', array(
                'label' => 'Cons',
                'allowEmpty' => false,
                'required' => true,
                'maxlength' => "255",
            ));
        }
        if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.review.summary', 1)) {
            $this->addElement('Textarea', 'description', array(
                'label' => 'Description',
                'allowEmpty' => false,
                'required' => true,
                'class' => 'sesproduct_review_tinymce',
                'maxlength' => "300",
            ));
        }
        if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.show.recommended', 1)) {
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
        $tabId = Engine_Api::_()->sesbasic()->pageTabIdOnPage('sesproduct.profile-reviews', 'sesproduct_profile_index', 'widget');
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
