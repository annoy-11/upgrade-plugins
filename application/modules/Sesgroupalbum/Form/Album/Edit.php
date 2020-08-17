<?php

class Sesgroupalbum_Form_Album_Edit extends Engine_Form {

  public function init() {
    $user = Engine_Api::_()->user()->getViewer();
    $user_level = Engine_Api::_()->user()->getViewer()->level_id;
    $this->setTitle('Edit Album Settings')
            ->setAttrib('name', 'albums_edit');
    $this->addElement('Text', 'title', array(
        'label' => 'Album Title',
        'required' => true,
        'notEmpty' => true,
        'validators' => array(
            'NotEmpty',
        ),
        'filters' => array(
            new Engine_Filter_Censor(),
            'StripTags',
            new Engine_Filter_StringLength(array('max' => '63'))
        )
    ));
    $this->title->getValidator('NotEmpty')->setMessage("Please specify an album title");
		// init to
    $this->addElement('Text', 'tags',array(
      'label'=>'Tags (Keywords)',
      'autocomplete' => 'off',
      'description' => 'Separate tags with commas.',
      'filters' => array(
        new Engine_Filter_Censor(),
      ),
    ));
   $this->tags->getDecorator("Description")->setOption("placement", "append");
			$this->addElement('Text', 'lat', array(
        'label' => 'Lat',
				'id' =>'latSesList',
        'filters' => array(
            new Engine_Filter_Censor(),
            new Engine_Filter_HtmlSpecialChars(),
        ),
    ));
	if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroupalbum_enable_location', 1)){
		$this->addElement('Text', 'location', array(
        'label' => 'Location',
				'id' =>'locationSesList',
        'filters' => array(
            new Engine_Filter_Censor(),
            new Engine_Filter_HtmlSpecialChars(),
        ),
    ));
		$this->addElement('dummy', 'map-canvas', array());
		$this->addElement('dummy', 'ses_location', array('content'));		
		$this->addElement('Text', 'lng', array(
        'label' => 'Lng',
				'id' =>'lngSesList',
        'filters' => array(
            new Engine_Filter_Censor(),
            new Engine_Filter_HtmlSpecialChars(),
        ),
    ));
	}


    $this->addElement('Textarea', 'description', array(
        'label' => 'Album Description',
        'rows' => 2,
        'filters' => array(
            new Engine_Filter_Censor(),
            'StripTags',
            new Engine_Filter_EnableLinks(),
        )
    ));
    $this->addElement('Checkbox', 'search', array(
        'label' => "Show this album in search results",
    ));
    // View
    $availableLabels = array(
        'everyone' => 'Everyone',
        'registered' => 'All Registered Members',
        'owner_network' => 'Friends and Networks',
        'owner_member_member' => 'Friends of Friends',
        'owner_member' => 'Friends Only',
        'owner' => 'Just Me'
    );
    // Element: auth_view
    $viewOptions = (array) Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('album', $user, 'auth_view');
    $viewOptions = array_intersect_key($availableLabels, array_flip($viewOptions));
    if (!empty($viewOptions) && count($viewOptions) >= 1) {
      // Make a hidden field
      if (count($viewOptions) == 1) {
        $this->addElement('hidden', 'auth_view', array('value' => key($viewOptions)));
        // Make select box
      } else {
        $this->addElement('Select', 'auth_view', array(
            'label' => 'Privacy',
            'description' => 'Who may see this album?',
            'multiOptions' => $viewOptions,
            'value' => key($viewOptions),
        ));
        $this->auth_view->getDecorator('Description')->setOption('placement', 'append');
      }
    }
    // Element: auth_comment
    $commentOptions = (array) Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('album', $user, 'auth_comment');
    $commentOptions = array_intersect_key($availableLabels, array_flip($commentOptions));
    if (!empty($commentOptions) && count($commentOptions) >= 1) {
      // Make a hidden field
      if (count($commentOptions) == 1) {
        $this->addElement('hidden', 'auth_comment', array('value' => key($commentOptions)));
        // Make select box
      } else {
        $this->addElement('Select', 'auth_comment', array(
            'label' => 'Comment Privacy',
            'description' => 'Who may post comments on this album?',
            'multiOptions' => $commentOptions,
            'value' => key($commentOptions),
        ));
        $this->auth_comment->getDecorator('Description')->setOption('placement', 'append');
      }
    }
    // Element: auth_tag
    $tagOptions = (array) Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('album', $user, 'auth_tag');
    $tagOptions = array_intersect_key($availableLabels, array_flip($tagOptions));
    if (!empty($tagOptions) && count($tagOptions) >= 1) {
      // Make a hidden field
      if (count($tagOptions) == 1) {
        $this->addElement('hidden', 'auth_tag', array('value' => key($tagOptions)));
        // Make select box
      } else {
        $this->addElement('Select', 'auth_tag', array(
            'label' => 'Tagging',
            'description' => 'Who may tag photos in this album?',
            'multiOptions' => $tagOptions,
            'value' => key($tagOptions),
        ));
        $this->auth_tag->getDecorator('Description')->setOption('placement', 'append');
      }
    }
		
		$viewer = Engine_Api::_()->user()->getViewer();
		$sesprofilelock_enable_module = (array)Engine_Api::_()->getApi('settings', 'core')->getSetting('sesprofilelock.enable.modules');
    //check dependent module sesprofile install or not
    if (Engine_Api::_()->getApi('core', 'sesbasic')->isModuleEnable('sesprofilelock') && Engine_Api::_()->authorization()->getPermission($viewer, 'album', 'sesgroupalbum_locked')  && in_array('sesgroupalbum',$sesprofilelock_enable_module)) {
      // Video enable password
      $this->addElement('Select', 'is_locked', array(
          'label' => 'Enable Album Lock',
          'multiOptions' => array(
              0 => 'No',
              1 => 'Yes',
          ),
          'onclick' => 'enablePasswordFiled(this.value);',
          'value' => 0
      ));
      // Video lock password
      $this->addElement('password', 'password', array(
          'label' => 'Set Album Password',
					'autocomplete'=>'off',
          'value' => '',
      ));
    }
		
    // Submit or succumb!
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Album',
        'type' => 'submit',
        'decorators' => array(
            'ViewHelper'
        )
    ));
    $this->addElement('Cancel', 'cancel', array(
        'label' => 'cancel',
        'link' => true,
        'prependText' => ' or ',
        'decorators' => array(
            'ViewHelper'
        )
    ));
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
  }
}