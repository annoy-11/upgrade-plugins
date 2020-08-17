<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Create.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespage_Form_Create extends Engine_Form {

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
    if (Engine_Api::_()->core()->hasSubject('sespage_page'))
      $page = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    //get current logged in user
    $this->setTitle('Create New Page')
            ->setAttrib('id', 'sespage_create_form')
            ->setAttrib('enctype', 'multipart/form-data')
            ->setMethod("POST");
    // ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()));
    if ($this->getSmoothboxType())
      $this->setAttrib('class', 'global_form sespage_smoothbox_create');
    $request = Zend_Controller_Front::getInstance()->getRequest();
    $moduleName = $request->getModuleName();
    $controllerName = $request->getControllerName();
    $actionName = $request->getActionName();
    $hideClass = '';

    if (SESPAGEPACKAGE == 1) {
      if (isset($page)) {
        $package = Engine_Api::_()->getItem('sespagepackage_package', $page->package_id);
      } else {
        if ($request->getParam('package_id', 0)) {
          $package = Engine_Api::_()->getItem('sespagepackage_package', $request->getParam('package_id', 0));
        } elseif ($request->getParam('existing_package_id', 0)) {
          $packageId = Engine_Api::_()->getItem('sespagepackage_orderspackage', $request->getParam('existing_package_id', 0))->package_id;
          $package = Engine_Api::_()->getItem('sespagepackage_package', $packageId);
        }
      }
      if (!isset($package)) {
        $packageId = Engine_Api::_()->getDbTable('packages', 'sespagepackage')->getDefaultPackage();
        $package = Engine_Api::_()->getItem('sespagepackage_package', $packageId);
      }
      $params = json_decode($package->params, true);
    }

    //UPLOAD PHOTO URL
    $upload_url = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sesbasic', 'controller' => 'index', 'action' => "upload-image"), 'default', true);

    $allowed_html = 'strong, b, em, i, u, strike, sub, sup, p, div, pre, address, h1, h2, h3, h4, h5, h6, span, ol, li, ul, a, img, embed, br, hr';

    $editorOptions = array(
        'upload_url' => $upload_url,
        'html' => (bool) $allowed_html,
    );

    if (!empty($upload_url)) {
      $editorOptions['editor_selector'] = 'tinymce';
      $editorOptions['mode'] = 'specific_textareas';
      $editorOptions['plugins'] = array(
          'table', 'fullscreen', 'media', 'preview', 'paste',
          'code', 'image', 'textcolor', 'jbimages', 'link'
      );

      $editorOptions['toolbar1'] = array(
          'undo', 'redo', 'removeformat', 'pastetext', '|', 'code',
          'media', 'image', 'jbimages', 'link', 'fullscreen',
          'preview'
      );
    }
    $this->addElement('Text', 'title', array(
        'label' => 'Page Title',
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
    $custom_url_value = isset($page->custom_url) ? $page->custom_url : (isset($_POST["custom_url"]) ? $_POST["custom_url"] : "");
    if ($actionName == 'create' || ($actionName == 'edit' && $setting->getSetting('sespage.edit.url', 0))) {
      // Custom Url
      $this->addElement('Dummy', 'custom_url_page', array(
          'label' => 'Custom URL',
          'content' => '<input type="text" name="custom_url" id="custom_url" value="' . $custom_url_value . '"><span class="sespage_check_availability_btn"><button id="check_custom_url_availability" type="button" name="check_availability" ><i class="fa fa-check" id="sespage_custom_url_correct" style=""></i><i class="fa fa-close" id="sespage_custom_url_wrong" style="display:none;"></i><img src="application/modules/Core/externals/images/loading.gif" id="sespage_custom_url_loading" alt="Loading" style="display:none;" /><samp class="availability_tip">Check Availability</samp></button></span>',
      ));
    }
    if ($setting->getSetting('sespage.pagetags', 1)) {
      if ($actionName == 'create') {
        if ((isset($_GET['typesmoothbox']) && $_GET['typesmoothbox'] == 'sessmoothbox' && $setting->getSetting('sespage.show.tagpopup', 1)) || (!isset($_GET['typesmoothbox']) && $setting->getSetting('sespage.show.tagcreate', 1)))
          $pagecretag = true;
        else
          $pagecretag = false;
      }elseif ($actionName == 'edit') {
        $pagecretag = true;
      }
      if ($pagecretag) {
        //Tags
        $this->addElement('Text', 'tags', array(
            'label' => 'Tags (Keywords)',
            'autocomplete' => 'off',
            'description' => 'Separate tags with commas.',
            'filters' => array(
                new Engine_Filter_Censor(),
            ),
        ));
        $this->tags->getDecorator("Description")->setOption("placement", "append");
      }
    }

    //Category
    $categories = Engine_Api::_()->getDbTable('categories', 'sespage')->getCategoriesAssoc(array('member_levels' => 1));
    if (count($categories) > 0) {
      $categorieEnable = $setting->getSetting('sespage.category.required', '1');
      if ($categorieEnable == 1) {
        $required = true;
        $allowEmpty = false;
      } else {
        $required = false;
        $allowEmpty = true;
      }
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
          'onchange' => 'showFields(this.value,1);'
      ));
      if ($actionName != 'edit' && ((isset($package) && $package->custom_fields) || (!isset($package)))) {
        $defaultProfileId = "0_0_" . $this->getDefaultProfileId();
        $customFields = new Sesbasic_Form_Custom_Fields(array(
            'packageId' => '',
            'resourceType' => '',
            'item' => isset($page) ? $page : 'sespage_page',
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
    $enableDescription = $setting->getSetting('sespage.enable.description', '1');
    if ($enableDescription) {
      if ($actionName == 'create') {
        if ((isset($_GET['typesmoothbox']) && $_GET['typesmoothbox'] == 'sessmoothbox' && $setting->getSetting('sespage.show.descriptionpopup', 1)) || (!isset($_GET['typesmoothbox']) && $setting->getSetting('sespage.show.descriptioncreate', 1)))
          $pagecredescription = true;
        else
          $pagecredescription = false;
      }elseif ($actionName == 'edit') {
        $pagecredescription = true;
      }
      $descriptionMandatory = $setting->getSetting('sespage.description.required', '1');
      if ($descriptionMandatory == 1) {
        $required = true;
        $allowEmpty = false;
      } else {
        $required = false;
        $allowEmpty = true;
      }
      if ($pagecredescription) {
        $this->addElement('TinyMce', 'description', array(
            'label' => 'Description',
            'allowEmpty' => $allowEmpty,
            'required' => $required,
            'class' => 'tinymce',
            'editorOptions' => $editorOptions,
        ));
      }
    }
    if (isset($package)) {
      $params = json_decode($package->params, true);
      if ($params['page_choose_style']) {
        $chooselayoutVal = $params['page_chooselayout'];
        $designoptions = array();
        if (in_array(1, $chooselayoutVal)) {
          $designoptions[1] = '<span><img src="./application/modules/Sespage/externals/images/layout_1.jpg" alt="" /></span>' . $translate->translate("Design 1");
        }
        if (in_array(2, $chooselayoutVal)) {
          $designoptions[2] = '<span><img src="./application/modules/Sespage/externals/images/layout_2.jpg" alt="" /></span>' . $translate->translate("Design 2");
        }
        if (in_array(3, $chooselayoutVal)) {
          $designoptions[3] = '<span><img src="./application/modules/Sespage/externals/images/layout_3.jpg" alt="" /></span>' . $translate->translate("Design 3");
        }
        if (in_array(4, $chooselayoutVal)) {
          $designoptions[4] = '<span><img src="./application/modules/Sespage/externals/images/layout_4.jpg" alt="" /></span>' . $translate->translate("Design 4");
        }
        $this->addElement('Radio', 'pagestyle', array(
            'label' => 'Page Profile Page Layout',
            'description' => 'Set Your Page Template',
            'multiOptions' => $designoptions,
            'escape' => false,
            'value' => $chooselayoutVal,
			'order' => 2003,
        ));
      } else {
        if (isset($params['page_style_type']))
          $value = $params['page_style_type'];
        $value = 1;
        $this->addElement('Hidden', 'pagestyle', array(
            'value' => $value,
			'order' => 2003,
        ));
      }
    }
    else {
      if (Engine_Api::_()->authorization()->isAllowed('sespage_page', $viewer, 'auth_pagestyle')) {
        $chooselayoutVal = json_decode(Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'sespage_page', 'select_pagestyle'));
        $designoptions = array();
        if (in_array(1, $chooselayoutVal)) {
          $designoptions[1] = '<span><img src="./application/modules/Sespage/externals/images/layout_1.jpg" alt="" /></span> ' . $translate->translate("Design 1");
          $designoptionsApi[1] = $translate->translate("Design 1");
        }
        if (in_array(2, $chooselayoutVal)) {
          $designoptions[2] = '<span><img src="./application/modules/Sespage/externals/images/layout_2.jpg" alt="" /></span> ' . $translate->translate("Design 2");
          $designoptionsApi[2] = $translate->translate("Design 2");
        }
        if (in_array(3, $chooselayoutVal)) {
          $designoptions[3] = '<span><img src="./application/modules/Sespage/externals/images/layout_3.jpg" alt="" /></span> ' . $translate->translate("Design 3");
          $designoptionsApi[3] = $translate->translate("Design 3");
        }
        if (in_array(4, $chooselayoutVal)) {
          $designoptions[4] = '<span><img src="./application/modules/Sespage/externals/images/layout_4.jpg" alt="" /></span> ' . $translate->translate("Design 4");
          $designoptionsApi[4] = $translate->translate("Design 4");
        }
        $this->addElement('Radio', 'pagestyle', array(
            'label' => 'Page Profile Page Layout',
            'description' => 'Set Your Page Template',
            'multiOptions' => empty($_GET['restApi']) ? $designoptions : $designoptionsApi,
            'escape' => false,
            'value' => 1,
        ));
      } else {
        $permissionTable = Engine_Api::_()->getDbTable('permissions', 'authorization');
        $value = $permissionTable->select()
                ->from($permissionTable->info('name'), 'value')
                ->where('level_id = ?', $viewer->level_id)
                ->where('type = ?', 'sespage_page')
                ->where('name = ?', 'page_style_type')
                ->query()
                ->fetchColumn();
        $this->addElement('Hidden', 'pagestyle', array(
            'value' => $value,
        ));
      }
    }
    /* Location Elements */
	$restapi=Zend_Controller_Front::getInstance()->getRequest()->getParam( 'restApi', null );
    if ($setting->getSetting('sespage_enable_location', 1) && $restapi != 'Sesapi') {
      $showLocationField = true;
      if (isset($page)) {
        if (!Engine_Api::_()->authorization()->isAllowed('sespage_page', $viewer, 'allow_mlocation'))
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
          $countrySelect = '<option value="">Choose Country</option>';
          if (isset($page)) {
            $itemlocation = Engine_Api::_()->getDbTable('locations', 'sesbasic')->getLocationData('sespage_page', $page->getIdentity());
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
        $this->addElement('dummy', 'page_location', array(
            'decorators' => array(array('ViewScript', array(
                        'viewScript' => 'application/modules/Sespage/views/scripts/_location.tpl',
                        'class' => 'form element',
                        'page' => isset($page) ? $page : '',
                        'countrySelect' => $countrySelect,
                        'itemlocation' => isset($itemlocation) ? $itemlocation : '',
                    )))
        ));
      }
    }
	 if ($setting->getSetting('sespage_enable_location', 1) && $restapi == 'Sesapi') {
		 $isrequired = false;
		 $isallowEmpty = true;
		if($setting->getSetting('sespage_location_isrequired', 1))
		$isrequired = true;
		$this->addElement('Text', 'page_location', array(
          'label' => 'Location',
		  'required' => $isrequired,
		  'allowEmpty' => $isallowEmpty,
      ));
	 }
     if (isset($package)) {
      $params = json_decode($package->params, true);
      if ($params['enable_price']) {
        if ($params['price_mandatory']) {
          $required = true;
          $allowEmpty = false;
        } else {
          $required = false;
          $allowEmpty = true;
        }
        $this->addElement('Text', 'price', array(
            'label' => 'Price (USD)',
            'autocomplete' => 'off',
            'allowEmpty' => $allowEmpty,
            'required' => $required,
            'validators' => array(
                array('Int', true),
                array('GreaterThan', true, array(0)),
            )
        ));
        if ($params['can_chooseprice']) {
          $this->addElement('Select', 'price_type', array(
              'label' => 'Price Type',
              'description' => '',
              'class' => $hideClass,
              'multiOptions' => array('' => 'Choose Price Type', '1' => 'Show Price', '2' => 'Show Starting Price'),
          ));
        } else {
          $this->addElement('hidden', 'price_type', array('value' => $params['default_prztype']));
        }
      }

     }else{
      if (Engine_Api::_()->authorization()->isAllowed('sespage_page', $viewer, 'enable_price')) {
        if (Engine_Api::_()->authorization()->isAllowed('sespage_page', $viewer, 'price_mandatory')) {
          $required = true;
          $allowEmpty = false;
        } else {
          $required = false;
          $allowEmpty = true;
        }
        $this->addElement('Text', 'price', array(
            'label' => 'Price (USD)',
            'autocomplete' => 'off',
            'allowEmpty' => $allowEmpty,
            'required' => $required,
            'validators' => array(
                array('Int', true),
                array('GreaterThan', true, array(0)),
            )
        ));
        if (Engine_Api::_()->authorization()->isAllowed('sespage_page', $viewer, 'can_chooseprice')) {
          $this->addElement('Select', 'price_type', array(
              'label' => 'Price Type',
              'description' => '',
              'class' => $hideClass,
              'multiOptions' => array('' => 'Choose Price Type', '1' => 'Show Price', '2' => 'Show Starting Price'),
          ));
        } else {
          $this->addElement('hidden', 'price_type', array('value' => Engine_Api::_()->authorization()->isAllowed('sespage_page', $viewer, 'default_prztype')));
        }
      }
     }
    if (Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesprofilelock')) {
      $this->addElement('Radio', 'show_adult', array(
          'label' => 'Mark Page as Adult',
          'description' => 'The users of your site which are below 18 will not able to see your page',
          'multioptions' => array(1 => 'Yes', 0 => 'No'),
          'class' => $hideClass,
          'value' => 0,
      ));

      $this->addElement('Radio', 'enable_lock', array(
          'label' => 'Enable Page Lock',
          'description' => '',
          'multioptions' => array(1 => 'Yes', 0 => 'No'),
          'class' => $hideClass,
          'value' => 0
      ));

      $this->addElement('Password', 'page_password', array(
          'label' => 'Set Lock Password',
          'value' => '',
      ));
    }
    if ($setting->getSetting('sespage.allow.join', 1) && $setting->getSetting('sespage.allow.owner.join', 1)) {
      $this->addElement('Radio', 'can_join', array(
          'label' => 'Enable Page Joining',
          'description' => 'Do you want to allow users to join your Page?',
          'multioptions' => array(1 => 'Yes', 0 => 'No'),
          'class' => $hideClass,
          'value' => 0
      ));
      if ($setting->getSetting('sespage.show.approvaloption', 1)) {
        $this->addElement('Radio', 'approval', array(
            'label' => 'Approve members',
            'description' => 'When people try to join your Page, should they be allowed to join immediately, or should they be forced to wait for approval?',
            'multioptions' => array( 1 => 'New members must be approved.',0 => 'New members can join immediately.'),
            'class' => $hideClass,
            'value' => 1
        ));
      }

      if ($setting->getSetting('sespage_approve_post', 1)) {
        $this->addElement('Radio', 'auto_approve', array(
            'label' => 'Auto-Approve Posts',
            'description' => 'When people try to post on your Page, should their posts be auto-approved or wait for Page admins approval? The feed will display on the posted date in your Page timeline.',
            'multioptions' => array(1 => 'New posts will be auto-approved.', 0 => 'New posts must be approved by this Page admins.'),
            'class' => $hideClass,
            'value' => 1
        ));
      }

      if ($setting->getSetting('sespage.joinpage.memtitle', 1)) {
        if ($setting->getSetting('sespage.memtitle.required', 1) && (!count($_POST) || (!empty($_POST['can_join']) && $_POST['can_join'] == 1))) {
          $required = true;
          $allowEmpty = false;
        } else {
          $required = false;
          $allowEmpty = true;
        }
        $this->addElement('Text', 'member_title_singular', array(
            'label' => 'Member\'s Singular Title',
            'allowEmpty' => $allowEmpty,
            'required' => $required,
            'description' => 'Enter the title for members of your Page. E.g. Music Artist, Blogger, Painter, Dance Lover etc.'
        ));
        $this->addElement('Text', 'member_title_plural', array(
            'label' => 'Member\'s Plural Title',
            'allowEmpty' => $allowEmpty,
            'required' => $required,
            'description' => 'Enter the title for members of your Page. E.g. Music Artists, Bloggers, Painters, Dance Lovers etc.'
        ));
      }
    }
    if (Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesadvancedactivity') && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesadvancedactivity.pluginactivated')) {
      $this->addElement('Radio', 'other_tag', array(
          'label' => 'Other\'s Tagging Your Page',
          'description' => 'Do you want to allow other People and Pages to tag your Page?',
          'multioptions' => array(1 => 'Yes', 0 => 'No.'),
          'class' => $hideClass, 'value' => True,
          'value' => 1
      ));
    }
    if ($setting->getSetting('sespage.invite.enable', 1) && $setting->getSetting('sespage.invite.allow.owner', 1)) {
      $this->addElement('Radio', 'can_invite', array(
          'label' => 'Let members invite others?',
          'description' => '',
          'multioptions' => array(1 => 'Yes, allow members to invite other people.', 0 => 'No, do not allow members to invite other people.'),
          'class' => $hideClass, 'value' => True,
          'value' => 1
      ));
    } elseif ($setting->getSetting('sespage.invite.enable', 1) && !$setting->getSetting('sespage.invite.allow.owner', 1)) {
      $this->addElement('Hidden', 'can_invite', array(
          'value' => $setting->getSetting('sespage.invite.people.default', 1),
          'order' => 99999999,
      ));
    } else {
      $this->addElement('Hidden', 'can_invite', array(
          'value' => 0,
          'order' => 99999999,
      ));
    }
    if ($actionName == 'create') {
      if ((((isset($_GET['typesmoothbox']) && $_GET['typesmoothbox'] == 'sessmoothbox' && $setting->getSetting('sespage.show.photopopup', 1))) || (!isset($_GET['typesmoothbox']) && $setting->getSetting('sespage.show.photocreate', 1))))
        $pageMainPhoto = true;
      else
        $pageMainPhoto = false;
    } elseif ($actionName == 'edit') {
      $pageMainPhoto = false;
    }
    if (SESPAGEPACKAGE == 1) {
      if (isset($params) && $params['upload_mainphoto'])
        $pageMainPhoto = true;
      else
        $pageMainPhoto = false;
    }
    elseif (!Engine_Api::_()->authorization()->isAllowed('sespage_page', $viewer, 'upload_mainphoto'))
      $pageMainPhoto = false;
	  $photoMandatory = $setting->getSetting('sespage.pagemainphoto', '1');
    if (!isset($page) && $pageMainPhoto && $restapi != 'Sesapi') {
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
          'label' => 'Main Photo',
          'onclick' => 'javascript:sesJqueryObject("#photo").val("")',
          'onchange' => 'handleFileBackgroundUpload(this,page_main_photo_preview)',
      ));
      $this->photo->addValidator('Extension', false, 'jpg,png,gif,jpeg');
      $this->addElement('Dummy', 'photo-uploader', array(
          'label' => 'Main Photo',
          'content' => '<div id="dragandrophandlerbackground" class="sespage_upload_dragdrop_content sesbasic_bxs' . $requiredClass . '"><div class="sespage_upload_dragdrop_content_inner"><i class="fa fa-camera"></i><span class="sespage_upload_dragdrop_content_txt">' . $translate->translate('Add photo for your page') . '</span></div></div>'
      ));
      $this->addElement('Image', 'page_main_photo_preview', array(
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
    }elseif(!isset($page) && $pageMainPhoto && $restapi == 'Sesapi'){
		if ($photoMandatory == 1) {
        $photoRequired = true;
        $photoAllowEmpty = false;
      } else {
        $photoRequired = false;
        $photoAllowEmpty = true;
      }
		$this->addElement('File', 'photo', array(
          'label' => 'Main Photo',
		  'allowEmpty' => $photoAllowEmpty,
            'required' => $photoRequired,
      ));
      $this->photo->addValidator('Extension', false, 'jpg,png,gif,jpeg');
	}
    // Privacy
    $viewOptions = (array) Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('sespage_page', $viewer, 'auth_view');
    $commentOptions = (array) Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('sespage_page', $viewer, 'auth_comment');

    //Album Photo
    $albumOptions = (array) Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('sespage_page', $viewer, 'auth_album');

    //Video
    $videoOptions = (array) Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('sespage_page', $viewer, 'auth_video');

    //Note
    $noteOptions = (array) Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('sespage_page', $viewer, 'auth_note');

    //Offer
    $offerOptions = (array) Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('sespage_page', $viewer, 'auth_offer');

    //Poll
    $pollOptions = (array) Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('sespage_page', $viewer, 'auth_poll');

    $availableLabels = array(
        'everyone' => 'Everyone',
        'registered' => 'All Registered Members',
        'owner_network' => 'Friends and Networks',
        'owner_member_member' => 'Friends of Friends',
        'owner_member' => 'Friends Only',
        'member' => 'Page Guests Only',
        'owner' => 'Page Admins'
    );
    $viewOptions = array_intersect_key($availableLabels, array_flip($viewOptions));
    $commentOptions = array_intersect_key(array_merge($availableLabels, array('member' => 'Page Members Only')), array_flip($commentOptions));
    $albumOptions = array_intersect_key(array_merge($availableLabels, array('member' => 'Page Members Only')), array_flip($albumOptions));
    $videoOptions = array_intersect_key($availableLabels, array_flip($videoOptions));
    $pollOptions = array_intersect_key($availableLabels, array_flip($pollOptions));
    $noteOptions = array_intersect_key($availableLabels, array_flip($noteOptions));
    $offerOptions = array_intersect_key($availableLabels, array_flip($offerOptions));


    // View
    if (!empty($viewOptions) && count($viewOptions) >= 1 && ((isset($_GET['typesmoothbox']) && $_GET['typesmoothbox'] == 'sessmoothbox' && $setting->getSetting('sespage.show.viewprivacypopup', 1)) || (!isset($_GET['typesmoothbox']) && $setting->getSetting('sespage.show.viewprivacycreate', 1)))) {
      // Make a hidden field
      if (count($viewOptions) == 1) {
        $this->addElement('hidden', 'auth_view', array('value' => key($viewOptions)));
        // Make select box
      } else {
        $this->addElement('Select', 'auth_view', array(
            'label' => 'View Privacy',
            'description' => 'Who may see this page?',
            'class' => $hideClass,
            'multiOptions' => $viewOptions,
            'value' => key($viewOptions)));
        $this->auth_view->getDecorator('Description')->setOption('placement', 'append');
      }
    } else {
      if (isset($_GET['typesmoothbox']) && $_GET['typesmoothbox'] == 'sessmoothbox')
        $this->addElement('hidden', 'auth_view', array('value' => key($setting->getSetting('sespage.default.viewprivacypopup'))));
      else
        $this->addElement('hidden', 'auth_view', array('value' => key($setting->getSetting('sespage.default.viewprivacy'))));
    }
    if (Engine_Api::_()->authorization()->isAllowed('sespage_page', $viewer, 'allow_network')) {
      $networkOptions = array();
      $networkValues = array();
      foreach (Engine_Api::_()->getDbTable('networks', 'network')->fetchAll() as $network) {
        $networkOptions[$network->network_id] = $network->getTitle();
        $networkValues[] = $network->network_id;
      }

      if(empty($_GET['restApi'])){
        // Select Networks
        $this->addElement('multiselect', 'networks', array(
            'label' => 'Networks',
            'multiOptions' => $networkOptions,
            'description' => 'Choose the Networks to which this Business will be displayed.',
            'value' => $networkValues,
        ));
      }else{
         $this->addElement('MultiCheckbox', 'networks', array(
            'label' => 'Networks',
            'multiOptions' => $networkOptions,
            'description' => 'Choose the Networks to which this Business will be displayed.',
            'value' => $networkValues,
        ));
      }
    }
    // Comment
    if (!empty($commentOptions) && count($commentOptions) >= 1 && ((isset($_GET['typesmoothbox']) && $_GET['typesmoothbox'] == 'sessmoothbox' && $setting->getSetting('sespage.show.commentprivacypopup', 1)) || (!isset($_GET['typesmoothbox']) && $setting->getSetting('sespage.show.commentprivacycreate', 1)))) {
      // Make a hidden field
      if (count($commentOptions) == 1) {
        $this->addElement('hidden', 'auth_comment', array('order' => 1000, 'value' => key($commentOptions)));
        // Make select box
      } else {
        $this->addElement('Select', 'auth_comment', array(
            'label' => 'Comment Privacy', 'description' => 'Who may post comments on this page?', 'class' => $hideClass,
            'multiOptions' => $commentOptions,
            'value' => key($commentOptions),
        ));
        $this->auth_comment->getDecorator('Description')->setOption('placement', 'append');
      }
    } else {
      if (isset($_GET['typesmoothbox']) && $_GET['typesmoothbox'] == 'sessmoothbox')
        $this->addElement('hidden', 'auth_comment', array('order' => 1000, 'value' => key($setting->getSetting('sespage.default.commentprivacypopup'))));
      else
        $this->addElement('hidden', 'auth_comment', array('order' => 1000, 'value' => key($setting->getSetting('sespage.default.commentprivacy'))));
    }

    // Album
    if(empty($params) || $params['album']){
      if (count($albumOptions) == 1){
        $this->addElement('hidden', 'auth_album', array('value' => key($albumOptions), 'order' => 1003));
      }else{
        $this->addElement('Select', 'auth_album', array(
            'label' => 'Album Upload Privacy',
            'description' => 'Who may upload albums to this page?',
            'multiOptions' => $albumOptions,
            'class' => $hideClass,
            'value' => key($albumOptions)
        ));
        $this->auth_album->getDecorator('Description')->setOption('placement', 'append');
      }
    }

    //video
    if (!empty($videoOptions) && count($videoOptions) >= 1 && Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sespagevideo')) {
      // Make a hidden field
      if (count($videoOptions) == 1) {
        $this->addElement('hidden', 'auth_video', array('value' => key($videoOptions)));
        // Make select box
      } else {
        $this->addElement('Select', 'auth_video', array(
            'label' => 'Video Upload Privacy',
            'description' => 'Who may upload videos to this page?',
            'multiOptions' => $videoOptions,
            'class' => $hideClass,
            'value' => key($videoOptions)
        ));
        $this->auth_video->getDecorator('Description')->setOption('placement', 'append');
      }
    }

    //Note Extension
    if ((empty($params) || $params['note']) && Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sespagenote')) {
      // Make a hidden field
      if (count($noteOptions) == 1) {
        $this->addElement('hidden', 'auth_note', array('value' => key($noteOptions)));
        // Make select box
      } else {
        $this->addElement('Select', 'auth_note', array(
            'label' => 'Note Create Privacy',
            'description' => 'Who may create notes to this page?',
            'multiOptions' => $noteOptions,
            'class' => $hideClass,
            'value' => key($noteOptions)
        ));
        $this->auth_note->getDecorator('Description')->setOption('placement', 'append');
      }
    }

    //Offer Extension
    if ((empty($params) || $params['offer']) && Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sespageoffer')) {
      // Make a hidden field
      if (count($offerOptions) == 1) {
        $this->addElement('hidden', 'auth_offer', array('value' => key($offerOptions)));
        // Make select box
      } else {
        $this->addElement('Select', 'auth_offer', array(
            'label' => 'Offer Create Privacy',
            'description' => 'Who may create offers to this page?',
            'multiOptions' => $offerOptions,
            'class' => $hideClass,
            'value' => key($offerOptions)
        ));
        $this->auth_offer->getDecorator('Description')->setOption('placement', 'append');
      }
    }

    // // poll
    if (!empty($pollOptions) && count($pollOptions) >= 1 && Engine_Api::_()->getDbTable('modules', 'core')
        ->isModuleEnabled('sespagepoll')) {
      // Make a hidden field
      if (count($pollOptions) == 1) {
        $this->addElement('hidden', 'auth_poll', array('value' => key($pollOptions)));
        // Make select box
      } else {
        $this->addElement('Select', 'auth_poll', array(
          'label' => 'Poll Upload Privacy',
          'description' => ' Who may upload polls in this Page?',
          'multiOptions' => $pollOptions,
          'class' => $hideClass,
          'value' => key($pollOptions)
        ));
        $this->auth_poll->getDecorator('Description')->setOption('placement', 'append');
      }
    }
    if ($actionName == 'create') {
      if ((isset($_GET['typesmoothbox']) && $_GET['typesmoothbox'] == 'sessmoothbox' && $setting->getSetting('sespage.show.statuspopup', 1)) || (!isset($_GET['typesmoothbox']) && $setting->getSetting('sespage.show.statuscreate', 1)))
        $draft = true;
      else
        $draft = false;
    } elseif ($actionName == 'edit') {
      $draft = true;
    }

    if ($draft) {
      $this->addElement('Select', 'draft', array(
          'label' => 'Status',
          'class' => $hideClass,
          'description' => 'If this entry is published, it cannot be switched back to draft mode.', 'multiOptions' => array( '1' => 'Published','0' => 'Saved As Draft'),
          'value' => 1,
      ));
      $this->draft->getDecorator('Description')->setOption('placement', 'append');
    }

    if ($setting->getSetting('sespage.global.search', 1)) {
      // Search
      $this->addElement('Checkbox', 'search', array('label'
          => 'People can search for this page',
          'class' => $hideClass, 'value' => True
      ));
    }
    else {
      $this->addElement('Hidden', 'search', array(
        'value' => 1,
		'order' => 2005,
      ));
    }

    // Buttons
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
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
          'href' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'manage'), 'sespage_general', true),
          'prependText' => ' or ',
          'decorators' => array(
              'ViewHelper',
          ),
      ));
    } else {
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
    }
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons', array(
        'decorators' => array(
            'FormElements',
            'DivDivDivWrapper',
        ),
    ));
  }

}
