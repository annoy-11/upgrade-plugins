<?php

class Estore_Form_Admin_Createslide extends Engine_Form {

  public function init() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $url = "https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyDczHMCNc0JCmJACM86C7L8yYdF9sTvz1A";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $data = curl_exec($ch);
    curl_close($ch);
    $results = json_decode($data,true);
    $googleFontArray = array();
    foreach($results['items'] as $re) {
      $googleFontArray['"'.$re["family"].'"'] = $re['family'];
    }

    $this
            ->setTitle('Upload New Offer Block')
            ->setDescription("Below, You can upload new offer block and configure various settings.")
            ->setAttrib('id', 'form-create-offer')
            ->setAttrib('name', 'estore_create_offer')
            ->setAttrib('enctype', 'multipart/form-data')
            ->setAttrib('onsubmit', 'return checkValidation();')
            ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()));

    $this->setMethod('post');
    $this->addElement('Text', 'title', array(
        'label' => 'Caption',
        'description' => 'Enter the caption for this offer block.',
        'allowEmpty' => true,
        'required' => false,
    ));


    $this->addElement('Textarea', 'description', array(
        'label' => 'Description',
        'description' => 'Enter the description for this offer block.',
        'allowEmpty' => true,
        'required' => false,
    ));

    $this->addElement('Text', 'url', array(
        'label' => 'Block URL',
        'description' => 'Enter URL of the page on which you want redirect your users when they click this offer block.',
        'allowEmpty' => true,
        'required' => false,
    ));

    $offer_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('slide_id', 0);
		if($offer_id)
			$offer = Engine_Api::_()->getItem('estore_slides', $offer_id);
		else
			$offer = '';
    if (!$offer_id) {
      $required = true;
      $allowEmpty = false;
    } else {
      $required = false;
      $allowEmpty = false;
    }

    $this->addElement('File', 'file', array(
        'allowEmpty' => $allowEmpty,
        'required' => $required,
        'label' => 'Choose Photo',
        'description' => 'Choose the photo. [Note: only the photos with extension: “.jpg, .png and .jpeg are allowed.]',
    ));
    $this->file->addValidator('Extension', false, 'jpg,png,jpeg');

		if(!empty($offer) && $offer->file_id){
			$ImageSrc = Engine_Api::_()->storage()->get($offer->file_id, '');
			if($ImageSrc){
				$ImageSrc = $ImageSrc->getPhotoUrl();
				$this->addElement('Dummy', 'imagedummy_1', array(
				 'content' => '<img src="'.$ImageSrc.'" alt="image" height="100" width="100">',
				));
			}
		}

    // Buttons
    $this->addElement('Button', 'submit', array(
        'label' => 'Create',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper')
    ));
    $this->addElement('Cancel', 'cancel', array(
        'label' => 'Cancel',
        'link' => true,
        'prependText' => ' or ',
        'href' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'index')),
        'onClick' => 'javascript:parent.Smoothbox.close();',
        'decorators' => array(
            'ViewHelper'
        )
    ));
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
  }

}
