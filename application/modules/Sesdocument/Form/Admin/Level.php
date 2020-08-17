<?php
class Sesdocument_Form_Admin_Level extends Authorization_Form_Admin_Level_Abstract {

  public function init() {
   parent::init();
        $this
            ->setTitle('Member Level Settings')
            ->setDescription('These settings are applied on a per member level basis . Start by selecting the member level you want to modify, then adjust the settings for that level below.');

        $this->addElement('Radio', 'view', array(
                'label' => 'Allow Viewing of Documents?',
                'description' => 'Do you want to let members to view documents on your website? If set to no, some other settings on this page may not apply.',
                'multiOptions' => array(
                    2 => 'Yes, allow members to view all Documents, even private ones.',
                    1 => 'Yes, allow members to view Documents.',
                    0 => 'No, do not allow Documents to be viewed.',
                 ),
                'value' => ( $this->isModerator() ? 2 : 1 ),
        ));
        if (!$this->isModerator()) {
        unset($this->view->options[2]);
        }

        if (!$this->isPublic()) {

      // Element: create
        $this->addElement('Radio', 'create', array(
                'label' => 'Allow Creation of Documents?',
                'description' => 'Do you want to let members to create documents? If set to no, some other settings on this page may not apply.',
                'multiOptions' => array(
                    1 => 'Yes, allow creation of Documents.',
                    0 => 'No, do not allow Documents to be created.',
                ),
                'value' => 1,
        ));

        $this->addElement('Radio', 'edit', array(
                'label' => 'Allow Editing of Documents?',
                'description' => 'Do you want to let members to edit their own Documents?',
                'multiOptions' => array(
                    2 => "Yes, allow members to edit everyone's Documents.",
                    1 => "Yes, allow  members to edit their own Documents.",
                    0 => "No, do not allow Documents to be edited.",
                ),
                'value' => ( $this->isModerator() ? 2 : 1 ),
        ));
        if (!$this->isModerator()) {
        unset($this->edit->options[2]);
        }

        $this->addElement('Radio', 'delete', array(
                'label' => 'Allow Deletion of Documents?',
                'description' => 'Do you want to let members to delete Documents? If set to no, some other settings on this page may not apply.',
                'multiOptions' => array(
                    2 => 'Yes, allow members to delete all Documents.',
                    1 => 'Yes, allow members to delete their own Documents.',
                    0 => 'No, do not allow members to delete their Documents.',
                ),
                'value' => ( $this->isModerator() ? 2 : 1 ),
        ));
        if (!$this->isModerator()) {
        unset($this->delete->options[2]);
        }

        $this->addElement('Radio', 'approve', array(
				'description' => 'Do you want documents created by members of this level to be auto-approved?',
				'label' => 'Auto Approve Documents',
				'multiOptions' => array(
                    1=>'Yes, auto-approve documents.',
                    0=>'No, do not auto-approve documents.'
				),
				'value' => 1,
        ));

        $this->addElement('Radio', 'featured', array(
				'description' => 'Do you want documents created by members of this level to be automatically marked as Featured?',
				'label' => 'Automatically Mark documents as Featured',
				'multiOptions' => array(
                    1=>'Yes, automatically mark documents as Featured.',
                    0=>'No, do not automatically mark documents as Featured.',
				),
				'value' => 0,
        ));

        $this->addElement('Radio', 'sponsored', array(
				'description' => '“Do you want documents created by members of this level to be automatically marked as Sponsored?”',
				'label' => 'Automatically Mark documents as Sponsored',
				'multiOptions' => array(
                    1=>'Yes, automatically mark documents as Sponsored.',
                    0=>'No, do not automatically mark documents as Sponsored.',
				),
				'value' => 0,
        ));

        $this->addElement('Radio', "highlight", array(
              'label' => ' Allow to Highlight Document',
              'description' => 'Do you want to let members of this level to choose their documents as Highlighted Document?',
              'allowEmpty' => false,
              'required' => true,
              'multiOptions'=>array(
                    '1'=>'Yes',
                    '0'=>'No',
               ),
              'value'=>'0',
        ));
        $this->getElement('highlight')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));


        $this->addElement('Radio', "make_highlight", array(
              'label' => 'Make Highlight Document during Creation',
              'description' => 'Do you want users to be able to make Highlighted Document while creation of the document?',
              'allowEmpty' => false,
              'required' => true,
              'multiOptions'=>array(
                    '1'=>'Yes',
                    '0'=>'No',
              ),
              'value'=>'1',
        ));
        $this->getElement('make_highlight')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

        $this->addElement('Text', "max_highlight", array(
              'label' => ' Maximum Allowed Highlighted Documents',
              'description' => ' Enter the maximum number of allowed highlighted documents. The field must contain an integer between 1 and 999, or 0 for unlimited.',
              'allowEmpty' => false,
              'required' => true,
              'value'=>'1',
        ));
        $this->getElement('max_highlight')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

        $this->addElement('Radio', 'comment', array(
              'label' => 'Allow Commenting on Documents?',
              'description' => 'Do you want to let members of this level to comment on Documents?',
              'multiOptions' => array(
                     2 => 'Yes, allow members to comment on all Documents, including private ones.',
                     1 => 'Yes, allow members to comment on Documents.',
                     0 => 'No, do not allow members to comment on Documents.',
             ),
             'value' => ( $this->isModerator() ? 2 : 1 ),
        ));
        if (!$this->isModerator()) {
        unset($this->comment->options[2]);
        }

        $this->addElement('MultiCheckbox', 'auth_view', array(
              'label' => '  Document View Privacy',
              'description' => ' Your members can choose from any of the options checked below when they decide who can see their document entries.',
               'allowEmpty' => false,
              'required' => true,
              'multiOptions' => array(
                    'everyone' => 'Everyone',
                    'registered' => 'All Registered Members',
                    'owner_network' => 'Friends and Networks',
                    'owner_member_member' => 'Friends of Friends',
                    'owner_member' => 'Friends Only',
                    'owner' => 'Just Me',

             ),
                 'value' => array('everyone','registered','owner_network','owner_member_member','owner_member','owner'),

        ));


        $this->addElement('MultiCheckbox', 'auth_comment', array(
              'label' => 'Document Comment Options',
              'description' => 'Your members can choose from any of the options checked below when they decide who can post comments on their entries.',
               'allowEmpty' => false,
              'required' => true,
              'multiOptions' => array(
                        'everyone' => 'Everyone',
                    'registered' => 'All Registered Members',
                    'owner_network' => 'Friends and Networks',
                    'owner_member_member' => 'Friends of Friends',
                    'owner_member' => 'Friends Only',
                    'owner' => 'Just Me',
               ),
                'value' => array('everyone','registered','owner_network','owner_member_member','owner_member','owner'),
        ));

        $this->addElement('Text', 'max_doc', array(
              'label' => 'Maximum allowed documents',
              'description' => ' Enter the maximum number of documents allowed to be posted. This field must contain an integer (Valid values are from 1 to 0.) use zero for unlimited documents.',
              'value' => '2',
        ));
        $this->getElement('max_doc')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

        $this->addElement('Text', 'max_size', array(
              'label' => ' Maximum file size',
              'description' => 'Enter the maximum document file size limit in KB to be allowed for this user level. (Valid values are from 1 to 131072 KB.)',
              'value' => '131072',
        ));
        $this->getElement('max_size')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

        $this->addElement('Radio', 'downloading', array(
              'label' => 'Document downloading',
              'description' => ' Do you want members to be able to download the documents posted by the members of this level?',
              'multiOptions' => array(
                    '1' => 'Yes',
                    '0' => 'No',
              ),
              'value' => '0',
        ));
        $this->getElement('downloading')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

        $this->addElement('Radio', 'email', array(
              'label' => 'Email attachment Settings',
              'description' => 'Do you want members to be able to email the document as attachment?',
              'multiOptions' => array(
                    '1' => 'Yes',
                    '0' => 'No',
              ),
              'value' => '0',
        ));
        $this->getElement('email')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
        }
  }
}
