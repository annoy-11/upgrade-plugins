<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Create.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Estore_Form_Create extends Engine_Form {

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
    if (Engine_Api::_()->core()->hasSubject('stores'))
      $store = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    //get current logged in user
    $this->setTitle('Create New Store')
            ->setAttrib('id', 'estore_create_form')
            ->setAttrib('enctype', 'multipart/form-data')
            ->setMethod("POST");
    // ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()));
    if ($this->getSmoothboxType())
      $this->setAttrib('class', 'global_form estore_smoothbox_create');
    $request = Zend_Controller_Front::getInstance()->getRequest();
    $moduleName = $request->getModuleName();
    $controllerName = $request->getControllerName();
    $actionName = $request->getActionName();
    $hideClass = '';

    if (ESTOREPACKAGE == 1) {
      if (isset($store)) {
        $package = Engine_Api::_()->getItem('estorepackage_package', $store->package_id);
      } else {
        if ($request->getParam('package_id', 0)) {
          $package = Engine_Api::_()->getItem('estorepackage_package', $request->getParam('package_id', 0));
        } elseif ($request->getParam('existing_package_id', 0)) {
          $packageId = Engine_Api::_()->getItem('estorepackage_orderspackage', $request->getParam('existing_package_id', 0))->package_id;
          $package = Engine_Api::_()->getItem('estorepackage_package', $packageId);
        }
      }
      if (!isset($package)) {
        $packageId = Engine_Api::_()->getDbTable('packages', 'estorepackage')->getDefaultPackage();
        $package = Engine_Api::_()->getItem('estorepackage_package', $packageId);
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
        'label' => 'Store Title',
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
    $custom_url_value = isset($store->custom_url) ? $store->custom_url : (isset($_POST["custom_url"]) ? $_POST["custom_url"] : "");
    if ($actionName == 'create' || ($actionName == 'edit' && $setting->getSetting('estore.edit.url', 0))) {
      // Custom Url
      $this->addElement('Dummy', 'custom_url_store', array(
          'label' => 'Custom URL',
          'content' => '<input type="text" name="custom_url" id="custom_url" value="' . $custom_url_value . '"><span class="estore_check_availability_btn"><button id="check_custom_url_availability" type="button" name="check_availability" ><span class="estore_custom_loading_btn"><img src="application/modules/Core/externals/images/loading.gif" id="estore_custom_url_loading" alt="Loading" style="display:none;" /></span><i class="fa fa-check" id="estore_custom_url_correct" style=""></i><i class="fa fa-close" id="estore_custom_url_wrong" style="display:none;"></i><samp class="availability_tip">Check Availability</samp></button></span>',
      ));
    }
    if ($setting->getSetting('estore.storetags', 1)) {
      if ($actionName == 'create') {
        if ((isset($_GET['typesmoothbox']) && $_GET['typesmoothbox'] == 'sessmoothbox' && $setting->getSetting('estore.show.tagpopup', 1)) || (!isset($_GET['typesmoothbox']) && $setting->getSetting('estore.show.tagcreate', 1)))
          $storecretag = true;
        else
          $storecretag = false;
      }elseif ($actionName == 'edit') {
        $storecretag = true;
      }
      if ($storecretag) {
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
    $categories = Engine_Api::_()->getDbTable('categories', 'estore')->getCategoriesAssoc();
    if (count($categories) > 0) {
      $categorieEnable = $setting->getSetting('estore.category.required', '1');
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
            'item' => isset($store) ? $store : 'stores',
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
    $enableDescription = $setting->getSetting('estore.enable.description', '1');
    if ($enableDescription) {
      if ($actionName == 'create') {
        if ((isset($_GET['typesmoothbox']) && $_GET['typesmoothbox'] == 'sessmoothbox' && $setting->getSetting('estore.show.descriptionpopup', 1)) || (!isset($_GET['typesmoothbox']) && $setting->getSetting('estore.show.descriptioncreate', 1)))
          $storecredescription = true;
        else
          $storecredescription = false;
      }elseif ($actionName == 'edit') {
        $storecredescription = true;
      }
      $descriptionMandatory = $setting->getSetting('estore.description.required', '1');
      if ($descriptionMandatory == 1) {
        $required = true;
        $allowEmpty = false;
      } else {
        $required = false;
        $allowEmpty = true;
      }
      if ($storecredescription) {
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
      if ($params['store_choose_style']) {
        $chooselayoutVal = $params['store_chooselayout'];
        $designoptions = array();
        if (in_array(1, $chooselayoutVal)) {
          $designoptions[1] = '<span><img src="./application/modules/Estore/externals/images/layout_1.jpg" alt="" /></span>' . $translate->translate("Design 1");
        }
        if (in_array(2, $chooselayoutVal)) {
          $designoptions[2] = '<span><img src="./application/modules/Estore/externals/images/layout_2.jpg" alt="" /></span>' . $translate->translate("Design 2");
        }
        if (in_array(3, $chooselayoutVal)) {
          $designoptions[3] = '<span><img src="./application/modules/Estore/externals/images/layout_3.jpg" alt="" /></span>' . $translate->translate("Design 3");
        }
        if (in_array(4, $chooselayoutVal)) {
          $designoptions[4] = '<span><img src="./application/modules/Estore/externals/images/layout_4.jpg" alt="" /></span>' . $translate->translate("Design 4");
        }
        $this->addElement('Radio', 'storestyle', array(
            'label' => 'Store Profile Store Layout',
            'description' => 'Set Your Store Template',
            'multiOptions' => $designoptions,
            'escape' => false,
            'value' => $chooselayoutVal,
        ));
      } else {
        if (isset($params['bs_style_type']))
          $value = $params['bs_style_type'];
        $value = 1;
        $this->addElement('Hidden', 'storestyle', array(
            'value' => $value,
        ));
      }
    }
    else {
      if (Engine_Api::_()->authorization()->isAllowed('stores', $viewer, 'auth_bsstyle')) {
        $chooselayoutVal = json_decode(Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'stores', 'select_bsstyle'));
        $designoptions = array();
        if (in_array(1, $chooselayoutVal)) {
          $designoptions[1] = '<span><img src="./application/modules/Estore/externals/images/layout_1.jpg" alt="" /></span> ' . $translate->translate("Design 1");
          $designoptionsApi[1] = $translate->translate("Design 1");
        }
        if (in_array(2, $chooselayoutVal)) {
          $designoptions[2] = '<span><img src="./application/modules/Estore/externals/images/layout_2.jpg" alt="" /></span> ' . $translate->translate("Design 2");
          $designoptionsApi[2] = $translate->translate("Design 2");
        }
        if (in_array(3, $chooselayoutVal)) {
          $designoptions[3] = '<span><img src="./application/modules/Estore/externals/images/layout_3.jpg" alt="" /></span> ' . $translate->translate("Design 3");
          $designoptionsApi[3] = $translate->translate("Design 3");
        }
        if (in_array(4, $chooselayoutVal)) {
          $designoptions[4] = '<span><img src="./application/modules/Estore/externals/images/layout_4.jpg" alt="" /></span> ' . $translate->translate("Design 4");
          $designoptionsApi[4] = $translate->translate("Design 4");
        }
        $this->addElement('Radio', 'storestyle', array(
            'label' => 'Store Profile Store Layout',
            'description' => 'Set Your Store Template',
            'multiOptions' => empty($_GET['restApi']) ? $designoptions : $designoptionsApi,
            'escape' => false,
            'value' => 1,
        ));
      } else {
        $permissionTable = Engine_Api::_()->getDbTable('permissions', 'authorization');
        $value = $permissionTable->select()
                ->from($permissionTable->info('name'), 'value')
                ->where('level_id = ?', $viewer->level_id)
                ->where('type = ?', 'stores')
                ->where('name = ?', 'bs_style_type')
                ->query()
                ->fetchColumn();
        $this->addElement('Hidden', 'storestyle', array(
            'value' => $value,
        ));
      }
    }
    /* Location Elements */
    if ($setting->getSetting('estore_enable_location', 1)) {
      $showLocationField = true;
      if (isset($store)) {
        if (!Engine_Api::_()->authorization()->isAllowed('stores', $viewer, 'allow_mlocation'))
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
          if (isset($store)) {
            $itemlocation = Engine_Api::_()->getDbTable('locations', 'sesbasic')->getLocationData('stores', $store->getIdentity());
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
        $this->addElement('dummy', 'store_location', array(
            'decorators' => array(array('ViewScript', array(
                        'viewScript' => 'application/modules/Estore/views/scripts/_location.tpl',
                        'class' => 'form element',
                        'store' => isset($store) ? $store : '',
                        'countrySelect' => $countrySelect,
                        'itemlocation' => isset($itemlocation) ? $itemlocation : '',
                    )))
        ));
      }
    }
    if (Engine_Api::_()->authorization()->isAllowed('stores', $viewer, 'enable_price')) {
      if (Engine_Api::_()->authorization()->isAllowed('stores', $viewer, 'price_mandatory')) {
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
      if (Engine_Api::_()->authorization()->isAllowed('stores', $viewer, 'can_chooseprice')) {
        $this->addElement('Select', 'price_type', array(
            'label' => 'Price Type',
            'description' => '',
            'class' => $hideClass,
            'multiOptions' => array('' => 'Choose Price Type', '1' => 'Show Price', '2' => 'Show Starting Price'),
        ));
      } else {
        $this->addElement('hidden', 'price_type', array('value' => Engine_Api::_()->authorization()->isAllowed('stores', $viewer, 'default_prztype')));
      }
    }
//     if (Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesprofilelock')) {
//       $this->addElement('Radio', 'show_adult', array(
//           'label' => 'Mark Store as Adult',
//           'description' => 'The users of your site which are below 18 will not able to see your store',
//           'multioptions' => array(1 => 'Yes', 0 => 'No'),
//           'class' => $hideClass,
//           'value' => 0,
//       ));
//
//       $this->addElement('Radio', 'enable_lock', array(
//           'label' => 'Enable Store Lock',
//           'description' => '',
//           'multioptions' => array(1 => 'Yes', 0 => 'No'),
//           'class' => $hideClass,
//           'value' => 0
//       ));
//
//       $this->addElement('Password', 'store_password', array(
//           'label' => 'Set Lock Password',
//           'value' => '',
//       ));
//     }
    if ($setting->getSetting('estore.allow.join', 1) && $setting->getSetting('estore.allow.owner.join', 1)) {
      $this->addElement('Radio', 'can_join', array(
          'label' => 'Enable Store Joining',
          'description' => 'Do you want to allow users to join your Store?',
          'multioptions' => array(1 => 'Yes', 0 => 'No'),
          'class' => $hideClass,
          'value' => 0
      ));
      if ($setting->getSetting('estore.show.approvaloption', 1)) {
        $this->addElement('Radio', 'approval', array(
            'label' => 'Approve members',
            'description' => 'When people try to join your Store, should they be allowed to join immediately, or should they be forced to wait for approval?',
            'multioptions' => array(0 => 'New members can join immediately.', 1 => 'New members must be approved.'),
            'class' => $hideClass,
            'value' => 1
        ));
      }

      if ($setting->getSetting('estore_approve_post', 1)) {
        $this->addElement('Radio', 'auto_approve', array(
            'label' => 'Auto-Approve Posts',
            'description' => 'When people try to post on your Store, should their posts be auto-approved or wait for Store admin approval? The feed will display on the posted date in your Store timeline.',
            'multioptions' => array(1 => 'New posts will be auto-approved.', 0 => 'New posts must be approved by this Store admin.'),
            'class' => $hideClass,
            'value' => 1
        ));
      }

      if ($setting->getSetting('estore.joinstore.memtitle', 1)) {
        if ($setting->getSetting('estore.memtitle.required', 1) && (!count($_POST) || (!empty($_POST['can_join']) && $_POST['can_join'] == 1))) {
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
            'description' => 'Enter the title for members of your Store. E.g. Music Artist, Blogger, Painter, Dance Lover etc.'
        ));
        $this->addElement('Text', 'member_title_plural', array(
            'label' => 'Member\'s Plural Title',
            'allowEmpty' => $allowEmpty,
            'required' => $required,
            'description' => 'Enter the title for members of your Store. E.g. Music Artists, Bloggers, Painters, Dance Lovers etc.'
        ));
      }
    }
    if (Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesadvancedactivity') && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesadvancedactivity.pluginactivated')) {
      $this->addElement('Radio', 'other_tag', array(
          'label' => 'Other\'s Tagging Your Store',
          'description' => 'Do you want to allow other People and Stores to tag your Store?',
          'multioptions' => array(1 => 'Yes', 0 => 'No.'),
          'class' => $hideClass, 'value' => True,
          'value' => 1
      ));
    }
    if ($setting->getSetting('estore.invite.enable', 1) && $setting->getSetting('estore.invite.allow.owner', 1)) {
      $this->addElement('Radio', 'can_invite', array(
          'label' => 'Let members invite others?',
          'description' => '',
          'multioptions' => array(1 => 'Yes, allow members to invite other people.', 0 => 'No, do not allow members to invite other people.'),
          'class' => $hideClass, 'value' => True,
          'value' => 1
      ));
    } elseif ($setting->getSetting('estore.invite.enable', 1) && !$setting->getSetting('estore.invite.allow.owner', 1)) {
      $this->addElement('Hidden', 'can_invite', array(
          'value' => $setting->getSetting('estore.invite.people.default', 1),
          'order' => 99999999,
      ));
    } else {
      $this->addElement('Hidden', 'can_invite', array(
          'value' => 0,
          'order' => 99999999,
      ));
    }
    if ($actionName == 'create') {
      if ((((isset($_GET['typesmoothbox']) && $_GET['typesmoothbox'] == 'sessmoothbox' && $setting->getSetting('estore.show.photopopup', 1))) || (!isset($_GET['typesmoothbox']) && $setting->getSetting('estore.show.photocreate', 1))))
        $storeMainPhoto = true;
      else
        $storeMainPhoto = false;
    } elseif ($actionName == 'edit') {
      $storeMainPhoto = false;
    }
    if (ESTOREPACKAGE == 1) {
      if (isset($params) && $params['upload_mainphoto'])
        $storeMainPhoto = true;
      else
        $storeMainPhoto = false;
    }
    elseif (!Engine_Api::_()->authorization()->isAllowed('stores', $viewer, 'upload_mainphoto'))
      $storeMainPhoto = false;
    if (!isset($store) && $storeMainPhoto) {
      $photoMandatory = $setting->getSetting('estore.storemainphoto', '1');
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
          'onchange' => 'handleFileBackgroundUpload(this,store_main_photo_preview)',
      ));
      $this->photo->addValidator('Extension', false, 'jpg,png,gif,jpeg');
      $this->addElement('Dummy', 'photo-uploader', array(
          'label' => 'Main Photo',
          'content' => '<div id="dragandrophandlerbackground" class="estore_upload_dragdrop_content sesbasic_bxs' . $requiredClass . '"><div class="estore_upload_dragdrop_content_inner"><i class="fa fa-camera"></i><span class="estore_upload_dragdrop_content_txt">' . $translate->translate('Add photo for your store') . '</span></div></div>'
      ));
      $this->addElement('Image', 'store_main_photo_preview', array(
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
    $viewOptions = (array) Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('stores', $viewer, 'auth_view');
    $commentOptions = (array) Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('stores', $viewer, 'auth_comment');

    $albumOptions = (array) Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('stores', $viewer, 'auth_album');

    $videoOptions = (array) Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('stores', $viewer, 'auth_video');

    $availableLabels = array(
        'everyone' => 'Everyone',
        'registered' => 'All Registered Members',
        'owner_network' => 'Friends and Networks',
        'owner_member_member' => 'Friends of Friends',
        'owner_member' => 'Friends Only',
        'member' => 'Store Guests Only',
        'owner' => 'Store Admins'
    );
    $viewOptions = array_intersect_key($availableLabels, array_flip($viewOptions));
    $commentOptions = array_intersect_key(array_merge($availableLabels, array('member' => 'Store Members Only')), array_flip($commentOptions));
    $albumOptions = array_intersect_key(array_merge($availableLabels, array('member' => 'Store Members Only')), array_flip($albumOptions));
    $videoOptions = array_intersect_key($availableLabels, array_flip($videoOptions));

    // View
    if (!empty($viewOptions) && count($viewOptions) >= 1 && ((isset($_GET['typesmoothbox']) && $_GET['typesmoothbox'] == 'sessmoothbox' && $setting->getSetting('estore.show.viewprivacypopup', 1)) || (!isset($_GET['typesmoothbox']) && $setting->getSetting('estore.show.viewprivacycreate', 1)))) {
      // Make a hidden field
      if (count($viewOptions) == 1) {
        $this->addElement('hidden', 'auth_view', array('value' => key($viewOptions)));
        // Make select box
      } else {
        $this->addElement('Select', 'auth_view', array(
            'label' => 'View Privacy',
            'description' => 'Who may see this store?',
            'class' => $hideClass,
            'multiOptions' => $viewOptions,
            'value' => key($viewOptions)));
        $this->auth_view->getDecorator('Description')->setOption('placement', 'append');
      }
    } else {
      if (isset($_GET['typesmoothbox']) && $_GET['typesmoothbox'] == 'sessmoothbox')
        $this->addElement('hidden', 'auth_view', array('value' => key($setting->getSetting('estore.default.viewprivacypopup'))));
      else
        $this->addElement('hidden', 'auth_view', array('value' => key($setting->getSetting('estore.default.viewprivacy'))));
    }
    if (Engine_Api::_()->authorization()->isAllowed('stores', $viewer, 'allow_network')) {
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
            'description' => 'Choose the Networks to which this Store will be displayed.',
            'value' => $networkValues,
        ));
      }else{
         $this->addElement('MultiCheckbox', 'networks', array(
            'label' => 'Networks',
            'multiOptions' => $networkOptions,
            'description' => 'Choose the Networks to which this Store will be displayed.',
            'value' => $networkValues,
        ));
      }
    }
    // Comment
    if (!empty($commentOptions) && count($commentOptions) >= 1 && ((isset($_GET['typesmoothbox']) && $_GET['typesmoothbox'] == 'sessmoothbox' && $setting->getSetting('estore.show.commentprivacypopup', 1)) || (!isset($_GET['typesmoothbox']) && $setting->getSetting('estore.show.commentprivacycreate', 1)))) {
      // Make a hidden field
      if (count($commentOptions) == 1) {
        $this->addElement('hidden', 'auth_comment', array('order' => 1000, 'value' => key($commentOptions)));
        // Make select box
      } else {
        $this->addElement('Select', 'auth_comment', array(
            'label' => 'Comment Privacy', 'description' => 'Who may post comments on this store?', 'class' => $hideClass,
            'multiOptions' => $commentOptions,
            'value' => key($commentOptions),
        ));
        $this->auth_comment->getDecorator('Description')->setOption('placement', 'append');
      }
    } else {
      if (isset($_GET['typesmoothbox']) && $_GET['typesmoothbox'] == 'sessmoothbox')
        $this->addElement('hidden', 'auth_comment', array('order' => 1000, 'value' => key($setting->getSetting('estore.default.commentprivacypopup'))));
      else
        $this->addElement('hidden', 'auth_comment', array('order' => 1000, 'value' => key($setting->getSetting('estore.default.commentprivacy'))));
    }

    // Album
    // Make a hidden field
    if (count($albumOptions) == 1) {
      $this->addElement('hidden', 'auth_album', array('value' => key($albumOptions)));
      // Make select box
    } else {
      $this->addElement('Select', 'auth_album', array(
          'label' => 'Album Upload Privacy',
          'description' => 'Who may upload albums to this store?',
          'multiOptions' => $albumOptions,
          'class' => $hideClass,
          'value' => key($albumOptions)
      ));
      $this->auth_album->getDecorator('Description')->setOption('placement', 'append');
    }

    //video
    if (!empty($videoOptions) && count($videoOptions) >= 1 && Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('estorevideo')) {
      // Make a hidden field
      if (count($videoOptions) == 1) {
        $this->addElement('hidden', 'auth_video', array('value' => key($videoOptions)));
        // Make select box
      } else {
        $this->addElement('Select', 'auth_video', array(
            'label' => 'Video Upload Privacy',
            'description' => 'Who may upload videos to this store?',
            'multiOptions' => $videoOptions,
            'class' => $hideClass,
            'value' => key($videoOptions)
        ));
        $this->auth_video->getDecorator('Description')->setOption('placement', 'append');
      }
    }

    if ($actionName == 'create') {
      if ((isset($_GET['typesmoothbox']) && $_GET['typesmoothbox'] == 'sessmoothbox' && $setting->getSetting('estore.show.statuspopup', 1)) || (!isset($_GET['typesmoothbox']) && $setting->getSetting('estore.show.statuscreate', 1)))
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
          'description' => 'If this entry is published, it cannot be switched back to draft mode.', 'multiOptions' => array('0' => 'Saved As Draft', '1' => 'Published'),
          'value' => 1,
      ));
      $this->draft->getDecorator('Description')->setOption('placement', 'append');
    }

    if ($setting->getSetting('estore.global.search', 1)) {
      // Search
      $this->addElement('Checkbox', 'search', array('label'
          => 'People can search for this store',
          'class' => $hideClass, 'value' => True
      ));
    }
    else {
      $this->addElement('Hidden', 'search', array(
        'value' => 1,
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
          'href' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'manage'), 'estore_general', true),
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
