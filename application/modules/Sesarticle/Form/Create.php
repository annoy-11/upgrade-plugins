<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesarticle
 * @package    Sesarticle
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Create.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesarticle_Form_Create extends Engine_Form
{
  public $_error = array();
  protected $_defaultProfileId;
  protected $_fromApi;
  protected $_smoothboxType;
  public function getFromApi() {
    return $this->_fromApi;
  }

  public function setFromApi($fromApi) {
    $this->_fromApi = $fromApi;
    return $this;
  }

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
		$viewer = Engine_Api::_()->user()->getViewer();
    if($this->getSmoothboxType())
      $hideClass = 'sesarticle_hideelement_smoothbox';
    else
      $hideClass = '';

  $translate = Zend_Registry::get('Zend_Translate');
	 if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesarticlepackage') && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticlepackage.enable.package', 1)){
		 $package_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('package_id');
	 if($package_id)
	 	$package = Engine_Api::_()->getItem('sesarticlepackage_package',$package_id);
	 else{
		$existing_package_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('existing_package_id');
		$existing_package = Engine_Api::_()->getItem('sesarticlepackage_orderspackage',$existing_package_id);
		$package = Engine_Api::_()->getItem('sesarticlepackage_package',$existing_package->package_id);
	}
		if ( ($package) && $package_id || $existing_package_id) {
			$modulesEnable = json_decode($package->params,true);
		}
	 }

    $this->setTitle('Write New Entry')
      ->setDescription('Compose your new article entry below, then click "Post Entry" to publish the entry to your article.')
      ->setAttrib('name', 'sesarticles_create');

		if($this->getSmoothboxType())
			$this->setAttrib('class','global_form sesarticle_smoothbox_create');

    $user = Engine_Api::_()->user()->getViewer();
    $user_level = Engine_Api::_()->user()->getViewer()->level_id;

    if (Engine_Api::_()->core()->hasSubject('sesarticle'))
    $article = Engine_Api::_()->core()->getSubject();

    $this->addElement('Text', 'title', array(
      'label' => 'Title',
      'allowEmpty' => false,
      'required' => true,
      'filters' => array(
        new Engine_Filter_Censor(),
        'StripTags',
        new Engine_Filter_StringLength(array('max' => '224'))
      ),
    ));

    $custom_url_value = isset($article->custom_url) ? $article->custom_url : (isset($_POST["custom_url"]) ? $_POST["custom_url"] : "");
    // Custom Url
    $this->addElement('Dummy', 'custom_url_article', array(
	'label' => 'Custom Url',
	'content' => '<input type="text" name="custom_url" id="custom_url" value="' . $custom_url_value . '"><i class="fa fa-check" id="sesarticle_custom_url_correct" style="display:none;"></i><i class="fa fa-close" id="sesarticle_custom_url_wrong" style="display:none;"></i><span class="sesarticle_check_availability_btn"><img src="application/modules/Core/externals/images/loading.gif" id="sesarticle_custom_url_loading" alt="Loading" style="display:none;" /><button id="check_custom_url_availability" type="button" name="check_availability" >Check Availability</button></span> <p id="suggestion_tooltip" class="check_tooltip" style="display:none;">'.$translate->translate("You can use letters, numbers and periods.").'</p>',
    ));

    // init to
    $this->addElement('Text', 'tags', array(
        'label' => 'Tags (Keywords)',
        'autocomplete' => 'off',
        'description' => 'Separate tags with commas.',
        'filters' => array(
            new Engine_Filter_Censor(),
        )
    ));
    $this->tags->getDecorator("Description")->setOption("placement", "append");

    if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.start.date', 1))  {

    $this->addElement('Radio', 'show_start_time', array(
        'label' => 'Start Date',
        'description' => '',
        'multiOptions' => array(
        "" => 'Choose Start Date',
        "1" => 'Publish Now',
      ),
      'value' => 1,
      'onclick' => "showStartDate(this.value);",
    ));
      if($this->getFromApi()){
        // Start time
        $start = new Engine_Form_Element_Date('starttime');
        $start->setLabel("Start Time");
        $start->setAllowEmpty(true);
        $start->setRequired(false);
        $this->addElement($start);
      }
			if(empty($_POST)){
				$startDate = date('Y-m-d h:i:s', strtotime(date('Y-m-d h:i:s') . ' + 2 minutes'));
				$start_date = date('m/d/Y',strtotime($startDate));
				$start_time = date('g:ia',strtotime($startDate));

				if($viewer->timezone){
					$start =  strtotime(date('Y-m-d h:i:s', strtotime(date('Y-m-d h:i:s') . ' + 2 minutes')));
					$selectedTime = "00:02:00";
					$startTime = intval(time()+strtotime($selectedTime));
					$oldTz = date_default_timezone_get();
					date_default_timezone_set($viewer->timezone);
					$start_date = date('m/d/Y',($start));

					$start_time = date('g:ia',$startTime);
					date_default_timezone_set($oldTz);
				}
			}else{
				$start_date = date('m/d/Y',strtotime($_POST['start_date']));
				$start_time = date('g:ia',strtotime($_POST['start_time']));
			}
			$this->addElement('dummy', 'article_custom_datetimes', array(
				'decorators' => array(array('ViewScript', array(
										'viewScript' => 'application/modules/Sesarticle/views/scripts/_customdates.tpl',
										'class' => 'form element',
										'start_date'=>$start_date,
										'start_time'=>$start_time,
										'start_time_check'=>1,
										'subject'=>isset($article) ? $article : '',
								)))
			));
    }
    if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle_enable_location', 1) && ((isset($modulesEnable) && array_key_exists('enable_location',$modulesEnable) && $modulesEnable['enable_location']) || empty($modulesEnable))) {
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

    // prepare categories
    $categories = Engine_Api::_()->getDbtable('categories', 'sesarticle')->getCategoriesAssoc(array('member_level'=>'1'));
    if( count($categories) > 0 ) {
		$categorieEnable = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.category.enable', '1');
		if ($categorieEnable == 1) {
			$required = true;
			$allowEmpty = false;
		} else {
			$required = false;
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
      $customFields = new Sesarticle_Form_Custom_Fields(array(
          'item' => 'sesarticle',
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
	$photoLeft = true;
	if(isset($existing_package_id) && $existing_package_id){
			$modulesEnable = json_decode($package->params,true);
			$package_id = $existing_package->package_id;
			if($package_id){
				$photoLeft = $package->allowUploadPhoto($existing_package->getIdentity(),true);
			}

	}

		$mainPhotoEnable = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.photo.mandatory', '1');
		if ($mainPhotoEnable == 1) {
			$required = true;
			$allowEmpty = false;
		} else {
			$required = false;
			$allowEmpty = true;
		}
	 // Init submit
    if($this->getFromApi()){
     $this->addElement('File', 'file', array(
        'label' => 'Main Photo',
        'description' => '',
      ));
    }
   if(((isset($modulesEnable) && array_key_exists('modules',$modulesEnable) && in_array('photo',$modulesEnable['modules'])) || empty($modulesEnable)) && $photoLeft){
		 	if(isset($modulesEnable) && array_key_exists('photo_count',$modulesEnable) && $modulesEnable['photo_count']){
				if(isset($photoLeft))
					$photo_count = $photoLeft;
				else
					$photo_count = $modulesEnable['photo_count'];
	 			$this->addElement('hidden', 'photo_count', array('value' => $photo_count,'order'=>8769));
	 		}


			$this->addElement('Dummy', 'fancyuploadfileids', array('content'=>'<input id="fancyuploadfileids" name="file" type="hidden" value="" >'));

			$this->addElement('Dummy', 'tabs_form_articlecreate', array(
			'label' => 'Upload photos',
			//'required'=>$required,
			//'allowEmpty'=>$allowEmpty,
			'content' => '<div class="sesarticle_create_form_tabs sesbasic_clearfix sesbm"><ul id="sesarticle_create_form_tabs" class="sesbasic_clearfix"><li class="active sesbm"><i class="fa fa-arrows sesbasic_text_light"></i><a href="javascript:;" class="drag_drop">'.$translate->translate('Drag & Drop').'</a></li><li class=" sesbm"><i class="fa fa-upload sesbasic_text_light"></i><a href="javascript:;" class="multi_upload">'.$translate->translate('Multi Upload').'</a></li><li class=" sesbm"><i class="fa fa-link sesbasic_text_light"></i><a href="javascript:;" class="from_url">'.$translate->translate('From URL').'</a></li></ul></div>',
			));
			$this->addElement('Dummy', 'drag-drop', array(
			'content' => '<div id="dragandrophandler" class="sesarticle_upload_dragdrop_content sesbasic_bxs">'.$translate->translate('Drag & Drop Photos Here').'</div>',
			));
			$this->addElement('Dummy', 'from-url', array(
			'content' => '<div id="from-url" class="sesarticle_upload_url_content sesbm"><input type="text" name="from_url" id="from_url_upload" value="" placeholder="'.$translate->translate('Enter Image URL to upload').'"><span id="loading_image"></span><span></span><button id="upload_from_url">'.$translate->translate('Upload').'</button></div>',
			));

			$this->addElement('Dummy', 'file_multi', array('content'=>'<input type="file" accept="image/x-png,image/jpeg" onchange="readImageUrl(this)" multiple="multiple" id="file_multi" name="file_multi">'));
			$this->addElement('Dummy', 'uploadFileContainer', array('content'=>'<div id="show_photo_container" class="sesarticle_upload_photos_container sesbasic_bxs sesbasic_custom_scroll clear"><div id="show_photo"></div></div>'));
  }else{
		//make main photo upload btn
		$this->addElement('File', 'photo_file', array(
			'label' => 'Main Photo',
			'required'=>$required,
			'allowEmpty'=>$allowEmpty,
		));
		$this->photo_file->addValidator('Extension', false, 'jpg,png,gif,jpeg');
	}

    $allowed_html = Engine_Api::_()->authorization()->getPermission($user_level, 'sesarticle', 'auth_html');
    $upload_url = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sesbasic', 'controller' => 'index', 'action' => "upload-image"), 'default', true);

    $editorOptions = array(
      'upload_url' => $upload_url,
      'html' => (bool) $allowed_html,
    );

    if (!empty($upload_url))
    {
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

		if((isset($modulesEnable) && array_key_exists('enable_tinymce',$modulesEnable) && $modulesEnable['enable_tinymce']) || empty($modulesEnable)) {
				$textarea = 'TinyMce';
		}else
			$textarea = 'Textarea';


		$descriptionMan= Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.description.mandatory', '1');
		if ($descriptionMan == 1) {
			$required = true;
			$allowEmpty = false;
		} else {
			$required = false;
			$allowEmpty = true;
		}

    $this->addElement($textarea, 'body', array(
      'label' => 'Article Description',
      'required' => $required,
      'allowEmpty' => $allowEmpty,
      'class'=>'tinymce',
      'editorOptions' => $editorOptions,
    ));

    if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.enablearticledesignview', 1)) {

      $chooselayout = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.chooselayout', 'a:4:{i:0;s:1:"1";i:1;s:1:"2";i:2;s:1:"3";i:3;s:1:"4";}');
      $chooselayoutVal = unserialize($chooselayout);

      $designoptions = array();
      if(is_array($chooselayoutVal)  && in_array(1, $chooselayoutVal)) {
        $designoptions[1] = '<a href="" onclick="showPreview(1);return false;"><img src="./application/modules/Sesarticle/externals/images/layout_1.jpg" alt="" /></a> '.$translate->translate("Design 1");
      }
      if(is_array($chooselayoutVal)  && in_array(2, $chooselayoutVal)) {
        $designoptions[2] = '<a href="" onclick="showPreview(2);return false;"><img src="./application/modules/Sesarticle/externals/images/layout_2.jpg" alt="" /></a> '.$translate->translate("Design 2");
      }
      if(is_array($chooselayoutVal)  && in_array(3, $chooselayoutVal)) {
        $designoptions[3] = '<a href="" onclick="showPreview(3);return false;"><img src="./application/modules/Sesarticle/externals/images/layout_3.jpg" alt="" /></a> '.$translate->translate("Design 3");
      }

      if(is_array($chooselayoutVal)  && in_array(4, $chooselayoutVal)) {
        $designoptions[4] = '<a href="" onclick="showPreview(4);return false;"><img src="./application/modules/Sesarticle/externals/images/layout_4.jpg" alt="" /></a> '.$translate->translate("Design 4");
      }

      $this->addElement('Radio', 'articlestyle', array(
        'label' => 'Article Layout',
        'description' => 'Set Your Article Template',
        'multiOptions' => $designoptions,
        'escape' => false,
        'value' => $chooselayoutVal,
      ));
		} else {
      $this->addElement('Hidden', 'articlestyle', array(
        'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.defaultlayout', 1),
      ));
		}

		if(Engine_Api::_()->authorization()->isAllowed('sesarticle', Engine_Api::_()->user()->getViewer(), 'cotinuereading')){
			 $this->addElement('Radio', 'cotinuereading', array(
				'label' => 'Enable Continue Reading Button',
				'description' => 'Do you want to enable "Continue Reading" button for your Article?',
				'multiOptions' => array(
					'1'=>'Yes',
					'0'=>'No',
				),
				'onchange' => 'showHideHeight(this.value)',
				'value'=>'1',
        ));
        $this->addElement('Text', 'continue_height', array(
            'label' => 'Enter Height',
            'description' => 'Enter the height after you want to show continue reading button. 0 for unlimited.',
            'value' => '0'
        ));
		}else{
			if(Engine_Api::_()->authorization()->isAllowed('sesarticle', Engine_Api::_()->user()->getViewer(), 'cntrdng_dflt')){
				$val = 1;
				$continue_height = Engine_Api::_()->authorization()->getPermission(Engine_Api::_()->user()->getViewer()->level_id, 'sesarticle', 'continue_height');
			}else{
				$val = 0;
				$continue_height = 0;
			}
			$this->addElement('Hidden', 'cotinuereading', array(
                'value' => $val,
                'order'=>9878
			));
			$this->addElement('Hidden', 'continue_height', array(
                'value' => $continue_height,
                'order'=>9879
			));
		}


    if (Engine_Api::_()->authorization()->isAllowed('sesarticle', Engine_Api::_()->user()->getViewer(), 'allow_levels')) {

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
            'description' => 'Choose the Member Levels to which this Article will be displayed. (Note: Hold down the CTRL key to select or de-select specific member levels.)',
            'value' => $levelValues,
        ));
    }

    if (Engine_Api::_()->authorization()->isAllowed('sesarticle', $viewer, 'allow_network')) {
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
          'description' => 'Choose the Networks to which this Article will be displayed. (Note: Hold down the CTRL key to select or de-select specific networks.)',
          'value' => $networkValues,
      ));
    }

    $this->addElement('Checkbox', 'search', array(
      'label' => 'Show this article entry in search results',
      'value' => 1,
    ));

    $availableLabels = array(
      'everyone'            => 'Everyone',
      'registered'          => 'All Registered Members',
      'owner_network'       => 'Friends and Networks',
      'owner_member_member' => 'Friends of Friends',
      'owner_member'        => 'Friends Only',
      'owner'               => 'Just Me'
    );

    // Element: auth_view
    $viewOptions = (array) Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('sesarticle', $user, 'auth_view');
    $viewOptions = array_intersect_key($availableLabels, array_flip($viewOptions));

    if( !empty($viewOptions) && count($viewOptions) >= 1 ) {
      // Make a hidden field
      if(count($viewOptions) == 1) {
        $this->addElement('hidden', 'auth_view', array('value' => key($viewOptions)));
      // Make select box
      } else {
        $this->addElement('Select', 'auth_view', array(
            'label' => 'Privacy',
            'description' => 'Who may see this article entry?',
            'multiOptions' => $viewOptions,
            'value' => key($viewOptions),
            'class'=>$hideClass,
        ));
        $this->auth_view->getDecorator('Description')->setOption('placement', 'append');
      }
    }

    // Element: auth_comment
    $commentOptions = (array) Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('sesarticle', $user, 'auth_comment');
    $commentOptions = array_intersect_key($availableLabels, array_flip($commentOptions));

    if( !empty($commentOptions) && count($commentOptions) >= 1 ) {
      // Make a hidden field
      if(count($commentOptions) == 1) {
        $this->addElement('hidden', 'auth_comment', array('value' => key($commentOptions)));
      // Make select box
      } else {
        $this->addElement('Select', 'auth_comment', array(
            'label' => 'Comment Privacy',
            'description' => 'Who may post comments on this article entry?',
            'multiOptions' => $commentOptions,
            'value' => key($commentOptions),
            'class'=>$hideClass,
        ));
        $this->auth_comment->getDecorator('Description')->setOption('placement', 'append');
      }
    }
 		$this->addElement('Select', 'draft', array(
      'label' => 'Status',
      'multiOptions' => array(""=>"Published", "1"=>"Saved As Draft"),
      'description' => 'If this entry is published, it cannot be switched back to draft mode.',
      'class'=>$hideClass,
    ));
    $this->draft->getDecorator('Description')->setOption('placement', 'append');
     $this->addElement('Button', 'submit_check',array(
      'type' => 'submit',
    ));

    // Element: submit
    $this->addElement('Button', 'submit', array(
        'label' => 'Post Entry',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array(
            'ViewHelper',
        ),
    ));

    if($this->getSmoothboxType()) {
			$this->addElement('Cancel', 'advanced_sesarticleoptions', array(
        'label' => 'Show Advanced Settings',
        'link' => true,
				'class'=>'active',
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
    }
  }
}
