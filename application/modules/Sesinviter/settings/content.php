<?php

return array(
  array(
    'title' => 'SES - Inviter - Manage Referral Search',
    'description' => 'Displays a search form in the my referral page.',
    'category' => 'SES - Social Friends Inviter & Contact Importer Plugin',
    'type' => 'widget',
    'name' => 'sesinviter.manage-search',
    'requirements' => array(
      'no-subject',
    ),
  ),
  array(
    'title' => 'SES - Inviter - Invite Browse Search',
    'description' => 'Displays a search form in the invite browse page.',
    'category' => 'SES - Social Friends Inviter & Contact Importer Plugin',
    'type' => 'widget',
    'name' => 'sesinviter.browse-search',
    'requirements' => array(
      'no-subject',
    ),
  ),
  array(
    'title' => 'SES - Inviter - Browse Menu',
    'description' => 'Displays a menu in the inviter browse page.',
    'category' => 'SES - Social Friends Inviter & Contact Importer Plugin',
    'type' => 'widget',
    'name' => 'sesinviter.browse-menu',
  ),
    array(
        'title' => 'SES - Inviter - Referral Signup',
        'description' => 'With this widget current user can send referral link to their friends for Signup.',
        'category' => 'SES - Social Friends Inviter & Contact Importer Plugin',
        'type' => 'widget',
        'name' => 'sesinviter.invite-friends',
    ),
  array(
    'title' => 'SES - Inviter - Top Referrers',
    'description' => 'Displays the members who have brought the most new members on your community through their invites.',
    'category' => 'SES - Social Friends Inviter & Contact Importer Plugin',
    'type' => 'widget',
    'name' => 'sesinviter.topreferrers',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Select',
          'viewType',
          array(
            'label' => "Choose View Type.",
            'multiOptions' => array(
              'list' => 'List View',
              'grid' => 'Grid View',
            ),
          ),
        ),
        array(
          'MultiCheckbox',
          'information',
          array(
            'label' => "Select the details that you want to show in this widget.",
            'multiOptions' => array(
              'invitecount' => 'Invite Count',
              'memberjoincount' => 'Member Joined Count',
              'friendcount' => 'Friend count',
            ),
          )
        ),
        array(
            'Text',
            'photoheight',
            array(
                'label' => 'Enter the height of grid photo block (in pixels).',
                'value' => '160',
            )
        ),
        array(
            'Text',
            'photowidth',
            array(
                'label' => 'Enter the width of grid photo block (in pixels).',
                'value' => '250',
            )
        ),
        array(
          'Text',
          'limit',
          array(
            'label' => 'Enter the number of members to be shown',
            'value' => 3,
            'validators' => array(
              array('Int', true),
              array('GreaterThan', true, array(0)),
            )
          )
        ),
      ),
    ),
  ),
  array(
    'title' => 'SES - Inviter - Top Inviters',
    'description' => 'Displays the members who have invited the most to join your community with their contacts.',
    'category' => 'SES - Social Friends Inviter & Contact Importer Plugin',
    'type' => 'widget',
    'name' => 'sesinviter.topinviters',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Select',
          'viewType',
          array(
            'label' => "Choose View Type.",
            'multiOptions' => array(
              'list' => 'List View',
              'grid' => 'Grid View',
            ),
          ),
        ),
        array(
          'MultiCheckbox',
          'information',
          array(
            'label' => "Select the details that you want to show in this widget.",
            'multiOptions' => array(
              'invitecount' => 'Invite Count',
              'friendcount' => 'Friend count',
            ),
          )
        ),
        array(
            'Text',
            'photoheight',
            array(
                'label' => 'Enter the height of grid photo block (in pixels).',
                'value' => '160',
            )
        ),
        array(
            'Text',
            'photowidth',
            array(
                'label' => 'Enter the width of grid photo block (in pixels).',
                'value' => '250',
            )
        ),
        array(
          'Text',
          'limit',
          array(
            'label' => 'Enter the number of members to be shown',
            'value' => 3,
            'validators' => array(
              array('Int', true),
              array('GreaterThan', true, array(0)),
            )
          )
        ),
      ),
    ),
  ),
  array(
    'title' => 'SES - Inviter - Random Member Introductions',
    'description' => 'Randomly displays members introductions.',
    'category' => 'SES - Social Friends Inviter & Contact Importer Plugin',
    'type' => 'widget',
    'name' => 'sesinviter.random-member-introductions',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Select',
          'criteria',
          array(
            'label' => "Choose Popularity Criteria for this widget.",
            'multiOptions' => array(
              'creation_date' => 'Recenty Created',
              'modified_date' => 'Recenty Modified',
              'random' => 'Random',
            ),
          ),
        ),
        array(
          'MultiCheckbox',
          'information',
          array(
            'label' => "Select the details that you want to show for each introduction in this widget.",
            'multiOptions' => array(
              'memberphoto' => 'Member Photo',
              'addfriendbutton' => 'Add Friend Button',
              'viewprofile' => 'View Profile Button',
              'mutualfriendcount' => 'Count of Mutual Friends',
            ),
          )
        ),
        array(
          'Text',
          'descriptionlimit',
          array(
            'label' => 'Enter the limit for the Introduction.',
            'value' => 100,
            'validators' => array(
              array('Int', true),
              array('GreaterThan', true, array(0)),
            )
          )
        ),
        array(
          'Text',
          'limit',
          array(
            'label' => 'Enter the number of introductions to be shown',
            'value' => 3,
            'validators' => array(
              array('Int', true),
              array('GreaterThan', true, array(0)),
            )
          )
        ),
      ),
    ),
  ),
  array(
    'title' => 'SES - Inviter - Introduce Yourself',
    'description' => 'Allows user to introduce himself to whole social network by writing about himself. We recommend you to place this widget on Member Home Page and Member Profile Page.',
    'category' => 'SES - Social Friends Inviter & Contact Importer Plugin',
    'type' => 'widget',
    'name' => 'sesinviter.introduce-yourself',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Text',
          'descriptionlimit',
          array(
            'label' => 'Enter the limit for the Introduction.',
            'value' => 100,
            'validators' => array(
              array('Int', true),
              array('GreaterThan', true, array(0)),
            )
          )
        ),
      ),
    ),
  ),
  array(
    'title' => 'SES - Inviter - Button Click in Popup or Page',
    'description' => 'This widget displays a button as configured from the edit settings of this widget to show chosen form. The form can be shown in popup or on specific page. Various settings for button like text, color can be configured.',
    'category' => 'SES - Social Friends Inviter & Contact Importer Plugin',
    'type' => 'widget',
    'name' => 'sesinviter.popup',
    'autoEdit' => true,
    'adminForm' => array(
    'elements' => array(
      array(
        'Text',
        'buttontext',
        array(
          'label'=>'Enter Button Text.',
          'value' => '',
          'required' => true
        )
      ),
      array(
        'Select',
        'position',
        array(
          'label'=>'Choose the placement of button. [This setting will only work, if you place this widget in the header or footer of your website. On other pages, button will be shown at placed position.]',
          'multiOptions' => array('1'=>'In Right Side','2'=>'In Left Side','3'=>'At placed Position'),
          'value' => '3',
        )
      ),
      array(
        'Text',
        'buttoncolor',
        array(
          'class' => 'SEScolor',
          'label'=>'Choose color of the button.',
          'value' => '#78c744',
        )
      ),
      array(
        'Text',
        'texthovercolor',
        array(
          'class' => 'SEScolor',
          'label'=>'Choose color of the button when mouse is hovered on it.',
          'value' => '#f2134f',
        )
      ),
      array(
        'Text',
        'textcolor',
        array(
          'class' => 'SEScolor',
          'label'=>'Choose text color on the button.',
          'value' => '#ffffff',
        )
      ),
      array(
        'Text',
        'margin',
        array(
          'label' => 'Enter value for the top margin. [This setting will work for Left / Right placement of button.]',
          'value' => '30',
        )
      ),
      array(
        'Select',
        'margintype',
        array(
          'label' => 'Choose the unit of margin.',
          'multiOptions' => array('pix'=>'Pixels (px)','per'=>'Percentage (%)'),
          'value' => 1,
          'required' => true
        )
      ),
      array(
        'Select',
        'popuptype',
        array(
          'label' => 'Do you want to show Form in Popup or Redirect users to Specific Page, when the button of this widget is clicked?',
          'multiOptions' => array(1=>'Show Form in Popup',0=>'Redirect users to Specific Page.'),
          'value' => 1,
        )
      ),
      array(
        'Text',
        'redirectOpen',
        array(
          'label'=>'Enter URL to which users will be redirected.(this setting works only, if you select "Redirect users to Specific Page.")',
          'value' => '',
        )
      ),
    )
    ),
  ),
);
