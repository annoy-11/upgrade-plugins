<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagereview
 * @package    Sespagereview
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Create.php  2018-11-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespagereview_Form_Review_Create extends Engine_Form {

  protected $_pageId;
  public function getPageId() {
    return $this->_pageId;
  }
  public function setPageId($pageId) {
    $this->_pageId = $pageId;
    return $this;
  }
  protected $_reviewId;
  public function getReviewId() {
    return $this->_reviewId;
  }
  public function setReviewId($reviewId) {
    $this->_reviewId = $reviewId;
    return $this;
  }
  public function init() {

    $this->setAttrib('id', 'sespagereview_review_form');
    $settings = Engine_Api::_()->getApi('settings', 'core');
    if ($this->getPageId()) {
      $objectId = $this->getPageId();
    } else {
      $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id');
      $objectId = Engine_Api::_()->getItem('sespage_page', $id)->page_id;
    }
    $this->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sespagereview', 'controller' => 'review', 'action' => 'create', 'object_id' => $objectId), 'default', true));
    $reviewId = $this->getReviewId();
    if ($this->getPageId())
      $item = Engine_Api::_()->getItem('sespage_page', $this->getPageId());
    else
      $item = Engine_Api::_()->core()->getSubject();
    if ($reviewId) {
      $subject = Engine_Api::_()->getItem('pagereview', $reviewId);
    }
		$restapi=Zend_Controller_Front::getInstance()->getRequest()->getParam( 'restApi', null );
		if($restapi){
			$translate = Zend_Registry::get('Zend_Translate');
			$this->addElement('text', 'rate_value', 
			array(
			'label' => $translate->translate("SESPAGEOverall Rating")
			));
			$reviewParameters = Engine_Api::_()->getDbtable('parameters', 'sespagereview')->getParameterResult(array('category'=>$item->category_id));
		
		if(count($reviewParameters)){
			$i = 1;
			foreach($reviewParameters as $value){
				$this->addElement('text', 'review_parameter_value_'.$i, 
					array(
					'label' => $translate->translate($value['title']),
					'value' => $subject ? $value['rating'] : 0 
				));
				$i++;
			}
		}
		}else{
			$this->addElement('Dummy', 'review_star', array(
					'label' => 'Review',
					'decorators' => array(array('ViewScript', array(
											'item' => $item,
											'viewScript' => '/application/modules/Sespagereview/views/scripts/review-rating.tpl',
											'class' => 'form element')))
			));
			$this->addElement('Dummy', 'review_parameters', array(
					'label' => 'Review',
					'decorators' => array(array('ViewScript', array(
											'category_id' => $item->category_id,
											'viewScript' => '/application/modules/Sespagereview/views/scripts/review-parameters.tpl',
											'class' => 'form element')))
			));
			$this->addElement('Hidden', 'rate_value', array('order' => 878));
		}
    
    $orderC = 881;
    if (isset($subject)) {
      $reviewParameters = Engine_Api::_()->getDbtable('parametervalues', 'sespagereview')->getParameters(array('content_id' => $subject->getIdentity(), 'page_id' => $subject->page_id));
      foreach ($reviewParameters as $val) {
        $this->addElement('Hidden', 'review_parameter_value_' . $val['parameter_id'], array('order' => $orderC++, 'value' => $val['rating'], 'class' => "sespagereview_review_values"));
      }
    }
    if ($settings->getSetting('sespagereview.review.title', 1)) {
      $this->addElement('Text', 'title', array(
          'label' => 'Review Title',
          'allowEmpty' => false,
          'required' => true,
          'maxlength' => "255",
      ));
    }
    if ($settings->getSetting('sespagereview.show.pros', 1)) {
      $this->addElement('Text', 'pros', array(
          'label' => 'Pros',
          'allowEmpty' => false,
          'required' => true,
          'maxlength' => "255",
      ));
    }
    if ($settings->getSetting('sespagereview.show.cons', 1)) {
      $this->addElement('Text', 'cons', array(
          'label' => 'Cons',
          'allowEmpty' => false,
          'required' => true,
          'maxlength' => "255",
      ));
    }
    if ($settings->getSetting('sespagereview.review.summary', 1)) {
      $this->addElement('Textarea', 'description', array(
          'label' => 'Description',
          'allowEmpty' => false,
          'required' => true,
          'class' => ($settings->getSetting('sespagereview.show.tinymce', 1)) ? 'sespagereview_review_tinymce' : '',
          'maxlength' => "300",
      ));
    }
    if ($settings->getSetting('sespagereview.show.recommended', 1)) {
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
    $tabId = Engine_Api::_()->sesbasic()->pageTabIdOnPage('sespagereview.page-reviews', 'sespage_profile_index_'.$item->pagestyle, 'widget');
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
