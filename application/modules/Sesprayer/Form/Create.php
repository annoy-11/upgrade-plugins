<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprayer
 * @package    Sesprayer
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Create.php  2017-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesprayer_Form_Create extends Engine_Form {

  public $_error = array();
  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    if($settings->getSetting('sesprayer.descriptionlimit', 0) == 0) {
      $descriptionlimit = 9999;
    } else {
      $descriptionlimit = $settings->getSetting('sesprayer.descriptionlimit', 0);
    }

    $this->setTitle('Create New Prayer')
        ->setMethod("POST")
        ->setDescription('Compose your new prayer entry below, then click "Post Prayer" to publish your prayer.')
        ->setAttrib('name', 'sesprayers_create')
        ->setAttrib('class', 'sesprayer_create_form');

    $this->addElement('Text', 'prayertitle', array(
      'placeholder' => 'Title',
      'label'=>'Title',
      'autofocus' => 'autofocus',
      'filters' => array(
        new Engine_Filter_Censor(),
        'StripTags',
        new Engine_Filter_StringLength(array('max' => '255'))
      ),
    ));

    $this->addElement('Textarea', 'title', array(
      'placeholder' => 'Prayer',
      'label'=>'Prayer',
      'allowEmpty' => false,
      'required' => true,
      'maxlength' => $descriptionlimit,
      'filters' => array(
        'StripTags',
        new Engine_Filter_Censor(),
        new Engine_Filter_EnableLinks(),
        new Engine_Filter_StringLength(array('max' => $descriptionlimit)),
      ),
    ));

    $this->addElement('Text', 'source', array(
      'placeholder' => 'Source',
      'label'=>'Source',
      'filters' => array(
        new Engine_Filter_Censor(),
        'StripTags',
        new Engine_Filter_StringLength(array('max' => '255'))
      ),
    ));

    if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesprayer.enablecategory', 1)) {

      if($settings->getSetting('sesprayer.categoryrequried', 0)) {
        $required = true;
        $allowEmpty = false;
      } else {
        $required = false;
        $allowEmpty = true;
      }

      //Category
      $categories = Engine_Api::_()->getDbtable('categories', 'sesprayer')->getCategoriesAssoc();
      if (count($categories) > 0) {
        $categories = array('' => 'Choose Category') + $categories;
        $this->addElement('Select', 'category_id', array(
          'label' => 'Category',
          'multiOptions' => $categories,
          'allowEmpty' => $allowEmpty,
          'required' => $required,
          'onchange' => "showSubCategory(this.value);",
        ));

        //Add Element: 2nd-level Category
        $this->addElement('Select', 'subcat_id', array(
          'label' => "2nd-level Category",
          'allowEmpty' => true,
          'required' => false,
          'multiOptions' => array('0' => ''),
          'registerInArrayValidator' => false,
          'onchange' => "showSubSubCategory(this.value);"
        ));

        //Add Element: Sub Sub Category
        $this->addElement('Select', 'subsubcat_id', array(
          'label' => "3rd-level Category",
          'allowEmpty' => true,
          'registerInArrayValidator' => false,
          'required' => false,
          'multiOptions' => array('0' => ''),
        ));
      }
    }

    // init to
    $this->addElement('Text', 'tags', array(
      'placeholder'=>'#tags',
      'label'=>'Tags',
      'autocomplete' => 'off',
      'filters' => array(
        'StripTags',
        new Engine_Filter_Censor(),
      ),
    ));
    $this->tags->getDecorator("Description")->setOption("placement", "append");

    $prayer_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('prayer_id', 0);
    if($prayer_id) {
      $prayer = Engine_Api::_()->getItem('sesprayer_prayer', $prayer_id);
    }
    if(empty($prayer_id)) {
      if(Engine_Api::_()->getApi('settings', 'core')->getSetting('core.iframely.secretIframelyKey')) {
        $this->addElement('Radio', 'mediatype', array(
          'label' => "Choose Media Type",
          'multiOptions' => array('1' => 'Photo', '2' => "Video"),
          'value' => 1,
          'onchange' => "showMediaType(this.value);",
        ));
      }

      $this->addElement('File', 'photo', array(
        'label' => 'Photo',
        'accept'=>"image/*",
      ));

      if(Engine_Api::_()->getApi('settings', 'core')->getSetting('core.iframely.secretIframelyKey')) {

        $this->addElement('Text', 'video', array(
          'description'=>'',
          'label'=>'Paste web address of the video',
          'placeholder'=> 'Paste the web address of the video here.',
          'onblur' => "iframelyurl();",
        ));
      }
    }
    if(!empty($prayer_id) && $prayer->photo_id) {
      $this->addElement('File', 'photo', array(
        'label' => 'Photo',
        'accept'=>"image/*",
      ));
    }

    if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesprayer.allowsendprayer', 0) && empty($prayer_id)) {
      if(!empty($_GET['restApi']) && $_GET['restApi'] == "Sesapi"){
          $this->addElement('Radio', 'posttype', array(
            'description' => "If you wish to send this prayer to other members, then choose the recipients from below.",
            'multiOptions' => array('1' => 'Everyone', '2' => 'My Networks', '3' => "My Lists", '4' => "My Friend"),
            'value' => 0,
            'allowEmpty'=>false,
            'required'=>true,
            'onchange' => "showposttypecreate(this.value);",
          ));

      }else{
        //SES Custom Work
        $this->addElement('Radio', 'posttype', array(
          'description' => "If you wish to send this prayer to other members, then choose the recipients from below.",
          'multiOptions' => array('0' => 'Everyone', '1' => 'My Networks', '2' => "My Lists", '3' => "My Friend"),
          'value' => 0,
          'allowEmpty'=>false,
          'required'=>true,
          'onchange' => "showposttypecreate(this.value);",
        ));
      }
      $viewer = Engine_Api::_()->user()->getViewer();
      $networkMembershipTable = Engine_Api::_()->getDbtable('membership', 'network');
      $viewerNetwork = $networkMembershipTable->getMembershipsOfInfo($viewer);
      $joinednetwork = array();
      foreach ($viewerNetwork as $networkvalue) {
        $joinednetwork[] = $networkvalue->resource_id;
      }

      if(count($joinednetwork) > 0) {
        $networkOptions = array();
        $networkValues = array();
        foreach (Engine_Api::_()->getDbtable('networks', 'network')->fetchAll() as $network) {
          if(in_array($network->network_id, $joinednetwork)) {
          $networkOptions[$network->network_id] = $network->getTitle();
          $networkValues[] = $network->network_id;
          }
        }
        if(!empty($_GET['restApi']) && $_GET['restApi'] == "Sesapi"){
           $this->addElement('multiselect', 'networks', array(
              'label' => 'Networks',
              'multiOptions' => $networkOptions,
              //'value' => $networkValues,
          ));
        }else{
        // Select Networks
          $this->addElement('multiselect', 'networks', array(
              'label' => 'Networks',
              'multiOptions' => $networkOptions,
              'description' => 'Select Networks.',
              //'value' => $networkValues,
          ));
        }
      } else {
        $description = "<div class='tip'><span>" . Zend_Registry::get('Zend_Translate')->_('There are currently no network joined by you.') . "</span></div>";
        //Add Element: Dummy
        if(!empty($_GET['restApi']) && $_GET['restApi'] == "Sesapi"){
          $this->addElement('Select', 'networks', array(
              'label' => 'Networks',
              'multiOptions'=>array(),
          ));
        }else{
          $this->addElement('Dummy', 'networks', array(
              'label' => 'Networks',
              'description' => $description,
          ));
          $this->networks->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
        }
      }

      $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
      $listsTable = Engine_Api::_()->getDbtable('lists', 'user');
      $listsName = $listsTable->info('name');

      $SelectList = $listsTable->select()->where('owner_id =?', $viewer_id);

      $lists = $listsTable->fetchAll($SelectList);

      if(count($lists) > 0) {
        $listOptions = array();
        $listValues = array();
        foreach ($lists as $list) {
          $listOptions[$list->list_id] = $list->title;
          $listValues[] = $list->list_id;
        }
        if(!empty($_GET['restApi']) && $_GET['restApi'] == "Sesapi"){
          $this->addElement('Select', 'lists', array(
              'label' => 'Lists',
              'multiOptions'=>$listOptions,
          ));
        }else{
          // Select Networks
          $this->addElement('Select', 'lists', array(
              'label' => 'Lists',
              'multiOptions' => $listOptions,
              'description' => 'Select Lists.',
              //'value' => $networkValues,
          ));
        }
      } else {
        $description = "<div class='tip'><span>" . Zend_Registry::get('Zend_Translate')->_('There are currently no list created by you.') . "</span></div>";
        //Add Element: Dummy
        if(!empty($_GET['restApi']) && $_GET['restApi'] == "Sesapi"){
          $this->addElement('Select', 'lists', array(
              'label' => 'Lists',
              'multiOptions'=>array(),
          ));
        }else{
        $this->addElement('Dummy', 'lists', array(
            'label' => 'Lists',
            'description' => $description,
        ));
        $this->lists->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
        }
      }



      //SES Custom Work
      if(!empty($_GET['restApi']) && $_GET['restApi'] == "Sesapi"){
          $viewer = Engine_Api::_()->user()->getViewer();
          $select = $viewer->membership()->getMembersOfSelect();
          $friends = $paginator = Zend_Paginator::factory($select);
          $paginator->setItemCountPerPage(1000);
          $paginator->setCurrentPageNumber(1);
          $ids = array();
          foreach ($friends as $friend) {
            $ids[] = $friend->resource_id;
          }

          $friendUsers = array();
          foreach (Engine_Api::_()->getItemTable('user')->find($ids) as $friendUser) {
            $friendUsers[$friendUser->getIdentity()] = $friendUser->getTitle();
          }
           $this->addElement('Select', 'user_id', array(
            'label' => 'Select the name of your friend.',
            'multiOptions'=>$friendUsers
          ));
      }else{
          $this->addElement('Text', 'friendid', array(
            'placeholder' => 'Enter the name of your friend using auto-suggest box.',
            'label' => 'Enter the name of your friend using auto-suggest box.',
            'filters' => array(
              'StripTags',
              new Engine_Filter_Censor(),
              new Engine_Filter_StringLength(array('max' => '63')),
            ),
          ));
          $this->addElement('Hidden', 'user_id', array());
      }
    }


    $this->addElement('Hash', 'token', array(
      'timeout' => 3600,
    ));

//     $this->addElement('Hidden', 'code', array(
//       'order' => 1
//     ));

    // Buttons
    $this->addElement('Button', 'submit', array(
      'label' => 'Post Prayer',
      'type' => 'submit',
      'ignore' => true,
      'decorators' => array('ViewHelper')
    ));

    $this->addElement('Cancel', 'cancel', array(
        'label' => 'Cancel',
        'link' => true,
        'prependText' => ' or ',
        'onclick' => 'javascript:sessmoothboxclose();',
        'decorators' => array(
            'ViewHelper',
        ),
    ));
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
    $button_group = $this->getDisplayGroup('buttons');
  }
}
