<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesbrowserpush
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Notification.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbrowserpush_Form_Admin_Settings_Notification extends Engine_Form
{
  public function init()
  {
    $description = $this->getTranslator()->translate('Here you can configure the push notification message and send to all subscribers of your choice. You can also upload image and add URL to your message. You can also test the Push Notification by sending it to Test users first by using the "Send To Test Users" button. You can choose to make any subscriber a test user from the "<a href="admin/sesbrowserpush/settings/subscriber">Manage Subscribers</a>" section of this plugin..');

	// Decorators
    $this->loadDefaultDecorators();
	$this->getDecorator('Description')->setOption('escape', false);

    $this->setTitle('Send Web & Mobile Push Notifications')
            ->setDescription($description);

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;

    $cri = array('all'=>'All Subscribed User','memberlevel'=>'Member Level','network'=>'Network','user'=>'Particular User');

    $tokenTable = Engine_Api::_()->getDbTable('tokens','sesbrowserpush');
    $select = $tokenTable->select()->from($tokenTable->info('name'),array('total_user'=>new Zend_Db_Expr('COUNT(token_id)'),'browser'))
                        ->group('browser');
    $tokenResult = $tokenTable->fetchAll($select);
    if(count($tokenResult)){
      foreach($tokenResult as $token){
        $cri[$token->browser] = $token->browser .' Users('.$token->total_user.')' ;
      }
    }
    $levels = Engine_Api::_()->getDbTable('levels','authorization')->getLevelsAssoc();
    if(!count($levels))
      unset($cri['memberlevel']);

     $table = Engine_Api::_()->getItemTable('network');
     $select = $table->select()
      ->where('assignment = ?', 0)
      ->order('title ASC');
    $networks = $table->fetchAll($select);

    if(!count($networks))
      unset($cri['network']);
    else{
      foreach($networks as $network)
        $networkArr[$network->getIdentity()] = $network->getTitle();
    }
    $this->addElement('Select', "criteria", array(
      'label' => 'Choose Subscribers',
      'description' => 'Choose from below the subscribers to whom you want to send this push notification message.',
      'allowEmpty' => false,
      'required' => true,
      'multiOptions'=>$cri,
      'onchange'=>'criteriaOpen(this.value);',
      'value' => '',
		));
   if(count($levels)){
    $this->addElement('Select', "memberlevel", array(
      'label' => 'Choose Member Level',
      'description' => 'Choose Member Level from below. Subscribers belonging to selected member level will receive the notification.',
      'allowEmpty' => false,
      'required' => true,
      'multiOptions'=>$levels,
      'value' => '',
		));
   }
   if(count($network)){
        $this->addElement('Select', "network", array(
        'label' => 'Choose Network',
        'description' => 'Choose Network from below. Subscribers belonging to selected member level will receive the notification.',
        'allowEmpty' => false,
        'required' => true,
        'multiOptions'=>$networkArr,
        'value' => '',
        ));
   }

   $this->addElement('Text', 'to',array(
        'label'=>'Select Particular User',
		'description' => 'Start by typing a user name and select the name from the auto-suggest below.',
        'autocomplete'=>'off'));

    Engine_Form::addDefaultDecorators($this->to);
    $this->addElement('Hidden', 'token_id', array(
      'required' => false,
      'allowEmpty' => true,
      'order' => 5,
    ));
    // Init to Values
    $this->addElement('Hidden', 'toValues', array(
      'label' => 'Send To',
      'required' => false,
      'allowEmpty' => true,
      'order' => 4,
      'validators' => array(
        'NotEmpty'
      ),
      'filters' => array(
        'HtmlEntities'
      ),
    ));
    Engine_Form::addDefaultDecorators($this->toValues);

		$this->addElement('Text', "title", array(
      'label' => 'Push Notification Title',
      'description' => 'Enter the title of this push notification.',
      'allowEmpty' => false,
      'required' => true,
		));

    $this->addElement('Textarea', "description", array(
		'label' => 'Push Notification Message',
		'description' => 'Enter the message of this push notification.',
		'allowEmpty' => true,
		'required' => false,
		));


    $this->addElement('Text', "link", array(
      'label' => 'Redirect URL',
      'description' => 'Enter the URL on which you want to redirect subscribers when they click on this push notification (Enter full url like: http://www.yourwebsite.com or https://www.yourwebsite.com ).',
      'allowEmpty' => true,
      'required' => false,
      'value' => '',
		));

    $this->addElement('File', 'icon', array(
        'label' => 'Upload Image',
        'description' => 'Choose a photo to be sent in this push notification. Recommended dimension for the image is 100 x 100 pixels.',
        'allowEmpty' => true,
        'required' => false,
    ));
    $this->icon->addValidator('Extension', false, 'jpg,png,jpeg,JPEG,PNG,JPG');
    $item_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id', 0);
    if ($item_id)
      $item = Engine_Api::_()->getItem('sesbrowserpush_scheduled', $item_id);

    if (!empty($item) && $item->file_id) {
      $file = Engine_Api::_()->getItemTable('storage_file')->getFile($item->file_id);
      if( $file ) {
        $image =  $file->map();
        $baseURL =(!empty($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"] == 'on')) ? "https://" : 'http://';
        $baseURL = $baseURL. $_SERVER['HTTP_HOST'];
        if(strpos($image,'http') === false)
          $path = $baseURL.$image;
      if (isset($path) && !empty($path)) {
        $this->addElement('Image', 'cat_icon_preview', array(
            'src' => $path,
            'width' => 100,
            'height' => 100,
        ));
      }
      $this->addElement('Checkbox', 'remove_icon_icon', array(
          'label' => 'Yes, delete this image.'
      ));
    }
   }
    $request = Zend_Controller_Front::getInstance()->getRequest();
		$controllerName = $request->getControllerName();
   if($controllerName == 'admin-scheduled'){
    $start = new Engine_Form_Element_CalendarDateTime('scheduled_time');
    //$start->useMilitaryTime;
    $start->setLabel("Scheduled Time");
    //$start->setValue(date("Y-d-m H:i:s"));
    $start->setAllowEmpty(false);
    $start->setRequired(true);
    $this->addElement($start);
   }

    $this->addElement('Button', 'submit', array(
      'label' => 'Send Now',
      'type' => 'submit',
      'ignore' => true,
      'decorators' => array('ViewHelper')
    ));

    $param = Zend_Controller_Front::getInstance()->getRequest()->getParam('param', 0);
    if(!empty($param)) {

        $this->addElement('Cancel', 'cancel', array(
            'label' => 'Cancel',
            'link' => true,
            'prependText' => ' or ',
            'onclick' => 'javascript:parent.Smoothbox.close()',
            'decorators' => array(
                'ViewHelper',
            ),
        ));
        $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');

    }

   $test_user =  Engine_Api::_()->getDbTable('tokens','sesbrowserpush')->getTokens(array('test_user'=>true));
   if(($test_user)){
    $this->addElement('Cancel', 'cancel', array(
        'label' => 'Send To Test Users',
        'prependText' => ' or ',
        'type' => 'submit',
        'ignore' => true,
        'onClick' => 'testuser()',
        'decorators' => array('ViewHelper')
    ));
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
   }
  }
}
