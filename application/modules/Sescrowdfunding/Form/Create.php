<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Create.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescrowdfunding_Form_Create extends Engine_Form {

  public $_error = array();
  protected $_defaultProfileId;

  public function getDefaultProfileId() {
    return $this->_defaultProfileId;
  }

  public function setDefaultProfileId($default_profile_id) {
    $this->_defaultProfileId = $default_profile_id;
    return $this;
  }


  public function init() {

    $request = Zend_Controller_Front::getInstance()->getRequest();
    $moduleName = $request->getModuleName();
    $controllerName = $request->getControllerName();
    $actionName = $request->getActionName();

    $translate = Zend_Registry::get('Zend_Translate');
    $setting = Engine_Api::_()->getApi('settings', 'core');
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->setTitle('Create Crowdfunding')
        ->setAttrib('id', 'sescrowdfunding_create_form')
        ->setDescription('Create your new crowdfunding entry below, then click "Create Crowdfunding" to publish the entry to your crowdfunding.')
        ->setAttrib('name', 'sescrowdfundings_create');

    $user = Engine_Api::_()->user()->getViewer();
    $user_level = Engine_Api::_()->user()->getViewer()->level_id;

    if (Engine_Api::_()->core()->hasSubject('crowdfunding'))
      $crowdfunding = Engine_Api::_()->core()->getSubject();

    $this->addElement('Text', 'title', array(
      'label' => 'Title',
      'allowEmpty' => false,
      'required' => true,
      'filters' => array(
        new Engine_Filter_Censor(),
        'StripTags',
        new Engine_Filter_StringLength(array('max' => '225'))
      ),
    ));

    $custom_url_value = isset($crowdfunding->custom_url) ? $crowdfunding->custom_url : (isset($_POST["custom_url"]) ? $_POST["custom_url"] : "");

    //Custom Url
    $this->addElement('Dummy', 'custom_url_crowdfunding', array(
      'label' => 'Custom Url',
      'content' => '<input type="text" name="custom_url" id="custom_url" value="' . $custom_url_value . '"><i class="fa fa-check" id="sescrowdfunding_custom_url_correct" style="display:none;"></i><i class="fa fa-close" id="sescrowdfunding_custom_url_wrong" style="display:none;"></i><span class="sescf_availability_btn"><button id="check_custom_url_availability" type="button" name="check_availability"><i class="fa fa-circle-o-notch fa-spin fa-fw" id="sescrowdfunding_custom_url_loading" style="display:none;"></i><span id="sescrowdfunding_custom_url_btn">Check Availability</span></button></span> <p id="suggestion_tooltip" class="check_tooltip" style="display:none;">'.$translate->translate("You can use letters, numbers and periods.").'</p>',
    ));

    if ($setting->getSetting('sescrowdfunding.crowdfundingtags', 1)) {
        $this->addElement('Text', 'tags', array(
            'label' => 'Tags (Keywords)',
            'autocomplete' => 'off',
            'description' => 'Separate tags with commas.',
            'filters' => array(
                new Engine_Filter_Censor(),
            )
        ));
        $this->tags->getDecorator("Description")->setOption("placement", "append");
    }


    //Prepare categories
    $categories = Engine_Api::_()->getDbtable('categories', 'sescrowdfunding')->getCategoriesAssoc();
    if( count($categories) > 0 ) {

      $categorieEnable = Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfunding.category.enable', '1');
      if ($categorieEnable == 1) {
        $required = true;
        $allowEmpty = false;
      } else {
        $required = false;
        $allowEmpty = true;
      }

      $categories = $categories;

      //Category field
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

      if ($actionName != 'edit') {
        $defaultProfileId = "0_0_" . $this->getDefaultProfileId();
        $customFields = new Sesbasic_Form_Custom_Fields(array(
            'packageId' => '',
            'resourceType' => '',
            'item' => isset($page) ? $page : 'crowdfunding',
            'decorators' => array(
                'FormElements'
        )));
        $customFields->removeElement('submit');
        if ($customFields->getElement($defaultProfileId)) {
          $customFields->getElement($defaultProfileId)
                  ->clearValidators()
                  ->setRequired(false)
                  ->setAllowEmpty(true);
        }
        $this->addSubForms(array(
            'fields' => $customFields
        ));
      }
    }

    $mainPhotoEnable = Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfunding.photo.mandatory', '1');
    $upload_mainphoto = Engine_Api::_()->authorization()->isAllowed('crowdfunding', $viewer, 'upload_mainphoto');
    if ($mainPhotoEnable == 1) {
        $required = true;
        $allowEmpty = false;
    } else {
        $required = false;
        $allowEmpty = true;
    }

    if(!empty($upload_mainphoto)) {
        //make main photo upload btn
        $this->addElement('File', 'photo_file', array(
        'label' => 'Main Photo',
        'required' => $required,
        'allowEmpty' => $allowEmpty,
        ));
        $this->photo_file->addValidator('Extension', false, 'jpg,png,gif,jpeg');
    }

    if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfunding.start.date', 1))  {

        $this->addElement('Radio', 'show_start_time', array(
            'label' => 'Expire Campaign',
            'description' => 'Do you want to expire this campaign? Choose Yes, to select the expiry date.',
            'multiOptions' => array(
            '0' => 'Yes',
            '1' => 'No',
            ),
            'value' => 1,
            'onclick' => "showStartDate(this.value);",
        ));

        if(empty($_POST)) {
            $startDate = date('Y-m-d h:i:s', strtotime(date('Y-m-d h:i:s') . '+1 day'));
            $start_date = date('m/d/Y',strtotime($startDate));
            $start_time = date('g:ia',strtotime($startDate));

            if($viewer->timezone){
                $start =  strtotime(date('Y-m-d h:i:s', strtotime(date('Y-m-d h:i:s') . '+1 day')));
                $selectedTime = "00:02:00";
                $startTime = time()+strtotime($selectedTime);
                $oldTz = date_default_timezone_get();
                date_default_timezone_set($viewer->timezone);
                $start_date = date('m/d/Y',($start));
                $start_time = date('g:ia',$startTime);
                date_default_timezone_set($oldTz);
            }
        } else {
            $start_date = date('m/d/Y',strtotime($_POST['start_date']));
            $start_time = date('g:ia',strtotime($_POST['start_time']));
        }

        $this->addElement('dummy', 'crowdfunding_custom_datetimes', array(
            'decorators' => array(array('ViewScript', array(
            'viewScript' => 'application/modules/Sescrowdfunding/views/scripts/_customdates.tpl',
            'class' => 'form element',
            'start_date'=>$start_date,
            'start_time'=>$start_time,
            'start_time_check'=>1,
            'subject'=>isset($crowdfunding) ? $crowdfunding : '',
            )))
        ));
    }

    $this->addElement('Text', 'price', array(
        'label' => 'Goal',
        'allowEmpty' => false,
        'required' => true,
        'validators' => array(
            array('Int', true),
            new Engine_Validate_AtLeast(10),
        ),
    ));

    if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfunding.enable.location', 1)) {

      $this->addElement('Text', 'location', array(
        'label' => 'Location',
        'id' => 'locationSes',
        'filters' => array(
            new Engine_Filter_Censor(),
            new Engine_Filter_HtmlSpecialChars(),
        ),
      ));

      $this->addElement('Text', 'lat', array(
        'label' => 'Lat',
        'id' => 'latSes',
        'filters' => array(
            new Engine_Filter_Censor(),
            new Engine_Filter_HtmlSpecialChars(),
        ),
      ));

      $this->addElement('dummy', 'map-canvas', array());
      $this->addElement('dummy', 'ses_location', array('content'));
      $this->addElement('Text', 'lng', array(
        'label' => 'Lng',
        'id' => 'lngSes',
        'filters' => array(
            new Engine_Filter_Censor(),
            new Engine_Filter_HtmlSpecialChars(),
        ),
      ));
    }

    // Description
    $this->addElement('Textarea', 'short_description', array(
      'label' => 'Short Description',
      'maxlength' => '500',
      'allowEmpty' => false,
      'required' => true,
      'filters' => array(
        'StripTags',
        new Engine_Filter_Censor(),
        new Engine_Filter_EnableLinks(),
        new Engine_Filter_StringLength(array('max' => 500)),
      ),
    ));

    $allowed_html = Engine_Api::_()->authorization()->getPermission($user_level, 'sescrowdfunding', 'auth_html');
    $upload_url = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sesbasic', 'controller' => 'index', 'action' => "upload-image"), 'default', true);

    $editorOptions = array(
      'upload_url' => $upload_url,
      'html' => (bool) $allowed_html,
    );

    if (!empty($upload_url)) {

      $editorOptions['plugins'] = array(
        'table', 'fullscreen', 'media', 'preview', 'paste',
        'code', 'image', 'textcolor', 'jbimages', 'link'
      );
      $editorOptions['toolbar1'] = array(
        'undo', 'redo', 'removeformat', 'pastetext', '|', 'code',
        'media', 'image', 'jbimages', 'link', 'fullscreen',
        'preview'
      );
      $editorOptions['toolbar2'] = array(
        'fontselect','fontsizeselect','bold','italic','underline','strikethrough','forecolor','backcolor','|','alignleft','aligncenter','alignright','alignjustify','|','bullist','numlist','|','outdent','indent','blockquote',
      );
    }

		$descriptionMan= Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfunding.description.mandatory', '1');
		if ($descriptionMan == 1) {
			$required = true;
			$allowEmpty = false;
		} else {
			$required = false;
			$allowEmpty = true;
		}

    $this->addElement('TinyMce', 'description', array(
      'label' => 'Description',
      'required' => $required,
      'allowEmpty' => $allowEmpty,
      'class'=>'tinymce',
      'editorOptions' => $editorOptions,
    ));


      if (Engine_Api::_()->authorization()->isAllowed('crowdfunding', $viewer, 'auth_crodstyle')) {
        $chooselayoutVal = json_decode(Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'crowdfunding', 'select_pagestyle'));
        $designoptions = array();
        if (in_array(1, $chooselayoutVal)) {
          $designoptions[1] = '<span><img src="./application/modules/Sescrowdfunding/externals/images/layout_1.jpg" alt="" /></span> ' . $translate->translate("Design 1");
          $designoptionsApi[1] = $translate->translate("Design 1");
        }
        if (in_array(2, $chooselayoutVal)) {
          $designoptions[2] = '<span><img src="./application/modules/Sescrowdfunding/externals/images/layout_2.jpg" alt="" /></span> ' . $translate->translate("Design 2");
          $designoptionsApi[2] = $translate->translate("Design 2");
        }
        if (in_array(3, $chooselayoutVal)) {
          $designoptions[3] = '<span><img src="./application/modules/Sescrowdfunding/externals/images/layout_3.jpg" alt="" /></span> ' . $translate->translate("Design 3");
          $designoptionsApi[3] = $translate->translate("Design 3");
        }
        if (in_array(4, $chooselayoutVal)) {
          $designoptions[4] = '<span><img src="./application/modules/Sescrowdfunding/externals/images/layout_4.jpg" alt="" /></span> ' . $translate->translate("Design 4");
          $designoptionsApi[4] = $translate->translate("Design 4");
        }
        $this->addElement('Radio', 'pagestyle', array(
            'label' => 'Crowdfunding Profile Page Layout',
            'description' => 'Set Your Crowdfunding Template',
            'multiOptions' => empty($_GET['restApi']) ? $designoptions : $designoptionsApi,
            'escape' => false,
            'value' => 1,
        ));
      } else {
        $permissionTable = Engine_Api::_()->getDbTable('permissions', 'authorization');
        $value = $permissionTable->select()
                ->from($permissionTable->info('name'), 'value')
                ->where('level_id = ?', $viewer->level_id)
                ->where('type = ?', 'Crowdfunding')
                ->where('name = ?', 'page_style_type')
                ->query()
                ->fetchColumn();
        $this->addElement('Hidden', 'pagestyle', array(
            'value' => $value,
        ));
      }

    $availableLabels = array(
      'everyone'            => 'Everyone',
      'registered'          => 'All Registered Members',
      'owner_network'       => 'Friends and Networks',
      'owner_member_member' => 'Friends of Friends',
      'owner_member'        => 'Friends Only',
      'owner'               => 'Just Me'
    );

    // Element: auth_view
    $viewOptions = (array) Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('crowdfunding', $user, 'auth_view');
    $viewOptions = array_intersect_key($availableLabels, array_flip($viewOptions));

    if( !empty($viewOptions) && count($viewOptions) >= 1 ) {
      // Make a hidden field
      if(count($viewOptions) == 1) {
        $this->addElement('hidden', 'auth_view', array('value' => key($viewOptions)));
      // Make select box
      } else {
        $this->addElement('Select', 'auth_view', array(
            'label' => 'Privacy',
            'description' => 'Who may see this crowdfunding entry?',
            'multiOptions' => $viewOptions,
            'value' => key($viewOptions),
        ));
        $this->auth_view->getDecorator('Description')->setOption('placement', 'append');
      }
    }

    // Element: auth_comment
    $commentOptions = (array) Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('crowdfunding', $user, 'auth_comment');
    $commentOptions = array_intersect_key($availableLabels, array_flip($commentOptions));

    if( !empty($commentOptions) && count($commentOptions) >= 1 ) {
      // Make a hidden field
      if(count($commentOptions) == 1) {
        $this->addElement('hidden', 'auth_comment', array('value' => key($commentOptions)));
      // Make select box
      } else {
        $this->addElement('Select', 'auth_comment', array(
            'label' => 'Comment Privacy',
            'description' => 'Who may post comments on this crowdfunding entry?',
            'multiOptions' => $commentOptions,
            'value' => key($commentOptions),
        ));
        $this->auth_comment->getDecorator('Description')->setOption('placement', 'append');
      }
    }

    $videoOptions = (array) Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('crowdfunding', $viewer, 'auth_video');
    $videoOptions = array_intersect_key($availableLabels, array_flip($videoOptions));
    //video
    if (!empty($videoOptions) && count($videoOptions) >= 1 && Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sescrowdfundingvideo')) {
      // Make a hidden field
      if (count($videoOptions) == 1) {
        $this->addElement('hidden', 'auth_video', array('value' => key($videoOptions)));
        // Make select box
      } else {
        $this->addElement('Select', 'auth_video', array(
            'label' => 'Video Upload Privacy',
            'description' => 'Who may upload videos to this crowdfunding?',
            'multiOptions' => $videoOptions,
            'class' => $hideClass,
            'value' => key($videoOptions)
        ));
        $this->auth_video->getDecorator('Description')->setOption('placement', 'append');
      }
    }

 		$this->addElement('Select', 'draft', array(
      'label' => 'Status',
      'multiOptions' => array("0"=>"Published", "1"=>"Saved As Draft"),
      'description' => 'If this entry is published, it cannot be switched back to draft mode.'
    ));
    $this->draft->getDecorator('Description')->setOption('placement', 'append');


    if ($setting->getSetting('sescrowdfunding.global.search', 1)) {
        $this->addElement('Checkbox', 'search', array(
        'label' => 'Show this crowdfunding entry in search results',
        'value' => 1,
        ));
    } else {
      $this->addElement('Hidden', 'search', array(
        'value' => 1,
      ));
    }

    $this->addElement('Button', 'submit_check',array(
      'type' => 'submit',
    ));

    //Element: submit
    $this->addElement('Button', 'submit', array(
      'label' => 'Create Crowdfunding',
      'type' => 'submit',
    ));
  }
}
