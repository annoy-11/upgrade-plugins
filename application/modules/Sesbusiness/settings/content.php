<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: content.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

if (Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesbusinessreview') && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinessreview.pluginactivated')) {
  $options = array('recentlySPcreated' => 'Newest', 'mostSPviewed' => 'Most Viewed','mostSPliked' => 'Most Liked','mostSPcommented' => 'Most Commented','mostSPrated' => 'Rated (High to Low)','lowestSPrated' => 'Rated (Low to High)','mostSPfavourite' => 'Most Favorited','mostSPfollower' => 'Most Followed','featured' => 'Only Featured','sponsored' => 'Only Sponsored','verified' => 'Only Verified','hot' => 'Only Hot');
  $viewOptions = array('0' => 'All Business Directories','4' => 'Open Business Directories','5' => 'Closed Business Directories','1' => 'Only My Friend\'s Business Directories','2' => 'Only My Network Business Directories','3' => 'Only My Businesses Directories','6' => 'Only 5 Star Reviews','7' => 'Only 4 Star Reviews','8' => 'Only 3 Star Reviews','9' => 'Only 2 Star Reviews','10' => 'Only 1 Star Reviews');
}
else {
  $options = array('recentlySPcreated' => 'Newest', 'mostSPviewed' => 'Most Viewed','mostSPliked' => 'Most Liked','mostSPcommented' => 'Most Commented','mostSPfavourite' => 'Most Favorited','mostSPfollower' => 'Most Followed','featured' => 'Only Featured','sponsored' => 'Only Sponsored','verified' => 'Only Verified','hot' => 'Only Hot');
  $viewOptions = array('0' => 'All Business Directories','4' => 'Open Business Directories','5' => 'Closed Business Directories','1' => 'Only My Friend\'s Business Directories','2' => 'Only My Network Business Directories','3' => 'Only My Businesses Directories');
}

$categories = array();
if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusiness.pluginactivated',0)) {
  $categories = Engine_Api::_()->getDbTable('categories', 'sesbusiness')->getCategoriesAssoc();
  $categories = array('' => '') + $categories;
}
$seslocation = array();
if (Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('seslocation')) {
  $seslocation = array(
      'Radio',
      'locationEnable',
      array(
          'label' => 'Do you want to show content in this widget based on the Location chosen by users on your website? (This is dependent on the “Location Based Member & Content Display Plugin”. Also, make sure location is enabled and entered for the content in this plugin. If setting is enabled and the content does not have a location, then such content will not be shown in this widget.)
',
          'multiOptions' => array('1' => 'Yes', '0' => 'No'),
          'value' => 0
      ),
  );
}
$socialshare_enable_plusicon = array(
    'Select',
    'socialshare_enable_plusicon',
    array(
        'label' => "Enable More Icon for social share buttons?",
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
    )
);
$socialshare_icon_limit = array(
    'Text',
    'socialshare_icon_limit',
    array(
        'label' => 'Count (number of social sites to show). If you enable More Icon, then other social sharing icons will display on clicking this plus icon.',
        'value' => 2,
    ),
);
$titleTruncation = array(
    'Text',
    'title_truncation',
    array(
        'label' => 'Enter Title truncation limit.',
        'value' => 45,
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    )
);
$descriptionTruncation = array(
    'Text',
    'description_truncation',
    array(
        'label' => 'Enter Description Truncation Limit.',
        'value' => 45,
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    )
);
$titleTruncationList = array(
    'Text',
    'title_truncation',
    array(
        'label' => 'Enter Title truncation limit.',
        'value' => 45,
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    )
);
$titleTruncationGrid = array(
    'Text',
    'grid_title_truncation',
    array(
        'label' => 'Title truncation limit for Grid View.',
        'value' => 45,
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    )
);
$titleTruncationAdvGrid = array(
    'Text',
    'advgrid_title_truncation',
    array(
        'label' => 'Title truncation limit for Advanced Grid View.',
        'value' => 45,
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    )
);
$titleTruncationSimpleGrid = array(
    'Text',
    'simplegrid_title_truncation',
    array(
        'label' => 'Title truncation limit for Simple Grid View.',
        'value' => 45,
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    )
);
$titleTruncationPinboard = array(
    'Text',
    'pinboard_title_truncation',
    array(
        'label' => 'Title truncation limit for Pinboard View.',
        'value' => 45,
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    )
);
$descriptionTruncationList = array(
    'Text',
    'description_truncation',
    array(
        'label' => 'Description truncation limit for List View.',
        'value' => 45,
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    )
);
$descriptionTruncationGrid = array(
    'Text',
    'grid_description_truncation',
    array(
        'label' => 'Description truncation limit for Grid View.',
        'value' => 45,
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    )
);
$descriptionTruncationAdvGrid = array(
    'Text',
    'advgrid_description_truncation',
    array(
        'label' => 'Description truncation limit for Advanced Grid View.',
        'value' => 45,
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    )
);
$descriptionTruncationSimpleGrid = array(
    'Text',
    'simplegrid_description_truncation',
    array(
        'label' => 'Description truncation limit for Simple Grid View.',
        'value' => 45,
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    )
);
$descriptionTruncationPinboard = array(
    'Text',
    'pinboard_description_truncation',
    array(
        'label' => 'Description truncation limit for Pinboard View.',
        'value' => 45,
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    )
);
$pagging = array(
    'Radio',
    'pagging',
    array(
        'label' => "Do you want the business directories to be auto-loaded when users scroll down the page?",
        'multiOptions' => array(
            'auto_load' => 'Yes, Auto Load',
            'button' => 'No, show \'View more\' link.',
            'pagging' => 'No, show \'Pagination\'.'
        ),
        'value' => 'auto_load',
    )
);
return array(
    array(
        'title' => 'SES - Business Directories - Business Directories Navigation Menu',
        'description' => 'Displays a navigation menu bar in the Business Directories pages like Browse Business Directories, Business Directories Home, Categories, etc.',
        'category' => 'SES - Business Directories',
        'type' => 'widget',
        'name' => 'sesbusiness.browse-menu',
        'requirements' => array(
            'no-subject',
        ),
    ),
    array(
        'title' => 'SES - Business Directories - Business Profile - Businesses Liked by This Business',
        'description' => 'This widget displays other Businesses which are Liked by the current Business. This widget should be placed on the "SES - Business Directories - Business View page" only.',
        'category' => 'SES - Business Directories - Business Profile',
        'type' => 'widget',
        'name' => 'sesbusiness.business-liked',
    ),
    array(
        'title' => 'SES - Business Directories - Business Profile - Business Operating Hours',
        'description' => 'This widget displays the operating hours of a Business which are entered from its dashboard.',
        'category' => 'SES - Business Directories - Business Profile',
        'type' => 'widget',
        'name' => 'sesbusiness.open-hours',
        'requirements' => array(
            'no-subject',
        ),
    ),
    array(
        'title' => 'SES - Business Directories - Tabbed widget for Manage Businesses',
        'description' => 'This widget displays businesses created, favourite, liked, etc by the member viewing the manage business. Edit this widget to configure various settings.',
        'category' => 'SES - Business Directories',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesbusiness.manage-businesses',
        'requirements' => array(
            'subject' => business,
        ),
        'adminForm' => 'Sesbusiness_Form_Admin_Tabbed',
    ),
    array(
        'title' => 'SES - Business Directories - Tabbed Widget for Popular Business Directories',
        'description' => 'Displays tabbed widget for business directores on your website. Edit this widget to choose and configure the tabs to be shown in this widget.',
        'category' => 'SES - Business Directories',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesbusiness.tabbed-widget-business',
        'requirements' => array(
            'subject' => business,
        ),
        'adminForm' => 'Sesbusiness_Form_Admin_Tabbed',
    ),
    array(
        'title' => 'SES - Business Directories - Browse Business Directories',
        'description' => 'Displays all the browsed business directories on the page in different views.',
        'category' => 'SES - Business Directories',
        'type' => 'widget',
        'name' => 'sesbusiness.browse-businesses',
        'autoEdit' => true,
        'adminForm' => 'Sesbusiness_Form_Admin_Browse',
        'requirements' => array(
            'no-subject',
        ),
    ),
    array(
        'title' => 'SES - Business Directories - Profile Business Directories',
        'description' => 'Displays all the profile business directories on the page in different views.',
        'category' => 'SES - Business Directories',
        'type' => 'widget',
        'name' => 'sesbusiness.profile-businesses',
        'autoEdit' => true,
        'adminForm' => 'Sesbusiness_Form_Admin_Browse',
        'requirements' => array(
            'no-subject',
        ),
    ),
    array(
        'title' => 'SES - Business Directories - Business Profile - Associated Sub Businesses List on Main Business',
        'description' => 'Displays Associated Sub Businesses on Business Directory View page.',
        'category' => 'SES - Business Directories - Business Profile',
        'type' => 'widget',
        'name' => 'sesbusiness.sub-businesses',
        'autoEdit' => true,
        'adminForm' => 'Sesbusiness_Form_Admin_Browse',
        'requirements' => array(
            'no-subject',
        ),
    ),
    array(
        'title' => 'SES - Business Directories - Business Profile - Associated Link Businesses List on Main Business',
        'description' => 'Displays Associated Link Businesses on Business Directory View page.',
        'category' => 'SES - Business Directories - Business Profile',
        'type' => 'widget',
        'name' => 'sesbusiness.link-businesses',
        'autoEdit' => true,
        'adminForm' => 'Sesbusiness_Form_Admin_Browse',
        'requirements' => array(
            'no-subject',
        ),
    ),
    array(
        'title' => 'SES - Business Directories - Business Profile - Cover Photo, Details & Options',
        'description' => 'Displays Cover photo of a Business. You can edit this widget to configure various settings and options to be shown in this widget. This widget should be placed on the "Businesses - Business View Page"',
        'category' => 'SES - Business Directories - Business Profile',
        'type' => 'widget',
        'name' => 'sesbusiness.business-view',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'Radio',
                    'layout_type',
                    array(
                        'label' => "Choose layout of view page.",
                        'multiOptions' => array(
                            '1' => ' Design 1 [Details are shown inside the block]',
                            '2' => ' Design 2 [Details are shown outside the block]',
                        ),
                        'value' => '1',
                    )
                ),
                array(
                    'Radio',
                    'tab_placement',
                    array(
                        'label' => "Choose the placement of the Tabs of tab container in Design 1.",
                        'multiOptions' => array(
                            'in' => 'Inside',
                            'out' => 'Outside'
                        ),
                        'value' => 'in',
                    )
                ),
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose options to be shown in this widget.",
                        'multiOptions' => array(
                            'title' => 'Business Title',
                            'photo' => 'Business Main Photo',
                            'by' => 'Created By',
                            'category' => 'Category [Design 2]',
                            'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                            'likeButton' => 'Like Button',
                            'favouriteButton' => 'Favourite Button',
                            'followButton' => 'Follow Button',
                            'joinButton' => 'Join Button',
                            'messageOwner' => 'Message Owner',
                            'addButton' => 'Add a Button',
                            'like' => 'Likes Count [Design 2]',
                            'comment' => 'Comments Count [Design 2]',
                            'favourite' => 'Favourites Count [Design 2]',
                            'rating' => 'Rating Star(Note: This setting will work only when business review extension enabled on your website.)',
                            'review' => 'Review Count (Note: This setting will work only when you have installed business review extension on your website.)',
                            'view' => 'Views Count [Design 2]',
                            'follow' => 'Follow Count [Design 2]',
                            'member' => 'Members Count[Design 2]',
                            'featuredLabel' => 'Featured Label',
                            'sponsoredLabel' => 'Sponsored Label',
                            'verifiedLabel' => 'Verified Label',
                            'hotLabel' => 'Hot Label',
                            'optionMenu' => 'Profile Options Menu',
                        ),
                        'escape' => false,
                    )
                ),
                array(
                    'Radio',
                    'show_full_width',
                    array(
                        'label' => "Show this widget in full width in Design 1?",
                        'multiOptions' => array(
                            'yes' => 'Yes',
                            'no' => 'No'
                        ),
                        'value' => 'no',
                    )
                ),
                array(
                    'Text',
                    'margin_top',
                    array(
                        'label' => 'Enter the value of the Margin Top for this widget (in pixels).',
                        'value' => 30,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        ),
                    ),
                ),
                array(
                    'Text',
                    'description_truncation',
                    array(
                        'label' => 'Enter Description truncation limit. [Supported with Design 2]',
                        'value' => 150,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                array(
                    'Text',
                    'cover_height',
                    array(
                        'label' => 'Enter the height of this cover photo container (in pixels).',
                        'value' => 400,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        ),
                    ),
                ),
                $socialshare_enable_plusicon,
                $socialshare_icon_limit,
            ),
        ),
    ),
    array(
        'title' => 'SES - Business Directories - Business Profile - Information',
        'description' => 'Displays information about the business when placed on "Businesses - Business View Page".',
        'category' => 'SES - Business Directories - Business Profile',
        'type' => 'widget',
        'name' => 'sesbusiness.business-info',
        'autoEdit' => true,
        'requirements' => array(
            business,
        ),
        'adminForm' => array(
            'elements' => array(
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => 'Choose from below the details you want to show in this widget.',
                        'multiOptions' => array(
                            'info' => 'Basic Info',
                            'description' => 'Description',
                            'profilefield' => 'Profile Fields',
                            'location' => 'Location Map',
                        ),
                    )
                ),
            ),
        ),
    ),
    array(
        'title' => 'SES - Business Directories - Business Directories Browse Search',
        'description' => 'Displays search form in the Business Directories Browse Page. This widget should be placed on "Business Directories Browse Page".',
        'category' => 'SES - Business Directories',
        'type' => 'widget',
        'autoEdit' => 'true',
        'name' => 'sesbusiness.browse-search',
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'view_type',
                    array(
                        'label' => "Choose the Placement Type.",
                        'multiOptions' => array(
                            'horizontal' => 'Horizontal',
                            'vertical' => 'Vertical'
                        ),
                        'value' => 'vertical',
                    )
                ),
                array(
                    'MultiCheckbox',
                    'search_type',
                    array(
                        'label' => 'Choose options to be shown in “Browse By” search fields.',
                        'multiOptions' => $options,
                    )
                ),
                array(
                    'Select',
                    'default_search_type',
                    array(
                        'label' => "Default value for 'Browse By' search field.",
                        'multiOptions' => $options,
                    )
                ),
                array(
                    'MultiCheckbox',
                    'criteria',
                    array(
                        'label' => "Choose options to be shown in 'View' search fields.",
                        'multiOptions' => $viewOptions,
                    )
                ),
                array(
                    'Select',
                    'default_view_search_type',
                    array(
                        'label' => "Default value for 'View' search field.",
                        'multiOptions' => $viewOptions,
                    )
                ),
                array(
                    'MultiCheckbox',
                    'show_option',
                    array(
                        'label' => "Choose from below the search fields to be shown in this widget.",
                        'multiOptions' => array(
                            'searchBusinessTitle' => 'Search Business Directories / Keywords',
                            'view' => 'View',
                            'browseBy' => 'Browse By',
                            'alphabet' => 'Alphabet',
                            'Categories' => 'Category',
                            'customFields' => 'Custom Fields',
                            'location' => 'Location ',
                            'miles' => 'Kilometers or Miles',
                            'country' => 'Country',
                            'state' => 'State',
                            'city' => 'City',
                            'zip' => 'Zip',
                            'venue' => 'Venue',
                            'closebusiness' => 'Include Closed Business Directories',
                        ),
                    )
                ),
                array(
                    'MultiCheckbox',
                    'hide_option',
                    array(
                        'label' => "Choose from below the search fields to be hidden in this widget. The selected search fields will be shown when users will click on the \"Show Advanced Settings\" link.",
                        'multiOptions' => array(
                            'searchBusinessTitle' => 'Search Businesses / Keywords',
                            'view' => 'View',
                            'browseBy' => 'Browse By',
                            'alphabet' => 'Alphabet',
                            'Categories' => 'Category',
                            'location' => 'Location ',
                            'miles' => 'Kilometers or Miles',
                            'country' => 'Country',
                            'state' => 'State',
                            'city' => 'City',
                            'zip' => 'Zip',
                            'venue' => 'Venue',
                            'closebusiness' => 'Include Closed Businesses',
                        ),
                    )
                ),
            )
        ),
    ),
    array(
        'title' => 'SES - Business Directories - Business Profile - Advance Share Widget',
        'description' => 'This widget allow users to share the current page on your website and on other social networking websites.',
        'category' => 'SES - Business Directories - Business Profile',
        'type' => 'widget',
        'name' => 'sesbusiness.advance-share',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'MultiCheckbox',
                    'advShareOptions',
                    array(
                        'label' => "Choose options to be shown in Advance Share in this widget.",
                        'multiOptions' => array(
                            'privateMessage' => 'Private Message',
                            'siteShare' => 'Site Share',
                            'quickShare' => 'Quick Share',
                            'tellAFriend' => 'Tell A Friend',
                            'addThis' => 'Add This Share Links',
                        ),
                    )
                ),
            ),
        ),
    ),
    array(
        'title' => 'SES - Business Directories - Business Profile - Info Sidebar',
        'description' => 'Displays a Business\'s info (likes creation details, stats, type, categories, etc) on their profiles. This widget should be placed in the right or left sidebar column on the "Businesses - Business View Page".',
        'category' => 'SES - Business Directories - Business Profile',
        'type' => 'widget',
        'name' => 'sesbusiness.profile-info',
        'requirements' => array(
            'subject' => business,
        ),
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'MultiCheckbox',
                    'criteria',
                    array(
                        'label' => 'Choose from below the content show in this widget.',
                        'multiOptions' => array(
                            'owner' => 'Created By',
                            'creationDate' => 'Created On',
                            'categories' => 'Category',
                            'tag' => 'tags',
                            'like' => 'Like Counts',
                            'comment' => 'Comment Counts',
                            'favourite' => 'Favourites Counts',
                            'view' => 'View Counts',
                            'follow' => 'Follow Counts',
                            'member' => 'Members Count',
                        ),
                    )
                ),
            )
        ),
    ),
    array(
        'title' => 'SES - Business Directories - Business Profile - Profile Options',
        'description' => 'Displays a menu of options (Edit, Report, Join, etc.) that can be performed on a Business on its View Page. You can enable disable any option from the Admin Panel >> Menu Editor.',
        'category' => 'SES - Business Directories - Business Profile',
        'type' => 'widget',
        'name' => 'sesbusiness.profile-options',
        'requirements' => array(
            'subject' => business,
        ),
    ),
    array(
        'title' => 'SES - Business Directories - Business Profile - Members',
        'description' => 'Displays a business’s members on it’s profile.',
        'category' => 'SES - Business Directories - Business Profile',
        'type' => 'widget',
        'name' => 'sesbusiness.profile-members',
        'requirements' => array(
            'subject' => business,
        ),
    ),
    array(
        'title' => "SES - Business Directories - Business Profile -  Owner's Photo",
        'description' => 'Displays the photo of the owner of the Business. This widget should be placed on the "Business  - Business View Page".',
        'category' => 'SES - Business Directories - Business Profile',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesbusiness.owner-photo',
        'defaultParams' => array(
            'title' => '',
        ),
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'showTitle',
                    array(
                        'label' => 'Member\'s Name',
                        'multiOptions' => array(
                            '1' => 'Yes',
                            '0' => 'No'
                        ),
                        'value' => 1,
                    )
                ),
            )
        ),
    ),
    array(
        'title' => 'SES - Business Directories - Business Directory of the Day',
        'description' => 'This widget displays Business Directory of the day. If there are more than 1 business directories marked as "of the day", then those will show randomly on each page refresh in this widget.',
        'category' => 'SES - Business Directories',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesbusiness.business-of-day',
        'adminForm' => 'Sesbusiness_Form_Admin_BusinessOfTheDay',
        'defaultParams' => array(
            'title' => 'Business of the Day',
        ),
    ),
    array(
        'title' => 'SES - Business Directories - Business Profile - Breadcrumb for Business View Page',
        'description' => 'Displays Breadcrumb for the pages. This widget should be placed on "Business - Business View Page".',
        'category' => 'SES - Business Directories - Business Profile',
        'autoEdit' => true,
        'type' => 'widget',
        'name' => 'sesbusiness.breadcrumb',
    ),
    array(
        'title' => 'SES - Business Directories - Business Profile - Like Button',
        'description' => 'Displays Like button on the business using which users will be able to add current business to their Like lists. This widget should be placed on "Businesses - Business View Page".',
        'category' => 'SES - Business Directories - Business Profile',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesbusiness.like-button',
        'defaultParams' => array(
        ),
    ),
    array(
        'title' => 'SES - Business Directories - Business Profile - Favorite Button',
        'description' => 'Displays Favorite button on the business using which users will be able to add current business to their Favorite lists. This widget should be placed on "Businesses - Business View Page".',
        'category' => 'SES - Business Directories - Business Profile',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesbusiness.favourite-button',
        'defaultParams' => array(
        ),
    ),
    array(
        'title' => 'SES - Business Directories - Business Profile - Follow Button',
        'description' => 'Displays Follow button on the business using which users will be able to Follow current business. This widget should be placed on "Business - Business View Page".',
        'category' => 'SES - Business Directories - Business Profile',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesbusiness.follow-button',
        'defaultParams' => array(
        ),
    ),
    array(
        'title' => 'SES - Business Directories - You May Also Like Business Directories',
        'description' => 'Displays the business directories which the current user viewing the widget may like.',
        'category' => 'SES - Business Directories',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesbusiness.you-may-also-like-businesses',
        'defaultParams' => array(
            'title' => '',
        ),
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'viewType',
                    array(
                        'label' => 'View Type',
                        'multiOptions' => array(
                            'listView' => 'List View',
                            'gridview' => 'Grid View'
                        ),
                        'value' => 'gridview',
                    )
                ),
                array(
                    'Select',
                    'category_id',
                    array(
                        'label' => 'Choose the category.',
                        'multiOptions' => $categories
                    ),
                    'value' => ''
                ),
                $seslocation,
                array(
                    'MultiCheckbox',
                    'information',
                    array(
                        'label' => 'Choose from below the details that you want to show for pages in this widget.',
                        'multiOptions' => array(
                            "title" => "Business Directory Title",
                            "by" => "Owner Name",
                            "ownerPhoto" => "Owner Photo",
                            "category" => "Category",
                           // 'price' => 'Price',
                            "description" => "Description",
                            "location" => "Location",
                            'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                            'contactButton' => 'Contact Button',
                            'contactDetail' => 'Contact Details',
                            'likeButton' => 'Like Button',
                            'favouriteButton' => 'Favourite Button',
                            'followButton' => 'Follow Button',
                            'joinButton' => 'Join Button',
                            'member' => 'Members Count',
                            'like' => 'Likes Count',
                            'comment' => 'Comments Count',
                            'favourite' => 'Favourites Count',
                            'rating' => 'Rating Star(Note: This setting will work only when business review extension enabled on your website.)',
                            'review' => 'Review Count (Note: This setting will work only when you have installed business review extension on your website.)',
                            'view' => 'Views Count',
                            'follow' => 'Follow Counts',
                            'featuredLabel' => 'Featured Label',
                            'sponsoredLabel' => 'Sponsored Label',
                            'verifiedLabel' => 'Verified Label',
                            'hotLabel' => 'Hot Label',
                        ),
                        'escape' => false,
                    ),
                ),
                $titleTruncation,
                $socialshare_enable_plusicon,
                $socialshare_icon_limit,
                array(
                    'Text',
                    'height',
                    array(
                        'label' => 'Enter the height of one block (in pixels).',
                        'value' => '230',
                    )
                ),
                array(
                    'Text',
                    'width',
                    array(
                        'label' => 'Enter the width of one block (in pixels).',
                        'value' => '260',
                    )
                ),
                array(
                    'Text',
                    'limit_data',
                    array(
                        'label' => 'Count (number of pages to show)',
                        'value' => 3,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        ),
                    )
                ),
            )
        ),
    ),
    array(
        'title' => 'SES - Business Directories - Business Profile - People Who Acted on This Page',
        'description' => 'This widget displays People who Liked / Followed or added current business as Favourite. This widget should be placed on "Businesses - Business View Page".',
        'category' => 'SES - Business Directories - Business Profile',
        'type' => 'widget',
        'name' => 'sesbusiness.recent-people-activity',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'MultiCheckbox',
                    'criteria',
                    array(
                        'label' => 'Choose from below the options that you want to show in this widget.',
                        'multiOptions' =>
                        array(
                            'like' => 'People who Liked this business',
                            'favourite' => 'People who added this business as Favourite',
                            'follow' => 'People who Followed this business',
                        ),
                    ),
                ),
                array(
                    'Text',
                    'height',
                    array(
                        'label' => 'Enter the height of member profile photo',
                        'value' => 70,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                array(
                    'Text',
                    'width',
                    array(
                        'label' => 'Enter the width of member profile photo',
                        'value' => 70,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                array(
                    'Text',
                    'view_more_like',
                    array(
                        'label' => 'Enter the number of members to be shown in "People Who Liked This Business" block. After the number of members entered below, option to view more members in popup will be shown.',
                        'value' => 3,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                array(
                    'Text',
                    'view_more_favourite',
                    array(
                        'label' => 'Enter the number of members to be shown in "People Who Favorited This Business" block. After the number of members entered below, option to view more members in popup will be shown.',
                        'value' => 3,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                array(
                    'Text',
                    'view_more_follow',
                    array(
                        'label' => 'Enter the number of members to be shown in "People who added this business as Favourite" block. After the number of members entered below, option to view more members in popup will be shown. ',
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
        'title' => 'SES - Business Directories - Recently Viewed Business Directories',
        'description' => 'Displays business directories which are viewed by current member / by his friends (if logged in) / by all members of your website. Edit this widget to configure various settings.',
        'category' => 'SES - Business Directories',
        'type' => 'widget',
        'name' => 'sesbusiness.recently-viewed-item',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'viewType',
                    array(
                        'label' => "View Type.",
                        'multiOptions' => array(
                            'list' => 'List View [Supported when placed in sidebar only.]',
                            'grid' => 'Grid View',
                            'advgrid' => 'Advanced Grid View',
                            'pinboard' => 'Pinboard View',
                        ),
                    )
                ),
                array(
                    'Select',
                    'category_id',
                    array(
                        'label' => 'Choose the category.',
                        'multiOptions' => $categories
                    ),
                    'value' => ''
                ),
                $seslocation,
                array(
                    'Select',
                    'criteria',
                    array(
                        'label' => 'Display Criteria',
                        'multiOptions' =>
                        array(
                            'by_me' => 'Viewed by current member',
                            'by_myfriend' => 'Viewed by current logged-in member\'s friend',
                            'on_site' => 'Viewed by all members of website'
                        ),
                    ),
                ),
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show for business directories in this widget.",
                        'multiOptions' => array(
                            'title' => 'Business Directory Title',
                            'by' => 'Owner Name',
                            'ownerPhoto' => 'Owner Photo',
                            'creationDate' => 'Created On',
                            'category' => 'Category',
                            //'price' => 'Price',
                            'status' => 'Business Status (Open/ Closed)',
                            'description' => 'Description (Not supported with List View)',
                            'location' => 'Location',
                            'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                            'contactButton' => 'Contact Button',
                            'contactDetail' => 'Contact Details',
                            'likeButton' => 'Like Button',
                            'favouriteButton' => 'Favourite Button',
                            'followButton' => 'Follow Button',
                            'joinButton' => 'Join Button',
                            'member' => 'Members Count',
                            'like' => 'Likes Count',
                            'comment' => 'Comments Count',
                            'favourite' => 'Favourites Count',
                            'rating' => 'Rating Star(Note: This setting will work only when business review extension enabled on your website.)',
                            'review' => 'Review Count (Note: This setting will work only when you have installed business review extension on your website.)',
                            'view' => 'Views Count',
                            'follow' => 'Follow Counts',
                            'featuredLabel' => 'Featured Label',
                            'sponsoredLabel' => 'Sponsored Label',
                            'verifiedLabel' => 'Verified Label',
                            'hotLabel' => 'Hot Label',
                        ),
                        'escape' => false,
                    )
                ),
                $socialshare_enable_plusicon,
                $socialshare_icon_limit,
                $titleTruncation,
                array(
                    'Text',
                    'description_truncation',
                    array(
                        'label' => 'Enter Description truncation limit. (Not supported in List View)
',
                        'value' => 45,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                array(
                    'Text',
                    'height',
                    array(
                        'label' => 'Enter the height of one block in List, Grid & Advanced Grid View (in pixels).',
                        'value' => '180',
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                array(
                    'Text',
                    'width',
                    array(
                        'label' => 'Enter the width of one block in List, Grid & Advanced Grid View (in pixels).',
                        'value' => '180',
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                array(
                    'Text',
                    'width_pinboard',
                    array(
                        'label' => 'Enter the width of one block in Pinboard View (in pixels).',
                        'value' => '300',
                    )
                ),
                array(
                    'Text',
                    'limit_data',
                    array(
                        'label' => 'Count (number of businesses to show.)',
                        'value' => 20,
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
        'title' => 'SES - Business Directories - Browse Businesses Locations',
        'description' => 'Displays all the browse businesses based on locations on the page in different views.',
        'category' => 'SES - Business Directories',
        'type' => 'widget',
        'name' => 'sesbusiness.browse-locations-businesses',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'category_id',
                    array(
                        'label' => 'Choose the category.',
                        'multiOptions' => $categories
                    ),
                    'value' => ''
                ),
                $seslocation,
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show for businesses in this widget.",
                        'multiOptions' => array(
                          'title' => 'Business Title',
                          'description' => 'Description',
                          'ownerPhoto' => 'Owner\'s Photo',
                          'by' => 'Owner\'s Name',
                          'creationDate' => 'Created On',
                          'category' => 'Category',
                          //'price' => 'Price',
                          'location' => 'Location',
                          'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                          'contactDetail' => 'Contact Details',
                          'likeButton' => 'Like Button',
                          'favouriteButton' => 'Favourite Button',
                          'followButton' => 'Follow Button',
                          'joinButton' => 'Join Button',
                          'contactButton' => 'Contact Button',
                          'like' => 'Likes Count',
                          'comment' => 'Comments Count',
                          'favourite' => 'Favourite Count',
                          'rating' => 'Rating Star(Note: This setting will work only when business review extension enabled on your website.)',
                          'review' => 'Review Count (Note: This setting will work only when you have installed business review extension on your website.)',
                          'view' => 'Views Count',
                          'follow' => 'Follow Counts',
                          'member' => 'Members Count',
                          'statusLabel' => 'Status Label [Open/ Closed]',
                          'featuredLabel' => 'Featured Label',
                          'sponsoredLabel' => 'Sponsored Label',
                          'verifiedLabel' => 'Verified Label',
                          'hotLabel' => 'Hot Label',
                        ),
                        'escape' => false,
                    )
                ),
                array(
                    'Select',
                    'show_item_count',
                    array(
                        'label' => 'Do you want to show business count in this widget?',
                        'multiOptions' => array(
                            '1' => 'Yes',
                            '0' => 'No',
                        ),
                        'value' => '0',
                    ),
                ),
                array(
                    'Text',
                    'height',
                    array(
                        'label' => 'Enter the height of main photo block in List Views (in pixels).',
                        'value' => '230',
                    )
                ),
                array(
                    'Text',
                    'width',
                    array(
                        'label' => 'Enter the width of main photo block in List Views (in pixels).',
                        'value' => '260',
                    )
                ),
                $titleTruncationList,
                $descriptionTruncationList,
                array(
                    'Text',
                    'limit_data_list',
                    array(
                        'label' => 'Count for List Views (number of businesses to show).',
                        'value' => 20,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                $socialshare_enable_plusicon,
                $socialshare_icon_limit,
                $pagging
            ),
        ),
        'requirements' => array(
            'no-subject',
        ),
    ),
    array(
        'title' => 'SES - Business Directories - Business Profile - Tags',
        'description' => 'Displays all the tags of the current business on the "Business - Business View Page".',
        'category' => 'SES - Business Directories - Business Profile',
        'type' => 'widget',
        'name' => 'sesbusiness.profile-tags',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'Text',
                    'itemCountPerPage',
                    array(
                        'label' => 'Count (number of tags to show).',
                        'value' => 30,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        ),
                    ),
                ),
            ),
        ),
    ),
    array(
        'title' => 'SES - Business Directories - Popular Businesses Slideshow - Businesses with Content',
        'description' => "Displays slideshow of businesses with content on 1 side based on chosen criteria for this widget. The placement of this widget depends on the criteria chosen for this widget.",
        'category' => 'SES - Business Directories',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesbusiness.featured-sponsored-verified-hot-slideshow',
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'category_id',
                    array(
                        'label' => 'Choose the category.',
                        'multiOptions' => $categories
                    ),
                    'value' => ''
                ),
                $seslocation,
                array(
                    'Select',
                    'criteria',
                    array(
                        'label' => "Display Content",
                        'multiOptions' => array(
                            '5' => 'All Businesses',
                            '1' => 'Only Featured',
                            '2' => 'Only Sponsored',
                            '6' => 'Only Verified',
                            '7' => 'Only Hot',
                            '3' => 'Both Featured and Sponsored',
                            '4' => 'All except Featured and Sponsored',
                        ),
                        'value' => 5,
                    )
                ),
                array(
                    'Select',
                    'info',
                    array(
                        'label' => 'Choose Popularity Criteria.',
                        'multiOptions' => array(
                            "creation_date" => "Most Recent",
                            "most_liked" => "Most Liked",
                            "most_viewed" => "Most Viewed",
                            "most_commented" => "Most Commented",
                            "favourite_count" => "Most Favorited",
                            "follow_count" => "Most Followed",
                        )
                    ),
                    'value' => 'creation_date',
                ),
                array(
                    'Select',
                    'isfullwidth',
                    array(
                        'label' => 'Do you want to show slideshow in full width?',
                        'multiOptions' => array(
                            1 => 'Yes',
                            0 => 'No'
                        ),
                        'value' => 1,
                    )
                ),
                array(
                    'Select',
                    'autoplay',
                    array(
                        'label' => "Do you want to enable autoplay of businesses?",
                        'multiOptions' => array(
                            1 => 'Yes',
                            0 => 'No'
                        ),
                    ),
                ),
                array(
                    'Text',
                    'speed',
                    array(
                        'label' => 'Delay time for next business when you have enabled autoplay.',
                        'value' => '2000',
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                array(
                    'Select',
                    'navigation',
                    array(
                        'label' => "Do you want to show buttons or circles to navigate to next slide.",
                        'multiOptions' => array(
                            'nextprev' => 'Show buttons',
                            'buttons' => 'Show circle'
                        ),
                    ),
                ),
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show for businesses in this widget.",
                        'multiOptions' => array(
                            'title' => 'Business Title',
                            'description' => 'Description',
                        ),
                        'escape' => false,
                    )
                ),
                $titleTruncation,
                $descriptionTruncation,
                array(
                    'Text',
                    'height',
                    array(
                        'label' => 'Enter the height of one slide block (in pixels).',
                        'value' => '400',
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                array(
                    'Text',
                    'limit_data',
                    array(
                        'label' => 'Count (number of businesses to show).',
                        'value' => 5,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
            )
        ),
    ),
    array(
        'title' => 'SES - Business Directories - Popular 3 Businesses View',
        'description' => 'Displays businesses in attractive view based on the chosen criteria in this widget. The placement of this widget is based on the criteria chosen. In this widget only 3 businesses will show attractively.',
        'category' => 'SES - Business Directories',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesbusiness.featured-sponsored-verified-hot-random-business',
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'category_id',
                    array(
                        'label' => 'Choose the category.',
                        'multiOptions' => $categories
                    ),
                    'value' => ''
                ),
                $seslocation,
                array(
                    'Select',
                    'criteria',
                    array(
                        'label' => "Display Content",
                        'multiOptions' => array(
                            '5' => 'All Businesses',
                            '1' => 'Only Featured',
                            '2' => 'Only Sponsored',
                            '6' => 'Only Verified',
                            '3' => 'Both Featured and Sponsored',
                            '4' => 'All except Featured and Sponsored',
                        ),
                        'value' => 5,
                    )
                ),
                array(
                    'Select',
                    'order_content',
                    array(
                        'label' => 'Choose Popularity Criteria.',
                        'multiOptions' => array(
                            "creation_date" => "Most Recent",
                            "most_liked" => "Most Liked",
                            "most_viewed" => "Most Viewed",
                            "most_commented" => "Most Commented",
                            "favourite_count" => "Most Favorited",
                            "follow_count" => "Most Followed",
                        )
                    ),
                    'value' => 'creation_date',
                ),
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show for businesses in this widget.",
                        'multiOptions' => array(
                          'title' => 'Business Title',
                          'ownerPhoto' => 'Owner\'s Photo',
                          'by' => 'Owner\'s Name',
                          'creationDate' => 'Created On',
                          'category' => 'Category',
                          //'price' => 'Price',
                          'location' => 'Location',
                          'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                          'contactDetail' => 'Contact Details',
                          'likeButton' => 'Like Button',
                          'favouriteButton' => 'Favourite Button',
                          'followButton' => 'Follow Button',
                          'joinButton' => 'Join Button',
                          'contactButton' => 'Contact Button',
                          'like' => 'Likes Count',
                          'comment' => 'Comments Count',
                          'favourite' => 'Favourite Count',
                          'rating' => 'Rating Star(Note: This setting will work only when business review extension enabled on your website.)',
                          'review' => 'Review Count (Note: This setting will work only when you have installed business review extension on your website.)',
                          'member' => 'Members Count',
                          'view' => 'Views Count',
                          'follow' => 'Follow Counts',
                          'statusLabel' => 'Status Label [Open/ Closed]',
                          'featuredLabel' => 'Featured Label',
                          'sponsoredLabel' => 'Sponsored Label',
                          'verifiedLabel' => 'Verified Label',
                          'hotLabel' => 'Hot Label',
                        ),
                        'escape' => false,
                    )
                ),
                $socialshare_enable_plusicon,
                $socialshare_icon_limit,
                $titleTruncation,
                $descriptionTruncation,
                array(
                    'Text',
                    'height',
                    array(
                        'label' => 'Enter the height of one block (in pixels).',
                        'value' => '160',
                    )
                ),
            ),
        ),
    ),
    array(
        'title' => 'SES - Business Directories - Popular Business Directories',
        'description' => "Displays business directories based on the chosen criteria in this widget. The placement of this widget depend upon the criteria chosen.",
        'category' => 'SES - Business Directories',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesbusiness.featured-sponsored-hot',
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'viewType',
                    array(
                        'label' => "Choose the View Type.",
                        'multiOptions' => array(
                            'list' => 'List View [Supported when placed in sidebar only.]',
                            'horrizontallist' => 'Horizontal List View',
                            'grid' => 'Grid View',
                            'advgrid' => 'Advanced Grid View',
                            'pinboard' => 'Pinboard View',
                        ),
                    )
                ),
                array(
                    'Select',
                    'order',
                    array(
                        'label' => 'Choose criteria for pages to be show in this widget.',
                        'multiOptions' => array(
                            '' => 'All Business Directories',
                            'open' => 'Open',
                            'close' => 'Close',
                        ),
                        'value' => '',
                    )
                ),
                array(
                    'Select',
                    'category_id',
                    array(
                        'label' => 'Choose the category.',
                        'multiOptions' => $categories
                    ),
                    'value' => ''
                ),
                $seslocation,
                array(
                    'Select',
                    'criteria',
                    array(
                        'label' => "Display Content",
                        'multiOptions' => array(
                            '5' => 'All Businesses',
                            '1' => 'Only Featured',
                            '2' => 'Only Sponsored',
                            '6' => 'Only Verified',
                            '7' => 'Only Hot',
                            '3' => 'Both Featured and Sponsored',
                            '4' => 'All except Featured and Sponsored',
                        ),
                        'value' => 5,
                    )
                ),
                array(
                    'Select',
                    'info',
                    array(
                        'label' => 'Choose Popularity Criteria.',
                        'multiOptions' => array(
                            "recently_created" => "Most Recent",
                            "most_liked" => "Most Liked",
                            "most_commented" => "Most Commented",
                            "most_viewed" => "Most Viewed",
                            "favourite_count" => "Most Favorited",
                            "follow_count" => "Most Followed",
                            "member_count" => "Most Joined",
                        )
                    ),
                    'value' => 'recently_created',
                ),
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show for pages in this widget.",
                        'multiOptions' => array(
                            'title' => 'Business Directory Title',
                            'by' => 'Owner Name',
                            'ownerPhoto' => 'Owner Photo (Not supported with Grid View and List View)',
                            'creationDate' => 'Created On',
                            'category' => 'Category',
                            'status' => 'Business Directory Status (Open / Closed)',
                            'description' => 'Description',
                            'location' => 'Location',
                            'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                            'contactDetail' => 'Contact Details',
                            'likeButton' => 'Like Button',
                            'favouriteButton' => 'Favourite Button',
                            'followButton' => 'Follow Button',
                            'joinButton' => 'Join Button',
                            'like' => 'Likes Count (Not supported with Advanced Grid View)',
                            'comment' => 'Comments Count (Not supported with Advanced Grid View)',
                            'favourite' => 'Favourites Count (Not supported with Advanced Grid View)',
                            'rating' => 'Rating Star(Note: This setting will work only when business review extension enabled on your website.)',
                          'review' => 'Review Count (Note: This setting will work only when you have installed business review extension on your website.)',
                            'view' => 'Views Count (Not supported with Advanced Grid View)',
                            'follow' => 'Follow Counts(Not supported with Advanced Grid View)',
                            'member' => 'Members Count(Not supported with Advanced Grid View)',
                            'featuredLabel' => 'Featured Label',
                            'sponsoredLabel' => 'Sponsored Label',
                            'verifiedLabel' => 'Verified Label',
                            'hotLabel' => 'Hot Label',
                        ),
                        'escape' => false,
                    )
                ),
                $socialshare_enable_plusicon,
                $socialshare_icon_limit,
                $titleTruncation,
                $descriptionTruncation,
                array(
                    'Text',
                    'width_pinboard',
                    array(
                        'label' => 'Enter the width of one block in Pinboard View (in pixels).',
                        'value' => '300',
                    )
                ),
                array(
                    'Text',
                    'height',
                    array(
                        'label' => 'Enter the height of one block in List, Grid and Advanced Grid View (in pixels).',
                        'value' => '160',
                    )
                ),
                array(
                    'Text',
                    'width',
                    array(
                        'label' => 'Enter the width of one block in List, Grid and Advanced Grid View (in pixels).',
                        'value' => '250',
                    )
                ),
                array(
                    'Text',
                    'limit_data',
                    array(
                        'label' => 'Count for (number of pages to show).',
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
        'title' => 'SES - Business Directories - Popular Business Directories Carousel',
        'description' => "Displays business directories in attractive carousel based on the chosen criteria in this widget. The placement of this widget is based on the criteria chosen.",
        'category' => 'SES - Business Directories',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesbusiness.featured-sponsored-carousel',
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'viewType',
                    array(
                        'label' => "View Type",
                        'multiOptions' => array(
                            'horizontal' => 'Horizontal',
                            'vertical' => 'Vertical',
                        ),
                        'value' => 'horizontal',
                    ),
                ),
                array(
                    'Select',
                    'order',
                    array(
                        'label' => 'Choose criteria for pages to be show in this widget.',
                        'multiOptions' => array(
                            '' => 'All Business Directories',
                            'open' => 'Open',
                            'close' => 'Close',
                        ),
                        'value' => '',
                    )
                ),
                array(
                    'Select',
                    'category_id',
                    array(
                        'label' => 'Choose the category.',
                        'multiOptions' => $categories
                    ),
                    'value' => ''
                ),
                $seslocation,
                array(
                    'Select',
                    'criteria',
                    array(
                        'label' => "Display Content",
                        'multiOptions' => array(
                            '5' => 'All Businesses',
                            '1' => 'Only Featured',
                            '2' => 'Only Sponsored',
                            '6' => 'Only Verified',
                            '7' => 'Only Hot',
                            '3' => 'Both Featured and Sponsored',
                            '4' => 'All except Featured and Sponsored',
                        ),
                        'value' => 5,
                    )
                ),
                array(
                    'Select',
                    'info',
                    array(
                        'label' => 'Choose Popularity Criteria.',
                        'multiOptions' => array(
                            "creation_date" => "Most Recent",
                            "most_liked" => "Most Liked",
                            "most_viewed" => "Most Viewed",
                            "most_commented" => "Most Commented",
                            "favourite_count" => "Most Favorited",
                            "follow_count" => "Most Followed",
                            "member_count" => "Most Joined",
                        )
                    ),
                    'value' => 'creation_date',
                ),
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show for pages in this widget.",
                        'multiOptions' => array(
                            'title' => 'Business Directory Title',
                            'by' => 'Owner Name',
                            'ownerPhoto' => 'Owner Photo',
                            'creationDate' => 'Created On',
                            'category' => 'Category',
                            'status' => 'Business Status (Open/ Closed)',
                            'description' => 'Description (Not supported with List View)',
                            'location' => 'Location',
                            'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                            'likeButton' => 'Like Button',
                            'favouriteButton' => 'Favourite Button',
                            'followButton' => 'Follow Button',
                            'joinButton' => 'Join Button',
                            'member' => 'Members Count',
                            'like' => 'Likes Count',
                            'comment' => 'Comments Count',
                            'favourite' => 'Favourites Count',
                            'rating' => 'Rating Star(Note: This setting will work only when business review extension enabled on your website.)',
                          'review' => 'Review Count (Note: This setting will work only when you have installed business review extension on your website.)',
                            'view' => 'Views Count',
                            'follow' => 'Follow Counts',
                            'featuredLabel' => 'Featured Label',
                            'sponsoredLabel' => 'Sponsored Label',
                            'verifiedLabel' => 'Verified Label',
                            'hotLabel' => 'Hot Label',
                        ),
                        'escape' => false,
                    )
                ),
                $socialshare_enable_plusicon,
                $socialshare_icon_limit,
                $titleTruncation,
                $descriptionTruncation,
                array(
                    'Text',
                    'imageheight',
                    array(
                        'label' => 'Enter the height of one block (in pixels).',
                        'value' => '180',
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                array(
                    'Text',
                    'width',
                    array(
                        'label' => 'Enter the width of one block (in pixels).',
                        'value' => '180',
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                array(
                    'Text',
                    'limit_data',
                    array(
                        'label' => 'Count (number of pages to show).',
                        'value' => 5,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
            )
        ),
    ),
    array(
        'title' => 'SES - Business Directories - Business Profile - Call To Action Button',
        'description' => 'This widget enables Business owners to add a \'Call To Action Button\' to their Businesses. This widget should be placed on the "SES - Business Directories - Business View Page" only.',
        'category' => 'SES - Business Directories - Business Profile',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesbusiness.profile-action-button',
    ),
    array(
        'title' => 'SES - Business Directories - Business Profile - Profile Tips',
        'description' => 'This widget is shown on Business View Page to display tips for creating and managing their Businesses on your website.',
        'category' => 'SES - Business Directories - Business Profile',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesbusiness.profile-tips',
        'adminForm' => array(
            'elements' => array(
                array(
                    'Text',
                    'title',
                    array(
                        'label' => "Title of this widget.",
                        'value' => "",
                    )
                ),
                array(
                    'Textarea',
                    'description',
                    array(
                        'label' => "Description of this widget.",
                        'value' => "",
                    )
                ),
                array(
                    'MultiCheckbox',
                    'types',
                    array(
                        'label' => "Choose data show in this widget.",
                        'multiOptions' => array(
                            'addLocation' => 'Add Location',
                            'addCover' => 'Add Cover',
                            'addProfilePhoto' => 'Add Profile Photo',
                        ),
                        'value' => array('addLocation', 'addCover', 'addProfilePhoto'),
                    )
                ),
            )
        )
    ),
    array(
        'title' => 'SES - Business Directories- Alphabetic Filtering of Business Directories',
        'description' => "This widget displays all the alphabets for alphabetic filtering of Business Directories. This widget should be placed on \"Business Directories Browse Page\"",
        'category' => 'SES - Business Directories',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesbusiness.business-alphabet',
        'defaultParams' => array(
            'title' => "",
        ),
    ),
    array(
        'title' => 'SES - Business Directories - Create New Business Directory Link',
        'description' => 'Displays a link to create a new business directory.',
        'category' => 'SES - Business Directories',
        'type' => 'widget',
        'name' => 'sesbusiness.browse-menu-quick',
        'autoEdit' => true,
        'requirements' => array(
            'no-subject',
        ),
        'adminForm' => array(
            'elements' => array(
                array(
                    'Radio',
                    'popup',
                    array(
                        'label' => "Do you want to show popup.",
                        'multiOptions' => array(
                            '1' => 'Yes,want to show popup',
                            '0' => 'No,don\'t want to show poup',
                        ),
                        'value' => '1',
                    )
                ),
            ),
        ),
    ),
    array(
        'title' => 'SES - Business Directories - Popular Business Directories Based on Categories',
        'description' => 'Displays business directories based on their categories in attarctive grid view, slideshow or carousel as chosen by you in this widget. Edit this widget to choose number of categories and business directories. You can configure various other settings also.',
        'category' => 'SES - Business Directories',
        'type' => 'widget',
        'autoEdit' => 'true',
        'name' => 'sesbusiness.category-associate-businesses',
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'view_type',
                    array(
                        'label' => "Choose View Type.",
                        'multiOptions' => array(
                            'grid' => 'Grid View',
                            'slideshow' => 'Slideshow',
                            'carousel' => 'Carousel',
                        ),
                        'value' => 'carousel',
                    )
                ),
                $seslocation,
                array(
                    'Select',
                    'criteria',
                    array(
                        'label' => "Choose Popularity Criteria for Categories",
                        'multiOptions' => array(
                            'most_page' => 'Categories with maximum pages first',
                            'alphabetical' => 'Alphabetical Order',
                            'admin_order' => 'Admin selected order for categories',
                        ),
                    ),
                ),
                array(
                    'Radio',
                    'popularty',
                    array(
                        'label' => 'Choose criteria for pages to be show in this widget',
                        'multiOptions' => array(
                            'all' => 'All Businesses',
                            'featured' => 'Featured',
                            'sponsored' => 'Sponsored',
                            'verified' => 'Verified',
                            'hot' => 'Hot',
                        ),
                        'value' => '',
                    )
                ),
                array(
                    'Radio',
                    'order',
                    array(
                        'label' => 'Choose Popularity Criteria for Businesses',
                        'multiOptions' => array(
                            "creation_date" => "Most Recent",
                            "like_count" => "Most Liked",
                            "comment_count" => "Most Commented",
                            "view_count" => "Most Viewed",
                            "favourite_count" => "Most Favourite",
                            "follow_count" => "Most Followed",
                        ),
                        'value' => 'like_count',
                    )
                ),
                array(
                    'MultiCheckbox',
                    'show_category_criteria',
                    array(
                        'label' => "Choose the details to be shown with each category in this widget.",
                        'multiOptions' => array(
                            'seeAll' => 'See All link',
                            'countBusiness' => 'Count of Business',
                            'categoryDescription' => 'Category Description (Supported in grid View)',
                        ),
                    )
                ),
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show for pages in this widget. (All settings are Supported in Slideshow and Carousel only.)",
                        'multiOptions' => array(
                            'title' => 'Business Directories Title',
                            'by' => 'Owner\'s Name',
                            'ownerPhoto' => 'Owner\'s Photo',
                            'creationDate' => 'Created On',
                            //'price' => 'Price',
                            'category' => 'Category',
                            'location' => 'Location',
                            'description' => 'Business Description (Supported in Slideshow)',
                            'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                            'contactButton' => 'Contact Button',
                            'contactDetail' => 'Contact Details',
                            'likeButton' => 'Like Button',
                            'favouriteButton' => 'Favourite Button',
                            'followButton' => 'Follow Button',
                            'joinButton' => 'Join Button',
                            'member' => 'Members Count',
                            'like' => 'Likes Count',
                            'comment' => 'Comments Count',
                            'favourite' => 'Favourites Count',
                            'rating' => 'Rating Star(Note: This setting will work only when business review extension enabled on your website.)',
                          'review' => 'Review Count (Note: This setting will work only when you have installed business review extension on your website.)',
                            'view' => 'Views Count',
                            'follow' => 'Follow Counts',
                            'featuredLabel' => 'Featured Label',
                            'sponsoredLabel' => 'Sponsored Label',
                            'verifiedLabel' => 'Verified Label',
                            'hotLabel' => 'Hot Label',
                        ),
                        'escape' => false,
                    )
                ),
                $pagging,
                $socialshare_enable_plusicon,
                $socialshare_icon_limit,
                array(
                    'Text',
                    'grid_description_truncation',
                    array(
                        'label' => 'Enter the Category Description truncation limit(Supported in grid View).',
                        'value' => '45',
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                $titleTruncation,
                array(
                    'Text',
                    'slideshow_description_truncation',
                    array(
                        'label' => 'Enter business description truncation limit (Supported in slideshow View).',
                        'value' => '45',
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                array(
                    'Text',
                    'height',
                    array(
                        'label' => 'Enter the height of one block (in pixels) (Supported in slideshow and carousel).',
                        'value' => '230',
                    )
                ),
                array(
                    'Text',
                    'width',
                    array(
                        'label' => 'Enter the width of one block (in pixels)(Supported in Grid View).',
                        'value' => '260',
                    )
                ),
                array(
                    'Text',
                    'category_limit',
                    array(
                        'label' => 'Count (number of categories to show)',
                        'value' => '8',
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                array(
                    'Text',
                    'page_limit',
                    array(
                        'label' => 'Count (number of pages to show in each category in this widget).',
                        'value' => '8',
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                array(
                    'Select',
                    'allignment_seeall',
                    array(
                        'label' => "Allignment of see all field",
                        'multiOptions' => array(
                            'left' => 'left',
                            'right' => 'right'
                        ),
                    ),
                ),
            )
        ),
    ),
    array(
        'title' => 'SES - Business Directories - Popular Business Directories Slideshow - Double Business Directories',
        'description' => 'This widget displays 2 types of business directories. The one section of this widget will be slideshow and the other will show 3 business directories based on the criterion chosen in this widget.',
        'category' => 'SES - Business Directories',
        'type' => 'widget',
        'name' => 'sesbusiness.businesses-slideshow',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'leftBusiness',
                    array(
                        'label' => "Do you want to enable the 3 Businesses in left side?",
                        'multiOptions' => array(
                            '1' => 'Yes',
                            '0' => 'No',
                        ),
                        'value' => 1,
                    )
                ),
                array(
                    'Select',
                    'category_id',
                    array(
                        'label' => 'Choose the category.',
                        'multiOptions' => $categories
                    ),
                    'value' => ''
                ),
                $seslocation,
                array(
                    'Select',
                    'info',
                    array(
                        'label' => 'Choose popularity criteria for the 3 pages to be displayed in left side.',
                        'multiOptions' => array(
                            "recently_created" => "Most Recent",
                            "most_liked" => "Most Liked",
                            "most_commented" => "Most Commented",
                            "most_viewed" => "Most Viewed",
                            "most_favourite" => "Most Favorited",
                            "most_followed" => "Most Followed",
                            "most_joined" => "Most Joined",
                        )
                    ),
                    'value' => 'recently_created',
                ),
                array(
                    'Select',
                    'criteria',
                    array(
                        'label' => "Display Content in left side.",
                        'multiOptions' => array(
                            '5' => 'All Businesses',
                            '1' => 'Only Featured',
                            '2' => 'Only Sponsored',
                            '6' => 'Only Verified',
                            '7' => 'Only Hot',
                            '3' => 'Both Featured and Sponsored',
                            '4' => 'All except Featured and Sponsored',
                        ),
                        'value' => 5,
                    )
                ),
                array(
                    'Select',
                    'order',
                    array(
                        'label' => 'Choose criteria for pages to be show in this widget.',
                        'multiOptions' => array(
                            '' => 'All Businesses',
                            'open' => 'Open',
                            'close' => 'Close',
                        ),
                        'value' => '',
                    )
                ),
                array(
                    'Select',
                    'enableSlideshow',
                    array(
                        'label' => "Do you want to enable the slideshow in right side?",
                        'multiOptions' => array(
                            '1' => 'Yes',
                            '0' => 'No',
                        ),
                        'value' => 1,
                    )
                ),
                array(
                    'Select',
                    'criteria_right',
                    array(
                        'label' => "Display Content for Slideshow in right side.",
                        'multiOptions' => array(
                            '5' => 'All',
                            '1' => 'Only Featured',
                            '2' => 'Only Sponsored',
                            '6' => 'Only Verified',
                            '7' => 'Only Hot',
                            '3' => 'Both Featured and Sponsored',
                            '4' => 'All except Featured and Sponsored',
                        ),
                        'value' => 5,
                    )
                ),
                array(
                    'Select',
                    'info_right',
                    array(
                        'label' => 'Choose popularity criteria for the pages to be displayed in the slideshow in right side.',
                        'multiOptions' => array(
                            "recently_created" => "Most Recent",
                            "most_liked" => "Most Liked",
                            "most_commented" => "Most Commented",
                            "most_viewed" => "Most Viewed",
                            "most_favourite" => "Most Favourited",
                            "most_followed" => "Most Followed",
                            "most_joined" => "Most Joined",
                        )
                    ),
                    'value' => 'recently_created',
                ),
                array(
                    'Select',
                    'navigation',
                    array(
                        'label' => "How do you want to allow your users to navigate to next slide?",
                        'multiOptions' => array(
                            1 => 'Using Bullets',
                            2 => 'Using Navigation Buttons'
                        ),
                    ),
                ),
                array(
                    'Select',
                    'autoplay',
                    array(
                        'label' => "Do you want to enable the autoplay of pages slideshow?",
                        'multiOptions' => array(
                            1 => 'Yes',
                            0 => 'No'
                        ),
                    ),
                ),
                $titleTruncation,
                $descriptionTruncation,
                array(
                    'Text',
                    'speed',
                    array(
                        'label' => 'Enter the delay time for the next business to be displayed in slideshow. (work if autoplay is enabled.)',
                        'value' => '2000',
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                array(
                    'Text',
                    'height',
                    array(
                        'label' => 'Enter the height of this widget.',
                        'value' => '160',
                    )
                ),
                array(
                    'Text',
                    'limit_data',
                    array(
                        'label' => 'Count (number of pages to be displayed in slideshow).',
                        'value' => 5,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                $socialshare_enable_plusicon,
                $socialshare_icon_limit,
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show for pages in this widget.",
                        'multiOptions' => array(
                            'title' => 'Business Directory Title',
                            'by' => 'Owner Name',
                            'ownerPhoto' => 'Owner Photo',
                            'creationDate' => 'Created On',
                            'category' => 'Category',
                            //'price' => 'Price',
                            'location' => 'Location',
                            'status' => 'Business Status (Open/ Closed)',
                            'description' => "Description (This will only show in the slideshow.)",
                            'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                            'contactButton' => 'Contact Button',
                            'contactDetail' => 'Contact Details',
                            'likeButton' => 'Like Button',
                            'favouriteButton' => 'Favourite Button',
                            'followButton' => 'Follow Button',
                            'joinButton' => 'Join Button',
                            'member' => 'Members Count',
                            'like' => 'Likes Count',
                            'comment' => 'Comments Count',
                            'favourite' => 'Favourites Count',
                            'rating' => 'Rating Star(Note: This setting will work only when business review extension enabled on your website.)',
                          'review' => 'Review Count (Note: This setting will work only when you have installed business review extension on your website.)',
                            'view' => 'Views Count',
                            'follow' => 'Follow Counts',
                            'featuredLabel' => 'Featured Label',
                            'sponsoredLabel' => 'Sponsored Label',
                            'verifiedLabel' => 'Verified Label',
                            'hotLabel' => 'Hot Label',
                        ),
                        'escape' => false,
                    )
                ),
            ),
        ),
    ),
    array(
        'title' => 'SES - Business Directories - Popular Categories',
        'description' => 'Displays all business directory Categories in grid and list view. This widget can be placed anywhere on the site to display business directory categories.',
        'category' => 'SES - Business Directories',
        'type' => 'widget',
        'name' => 'sesbusiness.popular-categories',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'viewType',
                    array(
                        'label' => "Categories View Type",
                        'multiOptions' => array(
                            'list' => 'List View',
                            'grid' => 'Grid View'
                        ),
                    )
                ),
                array(
                    'Select',
                    'showsubcategory',
                    array(
                        'label' => "Do you want to show sub-categories in this widget? (Works only with the List View)",
                        'multiOptions' => array(
                            1 => 'Yes',
                            0 => 'No'
                        ),
                    )
                ),
                array(
                    'MultiCheckbox',
                    'showinformation',
                    array(
                        'label' => "Choose the details to be shown for categories in this widget.",
                        'multiOptions' => array(
                            'description' => 'Category Description [Only Grid View]',
                            'caticon' => 'Category Icon [Both Grid and List View]',
                            'subcaticon' => 'Sub-category Icon [List View]',
                            'socialshare' => 'Social Share Icons [Grid View] <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>'
                        ),
                        'escape' => false,
                    )
                ),
                $socialshare_enable_plusicon,
                $socialshare_icon_limit,
                array(
                    'Select',
                    'criteria',
                    array(
                        'label' => "Choose Popularity Criteria.",
                        'multiOptions' => array(
                            'alphabetical' => 'Alphabetical order',
                            'most_faq' => 'Categories with maximum pages first',
                            'admin_order' => 'Admin selected order for categories',
                        ),
                    ),
                ),
                $descriptionTruncation,
                array(
                    'Text',
                    'mainblockheight',
                    array(
                        'label' => 'Enter the main block height for grid view (in pixels).',
                        'value' => 300,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    ),
                ),
                array(
                    'Text',
                    'mainblockwidth',
                    array(
                        'label' => 'Enter the main block width for grid view (in pixels).',
                        'value' => 250,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    ),
                ),
                array(
                    'Text',
                    'categoryiconheight',
                    array(
                        'label' => 'Enter the category icon height (in pixels).',
                        'value' => 122,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    ),
                ),
                array(
                    'Text',
                    'categoryiconwidth',
                    array(
                        'label' => 'Enter the category icon width (in pixels).',
                        'value' => 122,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    ),
                ),
                array(
                    'Text',
                    'subcaticonheight',
                    array(
                        'label' => 'Enter the sub-category icon height (in pixels).',
                        'value' => 122,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    ),
                ),
                array(
                    'Text',
                    'subcaticonwidth',
                    array(
                        'label' => 'Enter the sub-category icon width (in pixels).',
                        'value' => 122,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    ),
                ),
                array(
                    'Text',
                    'limit_data',
                    array(
                        'label' => 'Count (number of categories to show).',
                        'value' => 4,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                array(
                    'Text',
                    'limitsubcat',
                    array(
                        'label' => 'Count (number of sub-categories to show).',
                        'value' => 4,
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
        'title' => 'SES - Business Directories - Categories - Business Categories in Icons or Images',
        'description' => 'Displays all categories of business directories in circular or square view with their icons or images. Edit this widget to configure various settings.',
        'category' => 'SES - Business Directories',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesbusiness.business-category-icons',
        'adminForm' => 'Sesbusiness_Form_Admin_CategoryIcon',
    ),
    array(
        'title' => 'SES - Business Directories - Categories Cloud / Hierarchy View',
        'description' => 'Displays all categories with their 2nd and 3rd level categories in cloud view and hierachy view. In hierarchy view categories can be shown either in horizontal view or vertical view and in both the views subcategories can be shown in expanded or collapsed form according to the chosen setting. Edit this widget to make changes accordingly. ',
        'category' => 'SES - Business Directories',
        'type' => 'widget',
        'name' => 'sesbusiness.category',
        'autoEdit' => true,
        'adminForm' => 'Sesbusiness_Form_Admin_Tagcloudcategory',
    ),
    array(
        'title' => 'SES - Business Directories - Category Banner Widget',
        'description' => 'Displays a banner for categories. You can place this widget at browse page of category on your site.',
        'category' => 'SES - Business Directories',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesbusiness.banner-category',
        'adminForm' => 'Sesbusiness_Form_Admin_Categorywidget',
    ),
    array(
        'title' => 'SES - Business Directories - Category Carousel',
        'description' => 'Displays categories in a carousel. The placement criteria of this widget depends upon the chosen criteria for this widget.',
        'category' => 'SES - Business Directories',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesbusiness.category-carousel',
        'adminForm' => array(
            'elements' => array(
                $titleTruncation,
                $descriptionTruncation,
                array(
                    'Text',
                    'height',
                    array(
                        'label' => 'Enter the height of one business block (in pixels).',
                        'value' => '180',
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                array(
                    'Text',
                    'width',
                    array(
                        'label' => 'Enter the width of one business block (in pixels).',
                        'value' => '180',
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                array(
                    'Text',
                    'speed',
                    array(
                        'label' => 'Enter the delay time for next category when you have enabled autoplay.',
                        'value' => '300',
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                array(
                    'Select',
                    'autoplay',
                    array(
                        'label' => "Enables auto play of slides",
                        'multiOptions' => array(
                            1 => 'Yes',
                            0 => 'No'
                        ),
                    ),
                ),
                array(
                    'Select',
                    'criteria',
                    array(
                        'label' => "Choose Popularity Criteria.",
                        'multiOptions' => array(
                            'alphabetical' => 'Alphabetical order',
                            'most_page' => 'Categories with maximum pages first',
                            'admin_order' => 'Admin selected order for categories',
                        ),
                    ),
                ),
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show on each block.",
                        'multiOptions' => array(
                            'title' => 'Category title',
                            'description' => 'Category description',
                            'countBusinesses' => 'Business count in each category',
                            'followButton' => 'Follow Button',
                        ),
                    )
                ),
                $socialshare_enable_plusicon,
                $socialshare_icon_limit,
                array(
                    'Select',
                    'isfullwidth',
                    array(
                        'label' => 'Do you want to show category carousel in full width?',
                        'multiOptions' => array(
                            1 => 'Yes,want to show this widget in full width.',
                            0 => 'No,don\'t want to show this widget in full width.'
                        ),
                        'value' => 1,
                    )
                ),
                array(
                    'Text',
                    'limit_data',
                    array(
                        'label' => 'Count (number of category to show in this widget,put 0 for unlimited).',
                        'value' => 10,
                    )
                ),
            )
        ),
    ),
    array(
        'title' => 'SES - Business Directories - Category View Page for All Category Levels',
        'description' => 'Displays banner, 2nd-level or 3rd level categories and pages associated with the current category on its view page.',
        'category' => 'SES - Business Directories',
        'type' => 'widget',
        'name' => 'sesbusiness.category-view',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'show_subcat',
                    array(
                        'label' => "Show 2nd-level or 3rd level categories blocks.",
                        'multiOptions' => array(
                            '1' => 'Yes',
                            '0' => 'No'
                        ),
                    ),
                ),
                array('Text', "subcategory_title", array(
                        'label' => "Sub-Categories Title for pages",
                        'value' => 'Sub-Categories of this catgeory',
                    )),
                array(
                    'MultiCheckbox',
                    'show_subcatcriteria',
                    array(
                        'label' => "Choose from below the details that you want to show on each categpory block.",
                        'multiOptions' => array(
                            'title' => 'Category title',
                            'icon' => 'Category icon',
                            'countBusinesses' => 'Business count in each category',
                        ),
                    )
                ),
                array(
                    'Select',
                    'show_follow_button',
                    array(
                        'label' => "Show category follow button.",
                        'multiOptions' => array(
                            '1' => 'Yes',
                            '0' => 'No'
                        ),
                    ),
                ),
                array(
                    'Text',
                    'heightSubcat',
                    array(
                        'label' => 'Enter the height of one 2nd-level or 3rd level categor\'s block (in pixels).',
                        'value' => '160px',
                    )
                ),
                array(
                    'Text',
                    'widthSubcat',
                    array(
                        'label' => 'Enter the width of one 2nd-level or 3rd level category\'s block (in pixels).',
                        'value' => '250px',
                    )
                ),
                array('Select', "show_popular_pages", array(
                        'label' => "Do you want to show popular pages in  banner widget",
                        'multiOptions' => array('1' => 'Yes,want to show popular business', 0 => 'No,don\'t want to business popular pages'),
                        'value' => 1,
                    )),
                array('Text', "pop_title", array(
                        'label' => "Title for pages",
                        'value' => 'Popular Businesses',
                    )),
                array(
                    'Select',
                    'info',
                    array(
                        'label' => "choose criteria by which business shown in banner widget.",
                        'multiOptions' => array(
                            'creationSPdate' => 'Recently Created',
                            'mostSPviewed' => 'Most Viewed',
                            'mostSPliked' => 'Most Liked',
                            'mostSPcommented' => 'Most Commented',
                            'favouriteSPcount' => 'Most Favourite',
                            'featured' => 'Only Featured',
                            'sponsored' => 'Only Sponsored',
                            'verified' => 'Only Verified',
                            'hot' => 'Only Hot'
                        ),
                        'value' => 'creationSPdate',
                    )
                ),
                array(
                    'dummy',
                    'dummy1',
                    array(
                        'label' => "Business Settings"
                    )
                ),
                array('Text', "business_title", array(
                        'label' => "Businesses Title for pages",
                        'value' => 'Businesses of this catgeory',
                    )),
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show on each business block.",
                        'multiOptions' => array(
                            "title" => "Business Directory Title",
                            'ownerPhoto' => 'Owner\'s Photo',
                            'by' => 'Owner\'s Name',
                            'creationDate' => 'Created On',
                            'category' => 'Category',
                            'price' => 'Price',
                            'location' => 'Location',
                            'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                            'contactDetail' => 'Contact Details',
                            'likeButton' => 'Like Button',
                            'favouriteButton' => 'Favourite Button',
                            'followButton' => 'Follow Button',
                            'joinButton' => 'Join Button',
                            'contactButton' => 'Contact Button',
                            'like' => 'Likes Count',
                            'comment' => 'Comments Count',
                            'favourite' => 'Favourite Count',
                            'rating' => 'Rating Star(Note: This setting will work only when business review extension enabled on your website.)',
                            'review' => 'Review Count (Note: This setting will work only when you have installed business review extension on your website.)',
                            'member' => 'Members Count',
                            'view' => 'Views Count',
                            'follow' => 'Follow Counts',
                            'statusLabel' => 'Status Label [Open/ Closed]',
                            'featuredLabel' => 'Featured Label',
                            'sponsoredLabel' => 'Sponsored Label',
                            'verifiedLabel' => 'Verified Label',
                            'hotLabel' => 'Hot Label',
                        ),
                        'escape' => false,
                    )
                ),
                $pagging,
                array(
                    'Text',
                    'page_limit',
                    array(
                        'label' => 'count (number of pages to show).',
                        'value' => '10',
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                array(
                    'Text',
                    'height',
                    array(
                        'label' => 'Enter the height of one business block (in pixels). [Note: This setting will not affect the business blocks displayed in Advanced View.]',
                        'value' => '160px',
                    )
                ),
                array(
                    'Text',
                    'width',
                    array(
                        'label' => 'Enter the width of one business block (in pixels). [Note: This setting will not affect the business blocks displayed in Advanced View.]',
                        'value' => '160px',
                    )
                )
            )
        ),
    ),
    array(
        'title' => 'SES - Business Directories - Tags Cloud / Tab View',
        'description' => 'Displays all tags of business directories in cloud or tab view. Edit this widget to choose various other settings.',
        'category' => 'SES - Business Directories',
        'type' => 'widget',
        'name' => 'sesbusiness.tag-cloud-businesses',
        'autoEdit' => true,
        'adminForm' => 'Sesbusiness_Form_Admin_Tagcloudbusiness',
    ),
    array(
        'title' => 'SES - Business Directories - Business Profile - Photo Albums',
        'description' => 'Displays a business\'s albums on it\'s profile.',
        'category' => 'SES - Business Directories - Business Profile',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesbusiness.profile-photos',
        //'isPaginated' => true,
        'defaultParams' => array(
            'title' => 'Albums',
            'titleCount' => false,
        ),
        'requirements' => array(
            'subject' => business,
        ),
        'adminForm' => array(
            'elements' => array(
                array(
                    'Radio',
                    'load_content',
                    array(
                        'label' => "Do you want the albums to be auto-loaded when users scroll down the page?",
                        'multiOptions' => array(
                            'auto_load' => 'Yes, Auto Load.',
                            'button' => 'No, show \'View more\' link.',
                            'pagging' => 'No, show \'Pagination\'.'
                        ),
                        'value' => 'auto_load',
                    )
                ),
                array(
                    'Radio',
                    'sort',
                    array(
                        'label' => 'Choose Album Display Criteria.',
                        'multiOptions' => array(
                            "recentlySPcreated" => "Recently Created",
                            "mostSPviewed" => "Most Viewed",
                            "mostSPliked" => "Most Liked",
                            "mostSPcommented" => "Most Commented",
                        ),
                        'value' => 'most_liked',
                    )
                ),
                array(
                    'Select',
                    'insideOutside',
                    array(
                        'label' => "Choose where do you want to show the statistics of albums.",
                        'multiOptions' => array(
                            'inside' => 'Inside the Album Block',
                            'outside' => 'Outside the Album Block',
                        ),
                        'value' => 'inside',
                    )
                ),
                array(
                    'Select',
                    'fixHover',
                    array(
                        'label' => "Show album statistics Always or when users Mouse-over on album blocks (this setting will work only if you choose to show information inside the Album block.)",
                        'multiOptions' => array(
                            'fix' => 'Always',
                            'hover' => 'On Mouse-over',
                        ),
                        'value' => 'fix',
                    )
                ),
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show for albums in this widget.",
                        'multiOptions' => array(
                            'like' => 'Likes Count',
                            'comment' => 'Comments Count',
                            'view' => 'Views Count',
                            'title' => 'Album Title',
                            'by' => 'Owner\'s Name',
                            'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                            'photoCount' => 'Photos Count',
                            'likeButton' => 'Like Button',
                        ),
                        'escape' => false,
                    )
                ),
                $socialshare_enable_plusicon,
                $socialshare_icon_limit,
                array(
                    'Text',
                    'title_truncation',
                    array(
                        'label' => 'Album title truncation limit.',
                        'value' => 45,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                array(
                    'Text',
                    'limit_data',
                    array(
                        'label' => 'Count (number of albums to show.)',
                        'value' => 20,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                array(
                    'Text',
                    'height',
                    array(
                        'label' => 'Enter the height of one album block (in pixels).',
                        'value' => 200,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                array(
                    'Text',
                    'width',
                    array(
                        'label' => 'Enter the width of one album block (in pixels).',
                        'value' => 236,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
            )
        ),
    ),
    array(
        'title' => 'SES - Business Directories - Photos - Album View Page Options',
        'description' => "Album View Page",
        'category' => 'SES - Business Directories - Photos & Albums',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesbusiness.album-view-page',
        'adminForm' => 'Sesbusiness_Form_Admin_Albumviewpage',
    ),
    array(
        'title' => 'SES - Business Directories - Photo View Page Options',
        'description' => 'This widget enables you to choose various options to be shown on photo view page like Slideshow of other photos associated with same album as the current photo, etc.',
        'category' => 'SES - Business Directories - Photos & Albums',
        'type' => 'widget',
        'name' => 'sesbusiness.photo-view-page',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'Radio',
                    'criteria',
                    array(
                        'label' => 'Slideshow of other photos associated with same album?',
                        'multiOptions' =>
                        array(
                            '1' => 'Yes',
                            '0' => 'No'
                        ),
                        'value' => 1
                    ),
                ),
                array(
                    'Text',
                    'maxHeight',
                    array(
                        'label' => 'Enter the height of photo.',
                        'value' => 550,
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
        'title' => 'SES - Business Directories - Businesses Slideshow',
        'description' => "Displays Slideshow for the business created on your website. You can place this widget at any page of your choice.",
        'category' => 'SES - Business Directories',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesbusiness.slideshow',
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'category_id',
                    array(
                        'label' => 'Choose the category.',
                        'multiOptions' => $categories
                    ),
                    'value' => ''
                ),
                $seslocation,
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose options to be shown in this widget.",
                        'multiOptions' => array(
                            'title' => 'Business Title',
                            'description' => 'Description (Advanced List View)',
                            'ownerPhoto' => 'Owner\'s Photo',
                            'by' => 'Owner\'s Name',
                            'creationDate' => 'Created On',
                            'category' => 'Category',
                            //'price' => 'Price',
                            'location' => 'Location',
                            'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                            'contactDetail' => 'Contact Details',
                            'likeButton' => 'Like Button',
                            'favouriteButton' => 'Favourite Button',
                            'followButton' => 'Follow Button',
                            'joinButton' => 'Join Button[Supported in List View and Advanced List View only]',
                            'contactButton' => 'Contact Button[Supported in List View and Advanced List View only]',
                            'like' => 'Likes Count',
                            'comment' => 'Comments Count',
                            'favourite' => 'Favourite Count',
                            'rating' => 'Rating Star(Note: This setting will work only when business review extension enabled on your website.)',
                            'review' => 'Review Count (Note: This setting will work only when you have installed business review extension on your website.)',
                            'view' => 'Views Count',
                            'follow' => 'Follow Counts',
                            'member' => 'Members Count',
                            'statusLabel' => 'Status Label [Open/ Closed]',
                            'featuredLabel' => 'Featured Label',
                            'sponsoredLabel' => 'Sponsored Label',
                            'verifiedLabel' => 'Verified Label',
                            'hotLabel' => 'Hot Label',
                        ),
                        'escape' => false,
                    ),
                ),
                $socialshare_enable_plusicon,
                $socialshare_icon_limit,
                array(
                    'Text',
                    "limit_data",
                    array(
                        'label' => 'Count (number of business directories to show).',
                        'value' => 10,
                    ),
                ),
                array(
                    'Text',
                    "title_truncation",
                    array(
                        'label' => 'Title truncation limit.',
                        'value' => 45,
                    ),
                ),
                array(
                    'Text',
                    "description_truncation",
                    array(
                        'label' => 'Description truncation limit.',
                        'value' => 45,
                    ),
                ),
                array(
                    'Text',
                    "height",
                    array(
                        'label' => 'Enter the height of main photo block (in pixels).',
                        'value' => '230',
                    ),
                ),
                array(
                    'Text',
                    "width",
                    array(
                        'label' => 'Enter the width of main photo block (in pixels).',
                        'value' => '260',
                    ),
                ),
            ),
        ),
    ),
    array(
        'title' => 'SES - Business Directories - Photos - Album Browse Search',
        'description' => 'Displays a search form in the album browse page as placed by you. Edit this widget to choose the search option to be shown in the search form.',
        'category' => 'SES - Business Directories - Photos & Albums',
        'type' => 'widget',
        'name' => 'sesbusiness.browse-album-search',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
//                 array(
//                     'Radio',
//                     'search_for',
//                     array(
//                         'label' => "Choose the content for which results will be shown.",
//                         'multiOptions' => array(
//                             'album' => 'Albums',
//                             'photo' => 'Photos'
//                         ),
//                         'value' => 'album',
//                     )
//                 ),
                array(
                    'Radio',
                    'view_type',
                    array(
                        'label' => "Choose the View Type.",
                        'multiOptions' => array(
                            'horizontal' => 'Horizontal',
                            'vertical' => 'Vertical'
                        ),
                        'value' => 'vertical',
                    )
                ),
                array(
                    'MultiCheckbox',
                    'search_type',
                    array(
                        'label' => "Choose options to be shown in \'Browse By\' search fields.",
                        'multiOptions' => array(
                            'recentlySPcreated' => 'Recently Created',
                            'mostSPviewed' => 'Most Viewed',
                            'mostSPliked' => 'Most Liked',
                            'mostSPcommented' => 'Most Commented',
                            'mostSPfavourite' => 'Most Favourite',
                            'featured' => 'Only Featured',
                            'sponsored' => 'Only Sponsored'
                        ),
                    )
                ),
                array(
                    'Select',
                    'default_search_type',
                    array(
                        'label' => "Default \'Browse By\' search fields.",
                        'multiOptions' => array(
                            'recentlySPcreated' => 'Recently Created',
                            'mostSPviewed' => 'Most Viewed',
                            'mostSPliked' => 'Most Liked',
                            'mostSPcommented' => 'Most Commented',
                            'mostSPfavourite' => 'Most Favourite',
                            'featured' => 'Only Featured',
                            'sponsored' => 'Only Sponsored'
                        ),
                    )
                ),
                array(
                    'Radio',
                    'friend_show',
                    array(
                        'label' => "Show \'View\' search field?",
                        'multiOptions' => array(
                            'yes' => 'Yes',
                            'no' => 'No'
                        ),
                        'value' => 'yes',
                    )
                ),
                array(
                    'Radio',
                    'search_title',
                    array(
                        'label' => "Show \'Search Photos or Albums/Keyword\' search field?",
                        'multiOptions' => array(
                            'yes' => 'Yes',
                            'no' => 'No'
                        ),
                        'value' => 'yes',
                    )
                ),
                array(
                    'Radio',
                    'browse_by',
                    array(
                        'label' => "Show \'Browse By\' search field?",
                        'multiOptions' => array(
                            'yes' => 'Yes',
                            'no' => 'No'
                        ),
                        'value' => 'yes',
                    )
                ),
            )
        ),
    ),
    array(
        'title' => 'SES - Business Directories - Photos - Browse Albums',
        'description' => 'Display all albums on your website. The recommended page for this widget is "SES - Business Directories - Browse Albums Business".',
        'category' => 'SES - Business Directories - Photos & Albums',
        'type' => 'widget',
        'name' => 'sesbusiness.browse-albums',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                  'Radio',
                  'showdefaultalbum',
                  array(
                      'label' => "Do you want to show default album in this widget?",
                      'multiOptions' => array(
                          1 => 'Yes',
                          0 => 'No',
                      ),
                      'value' => 0,
                  )
                ),
                array(
                    'Radio',
                    'load_content',
                    array(
                        'label' => "Do you want the albums to be auto-loaded when users scroll down the page?",
                        'multiOptions' => array(
                            'auto_load' => 'Yes, Auto Load.',
                            'button' => 'No, show \'View more\' link.',
                            'pagging' => 'No, show \'Pagination\'.'
                        ),
                        'value' => 'auto_load',
                    )
                ),
                array(
                    'Radio',
                    'sort',
                    array(
                        'label' => 'Choose Album Display Criteria.',
                        'multiOptions' => array(
                            "recentlySPcreated" => "Recently Created",
                            "mostSPviewed" => "Most Viewed",
                            "mostSPliked" => "Most Liked",
                            "mostSPcommented" => "Most Commented",
                            "mostSPfavourite" => "Most Favourite",
                            'featured' => 'Only Featured',
                            'sponsored' => 'Only Sponsored'
                        ),
                        'value' => 'most_liked',
                    )
                ),
                array(
                    'Select',
                    'view_type',
                    array(
                        'label' => "Choose the View Type.",
                        'multiOptions' => array(
                            '1' => 'Grid View',
                            '2' => 'Advanced Grid View with 4 photos',
                        ),
                        'value' => '2',
                    )
                ),
                array(
                    'Select',
                    'insideOutside',
                    array(
                        'label' => "Choose where do you want to show the statistics of albums.",
                        'multiOptions' => array(
                            'inside' => 'Inside the Album Block',
                            'outside' => 'Outside the Album Block',
                        ),
                        'value' => 'inside',
                    )
                ),
                array(
                    'Select',
                    'fixHover',
                    array(
                        'label' => "Show album statistics Always or when users Mouse-over on album blocks (this setting will work only if you choose to show information inside the Album block.)",
                        'multiOptions' => array(
                            'fix' => 'Always',
                            'hover' => 'On Mouse-over',
                        ),
                        'value' => 'fix',
                    )
                ),
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show for albums in this widget.",
                        'multiOptions' => array(
                            'businessname' => "Business Name",
                            'like' => 'Likes Count',
                            'featured' => "Featured Label",
                            "sponsored" => "Sponsored Label",
                            'comment' => 'Comments Count',
                            'view' => 'Views Count',
                            'title' => 'Album Title',
                            'by' => 'Owner\'s Name',
                            'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                            'favouriteCount' => 'Favourites Count',
                            'photoCount' => 'Photos Count',
                            'likeButton' => 'Like Button',
                            'favouriteButton' => 'Favourite Button',
                        ),
                        'escape' => false,
                    //'value' => array('like','comment','view','rating','title','by','socialSharing'),
                    )
                ),
                $socialshare_enable_plusicon,
                $socialshare_icon_limit,
                array(
                    'Text',
                    'title_truncation',
                    array(
                        'label' => 'Album title truncation limit.',
                        'value' => 45,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                array(
                    'Text',
                    'limit_data',
                    array(
                        'label' => 'Count (number of albums to show.)',
                        'value' => 20,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                array(
                    'Text',
                    'height',
                    array(
                        'label' => 'Enter the height of one album block (in pixels).',
                        'value' => 200,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                array(
                    'Text',
                    'width',
                    array(
                        'label' => 'Enter the width of one album block (in pixels).',
                        'value' => 236,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
            )
        ),
    ),
    array(
        'title' => 'SES - Business Directories - Photos - Tabbed widget for Popular Albums',
        'description' => 'Displays a tabbed widget for popular albums on your website on various popularity criteria. Edit this widget to choose tabs to be shown in this widget.',
        'category' => 'SES - Business Directories - Photos & Albums',
        'type' => 'widget',
        'name' => 'sesbusiness.album-tabbed-widget',
        'autoEdit' => true,
        'adminForm' => 'Sesbusiness_Form_Admin_AlbumTabbed',
    ),
    array(
        'title' => 'SES - Business Directories - Photos - Popular Albums',
        'description' => "Displays albums as chosen by you based on chosen criteria for this widget. The placement of this widget depends on the criteria chosen for this widget.",
        'category' => 'SES - Business Directories - Photos & Albums',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesbusiness.popular-albums',
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'info',
                    array(
                        'label' => 'Choose Popularity Criteria.',
                        'multiOptions' => array(
                            "creation_date" => "Recently Created",
                            "view_count" => "Most Viewed",
                            "like_count" => "Most Liked",
                            "comment_count" => "Most Commented",
                            "favourite_count" => "Most Favourite",
                            "featured" => "Only Featured",
                            "sponsored" => "Only Sponsored",
                        )
                    ),
                    'value' => 'creation_date',
                ),
                array(
                  'Radio',
                  'showdefaultalbum',
                  array(
                      'label' => "Do you want to show default album in this widget?",
                      'multiOptions' => array(
                          1 => 'Yes',
                          0 => 'No',
                      ),
                      'value' => 0,
                  )
                ),
                array(
                    'Select',
                    'insideOutside',
                    array(
                        'label' => "Choose where do you want to show the statistics of albums.",
                        'multiOptions' => array(
                            'inside' => 'Inside the Album Block',
                            'outside' => 'Outside the Album Block',
                        ),
                        'value' => 'inside',
                    )
                ),
                array(
                    'Select',
                    'fixHover',
                    array(
                        'label' => "Show album statistics Always or when users Mouse-over on albums (this setting will work only if you choose to show information inside the Album block.)",
                        'multiOptions' => array(
                            'fix' => 'Always',
                            'hover' => 'On Mouse-over',
                        ),
                        'value' => 'fix',
                    )
                ),
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show for Albums in this widget.",
                        'multiOptions' => array(
                            'businessname' => "Business Name",
                            'featured' => "Featured Label",
                            "sponsored" => "Sponsored Label",
                            'like' => 'Likes Count',
                            'comment' => 'Comments Count',
                            'view' => 'Views Count',
                            'title' => 'Album Title',
                            'by' => 'Owner\'s Name',
                            'socialSharing' => 'Social Share Buttons<a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                            'favouriteCount' => 'Favourites Count',
                            'photoCount' => 'Photos Count',
                            'likeButton' => 'Like Button',
                            'favouriteButton' => 'Favourite Button',
                        ),
                        'escape' => false,
                    )
                ),
                $socialshare_enable_plusicon,
                $socialshare_icon_limit,
                array(
                    'Radio',
                    'view_type',
                    array(
                        'label' => "Choose the View Type.",
                        'multiOptions' => array(
                            '1' => 'Horizontal',
                            '2' => 'Vertical',
                        ),
                        'value' => 1,
                    )
                ),
                array(
                    'Text',
                    'title_truncation',
                    array(
                        'label' => 'Album title truncation limit.',
                        'value' => 45,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                array(
                    'Text',
                    'height',
                    array(
                        'label' => 'Enter the height of one album block (in pixels).',
                        'value' => '180',
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                array(
                    'Text',
                    'width',
                    array(
                        'label' => 'Enter the width of one album block (in pixels).',
                        'value' => '180',
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                array(
                    'Text',
                    'limit_data',
                    array(
                        'label' => 'Count (number of albums to show).',
                        'value' => 5,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
            )
        ),
    ),
    array(
        'title' => 'SES - Business Directories - Photos - Album Home No Album Message',
        'description' => 'Displays a message when there is no Album on your website. Edit this widget to choose for which content you want to place this widget.',
        'category' => 'SES - Business Directories - Photos & Albums',
        'type' => 'widget',
        'name' => 'sesbusiness.album-home-error',
    ),
    array(
        'title' => 'SES - Business Directories - Photos - Recently Viewed Albums',
        'description' => 'This widget displays the recently viewed albums by the user who is currently viewing your website or by the logged in members friend or by all the members of your website. Edit this widget to choose whose recently viewed content will show in this widget.',
        'category' => 'SES - Business Directories - Photos & Albums',
        'type' => 'widget',
        'name' => 'sesbusiness.recently-viewed-albums',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'criteria',
                    array(
                        'label' => 'Display Criteria',
                        'multiOptions' =>
                        array(
                            'by_me' => 'Viewed By logged-in member',
                            'by_myfriend' => 'Viewed By logged-in member\'s friend',
                            'on_site' => 'Viewed by all members of website'
                        ),
                    ),
                ),
                array(
                  'Radio',
                  'showdefaultalbum',
                  array(
                      'label' => "Do you want to show default album in this widget?",
                      'multiOptions' => array(
                          1 => 'Yes',
                          0 => 'No',
                      ),
                      'value' => 0,
                  )
                ),
                array(
                    'Select',
                    'insideOutside',
                    array(
                        'label' => "Choose where do you want to show the statistics of albums.",
                        'multiOptions' => array(
                            'inside' => 'Inside the Album Block',
                            'outside' => 'Outside the Album Block',
                        ),
                        'value' => 'inside',
                    )
                ),
                array(
                    'Select',
                    'fixHover',
                    array(
                        'label' => "Show album statistics Always or when users Mouse-over on album blocks (this setting will work only if you choose to show information inside the Album block.)",
                        'multiOptions' => array(
                            'fix' => 'Always',
                            'hover' => 'On Mouse-over',
                        ),
                        'value' => 'fix',
                    )
                ),
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show in this widget.",
                        'multiOptions' => array(
                            'businessname' => "Business Name",
                            'featured' => "Featured Label",
                            "sponsored" => "Sponsored Label",
                            'like' => 'Likes Count',
                            'comment' => 'Comments Count',
                            'view' => 'Views Count',
                            'title' => 'Album Title',
                            'by' => 'Owner\'s Name',
                            'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                            'favouriteCount' => 'Favourites Count',
                            'photoCount' => 'Photos Count',
                            'likeButton' => 'Like Button',
                            'favouriteButton' => 'Favourite Button',
                        ),
                        'escape' => false,
                    )
                ),
                $socialshare_enable_plusicon,
                $socialshare_icon_limit,
                array(
                    'Text',
                    'title_truncation',
                    array(
                        'label' => 'Album title truncation limit.',
                        'value' => 45,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                array(
                    'Text',
                    'height',
                    array(
                        'label' => 'Enter the height of one album block (in pixels).',
                        'value' => '180',
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                array(
                    'Text',
                    'width',
                    array(
                        'label' => 'Enter the width of one album block (in pixels).',
                        'value' => '180',
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                array(
                    'Text',
                    'limit_data',
                    array(
                        'label' => 'Count (number of album to show.)',
                        'value' => 20,
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
        'title' => 'SES - Business Directories - Business Profile - Business Main Photo & Vertical Tabs',
        'description' => 'This widget displays the main photo of Business and the tab container in vertical side bar. If you want to display the widgets placed in Tab Container, then you should place this widget in sidebar and configure this widget accordingly. This widget should be placed on the "SES - Business Directories - Business View page".',
        'category' => 'SES - Business Directories - Business Profile',
        'type' => 'widget',
        'name' => 'sesbusiness.profile-main-photo',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'MultiCheckbox',
                    'criteria',
                    array(
                        'label' => 'Choose from below the content show in this widget.',
                        'multiOptions' => array(
                            'photo' => 'Business Main/Profile Photo',
                            'title' => 'Business Title',
                            'businessUrl' => 'Business Custom URL',
                            'tab' => 'Business Tabs (If you choose this option, then make sure to place Tab Container widget also.)'
                        ),
                    )
                ),
            )
        ),
    ),
    array(
        'title' => 'SES - Business Directories - Business Profile - Announcements',
        'description' => 'This widget displays the announcements posted by Business Admins from their Business Dashboards. This widget should be placed on the "SES - Business Directories - Business View page".',
        'category' => 'SES - Business Directories - Business Profile',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesbusiness.profile-announcements',
        'adminForm' => array(
            'elements' => array(
                array(
                    'Text',
                    'limit_data',
                    array(
                        'label' => 'Count (number of business announcements to show)',
                        'value' => 5,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        ),
                    )
                ),
            )
        ),
    ),
    array(
        'title' => 'SES - Business Directories - Business Profile - Overview',
        'description' => 'Displays Overview of the Business on "SES - Business Directories - Business View page".',
        'category' => 'SES - Business Directories - Business Profile',
        'type' => 'widget',
        'name' => 'sesbusiness.business-overview',
        'requirements' => array(
            business,
        ),
    ),
    array(
        'title' => 'SES - Business Directories - Business Profile - Map',
        'description' => 'Displays multiple locations of Business on map on it\'s profile. This widget should be placed on the "SES - Business Directories - Business View page".',
        'category' => 'SES - Business Directories - Business Profile',
        'type' => 'widget',
        'name' => 'sesbusiness.business-map',
        'defaultParams' => array(
            'title' => 'Map',
            'titleCount' => true,
        ),
        'requirements' => array(
            'subject' => 'user',
        ),
    ),
    array(
        'title' => 'SES - Business Directories - Business Profile - Labels',
        'description' => 'Displays Featured, Sponsored , Verified and Hot labels on current business depending on the labels it has enabled from the admin panel of this plugin. This widget should be placed on "Business - Business View Page".',
        'category' => 'SES - Business Directories - Business Profile',
        'type' => 'widget',
        'name' => 'sesbusiness.business-labels',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'MultiCheckbox',
                    'option',
                    array(
                        'label' => "Choose options to be shown in this widget.",
                        'multiOptions' => array(
                            'featured' => 'Featured',
                            'sponsored' => 'Sponsored',
                            'verified' => 'Verified',
                            'hot' => 'Hot',
                        ),
                    )
                ),
            ),
        ),
    ),
    array(
        'title' => 'SES - Business Directories - Banner with AJAX Search and Categories',
        'description' => 'This widget allows you to add an attractive banner and AJAX Search to search Businesses based on their categories and locations. You can also enable Categories to be shown attractively in carousel in this widget.',
        'category' => 'SES - Business Directories',
        'type' => 'widget',
        'name' => 'sesbusiness.banner-search',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'Text',
                    'banner_title',
                    array(
                        'label' => 'Enter the title of Banner.',
                        'value' => '',
                    )
                ),
                array(
                    'Textarea',
                    'description',
                    array(
                        'label' => "Enter the description of Banner.",
                        'value' => "",
                    )
                ),
                array(
                    'Text',
                    'height_image',
                    array(
                        'label' => 'Enter the height of Banner image (in pixels).',
                        'value' => 400,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        ),
                    ),
                ),
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => 'Choose the options to be shown in the search bar in this widget.',
                        'multiOptions' => array(
                            'title' => 'Business Title',
                            'location' => 'Location',
                            'category' => 'Categories',
                        ),
                    )
                ),
                array(
                    'Radio',
                    'show_carousel',
                    array(
                        'label' => " Do you want to show categories carousel in this widget?",
                        'multiOptions' => array(
                            '1' => 'Yes',
                            '0' => 'No',
                        ),
                        'value' => 1,
                    )
                ),
                array(
                    'Text',
                    'category_carousel_title',
                    array(
                        'label' => 'Enter the Title of category carousel.',
                        'value' => '',
                    )
                ),
                array(
                    'Radio',
                    'show_full_width',
                    array(
                        'label' => "Show this widget in full width?",
                        'multiOptions' => array(
                            'yes' => 'Yes',
                            'no' => 'No'
                        ),
                        'value' => 'yes',
                    )
                ),
            ),
        ),
    ),
    array(
        'title' => 'SES - Business Directories - Photo View Page Breadcrumb',
        'description' => 'Displays breadcrumb for Photo View Page of Business. The recommended page for this is “SES - Business Directories - Photo View Page”.',
        'category' => 'SES - Business Directories - Photos & Albums',
        'type' => 'widget',
        'name' => 'sesbusiness.photo-view-breadcrumb',
        'autoEdit' => false,
    ),
    array(
        'title' => 'SES - Business Directories - Albums View Page Breadcrumb',
        'description' => 'Displays breadcrumb for Album View Page of Business. The recommended page for this is “SES - Business Directories - Album View Page”.',
        'category' => 'SES - Business Directories - Photos & Albums',
        'type' => 'widget',
        'name' => 'sesbusiness.photo-album-view-breadcrumb',
        'autoEdit' => false,
    ),
    array(
        'title' => 'SES - Business Directories - Business Profile - Associated Sub Business Details',
        'description' => 'If a Business is an Associated Sub Business, then this widget displays the details of its Create Associated Main Business and shows a label for the Business being a Associated-Business. This widget should be placed on the "SES - Business View Page"',
        'category' => 'SES - Business Directories - Business Profile',
        'type' => 'widget',
        'name' => 'sesbusiness.main-business-details',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => 'Choose the details of "Main Business" to be shown in this widget.',
                        'multiOptions' => array(
                            'businessPhoto' => 'Business Photo',
                            'title' => 'Business Title',
                            'likeButton' => 'Like Button',
                            'favouriteButton' => 'Favourite Button',
                            'followButton' => 'Follow Button',
                            'joinButton' => 'Join Button',
                        ),
                    )
                ),
            ),
        ),
    ),
//    array(
//        'title' => 'SES - Business Directories - How It Works',
//        'description' => '',
//        'category' => 'SES - Business Directories',
//        'type' => 'widget',
//        'name' => 'sesbusiness.howitworks',
//        'autoEdit' => false,
//    ),
    array(
      'title' => 'SES - Business Directories - Business Profile - Services',
      'description' => 'Displays all service created by business owner. This widget should be placed on the "SES - Business View Page".',
      'category' => 'SES - Business Directories - Business Profile',
      'type' => 'widget',
      'autoEdit' => true,
      'name' => 'sesbusiness.service',
    ),
    array(
      'title' => 'SES - Business Directories - New Claim Request Form',
      'description' => 'Displays form to make new request to claim a business. This widget should be placed on the "SES - Business Directories - New Claims Page".',
      'category' => 'SES - Business Directories - Business Profile',
      'type' => 'widget',
      'name' => 'sesbusiness.claim-business',
      'autoEdit' => true,
    ),
    array(
      'title' => 'SES - Business Directories - Browse Claim Requests',
      'description' => 'Displays all claim requests made by the current member viewing the business. The recommended page for this widget is "SES - Business Directories - Browse Claim Requests Page',
      'category' => 'SES - Business Directories - Business Profile',
      'autoEdit' => true,
      'type' => 'widget',
      'name' => 'sesbusiness.claim-requests',
      'autoEdit' => true,
    ),
    array(
        'title' => 'SES - Business Directories - businesses tags',
        'description' => 'Displays all business tags on your website. The recommended page for this widget is "SES - Advanced Business Directories - Browse Tags Page".',
        'category' => 'SES - Business Directories',
        'type' => 'widget',
        'name' => 'sesbusiness.tag-businesses',
    ),
//    array(
//			'title' => 'SES - Business Directories - How It Works',
//			'description' => '',
//			'category' => 'SES - Business Directories',
//			'type' => 'widget',
//			'name' => 'sesbusiness.howitworks',
//			'autoEdit' => false,
//    ),
);
