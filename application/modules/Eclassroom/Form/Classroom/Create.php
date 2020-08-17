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
class Eclassroom_Form_Classroom_Create extends Engine_Form {

  protected $_defaultProfileId;
  protected $_smoothboxType;

  public function getDefaultProfileId() {
    return $this->_defaultProfileId;
  }

  public function setDefaultProfileId($default_profile_id) {
    $this->_defaultProfileId = $default_profile_id;
    return $this;
  }

  public function getSmoothboxType() {
    return $this->_smoothboxType;
  }

  public function setSmoothboxType($smoothboxType) {
    $this->_smoothboxType = $smoothboxType;
    return $this;
  }

  public function init() {

    $setting = Engine_Api::_()->getApi('settings', 'core');
    $translate = Zend_Registry::get('Zend_Translate');
    if (Engine_Api::_()->core()->hasSubject())
      $classroom = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    //get current logged in user
    $this->setTitle('Create New Classroom')
            ->setAttrib('id', 'eclassroom_create_form')
            ->setAttrib('enctype', 'multipart/form-data')
            ->setMethod("POST");
    if ($this->getSmoothboxType())
      $this->setAttrib('class', 'global_form classroom_smoothbox_create');
    $request = Zend_Controller_Front::getInstance()->getRequest();
    $moduleName = $request->getModuleName();
    $controllerName = $request->getControllerName();
    $actionName = $request->getActionName();
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $hideClass = '';
    //UPLOAD PHOTO URL
    $upload_url = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sesbasic', 'controller' => 'index', 'action' => "upload-image"), 'default', true);
    $allowed_html = 'strong, b, em, i, u, strike, sub, sup, p, div, pre, address, h1, h2, h3, h4, h5, h6, span, ol, li, ul, a, img, embed, br, hr';
    $editorOptions = array('upload_url' => $upload_url,'html' => (bool) $allowed_html);
    if (!empty($upload_url)) {
      $editorOptions['editor_selector'] = 'tinymce';
      $editorOptions['mode'] = 'specific_textareas';
      $editorOptions['plugins'] = array('table', 'fullscreen', 'media', 'preview', 'paste','code', 'image', 'textcolor', 'jbimages', 'link');
      $editorOptions['toolbar1'] = array('undo', 'redo', 'removeformat', 'pastetext', '|', 'code','media', 'image', 'jbimages', 'link', 'fullscreen','preview');
    }
    $this->addElement('Text', 'title', array(
        'label' => $view->translate('Classroom Title'),
        'autocomplete' => 'off',
        'allowEmpty' => false,
        'required' => true,
        'validators' => array(
            array('NotEmpty', true),
            array('StringLength', false, array(1, 255)),
        ),
        'filters' => array(
            'StripTags',
            new Engine_Filter_Censor(),
        ),
    ));
    $custom_url_value = isset($classroom->custom_url) ? $classroom->custom_url : (isset($_POST["custom_url"]) ? $_POST["custom_url"] : "");
    if ($actionName == 'create' || ($actionName == 'edit' && $setting->getSetting('eclassroom.edit.url', 0))) {
      // Custom Url
      $this->addElement('Dummy', 'custom_url_classroom', array(
          'label' => 'Custom URL',
          'content' => '<input type="text" name="custom_url" id="custom_url" value="' . $custom_url_value . '"><span class="classroom_check_availability_btn"><button id="check_custom_url_availability" type="button" name="check_availability" ><span class="classroom_custom_loading_btn"><img src="application/modules/Core/externals/images/loading.gif" id="classroom_custom_url_loading" alt="Loading" style="display:none;" /></span><i class="fa fa-check" id="classroom_custom_url_correct" style=""></i><i class="fa fa-close" id="classroom_custom_url_wrong" style="display:none;"></i><samp class="availability_tip">'.$translate->translate('Check Availability').'</samp></button></span>',
      ));
    }
    if ($setting->getSetting('eclassroom.classtags', 1)) {
      if ($actionName == 'create') {
        if ((isset($_GET['typesmoothbox']) && $_GET['typesmoothbox'] == 'sessmoothbox') || (!isset($_GET['typesmoothbox'])))
          $classroomcretag = true;
        else
          $classroomcretag = false;
      }elseif ($actionName == 'edit') {
        $classroomcretag = true;
      }
      if ($classroomcretag) {
        //Tags
        $this->addElement('Text', 'tags', array(
            'label' => $view->translate('Tags (Keywords)'),
            'autocomplete' => 'off',
            'description' => $view->translate('Separate tags with commas.'),
            'filters' => array(
                new Engine_Filter_Censor(),
            ),
        ));
        $this->tags->getDecorator("Description")->setOption("placement", "append");
      }
    }

    //Category
    $categories = Engine_Api::_()->getDbTable('categories', 'eclassroom')->getCategoriesAssoc();
    if ((count($categories) > 0) && $setting->getSetting('eclassroom.enable.category', '1')) {
      $categorieMandatory = $setting->getSetting('eclassroom.category.mandatory', '1');
      if ($categorieMandatory == 1) {
        $required = true;
        $allowEmpty = false;
      } else {
        $required = false;
        $allowEmpty = true;
      }
      $categories = array('' => 'Choose Category') + $categories;
      $this->addElement('Select', 'category_id', array(
          'label' => $view->translate('Category'),
          'description'=> $view->translate('Select a Category from the dropdown box for Classroom.'),
          'multiOptions' => $categories,
          'allowEmpty' => $allowEmpty,
          'required' => $required,
          'onchange' => "showSubCategory(this.value);",
      ));
      //Add Element: 2nd-level Category
      $this->addElement('Select', 'subcat_id', array(
          'label' => $view->translate('2nd-level Category'),
          'allowEmpty' => true,
          'required' => false,
          'multiOptions' => array('0' => ''),
          'registerInArrayValidator' => false,
          'onchange' => "showSubSubCategory(this.value);"
      ));
      //Add Element: Sub Sub Category
      $this->addElement('Select', 'subsubcat_id', array(
          'label' => $view->translate('3rd-level Category'),
          'allowEmpty' => true,
          'registerInArrayValidator' => false,
          'required' => false,
          'multiOptions' => array('0' => ''),
          'onchange' => 'showFields(this.value,1);'
      ));
     if ($actionName != 'edit') {
        $defaultProfileId = "0_0_" . $this->getDefaultProfileId();
        $customFields = new Sesbasic_Form_Custom_Fields(array(
            'packageId' => '',
            'resourceType' => '',
            'item' => isset($classroom) ? $classroom : 'classroom',
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
    $enableDescription = $setting->getSetting('eclassroom.enable.description', '1');
    if ($enableDescription) {
      if ($actionName == 'create') {
        if ((isset($_GET['typesmoothbox']) && $_GET['typesmoothbox'] == 'sessmoothbox' && $setting->getSetting('eclassroom.show.descriptionpopup', 1)) || (!isset($_GET['typesmoothbox']) && $setting->getSetting('eclassroom.show.descriptioncreate', 1)))
          $classroomcredescription = true;
        else
          $classroomcredescription = false;
      }elseif ($actionName == 'edit') {
        $classroomcredescription = true;
      }
      $descriptionMandatory = $setting->getSetting('eclassroom.description.required', '1');
      if ($descriptionMandatory == 1) {
        $required = true;
        $allowEmpty = false;
      } else {
        $required = false;
        $allowEmpty = true;
      }
      if ($classroomcredescription) {
        $this->addElement('TinyMce', 'description', array(
            'label' => 'Description',
            'allowEmpty' => $allowEmpty,
            'required' => $required,
            'class' => 'tinymce',
            'editorOptions' => $editorOptions,
        ));
      }
    }
    /* Location Elements */
    if ($setting->getSetting('eclassroom.enable.location', 1)) {
      $showLocationField = true;
      if (isset($classroom)) {
        if (!Engine_Api::_()->authorization()->isAllowed('eclassroom', $viewer, 'allow_mlocation'))
          $showLocationField = true;
        else
          $showLocationField = false;
      }
      if ($showLocationField) {
        $locale = Zend_Registry::get('Zend_Translate')->getLocale();
        $territories = Zend_Locale::getTranslationList('territory', $locale, 2);
        asort($territories);
        $countrySelect = '';
        $countrySelected = '';
        if (count($territories)) {
          $countrySelect = '<option value="'.$view->translate('Choose Country').'"></option>';
          if (isset($classroom)) {
            $itemlocation = Engine_Api::_()->getDbTable('locations', 'sesbasic')->getLocationData('classroom', $classroom->getIdentity());
            if ($itemlocation)
              $countrySelected = $itemlocation->country;
          }
          foreach ($territories as $key => $valCon) {
            if ($valCon == $countrySelected)
              $countrySelect .= '<option value="' . $valCon . '" selected >' . $valCon . '</option>';
            else
              $countrySelect .= '<option value="' . $valCon . '" >' . $valCon . '</option>';
          }
        }
        $this->addElement('dummy', 'classroom_location', array(
            'decorators' => array(array('ViewScript', array(
                        'viewScript' => 'application/modules/Eclassroom/views/scripts/_location.tpl',
                        'class' => 'form element',
                        'eclassroom' => isset($classroom) ? $classroom : '',
                        'countrySelect' => $countrySelect,
                        'itemlocation' => isset($itemlocation) ? $itemlocation : '',
                    )))
        ));
      }
    }

    if (isset($package)) {
      $params = json_decode($package->params, true);
      if ($params['classroom_choose_style']) {
        $chooselayoutVal = $params['classroom_chooselayout'];
        $designoptions = array();
        if (in_array(1, $chooselayoutVal)) {
          $designoptions[1] = '<span><img src="./application/modules/Courses/externals/images/layout_1.jpg" alt="" /></span>' . $translate->translate("Design 1");
        }
        if (in_array(2, $chooselayoutVal)) {
          $designoptions[2] = '<span><img src="./application/modules/Courses/externals/images/layout_2.jpg" alt="" /></span>' . $translate->translate("Design 2");
        }
        if (in_array(3, $chooselayoutVal)) {
          $designoptions[3] = '<span><img src="./application/modules/Courses/externals/images/layout_3.jpg" alt="" /></span>' . $translate->translate("Design 3");
        }
        if (in_array(4, $chooselayoutVal)) {
          $designoptions[4] = '<span><img src="./application/modules/Courses/externals/images/layout_4.jpg" alt="" /></span>' . $translate->translate("Design 4");
        }
        $this->addElement('Radio', 'classroomstyle', array(
            'label' => $view->translate('Classroom Profile Classroom Layout'),
            'description' => $view->translate('Set Your Classroom Template'),
            'multiOptions' => $designoptions,
            'escape' => false,
            'value' => $chooselayoutVal,
        ));
      } else {
        if (isset($params['bs_style_type']))
          $value = $params['bs_style_type'];
        $value = 1;
        $this->addElement('Hidden', 'classroomstyle', array(
            'value' => $value,
        ));
      }
    }
    else {
      if (Engine_Api::_()->authorization()->isAllowed('eclassroom', $viewer, 'auth_bsstyle')) {
        $chooselayoutVal = json_decode(Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'eclassroom', 'select_bsstyle'));
        $designoptions = array();
        if (in_array(1, $chooselayoutVal)) {
          $designoptions[1] = '<span><img src="./application/modules/Courses/externals/images/layout_1.jpg" alt="" /></span> ' . $translate->translate("Design 1");
          $designoptionsApi[1] = $translate->translate("Design 1");
        }
        if (in_array(2, $chooselayoutVal)) {
          $designoptions[2] = '<span><img src="./application/modules/Courses/externals/images/layout_2.jpg" alt="" /></span> ' . $translate->translate("Design 2");
          $designoptionsApi[2] = $translate->translate("Design 2");
        }
        if (in_array(3, $chooselayoutVal)) {
          $designoptions[3] = '<span><img src="./application/modules/Courses/externals/images/layout_3.jpg" alt="" /></span> ' . $translate->translate("Design 3");
          $designoptionsApi[3] = $translate->translate("Design 3");
        }
        if (in_array(4, $chooselayoutVal)) {
          $designoptions[4] = '<span><img src="./application/modules/Courses/externals/images/layout_4.jpg" alt="" /></span> ' . $translate->translate("Design 4");
          $designoptionsApi[4] = $translate->translate("Design 4");
        }
        $this->addElement('Radio', 'classroomstyle', array(
            'label' => $view->translate('Classroom Profile Classroom Layout'),
            'description' => $view->translate('Set Your Classroom Template'),
            'multiOptions' => empty($_GET['restApi']) ? $designoptions : $designoptionsApi,
            'escape' => false,
            'value' => 1,
        ));
      } else {
        $permissionTable = Engine_Api::_()->getDbTable('permissions', 'authorization');
        $value = $permissionTable->select()
                ->from($permissionTable->info('name'), 'value')
                ->where('level_id = ?', $viewer->level_id)
                ->where('type = ?', 'classroom')
                ->where('name = ?', 'bs_style_type')
                ->query()
                ->fetchColumn();
        $this->addElement('Hidden', 'classroomstyle', array(
            'value' => $value,
        ));
      }
    }
    if ($setting->getSetting('eclassroom.allow.join', 1) && $setting->getSetting('eclassroom.allow.owner.join', 1)) {
      $this->addElement('Radio', 'can_join', array(
          'label' => $view->translate('Enable Classroom Joining'),
          'description' => $view->translate('Do you want to allow users to join your Classroom?'),
          'multioptions' => array(1 => 'Yes', 0 => 'No'),
          'class' => $hideClass,
          'value' => 0
      ));
      if ($setting->getSetting('eclassroom.show.approvaloption', 1)) {
        $this->addElement('Radio', 'approval', array(
            'label' => $view->translate('Approve Members'),
            'description' => $view->translate('When people try to join your Classroom, should they be allowed to join immediately, or should they be forced to wait for approval?'),
            'multioptions' => array(0 => $view->translate('New members can join immediately.'), 1 => $view->translate('New members must be approved.')),
            'class' => $hideClass,
            'value' => 1
        ));
      }
      if ($setting->getSetting('eclassroom.joinclassroom.memtitle', 1)) {
        if ($setting->getSetting('eclassroom.memtitle.required', 1) && (!count($_POST) || (!empty($_POST['can_join']) && $_POST['can_join'] == 1))) {
          $required = true;
          $allowEmpty = false;
        } else {
          $required = false;
          $allowEmpty = true;
        }
        $this->addElement('Text', 'member_title_singular', array(
            'label' => $view->translate('Member\'s Singular Title'),
            'allowEmpty' => $allowEmpty,
            'required' => $required,
            'description' => $view->translate('Enter the title for members of your Classroom. E.g. Music Artist, Blogger, Painter, Dance Lover etc.')
        ));
        $this->addElement('Text', 'member_title_plural', array(
            'label' => $view->translate('Member\'s Plural Title'),
            'allowEmpty' => $allowEmpty,
            'required' => $required,
            'description' => $view->translate('Enter the title for members of your Classroom. E.g. Music Artists, Bloggers, Painters, Dance Lovers etc.')
        ));
      }
    }
    $this->addElement('Radio', 'auto_approve', array(
        'label' => $view->translate('Auto-Approve Posts'),
        'description' => $view->translate('When people try to post on your Classroom, should their posts be auto-approved or wait for Classroom admin approval? The feed will display on the posted date in your Classroom timeline.'),
        'multioptions' => array(1 => $view->translate('New posts will be auto-approved.'), 0 => $view->translate('New posts must be approved by this Classroom admin.')),
        'class' => $hideClass,
        'value' => 1
    ));

    if ($setting->getSetting('eclassroom.invite.enable', 1) && $setting->getSetting('eclassroom.invite.allow.owner', 1)) {
      $this->addElement('Radio', 'can_invite', array(
          'label' => $view->translate('Let members invite others?'),
          'description' => '',
          'multioptions' => array(1 => $view->translate('Yes, allow members to invite other people.'), 0 => $view->translate('No, do not allow members to invite other people.')),
          'class' => $hideClass, 'value' => True,
          'value' => 1
      ));
    } elseif ($setting->getSetting('eclassroom.invite.enable', 1) && !$setting->getSetting('eclassroom.invite.allow.owner', 1)) {
      $this->addElement('Hidden', 'can_invite', array(
          'value' => $setting->getSetting('eclassroom.invite.people.default', 1),
          'order' => 99999999,
      ));
    } else {
      $this->addElement('Hidden', 'can_invite', array(
          'value' => 0,
          'order' => 99999999,
      ));
    }
    if ($actionName == 'create') {
      if (((isset($_GET['typesmoothbox']) && $_GET['typesmoothbox'] == 'sessmoothbox') || (!isset($_GET['typesmoothbox']))))
        $classroomMainPhoto = true;
      else
        $classroomMainPhoto = false;
    } elseif ($actionName == 'edit') {
      $classroomMainPhoto = false;
    }
    if (CLASSROOMPACKAGE == 1) {
      if (isset($params) && $params['upload_mainphoto'])
        $classroomMainPhoto = true;
      else
        $classroomMainPhoto = false;
    }
    elseif (!Engine_Api::_()->authorization()->isAllowed('eclassroom', $viewer, 'upload_mainphoto'))
      $classroomMainPhoto = false;
    if (!isset($classroom) && $classroomMainPhoto && $setting->getSetting('eclassroom.enable.mainphoto', 1)) {
      $photoMandatory = $setting->getSetting('eclassroom.classmainphoto', '1');
      if ($photoMandatory == 1) {
        $required = true;
        $allowEmpty = false;
      } else {
        $required = false;
        $allowEmpty = true;
      }
      $requiredClass = $required ? ' requiredClass' : '';
      $translate = Zend_Registry::get('Zend_Translate');
      //Main Photo
      $this->addElement('File', 'photo', array(
          'label' => $view->translate('Main Photo'),
          'onclick' => 'javascript:sesJqueryObject("#photo").val("")',
          'onchange' => 'handleFileBackgroundUpload(this,classroom_main_photo_preview)',
          'description'=> $view->translate('Add Photo for your Classroom'),
      ));
      $this->photo->addValidator('Extension', false, 'jpg,png,gif,jpeg');
      $this->addElement('Dummy', 'photo-uploader', array(
          'label' => 'Main Photo',
          'content' => '<div id="dragandrophandlerbackground" class="eclassroom_upload_dragdrop_content sesbasic_bxs' . $requiredClass . '"><div class="eclassroom_upload_dragdrop_content_inner"><i class="fa fa-camera"></i><span class="eclassroom_upload_dragdrop_content_txt">' . $translate->translate('Add photo for your classroom') . '</span></div></div>'
      ));
      $this->addElement('Image', 'classroom_main_photo_preview', array(
          'width' => 300,
          'height' => 200,
          'value' => '1',
          'disable' => true,
      ));
      $this->addElement('Dummy', 'removeimage', array(
          'content' => '<a class="icon_cancel form-link" id="removeimage1" style="display:none; "href="javascript:void(0);" onclick="removeImage();"><i class="fa fa-trash-o"></i>' . $translate->translate('Remove') . '</a>',
      ));
      $this->addElement('Hidden', 'removeimage2', array(
          'value' => 1,
          'order' => 10000000012,
      ));
    }
    // Privacy
    $viewOptions = (array) Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('eclassroom', $viewer, 'auth_view');
    $commentOptions = (array) Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('eclassroom', $viewer, 'auth_comment');
    $albumOptions = (array) Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('eclassroom', $viewer, 'auth_album');
    $availableLabels = array(
        'everyone' => $view->translate('Everyone'),
        'registered' => $view->translate('All Registered Members'),
        'owner_network' => $view->translate('Friends and Networks'),
        'owner_member_member' => $view->translate('Friends of Friends'),
        'owner_member' => $view->translate('Friends Only'),
        'member' => $view->translate('Classroom Guests Only'),
        'owner' => $view->translate('Classroom Admins')
    );
    $viewOptions = array_intersect_key($availableLabels, array_flip($viewOptions));
    $commentOptions = array_intersect_key(array_merge($availableLabels, array('member' => 'Classroom Members Only')), array_flip($commentOptions));
    $albumOptions = array_intersect_key(array_merge($availableLabels, array('member' => 'Classroom Members Only')), array_flip($albumOptions));
    // View
    if (!empty($viewOptions) && count($viewOptions) >= 1 && ((isset($_GET['typesmoothbox']) && $_GET['typesmoothbox'] == 'sessmoothbox') || (!isset($_GET['typesmoothbox'])))) {
      // Make a hidden field
      if (count($viewOptions) == 1) {
        $this->addElement('hidden', 'auth_view', array('value' => key($viewOptions),'order' => 100021));
        // Make select box
      } else {
        $this->addElement('Select', 'auth_view', array(
            'label' => $view->translate('View Privacy'),
            'description' => $view->translate('Who may see this Classroom?'),
            'class' => $hideClass,
            'multiOptions' => $viewOptions,
            'value' => key($viewOptions)));
        $this->auth_view->getDecorator('Description')->setOption('placement', 'append');
      }
    } else {
      if (isset($_GET['typesmoothbox']) && $_GET['typesmoothbox'] == 'sessmoothbox')
        $this->addElement('hidden', 'auth_view', array('value' => key($setting->getSetting('eclassroom.default.viewprivacypopup'))));
      else
        $this->addElement('hidden', 'auth_view', array('value' => key($setting->getSetting('eclassroom.default.viewprivacy'))));
    }
    if (Engine_Api::_()->authorization()->isAllowed('classroom', $viewer, 'allow_network')) {
      $networkOptions = array();
      $networkValues = array();
      foreach (Engine_Api::_()->getDbTable('networks', 'network')->fetchAll() as $network) {
        $networkOptions[$network->network_id] = $network->getTitle();
        $networkValues[] = $network->network_id;
      }

      if(empty($_GET['restApi'])){
        // Select Networks
        $this->addElement('multiselect', 'networks', array(
            'label' => $view->translate('Select Networks'),
            'multiOptions' => $networkOptions,
            'description' => $view->translate('Choose the Networks to which this Classroom will be displayed.'),
            'value' => $networkValues,
        ));
      }else{
         $this->addElement('MultiCheckbox', 'networks', array(
            'label' => $view->translate('Select Networks'),
            'multiOptions' => $networkOptions,
            'description' => $view->translate('Choose the Networks to which this Classroom will be displayed.'),
            'value' => $networkValues,
        ));
      }
    }
    // Comment
    if (!empty($commentOptions) && count($commentOptions) >= 1 && ((isset($_GET['typesmoothbox']) && $_GET['typesmoothbox'] == 'sessmoothbox'
     || (!isset($_GET['typesmoothbox']))))) {
      // Make a hidden field
      if (count($commentOptions) == 1) {
        $this->addElement('hidden', 'auth_comment', array('order' => 1000, 'value' => key($commentOptions)));
        // Make select box
      } else {
        $this->addElement('Select', 'auth_comment', array(
            'label' => $view->translate('Comment Privacy'), 'description' => $view->translate('Who may post comments on this Classroom?'), 'class' => $hideClass,
            'multiOptions' => $commentOptions,
            'value' => key($commentOptions),
        ));
        $this->auth_comment->getDecorator('Description')->setOption('placement', 'append');
      }
    } else {
      if (isset($_GET['typesmoothbox']) && $_GET['typesmoothbox'] == 'sessmoothbox')
        $this->addElement('hidden', 'auth_comment', array('order' => 1000, 'value' => key($setting->getSetting('eclassroom.default.commentprivacypopup'))));
      else
        $this->addElement('hidden', 'auth_comment', array('order' => 1000, 'value' => key($setting->getSetting('eclassroom.default.commentprivacy'))));
    }

    // Album
    // Make a hidden field
    if (count($albumOptions) == 1) {
      $this->addElement('hidden', 'auth_album', array('value' => key($albumOptions)));
      // Make select box
    } else {
      $this->addElement('Select', 'auth_album', array(
          'label' => $view->translate('Album Upload Privacy'),
          'description' => $view->translate('Who may upload albums to this Classroom?'),
          'multiOptions' => $albumOptions,
          'class' => $hideClass,
          'value' => key($albumOptions)
      ));
      $this->auth_album->getDecorator('Description')->setOption('placement', 'append');
    }
    if ($actionName == 'create') {
      $draft = true;
    } elseif ($actionName == 'edit') {
      $draft = !$classroom->draft;
    } 
    if ($draft) {
      $this->addElement('Select', 'draft', array(
          'label' => $view->translate('Status'),
          'class' => $hideClass,
          'description' => $view->translate('If this Classroom is published, it cannot be switched back to draft mode.'),
          'multiOptions' => array('0' => $view->translate('Saved As Draft'), '1' => $view->translate('Published')),
          'value' => 1
      ));
      $this->draft->getDecorator('Description')->setOption('placement', 'append');
    }
    if ($setting->getSetting('eclassroom.global.search', 1)) {
      // Search
      $this->addElement('Checkbox', 'search', array('label'
          => $view->translate('Enable Search'),
          'description'=>$view->translate('People can search for this Classroom'),
          'class' => $hideClass, 'value' => True
      ));
    }
    else {
      $this->addElement('Hidden', 'search', array(
        'value' => 1
      ));
    }
    // Buttons
    $this->addElement('Button', 'submit', array(
        'label' => $view->translate('Save Changes'),
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array(
            'ViewHelper',
        ),
    ));
    if (!$this->getSmoothboxType()) {
      $this->addElement('Cancel', 'cancel', array(
          'label' => 'cancel',
          'link' => true,
          'href' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'manage'), 'eclassroom_general', true),
          'prependText' => ' or ',
          'decorators' => array(
              'ViewHelper',
          ),
      ));
    } else {
      $this->addElement('Cancel', 'cancel', array(
          'label' => $view->translate('cancel'),
          'link' => true,
          'href' => '',
          'prependText' => ' or ',
          'onclick' => 'sessmoothboxclose();',
          'decorators' => array(
              'ViewHelper'
          )
      ));
    }
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons', array(
        'decorators' => array(
            'FormElements',
            'DivDivDivWrapper',
        ),
    ));
  }

}
