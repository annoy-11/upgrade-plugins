<?php

class Sesdocument_Form_Create extends Engine_Form

{
    protected $_defaultProfileId;
    public function getDefaultProfileId() {
        return $this->_defaultProfileId;
    }
    public function setDefaultProfileId($default_profile_id) {
        $this->_defaultProfileId = $default_profile_id;
        return $this;
    }
    protected $_itemData;
    function getItemData($itemData){
        $this->_itemData = $itemData;
    }
    function setItemData($itemData){
        $this->_itemData = $itemData;
    }

    public function init() {
        $level = Engine_Api::_()->getItemTable('authorization_level');
        if (Engine_Api::_()->core()->hasSubject('sesdocument'))
        $event = Engine_Api::_()->core()->getSubject();

        $viewer = Engine_Api::_()->user()->getViewer();
        $userId = $viewer->getIdentity();

        //get current logged in user
        $this->setTitle('Create New Event')
            ->setAttrib('id', 'sesdocument_create_form')
                      ->setAttrib('enctype', 'multipart/form-data')
            ->setMethod("POST")
            ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()));


        $settings = Engine_Api::_()->getApi('settings', 'core');
        $request = Zend_Controller_Front::getInstance()->getRequest();
        $moduleName = $request->getModuleName();
        $controllerName = $request->getControllerName();
        $actionName = $request->getActionName();

        $sesdocument_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('sesdocument_id',0);

        $this->setTitle('Upload New Document')
            ->setDescription('Upload your new document by filling the information below, then click "Save Changes".');
        $settings = Engine_Api::_()->getApi('settings', 'core');

        $this->addElement('Text', 'title', array(
            'label' => ' Document Title',
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

         $custom_url_value = isset($document->custom_url) ? $document->custom_url : (isset($_POST["custom_url"]) ? $_POST["custom_url"] : "");
        if($actionName !=  'edit'){
            // Custom Url
            $this->addElement('Dummy', 'custom_url_event', array(
                    'label' => 'Custom URL',
                    'content' => '<input type="text" name="custom_url" id="custom_url" value="' . $custom_url_value . '"><i class="fa fa-check" id="sesdocument_custom_url_correct" style="display:none;"></i><i class="fa fa-close" id="sesdocument_custom_url_wrong" style="display:none;"></i><span class="sesdocument_check_availability_btn"><img src="application/modules/Core/externals/images/loading.gif" id="sesdocument_custom_url_loading" alt="Loading" style="display:none;" /><button id="check_custom_url_availability" type="button" name="check_availability" >Check Availability</button></span>',
            ));
        }

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

    if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdocument.description.enable', 1)) {
        $descriptionMan= Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdocument.description.mandatory', '1');
		if ($descriptionMan == 1) {
			$required = true;
			$allowEmpty = false;
		} else {
			$required = false;
			$allowEmpty = true;
		}
        $this->addElement('TinyMce', 'description', array(
            'label' => 'Description',
            'allowEmpty' => $allowEmpty,
            'required' => $required,
            'class' => 'tinymce',
            'editorOptions' => $editorOptions,
        ));
    }

        $categories = Engine_Api::_()->getDbtable('categories', 'sesdocument')->getCategoriesAssoc();
        $document_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('document_id', 0);
        if (count($categories) > 0) {
        $settings = Engine_Api::_()->getApi('settings', 'core');

        $categorieEnable = $settings->getSetting('sesdocument.category.enable', '1');
        if($categorieEnable) {
            $catMand = $settings->getSetting('sesdocument.category.mandatory', 1);
            if ($catMand == 1) {
                $required = true;
                $allowEmpty = false;
            } else {
                $required = false;
                $allowEmpty = true;
            }

            $categories = array('0'=>"")+$categories;
            $this->addElement('Select', 'category_id', array(
                'label' => 'Category',
                'multiOptions' => $categories,
                'allowEmpty' => $allowEmpty,
                'required' => $required,
                'onchange' => "showSubCategory(this.value);showFields(this.value,1,this.class,this.class,'resets');",
            ));

            $this->addElement('Select', 'subcat_id', array(
                'label' => "2nd-level Category",
                'allowEmpty' => true,
                'required' => false,
                'multiOptions' => array('0' => ''),
                'registerInArrayValidator' => false,
                'onchange' => "showSubSubCategory(this.value);showFields(this.value,1,this.class,this.class,'resets');"
            ));

            $this->addElement('Select', 'subsubcat_id', array(
                'label' => "3rd-level Category",
                'allowEmpty' => true,
                'registerInArrayValidator' => false,
                'required' => false,
                'multiOptions' => array('0' => ''),
                'onchange' => "showFields(this.value,1);showFields(this.value,1,this.class,this.class,'resets');"
            ));
                $defaultProfileId = "0_0_" . $this->getDefaultProfileId();
                $customFields = new Sesbasic_Form_Custom_Fields(array(
                    'item' => isset($document) ? $document : 'sesdocument',
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

        if($sesdocument_id) {
            $upallowEmpty = true;
            $uprequired = false;
        } else {
            $upallowEmpty = false;
            $uprequired = true;
        }

        if($settings->getSetting('sesdocument.extensions','1')) {
            $this->addElement('File', "extensions", array(
                'label' => 'Upload Document',
                'description' => 'Please upload the documents of following types only.[DEFAULT ALLOWED EXTENSIONS: pdf, txt, ps, rtf, epub, odt, odp, ods, odg, odf, sxw, sxc, sxi, sxd, doc, ppt, pps, xls, docx, pptx, ppsx, xlsx, tif, tiff, jpg, jpeg, png, gif, mp4, mov.]',
                'allowEmpty' => $upallowEmpty,
                'required' => $uprequired,
                'value' => $settings->getSetting('extensions',''),
            ));
            $this->getElement('extensions')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
        } else {
            $description = $settings->getSetting('sesdocument.extensionstype','pdf, txt, ps, rtf, epub, odt, odp, ods, odg, odf, sxw, sxc, sxi, sxd, doc, ppt, pps, xls, docx, pptx, ppsx, xlsx, tif, tiff, jpg, jpeg, png, gif, mp4, mov');

            $this->addElement('File', "extensions", array(
                'label' => 'Upload Document',
                'description' => 'Please upload the documents of following types only.[DEFAULT ALLOWED EXTENSIONS: "'.$description.'".]',
                'allowEmpty' => $upallowEmpty,
                'required' => $uprequired,
                'value' => $settings->getSetting('extensions',''),
            ));
            $this->extensions->addValidator('Extension', false, $description);
            $this->getElement('extensions')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
        }

        $this->addElement('Text', 'tags', array(
            'label' => 'Tags (Keywords)',
            'autocomplete' => 'off',
            'description' => 'Separate tags with commas.',
            'filters' => array(
            new Engine_Filter_Censor(),
            ),
        ));
        $this->tags->getDecorator("Description")->setOption("placement", "append");

        if($settings->getSetting('sesdocument_thumbnails','1')) {
            $this->addElement('File', 'file', array(
                'label' => 'Document Thumbnail',
                'onclick'=>'javascript:sesJqueryObject("#photo").val("")',
                'onchange'=>'handleFileBackgroundUpload(this,document_main_photo_preview)',
            ));
            $this->file->addValidator('Extension', false, 'jpg,png,gif,jpeg');
        }

        $user = Engine_Api::_()->user()->getViewer();
        $value = Engine_Api::_()->authorization()->isAllowed('sesdocument', $viewer, 'highlight');
        $highlight = Engine_Api::_()->authorization()->isAllowed('sesdocument', $viewer, 'make_highlight');
        if($value == 1 && $highlight == 1){
            $highlightc = Engine_Api::_()->getDbTable('sesdocuments','sesdocument');
            $highlight_count = $highlightc->select()->from($highlightc->info('name'), array("COUNT(sesdocument_id)"));
            if ($userId){
                $highlight_count->where('user_id =?', $userId);
                $highlight_count->where('highlight =?',1);
            }
        $highlight_counts = $highlight_count->query()->fetchColumn();
        $allowed_highlight = Engine_Api::_()->authorization()->getPermission($user,'sesdocument','max_highlight');

        if( $highlight_counts < $allowed_highlight ||  $highlight_counts == $allowed_highlight || $allowed_highlight == 0)
         {

        $this->addElement('Radio', 'highlight', array(
            'label' => ' Make Highlight Document',
            'multiOptions' => array(
                '1' => 'Yes, make this your Highlight Document.',
                '0' => 'No, do not make this your Highlight Document.',
            ),
            'value' => '1',
        ));
        $this->highlight->getDecorator('Description')->setOption('placement', 'append');
        }}

        $value = Engine_Api::_()->authorization()->isAllowed('sesdocument', $viewer, 'downloading');
        if($value == 1){
        $this->addElement('Radio', 'download', array(
            'label' => ' Allow Document Download',
            'multiOptions' => array(
                '1' => 'Yes, allow document download.',
                '0' => 'No, do not allow document download.',
            ),
            'value' => 1,
        ));
        $this->download->getDecorator('Description')->setOption('placement', 'append');
        }


        $value = Engine_Api::_()->authorization()->isAllowed('sesdocument', $viewer, 'email');
        if($value == 1){
        $this->addElement('Radio', 'attachment', array(
            'label' => ' Allow Email Attachment',
            'multiOptions' => array(
                '1' => 'Yes, allow document to be emailed as attachment.',
                '0' => 'No, do not allow document to be emailed as attachment.',
            ),
            'value' => 1,
        ));
        $this->attachment->getDecorator('Description')->setOption('placement', 'append');
        }


        $viewOptions = (array) Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('sesdocument', $viewer, 'auth_view');
        $commentOptions = (array) Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('sesdocument', $viewer, 'auth_comment');

          $availableLabels = array(
          'everyone' => 'Everyone',
          'registered' => 'All Registered Members',
          'owner_network' => 'Friends and Networks',
          'owner_member_member' => 'Friends of Friends',
          'owner_member' => 'Friends Only',
          'member' => 'Event Guests Only',
          'owner' => 'Just Me'
      );
      $viewOptions = array_intersect_key($availableLabels, array_flip($viewOptions));
      $commentOptions = array_intersect_key($availableLabels,  array_flip($commentOptions));


    // View
         if (!empty($viewOptions) && count($viewOptions) >= 1) {
      // Make a hidden field
      if (count($viewOptions) == 1) {
        $this->addElement('hidden', 'auth_view',
            array(
                'value' => key($viewOptions),
                'order' => 13
            ));
        // Make select box
      } else {
        $this->addElement('Select', 'auth_view', array(
            'label' => 'View Privacy',
            'description' => 'Who may see this document?',
                        'class'=>$hideClass,
            'multiOptions' => $viewOptions,
            'value' => key($viewOptions),
        ));
        $this->auth_view->getDecorator('Description')->setOption('placement', 'append');
      }
    }

        if (!empty($commentOptions) && count($commentOptions) >= 1) {
      // Make a hidden field
            if (count($commentOptions) == 1) {
                $this->addElement('hidden', 'auth_comment',
                    array(
                        'value' => key($commentOptions),
                        'order' => 14
                ));
        // Make select box
            }else {
                $this->addElement('Select', 'auth_comment', array(
                    'label' => 'Comment Privacy',
                    'description' => 'Who may post comments on this Document?',
                    'class' => $hideClass,
                    'multiOptions' => $commentOptions,
                    'value' => key($commentOptions),
                ));
                $this->auth_comment->getDecorator('Description')->setOption('placement', 'append');
            }
        }

        $this->addElement('Select', 'draft', array(
            'label' => 'Status',
            'description' => 'If this entry is published, it cannot be switched back to draft mode.',
            'multiOptions' => array(
                '1' => 'Published',
                '0' => 'Saved As Draft',
            ),
            'value' => 1,
        ));
        $this->draft->getDecorator('Description')->setOption('placement', 'append');
        $this->addElement('Checkbox', 'show', array(
            'label' => ' Show this document in search results.',
            'description' => '',
            'multiOptions' => array(
                '1' => 'Show Document',
            ),
            'value' => 1,
        ));
        //$this->show->getDecorator('Description')->setOption('placement', 'append');

        $this->addElement('Button', 'submit', array(
            'label' => 'Save Changes',
            'type' => 'submit',
            'ignore' => true,
            'decorators' => array(
            'ViewHelper',
            ),
        ));


    }
}
