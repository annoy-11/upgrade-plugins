<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Edocument
 * @package    Edocument
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Edit.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Edocument_Form_Edit extends Engine_Form
{
  protected $_defaultProfileId;
  protected $_fromApi;
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

  public function init() {

    if (Engine_Api::_()->core()->hasSubject('edocument'))
        $document = Engine_Api::_()->core()->getSubject();

    $this->setTitle('Edit Document')
        ->setDescription('Edit your document below, then click "Save Changes" to publish the document.')->setAttrib('name', 'edocuments_edit');

    $user = Engine_Api::_()->user()->getViewer();
    $user_level = Engine_Api::_()->user()->getViewer()->level_id;

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

    $this->addElement('Text', 'tags',array(
      'label'=>'Tags (Keywords)',
      'autocomplete' => 'off',
      'description' => 'Separate tags with commas.',
      'filters' => array(
        new Engine_Filter_Censor(),
      ),
    ));
    $this->tags->getDecorator("Description")->setOption("placement", "append");

//     if(Engine_Api::_()->getApi('settings', 'core')->getSetting('edocument.start.date', 1)) {
// 			if(isset($document)){
// 				$start = strtotime($document->publish_date);
// 				$start_date = date('m/d/Y',($start));
// 				$start_time = date('g:ia',($start));
// 				$viewer = Engine_Api::_()->user()->getViewer();
// 				$publishDate = $start_date.' '.$start_time;
// 				if($viewer->timezone){
// 					$start = strtotime($document->publish_date);
// 					$oldTz = date_default_timezone_get();
// 					date_default_timezone_set($viewer->timezone);
// 					$start_date = date('m/d/Y',($start));
//           $start_date_y = date('Y',strtotime($start_date));
//           $start_date_m = date('m',strtotime($start_date));
//           $start_date_d = date('d',strtotime($start_date));
// 					$start_time = date('g:ia',($start));
// 					date_default_timezone_set($oldTz);
// 				}
// 			}
// 			if(isset($document) && $document->publish_date != '' && strtotime($publishDate) > time()){
// 				$this->addElement('dummy', 'document_custom_datetimes', array(
// 						'decorators' => array(array('ViewScript', array(
// 						'viewScript' => 'application/modules/Edocument/views/scripts/_customdates.tpl',
// 						'class' => 'form element',
// 						'start_date'=>$start_date,
// 						'start_time'=>$start_time,
// 						'start_time_check'=>1,
// 						'subject'=> '',
// 				  )))
// 				));
// 			  if($this->getFromApi()){
//           // Start time
//           $start = new Engine_Form_Element_Date('starttime');
//           $start->setLabel("Start Time");
//           if(!empty($start_date_y)){
//             $start_date_cal = array('year'=>$start_date_y,'month'=>$start_date_m,'day'=>$start_date_d);
//             $start->setValue($start_date_cal);
//           }
//           $start->setAllowEmpty(true);
//           $start->setRequired(false);
//           $this->addElement($start);
//         }
//       }
// 		}

    $categories = Engine_Api::_()->getDbtable('categories', 'edocument')->getCategoriesAssoc(array('member_level'=>1));
    if( count($categories) > 0 ) {
        $categorieEnable = Engine_Api::_()->getApi('settings', 'core')->getSetting('edocument.category.enable', '1');
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

        $edocument = Engine_Api::_()->core()->getSubject();
        // General form w/o profile type
        $aliasedFields = $edocument->fields()->getFieldsObjectsByAlias();
        $topLevelId = $topLevelId = 0;
        $topLevelValue = $topLevelValue = null;

        if (isset($aliasedFields['profile_type'])) {
            $aliasedFieldValue = $aliasedFields['profile_type']->getValue($edocument);
            $topLevelId = $aliasedFields['profile_type']->field_id;
            $topLevelValue = ( is_object($aliasedFieldValue) ? $aliasedFieldValue->value : null );
            if (!$topLevelId || !$topLevelValue) {
                $topLevelId = null;
                $topLevelValue = null;
            }
            $topLevelId = $topLevelId;
            $topLevelValue = $topLevelValue;
        }
        // Get category map form data
        $defaultProfileId = "0_0_" . $this->getDefaultProfileId();
        $customFields = new Edocument_Form_Custom_Fields(array(
        'item' => Engine_Api::_()->core()->getSubject(),
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

    $allowed_html = Engine_Api::_()->authorization()->getPermission($user_level, 'edocument', 'auth_html');
    $upload_url = "";
    if(Engine_Api::_()->authorization()->isAllowed('album', $user, 'create')){
      $upload_url = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sesbasic', 'controller' => 'index', 'action' => "upload-image"), 'default', true);
    }

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

    if((isset($modulesEnable) && array_key_exists('enable_tinymce',$modulesEnable) && $modulesEnable['enable_tinymce']) || empty($modulesEnable)) {
			$textarea = 'TinyMce';
		}else
			$textarea = 'Textarea';

    $descriptionMan= Engine_Api::_()->getApi('settings', 'core')->getSetting('edocument.description.mandatory', '1');
		if ($descriptionMan == 1) {
			$required = true;
			$allowEmpty = false;
		} else {
			$required = false;
			$allowEmpty = true;
		}
    $this->addElement($textarea, 'body', array(
      'label' => 'Description',
      'required' => $required,
      'allowEmpty' => $allowEmpty,
      'class'=>'tinymce',
      'editorOptions' => $editorOptions,
    ));

    if($this->getFromApi()){
        $this->addElement('File', 'file', array(
            'label' => 'Main Photo',
            'description' => '',
        ));
    }

//     // Photo
//     $this->addElement('File', 'photo_file', array(
//         'label' => 'Main Photo'
//     ));
//     $this->photo_file->addValidator('Extension', false, 'jpg,png,gif,jpeg');

    $upallowEmpty = true;
    $uprequired = false;

    if(Engine_Api::_()->getApi('settings', 'core')->getSetting('edocument.extensions','1')) {
        $this->addElement('File', "extensions", array(
            'label' => 'Upload Document',
            'description' => 'Please upload the documents of following types only.[DEFAULT ALLOWED EXTENSIONS: pdf, txt, ps, rtf, epub, odt, odp, ods, odg, odf, sxw, sxc, sxi, sxd, doc, ppt, pps, xls, docx, pptx, ppsx, xlsx, tif, tiff, jpg, jpeg, png, gif, mp4, mov.]',
            'allowEmpty' => $upallowEmpty,
            'required' => $uprequired,
            'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('extensions',''),
        ));
        $this->getElement('extensions')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    } else {
        $description = Engine_Api::_()->getApi('settings', 'core')->getSetting('edocument.extensionstype','pdf, txt, ps, rtf, epub, odt, odp, ods, odg, odf, sxw, sxc, sxi, sxd, doc, ppt, pps, xls, docx, pptx, ppsx, xlsx, tif, tiff, jpg, jpeg, png, gif, mp4, mov');

        $this->addElement('File', "extensions", array(
            'label' => 'Upload Document',
            'description' => 'Please upload the documents of following types only.[DEFAULT ALLOWED EXTENSIONS: "'.$description.'".]',
            'allowEmpty' => $upallowEmpty,
            'required' => $uprequired,
            'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('extensions',''),
        ));
        $this->extensions->addValidator('Extension', false, $description);
        $this->getElement('extensions')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    }

    if (Engine_Api::_()->authorization()->isAllowed('edocument', $viewer, 'allow_levels')) {

        $levelOptions = array();
        $levelValues = array();
        foreach (Engine_Api::_()->getDbtable('levels', 'authorization')->fetchAll() as $level) {
            $levelOptions[$level->level_id] = $level->getTitle();
            $levelValues[] = $level->level_id;
        }
        // Select Member Levels
        $this->addElement('multiselect', 'levels', array(
            'label' => 'Member Levels',
            'multiOptions' => $levelOptions,
            'description' => 'Choose the Member Levels to which this Document will be displayed. (Note: Hold down the CTRL key to select or de-select specific member levels.)',
            'value' => $levelValues,
        ));
    }

    if (Engine_Api::_()->authorization()->isAllowed('edocument', $viewer, 'allow_network')) {
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

    if (Engine_Api::_()->authorization()->isAllowed('edocument', $viewer, 'download')) {
      $this->addElement('Radio', 'download', array(
          'label' => 'Allow Document Download',
          'description' => 'Do you want allow member download this document?',
          'multiOptions' => array(
              "1" => 'Yes',
              "0" => 'No',
          ),
          'value' => 1,
      ));
    }

    if (Engine_Api::_()->authorization()->isAllowed('edocument', $viewer, 'emailattachment')) {
      $this->addElement('Radio', 'attachment', array(
          'label' => 'Allow Email Attachment',
          'description' => 'Do you want to allow to email attachment this document?',
          'multiOptions' => array(
              "1" => 'Yes',
              "0" => 'No',
          ),
          'value' => 1,
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
    $viewOptions = (array) Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('edocument', $user, 'auth_view');
    $viewOptions = array_intersect_key($availableLabels, array_flip($viewOptions));

    if( !empty($viewOptions) && count($viewOptions) >= 1 ) {
      // Make a hidden field
      if(count($viewOptions) == 1) {
        $this->addElement('hidden', 'auth_view', array('value' => key($viewOptions)));
      // Make select box
      } else {
        $this->addElement('Select', 'auth_view', array(
            'label' => 'Privacy',
            'description' => 'Who may see this document entry?',
            'multiOptions' => $viewOptions,
            'value' => key($viewOptions),
        ));
        $this->auth_view->getDecorator('Description')->setOption('placement', 'append');
      }
    }

    // Element: auth_comment
    $commentOptions = (array) Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('edocument', $user, 'auth_comment');
    $commentOptions = array_intersect_key($availableLabels, array_flip($commentOptions));

    if( !empty($commentOptions) && count($commentOptions) >= 1 ) {
      // Make a hidden field
      if(count($commentOptions) == 1) {
        $this->addElement('hidden', 'auth_comment', array('value' => key($commentOptions)));
      // Make select box
      } else {
        $this->addElement('Select', 'auth_comment', array(
            'label' => 'Comment Privacy',
            'description' => 'Who may post comments on this document entry?',
            'multiOptions' => $commentOptions,
            'value' => key($commentOptions),
        ));
        $this->auth_comment->getDecorator('Description')->setOption('placement', 'append');
      }
    }

    $this->addElement('Select', 'draft', array(
      'label' => 'Status',
      'multiOptions' => array(""=>"Published", "1"=>"Saved As Draft"),
      'description' => 'If this entry is published, it cannot be switched back to draft mode.'
    ));
    $this->draft->getDecorator('Description')->setOption('placement', 'append');

    $this->addElement('Checkbox', 'search', array(
      'label' => 'Show this document entry in search results',
      'value' => 1,
    ));

    $this->addElement('Button', 'submit', array(
      'label' => 'Save Changes',
      'type' => 'submit',
    ));
  }
}
