<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Create.php  2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesjob_Form_Create extends Engine_Form
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

    if($this->getSmoothboxType())
      $hideClass = 'sesjob_hideelement_smoothbox';
    else
      $hideClass = '';
    $viewer = Engine_Api::_()->user()->getViewer();
    $translate = Zend_Registry::get('Zend_Translate');
	 if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesjobpackage') && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjobpackage.enable.package', 1)){
		 $package_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('package_id');
	 if($package_id)
	 	$package = Engine_Api::_()->getItem('sesjobpackage_package',$package_id);
	 else{
		$existing_package_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('existing_package_id');
		$existing_package = Engine_Api::_()->getItem('sesjobpackage_orderspackage',$existing_package_id);
		$package = Engine_Api::_()->getItem('sesjobpackage_package',$existing_package->package_id);
	}
		if ( ($package) && $package_id || $existing_package_id) {
			$modulesEnable = json_decode($package->params,true);
		}
	 }

    $this->setTitle('Post New Job')
      ->setDescription('Post your new job below, then click "Post Job" to publish the entry to your job.')
      ->setAttrib('name', 'sesjobs_create');

		if($this->getSmoothboxType())
			$this->setAttrib('class','global_form sesjob_smoothbox_create');

    $user = Engine_Api::_()->user()->getViewer();
    $user_level = Engine_Api::_()->user()->getViewer()->level_id;

    if (Engine_Api::_()->core()->hasSubject('sesjob_job'))
    $job = Engine_Api::_()->core()->getSubject();

    if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.company', 1)) {
    $this->addElement('Dummy', 'companydetails', array(
      'label' => 'Company Information',
    ));


    $companies = Engine_Api::_()->getDbTable('companies', 'sesjob')->getCompaniesAssoc(array('user_id' => $user->getIdentity()));
    if(count($companies) > 0) {
        $companies = array('0' => 'Create New Company') + $companies;
        $this->addElement('Select', 'company_id', array(
            'label' => 'Choose Company',
            'multiOptions' => $companies,
            'allowEmpty' => false,
            'required' => true,
            'onchange' => 'choosecompany(this.value);',
        ));
    }


    $this->addElement('Text', 'company_name', array(
      'label' => 'Company Name',
      'allowEmpty' => false,
      'required' => true,
    ));

    $this->addElement('Text', 'company_websiteurl', array(
      'label' => 'Company Website URL',
      'allowEmpty' => false,
      'required' => true,
    ));

    $this->addElement('Textarea', 'company_description', array(
      'label' => 'Company Description',
      'allowEmpty' => false,
      'required' => true,
    ));

    $industries = Engine_Api::_()->getDbTable('industries', 'sesjob')->getIndustriesAssoc();
    if(count($industries) > 0) {
        $industries = array('' => '') + $industries;
        $this->addElement('Select', 'industry_id', array(
            'label' => 'Industry',
            'multiOptions' => $industries,
            'allowEmpty' => false,
            'required' => true,
        ));
    }

    }

    $this->addElement('Dummy', 'jobgeneralinformation', array(
      'label' => 'Job Information',
    ));

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

    $custom_url_value = isset($job->custom_url) ? $job->custom_url : (isset($_POST["custom_url"]) ? $_POST["custom_url"] : "");
    // Custom Url
    $this->addElement('Dummy', 'custom_url_job', array(
	'label' => 'Custom Url',
	'content' => '<input type="text" name="custom_url" id="custom_url" value="' . $custom_url_value . '"><i class="fa fa-check" id="sesjob_custom_url_correct" style="display:none;"></i><i class="fa fa-close" id="sesjob_custom_url_wrong" style="display:none;"></i><span class="sesjob_check_availability_btn"><img src="application/modules/Core/externals/images/loading.gif" id="sesjob_custom_url_loading" alt="Loading" style="display:none;" /><button id="check_custom_url_availability" type="button" name="check_availability" >Check Availability</button></span> <p id="suggestion_tooltip" class="check_tooltip" style="display:none;">'.$translate->translate("You can use letters, numbers and periods.").'</p>',
    ));

    // init to
    $this->addElement('Text', 'tags', array(
        'label' => 'Skills (Keywords)',
        'autocomplete' => 'off',
        'description' => 'Separate skills with commas.',
        'filters' => array(
            new Engine_Filter_Censor(),
        )
    ));
    $this->tags->getDecorator("Description")->setOption("placement", "append");

    if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.start.date', 1))  {

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
					$startTime = time()+strtotime($selectedTime);
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
			$this->addElement('dummy', 'job_custom_datetimes', array(
				'decorators' => array(array('ViewScript', array(
										'viewScript' => 'application/modules/Sesjob/views/scripts/_customdates.tpl',
										'class' => 'form element',
										'start_date'=>$start_date,
										'start_time'=>$start_time,
										'start_time_check'=>1,
										'subject'=>isset($job) ? $job : '',
								)))
			));
    }
    if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob_enable_location', 1) && ((isset($modulesEnable) && array_key_exists('enable_location',$modulesEnable) && $modulesEnable['enable_location']) || empty($modulesEnable))) {
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
    $categories = Engine_Api::_()->getDbtable('categories', 'sesjob')->getCategoriesAssoc(array('member_levels' => 1));
    if( count($categories) > 0 ) {
		$categorieEnable = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.category.enable', '1');
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
      $customFields = new Sesjob_Form_Custom_Fields(array(
          'item' => 'sesjob_job',
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

		$mainPhotoEnable = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.photo.mandatory', '1');
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
//    if(((isset($modulesEnable) && array_key_exists('modules',$modulesEnable) && in_array('photo',$modulesEnable['modules'])) || empty($modulesEnable)) && $photoLeft){
// 		 	if(isset($modulesEnable) && array_key_exists('photo_count',$modulesEnable) && $modulesEnable['photo_count']){
// 				if(isset($photoLeft))
// 					$photo_count = $photoLeft;
// 				else
// 					$photo_count = $modulesEnable['photo_count'];
// 	 			$this->addElement('hidden', 'photo_count', array('value' => $photo_count,'order'=>8769));
// 	 		}
//
//
// 			$this->addElement('Dummy', 'fancyuploadfileids', array('content'=>'<input id="fancyuploadfileids" name="file" type="hidden" value="" >'));
//
// 			$this->addElement('Dummy', 'tabs_form_jobcreate', array(
// 			'label' => 'Upload photos',
// 			//'required'=>$required,
// 			//'allowEmpty'=>$allowEmpty,
// 			'content' => '<div class="sesjob_create_form_tabs sesbasic_clearfix sesbm"><ul id="sesjob_create_form_tabs" class="sesbasic_clearfix"><li class="active sesbm"><i class="fa fa-arrows sesbasic_text_light"></i><a href="javascript:;" class="drag_drop">'.$translate->translate('Drag & Drop').'</a></li><li class=" sesbm"><i class="fa fa-upload sesbasic_text_light"></i><a href="javascript:;" class="multi_upload">'.$translate->translate('Multi Upload').'</a></li><li class=" sesbm"><i class="fa fa-link sesbasic_text_light"></i><a href="javascript:;" class="from_url">'.$translate->translate('From URL').'</a></li></ul></div>',
// 			));
// 			$this->addElement('Dummy', 'drag-drop', array(
// 			'content' => '<div id="dragandrophandler" class="sesjob_upload_dragdrop_content sesbasic_bxs">'.$translate->translate('Drag & Drop Photos Here').'</div>',
// 			));
// // 			$this->addElement('Dummy', 'from-url', array(
// // 			'content' => '<div id="from-url" class="sesjob_upload_url_content sesbm"><input type="text" name="from_url" id="from_url_upload" value="" placeholder="'.$translate->translate('Enter Image URL to upload').'"><span id="loading_image"></span><span></span><button id="upload_from_url">'.$translate->translate('Upload').'</button></div>',
// // 			));
//
// 			//$this->addElement('Dummy', 'file_multi', array('content'=>'<input type="file" accept="image/x-png,image/jpeg" onchange="readImageUrl(this)" multiple="multiple" id="file_multi" name="file_multi">'));
//
// 			$this->addElement('Dummy', 'uploadFileContainer', array('content'=>'<div id="show_photo_container" class="sesjob_upload_photos_container sesbasic_bxs sesbasic_custom_scroll clear"><div id="show_photo"></div></div>'));
//   }else{
		//make main photo upload btn
		$this->addElement('File', 'photo_file', array(
			'label' => 'Main Photo',
			'required'=>$required,
			'allowEmpty'=>$allowEmpty,
		));
		$this->photo_file->addValidator('Extension', false, 'jpg,png,gif,jpeg');
	//}

    $allowed_html = Engine_Api::_()->authorization()->getPermission($user_level, 'sesjob_job', 'auth_html');
    $upload_url = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sesbasic', 'controller' => 'index', 'action' => "upload-image"), 'default', true);
    $editorOptions = array(
       'upload_url' => $upload_url,
       'html' => true,
       'extended_valid_elements'=>$allowed_html,
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

    $this->addElement('Textarea', 'description', array(
      'label' => 'Short Description',
      'allowEmpty' => false,
      'required' => true,
      'filters' => array(
        new Engine_Filter_Censor(),
        'StripTags',
        new Engine_Filter_StringLength(array('max' => '224'))
      ),
    ));

		if((isset($modulesEnable) && array_key_exists('enable_tinymce',$modulesEnable) && $modulesEnable['enable_tinymce']) || empty($modulesEnable)) {
				$textarea = 'TinyMce';
		}else
			$textarea = 'Textarea';


		$descriptionMan= Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.description.mandatory', '1');
		if ($descriptionMan == 1) {
			$required = true;
			$allowEmpty = false;
		} else {
			$required = false;
			$allowEmpty = true;
		}

    $this->addElement($textarea, 'body', array(
      'label' => 'Job Description',
      'required' => $required,
      'allowEmpty' => $allowEmpty,
      'class'=>'tinymce',
      'editorOptions' => $editorOptions,
    ));

    if (Engine_Api::_()->authorization()->isAllowed('sesjob_job', $viewer, 'allow_levels')) {

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
            'description' => 'Choose the Member Levels to which this Job will be displayed. (Note: Hold down the CTRL key to select or de-select specific member levels.)',
            'value' => $levelValues,
        ));
    }

    if (Engine_Api::_()->authorization()->isAllowed('sesjob_job', $viewer, 'allow_network')) {
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


    $this->addElement('Hidden', 'jobstyle', array(
    'value' => 1,
    ));

    //Job Information
    $this->addElement('Dummy', 'jobdetails', array(
      'label' => 'Job Details',
    ));

    $this->addElement('Text', 'salary', array(
        'label' => 'Salary',
        'description' => 'Enter salary that you want to pay.',
        //'required' => true,
        //'allowEmpty' => false,
    ));

    $this->addElement('Text', 'otherpay', array(
        'label' => 'Other Pays',
        //'required' => true,
        //'allowEmpty' => false,
    ));

    $this->addElement('Text', 'experience', array(
        'label' => 'Required Experience',
        //'required' => true,
        //'allowEmpty' => false,
    ));

//     $this->addElement('Text', 'reference_code', array(
//         'label' => 'Reference Code',
//         'description' => "Enter reference code/id for this job",
//         //'required' => true,
//         //'allowEmpty' => false,
//     ));

    $employments = Engine_Api::_()->getDbTable('employments', 'sesjob')->getEmploymentsAssoc();
    if(count($employments) > 0) {
        $employments = array('' => '') + $employments;
        $this->addElement('Select', 'employment_id', array(
            'label' => 'Employment Type',
            'required' => true,
            'allowEmpty' => false,
            'multiOptions' => $employments,
        ));
    }

    $educations = Engine_Api::_()->getDbTable('educations', 'sesjob')->getEducationsAssoc();
    if(count($educations) > 0) {
        $this->addElement('MultiCheckbox', 'education_id', array(
            'label' => 'Education Level',
            //'required' => true,
            //'allowEmpty' => false,
            'multiOptions' => $educations,
        ));
    }

//     $this->addElement('Radio', 'manage_others', array(
//         'label' => 'Manage Others',
//         //'required' => true,
//         //'allowEmpty' => false,
//         'multiOptions' => array('1' => 'Yes', '0' => 'No'),
//         'value' => '0',
//     ));

    //Contact Information
    $this->addElement('Dummy', 'contactdetails', array(
      'label' => 'Contact Information',
    ));

    // Name
    $this->addElement('Text', 'job_contact_name', array(
      'label' => 'Name',
      'allowEmpty' => false,
      'required' => true,
    ));
    // Email
    $this->addElement('Text', 'job_contact_email', array(
      'label' => 'Email',
      'allowEmpty' => false,
      'required' => true,
    ));
    // Phone
    $this->addElement('Text', 'job_contact_phone', array(
      'label' => 'Phone',
    ));
    // Facebook
    $this->addElement('Text', 'job_contact_facebook', array(
      'label' => 'Facebook',
    ));
    // Website
    $this->addElement('Text', 'job_contact_website', array(
      'label' => 'Website',
    ));
    // Website
    $this->addElement('Hidden', 'conatct_user_id', array(
      'order' => '888888',
    ));


    $this->addElement('Checkbox', 'search', array(
      'label' => 'Show this job entry in search results',
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
    $viewOptions = (array) Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('sesjob_job', $user, 'auth_view');
    $viewOptions = array_intersect_key($availableLabels, array_flip($viewOptions));

    if( !empty($viewOptions) && count($viewOptions) >= 1 ) {
      // Make a hidden field
      if(count($viewOptions) == 1) {
        $this->addElement('hidden', 'auth_view', array('value' => key($viewOptions)));
      // Make select box
      } else {
        $this->addElement('Select', 'auth_view', array(
            'label' => 'Privacy',
            'description' => 'Who may see this job entry?',
            'multiOptions' => $viewOptions,
            'value' => key($viewOptions),
            'class'=>$hideClass,
        ));
        $this->auth_view->getDecorator('Description')->setOption('placement', 'append');
      }
    }

    // Element: auth_comment
    $commentOptions = (array) Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('sesjob_job', $user, 'auth_comment');
    $commentOptions = array_intersect_key($availableLabels, array_flip($commentOptions));

    if( !empty($commentOptions) && count($commentOptions) >= 1 ) {
      // Make a hidden field
      if(count($commentOptions) == 1) {
        $this->addElement('hidden', 'auth_comment', array('value' => key($commentOptions)));
      // Make select box
      } else {
        $this->addElement('Select', 'auth_comment', array(
            'label' => 'Comment Privacy',
            'description' => 'Who may post comments on this job entry?',
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
        'label' => 'Post Job',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array(
            'ViewHelper',
        ),
    ));

    if($this->getSmoothboxType()) {
			$this->addElement('Cancel', 'advanced_sesjoboptions', array(
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
