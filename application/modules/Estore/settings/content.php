<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: content.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
$categories = array();
if (Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.pluginactivated',0)) {
  $categories = Engine_Api::_()->getDbTable('categories', 'estore')->getCategoriesAssoc();
  $categories = array('' => '') + $categories;
}
$seslocation = array();
// if (Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('seslocation')) {
//   $seslocation = array(
//       'Radio',
//       'locationEnable',
//       array(
//           'label' => 'Do you want to show content in this widget based on the Location chosen by users on your website? (This is dependent on the “Location Based Member & Content Display Plugin”. Also, make sure location is enabled and entered for the content in this plugin. If setting is enabled and the content does not have a location, then such content will not be shown in this widget.)
// ',
//           'multiOptions' => array('1' => 'Yes', '0' => 'No'),
//           'value' => 0
//       ),
//   );
// }
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

$titleTruncationSimpleGrid = array(
    'Text',
    'simplegrid_title_truncation',
    array(
        'label' => 'Title truncation limit for Grid View.',
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
        'value' => 100,
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
        'label' => 'Description truncation limit for Grid View.',
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
        'label' => "Do you want the stores to be auto-loaded when users scroll down the page?",
        'multiOptions' => array(
            'auto_load' => 'Yes, Auto Load',
            'button' => 'Yes, show \'View more\' link.',
            'pagging' => 'Yes, show \'Pagination\'.'
        ),
        'value' => 'auto_load',
    )
);
return array(
    array(
        'title' => 'SES - Stores Marketplace - Stores Navigation Menu',
        'description' => 'Displays a navigation menu bar in the Stores pages like Browse Stores, Stores Home, Categories, etc.',
        'category' => 'SES - Stores Marketplace',
        'type' => 'widget',
        'name' => 'estore.browse-menu',
        'requirements' => array(
            'no-subject',
        ),
    ),
    array(
        'title' => 'SES - Stores Marketplace - Store Profile - Stores Liked by This Store',
        'description' => 'This widget displays other Stores which are Liked by the current Store. This widget should be placed on the "SES - Stores Marketplace - Store View page" only.',
        'category' => 'SES - Stores Marketplace - Store Profile',
        'type' => 'widget',
        'name' => 'estore.store-liked',
        'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Text',
          'limit_data',
          array(
            'label' => 'Enter Number of store to show.',
            'value' => 11,
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
                'label' => 'Enter the height of main photo block (in pixels).',
                'value' => '230',
            )
        ),
        array(
            'Text',
            'width',
            array(
                'label' => 'Enter the width of main photo block (in pixels).',
                'value' => '260',
            )
        ),
      )
    )
    ),
    array(
        'title' => 'SES - Stores Marketplace - Store Profile - Store Operating Hours',
        'description' => 'This widget displays the operating hours of a Store which are entered from its dashboard.',
        'category' => 'SES - Stores Marketplace - Store Profile',
        'type' => 'widget',
        'name' => 'estore.open-hours',
        'requirements' => array(
            'no-subject',
        ),
    ),
    array(
        'title' => 'SES - Stores Marketplace - Tabbed widget for Manage Stores',
        'description' => 'This widget displays stores created, favourite, liked, etc by the member viewing the manage store. Edit this widget to configure various settings.',
        'category' => 'SES - Stores Marketplace',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'estore.manage-stores',
        'requirements' => array(
            'subject' => store,
        ),
        'adminForm' => array(
            'elements' => array(
                  array('Select', "tabOption",
                    array(
                        'label' => 'Choose Tab Type.',
                        'multiOptions' => array(
                            'default' => 'Default',
                            'advance' => 'Advanced',
                            'filter' => 'Filter',
                            'vertical' => 'Vertical',
                            'select' => 'Dropdown',
                        ),
                        'value' => 'advance',
                    ),
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

              array('MultiCheckbox', "show_criteria",
                array(
                    'label' => "Choose from below the details that you want to show in this widget.",
                    'multiOptions' => array(
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
                        'view' => 'Views Count',
                        'follow' => 'Follow Counts',
                        'statusLabel' => 'Status Label [Open/ Closed]',
                        'featuredLabel' => 'Featured Label',
                        'sponsoredLabel' => 'Sponsored Label',
                        'verifiedLabel' => 'Verified Label',
                        'hotLabel' => 'Hot Label',
                        'newLabel' => 'New Label',
                    ),
                    'escape' => false,
                  )
                ),

                array('MultiCheckbox', "search_type",
                    array(
                    'label' => "Choose from below tabs that you want to show in this widget.",
                    'multiOptions' => array(
                        'open' => 'Open',
                        'close' => 'Closed',
                        'recentlySPcreated' => 'Recently Created',
                        'mostSPliked' => 'Most Liked',
                        'mostSPcommented' => 'Most Commented',
                        'mostSPviewed' => 'Most Viewed',
                        'mostSPfavourite' => 'Most Favorited',
                        'mostSPfollowed' => 'Most Followed',
                        'mostSPrated' => 'Most Rated',
                        'mostSPjoined' => 'Most Joined',
                        'featured' => 'Featured',
                        'sponsored' => 'Sponsored',
                        'verified' => 'Verified',
                        'hot' => 'Hot',
                    ),
                  )
                ),

                array(
                    'dummy',
                    'dummy1',
                    array(
                        'label' => "Order and Title of 'Open' Tab"
                    )
                ),
                array('Text', "open_order", array(
                    'label' => "Order of this Tab.",
                    'value' => '1',
                )),
                array('Text', "open_label", array(
                    'label' => 'Title of this Tab.',
                    'value' => 'Open',
                )),

                // setting for Most Liked
                 array(
                    'dummy',
                    'dummy2',
                    array(
                        'label' => "Order and Title of 'Close' Tab"
                    )
                ),
                array('Text', "close_order", array(
                    'label' => "Order of this Tab.",
                    'value' => '2',
                )),
                array('Text', "close_label", array(
                    'label' => 'Title of this Tab.',
                    'value' => 'Close',
                )),


                array(
                    'dummy',
                    'dummy3',
                    array(
                        'label' => "Order and Title of 'Recently Created' Tab"
                    )
                ),
                array('Text', "recentlySPcreated_order", array(
                    'label' => "Order of this Tab.",
                    'value' => '3',
                )),
                array('Text', "recentlySPcreated_label", array(
                    'label' => 'Title of this Tab.',
                    'value' => 'Recently Created',
                )),

                // setting for Most Liked
                 array(
                    'dummy',
                    'dummy4',
                    array(
                        'label' => "Order and Title of 'Most Liked' Tab"
                    )
                ),
                array('Text', "mostSPliked_order", array(
                    'label' => "Order of this Tab.",
                    'value' => '4',
                )),
                array('Text', "mostSPliked_label", array(
                    'label' => 'Title of this Tab.',
                    'value' => 'Most Liked',
                )),

                // setting for Most Commented
                array(
                    'dummy',
                    'dummy5',
                    array(
                        'label' => "Order and Title of 'Most Commented' Tab"
                    )
                ),

                array('Text', "mostSPcommented_order", array(
                    'label' => "Order of this Tab.",
                    'value' => '5',
                )),
                array('Text', "mostSPcommented_label", array(
                    'label' => 'Title of this Tab.',
                    'value' => 'Most Commented',
                )),

                // setting for Most Viewed
                array(
                    'dummy',
                    'dummy6',
                    array(
                        'label' => "Order and Title of 'Most Viewed' Tab"
                    )
                ),
                array('Text', "mostSPviewed_order", array(
                    'label' => "Order of this Tab.",
                    'value' => '6',
                )),
                array('Text', "mostSPviewed_label", array(
                    'label' => 'Title of this Tab.',
                    'value' => 'Most Viewed',
                )),

                // setting for Most Favourite
                array(
                    'dummy',
                    'dummy7',
                    array(
                        'label' => "Order and Title of 'Most Favourited' Tab"
                    )
                ),
                array('Text', "mostSPfavourite_order", array(
                    'label' => "Order of this Tab.",
                    'value' => '7',
                )),
                array('Text', "mostSPfavourite_label", array(
                    'label' => 'Title of this Tab.',
                    'value' => 'Most Favourited',
                )),

                 array(
                    'dummy',
                    'dummy8',
                    array(
                        'label' => "Order and Title of 'Most Followed' Tab"
                    )
                ),

                array('Text', "mostSPfollowed_order", array(
                    'label' => "Order of this Tab.",
                    'value' => '8',
                )),
                array('Text', "mostSPfollowed_label", array(
                    'label' => 'Title of this Tab.',
                    'value' => 'Most Followed',
                )),

                // setting for Featured
                array(
                    'dummy',
                    'dummy9',
                    array(
                        'label' => "Order and Title of 'Featured' Tab"
                    )
                ),

                array('Text', "featured_order", array(
                    'label' => "Order of this Tab.",
                    'value' => '9',
                )),
                array('Text', "featured_label", array(
                    'label' => 'Title of this Tab.',
                    'value' => 'Featured',
                )),

                // setting for Sponsored
                 array(
                    'dummy',
                    'dummy10',
                    array(
                        'label' => "Order and Title of 'Sponsored' Tab"
                    )
                ),

                array('Text', "sponsored_order", array(
                    'label' => "Order of this Tab.",
                    'value' => '10',
                )),
                array('Text', "sponsored_label", array(
                    'label' => 'Title of this Tab.',
                    'value' => 'Sponsored',
                )),

                 array(
                    'dummy',
                    'dummy11',
                    array(
                        'label' => "Order and Title of 'Verified' Tab"
                    )
                ),

                array('Text', "verified_order", array(
                    'label' => "Order of this Tab.",
                    'value' => '11',
                )),
                array('Text', "verified_label", array(
                    'label' => 'Title of this Tab.',
                    'value' => 'Verified',
                )),
                 array(
                    'dummy',
                    'dummy12',
                    array(
                        'label' => "Order and Title of 'Hot' Tab"
                    )
                ),

                 array('Text', "hot_order", array(
                    'label' => "Order of this Tab.",
                    'value' => '12',
                )),
                array('Text', "hot_label", array(
                    'label' => 'Title of this Tab.',
                    'value' => 'Hot',
                )),
            ),
        ),
    ),
    array(
        'title' => 'SES - Stores Marketplace - Tabbed Widget for Popular Stores',
        'description' => 'Displays tabbed widget for stores on your website. Edit this widget to choose and configure the tabs to be shown in this widget.',
        'category' => 'SES - Stores Marketplace',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'estore.tabbed-widget-store',
        'requirements' => array(
            'subject' => store,
        ),
        'adminForm' => 'Estore_Form_Admin_Tabbed',
    ),
    array(
        'title' => 'SES - Stores Marketplace - Browse Stores',
        'description' => 'Displays all the browsed Stores on the page in different views.',
        'category' => 'SES - Stores Marketplace',
        'type' => 'widget',
        'name' => 'estore.browse-stores',
        'autoEdit' => true,
        'adminForm' => 'Estore_Form_Admin_Browse',
        'requirements' => array(
            'no-subject',
        ),
    ),
    array(
        'title' => 'SES - Stores Marketplace - Profile Stores',
        'description' => 'Displays all the profile Stores on the page in different views.',
        'category' => 'SES - Stores Marketplace',
        'type' => 'widget',
        'name' => 'estore.profile-stores',
        'autoEdit' => true,
        'adminForm' => 'Estore_Form_Admin_Browse',
        'requirements' => array(
            'no-subject',
        ),
    ),
    array(
        'title' => 'SES - Stores Marketplace - Store Profile - Associated Sub Stores List on Main Store',
        'description' => 'Displays Associated Sub Stores on Store View page.',
        'category' => 'SES - Stores Marketplace - Store Profile',
        'type' => 'widget',
        'name' => 'estore.sub-stores',
        'autoEdit' => true,
        'adminForm' => 'Estore_Form_Admin_Browse',
        'requirements' => array(
            'no-subject',
        ),
    ),
    array(
        'title' => 'SES - Stores Marketplace - Store Profile - Associated Link Stores List on Main Store',
        'description' => 'Displays Associated Link Stores on Store View page.',
        'category' => 'SES - Stores Marketplace - Store Profile',
        'type' => 'widget',
        'name' => 'estore.link-stores',
        'autoEdit' => true,
        'adminForm' => 'Estore_Form_Admin_Browse',
        'requirements' => array(
            'no-subject',
        ),
    ),
    array(
        'title' => 'SES - Stores Marketplace - Store Profile - Cover Photo, Details & Options',
        'description' => 'Displays Cover photo of a Store. You can edit this widget to configure various settings and options to be shown in this widget. This widget should be placed on the "Stores - Store View Page"',
        'category' => 'SES - Stores Marketplace - Store Profile',
        'type' => 'widget',
        'name' => 'estore.store-view',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose options to be shown in this widget.",
                        'multiOptions' => array(
                            'title' => 'Store Title',
                            'photo' => 'Store Main Photo (only work when Store Main Photo & Vertical Tabs widget not placed same page)',
                            'by' => 'Created By',
                            'category' => 'Category',
							'creationDate' => 'Created On',
                            'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
							'price' => 'Price',
                            'likeButton' => 'Like Button',
                            'favouriteButton' => 'Favourite Button',
                            'followButton' => 'Follow Button',
                            'joinButton' => 'Join Button',
                            'messageOwner' => 'Message Owner',
                            'addButton' => 'Add a Button',
                            'like' => 'Likes Count',
                            'comment' => 'Comments Count',
                            'favourite' => 'Favourites Count',
                            'view' => 'Views Count',
                            'follow' => 'Follow Count',
                            'member' => 'Members Count',
                            'featuredLabel' => 'Featured Label',
                            'sponsoredLabel' => 'Sponsored Label',
                            'verifiedLabel' => 'Verified Label',
                            'hotLabel' => 'Hot Label',
                            'rating' => 'Rating Stars',
                            'optionMenu' => 'Profile Options Menu',
                        ),
                        'escape' => false,
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
                        'value' => 'no',
                    )
                ),
                array(
                    'Text',
                    'margin_top',
                    array(
                        'label' => 'Enter the value of the Margin Top for this widget (in pixels).',
                        'value' => 1,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        ),
                    ),
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
                 array(
                    'Text',
                    'main_photo_height',
                    array(
                        'label' => 'Enter height of main photo (in pixels)',
                        'value' => 400,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        ),
                    ),
                ),
                array(
                    'Text',
                    'main_photo_width',
                    array(
                        'label' => 'Enter width of main photo (in pixels).',
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
        'title' => 'SES - Stores Marketplace - Store Profile - Information',
        'description' => 'Displays information about the store when placed on "Stores - Store View Page".',
        'category' => 'SES - Stores Marketplace - Store Profile',
        'type' => 'widget',
        'name' => 'estore.store-info',
        'autoEdit' => true,
        'requirements' => array(
            store,
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
                            'likeCount' => 'Likes Count',
                            'viewCount' => 'Views Count',
                            'commentCount' =>'Comment Count',
                            'FavouriteCount' => 'Favourite Count',
                            'followerCount' => 'Follower Count',
                            'category' => 'Category ',
                            'contactInfo' =>'Contact Information',

                        ),
                    )
                ),
            ),
        ),
    ),
    array(
        'title' => 'SES - Stores Marketplace - Stores Browse Search',
        'description' => 'Displays search form in the Stores Browse Page. This widget should be placed on "SES - Stores Marketplace - Browse Stores Page".',
        'category' => 'SES - Stores Marketplace',
        'type' => 'widget',
        'autoEdit' => 'true',
        'name' => 'estore.browse-search',
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
                        'multiOptions' => array(
                            'recentlySPcreated' => 'Newest',
                            'mostSPviewed' => 'Most Viewed',
                            'mostSPliked' => 'Most Liked',
                            'mostSPcommented' => 'Most Commented',
                            'mostSPfavourite' => 'Most Favorited',
                            'mostSPfollower' => 'Most Followed',
                            'featured' => 'Only Featured',
                            'sponsored' => 'Only Sponsored',
                            'verified' => 'Only Verified',
                            'hot' => 'Only Hot',
                        ),
                    )
                ),
                array(
                    'Select',
                    'default_search_type',
                    array(
                        'label' => "Default value for 'Browse By' search field.",
                        'multiOptions' => array(
                            'recentlySPcreated' => 'Newest',
                            'mostSPviewed' => 'Most Viewed',
                            'mostSPliked' => 'Most Liked',
                            'mostSPcommented' => 'Most Commented',
                            'mostSPfavourite' => 'Most Favorited',
                            'mostSPfollower' => 'Most Followed',
                            'featured' => 'Only Featured',
                            'sponsored' => 'Only Sponsored',
                            'verified' => 'Only Verified',
                            'hot' => 'Only Hot',
                        ),
                    )
                ),
                array(
                    'MultiCheckbox',
                    'criteria',
                    array(
                        'label' => "Choose options to be shown in 'View' search fields.",
                        'multiOptions' => array(
                            '0' => 'All Stores',
                            '4' => 'Open Stores',
                            '5' => 'Closed Stores',
                            '1' => 'Only My Friend\'s Stores',
                            '2' => 'Only My Network Stores',
                            '3' => 'Only My Stores',
                        ),
                    )
                ),
                array(
                    'Select',
                    'default_view_search_type',
                    array(
                        'label' => "Default value for 'View' search field.",
                        'multiOptions' => array(
                            '0' => 'All Stores',
                            '4' => 'Open Stores',
                            '5' => 'Closed Stores',
                            '1' => 'Only My Friend\'s Stores',
                            '2' => 'Only My Network Stores',
                            '3' => 'Only My Stores',
                        ),
                    )
                ),
                array(
                    'MultiCheckbox',
                    'show_option',
                    array(
                        'label' => "Choose from below the search fields to be shown in this widget.",
                        'multiOptions' => array(
                            'searchStoreTitle' => 'Search Stores / Keywords',
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
                            'zip' => 'ZIP',
                            'venue' => 'Venue',
                            'closestore' => 'Include Closed Stores',
                        ),
                    )
                ),
                array(
                    'MultiCheckbox',
                    'hide_option',
                    array(
                        'label' => "Choose from below the search fields to be hidden in this widget. The selected search fields will be shown when users will click on the \"Show Advanced Settings\" link.",
                        'multiOptions' => array(
                            'searchStoreTitle' => 'Search Stores / Keywords',
                            'view' => 'View',
                            'browseBy' => 'Browse By',
                            'alphabet' => 'Alphabet',
                            'Categories' => 'Category',
                            'location' => 'Location ',
                            'miles' => 'Kilometers or Miles',
                            'country' => 'Country',
                            'state' => 'State',
                            'city' => 'City',
                            'zip' => 'ZIP',
                            'venue' => 'Venue',
                            'closestore' => 'Include Closed Stores',
                        ),
                    )
                ),
            )
        ),
    ),
    array(
        'title' => 'SES - Stores Marketplace - Store Profile - Advance Share Widget',
        'description' => 'This widget allow users to share the current page on your website and on other social networking websites.',
        'category' => 'SES - Stores Marketplace - Store Profile',
        'type' => 'widget',
        'name' => 'estore.advance-share',
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
        'title' => 'SES - Stores Marketplace - Store Profile - Info Sidebar',
        'description' => 'Displays a Store\'s info (likes creation details, stats, type, categories, etc) on their profiles. This widget should be placed in the right or left sidebar column on the "Stores - Store View Page".',
        'category' => 'SES - Stores Marketplace - Store Profile',
        'type' => 'widget',
        'name' => 'estore.profile-info',
        'requirements' => array(
            'subject' => store,
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
        'title' => 'SES - Stores Marketplace - Store Profile - Profile Options',
        'description' => 'Displays a menu of options (Edit, Report, Join, etc.) that can be performed on a Store on its View Page. You can enable disable any option from the Admin Panel >> Menu Editor.',
        'category' => 'SES - Stores Marketplace - Store Profile',
        'type' => 'widget',
        'name' => 'estore.profile-options',
        'requirements' => array(
            'subject' => store,
        ),
    ),
    array(
        'title' => 'SES - Stores Marketplace - Store Profile - Members',
        'description' => 'This widget displays members in the store.',
        'category' => 'SES - Stores Marketplace - Store Profile',
        'type' => 'widget',
        'name' => 'estore.profile-members',
        'requirements' => array(
            'subject' => store,
        ),
        'adminForm' => array(
         'elements' => array(
            array(
                'Text',
                'limit_data',
                array(
                    'label' => 'Enter the number of Members to display',
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
        'title' => "SES - Stores Marketplace - Store Profile -  Owner's Photo",
        'description' => 'Displays the photo of the owner of the Store. This widget should be placed on the "Store  - Store View Page".',
        'category' => 'SES - Stores Marketplace - Store Profile',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'estore.owner-photo',
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
        'title' => 'SES - Stores Marketplace - Store of the Day',
        'description' => 'This widget displays Store of the day. If there are more than 1 stores marked as "of the day", then those will show randomly on each page refresh in this widget.',
        'category' => 'SES - Stores Marketplace',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'estore.store-of-day',
        'adminForm' => 'Estore_Form_Admin_StoreOfTheDay',
        'defaultParams' => array(
            'title' => 'Store of the Day',
        ),
    ),
    array(
        'title' => 'SES - Stores Marketplace - Store Profile - Breadcrumb for Store View Page',
        'description' => 'Displays Breadcrumb for the pages. This widget should be placed on "Store - Store View Page".',
        'category' => 'SES - Stores Marketplace - Store Profile',
        'autoEdit' => true,
        'type' => 'widget',
        'name' => 'estore.breadcrumb',
    ),
    array(
        'title' => 'SES - Stores Marketplace - Store Profile - Like Button',
        'description' => 'Displays Like button on the store using which users will be able to add current store to their Like lists. This widget should be placed on "Stores - Store View Page".',
        'category' => 'SES - Stores Marketplace - Store Profile',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'estore.like-button',
        'defaultParams' => array(
        ),
    ),
    array(
        'title' => 'SES - Stores Marketplace - Store Profile - Favorite Button',
        'description' => 'Displays Favorite button on the store using which users will be able to add current store to their Favorite lists. This widget should be placed on "Stores - Store View Page".',
        'category' => 'SES - Stores Marketplace - Store Profile',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'estore.favourite-button',
        'defaultParams' => array(
        ),
    ),
    array(
        'title' => 'SES - Stores Marketplace - Store Profile - Follow Button',
        'description' => 'Displays Follow button on the store using which users will be able to Follow current store. This widget should be placed on "Store - Store View Page".',
        'category' => 'SES - Stores Marketplace - Store Profile',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'estore.follow-button',
        'defaultParams' => array(
        ),
    ),
    array(
        'title' => 'SES - Stores Marketplace - You May Also Like Stores',
        'description' => 'Displays the Stores which the current user viewing the widget may like.',
        'category' => 'SES - Stores Marketplace',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'estore.you-may-also-like-stores',
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
                            'title' => 'Store Title',
                            'by' => 'Owner Name',
                            'creationDate' => 'Created On',
                            'category' => 'Category',
														'featuredLabel' => 'Featured Label',
                            'sponsoredLabel' => 'Sponsored Label',
                            'verifiedLabel' => 'Verified Label',
                            'hotLabel' => 'Hot Label',
														'location' => 'Location',
                            'description' => 'Description for Grid View',
                            'socialSharing' => 'Social Share Buttons for Grid View <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                            'likeButton' => 'Like Button for Grid View',
                            'favouriteButton' => 'Favourite Button for Grid View',
														'newLabel' => 'New Store Label for Grid View',
                            'member' => 'Members Count for List View',
                            'like' => 'Likes Count for List View',
                            'comment' => 'Comments Count for List View',
                            'favourite' => 'Favourites Count for List View',
                            'view' => 'Views Count for List View',
                            'follow' => 'Follow Counts for List View',
                        ),
                        'escape' => false,
                    ),
                ),
                $socialshare_enable_plusicon,
                $socialshare_icon_limit,

                array('Text', "limit_data", array(
                    'label' => 'Count (number of Stores to show).',
                    'value' => 10,
                    'validators' => array(
                        array('Int', true),
                        array('GreaterThan', true, array(0)),
                    )
                )),

                $titleTruncationList,
                $descriptionTruncationList,

                array('Text', "height_list", array(
                    'label' => 'Enter the height of main photo block (in pixels).',
                    'value' => '230',
                )),
                array('Text', "width_list", array(
                    'label' => 'Enter the width of main photo block (in pixels).',
                    'value' => '260',
                )),

                $titleTruncationSimpleGrid,
                $descriptionTruncationSimpleGrid,
                array(
                    'Text',
                    'height_grid',
                    array(
                        'label' => 'Enter the height of photo block(in pixels).',
                        'value' => '230',
                    )
                ),
                array(
                    'Text',
                    'width_grid',
                    array(
                        'label' => 'Enter the width of photo block(in pixels).',
                        'value' => '260',
                    )
                ),
            )
        ),
    ),
    array(
        'title' => 'SES - Stores Marketplace - Store Profile - People Who Acted on This Page',
        'description' => 'This widget displays People who Liked / Followed or added current store as Favourite. This widget should be placed on "Stores - Store View Page".',
        'category' => 'SES - Stores Marketplace - Store Profile',
        'type' => 'widget',
        'name' => 'estore.recent-people-activity',
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
                            'like' => 'People who Liked this store',
                            'favourite' => 'People who added this store as Favourite',
                            'follow' => 'People who Followed this store',
                            'review' => 'People who given " Reviews & Rating " this store',
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
                        'label' => 'Enter the number of members to be shown in "People Who Liked This Store" block. After the number of members entered below, option to view more members in popup will be shown.',
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
                        'label' => 'Enter the number of members to be shown in "People Who Favorited This Store" block. After the number of members entered below, option to view more members in popup will be shown.',
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
                        'label' => 'Enter the number of members to be shown in "People who added this store as Favourite" block. After the number of members entered below, option to view more members in popup will be shown. ',
                        'value' => 3,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                array(
                    'Text',
                    'view_more_reviews',
                    array(
                        'label' => 'Enter the number of members to be shown in "Reviews & Ratings" block. After the number of members entered below, option to view more members in popup will be shown.',
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
        'title' => 'SES - Stores Marketplace - Recently Viewed Stores',
        'description' => 'Displays Stores which are viewed by current member / by his friends (if logged in) / by all members of your website. Edit this widget to configure various settings.',
        'category' => 'SES - Stores Marketplace',
        'type' => 'widget',
        'name' => 'estore.recently-viewed-item',
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
                        'label' => "Choose from below the details that you want to show for Stores in this widget.",
                        'multiOptions' => array(
                            'title' => 'Store Title',
                            'by' => 'Owner Name',
                            'creationDate' => 'Created On',
                            'category' => 'Category',
														'featuredLabel' => 'Featured Label',
                            'sponsoredLabel' => 'Sponsored Label',
                            'verifiedLabel' => 'Verified Label',
                            'hotLabel' => 'Hot Label',
														'location' => 'Location',
                            'description' => 'Description for Grid View',
                            'socialSharing' => 'Social Share Buttons for Grid View <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                            'likeButton' => 'Like Button for Grid View',
                            'favouriteButton' => 'Favourite Button for Grid View',
														'newLabel' => 'New Store Label for Grid View',
                            'member' => 'Members Count for List View',
                            'like' => 'Likes Count for List View',
                            'comment' => 'Comments Count for List View',
                            'favourite' => 'Favourites Count for List View',
                            'view' => 'Views Count for List View',
                            'follow' => 'Follow Counts for List View',
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
                        'label' => 'Enter Description truncation limit.',
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
                        'label' => 'Enter the height of one block in List, Grid View (in pixels).',
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
                        'label' => 'Enter the width of one block in List, Grid View (in pixels).',
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
                        'label' => 'Count (number of stores to show.)',
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
        'title' => 'SES - Stores Marketplace - Browse Stores Locations',
        'description' => 'Displays all the browse stores based on locations on the page in different views.',
        'category' => 'SES - Stores Marketplace',
        'type' => 'widget',
        'name' => 'estore.browse-locations-stores',
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
                        'label' => "Choose from below the details that you want to show for stores in this widget.",
                        'multiOptions' => array(
                          'title' => 'Store Title',
                          'description' => 'Description',
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
                          'view' => 'Views Count',
                          'follow' => 'Follow Counts',
                          'member' => 'Members Count',
                          'statusLabel' => 'Status Label [Open/ Closed]',
                          'featuredLabel' => 'Featured Label',
                          'sponsoredLabel' => 'Sponsored Label',
                          'verifiedLabel' => 'Verified Label',
                          'hotLabel' => 'Hot Label',
                          'rating' => 'Reviews & Rating',
                        ),
                        'escape' => false,
                    )
                ),
                array(
                    'Select',
                    'show_item_count',
                    array(
                        'label' => 'Do you want to show store count in this widget?',
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
                        'label' => 'Count for List Views (number of stores to show).',
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
        'title' => 'SES - Stores Marketplace - Store Profile - Tags',
        'description' => 'Displays all the tags of the current store on the "Store - Store View Page".',
        'category' => 'SES - Stores Marketplace - Store Profile',
        'type' => 'widget',
        'name' => 'estore.profile-tags',
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
        'title' => 'SES - Stores Marketplace - Popular Stores',
        'description' => "Displays Stores based on the chosen criteria in this widget. The placement of this widget depend upon the criteria chosen.",
        'category' => 'SES - Stores Marketplace',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'estore.featured-sponsored-hot',
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'viewType',
                    array(
                        'label' => "Choose the View Type.",
                        'multiOptions' => array(
                            'list' => 'List View [Supported when placed in sidebar only.]',
                            'grid' => 'Grid View',
                        ),
                    )
                ),
                array(
                    'Select',
                    'order',
                    array(
                        'label' => 'Choose criteria for pages to be show in this widget.',
                        'multiOptions' => array(
                            '' => 'All Stores',
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
                            '5' => 'All Stores',
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
                            'title' => 'Store Title',
                            'by' => 'Owner Name',
                            'creationDate' => 'Created On',
                            'category' => 'Category',
														'featuredLabel' => 'Featured Label',
                            'sponsoredLabel' => 'Sponsored Label',
                            'verifiedLabel' => 'Verified Label',
                            'hotLabel' => 'Hot Label',
														'location' => 'Location',
                            'description' => 'Description for Grid View',
                            'socialSharing' => 'Social Share Buttons for Grid View <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                            'likeButton' => 'Like Button for Grid View',
                            'favouriteButton' => 'Favourite Button for Grid View',
														'newLabel' => 'New Store Label for Grid View',
                            'member' => 'Members Count for List View',
                            'like' => 'Likes Count for List View',
                            'comment' => 'Comments Count for List View',
                            'favourite' => 'Favourites Count for List View',
                            'view' => 'Views Count for List View',
                            'follow' => 'Follow Counts for List View',
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
                        'label' => 'Enter the height of one block in List and Grid View (in pixels).',
                        'value' => '160',
                    )
                ),
                array(
                    'Text',
                    'width',
                    array(
                        'label' => 'Enter the width of one block in List and Grid View (in pixels).',
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
        'title' => 'SES - Stores Marketplace - Popular Stores Carousel',
        'description' => "Displays Stores in attractive carousel based on the chosen criteria in this widget. The placement of this widget is based on the criteria chosen.",
        'category' => 'SES - Stores Marketplace',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'estore.featured-sponsored-carousel',
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
                            '' => 'All Stores',
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
                            '5' => 'All Stores',
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
                            'title' => 'Store Title',
                            'by' => 'Owner Name',
                            'ownerPhoto' => 'Owner Photo',
                            'creationDate' => 'Created On',
                            'category' => 'Category',
                            'status' => 'Store Status (Open/ Closed)',
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
                            'view' => 'Views Count',
                            'follow' => 'Follow Counts',
                            'featuredLabel' => 'Featured Label',
                            'sponsoredLabel' => 'Sponsored Label',
                            'verifiedLabel' => 'Verified Label',
                            'hotLabel' => 'Hot Label',
                            'newLabel' => 'New Store Label',
                            'totalProduct' =>'Product Count & Images',
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
        'title' => 'SES - Stores Marketplace - Store Profile - Call To Action Button',
        'description' => 'This widget enables Store owners to add a \'Call To Action Button\' to their Stores. This widget should be placed on the "SES - Stores Marketplace - Store View Page" only.',
        'category' => 'SES - Stores Marketplace - Store Profile',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'estore.profile-action-button',
    ),
    array(
        'title' => 'SES - Stores Marketplace - Store Profile - Profile Tips',
        'description' => 'This widget is shown on Store View Page to display tips for creating and managing their Stores on your website.',
        'category' => 'SES - Stores Marketplace - Store Profile',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'estore.profile-tips',
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
        'title' => 'SES - Stores Marketplace - Alphabetic Filtering of Stores',
        'description' => "This widget displays all the alphabets for alphabetic filtering of Stores. This widget should be placed on \"SES - Stores Marketplace - Stores Browse Page\"",
        'category' => 'SES - Stores Marketplace',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'estore.store-alphabet',
        'defaultParams' => array(
            'title' => "",
        ),
    ),
    array(
        'title' => 'SES - Stores Marketplace - Create New Store Link',
        'description' => 'Displays a link to create a new Store.',
        'category' => 'SES - Stores Marketplace',
        'type' => 'widget',
        'name' => 'estore.browse-menu-quick',
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
        'title' => 'SES - Stores Marketplace - Popular Stores Based on Categories',
        'description' => 'Displays Stores based on their categories in attarctive grid view, slideshow or carousel as chosen by you in this widget. Edit this widget to choose number of categories and Stores. You can configure various other settings also.',
        'category' => 'SES - Stores Marketplace',
        'type' => 'widget',
        'autoEdit' => 'true',
        'name' => 'estore.category-associate-stores',
        'adminForm' => array(
            'elements' => array(
                $seslocation,
                array(
                    'Select',
                    'criteria',
                    array(
                        'label' => "Choose Popularity Criteria for Categories",
                        'multiOptions' => array(
                            'most_store' => 'Categories with maximum store first',
                            'alphabetical' => 'Alphabetical Order',
                            'admin_order' => 'Admin selected order for categories',
                        ),
                    ),
                ),
                array(
                    'Radio',
                    'popularty',
                    array(
                        'label' => 'Choose criteria for store to be show in this widget',
                        'multiOptions' => array(
                            'all' => 'All Stores',
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
                        'label' => 'Choose Popularity Criteria for Stores',
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
                            'countStore' => 'Count of Store',
                        ),
                    )
                ),
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show for pages in this widget. (All settings are Supported in Slideshow and Carousel only.)",
                        'multiOptions' => array(
                            'title' => 'Stores Title',
                            'by' => 'Owner\'s Name',
                            'creationDate' => 'Created On',
                            'category' => 'Category',
                            'location' => 'Location',
                            'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                            'likeButton' => 'Like Button',
                            'favouriteButton' => 'Favourite Button',
                            'member' => 'Members Count',
                            'like' => 'Likes Count',
                            'comment' => 'Comments Count',
                            'favourite' => 'Favourites Count',
                            'view' => 'Views Count',
                            'follow' => 'Follow Counts',
                            'featuredLabel' => 'Featured Label',
                            'sponsoredLabel' => 'Sponsored Label',
                            'verifiedLabel' => 'Verified Label',
                            'hotLabel' => 'Hot Label',
                            'newlabel' => 'New label',
                            'rating' => 'Rating Stars',
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
                        'label' => 'Enter store description truncation limit (Supported in slideshow View).',
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
                    'store_limit',
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
        'title' => 'SES - Stores Marketplace - Popular Stores Slideshow - Double Stores',
        'description' => 'This widget displays 2 types of Stores. The one section of this widget will be slideshow and the other will show 3 Stores based on the criterion chosen in this widget.',
        'category' => 'SES - Stores Marketplace',
        'type' => 'widget',
        'name' => 'estore.stores-slideshow',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'leftStore',
                    array(
                        'label' => "Do you want to enable the 3 Stores in left side?",
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
                            '5' => 'All Stores',
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
                            '' => 'All Stores',
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
                        'label' => 'Enter the delay time for the next store to be displayed in slideshow. (work if autoplay is enabled.)',
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
                            'title' => 'Store Title',
                            'by' => 'Owner Name',
                            'creationDate' => 'Created On',
                            'category' => 'Category',
                            'location' => 'Location',
                            'description' => "Description (This will only show in the slideshow.)",
                            'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                            'likeButton' => 'Like Button',
                            'favouriteButton' => 'Favourite Button',
                            'member' => 'Members Count',
                            'like' => 'Likes Count',
                            'comment' => 'Comments Count',
                            'favourite' => 'Favourites Count',
                            'view' => 'Views Count',
                            'follow' => 'Follow Counts',
                            'featuredLabel' => 'Featured Label',
                            'sponsoredLabel' => 'Sponsored Label',
                            'verifiedLabel' => 'Verified Label',
                            'hotLabel' => 'Hot Label',
                            'newlabel'=>'New Label',
                            'rating' => 'Reviews & Rating',
                        ),
                        'escape' => false,
                    )
                ),
            ),
        ),
    ),
    array(
        'title' => 'SES - Stores Marketplace - Popular Categories',
        'description' => 'Displays all Store Categories in grid and list view. This widget can be placed anywhere on the site to display Store categories.',
        'category' => 'SES - Stores Marketplace',
        'type' => 'widget',
        'name' => 'estore.popular-categories',
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
                    'MultiCheckbox',
                    'showinformation',
                    array(
                        'label' => "Choose the details to be shown for categories in this widget.",
                        'multiOptions' => array(
                            'description' => 'Category Description [Only Grid View]',
                            'caticon' => 'Category Icon [Both Grid and List View]',
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
                            'most_store' => 'Categories with maximum stores first',
                            'admin_order' => 'Admin selected order for categories',
                        ),
                    ),
                ),
                $titleTruncation,
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
                        'value' => 64,
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
                        'value' => 64,
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
            ),
        ),
    ),
    array(
        'title' => 'SES - Stores Marketplace - Categories - Store Categories in Icons or Images',
        'description' => 'Displays all categories of Stores in circular or square view with their icons or images. Edit this widget to configure various settings.',
        'category' => 'SES - Stores Marketplace',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'estore.store-category-icons',
        'adminForm' => 'Estore_Form_Admin_CategoryIcon',
    ),
    array(
        'title' => 'SES - Stores Marketplace - Categories Cloud / Hierarchy View',
        'description' => 'Displays all categories with their 2nd and 3rd level categories in cloud view and hierachy view. In hierarchy view categories can be shown either in horizontal view or vertical view and in both the views subcategories can be shown in expanded or collapsed form according to the chosen setting. Edit this widget to make changes accordingly. ',
        'category' => 'SES - Stores Marketplace',
        'type' => 'widget',
        'name' => 'estore.category',
        'autoEdit' => true,
        'adminForm' => 'Estore_Form_Admin_Tagcloudcategory',
    ),
    array(
        'title' => 'SES - Stores Marketplace - Category Banner Widget',
        'description' => 'Displays a banner for categories. You can place this widget at browse page of category on your site.',
        'category' => 'SES - Stores Marketplace',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'estore.banner-category',
        'adminForm' => 'Estore_Form_Admin_Categorywidget',
    ),
    array(
        'title' => 'SES - Stores Marketplace - Category Carousel',
        'description' => 'Displays categories in a carousel. The placement criteria of this widget depends upon the chosen criteria for this widget.',
        'category' => 'SES - Stores Marketplace',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'estore.category-carousel',
        'adminForm' => array(
            'elements' => array(
                $titleTruncation,
                $descriptionTruncation,
                array(
                    'Text',
                    'height',
                    array(
                        'label' => 'Enter the height of one store block (in pixels).',
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
                        'label' => 'Enter the width of one store block (in pixels).',
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
                            'countStores' => 'Store count in each category',
                            'followButton' => 'Follow Button',
                            'socialshare' => 'Social Share Button',
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
        'title' => 'SES - Stores Marketplace - Category View Page for All Category Levels',
        'description' => 'Displays banner, 2nd-level or 3rd level categories and pages associated with the current category on its view page.',
        'category' => 'SES - Stores Marketplace',
        'type' => 'widget',
        'name' => 'estore.category-view',
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
                            'countStores' => 'Store count in each category',
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
                array('Select', "show_popular_stores", array(
                        'label' => "Do you want to show popular stores",
                        'multiOptions' => array('1' => 'Yes,want to show popular store', 0 => 'No,don\'t want to store popular stores'),
                        'value' => 1,
                    )),
                array('Text', "pop_title", array(
                        'label' => "Title for stores",
                        'value' => 'Popular Stores',
                    )),
                array(
                    'Select',
                    'info',
                    array(
                        'label' => "choose criteria by which store shown in banner widget.",
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
                        'label' => "Store Settings"
                    )
                ),
                array('Text', "store_title", array(
                        'label' => "Stores Title for pages",
                        'value' => 'Stores of this catgeory',
                    )),
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show on each store block.",
                        'multiOptions' => array(
                            "title" => "Store Title",
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
                array(
								'Radio',
								'pagging',
								array(
								'label' => "Do you want the stores to be auto-loaded when users scroll down the page?",'multiOptions' => array(
									'button' => 'Yes, show \'View more\' link.',
									'pagging' => 'Yes, show \'Pagination\'.'
								),
							'value' => 'auto_load',
								)
							),
                array(
                    'Text',
                    'store_limit',
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
                        'label' => 'Enter the height of one store block (in pixels). [Note: This setting will not affect the store blocks displayed in Advanced View.]',
                        'value' => '160px',
                    )
                ),
                array(
                    'Text',
                    'width',
                    array(
                        'label' => 'Enter the width of one store block (in pixels). [Note: This setting will not affect the store blocks displayed in Advanced View.]',
                        'value' => '160px',
                    )
                )
            )
        ),
    ),
    array(
        'title' => 'SES - Stores Marketplace - Tags Cloud / Tab View',
        'description' => 'Displays all tags of Stores in cloud or tab view. Edit this widget to choose various other settings.',
        'category' => 'SES - Stores Marketplace',
        'type' => 'widget',
        'name' => 'estore.tag-cloud-stores',
        'autoEdit' => true,
        'adminForm' => 'Estore_Form_Admin_Tagcloudstore',
    ),
    array(
        'title' => 'SES - Stores Marketplace - Store Profile - Photo Albums',
        'description' => 'Displays a store\'s albums on it\'s profile.',
        'category' => 'SES - Stores Marketplace - Store Profile',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'estore.profile-photos',
        //'isPaginated' => true,
        'defaultParams' => array(
            'title' => 'Albums',
            'titleCount' => false,
        ),
        'requirements' => array(
            'subject' => store,
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
        'title' => 'SES - Stores Marketplace - Photos - Album View Page Options',
        'description' => "This widget displays Album View Page content.",
        'category' => 'SES - Stores Marketplace - Photos & Albums',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'estore.album-view-page',
        'adminForm' => 'Estore_Form_Admin_Albumviewpage',
    ),
    array(
        'title' => 'SES - Stores Marketplace - Photo View Page Options',
        'description' => 'This widget enables you to choose various options to be shown on photo view page like Slideshow of other photos associated with same album as the current photo, etc.',
        'category' => 'SES - Stores Marketplace - Photos & Albums',
        'type' => 'widget',
        'name' => 'estore.photo-view-page',
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
        'title' => 'SES - Stores Marketplace - Stores Slideshow',
        'description' => "Displays slideshow of stores on your website. Edit this widget to configure various settings. ",
        'category' => 'SES - Stores Marketplace',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'estore.slideshow',
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
                            'title' => 'Store Title',
                            'description' => 'Description',
                            'by' => 'Owner\'s Name',
                            'creationDate' => 'Created On',
                            'category' => 'Category',
                            'location' => 'Location',
                            'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                            'likeButton' => 'Like Button',
                            'favouriteButton' => 'Favourite Button',
                            'like' => 'Likes Count',
                            'comment' => 'Comments Count',
                            'favourite' => 'Favourite Count',
                            'view' => 'Views Count',
                            'follow' => 'Follow Counts',
                            'member' => 'Members Count',
                            'featuredLabel' => 'Featured Label',
                            'sponsoredLabel' => 'Sponsored Label',
                            'verifiedLabel' => 'Verified Label',
                            'hotLabel' => 'Hot Label',
                            'newlabel'=>'New Label',
                            'rating' => 'Review & Rating',
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
                        'label' => 'Count (number of Stores to show).',
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
            ),
        ),
    ),
    array(
        'title' => 'SES - Stores Marketplace - Photos - Album Browse Search',
        'description' => 'Displays a search form in the album browse page as placed by you. Edit this widget to choose the search option to be shown in the search form.',
        'category' => 'SES - Stores Marketplace - Photos & Albums',
        'type' => 'widget',
        'name' => 'estore.browse-album-search',
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
        'title' => 'SES - Stores Marketplace - Photos - Browse Albums',
        'description' => 'Display all albums on your website. The recommended page for this widget is "SES - Stores Marketplace - Browse Albums Store".',
        'category' => 'SES - Stores Marketplace - Photos & Albums',
        'type' => 'widget',
        'name' => 'estore.browse-albums',
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
                            'storename' => "Store Name",
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
        'title' => 'SES - Stores Marketplace - Photos - Tabbed widget for Popular Albums',
        'description' => 'Displays a tabbed widget for popular albums on your website on various popularity criteria. Edit this widget to choose tabs to be shown in this widget.',
        'category' => 'SES - Stores Marketplace - Photos & Albums',
        'type' => 'widget',
        'name' => 'estore.album-tabbed-widget',
        'autoEdit' => true,
        'adminForm' => 'Estore_Form_Admin_AlbumTabbed',
    ),
    array(
        'title' => 'SES - Stores Marketplace - Photos - Popular Albums',
        'description' => "Displays albums as chosen by you based on chosen criteria for this widget. The placement of this widget depends on the criteria chosen for this widget.",
        'category' => 'SES - Stores Marketplace - Photos & Albums',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'estore.popular-albums',
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
                            'storename' => "Store Name",
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
        'title' => 'SES - Stores Marketplace - Photos - Album Home No Album Message',
        'description' => 'Displays a message when there is no Album on your website. Edit this widget to choose for which content you want to place this widget.',
        'category' => 'SES - Stores Marketplace - Photos & Albums',
        'type' => 'widget',
        'name' => 'estore.album-home-error',
    ),
    array(
        'title' => 'SES - Stores Marketplace - Photos - Recently Viewed Albums',
        'description' => 'This widget displays the recently viewed albums by the user who is currently viewing your website or by the logged in members friend or by all the members of your website. Edit this widget to choose whose recently viewed content will show in this widget.',
        'category' => 'SES - Stores Marketplace - Photos & Albums',
        'type' => 'widget',
        'name' => 'estore.recently-viewed-albums',
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
                            'storeName' => "Store Name",
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
        'title' => 'SES - Stores Marketplace - Store Profile - Store Main Photo & Vertical Tabs',
        'description' => 'This widget displays the main photo of Store and the tab container in vertical side bar. If you want to display the widgets placed in Tab Container, then you should place this widget in sidebar and configure this widget accordingly. This widget should be placed on the "SES - Stores Marketplace - Store View page".',
        'category' => 'SES - Stores Marketplace - Store Profile',
        'type' => 'widget',
        'name' => 'estore.profile-main-photo',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'MultiCheckbox',
                    'criteria',
                    array(
                        'label' => 'Choose from below the content show in this widget.',
                        'multiOptions' => array(
                            'photo' => 'Store Main/Profile Photo',
                            'title' => 'Store Title',
                            'storeUrl' => 'Store Custom URL',
                            'tab' => 'Store Tabs (If you choose this option, then make sure to place Tab Container widget also.)'
                        ),
                    )
                ),
                array(
                    'Text',
                    'height',
                    array(
                        'label' => 'Enter the height of main photo block in List Views (in pixels).',
                        'value' => '150',
                    )
                ),
                array(
                    'Text',
                    'width',
                    array(
                        'label' => 'Enter the width of main photo block in List Views (in pixels).',
                        'value' => '150',
                    )
                ),
            )
        ),
    ),
    array(
        'title' => 'SES - Stores Marketplace - Store Profile - Announcements',
        'description' => 'This widget displays the announcements posted by Store Admins from their Store Dashboards. This widget should be placed on the "SES - Stores Marketplace - Store View page".',
        'category' => 'SES - Stores Marketplace - Store Profile',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'estore.profile-announcements',
        'adminForm' => array(
            'elements' => array(
                array(
                    'Text',
                    'limit_data',
                    array(
                        'label' => 'Count (number of store announcements to show)',
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
        'title' => 'SES - Stores Marketplace - Store Profile - Overview',
        'description' => 'Displays Overview of the Store on "SES - Stores Marketplace - Store View page".',
        'category' => 'SES - Stores Marketplace - Store Profile',
        'type' => 'widget',
        'name' => 'estore.store-overview',
        'requirements' => array(
            store,
        ),
    ),
    array(
        'title' => 'SES - Stores Marketplace - Store Profile - Map',
        'description' => 'Displays multiple locations of Store on map on it\'s profile. This widget should be placed on the "SES - Stores Marketplace - Store View page".',
        'category' => 'SES - Stores Marketplace - Store Profile',
        'type' => 'widget',
        'name' => 'estore.store-map',
        'defaultParams' => array(
            'title' => 'Map',
            'titleCount' => true,
        ),
        'requirements' => array(
            'subject' => 'user',
        ),
    ),
    array(
        'title' => 'SES - Stores Marketplace - Store Profile - Labels',
        'description' => 'Displays Featured, Sponsored , Verified and Hot labels on current store depending on the labels it has enabled from the admin panel of this plugin. This widget should be placed on "Store - Store View Page".',
        'category' => 'SES - Stores Marketplace - Store Profile',
        'type' => 'widget',
        'name' => 'estore.store-labels',
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
        'title' => 'SES - Stores Marketplace - Photo View Page Breadcrumb',
        'description' => 'This widget displays breadcrumb on store\'s photo view page.',
        'category' => 'SES - Stores Marketplace - Photos & Albums',
        'type' => 'widget',
        'name' => 'estore.photo-view-breadcrumb',
        'autoEdit' => false,
    ),
    array(
        'title' => 'SES - Stores Marketplace - Albums View Page Breadcrumb',
        'description' => 'This widget displays breadcrumb on store\'s album view page.',
        'category' => 'SES - Stores Marketplace - Photos & Albums',
        'type' => 'widget',
        'name' => 'estore.photo-album-view-breadcrumb',
        'autoEdit' => false,
    ),
    array(
        'title' => 'SES - Stores Marketplace - Store Profile - Associated Sub Store Details',
        'description' => 'If a Store is an Associated Sub Store, then this widget displays the details of its Create Associated Main Store and shows a label for the Store being a Associated-Store. This widget should be placed on the "SES - Store View Page"',
        'category' => 'SES - Stores Marketplace - Store Profile',
        'type' => 'widget',
        'name' => 'estore.main-store-details',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => 'Choose the details of "Main Store" to be shown in this widget.',
                        'multiOptions' => array(
                            'storePhoto' => 'Store Photo',
                            'title' => 'Store Title',
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
//        'title' => 'SES - Stores Marketplace - How It Works',
//        'description' => '',
//        'category' => 'SES - Stores Marketplace',
//        'type' => 'widget',
//        'name' => 'estore.howitworks',
//        'autoEdit' => false,
//    ),
    array(
      'title' => 'SES - Stores Marketplace - Store Profile - Services',
      'description' => 'Displays all service created by store owner. This widget should be placed on the "SES - Store View Page".',
      'category' => 'SES - Stores Marketplace - Store Profile',
      'type' => 'widget',
      'autoEdit' => true,
      'name' => 'estore.service',
      'adminForm' => array(
      'elements' => array(
        array(
          'Text',
          'limit_data',
            array(
                'label' => 'Enter the number of services to display.',
                'value' => 11,
                'validators' => array(
                array('Int', true),
                array('GreaterThan', true, array(0)),
                )
             )
            ),
            array(
                'MultiCheckbox',
                'show_criteria',
                array(
                    'label' => 'Choose from below the details that you want to show for stores in this widget.',
                    'multiOptions' => array(
                        'title' => 'Title',
                        'creationDate' => 'Creation Date',
                        'photo'=> 'Photo',
                        'description' => 'Description',
                    ),
                )
            ),
            ),
        ),
    ),
    array(
      'title' => 'SES - Stores Marketplace - New Claim Request Form',
      'description' => 'Displays form to make new request to claim a store. This widget should be placed on the "SES - Stores Marketplace - New Claims Page".',
      'category' => 'SES - Stores Marketplace - Store Profile',
      'type' => 'widget',
      'name' => 'estore.claim-store',
      'autoEdit' => true,
    ),
    array(
      'title' => 'SES - Stores Marketplace - Browse Claim Requests',
      'description' => 'Displays all claim requests made by the current member viewing the store. The recommended page for this widget is "SES - Stores Marketplace - Browse Claim Requests Page',
      'category' => 'SES - Stores Marketplace - Store Profile',
      'autoEdit' => true,
      'type' => 'widget',
      'name' => 'estore.claim-requests',
      'autoEdit' => true,
    ),

    array(
        'title' => 'SES - Stores Marketplace - Profile Store Review',
        'description' => 'This widget display review of user. This widget placed on "Store View Page" only.',
        'category' => 'SES - Stores Marketplace - Store Profile',
        'type' => 'widget',
        'name' => 'estore.store-reviews',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'MultiCheckbox',
                    'stats',
                    array(
                        'label' => 'Choose the options that you want to be displayed in this widget.',
                        'multiOptions' => array(
                            "likeCount" => "Likes Count",
                            "commentCount" => "Comments Count",
                            "viewCount" => "Views Count",
                            "title" => "Review Title",
                            "share" => "Share Button",
                            "report" => "Report Button",
                            "pros" => "Pros",
                            "cons" => "Cons",
                            "description" => "Description",
                            "recommended" => "Recommended",
                            'postedBy' => "Posted By",
                            'parameter' => 'Review Parameters',
                            "creationDate" => "Creation Date",
                            'rating' => 'Rating Stars',
                            'storeName' => 'Store Name',
                        )
                    ),
                )
            ),
        ),
    ),


    array(
        'title' => 'SES - Stores Marketplace - Profile Review',
        'description' => 'Displays a product\'s review entries on their profile. This widget is placed on "SES - Stores Marketplace - Review View Page" only.',
        'category' => 'SES - Stores Marketplace - Store Profile',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'estore.profile-review',
        'autoedit' => 'true',
        'adminForm' => array(
            'elements' => array(
                array(
                    'MultiCheckbox',
                    'stats',
                    array(
                        'label' => 'Choose the options that you want to be displayed in this widget.',
                        'multiOptions' => array(
                            "likeCount" => "Likes Count",
                            "commentCount" => "Comments Count",
                            "viewCount" => "Views Count",
                            "title" => "Review Title",
                            "pros" => "Pros",
                            "cons" => "Cons",
                            "description" => "Description",
                            "recommended" => "Recommended",
                            'postedin' => "Posted In",
                            "creationDate" => "Creation Date",
                            'parameter' => 'Review Parameters',
                            'rating' => 'Rating Stars',
                        )
                    ),
                )
            ),
        ),
    ),
    array(
        'title' => "SES - Stores Marketplace - Review Owner's Photo",
        'description' => 'This widget display review owner photo. This widge is placed on "SES - Stores Marketplace - Review View Page" only.',
        'category' => 'SES - Stores Marketplace - Store Profile',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'estore.review-owner-photo',
        'defaultParams' => array(
            'title' => '',
        ),
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'showTitle',
                    array(
                        'label' => 'Member’s Name',
                        'multiOptions' => array(
                            '1' => 'Yes',
                            '0' => 'No'
                        ),
                        'value' => 1,
                    )
                ),
                array(
                    'Text',
                    'height',
                    array(
                        'label' => 'Enter height of one block in pixels',
                        'value' => 400,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        ),
                    ),
                ),
                array(
                    'Text',
                    'width',
                    array(
                        'label' => 'Enter width of one block in pixels.',
                        'value' => 400,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        ),
                    ),
                ),
            )
        ),
    ),
    array(
        'title' => 'SES - Stores Marketplace - Review Profile Options',
        'description' => 'Displays a menu of actions (edit, report, share, etc) that can be performed on a content on its profile. The recommended page for this widget is "SES - Stores Marketplace - Review View Page".',
        'category' => 'SES - Stores Marketplace - Store Profile',
        'type' => 'widget',
        'name' => 'estore.review-profile-options',
        'autoEdit' => false,
    ),
    array(
        'title' => 'SES - Stores Marketplace - My Account',
        'description' => 'This widget should be placed on My Account page and  display user details',
        'category' => 'SES - Stores Marketplace - Store Profile',
        'type' => 'widget',
        'name' => 'estore.my-account',
        'autoEdit' => false,
    ),
);
