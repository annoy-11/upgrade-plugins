<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespopupbuilder
 * @package    Sespopupbuilder
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Create.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespopupbuilder_Form_Create extends Engine_Form {

  public function init() {
		$request = Zend_Controller_Front::getInstance()->getRequest();
		$popupId = $request->getParam('popup_id', null);
		if($popupId)
		 $popup = Engine_Api::_()->getItem('sespopupbuilder_popup', $popupId);
		else
			$popup = '';
		$popuptype = $request->type ? $request->type : $popup->popup_type;

		$order = 1;
    $settings = Engine_Api::_()->getApi('settings', 'core');

    $this->setTitle('Create New Popup')
            ->setDescription('Fill the form below to create new Popup for your website. If you want to change the type of the popup, then go back to manage popups.');
		$this->addElement('text', 'title', array(
          'label' => 'Popup Title',
          'placeholder' => 'Enter the title',
          'allowEmpty' => false,
          'required' => true,
          'description' => 'Enter the title for this popup which you want to show in this Popup.',
		));
		$this->addElement('hidden','popup_type',array(
			'value'=> $popuptype,
			'order'=>$order++
		));
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
						'undo', 'redo','format', 'pastetext', '|', 'code',
						'media', 'image', 'jbimages', 'link', 'fullscreen',
						'preview'
				);
			}
			
		if($popuptype == 'image'){
			$imagerequire = false;
			$imageempty = true;
			
			if(!empty($popup) && isset($_POST['remove_main_image']) && $_POST['remove_main_image']){
				$imagerequire = true;
				$imageempty = false;
			}elseif(empty($popup)){
				$imagerequire = true;
				$imageempty = false;
			}
				$this->addElement('file', 'photo', array(
          'label' => 'Choose Photo',
          'allowEmpty' => $imageempty,
          'required' => $imagerequire,
          'description' => 'Upload the photo which you want to show in this Popup.',
			));
			$this->photo->addValidator('Extension', false, 'jpg,png,gif,jpeg');
			if(!empty($popup) && $popup->image){
				$image = Engine_Api::_()->storage()->get($popup->image, '')->getPhotoUrl();
				if($image){
					$this->addElement('Dummy', 'editdummy_1', array(
						'content' => '<img src="'.$image.'" alt="Background_image" height="100" width="100">',
					));
				}
			}
		}elseif($popuptype == 'html' && $request->action == 'create-popup'){
			$this->addElement('TinyMce', 'html', array(
				'label' => 'HTML',
				'description' => 'Enter the HTML content which you want to show in this popup.',
				'allowEmpty' => false,
				'required' => true,
				'class' => 'tinymce',
				'editorOptions' => $editorOptions,
			));
		}elseif($popuptype == 'video'){
			$this->addElement('text', 'video_url', array(
				'label' => 'Youtube Video URL',
				'allowEmpty' => false,
				'required' => true,
				'onchange' =>'checkyoutubevideo(this.value);',
				'description' => 'Enter the URL of the Youtube Video which you want to show in this Popup.',
			));
			$this->addElement('dummy', 'checking', array(
						'description' => 'Checking Url....',
						'maxlength' => '150',
            'allowEmpty' => true,
            'required' => false,
			));
			$this->addElement('hidden', 'is_video_found', array(
				'value' => '1',
				'order' => $order++
			));
			$this->getElement('checking')->getDecorator('description')->setOption('style', 'display: none');
		}elseif($popuptype == 'iframe'){
			$this->addElement('Textarea', 'iframe_url', array(
				'label' => 'iframe Code',
				'allowEmpty' => false,
				'required' => true,
				'description' => 'Enter the iframe code which you want to show in this popup. (Include the iframe tag in your code.)',
			));
		}elseif($popuptype == 'facebook_like'){
			 $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
			 $here = '<a href="https://developers.facebook.com/docs/plugins/page-plugin/" target="_blank">here</a>';
			 $descriptionfb = sprintf('Enter the code of the Facebook Page Plugin which you want to show in this popup. Get code from %s.',$here);
			
			$this->addElement('Textarea', 'facebook_url', array(
				'label' => 'Facebook Page Plugin',
				'allowEmpty' => false,
				'required' => true,
				'description' => $descriptionfb,
			));
			 $this->getElement('facebook_url')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
		}elseif($popuptype == 'pdf'){
			$pdfAllowEmpty = false;
			$pdfRequired = true;
			if(!empty($popup) && $popup->pdf_file){
				$pdfAllowEmpty = true;
				$pdfRequired = false;
			}
			$this->addElement('file', 'pdf_file', array(
				'label' => 'Choose PDF',
				'allowEmpty' => $pdfAllowEmpty,
				'required' => $pdfRequired,
				'description' => 'Upload the PDF which you want to show in this Popup.',
			));
			$this->pdf_file->addValidator('Extension', false, 'pdf');
			if(isset($popup->pdf_file) && !empty($popup)){
				$pdf = Engine_Api::_()->storage()->get($popup->pdf_file, "")->map();;
				if($pdf){
					$this->addElement('Dummy', 'editdummy_4', array(
						'content' => '<embed type="application/pdf" src="'.$pdf.'" alt="pdf_file" height="100" width="100">',
					));
				}
			}
		}elseif($popuptype == 'age_verification'){
			/*$this->addElement('text', 'age_verification', array(
				'label' => 'Age',
				'allowEmpty' => false,
				'required' => true,
				'placeholder' => 'Enter age in integer',
				'description' => 'Enter the age which you want to verify in this popup. (The popup is simple and will not save any entry.)',
				'validators' => array(
					array('Int', true),
				),
			));*/
			$this->addElement('text', 'text_verifiaction', array(
				'label' => 'Verification Text',
				'placeholder' => 'Enter the text',
				'allowEmpty' => false,
				'required' => true,
				'description' => 'Enter the text for verification which you want to show in this Popup.',
			));
			$this->addElement('Select', 'is_button_text', array(
				'label' => 'Change Button Text',
				'multiOptions'=>array(
					'1'=>'Yes',
					'0'=>'No',
				),
				'allowEmpty' => false,
				'required' => true,
				'onchange'=>'buttonverfication(this.value)',
				'description' => 'Do you want to change the default buttons texts which are "Yes" and "No". If you choose Yes, then you can enter the text for buttons.',
				'value'=>'0'
			));

			$allowEmpty = false;
			$required = true;
			if($_POST['is_button_text'] != '1'){
				$allowEmpty = true;
				$required = false;
			}
			$this->addElement('text', 'first_button_verifiaction', array(
				'label' => 'Button Text for Confirmation',
				'placeholder' => 'Enter button text',
				'allowEmpty' => $allowEmpty,
				'required' => $required,
				'description' => 'Enter the button text which will be shown when users Confirm (Yes) their age.',
			));

			$this->addElement('text', 'second_button_verifiaction', array(
				'label' => 'Button Text for Deny',
				'placeholder' => 'Enter button text',
				'allowEmpty' => $allowEmpty,
				'required' => $required,
				'description' => 'Enter the button text which will be shown when users Deny (No) their age.',
			));
		}elseif($popuptype == 'notification_bar'){
			$this->addElement('text', 'notification_text', array(
				'label' => 'Notification Promo Text',
				'allowEmpty' => false,
				'required' => true,
				'description' => 'Enter the text which you want to show in the notification promo bar.',
			));
			$this->addElement('text', 'notification_font_color', array(
				'label' => 'Enter the Promo Text font Color',
				'allowEmpty' => false,
				'required' => true,
				'description' => 'Enter the Promo Text font Color.',
				'class' => 'SEScolor',
			));
			$this->addElement('text', 'notification_button_label', array(
				'label' => 'CTA Button Text',
				'allowEmpty' => true,
				'required' => false,
				'description' => 'Enter a text for your CTA, call to action button. If you do not want to show button, then simply leave the field empty.',
			));
			$this->addElement('text', 'notification_button_link', array(
				'label' => 'CTA Button Link',
				'allowEmpty' => true,
				'required' => false,
				'description' => 'Enter a link for your CTA, call to action button. If you do not want to show button, then simply leave the field empty.',
			));
			$this->addElement('Select', 'notification_button_target', array(
				'label' => 'CTA Button Target Window',
				'multiOptions'=>array(
					'1'=>'Open in New tab',
					'0'=>'Open in Same Tab',
				),
				'allowEmpty' => true,
				'required' => false,
				'value' => '1',
				'description' => 'Do you want to open the link in new window when users click on CTA button? Choose the option.',
			));
		}elseif($popuptype == 'christmas'){
			$this->addElement('TinyMce', 'christmas_description', array(
					'label' => 'Greeting Message',
					'description' => 'Enter the greeting message which will be shown in this popup.',
					'allowEmpty' => false,
					'required' => true,
					'class' => 'tinymce',
					'editorOptions' => $editorOptions,
			));
			$this->addElement('Select', 'christmas_image1_check', array(
				'label' => 'Image 1',
				'allowEmpty' => false,
				'required' => true,
				'onchange' => 'chrismisimage1(this.value);',
				'multiOptions'=>array(
					'1'=>'Upload new photo',
					'0'=>'Choose from pre-loaded photos',
				),
				'value'=>'0',
				'description' => 'Do you want to upload image 1 or choose from pre-loaded photos to be shown in this Popup?',
			));

			$allowEmpty1 = false;
			$required1 = true;
			$allowEmpty1select = true;
			$required1select = false;
			if($_POST['christmas_image1_check'] != '1' || !empty($popup)){
				$allowEmpty1 = true;
				$required1 = false;
				$allowEmpty1select = true;
				$required1select = false;
			}
			$this->addElement('file', 'christmas_image1_upload', array(
				'label' => 'Choose New Photo',
				'allowEmpty' => $allowEmpty1,
				'required' => $required1,
				'description' => 'Choose and upload new photo which will be displayed in place of image 1 in this popup.',
			));
			if(isset($popup->christmas_image1_upload) && !empty($popup) && $popup->christmas_image1_check == '1'){
				
				$christmasImage1Upload = Engine_Api::_()->storage()->get($popup->christmas_image1_upload, '');
				
				if($christmasImage1Upload){
					$christmasImage1Upload = $christmasImage1Upload->getPhotoUrl();
					if($christmasImage1Upload){
						$this->addElement('Dummy', 'editdummy_5', array(
							'content' => '<img src="'.$christmasImage1Upload.'" alt="Chirstmas_image_one" height="100" width="100">',
						));
					}
				}
			}
			
			$imageoneoptions = array();
			$imageoneoptions['christmas1.png'] = '<span class="christmas_img"><img src="./application/modules/Sespopupbuilder/externals/images/christmas1.png" alt="" /></span>';
			$imageoneoptions['christmas2.png'] = '<span class="christmas_img"><img src="./application/modules/Sespopupbuilder/externals/images/christmas2.png" alt="" /></span>';
			$imageoneoptions['christmas3.png'] = '<span class="christmas_img"><img src="./application/modules/Sespopupbuilder/externals/images/christmas3.png" alt="" /></span>';
			$imageoneoptions['christmas4.png'] = '<span class="christmas_img"><img src="./application/modules/Sespopupbuilder/externals/images/christmas4.png" alt="" /></span>';
			$imageoneoptions['christmas5.png'] = '<span class="christmas_img"><img src="./application/modules/Sespopupbuilder/externals/images/christmas5.png" alt="" /></span>';
			$imageoneoptions['christmashny1.png'] = '<span class="christmas_img"><img src="./application/modules/Sespopupbuilder/externals/images/christmashny1.png" alt="" /></span>';
			$imageoneoptions['christmashny2.png'] = '<span class="christmas_img"><img src="./application/modules/Sespopupbuilder/externals/images/christmashny2.png" alt="" /></span>';
			$imageoneoptions['christmashny3.png'] = '<span class="christmas_img"><img src="./application/modules/Sespopupbuilder/externals/images/christmashny3.png" alt="" /></span>';
			$imageoneoptions['happyny1.png'] = '<span class="christmas_img"><img src="./application/modules/Sespopupbuilder/externals/images/happyny1.png" alt="" /></span>';
			$imageoneoptions['happyny2.png'] = '<span class="christmas_img"><img src="./application/modules/Sespopupbuilder/externals/images/happyny2.png" alt="" /></span>';
			$imageoneoptions['happyny3.png'] = '<span class="christmas_img"><img src="./application/modules/Sespopupbuilder/externals/images/happyny3.png" alt="" /></span>';
			$imageoneoptions['happyny4.png'] = '<span class="christmas_img"><img src="./application/modules/Sespopupbuilder/externals/images/happyny4.png" alt="" /></span>';
			$this->addElement('Radio', 'christmas_image1_select', array(
				'label' => 'Pre-Loaded Images',
				'allowEmpty' => $allowEmpty1select,
				'required' => $required1select,
				'description' => 'Select from the below pre-loaded images to be shown in place of image 1 in this popup.',
				'multiOptions'=>$imageoneoptions,
				'value'=>'thought.jpg',
				'escape' => false,
			));
			
			$this->addElement('Select', 'christmas_image2_check', array(
				'label' => 'Image 2',
				'allowEmpty' => false,
				'required' => true,
				'onchange' => 'chrismisimage2(this.value);',
				'multiOptions'=>array(
					'1'=>'Upload New Photo',
					'0'=>'Choose from pre-loaded photos',
				),
				'description' => 'Do you want to upload image 2 or choose from pre-loaded photos to be shown in this Popup?',
				'value'=>'0',
			));

			$allowEmpty2 = false;
			$required2 = true;
			$allowEmpty2select = true;
			$required2select = false;
			if($_POST['christmas_image2_check'] != '1'){
				$allowEmpty2 = true;
				$required2 = false;
				$allowEmpty2select = true;
				$required2select = false;
			}
			if($_POST['christmas_image2_check'] == '1' && isset($popup->christmas_image2_upload) && $popup->christmas_image2_upload) {
				$allowEmpty2 = true;
				$required2 = false;
			}
			$this->addElement('file', 'christmas_image2_upload', array(
				'label' => 'Choose New Photo',
				'allowEmpty' => $allowEmpty2,
				'required' => $required2,
				'description' => 'Choose and upload new photo which will be displayed in place of image 2 in this popup.',
			));
			if(isset($popup->christmas_image2_upload) && !empty($popup) && $popup->christmas_image2_check == '1'){
				
				$christmasImage2Upload = Engine_Api::_()->storage()->get($popup->christmas_image2_upload, '');
				if($christmasImage2Upload){
					$christmasImage2Upload = $christmasImage2Upload->getPhotoUrl();
				if($christmasImage2Upload){
					$this->addElement('Dummy', 'editdummy2_5', array(
						'content' => '<img src="'.$christmasImage2Upload.'" alt="Chirstmas_image_two" height="100" width="100">',
					));
				}
				
				}
			}
		
			$imagetwooptions = array();
			$imagetwooptions['santa-1.png'] = '<span class="_santa_img"><img src="./application/modules/Sespopupbuilder/externals/images/santa-1.png" alt="" /></span>';
			$imagetwooptions['santa-2.png'] = '<span class="_santa_img"><img src="./application/modules/Sespopupbuilder/externals/images/santa-2.png" alt="" /></span>';
			$imagetwooptions['santa-3.png'] = '<span class="_santa_img"><img src="./application/modules/Sespopupbuilder/externals/images/santa-3.png" alt="" /></span>';
			$imagetwooptions['santa-4.png'] = '<span class="_santa_img"><img src="./application/modules/Sespopupbuilder/externals/images/santa-4.png" alt="" /></span>';
			$imagetwooptions['santa-5.png'] = '<span class="_santa_img"><img src="./application/modules/Sespopupbuilder/externals/images/santa-5.png" alt="" /></span>';
			$imagetwooptions['santa-6.png'] = '<span class="_santa_img"><img src="./application/modules/Sespopupbuilder/externals/images/santa-6.png" alt="" /></span>';
			$imagetwooptions['santa-7.png'] = '<span class="_santa_img"><img src="./application/modules/Sespopupbuilder/externals/images/santa-7.png" alt="" /></span>';
			$imagetwooptions['santa-8.png'] = '<span class="_santa_img"><img src="./application/modules/Sespopupbuilder/externals/images/santa-8.png" alt="" /></span>';
			$imagetwooptions['santa-9.png'] = '<span class="_santa_img"><img src="./application/modules/Sespopupbuilder/externals/images/santa-9.png" alt="" /></span>';
			$imagetwooptions['santa-10.png'] = '<span class="_santa_img"><img src="./application/modules/Sespopupbuilder/externals/images/santa-10.png" alt="" /></span>';
			$imagetwooptions['santa-11.png'] = '<span class="_santa_img"><img src="./application/modules/Sespopupbuilder/externals/images/santa-11.png" alt="" /></span>';
			$imagetwooptions['santa-12.png'] = '<span class="_santa_img"><img src="./application/modules/Sespopupbuilder/externals/images/santa-12.png" alt="" /></span>';
			$imagetwooptions['santa-13.png'] = '<span class="_santa_img"><img src="./application/modules/Sespopupbuilder/externals/images/santa-13.png" alt="" /></span>';
			$imagetwooptions['santa-14.png'] = '<span class="_santa_img"><img src="./application/modules/Sespopupbuilder/externals/images/santa-14.png" alt="" /></span>';
			$imagetwooptions['santa-15.png'] = '<span class="_santa_img"><img src="./application/modules/Sespopupbuilder/externals/images/santa-15.png" alt="" /></span>';
			$this->addElement('Radio', 'christmas_image2_select', array(
				'label' => 'Pre-Loaded Images',
				'allowEmpty' => $allowEmpty1select,
				'required' => $required1select,
				'description' => 'Select from the below pre-loaded images to be shown in place of image 2 in this popup.',
				'multiOptions'=>$imagetwooptions,
				'value'=>'santa-1.png',
				'escape' => false,
			));
		}elseif($popuptype == 'count_down'){
			$this->addElement('TinyMce', 'coundown_description', array(
				'label' => 'Enter Description',
				'allowEmpty' => false,
				'required' => true,
				'description' => 'Enter Countdown description which you want to show in popup.',
				'class' => 'tinymce',
				'editorOptions' => $editorOptions,
			));
			// End time
			$end = new Engine_Form_Element_CalendarDateTime('countdown_endtime');
			$end->setLabel("End Time");
			$end->setAllowEmpty(false);
			$end->setRequired(true);  
			$this->addElement($end);		
		}elseif($popuptype == 'cookie_consent' && $request->action == 'create-popup'){
			$this->addElement('TinyMce', 'cookies_description', array(
					'label' => 'Cookies Consent Description',
					'description' => 'Enter the description which will be displayed for Cookie consent in this popup.',
					'allowEmpty' => false,
					'required' => true,
					'class' => 'tinymce',
					'editorOptions' => $editorOptions,
			));
			$this->addElement('Select', 'cookies_button', array(
					'label' => 'Change CTA Button Text',
					'allowEmpty' => false,
					'required' => true,
					'description' => 'Do you want to change the default buttons texts which are "Yes" and "No". If you choose Yes, then you can enter the text for buttons. If you choose No, then "Ok" will be shown.',
					'onchange' => 'cookieconfirmation(this.value);',
					'multiOptions' => array(
						'1' => 'Yes',
						'0' => 'No',
					),
					'value'=>'0',
			));

			$allowEmpty = false;
			$required = true;
			if($_POST['cookies_button'] != '1'){
				$allowEmpty = true;
				$required = false;
			}
			$this->addElement('text', 'cookies_button_title', array(
					'label' => 'Cookies CTA Button Text',
					'description' => 'Enter the text of the CTA button which will be shown in this cookie popup.',
					'allowEmpty' => $allowEmpty,
					'required' => $required,
					'placeholder'=>'Enter the text.',
			));
		}
    $levelOptions = array();

    foreach( Engine_Api::_()->getDbtable('levels', 'authorization')->fetchAll() as $level ) {
      $levelOptions[$level->level_id] = $level->getTitle();
    }
		$defaultLevelOptions = array_keys($levelOptions);
		

    // Element: level_id
    $this->addElement('Multiselect', 'level_id', array(
      'label' => 'Member Level',
      'multiOptions' => $levelOptions,
			'value'=>$defaultLevelOptions,
	  'description' => 'Choose the Member Levels to which this popup will be displayed.'
    ));
		$this->addElement('Multiselect', 'devices', array(
			'label' => 'Device Types',
			'multiOptions' => array(
			'0'=> 'All',
			'1'=> 'Desktop',
			'2'=> 'Mobile',
			'3'=> 'Tablet',
			'4'=> 'IPad',
			),
			'description' => 'Choose the device types in which this popup will be displayed.',
			'value' => 0,
		));
		
		/* Location Elements */
		$locale = Zend_Registry::get('Zend_Translate')->getLocale();
		$territories = Zend_Locale::getTranslationList('territory', $locale, 2);
		asort($territories);
		$countrySelect = array();
		$countrySelected = '';
		if (count($territories)) {
			$countrySelect['choose_contry'] = 'Choose Country';
			$countrySelect['all'] = 'All';
			if (isset($popup) && !empty($popup)) {
				$itemlocation = Engine_Api::_()->getDbTable('locations', 'sesbasic')->getLocationData('popupbuilders', $popup->getIdentity());
				if ($itemlocation)
					$countrySelected = $itemlocation->geo_location;
			}
			foreach ($territories as $key => $valCon) {
				$appendCountrySelect[$key] = $valCon;
			}
		}
		if(count($appendCountrySelect)){
			$countries = array_merge($countrySelect,$appendCountrySelect);
		}
		if(!empty($popup)){
			$db = Engine_Db_Table::getDefaultAdapter();
			$query = $db->query('Select * from engine4_sespopupbuilder_countries where popup_id='.$popupId);
			$querydata = $query->fetchAll();
			$countryCount = 0;
			$cnt = array();
			foreach($querydata as $query){
				array_push($cnt,$query['country_title']);
			}
		}

		$this->addElement('Multiselect', 'geo_location', array(
			'label' => 'Countries',
			'multiOptions' => $countries,
			'description' => 'Choose Countries in which you want to show this popup.',
			'value' => !empty($popup) ? $cnt : 'all' ,
		));
		
		// Element: auth_view
		/*$this->addElement('Select', 'auth_view', array(
			'label' => 'View Privacy',
			'description' => 'Select the networks',
			'multiOptions' => array(
				'everyone'            => 'Everyone',
				'registered'          => 'All Registered Members',
				'owner_network'       => 'Friends and Networks',
				'owner_member_member' => 'Friends of Friends',
				'owner_member'        => 'Friends Only',
				'owner'               => 'Just Me'
			),
			'value' => array('everyone','registered', 'owner_network', 'owner_member_member', 'owner_member', 'owner'),
		));*/

		$networkOptions = array();
    $networkValues = array();
    foreach (Engine_Api::_()->getDbtable('networks', 'network')->fetchAll() as $network) {
      $networkOptions[$network->network_id] = $network->getTitle();
      $networkValues[] = $network->network_id;
    }

    // Select Networks
    $this->addElement('Multiselect', 'networks', array(
        'label' => 'Networks',
        'multiOptions' => $networkOptions,
        'description' => 'Choose the Networks to which this popup will be displayed.',
        'value' => $networkValues,
    ));
		
		// Element: profile_type
    $topStructure = Engine_Api::_()->fields()->getFieldStructureTop('user');
    if( count($topStructure) == 1 && $topStructure[0]->getChild()->type == 'profile_type' ) {
      $profileTypeField = $topStructure[0]->getChild();
      $options = $profileTypeField->getOptions();
      if( count($options) > 1 ) {
        $options = $profileTypeField->getElementParams('user');
        unset($options['options']['order']);
        unset($options['options']['multiOptions']['0']);
        $this->addElement('Multiselect', 'profile_type', array_merge($options['options'], array(
              'required' => false,
              'allowEmpty' => true,
              'tabindex' => $tabIndex++,
            )));
      } else if( count($options) == 1 ) {
        $this->addElement('Hidden', 'profile_type', array(
          'value' => $options[0]->option_id,
          'order' => 1001
        ));
      }
    }
		/*--------------------------When to show Popup --------------------*/
		$this->addElement('Dummy', 'dummy', array(
			'content' => '<h2 style="margin: 0px;" class="admin_heading_sm">When to Show / Close Popup Settings</h2>',
		));
		
		$this->addElement('Radio', 'whenshow', array(
			'label' => 'Action for Popup Display',
			'description' => 'Select the action to display this popup.',
			'onchange' => 'whenshowpopup(this.value)',
			'multiOptions' => array(
				'1' => 'When page loads',
				'2' => 'When user click on page',
				'3' => 'When user scroll down the page',
				//'4' => 'When Exit from Site',
				'5' => 'After Inactivity',
				'6' => 'On Specific Pages',
				//'7' => 'After Creating a content',
			),
			'value' => '1',
		));
		$this->addElement('Dummy', 'dummy1', array(
			'content' => '<button type="button" id="whenshow_specific_url" style="margin: 0px;">Enter Specific Page URLs</button>',
		));	
		$this->addElement('text', 'after_inactivity_time', array(
			'description' => 'Enter the time in seconds after which this popup will be shown if current user is inactive.',
			'label'=>'Inactivity Duration',
			'placeholder'=>'Enter time in seconds',
			
		));			
		// Element: auth_view
		$this->addElement('Radio', 'when_close_popup', array(
			'label' => 'Action to Close Popup',
			'description' => 'Select the action to close this popup.',
			'onchange' => 'whenclosepopup(this.value)',
			'multiOptions' => array(
				'1' => 'After user close from close button',
				'2' => 'When user click outside popup',
				'3' => 'After certain time is passed',
				'4' => 'When user press escape (esc) key',
				'5' => 'When user clicks on Popup',
			),
			'value' => '1',
		));	
		$this->addElement('text', 'close_time', array(
			'label'=>'Time Passed',
			'placeholder' => 'Enter time in seconds',
			'description' => 'Enter the time after which this popup will be automatically closed.'
			
		));
		$this->addElement('Select', 'date_display_setting', array(
			'label' => 'Enable Popup Display Duration',
			'description' => 'Do you want to enable display duration for this popup? If you choose Yes, then you can choose the start and end dates for the display.',
			'onchange' => 'datedisplaysetting(this.value)',
			'multiOptions' => array(
				'1' => 'Yes',
				'0' => 'No',
			),
			'value' => '0',
		));	
		// Start time
		$allowEmpty = false;
		$required = true;
		if(isset($_POST['date_display_setting']) && $_POST['date_display_setting'] != '1'){
			$allowEmpty = true;
			$required = false;
		}
    $start = new Engine_Form_Element_CalendarDateTime('starttime');
    $start->setLabel("Start Date & Time");
    $start->setAllowEmpty($allowEmpty);
    $start->setRequired($required);  
		$start->setValue(date('Y-m-d H:i:s'));
    $this->addElement($start);

    // End time
    $end = new Engine_Form_Element_CalendarDateTime('endtime');
    $end->setLabel("End Date & Time");
    $end->setAllowEmpty($allowEmpty);
    $end->setRequired($required);
		$end->setValue(date('Y-m-d H:i:s'));
    $this->addElement($end);		
		
		
		$this->addElement('Radio', "how_long_show", array(
			'label' => "Popup Visibility",
			'description' => 'Choose from below the how long do you want to display this popup to users on your site.',
        'multiOptions' => array(
            'everytime' => 'Every Time',
			'firsttime' => 'Only 1 Time',
        ),
        'value' => 'everytime',
				'onchange' => 'visibilityday(this.value)',
    ));
		$this->addElement('Text', "popup_visibility_duration", array(
			'label' => "Popup Visibility Duration",
			'description' => "How many days after you want to show this popup.if enter \"0\" then every time popup will be show.",
    ));
		
		$this->addElement('Dummy', 'dummy5', array(
			'content' => '<h2  style="margin: 0px;" class="admin_heading_sm">Popup Styling Settings</h2>',
		));	
		$this->addElement('Radio', "background", array(
			'description' => "Choose from below the element which you want to show in the background of this popup.",
			'label' => 'Popup Background Element',
			'onchange' => "backgorundofpopup(this.value)",
			'multiOptions' => array(
				'0' => 'Nothing',
				'1' => 'Image',
				'2' => 'Color',
			),
			'value'=>'0'
    ));
		if(isset($popup->background_photo) && !empty($popup->background_photo)){
			$bgphoto = Engine_Api::_()->storage()->get($popup->background_photo, '');
			
			if($bgphoto){
				$bgphoto=$bgphoto->getPhotoUrl();
				$this->addElement('Dummy', 'editdummy_2', array(
					'content' => '<img src="'.$bgphoto.'" alt="Background_image" height="100" width="100">',
				));
		
			$this->addElement('Checkbox', 'remove_background_photo', array(
				'label' => 'Yes, remove this Image.'
			));
			}
		}
		$this->addElement('file', "background_photo", array(
			'label' => "Background Photo",
			'description' => "Upload a background photo which will be shown in this popup.",
    ));
		$this->addElement('text', "background_color", array(
			'label' => "Background Color",
			'placeholder' => "Select color.",
			'class' => 'SEScolor',
    ));
		$opicity = array();
		for ($x = 0; $x <= 1;) {
			array_push($opicity,$x);
			$x = $x + 0.1;
		} 
		$this->addElement('Select', "backgroundoverlay_opicity", array(
			'description' => 'Select the opacity for the background overlay.',
			'label' => "Popup Overlay Opacity.",
			'placeholder' => "0.1 to 1",
			'multiOptions' => $opicity,
			'value'=>'0'
    ));

		if($popuptype != 'notification_bar'){
 			$this->addElement('Radio', "popup_responsive_mode", array(
				'label' => 'Popup Dimension Type in Desktop',
				'onchange' => "responsivemode(this.value)",
				'multiOptions' => array(
				'1' => 'Fixed Dimension',
				'2' => 'Dimension in Percentage'
				),
				'description' => 'Choose from below the dimension unit type for this popup. This setting will only work when this popup will be viewed in Desktops.',
				'value'=>'1'
		    ));
		 
 		}		
		
		$responsivesizeRequired =false;
		$responsivesizeAllowEmpty =true;
		if(isset($_POST['popup_responsive_mode']) && $popuptype != 'notification_bar' &&  $_POST['popup_responsive_mode']=='2'){
			$responsivesizeRequired =true;
			$responsivesizeAllowEmpty =false;
		}
		if($popuptype != 'notification_bar'){
 			$this->addElement('Select', "responsive_size", array(
				'label' => 'Percentage',
				'required' => $responsivesizeRequired,
				'allowEmpty' => $responsivesizeAllowEmpty,
				'multiOptions'=>array(
					//'0'=>'Auto',
					'1'=>'10%',
					'2'=>'20%',
					'3'=>'30%',
					'4'=>'40%',
					'5'=>'50%',
					'6'=>'60%',
					'7'=>'70%',
					'8'=>'80%',
					'9'=>'90%',
					'10'=>'100%'
				),
				'description' => 'Choose the percentage for the display of this popup.',
				'value'=>'5'
		    ));
		 
		 }
		
		$responsivecustomRequired =false;
		$responsivecustomAllowEmpty =true;
		if(isset($_POST['popup_responsive_mode']) && $_POST['popup_responsive_mode']=='1'){
			$responsivecustomRequired = true;
			$responsivecustomAllowEmpty =false;
		}
		if($popuptype != 'notification_bar'){
	 		$this->addElement('Text', "custom_width", array(
				'required' => $responsivecustomRequired,
				'allowEmpty' => $responsivecustomAllowEmpty,
				'label' => 'Custom Width',
				'description' => 'Enter the custom width for this popup.',
				'value' =>'700',
		   ));
		}
		if($popuptype != 'notification_bar'){
	 		$this->addElement('Text', "custom_height", array(
				'required' => $responsivecustomRequired,
				'allowEmpty' => $responsivecustomAllowEmpty,
				'label' => 'Custom Height',
				'description' => 'Enter the custom height for this popup.',
				'value' =>'500',
	    ));
	 }
		if($popuptype != 'notification_bar'){
	 		$this->addElement('Text', "max_width", array(
				'label' => 'Maximum Width',
				'description'=>'Enter the max widget for this popup. This setting will not be applicable if you have chosen popup "Dimension in Percentage" in above setting.',
				'value' =>'700',
	    ));
	 }
		if($popuptype != 'notification_bar'){ 
	 		$this->addElement('Text', "max_height", array(
				'label' => 'Maximum Height',
				'description'=>'Enter the maximum widget for this popup.',
				'value' =>'500',
	    ));
 		}
		if($popuptype != 'notification_bar'){ 
	 		$this->addElement('Text', "min_width", array(
				'label' => 'Minimum Width',
				'description'=>'Enter the minimum widget for this popup. This setting will not be applicable if you have chosen popup "Dimension in Percentage" in above setting.',
				'value' =>'500',
	    ));
 		}
		if($popuptype != 'notification_bar'){
	 		$this->addElement('Text', "min_height", array(
				'label' => 'Minimum Height',
				'description'=>'Enter the minimum widget for this popup.',
				'value' =>'300',
	    ));
 		}
		
		
		/*--------------popup close butoon ----------------*/
		
			$this->addElement('Dummy', 'dummy6', array(
			'content' => '<h2  style="margin: 0px;" class="admin_heading_sm">Settings for Closing Popup</h2>',
		));	
		
		if($popuptype != 'notification_bar'){
	 		$this->addElement('Radio', "close_button", array(
			'description' => 'Do you want users to close this popup?',
			'label' => 'Enable Closing Popup',
				'onchange' => "closebutton(this.value)",
				'multiOptions' => array(
					'1' => 'Yes',
					'0' => 'No'
				),
				'value'=>'1'
	    ));
		}
		
		
		$closeRequired = false;
		$closeRequiredAllowEmpty = true;
		if( isset($_POST['close_button']) && $_POST['close_button']=='1'){
			$closeRequired = true;
			$closeRequiredAllowEmpty = false;
		}
		if($popuptype != 'notification_bar'){
	 		$this->addElement('text', "close_button_width", array(
				'label' => 'Close Button Width',
				'required' => $closeRequired,
				'allowEmpty' => $closeRequiredAllowEmpty,
				'value' =>'40',
				'description' => 'Enter the width of the close button.',
	    ));
 		}
		if($popuptype != 'notification_bar'){
	 		$this->addElement('text', "close_button_height", array(
				'label' => 'Close Button Height',
				'required' => $closeRequired,
				'allowEmpty' => $closeRequiredAllowEmpty,
				'value' =>'40',
				'description' => 'Enter the height of the close button.',
	    ));
 		}
		if($popuptype != 'notification_bar'){
	 		$this->addElement('Select', "close_button_position", array(
				'label' => 'Close Button Position',
				'required' => $closeRequired,
				'allowEmpty' => $closeRequiredAllowEmpty,
				'multiOptions' => array(
					'1' => 'Top-Right',
					'2' => 'Top-Left',
				),
				'description' => 'Select the position of the close button in this popup.',
	    ));
 		}
		
		
		/*---------popup options --------------*/
		
					$this->addElement('Dummy', 'dummy7', array(
			'content' => '<h2  style="margin: 0px;" class="admin_heading_sm">Popup Animation Settings</h2>',
		));
		
		$this->addElement('Select', "opening_popup_sound", array(
			'description' => 'Do you want to enable the sound when this popup is opened?',
			'label' => 'Enable Popup Opening Sound',
			'onchange' => 'opcitysound(this.value)',
			'multiOptions' => array(
				'1' => 'Yes',
				'0' => 'No',
			),
			'value' => '0',
    ));
		$openingRequired = false;
		$openingAllowEmpty = true;
		if(isset($_POST['opening_popup_sound']) && $_POST['opening_popup_sound']=='1'){
			$openingRequired = true;
			$openingAllowEmpty = false;
		}
		if(isset($_POST['opening_popup_sound']) && $_POST['opening_popup_sound'] == '1' && isset($popup->popup_sound_file) && !empty($popup->popup_sound_file)){
			$openingRequired = false;
			$openingAllowEmpty = true;
		}
		$this->addElement('file', "popup_sound_file", array(
			'label' => 'Upload Popup Opening Sound',
			'required' => $openingRequired,
			'allowEmpty' => $openingAllowEmpty,
    ));
		if(isset($popup->popup_sound_file) && !empty($popup->popup_sound_file)){
			$audio = Engine_Api::_()->storage()->get($popup->popup_sound_file, "")->map(); 
			if($audio){
				$this->addElement('Dummy', 'editdummy_3', array(
					'content' => '<audio controls><source src="'.$audio.'" height="100" width="300"  type="audio/mp3"></audio>',
				));
			}
			$this->addElement('Checkbox', 'remove_popup_sound_file', array(
				'label' => 'Yes, remove this Audio.'
			));
		}
		$this->addElement('Select', "popup_opening_animation", array(
			'description' => 'Do you want to enable the animation for opening and closing this popup?',
			'label' => 'Enable Popup Opening Animation',
			'onchange' => 'openinganimation(this.value)',
			'multiOptions' => array(
				'1' => 'Yes',
				'0' => 'No',
			),
			'value' => '1',
    ));
		
		$openingAnimationRequired = false;
		$openingAnimationAllowEmpty = true;
		if(isset($_POST['popup_opening_animation']) && $_POST['popup_opening_animation']=='1'){
			$openingAnimationRequired = true;
			$openingAnimationAllowEmpty = false;
		}
		$this->addElement('Select', "opening_type_animation", array(
			'label' => 'Popup Animation',
			'required' => $openingRequired,
			'allowEmpty' => $openingAllowEmpty,
			'multiOptions' => array(
			'mfp-zoom-in'=>'Zoom In',
			'mfp-newspaper'=>'Newspaper',
			'mfp-move-horizontal'=>'Horizontal',
			'mfp-move-from-top'=>'From Top',
			'mfp-3d-unfold'=>'3D Unfold',
			'mfp-zoom-out'=>'Zoom Out',
			),
			'value' => 'flip',
			'description'=>'Choose from below the animation for opening and closing this popup.',
    ));
		$speed = array();
		for ($x = 0; $x <= 5;) {
			array_push($speed,$x);
			$x = $x + 0.1;
		} 
		$this->addElement('Select', "opening_speed_animation", array(
			'label' => 'Popup Opening Animation Speed',
			'multiOptions' => $speed,
			'required' => $openingRequired,
			'allowEmpty' => $openingAllowEmpty,
			'value' => '1',
    ));
		
		
		$speed = array();
		for ($x = 0; $x <= 5;) {
			array_push($speed,$x);
			$x = $x + 0.1;
		} 
		$this->addElement('Select', "closing_speed_animation", array(
			'label' => 'Popup Closing Animation Speed',
			'required' => $openingRequired,
			'allowEmpty' => $openingAllowEmpty,
			'multiOptions' => $speed,
			'value' => '1',
    ));
		
		// Buttons
		$this->addElement('Button', 'save', array(
				'label' => 'Save',
				'type' => 'submit',
				'ignore' => true,
				'decorators' => array('ViewHelper')
		));
		$this->addElement('Button', 'submit', array(
				'label' => 'Save & Exit',
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
				'decorators' => array('ViewHelper')
		));
		$this->addDisplayGroup(array('save', 'submit', 'cancel'), 'buttons');

  }

}
