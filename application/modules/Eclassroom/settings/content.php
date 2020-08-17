<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: content.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
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
$DescriptionTruncationList = array(
  'Text',
  'description_truncation_list',
  array(
    'label' => 'Description truncation limit for List Views.',
    'value' => 45,
    'validators' => array(
      array('Int', true),
      array('GreaterThan', true, array(0)),
    )
  )
);
$DescriptionTruncationGrid = array(
  'Text',
  'description_truncation_grid',
  array(
    'label' => 'Description truncation limit for Grid Views.',
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
    'label' => "Do you want the courses to be auto-loaded when users scroll down the page?",
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
        'title' => 'SNS - Courses - Courses Navigation Menu',
        'description' => 'Displays a navigation menu bar for the Courses pages & Classroom pages like Browse Courses, Courses Home, Categories, Browse classroom  etc.',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'name' => 'eclassroom.browse-menu',
        'requirements' => array(
            'no-subject',
        ),
    ),
     array(
        'title' => 'Courses - Classrooms - Cover Photo, Details & Options',
        'description' => 'Displays Cover photo of a Classroom. You can edit this widget to configure various settings and options to be shown in this widget. This widget should be placed on the "Classroom - Profile View Page"',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'name' => 'eclassroom.classroom-view',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'Radio',
                    'layout_type',
                    array(
                        'label' => "Choose layout of Profile View Page.",
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
                            'in' => 'Inside (only work when Classroom Main Photo & Vertical Tabs widget not placed same page)',
                            'out' => 'Outside'
                        ),
                        'value' => 'out',
                    )
                ),
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose the options to be shown in this widget.",
                        'multiOptions' => array(
                            'title' => 'Classroom Title',
                            'photo' => 'Classroom Main Photo',
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
                            'view' => 'Views Count [Design 2]',
                            //'follow' => 'Follow Count [Design 2]',
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
        'title' => 'Courses - Classrooms - Announcements',
        'description' => 'This widget displays the Announcements posted by Classroom Admins from their Classroom Dashboards. This widget should be placed on the "Classroom - Profile Page".',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'eclassroom.profile-announcements',
        'adminForm' => array(
            'elements' => array(
                array(
                    'Text',
                    'limit_data',
                    array(
                        'label' => 'Count (number of Classroom Announcements to show)',
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
        'title' => 'SNS - Courses - Classrooms - Associated Sub Classroom Details',
        'description' => 'If a Classroom is an Associated Sub Classroom, then this widget displays the details of its Create Associated Main Classroom and shows a label for the Classroom being a Associated-Classroom. This widget should be placed on the "Classroom - Profile View Page"',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'name' => 'eclassroom.main-classroom-details',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => 'Choose the details of "Main Classroom" to be shown in this widget.',
                        'multiOptions' => array(
                            'classroomPhoto' => 'Classroom Photo',
                            'title' => 'Classroom Title',
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
    array(
      'title' => 'SNS - Courses - Classrooms - Associated Sub Classrooms List on Main Classroom',
      'description' => 'Displays Associated Sub Classrooms on Classroom  - Profile View Page.',
      'category' => 'Courses - Learning Management System',
      'type' => 'widget',
      'name' => 'eclassroom.sub-classrooms',
      'autoEdit' => true,
      'adminForm' => 'Eclassroom_Form_Admin_Classroom_Browse',
        'requirements' => array(
            'no-subject',
      ),
    ),
    array(
        'title' => 'SNS - Courses - Classrooms - Call To Action Button',
        'description' => 'This widget enables Classroom owners to add a \'Call To Action Button\' to their Classrooms. This widget should be placed on the "Courses - Classrooms - Profile View Page”.',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'eclassroom.profile-action-button',
    ),
    array(
        'title' => 'SNS - Courses - Classrooms - Favorite Button',
        'description' => 'Displays Favorite button on the Classroom using which users will be able to add current Classroom to their Favorite lists. This widget should be placed on "Classroom - Profile View Page"',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'eclassroom.favourite-button',
        'defaultParams' => array(
        ),
    ),
    array(
        'title' => 'SNS - Courses - Classrooms - Follow Button',
        'description' => 'Displays Follow button on the Classroom using which users will be able to add current Classroom.This widget should be placed on "Classroom - Profile View Page"',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'eclassroom.follow-button',
        'defaultParams' => array(
        ),
    ),
    array(
        'title' => 'SNS - Courses - Classrooms - Info Sidebar',
        'description' => 'Displays a Classroom\'s Info (likes creation details, stats, type, categories, etc) on their profiles. This widget should be placed in the right or left sidebar column on the "Classrooms - Profile View Page"',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'name' => 'eclassroom.profile-info',
        'requirements' => array(
            'subject' => 'classroom',
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
        'title' => 'SNS - Courses - Classrooms -  Profile Information',
        'description' => 'Displays information about the classroom when placed on "Classroom - Profile  View Page"',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'name' => 'eclassroom.classroom-info',
        'autoEdit' => true,
        'requirements' => array(
            'classroom',
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
                            'favouriteCount' => 'Favourite Count',
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
        'title' => 'SNS - Courses - Classrooms -  Profile Labels',
        'description' => 'Displays Featured, Sponsored , Verified, New and Hot labels on current Classroom depending on the labels it has enabled from the admin panel of this plugin. This widget should be placed on "Classroom - Profile View Page"',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'name' => 'eclassroom.classroom-labels',
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
        'title' => 'SNS - Courses - Classrooms - Photo Albums',
        'description' => 'Displays  Classroom\'s albums on it\'s profile. This widget should be placed on "Classroom - Profile View page".',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'eclassroom.profile-photos',
        //'isPaginated' => true,
        'defaultParams' => array(
            'title' => 'Albums',
            'titleCount' => false,
        ),
        'requirements' => array(
            'subject' => classroom,
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
                        'label' => "Show Album statistics Always or when users Mouse-over on album blocks (this setting will work only if you choose to show information inside the Album block.)",
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
        'title' => 'SNS - Courses - Classrooms - Album View Page Options',
        'description' => 'This widget enables you to choose various options to be shown on album view page like edit, delte, like , favorite etc. This widget should be placed on "Classroom - Albums Profile Page”.',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'eclassroom.album-view-page',
        'adminForm' => 'Courses_Form_Admin_Albumviewpage',
    ),
    array(
        'title' => 'SNS - Classrooms - Photos - Album Home No Album Message',
        'description' => 'Displays a message when there is no Album on your website. Edit this widget to choose for which content you want to place this widget.',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'name' => 'eclassroom.album-home-error',
    ),
    array(
        'title' => 'SNS - Classrooms - Photos - Album Browse Search',
        'description' => 'Displays a search form in the album browse page as placed by you. Edit this widget to choose the search option to be shown in the search form.',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'name' => 'eclassroom.browse-album-search',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
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
        'title' => 'SNS - Courses - Classrooms - Like Button',
        'description' => 'Displays Like button on the Classroom using which users will be able to add current Classroom to their Like lists. This widget should be placed on "Classroom - Profile View Page"',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'eclassroom.like-button',
        'defaultParams' => array(
        ),
    ),
    array(
        'title' => 'SNS - Courses - Classrooms - Map',
        'description' => 'Displays multiple locations of Classroom on map on it\'s profile. This widget should be placed on the "Classroom - Profile View Page”.',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'name' => 'eclassroom.classroom-map',
        'defaultParams' => array(
            'title' => 'Map',
            'titleCount' => true,
        ),
        'requirements' => array(
            'subject' => 'user',
        ),
    ),
     array(
        'title' => 'SNS - Courses - Classrooms - Photos - Album Profile Page Options',
        'description' => 'This widget enables you to choose various options to be shown on photo view page like Slideshow of other photos associated with same album as the current photo, etc. This widget should be placed on "Classroom - Photo Profile Page”',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'name' => 'eclassroom.photo-view-page',
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
        'title' => 'SNS - Courses - Classrooms - Browse Locations widget',
        'description' => 'This widget should be placed on the  “Classroom - Browse Locations Page” & displays all the classrooms based on searching field chosen with different views.',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'name' => 'eclassroom.browse-locations-classrooms',
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
                        'label' => "Choose from below the details that you want to show for classrooms in this widget.",
                        'multiOptions' => array(
                          'title' => 'Classroom Title',
                          'description' => 'Description',
                          'ownerPhoto' => 'Owner\'s Photo',
                          'by' => 'Owner\'s Name',
                          'creationDate' => 'Created On',
                          'category' => 'Category',
                          'location' => 'Location',
                          'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                          'contactDetail' => 'Contact Details',
                          'likeButton' => 'Like Button',
                          'favouriteButton' => 'Favourite Button',
                          'followButton' => 'Follow Button',
                          'joinButton' => 'Join Button',
                          'contactButton' => 'Contact Button',
                          'courseCount'=>'Courses Count',
                          'like' => 'Likes Count',
                          'comment' => 'Comments Count',
                          'favourite' => 'Favourite Count',
                          'rating' => 'Reviews & Rating Count',
                          'view' => 'Views Count',
                          'follow' => 'Follow Counts',
                          'member' => 'Members Count',
                          'statusLabel' => 'Status Label [Open/ Closed]',
                          'featuredLabel' => 'Featured Label',
                          'sponsoredLabel' => 'Sponsored Label',
                          'verifiedLabel' => 'Verified Label',                          
                        ),
                        'escape' => false,
                    )
                ),
                array(
                    'Select',
                    'show_item_count',
                    array(
                        'label' => 'Do you want to show classroom count in this widget?',
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
                $titleTruncationList,
                $descriptionTruncationList,
                array(
                    'Text',
                    'limit_data_list',
                    array(
                        'label' => 'Count (number of classrooms to show)',
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
        'title' => 'SNS - Courses - Classrooms - Browse Search',
        'description' => 'Displays search form on the Classroom Browse Page. This widget should be placed on "Classroom -  Browse Page" & “Browse Locations Page”.',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'autoEdit' => 'true',
        'name' => 'eclassroom.browse-search',
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
                            'mostSPcourses'=>'Most Courses'
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
                            'mostSPcourses'=>'Most Courses'
                        ),
                    )
                ),
                array(
                    'MultiCheckbox',
                    'criteria',
                    array(
                        'label' => "Choose options to be shown in 'View' search fields.",
                        'multiOptions' => array(
                            '0' => 'All Classrooms',
                           // '1' => 'Only My Friend\'s Classrooms',
                            //'2' => 'Only My Network Classrooms',
                            '3' => 'Only My Classrooms',
                            '4'=> 'Only 5 Star Reviews',
                            '5'=> 'Only 4 Star Reviews',
                            '6'=> 'Only 3 Star Reviews',
                            '7'=> 'Only 2 Star Reviews',
                            '8'=> 'Only 1 Star Reviews',
                        ),
                    )
                ),
                array(
                    'Select',
                    'default_view_search_type',
                    array(
                        'label' => "Default value for 'View' search field.",
                        'multiOptions' => array(
                            '0' => 'All Classrooms',
                           // '1' => 'Only My Friend\'s Classrooms',
                           // '2' => 'Only My Network Classrooms',
                            '3' => 'Only My Classrooms',
                            '4'=> 'Only 5 Star Reviews',
                            '5'=> 'Only 4 Star Reviews',
                            '6'=> 'Only 3 Star Reviews',
                            '7'=> 'Only 2 Star Reviews',
                            '8'=> 'Only 1 Star Reviews',
                        ),
                    )
                ),
                array(
                    'MultiCheckbox',
                    'show_option',
                    array(
                        'label' => "Choose from below the search fields to be shown in this widget.",
                        'multiOptions' => array(
                            'searchClassroomTitle' => 'Search Classrooms / Keywords',
                            'view' => 'View',
                            'browseBy' => 'Browse By',
                            //'alphabet' => 'Alphabet',
                            'Categories' => 'Category',
                           // 'customFields' => 'Custom Fields',
                            //'location' => 'Location ',
                            //'miles' => 'Kilometers or Miles',
                           // 'country' => 'Country',
                            //'state' => 'State',
                           // 'city' => 'City',
                            //'zip' => 'ZIP',
                            //'venue' => 'Venue',
                        ),
                    )
                ),
                array(
                    'MultiCheckbox',
                    'hide_option',
                    array(
                        'label' => "Choose from below the search fields to be hidden in this widget. The selected search fields will be shown when users will click on the \"Show Advanced Settings\" link.",
                        'multiOptions' => array(
                            'searchClassroomTitle' => 'Search Classrooms / Keywords',
                            'view' => 'View',
                            'browseBy' => 'Browse By',
                            //'alphabet' => 'Alphabet',
                            'Categories' => 'Category',
                            //'location' => 'Location ',
                           // 'miles' => 'Kilometers or Miles',
                           // 'country' => 'Country',
                          //  'state' => 'State',
                          //  'city' => 'City',
                            //'zip' => 'ZIP',
                           // 'venue' => 'Venue',
                        ),
                    )
                ),
            )
        ),
    ),
    array(
        'title' => 'SNS - Courses - Classrooms - Members',
        'description' => 'Displays members of Classroom on it\'s profile. This widget should be placed on the "Classroom - Profile View Page”.',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'name' => 'eclassroom.profile-members',
        'requirements' => array(
            'subject' => 'classroom',
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
        'title' => 'SNS - Courses - Classrooms - Albums Profile Page Breadcrumb',
        'description' => 'Displays Breadcrumb for the album profile page. This widget should be placed on "Classroom - Albums Profile Page”.',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'name' => 'eclassroom.photo-album-view-breadcrumb',
        'autoEdit' => false,
    ),
    array(
        'title' => 'SNS - Classrooms - Photo Profile Page Breadcrumb',
        'description' => 'Displays Breadcrumb for the photo profile page. This widget should be placed on "Classroom - Photo Profile Page”.',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'name' => 'eclassroom.photo-view-breadcrumb',
        'autoEdit' => false,
    ),
    /*Classroom widgets */
    array(
        'title' => 'SNS - Courses - Classrooms - Browse Classrooms',
        'description' => 'Displays all the browsed classrooms on the page in different views.',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'name' => 'eclassroom.browse-classrooms',
        'autoEdit' => true,
        'adminForm' => 'Courses_Form_Admin_Classroom_Browse',
        'requirements' => array(
            'no-subject',
        ),
    ),
    array(
        'title' => 'SNS - Courses - Classroom - Category Banner Widget',
        'description' => 'Displays a banner for categories. You can place this widget at browse page of category on your site.',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'eclassroom.classroom-banner-category',
        'adminForm' => 'Courses_Form_Admin_Classroom_Categorywidget',
    ),
    array(
        'title' => 'SNS - Courses - Classrooms - Category View Page for All Category Levels',
        'description' => 'Displays banner, 2nd-level or 3rd level categories and classrooms associated with the current category on its view page.This widget should be placed on Classroom -  Category view page.',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'name' => 'eclassroom.category-view',
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
                        'label' => "Sub - Categories Title for Classroom",
                        'value' => 'Sub-Categories of this catgeory',
                    )),
                array(
                    'MultiCheckbox',
                    'show_subcatcriteria',
                    array(
                        'label' => "Choose from below the details that you want to show on each Category block.",
                        'multiOptions' => array(
                            'title' => 'Category title',
                            'icon' => 'Category icon',
                            'countClassrooms' => 'Classroom Count in each Category',
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
                        'label' => 'Enter the height of 1st,  2nd-level & 3rd level Category\'s block (in pixels).',
                        'value' => '160px',
                    )
                ),
                array(
                    'Text',
                    'widthSubcat',
                    array(
                        'label' => 'Enter the width of 1st, 2nd-level & 3rd level Category\'s block (in pixels).',
                        'value' => '250px',
                    )
                ),
                array('Select', "show_popular_classrooms", array(
                        'label' => "Do you want to show popular Classrooms in banner widget?",
                        'multiOptions' => array('1' => 'Yes,want to show popular classroom', 0 => 'No,don\'t want to classroom popular classrooms'),
                        'value' => 1,
                    )),
                array('Text', "pop_title", array(
                        'label' => "Title for Classrooms",
                        'value' => 'Popular Classrooms',
                    )),
                array(
                    'Select',
                    'info',
                    array(
                        'label' => "Choose criteria by which page shown in banner widget.",
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
                        'label' => "Classrooms Settings"
                    )
                ),
                array('Text', "classroom_title", array(
                        'label' => "Classrooms Title for pages",
                        'value' => 'Classrooms of this catgeory',
                    )),
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show on each classroom block.",
                        'multiOptions' => array(
                            "title" => "Classroom Title",
                            'classroomPhoto'=>'Classroom Photo',
                            'ownerPhoto' => 'Owner\'s Photo',
                            'by' => 'Owner\'s Name',
                            'creationDate' => 'Created On',
                            'category' => 'Category',
                            'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                            'likeButton' => 'Like Button',
                            'favouriteButton' => 'Favourite Button',
                            'followButton' => 'Follow Button',
                            'joinButton' => 'Join Button',
                            'like' => 'Likes Count',
                            'comment' => 'Comments Count',
                            'favourite' => 'Favourite Count',
                            'member' => 'Members Count',
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
                array(
                    'Radio',
                    'pagging',
                    array(
                        'label' => "Do you want the classrooms to be auto-loaded when users scroll down the page?",'multiOptions' => array(
                        'auto_load' => 'Yes, Auto Load',
                        'button' => 'Yes, show \'View more\' link.',
                        'pagging' => 'Yes, show \'Pagination\'.'
                    ),
                    'value' => 'auto_load',
                    )
                ),
                array(
                    'Text',
                    'classroom_limit',
                    array(
                        'label' => 'Count (number of Classrooms to show).',
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
                        'label' => 'Enter the height of one classroom block (in pixels). [Note: This setting will not affect the classroom blocks displayed in Advanced View.]',
                        'value' => '160px',
                    )
                ),
                array(
                    'Text',
                    'width',
                    array(
                        'label' => 'Enter the width of one classroom block (in pixels). [Note: This setting will not affect the classroom blocks displayed in Advanced View.]',
                        'value' => '160px',
                    )
                )
            )
        ),
    ),
     array(
        'title' => 'SNS - Courses - Classrooms - Category Carousel',
        'description' => 'Displays categories in aC. The placement criteria of this widget depends upon the chosen criteria for this widget.',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'eclassroom.classroom-category-carousel',
        'adminForm' => array(
            'elements' => array(
                $titleTruncation,
                $descriptionTruncation,
                array(
                    'Text',
                    'height',
                    array(
                        'label' => 'Enter the height of one page block (in pixels).',
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
                        'label' => 'Enter the width of one page block (in pixels)',
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
                            'most_classroom' => 'Categories with maximum classroom first',
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
                            'countClassroom' => 'Classroom count in each category',
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
                        'label' => 'Count (number of category to show in this widget, put 0 for unlimited).',
                        'value' => 10,
                    )
                ),
            )
        ),
    ),
    array(
        'title' => 'SNS - Courses - Classrooms - Popular Categories',
        'description' => 'Displays Popular categories in List and Grid view and you can configure setting.',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'name' => 'eclassroom.classroom-popular-categories',
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
                            'most_classroom' => 'Categories with maximum Classroom first.',
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
        'title' => 'SNS - Classrooms - Photos - Popular Albums',
        'description' => "Displays albums as chosen by you based on chosen criteria for this widget. This widget can be placed on Album Home & Browse Page.",
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'eclassroom.popular-albums',
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
                            'classroomName' => "Classroom Name",
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
        'title' => 'SNS - Classrooms - Photos - Recently Viewed Albums',
        'description' => 'This widget displays the recently viewed albums by the user who is currently viewing your website or by the logged in members friend or by all the members of your website.This widget can be placed on Album Home & Browse page.',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'name' => 'eclassroom.recently-viewed-albums',
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
                            'classroomName' => "Classroom Name",
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
        'title' => 'SNS - Courses - Classrooms - Overview',
        'description' => 'Displays Overview of the Classroom. This widget should be placed on "Classroom - Profile View Page"',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'name' => 'eclassroom.classroom-overview',
        'requirements' => array(
            classroom,
        ),
    ),
    array(
        'title' => 'SNS - Courses - Classrooms - Main Photo & Vertical Tabs',
        'description' => 'This widget displays the main photo of Classroom and the tab container in vertical side bar. If you want to display the widgets placed in Tab Container, then you should place this widget in sidebar and configure this widget accordingly. This widget should be placed on the "Classroom - Profile View page"',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'name' => 'eclassroom.profile-main-photo',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'MultiCheckbox',
                    'criteria',
                    array(
                        'label' => 'Choose from below the content show in this widget.',
                        'multiOptions' => array(
                            'photo' => 'Classroom Main/Profile Photo',
                            'title' => 'Classroom Title',
                            'classroomUrl' => 'Classroom Custom URL',
                            'tab' => 'Classroom Tabs (If you choose this option, then make sure to place Tab Container widget also.)'
                        ),
                    )
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
            )
        ),
    ),
    array(
        'title' => 'SNS - Courses - Classrooms - Opening / Operating Hours',
        'description' => 'This widget displays the Operating Hours of a Classroom which are entered from its dashboard. This widget should be placed on the "Classroom - Profile View page"',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'name' => 'eclassroom.open-hours',
        'requirements' => array(
            'no-subject',
        ),
    ),
    array(
        'title' => 'SNS - Courses - Classrooms - Classrooms Liked By This Classroom',
        'description' => 'This widget displays other Classrooms which are Liked by the current Classroom. This widget should be placed on the "Classroom - Profile View page”.',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'name' => 'eclassroom.classroom-liked',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                'Text',
                'limit_data',
                    array(
                        'label' => 'Enter Number of classroom to show.',
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
        'title' => 'SNS - Courses - Classrooms - People Who Acted On This Classroom',
        'description' => 'This widget displays People who Liked / Followed or added current page as Favorite. This widget should be placed on "Classroom - Profile View page".',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'name' => 'eclassroom.recent-people-activity',
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
                            'like' => 'People who Liked this Classroom.',
                            'favourite' => 'People who added this Classroom as Favourite.',
                            'follow' => 'People who Followed this Classroom.',
                            'review' => 'People who given " Reviews & Rating " this classroom',
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
                        'label' => 'Enter the number of members to be shown in "People Who Liked This Classroom" block. After the number of members entered below, option to view more members in popup will be shown.',
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
                        'label' => 'Enter the number of members to be shown in "People Who Favorite This Classroom" block. After the number of members entered below, option to view more members in popup will be shown.',
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
                        'label' => 'Enter the number of members to be shown in "People who Followed this Classroom" block. After the number of members entered below, option to view more members in popup will be shown.',
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
		'title' => 'SNS - Courses - Classroom - Browse Reviews',
		'description' => 'Displays all reviews for Classroom on your website. This widget should be placed on "Classroom - Browse Reviews Page"',
		'category' => 'Courses - Learning Management System',
		'type' => 'widget',
		'autoEdit' => true,
		'name' => 'eclassroom.browse-reviews',
		'defaultParams' => array(
		),
		'adminForm' => array(
				'elements' => array(
					array(
						'MultiCheckbox',
						'stats',
						array(
							'label' => 'Choose options to show in this widget.',
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
								//'likeButton' => 'Like Button',
                //'socialSharing' =>'Social Share Buttons',
							),
						)
					),
					
					$pagging,
					array(
						'Text',
						'limit_data',
						array(
								'label' => 'Count (number of reviews to show).',
								'value' => 5,
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
		'title' => 'SNS - Courses - Classroom - Reviews Browse Search',
		'description' => 'Displays a search form on the Classroom - Browse Reviews Page” as configured by you.',
		'category' => 'Courses - Learning Management System',
		'type' => 'widget',
		'name' => 'eclassroom.browse-review-search',
		'requirements' => array(
				'no-subject',
		),
		'autoEdit' => true,
		'adminForm' => array(
			'elements' => array(
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
					'Radio',
					'review_title',
					array(
						'label' => "Show \'Review Title\' search field?",
						'multiOptions' => array(
								'1' => 'Yes',
								'0' => 'No'
						),
						'value' => '1',
					)
				),
				array(
					'Radio',
					'review_search',
					array(
						'label' => "Show \'Browse By\' search field?",
						'multiOptions' => array(
								'1' => 'Yes',
								'0' => 'No'
						),
						'value' => '1',
					)
				),
				array(
					'Radio',
					'review_stars',
					array(
						'label' => "Show \'Review Stars\' search field?",
						'multiOptions' => array(
								'1' => 'Yes',
								'0' => 'No'
						),
						'value' => '1',
					)
				),
				array(
					'Radio',
					'review_recommendation',
					array(
						'label' => "Show \'Recommended Review\' search field?",
						'multiOptions' => array(
								'1' => 'Yes',
								'0' => 'No',
						),
						'value' => '1',
					)
				),
			)
		),
  ),
    array(
        'title' => 'SNS - Courses - Popular Classrooms Slideshow - Double Classrooms',
        'description' => 'This widget displays 2 types of classrooms. The one section of this widget will be slideshow and the other will show 3 classrooms based on the criterion chosen in this widget.',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'name' => 'eclassroom.classrooms-slideshow',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'leftClassroom',
                    array(
                        'label' => "Do you want to enable the 3 Classroom in left side?",
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
                        'label' => 'Choose popularity criteria for the 3 Classrooms to be displayed at the left side.',
                        'multiOptions' => array(
                            "recently_created" => "Most Recent",
                            "most_liked" => "Most Liked",
                            "most_commented" => "Most Commented",
                            "most_viewed" => "Most Viewed",
                            "most_favourite" => "Most Favorited",
                            "most_followed" => "Most Followed",
                            "most_joined" => "Most Joined",
                            "most_courses"=>"Most Courses"
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
                            '5' => 'All Classrooms',
                            '1' => 'Only Featured',
                            '2' => 'Only Sponsored',
                            '6' => 'Only Verified',
                            '7' => 'Only Hot',
                            '3' => 'Both Featured & Sponsored',
                            '4' => 'All except Featured & Sponsored',
                        ),
                        'value' => 5,
                    )
                ),
                array(
                    'Select',
                    'enableSlideshow',
                    array(
                        'label' => "Do you want to enable the slideshow on the right side?",
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
                        'label' => 'Choose popularity criteria for the classrooms to be displayed in the slideshow on the right side.',
                        'multiOptions' => array(
                            "recently_created" => "Most Recent",
                            "most_liked" => "Most Liked",
                            "most_commented" => "Most Commented",
                            "most_viewed" => "Most Viewed",
                            "most_favourite" => "Most Favourited",
                            "most_followed" => "Most Followed",
                            "most_joined" => "Most Joined",
                            "most_courses"=>"Most Courses"
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
                        'label' => "Do you want to enable the autoplay of classrooms slideshow?",
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
                        'label' => 'Enter the delay time for the next classroom to be displayed in the slideshow. (work if autoplay is enabled.)',
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
                        'label' => 'Count (number of classrooms to be displayed in slideshow).',
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
                            'title' => 'Classroom Title',
                            'by' => 'Owner Name',
                            'creationDate' => 'Created On',
                            'category' => 'Category',
                            'location' => 'Location',
                            'description' => "Description (This will only show in the slideshow.)",
                            'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                            'likeButton' => 'Like Button',
                            'favouriteButton' => 'Favourite Button',
                            'followButton' => 'Follow Button',
                            'joinButton' => 'Join Button',
                            'member' => 'Members Count',
                            'like' => 'Likes Count',
                            'comment' => 'Comments Count',
                            'favourite' => 'Favourites Count',
                            'rating'=>"Reviews & Rating count",
                            'view' => 'Views Count',
                            'follow' => 'Follow Counts',
                            'featuredLabel' => 'Featured Label',
                            'sponsoredLabel' => 'Sponsored Label',
                            'verifiedLabel' => 'Verified Label',
                            'hotLabel' => 'Hot Label',
                            'courseCount' => 'Courses Count',
                        ),
                        'escape' => false,
                    )
                ),
            ),
        ),
    ),
    array(
        'title' => 'SNS - Classrooms - Photos - Browse Albums',
        'description' => 'Display all albums on your website. The recommended page for this widget is "Classrooms - Albums Browse Page".',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'name' => 'eclassroom.browse-albums',
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
                            'classroomname' => "Classroom Name",
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
        'title' => 'SNS - Courses- Classrooms - Categories Cloud / Hierarchy View',
        'description' => 'Displays classrooms categories in cloud & hierarchy view. Also displays 2nd and 3rd level categories with mouse over etc features. ',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'name' => 'eclassroom.classroom-category',
        'autoEdit' => true,
        'adminForm' => 'Eclassroom_Form_Admin_Tagcloudcategory',
    ),
    array(
        'title' => 'SNS - Courses - Classrooms - Categories in Icons or Images',
        'description' => 'Displays all categories of classrooms in circular or square view with their icons or images. Edit this widget to configure various settings.',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'eclassroom.classroom-category-icons',
        'adminForm' => 'Courses_Form_Admin_Classroom_CategoryIcon',
    ),
    array(
        'title' => 'SNS - Classrooms - Photos - Tabbed widget for Popular Albums',
        'description' => 'Displays a tabbed widget for popular albums on your website on various popularity criteria.This Widget can be placed on Album home Page.',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'name' => 'eclassroom.album-tabbed-widget',
        'autoEdit' => true,
        'adminForm' => 'Eclassroom_Form_Admin_AlbumTabbed',
    ),
    array(
        'title' => 'SNS - Courses - Classroom Tabbed Widget for Popular Classrooms',
        'description' => 'Displays tabbed widget for classrooms on your website. Edit this widget to choose and configure the tabs to be shown in this widget.',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'eclassroom.tabbed-widget-classroom',
        'requirements' => array(
            'subject' => classroom,
        ),
        'adminForm' => 'Eclassroom_Form_Admin_Tabbed',
    ),
    array(
      'title' => 'SNS - Course - Classroom - New Claim Request Form',
      'description' => 'Displays form to make New Request to Claim a Classroom. This widget should be placed on the "Classroom - New Claim Classroom".',
      'category' => 'Courses - Learning Management System',
      'type' => 'widget',
      'name' => 'eclassroom.claim-classroom',
      'autoEdit' => true,
    ),
    array(
      'title' => 'SNS - Course - Classroom - Browse Claim Requests',
      'description' => 'Displays all claim requests made by the current member viewing the classroom. The recommended page for this widget is "SNS - Course - Classroom - Browse Claim Requests"',
      'category' => 'Courses - Learning Management System',
      'autoEdit' => true,
      'type' => 'widget',
      'name' => 'eclassroom.claim-requests',
      'autoEdit' => true,
    ),
      array(
        'title' => 'SNS - Courses - Classrooms - Profile Tips',
        'description' => 'This widget should be placed on Classroom - Profile View Page to display Tips for creating and managing their Classroom on your website.',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'eclassroom.profile-tips',
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
    // I have commented this widget for letter use 
    array(
      'title' => 'SNS - Courses - Classrooms - Services',
      'description' => 'Displays all Services created by Classroom owner. This widget should be placed on the "Classroom - Profile View Page"',
      'category' => 'Courses - Learning Management System',
      'type' => 'widget',
      'autoEdit' => true,
      'name' => 'eclassroom.service',
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
                    'label' => 'Choose from below the details that you want to show for classrooms in this widget.',
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
        'title' => 'SNS - Courses - You May Also Like Classrooms',
        'description' => 'Displays the classroom which the current user viewing the widget may like.',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'eclassroom.you-may-also-like-classrooms',
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
                        'label' => 'Choose from below the details that you want to show for classrooms in this widget.',
                        'multiOptions' => array(
                            "title" => "Classroom Title",
                            "classroomPhoto"=>"Classroom Photo",
                            "by" => "Owner Name",
                            "ownerPhoto"=>"Owner Photo",
                            "category" => "Category",
                            'listdescription' => 'Description (List View)',
                            'griddescription' => 'Description (Grid View)',
                            "location" => "Location",
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
                            'rating' => 'Reviews & Rating',
                            'courseCount' =>'Courses Count',
                        ),
                        'escape' => false,
                    ),
                ),
                $socialshare_enable_plusicon,
                $socialshare_icon_limit,
                array('Text', "limit_data", array(
                    'label' => 'Count (number of Classrooms to show).',
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
                $titleTruncationGrid,
                $descriptionTruncationGrid,
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
        'title' => 'SNS - Courses - Classrooms - Profile Options',
        'description' => 'This widget should be placed on the Classroom - Profile View Page and displays a menu of options (Edit, Report, Join, etc.) that can be performed on a Classroom. You can enable/disable any option from the Admin Panel >> Menu Editor.',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'name' => 'eclassroom.profile-options',
    ),
    array(
        'title' => 'SNS - Courses - Classrooms - Advance Share Widget',
        'description' => 'This widget allows users to share the current Classroom on your website and on other social networking websites.',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'name' => 'eclassroom.advance-share',
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
        'title' => 'Courses - Classrooms - Associated Linked Classrooms List on Main Classroom',
        'description' => 'Displays Associated Link Classrooms on the  "Classroom - Profile View Page".',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'name' => 'eclassroom.link-classrooms',
        'autoEdit' => true,
        'adminForm' => 'Eclassroom_Form_Admin_Classroom_Browse',
        'requirements' => array(
            'no-subject',
        ),
    ),
    array(
        'title' => 'SNS - Courses - Classrooms Tags Cloud / Tab View',
        'description' => 'Displays all tags of classrooms in cloud or tab view. Edit this widget to choose various other settings.',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'name' => 'eclassroom.tag-cloud-classrooms',
        'autoEdit' => true,
        'adminForm' => 'Courses_Form_Admin_Tagcloudcourse',
    ),
    array(
        'title' => 'SNS - Courses - Classroom - All Tags',
        'description' => 'Displays all Classrooms Tags on your website. The recommended page for this widget is "Classroom - Browse Tags Page"',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'name' => 'eclassroom.tag-classrooms',
         'adminForm' => array(
            'elements' => array(

            array(
            'Text',
            'show_count',
            array(
                'label' => 'Count (number of tags to show).',
                'value' => '10',
                'validators' => array(
                array('Int', true),
                array('GreaterThan', true, array(0)),
                )
            )
            ),
            array(
            'Text',
            'widgetbgcolor',
                array(
                    'class' => 'SEScolor',
                    'label'=>'Choose widget background color.',
                    'value' => '424242',
                )
            ),
            array(
            'Text',
            'buttonbgcolor',
                array(
                    'class' => 'SEScolor',
                    'label'=>'Choose background color of the button.',
                    'value' => '424242',
                )
            ),
            array(
            'Text',
            'textcolor',
                array(
                    'class' => 'SEScolor',
                    'label'=>'Choose text color on the button.',
                    'value' => '424242',
                )
            ),
        )),
    ),
    array(
      'title' => 'SNS - Courses - Classrooms - Tags',
      'description' => 'This widget should be placed on the “Classroom - Profile View Page” and displays all the Tags of the Classroom.',
      'category' => 'Courses - Learning Management System',
      'type' => 'widget',
      'name' => 'eclassroom.profile-tags',
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
        'title' => 'SNS - Courses - Classroom - Review Profile View widget',
        'description' => 'This widget should be placed on "Classroom - Review Profile View Page" only & display review of users.',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'eclassroom.profile-review',
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
      'title' => "SNS - Courses - Classroom - Review Owner’s Photo",
      'description' => 'This widget display Review owner photo. This widget should be placed on "Classroom - Review Owner’s Photo”.',
      'category' => 'Courses - Learning Management System',
      'type' => 'widget',
      'autoEdit' => true,
      'name' => 'eclassroom.review-owner-photo',
      'defaultParams' => array(
          'title' => '',
      ),
      'adminForm' => array(
          'elements' => array(
              array(
                  'Select',
                  'showTitle',
                  array(
                      'label' => 'Do you want to show Member’s Name in this widget?',
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
        'title' => 'SNS - Courses - Classroom - Review Profile Options',
        'description' => 'Displays a menu of actions (edit, report, share, etc) that can be performed on a content on its profile. The recommended page for this widget is "Classroom - Review Profile View Page".',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'name' => 'eclassroom.review-profile-options',
        'autoEdit' => false,
    ),
    array(
		'title' => 'SNS - Courses - Classrooms - Profile Review',
		'description' => 'This widget should be placed on “Classroom  - Profile View  Page” and displays Review lists & display” Write a Review” button.',
		'category' => 'Courses - Learning Management System',
		'type' => 'widget',
		'name' => 'eclassroom.classroom-reviews',
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
							'likeButton' => 'Like Button',
               'socialSharing' =>'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
						),
						'escape' => false,
					),
				),
        $socialshare_enable_plusicon,
        $socialshare_icon_limit,
				$pagging,
				array(
					'Text',
					'limit_data',
					array(
						'label' => 'count (number of reviews to show).',
						'value' => 5,
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
    'title' => 'SNS - Courses - Classroom Of The Day',
    'description' => "This widget displays Course of the day. If there are more than 1 Courses marked as 'Of The Day', then those will show randomly on each page refresh in this widget.",
    'category' => 'Courses - Learning Management System',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'eclassroom.of-the-day',
        'adminForm' => array(
            'elements' => array(
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show for courses in this widget.",
                            'multiOptions' => array(
                                'title' => 'Classroom Title',
                                'by'=>"Created By",
                                'ceationDate'=>'Created On',
                               // 'location'=>'Location',
                                'category' => 'Category',
                                'like' => 'Likes Count',
                                'view' => 'Views Count',
                                'comment' => 'Comment Count',
                                'favourite' => 'Favourites Count',
                               // 'followerCount'=>'Follow Count',
                                'member'=>'Member Count',
                                'courseCount'=>'Courses Count',
                                'rating' => 'Review & Rating Count',
                                'favouriteButton' => 'Favourite Button',
                                'likeButton' => 'Like Button',
                                //'contactButton' => 'Contact Button',
                                'followButton' => 'Follow Button',
                                'joinButton' => 'Join Button',
                                'featuredLabel' => 'Featured Label',
                               // 'verifiedLabel' => 'Verified Label',
                                'sponsoredLabel'=>'Sponsored Label',
                                'hotLabel'=>'Hot Label',
                                'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
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
                        'label' => 'Classroom Title truncation limit.',
                        'value' => 45,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
               /* array(
                    'Text',
                    'description_truncation',
                    array(
                        'label' => 'Classroom Description truncation limit.',
                        'value' => 60,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),*/
                array(
                    'Text',
                    'height',
                    array(
                        'label' => 'Enter the height of block (in pixels).',
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
                        'label' => 'Enter the width of block (in pixels).',
                        'value' => '180',
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
        'title' => ' SNS - Courses - Classroom - Recently Viewed Classrooms',
        'description' => 'Displays classrooms which are viewed by current member / by his friends (if logged in) / by all members of your website. Edit this widget to configure various settings.',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'name' => 'eclassroom.recently-viewed-item',
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
                        'label' => "Choose from below the details that you want to show for Classrooms in this widget.",
                        'multiOptions' => array(
                            'title' => 'Classroom Title',
                            'classroomPhoto' => 'Classroom Photo',
                            'by' => 'Owner Name',
                            'ownerPhoto'=>'Owner Photo',
                            'creationDate' => 'Created On',
                            'category' => 'Category',
                            'description' => 'Description',
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
                            'view' => 'Views Count',
                            'follow' => 'Follow Counts',
                            'courseCount'=>'Courses Count',
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
                    'width_pinboard',
                    array(
                        'label' => 'Enter the width of one block in Pinboard View (in pixels).',
                        'value' => '300',
                    )
                ),
//                  array(
//                     'Text',
//                     'main_photo_height',
//                     array(
//                         'label' => 'Enter the height of photo block',
//                         'value' => '230',
//                     )
//                 ),
//                 array(
//                     'Text',
//                     'main_photo_width',
//                     array(
//                         'label' => 'Enter the width of photo block',
//                         'value' => '260',
//                     )
//                 ),
                array(
                    'Text',
                    'limit_data',
                    array(
                        'label' => 'Count (number of classrooms to show.)',
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
        'title' => 'SNS - Courses - Popular Classrooms Based on Categories',
        'description' => 'Displays classrooms based on their categories in Grid view, Slideshow or Carousel as chosen by you in this widget. Edit this widget to choose number of categories and classrooms. You can configure various other settings also.',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'autoEdit' => 'true',
        'name' => 'eclassroom.category-associate-classrooms',
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
                            'most_classroom' => 'Categories with maximum Classrooms first',
                            'alphabetical' => 'Alphabetical Order',
                            'admin_order' => 'Admin selected order for categories',
                        ),
                    ),
                ),
                array(
                    'Radio',
                    'popularty',
                    array(
                        'label' => 'Choose criteria for Classroom to be show in this widget.',
                        'multiOptions' => array(
                            'all' => 'All Classrooms',
                            'featured' => 'Featured',
                            'sponsored' => 'Sponsored',
                            'verified' => 'Verified',
                            'hot' => 'Hot',
                        ),
                        'value' => 'all',
                    )
                ),
                array(
                    'Radio',
                    'order',
                    array(
                        'label' => 'Choose Popularity Criteria for Classrooms.',
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
                            'countClassroom' => 'Count of Classroom',
                            'categoryDescription' => 'Category Description (Supported in grid View)',
                        ),
                    )
                ),
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show for Classrooms in this widget. (All settings are Supported in Slideshow and Carousel only.)",
                        'multiOptions' => array(
                            'title' => 'Classroom Title',
                            'by' => 'Owner\'s Name',
                            'ownerPhoto' => 'Owner\'s Photo',
                            'creationDate' => 'Created On',
                            'category' => 'Category',
                            'location' => 'Location',
                            'description' => 'Classroom Description (Supported in Slideshow)',
                            'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                            'contactDetail' => 'Contact Details',
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
                            'rating' => 'Reviews & Rating',
                            'courseCount' =>'Courses Count',
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
                        'label' => 'Enter Classroom Description truncation limit (Supported in slideshow View).',
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
                    'classroom_limit',
                    array(
                        'label' => 'Count (number of Classrooms to show in each category in this widget).',
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
        'title' => 'SNS - Courses - Tabbed widget for Manage Classrooms',
        'description' => 'This widget should be placed on “Classroom - Manage Classrooms/My Classrooms” &  displays classrooms created, favorited, liked, etc by the member viewing the manage page. Edit this widget to configure various settings.',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'eclassroom.manage-classrooms',
        'requirements' => array(
          'subject' => 'classroom',
        ),
        'adminForm' => 'Eclassroom_Form_Admin_Tabbed',
    ),
    array(
        'title' => 'SNS - Courses - Classrooms - Breadcrumb for Profile View Page',
        'description' => 'Displays Breadcrumb for the Classrooms. This widget should be placed on "Classroom - Profile View Page”.',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'name' => 'eclassroom.breadcrumb',
        'autoEdit' => true,
    ),
    array(
        'title' => 'SNS - Courses - Classroom - Review Profile Breadcrumb',
        'description' => 'This widget should be placed on the “Classroom - Review Profile View Page” & displays Breadcrumb for Review Profile Page.',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'name' => 'eclassroom.review-breadcrumb',
        'autoEdit' => true,
    ),
    array(
        'title' => 'SNS - Courses - Classroom - Create Course',
        'description' => 'This widget should be placed only on “SNS - Courses -  Classroom Profile Pages”',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'name' => 'eclassroom.profile-course-create',
        'requirements' => array(
            'subject' => 'classroom',
        ),
    ),
    array(
    'title' => "SNS - Courses - Classrooms - Owner's Photo",
    'description' => 'Displays the photo of the owner of the Classroom. This widget should be placed on the "Classroom  - Profile View Page”.',
    'category' => 'Courses - Learning Management System',
    'type' => 'widget',
    'name' => 'eclassroom.owner-photo',
    'autoEdit' => true,
      'adminForm' => array(
        'elements' => array (
          array(
          'Select',
          'photoviewtype',
              array(
                  'label' => "Choose the shape of Photo.",
                  'multiOptions' => array(
                  'square' => 'Square',
                  'circle' => 'Circle'
                  ),
                  'value' => 'circle',
              )
          ),
          array(
          'Text',
          'user_description_limit',
              array(
                  'label' => 'Truncation limit for "About User" information .',
                  'value' => 150,
                  'validators' => array(
                  array('Int', true),
                  array('GreaterThan', true, array(0)),
                  )
              )
          ),
        ),
      ),
    ),
)
?>
