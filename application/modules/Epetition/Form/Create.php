<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Create.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Epetition_Form_Create extends Engine_Form
{
  public $_error = array();
  protected $_defaultProfileId;
  protected $_fromApi;
  protected $_smoothboxType;

  public function init()
  {
    if ($this->getSmoothboxType())
      $hideClass = 'epetition_hideelement_smoothbox';
    else
      $hideClass = '';
    $viewer = Engine_Api::_()->user()->getViewer();
    $translate = Zend_Registry::get('Zend_Translate');
    if (Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('epetitionpackage') && Engine_Api::_()->getApi('settings', 'core')->getSetting('epetitionpackage.enable.package', 1)) {
      $package_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('package_id');
      if ($package_id)
        $package = Engine_Api::_()->getItem('epetitionpackage_package', $package_id);
      else {
        $existing_package_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('existing_package_id');
        $existing_package = Engine_Api::_()->getItem('epetitionpackage_orderspackage', $existing_package_id);
        $package = Engine_Api::_()->getItem('epetitionpackage_package', $existing_package->package_id);
      }
      if (($package) && $package_id || $existing_package_id) {
        $modulesEnable = json_decode($package->params, true);
      }
    }

    $settings = Engine_Api::_()->getApi('settings', 'core');

      $this->setTitle('Start a Petition')
        ->setDescription('Compose your new petition entry below, then click "Post Entry" to publish the entry to your petition.')
        ->setAttrib('name', 'epetitions_create');

    if ($this->getSmoothboxType())
      $this->setAttrib('class', 'global_form epetition_smoothbox_create');

    $user = Engine_Api::_()->user()->getViewer();
    $user_level = Engine_Api::_()->user()->getViewer()->level_id;

    if (Engine_Api::_()->core()->hasSubject('epetition'))
      $petition = Engine_Api::_()->core()->getSubject();


    // For Title
    if ($settings->getSetting('epetcre.enable.title', 1)) {
      $this->addElement('Text', 'title', array(
        'label' => 'Petition Title',
        'description' => 'Enter a title for your petition.',
        'allowEmpty' => false,
        'required' => true,
        'filters' => array(
          new Engine_Filter_Censor(),
          'StripTags',
          new Engine_Filter_StringLength(array('max' => '128'))
        ),
      ));
    }


    // For Url
      $custom_url_value = isset($petition->custom_url) ? $petition->custom_url : (isset($_POST["custom_url"]) ? $_POST["custom_url"] : "");
      // Custom Url
      $this->addElement('Dummy', 'custom_url_petition', array(
        'label' => 'Custom Url',
        'content' => '<input type="text" name="custom_url" id="custom_url" value="' . $custom_url_value . '"><i class="fa fa-check" id="epetition_custom_url_correct" style="display:none;"></i><i class="fa fa-close" id="epetition_custom_url_wrong" style="display:none;"></i><span class="epetition_check_availability_btn"><img src="application/modules/Core/externals/images/loading.gif" id="epetition_custom_url_loading" alt="Loading" style="display:none;" /><button id="check_custom_url_availability" type="button" name="check_availability" >Check Availability</button></span> <p id="suggestion_tooltip" class="check_tooltip" style="display:none;">' . $translate->translate("You can use letters, numbers and periods.") . '</p>',
      ));

    // init to
    if ($settings->getSetting('epetcre.enable.tags', 1)) {
      $this->addElement('Text', 'tags', array(
        'label' => 'Tags (Keywords)',
        'autocomplete' => 'off',
        'description' => 'Separate tags with commas.',
        'filters' => array(
          new Engine_Filter_Censor(),
        )
      ));
    }

    $categories = Engine_Api::_()->getDbtable('categories', 'epetition')->getCategoriesAssoc(array('member_levels' => 1));
    if( count($categories) > 0 ) {
      $categorieEnable = Engine_Api::_()->getApi('settings', 'core')->getSetting('epetcre.enb.category', 1);
      if ($categorieEnable == 1) {
        $required = Engine_Api::_()->getApi('settings', 'core')->getSetting('epetcre.cat.req', 1);
        $allowEmpty = false;
      } else {
        $required = Engine_Api::_()->getApi('settings', 'core')->getSetting('epetcre.cat.req', 1);
        $allowEmpty = true;
      }
      $categories = array('' => '') + $categories;
      // category field
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
        'onchange' => 'showCustom(this.value);'
      ));



      $defaultProfileId = "0_0_" . $this->getDefaultProfileId();
      $customFields = new Epetition_Form_Custom_Fields(array(
        'item' => 'epetition',
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

    // description
    //$this->tags->getDecorator("Description")->setOption("placement", "append");


      $allowed_html = Engine_Api::_()->authorization()->getPermission($user_level, 'epetition', 'auth_html');
      $upload_url = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sesbasic', 'controller' => 'index', 'action' => "upload-image"), 'default', true);
      $editorOptions = array(
        'upload_url' => $upload_url,
        'html' => true,
        'extended_valid_elements' => $allowed_html,
      );

      if (!empty($upload_url)) {
        $editorOptions['plugins'] = array(
          'table', 'fullscreen', 'media', 'psignature', 'paste',
          'code', 'image', 'textcolor', 'jbimages', 'link'
        );
        $editorOptions['toolbar1'] = array(
          'undo', 'redo', 'removeformat', 'pastetext', '|', 'code',
          'media', 'image', 'jbimages', 'link', 'fullscreen',
          'psignature'
        );
        $editorOptions['toolbar2'] = array(
          'fontselect', 'fontsizeselect', 'bold', 'italic', 'underline', 'strikethrough', 'forecolor', 'backcolor', '|', 'alignleft', 'aligncenter', 'alignright', 'alignjustify', '|', 'bullist', 'numlist', '|', 'outdent', 'indent', 'blockquote',
        );
      }


      if ((isset($modulesEnable) && array_key_exists('enable_tinymce', $modulesEnable) && $modulesEnable['enable_tinymce']) || empty($modulesEnable)) {
        $textarea = 'TinyMce';
      } else
        $textarea = 'Textarea';


      $descriptionMan = $settings->getSetting('epetcre.des.req', 1);
      if ($descriptionMan == 1) {
        $required = true;
        $allowEmpty = false;
      } else {
        $required = false;
        $allowEmpty = true;
      }
    if ($settings->getSetting('epetcre.enb.des', 1)) {
      $this->addElement('TinyMce', 'body', array(
        'label' => 'Petition Description',
        'required' => $required,
        'description' => 'Provide a brief description about this petition',
        'allowEmpty' => $allowEmpty,
        'max'=>200,
      ));
   }

    if ($settings->getSetting('epetcre.enb.overview', 1)) {
      $this->addElement($textarea, 'petition_overview', array(
        'label' => 'Petition Overview',
        'description' => 'Please explain what is the overview of this petition & why someone should support it.',
        'required' => false,
        'allowEmpty' => true,
      ));
    }

    $photoLeft = true;
    if (isset($existing_package_id) && $existing_package_id) {
      $modulesEnable = json_decode($package->params, true);
      $package_id = $existing_package->package_id;
      if ($package_id) {
        $photoLeft = $package->allowUploadPhoto($existing_package->getIdentity(), true);
      }

    }


    $mainPhotoEnable = Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition.photo.mandatory', '1');
    if ($mainPhotoEnable == 1) {
      $required = true;
      $allowEmpty = false;
    } else {
      $required = false;
      $allowEmpty = true;
    }
    // Init submit
    if ($this->getFromApi()) {
      $this->addElement('File', 'file', array(
        'label' => 'Main Photo',
        'description' => '',
      ));
    }
    if (((isset($modulesEnable) && array_key_exists('modules', $modulesEnable) && in_array('photo', $modulesEnable['modules'])) || empty($modulesEnable)) && $photoLeft) {
      if (isset($modulesEnable) && array_key_exists('photo_count', $modulesEnable) && $modulesEnable['photo_count']) {
        if (isset($photoLeft))
          $photo_count = $photoLeft;
        else
          $photo_count = $modulesEnable['photo_count'];
        $this->addElement('hidden', 'photo_count', array('value' => $photo_count, 'order' => 8769));
      }


      $this->addElement('Dummy', 'fancyuploadfileids', array('content' => '<input id="fancyuploadfileids" name="file" type="hidden" value="" >'));

      $this->addElement('Dummy', 'tabs_form_petitioncreate', array(
        'label' => 'Upload photos',
        'required'=>$required,
        'allowEmpty'=>$allowEmpty,
        'content' => '<div class="epetition_create_form_tabs sesbasic_clearfix sesbm"><ul id="epetition_create_form_tabs" class="sesbasic_clearfix"><li class="active sesbm"><i class="fa fa-arrows sesbasic_text_light"></i><a href="javascript:;" class="drag_drop">' . $translate->translate('Drag & Drop') . '</a></li><li class=" sesbm"><i class="fa fa-upload sesbasic_text_light"></i><a href="javascript:;" class="multi_upload">' . $translate->translate('Multi Upload') . '</a></li><li class=" sesbm"><i class="fa fa-link sesbasic_text_light"></i><a href="javascript:;" class="from_url">' . $translate->translate('From URL') . '</a></li></ul></div>',
      ));
      $this->addElement('Dummy', 'drag-drop', array(
        'content' => '<div id="dragandrophandler" class="epetition_upload_dragdrop_content sesbasic_bxs">' . $translate->translate('Drag & Drop Photos Here') . '</div>',
      ));
      $this->addElement('Dummy', 'from-url', array(
        'content' => '<div id="from-url" class="epetition_upload_url_content sesbm"><input type="text" name="from_url" id="from_url_upload" value="" placeholder="' . $translate->translate('Enter Image URL to upload') . '"><span id="loading_image"></span><span></span><button id="upload_from_url">' . $translate->translate('Upload') . '</button></div>',
      ));

      $this->addElement('Dummy', 'file_multi', array('content' => '<input type="file" accept="image/x-png,image/jpeg" onchange="readImageUrl(this)" multiple="multiple" id="file_multi" name="file_multi">'));
      $this->addElement('Dummy', 'uploadFileContainer', array('content' => '<div id="show_photo_container" class="epetition_upload_photos_container sesbasic_bxs sesbasic_custom_scroll clear"><div id="show_photo"></div></div>'));
    } else {
      //make main photo upload btn
      $this->addElement('File', 'photo_file', array(
        'label' => 'Main Photo',
        'required' => $required,
        'allowEmpty' => $allowEmpty,
      ));
      $this->photo_file->addValidator('Extension', false, 'jpg,png,gif,jpeg');
    }

   if($settings->getSetting('epetition.enable.location', 1)) {
     $this->addElement('Text', 'location', array(
       'label' => 'Enter-Location',
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

    $check_setting_type=$settings->getSetting('epetition.signlimit', 3);
    if ($settings->getSetting('epetcre.sign.goal', 1) && $check_setting_type!=2) {
      $this->addElement('Text', 'signature_goal', array(
        'label' => 'Signature Goal',
        'id' => 'signaturegoal',
        'onkeypress' => 'return allowOnlyNumbers(event);',
        'Description' => 'Enter the signature goal (in integer) which you want for this petition.',
      ));
    }

    if (Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition.start.date', 1)) {

      $this->addElement('Radio', 'show_start_time', array(
        'label' => 'Start Date',
        'description' => '',
        'multiOptions' => array(
          "" => 'Choose Start Date',
          "1" => 'Publish Now',
        ),
        'value' => 1,
        'onchange' => "showStartDate();",
      ));
      if ($this->getFromApi()) {
        // Start time
        $start = new Engine_Form_Element_Date('starttime');
        $start->setLabel("Start Time");
        $start->setAllowEmpty(true);
        $start->setRequired(false);
        $this->addElement($start);
      }
      if (empty($_POST)) {
        $startDate = date('Y-m-d h:i:s', strtotime(date('Y-m-d h:i:s') . ' + 2 minutes'));
        $start_date = date('m/d/Y', strtotime($startDate));
        $start_time = date('g:ia', strtotime($startDate));

        if ($viewer->timezone) {
          $start = strtotime(date('Y-m-d h:i:s', strtotime(date('Y-m-d h:i:s') . ' + 2 minutes')));
          $selectedTime = "00:02:00";
          $startTime = time() + strtotime($selectedTime);
          $oldTz = date_default_timezone_get();
          date_default_timezone_set($viewer->timezone);
          $start_date = date('m/d/Y', ($start));
          $start_time = date('g:ia', $startTime);
          date_default_timezone_set($oldTz);
        }
      } else {
        $start_date = date('m/d/Y', strtotime($_POST['start_date']));
        $start_time = date('g:ia', strtotime($_POST['start_time']));
      }
      $this->addElement('dummy', 'petition_custom_datetimes', array(
        'decorators' => array(array('ViewScript', array(
          'viewScript' => 'application/modules/Epetition/views/scripts/_customdates.tpl',
          'class' => 'form element',
          'start_date' => $start_date,
          'start_time' => $start_time,
          'start_time_check' => 1,
          'subject' => isset($petition) ? $petition : '',
        )))
      ));
    }

    if ($settings->getSetting('epetcre.pet.dline', 1)) {

      $this->addElement('Radio', 'petition_deadline', array(
        'label' => 'Petition Deadline',
        'description' => 'Choose deadline for the petition on which you want this petition to get ended.',
        'multiOptions' => array(
          "" => 'End Date',
          "1" => 'No End Date',
        ),
        'value' => 1,
        'id' => 'petition_deadline',
        'onchange' => "showhidedeadline();",
      ));
      if ($this->getFromApi()) {
        // Start time
        $deadline = new Engine_Form_Element_Date('deadline');
        $deadline->setLabel("Deadline");
        $deadline->setAllowEmpty(true);
        $deadline->setRequired(false);
        $this->addElement($deadline);
      }
      if (empty($_POST)) {
        $deadlineDate = date('Y-m-d h:i:s', strtotime(date('Y-m-d h:i:s') . ' + 2 minutes'));
        $petition_deadline = date('m/d/Y', strtotime($deadlineDate));
        $petition_deadline = date('g:ia', strtotime($deadlineDate));

        if ($viewer->timezone) {
          $deadline = strtotime(date('Y-m-d h:i:s', strtotime(date('Y-m-d h:i:s') . ' + 2 minutes')));
          $selectedTime = "00:02:00";
          $deadlineTime = time() + strtotime($selectedTime);
          $oldTz = date_default_timezone_get();
          date_default_timezone_set($viewer->timezone);
          $petition_deadline = date('m/d/Y', ($deadline));
          $petition_deadline = date('g:ia', $deadlineTime);
          date_default_timezone_set($oldTz);
        }
      } else {
        $petition_deadline = date('m/d/Y', strtotime($_POST['petition_deadline']));
        $petition_deadline = date('g:ia', strtotime($_POST['petition_deadline']));
      }
      $this->addElement('dummy', 'petition_customs_datetimes', array(
        'decorators' => array(array('ViewScript', array(
          'viewScript' => 'application/modules/Epetition/views/scripts/_custompetitionenddates.tpl',
          'class' => 'form element',
          'petition_deadline' => $petition_deadline,
          'petition_deadline' => $petition_deadline,
          'petition_deadline_check' => 1,
          'subject' => isset($petition) ? $petition : '',
        )))
      ));
    }

/*    if ($settings->getSetting('epetcre.sponsored.by', 1)) {
      $this->addElement('Text', 'sponsored_by', array(
        'label' => 'Sponsored By',
        'maxlenght' => 128,
        'Description' => 'Who is sponsoring your petition? e.g. Workforce Union.',
      ));
    }*/


    if (Engine_Api::_()->authorization()->isAllowed('epetition', $viewer, 'allow_levels')) {
      $levelOptions = array();
      $levelValues = array();
      foreach (Engine_Api::_()->getDbtable('levels', 'authorization')->fetchAll() as $level) {
//             if($level->getTitle() == 'Public')
//                 continue;
        $levelOptions[$level->level_id] = $level->getTitle();
        $levelValues[] = $level->level_id;
      }
      // Select Member Levels
      $this->addElement('multiselect', 'levels', array(
        'label' => 'Member Levels',
        'multiOptions' => $levelOptions,
        'description' => 'Choose the Member Levels to which this Petition will be displayed. (Note: Hold down the CTRL key to select or de-select specific member levels.)',
        'value' => $levelValues,
      ));
    }

    if (Engine_Api::_()->authorization()->isAllowed('epetition', $viewer, 'allow_network')) {
      $networkOptions = array();
      $networkValues = array();
      foreach (Engine_Api::_()->getDbTable('networks', 'network')->fetchAll() as $network) {
        $networkOptions[$network->network_id] = $network->getTitle();
        $networkValues[] = $network->network_id;
      }

      // Select Networks
      $this->addElement('multiselect', 'networks', array(
        'label' => 'Networks',
        'multiOptions' => $networkOptions,
        'description' => 'Choose the Networks to which this Page will be displayed. (Note: Hold down the CTRL key to select or de-select specific networks.)',
        'value' => $networkValues,
      ));
    }



    if (Engine_Api::_()->authorization()->isAllowed('epetition', Engine_Api::_()->user()->getViewer(), 'cotinuereading')) {
      $this->addElement('Radio', 'cotinuereading', array(
        'label' => 'Enable Continue Reading Button',
        'description' => 'Do you want to enable "Continue Reading" button for your Petition?',
        'multiOptions' => array(
          '1' => 'Yes',
          '0' => 'No',
        ),
        'onchange' => 'showHideHeight(this.value)',
        'value' => '1',
      ));
      $this->addElement('Text', 'continue_height', array(
        'label' => 'Enter Height',
        'description' => 'Enter the height after you want to show continue reading button. 0 for unlimited.',
        'value' => '0'
      ));
    } else {
      if (Engine_Api::_()->authorization()->isAllowed('epetition', Engine_Api::_()->user()->getViewer(), 'cntrdng_dflt')) {
        $val = 1;
        $continue_height = Engine_Api::_()->authorization()->getPermission(Engine_Api::_()->user()->getViewer()->level_id, 'epetition', 'continue_height');
      } else {
        $val = 0;
        $continue_height = 0;
      }
      $this->addElement('Hidden', 'cotinuereading', array(
        'value' => $val,
        'order' => 9878
      ));
      $this->addElement('Hidden', 'continue_height', array(
        'value' => $continue_height,
        'order' => 9879
      ));
    }

    $availableLabels = array(
      'everyone' => 'Everyone',
      'registered' => 'All Registered Members',
      'owner_network' => 'Friends and Networks',
      'owner_member_member' => 'Friends of Friends',
      'owner_member' => 'Friends Only',
      'owner' => 'Just Me'
    );

    // Element: auth_view
    $viewOptions = (array)Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('epetition', $user, 'auth_view');
    $viewOptions = array_intersect_key($availableLabels, array_flip($viewOptions));
    if (!empty($viewOptions) && count($viewOptions) >= 1) {
      // Make a hidden field
      if (count($viewOptions) == 1) {
        $this->addElement('hidden', 'auth_view', array('value' => key($viewOptions)));
        // Make select box
      } else {
        $this->addElement('Select', 'auth_view', array(
          'label' => 'Privacy',
          'description' => 'Who may see this petition entry?',
          'multiOptions' => $viewOptions,
          'value' => key($viewOptions),
          'class' => $hideClass,
        ));
        $this->auth_view->getDecorator('Description')->setOption('placement', 'append');
      }
    }


    // Element: auth_comment
    $commentOptions = (array)Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('epetition', $user, 'auth_comment');
    $commentOptions = array_intersect_key($availableLabels, array_flip($commentOptions));
    if (isset($commentOptions)  && !empty($commentOptions) && count($commentOptions) >= 1) {
      // Make a hidden field
      if (count($commentOptions) == 1) {
        $this->addElement('hidden', 'auth_comment', array('value' => key($commentOptions)));
        // Make select box
      } else {
        $this->addElement('Select', 'auth_comment', array(
          'label' => 'Comment Privacy',
          'description' => 'Who may post comments on this petition entry?',
          'multiOptions' => $commentOptions,
          'value' => key($commentOptions),
          'class' => $hideClass,
        ));
        $this->auth_comment->getDecorator('Description')->setOption('placement', 'append');
      }
    }

    // Petition Overview
    // $this->tags->getDecorator("Description")->setOption("placement", "append");



    if ($settings->getSetting('epetcre.status.field', 1)) {
      $this->addElement('Select', 'draft', array(
        'label' => 'Status',
        'multiOptions' => array("" => "Published", "1" => "Saved As Draft"),
        'description' => 'If this entry is published, it cannot be switched back to draft mode.',
        'class' => $hideClass,
      ));
    }
    if ($settings->getSetting('epetcre.people.search', 1)) {

      $this->addElement('Checkbox', 'search', array(
        'label' => 'Show this petition entry in search results',
        'value' => 1,
      ));
    }




    if ($this->getSmoothboxType()) {

      // Element: submit
      $this->addElement('Button', 'submit', array(
        'label' => 'Post Entry',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array(
          'ViewHelper',
        ),
      ));

      $this->addElement('Cancel', 'advanced_epetitionoptions', array(
        'label' => 'Show Advanced Settings',
        'link' => true,
        'class' => 'active',
        'href' => 'javascript:;',
        'onclick' => 'return false;',
        'decorators' => array(
          'ViewHelper'
        )
      ));
      $this->addElement('Dummy', 'brtag', array(
        'content' => '<span style="margin-top:5px;"></span>',
      ));
      $this->addElement('Cancel', 'cancel', array(
        'label' => 'cancel',
        'link' => true,
        'href' => '',
        'prependText' => ' or ',
        'onclick' => 'sessmoothboxclose();',
        'decorators' => array(
          'ViewHelper'
        )
      ));
      $this->addDisplayGroup(array('submit', 'cancel'), 'buttons', array(
        'decorators' => array(
          'FormElements',
          'DivDivDivWrapper',
        ),
      ));
    } else {
      // Element: submit
      $this->addElement('Button', 'submit', array(
        'label' => 'Post Entry',
        'type' => 'submit',
        'ignore' => true,
      ));
    }
  }

  public function getSmoothboxType()
  {
    return $this->_smoothboxType;
  }

  public function setSmoothboxType($smoothboxType)
  {
    $this->_smoothboxType = $smoothboxType;
    return $this;
  }

  public function getDefaultProfileId()
  {
    return $this->_defaultProfileId;
  }

  public function setDefaultProfileId($default_profile_id)
  {
    $this->_defaultProfileId = $default_profile_id;
    return $this;
  }

  public function getFromApi()
  {
    return $this->_fromApi;
  }

  public function setFromApi($fromApi)
  {
    $this->_fromApi = $fromApi;
    return $this;
  }
}
