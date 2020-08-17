<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagenote
 * @package    Sespagenote
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: content.php  2019-03-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
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

$options = array('recentlySPcreated' => 'Recently Created', 'mostSPviewed' => 'Most Viewed','mostSPliked' => 'Most Liked','mostSPcommented' => 'Most Commented','mostSPfavourite' => 'Most Favorited','featured' => 'Only Featured','sponsored' => 'Only Sponsored');
// $viewOptions = array('0' => 'All Page Directories','4' => 'Open Page Directories','5' => 'Closed Page Directories','1' => 'Only My Friend\'s Page Directories','2' => 'Only My Network Page Directories','3' => 'Only My Pages Directories');

return array(
    array(
        'title' => 'SES - Page Notes Extension - Tags',
        'description' => 'Displays all the tags of the current page note on the "Page Note View Page".',
        'category' => 'SES - Page Notes Extension',
        'type' => 'widget',
        'name' => 'sespagenote.profile-tags',
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
        'title' => 'SES - Page Notes Extension - Browse Page Notes',
        'description' => 'Displays all the browse page notes on the page in different views.',
        'category' => 'SES - Page Notes Extension',
        'type' => 'widget',
        'name' => 'sespagenote.browse-notes',
        'autoEdit' => true,
        'adminForm' => 'Sespagenote_Form_Admin_Browse',
    ),
    array(
        'title' => 'SES - Page Notes Extension - Page Notes Browse Search',
        'description' => 'Displays search form in the Page Notes Browse Page. This widget should be placed on "Page Notes Browse Page".',
        'category' => 'SES - Page Notes Extension',
        'type' => 'widget',
        'autoEdit' => 'true',
        'name' => 'sespagenote.browse-search',
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
                        'label' => "Choose options to be shown in “Browse By” search fields.",
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
//                 array(
//                     'MultiCheckbox',
//                     'criteria',
//                     array(
//                         'label' => "Choose options to be shown in 'View' search fields.",
//                         'multiOptions' => $viewOptions,
//                     )
//                 ),
//                 array(
//                     'Select',
//                     'default_view_search_type',
//                     array(
//                         'label' => "Default value for 'View' search field.",
//                         'multiOptions' => $viewOptions,
//                     )
//                 ),
            )
        ),
    ),
    array(
        'title' => 'SES - Page Notes Extension - Browse Notes Page Button',
        'description' => 'This widget displays a button clicking on which users will be redirected to the "SES - Page Notes Extension - Browse Notes Page".',
        'category' => 'SES - Page Notes Extension',
        'type' => 'widget',
        'name' => 'sespagenote.browse-note-button',
    ),
    array(
        'title' => 'SES - Page Notes Extension - Note Home No Note Message',
        'description' => 'Displays a message when there is no Note on your website. The recommended page for this widget is "SES - Page Notes Extension - Note Home Page".',
        'category' => 'SES - Page Notes Extension',
        'type' => 'widget',
        'name' => 'sespagenote.note-home-error',
    ),
    array(
        'title' => 'SES - Page Notes Extension - Tabbed Widget for Popular Page Notes',
        'description' => 'Displays tabbed widget for page notes on your website. Edit this widget to choose and configure the tabs to be shown in this widget.',
        'category' => 'SES - Page Notes Extension',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sespagenote.tabbed-widget-note',
        'adminForm' => 'Sespagenote_Form_Admin_Tabbed',
    ),
    array(
        'title' => 'SES - Page Notes Extension - Page Notes Slideshow',
        'description' => "Display page notes in slideshow in this widget.",
        'category' => 'SES - Page Notes Extension',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sespagenote.slideshow',
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'info',
                    array(
                        'label' => 'Choose Popularity Criteria.',
                        'multiOptions' => array(
                            "creation_date" => "Most Recent",
                            'modified_date' => "Recently Modified",
                            "like_count" => "Most Liked",
                            "comment_count" => "Most Commented",
                            "view_count" => "Most Viewed",
                            "favourite_count" => "Most Favorited",
                            "featured" => "Only Featured",
                            "sponsored" => "Only Sponsored",
                        )
                    ),
                    'value' => 'creation_date',
                ),
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show in this widget.",
                        'multiOptions' => array(
                            'title' => 'Note Title',
                            'by' => 'Owner Name',
                            'description' => 'Note Description',
                            'posteddate' => 'Created On',
                            'likecount' => 'Likes Count',
                            'commentcount' => 'Comments Count ',
                            'favouritecount' => 'Favourites Count ',
                            'viewcount' => 'Views Count ',
                            'featured' => 'Featured Label',
                            'sponsored' => 'Sponsored Label',
                            'likeButton' => 'Like Button',
                            'favouriteButton' => "Favourite Button",
                            'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                        ),
                        'escape' => false,
                    )
                ),
                $socialshare_enable_plusicon,
                $socialshare_icon_limit,
                array(
                    'Text',
                    "limit_data",
                    array(
                        'label' => 'Count (number of page notes to show).',
                        'value' => 10,
                    ),
                ),
                array(
                    'Text',
                    'title_truncation',
                    array(
                        'label' => 'Enter Title truncation limit for list view.',
                        'value' => 45,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                array(
                    'Text',
                    'grid_description_truncation',
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
        'title' => 'SES - Page Notes Extension - Popular Page Notes Carousel',
        'description' => "Displays page notes in attractive carousel based on the chosen criteria in this widget. The placement of this widget is based on the criteria chosen.",
        'category' => 'SES - Page Notes Extension',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sespagenote.carousel',
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
                    'info',
                    array(
                        'label' => 'Choose Popularity Criteria.',
                        'multiOptions' => array(
                            "creation_date" => "Most Recent",
                            'modified_date' => "Recently Modified",
                            "like_count" => "Most Liked",
                            "comment_count" => "Most Commented",
                            "view_count" => "Most Viewed",
                            "favourite_count" => "Most Favorited",
                            "featured" => "Only Featured",
                            "sponsored" => "Only Sponsored",
                        )
                    ),
                    'value' => 'creation_date',
                ),
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show in this widget.",
                        'multiOptions' => array(
                            'title' => 'Note Title',
                            'by' => 'Owner Name',
                            'posteddate' => 'Created On',
                            'description' => "Description",
                            'likecount' => 'Likes Count',
                            'commentcount' => 'Comments Count ',
                            'favouritecount' => 'Favourites Count ',
                            'viewcount' => 'Views Count ',
                            'featured' => 'Featured Label',
                            'sponsored' => 'Sponsored Label',
                            'likeButton' => 'Like Button',
                            'favouriteButton' => "Favourite Button",
                            'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                        ),
                        'escape' => false,
                    )
                ),
                $socialshare_enable_plusicon,
                $socialshare_icon_limit,
                array(
                    'Text',
                    'grid_title_truncation',
                    array(
                        'label' => 'Enter Title truncation limit.',
                        'value' => 45,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                array(
                    'Text',
                    'grid_description_truncation',
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
                        'label' => 'Count (number of page notes to show).',
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
        'title' => 'SES - Page Note Extension - Page Note of the Day',
        'description' => 'This widget displays Page Note of the day. If there are more than 1 page notes marked as "of the day", then those will show randomly on each page refresh in this widget.',
        'category' => 'SES - Page Notes Extension',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sespagenote.of-the-day',
        'adminForm' => 'Sespagenote_Form_Admin_WidgetOfTheDay',
        'defaultParams' => array(
            'title' => 'Note of the Day',
        ),
    ),
    array(
        'title' => 'SES - Page Notes Extension - You May Also Like Page Notes',
        'description' => 'Displays the page notes which the current user viewing the widget may like.',
        'category' => 'SES - Page Notes Extension',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sespagenote.you-may-also-like-notes',
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'viewType',
                    array(
                        'label' => 'View Type',
                        'multiOptions' => array(
                            'list' => 'List View',
                            'grid' => 'Grid View'
                        ),
                        'value' => 'grid',
                    )
                ),
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show in this widget.",
                        'multiOptions' => array(
                            'title' => 'Note Title',
                            'by' => 'Owner Name',
                            'posteddate' => 'Created On',
                            'pagename' => "Page Name",
                            'likecount' => 'Likes Count',
                            'commentcount' => 'Comments Count ',
                            'favouritecount' => 'Favourites Count ',
                            'viewcount' => 'Views Count ',
                            'featured' => 'Featured Label',
                            'sponsored' => 'Sponsored Label',
                            'likeButton' => 'Like Button',
                            'favouriteButton' => "Favourite Button",
                            'griddescription' => "Show Description in Grid View",
                            'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                        ),
                        'escape' => false,
                    )
                ),
                $socialshare_enable_plusicon,
                $socialshare_icon_limit,
                array(
                    'Text',
                    'list_title_truncation',
                    array(
                        'label' => 'Enter Title truncation limit for list view.',
                        'value' => 45,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                array(
                    'Text',
                    'grid_title_truncation',
                    array(
                        'label' => 'Enter Title truncation limit for grid view.',
                        'value' => 45,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                array(
                    'Text',
                    'grid_description_truncation',
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
                    'height_grid',
                    array(
                        'label' => 'Enter the height of one block in Grid View (in pixels).',
                        'value' => '160',
                    )
                ),
                array(
                    'Text',
                    'width_grid',
                    array(
                        'label' => 'Enter the width of one block in Grid View (in pixels).',
                        'value' => '250',
                    )
                ),
                array(
                    'Text',
                    'limit_data',
                    array(
                        'label' => 'Count (number of page notes to show)',
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
        'title' => 'SES - Page Notes Extension - Info Sidebar',
        'description' => 'Displays a Page Note info (likes creation details, stats) on their view page. This widget should be placed in the right or left sidebar column on the "SES - Page Notes Extension - Page Note View Page".',
        'category' => 'SES - Page Notes Extension',
        'type' => 'widget',
        'name' => 'sespagenote.profile-info',
        'requirements' => array(
            'subject' => 'pagenote',
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
                            'by' => 'Created By',
                            'creationDate' => 'Created On',
                            'pagename' => 'Page Name',
                            'tag' => 'Tags',
                            'likecount' => 'Like Counts',
                            'commentcount' => 'Comment Counts',
                            'favouritecount' => 'Favourites Counts',
                            'viewcount' => 'View Counts',
                        ),
                    )
                ),
            )
        ),
    ),
    array(
        'title' => 'SES - Page Notes Extension - Recently Viewed Page Notes',
        'description' => 'Displays page notes which are viewed by current member / by his friends (if logged in) / by all members of your website. Edit this widget to configure various settings.',
        'category' => 'SES - Page Notes Extension',
        'type' => 'widget',
        'name' => 'sespagenote.recently-viewed-item',
        'autoEdit' => true,
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
                        'label' => "Choose from below the details that you want to show in this widget.",
                        'multiOptions' => array(
                            'title' => 'Note Title',
                            'by' => 'Owner Name',
                            'posteddate' => 'Created On',
                            'pagename' => "Page Name",
                            'likecount' => 'Likes Count',
                            'commentcount' => 'Comments Count ',
                            'favouritecount' => 'Favourites Count ',
                            'viewcount' => 'Views Count ',
                            'featured' => 'Featured Label',
                            'sponsored' => 'Sponsored Label',
                            'likeButton' => 'Like Button',
                            'favouriteButton' => "Favourite Button",
                            'griddescription' => "Show Description in Grid View",
                            'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                        ),
                        'escape' => false,
                    )
                ),
                $socialshare_enable_plusicon,
                $socialshare_icon_limit,
                array(
                    'Text',
                    'list_title_truncation',
                    array(
                        'label' => 'Enter Title truncation limit for list view.',
                        'value' => 45,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                array(
                    'Text',
                    'grid_title_truncation',
                    array(
                        'label' => 'Enter Title truncation limit for grid view.',
                        'value' => 45,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                array(
                    'Text',
                    'grid_description_truncation',
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
                    'height_grid',
                    array(
                        'label' => 'Enter the height of one block in Grid View (in pixels).',
                        'value' => '160',
                    )
                ),
                array(
                    'Text',
                    'width_grid',
                    array(
                        'label' => 'Enter the width of one block in Grid View (in pixels).',
                        'value' => '250',
                    )
                ),
                array(
                    'Text',
                    'limit_data',
                    array(
                        'label' => 'Count for (number of notes to show).',
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
        'title' => 'SES - Page Notes Extension - Other Page Note of Owner',
        'description' => "Displays page notes based on the chosen criteria in this widget. This widget will be placed on SES - Page Notes Extension - Page Note View Page.",
        'category' => 'SES - Page Notes Extension',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sespagenote.other-notes',
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
                    'info',
                    array(
                        'label' => 'Choose Popularity Criteria.',
                        'multiOptions' => array(
                            "creation_date" => "Most Recent",
                            'modified_date' => "Recently Modified",
                            "like_count" => "Most Liked",
                            "comment_count" => "Most Commented",
                            "view_count" => "Most Viewed",
                            "favourite_count" => "Most Favorited",
                            "featured" => "Only Featured",
                            "sponsored" => "Only Sponsored",
                        )
                    ),
                    'value' => 'creation_date',
                ),
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show in this widget.",
                        'multiOptions' => array(
                            'title' => 'Note Title',
                            'by' => 'Owner Name',
                            'posteddate' => 'Created On',
                            'pagename' => "Page Name",
                            'likecount' => 'Likes Count',
                            'commentcount' => 'Comments Count ',
                            'favouritecount' => 'Favourites Count ',
                            'viewcount' => 'Views Count ',
                            'featured' => 'Featured Label',
                            'sponsored' => 'Sponsored Label',
                            'likeButton' => 'Like Button',
                            'griddescription' => "Description for Grid View only",
                            'favouriteButton' => "Favourite Button",
                            'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                        ),
                        'escape' => false,
                    )
                ),
                $socialshare_enable_plusicon,
                $socialshare_icon_limit,
                array(
                    'Text',
                    'list_title_truncation',
                    array(
                        'label' => 'Enter Title truncation limit for list view.',
                        'value' => 45,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                array(
                    'Text',
                    'grid_title_truncation',
                    array(
                        'label' => 'Enter Title truncation limit for grid view.',
                        'value' => 45,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                array(
                    'Text',
                    'grid_description_truncation',
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
                    'height_grid',
                    array(
                        'label' => 'Enter the height of one block in Grid View (in pixels).',
                        'value' => '160',
                    )
                ),
                array(
                    'Text',
                    'width_grid',
                    array(
                        'label' => 'Enter the width of one block in Grid View (in pixels).',
                        'value' => '250',
                    )
                ),
                array(
                    'Text',
                    'limit_data',
                    array(
                        'label' => 'Count for (number of notes to show).',
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
        'title' => 'SES - Page Notes Extension - Popular Page Note',
        'description' => "Displays page notes based on the chosen criteria in this widget. The placement of this widget depend upon the criteria chosen.",
        'category' => 'SES - Page Notes Extension',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sespagenote.popular-notes',
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
                    'info',
                    array(
                        'label' => 'Choose Popularity Criteria.',
                        'multiOptions' => array(
                            "creation_date" => "Most Recent",
                            'modified_date' => "Recently Modified",
                            "like_count" => "Most Liked",
                            "comment_count" => "Most Commented",
                            "view_count" => "Most Viewed",
                            "favourite_count" => "Most Favorited",
                            "featured" => "Only Featured",
                            "sponsored" => "Only Sponsored",
                        )
                    ),
                    'value' => 'creation_date',
                ),
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show in this widget.",
                        'multiOptions' => array(
                            'title' => 'Note Title',
                            'by' => 'Owner Name',
                            'posteddate' => 'Created On',
                            'pagename' => "Page Name",
                            'likecount' => 'Likes Count',
                            'commentcount' => 'Comments Count ',
                            'favouritecount' => 'Favourites Count ',
                            'viewcount' => 'Views Count ',
                            'featured' => 'Featured Label',
                            'sponsored' => 'Sponsored Label',
                            'likeButton' => 'Like Button',
                            'griddescription' => "Description for Grid View only",
                            'favouriteButton' => "Favourite Button",
                            'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                        ),
                        'escape' => false,
                    )
                ),
                $socialshare_enable_plusicon,
                $socialshare_icon_limit,
                array(
                    'Text',
                    'list_title_truncation',
                    array(
                        'label' => 'Enter Title truncation limit for list view.',
                        'value' => 45,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                array(
                    'Text',
                    'grid_title_truncation',
                    array(
                        'label' => 'Enter Title truncation limit for grid view.',
                        'value' => 45,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                array(
                    'Text',
                    'grid_description_truncation',
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
                    'height_grid',
                    array(
                        'label' => 'Enter the height of one block in Grid View (in pixels).',
                        'value' => '160',
                    )
                ),
                array(
                    'Text',
                    'width_grid',
                    array(
                        'label' => 'Enter the width of one block in Grid View (in pixels).',
                        'value' => '250',
                    )
                ),
                array(
                    'Text',
                    'limit_data',
                    array(
                        'label' => 'Count for (number of notes to show).',
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
        'title' => 'SES - Page Notes Extension - Breadcrumb for Note View Page',
        'description' => 'Displays breadcrumb for Note. This widget should be placed on the Page Note Extension View page.',
        'category' => 'SES - Page Notes Extension',
        'autoEdit' => false,
        'type' => 'widget',
        'name' => 'sespagenote.profile-breadcrumb',
        'autoEdit' => true,
    ),
    array(
        'title' => 'SES - Page Notes Extension - Note Labels ',
        'description' => 'Displays a featured and sponsored on a note on it\'s profile.',
        'category' => 'SES - Page Notes Extension',
        'type' => 'widget',
        'name' => 'sespagenote.profile-label',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'MultiCheckbox',
                    'option',
                    array(
                        'label' => "Choose options to be shown in this widget.",
                        'multiOptions' => array(
                            'featured' => 'Featured Label',
                            'sponsored' => 'Sponsored Label',
                        ),
                    ),
                ),
            ),
        ),
    ),
    array(
        'title' => 'SES - Page Notes Extension - Note Gutter Menu',
        'description' => 'Displays a menu in the page note gutter on Page Note View Page only.',
        'category' => 'SES - Page Notes Extension',
        'type' => 'widget',
        'name' => 'sespagenote.profile-gutter-menu',
    ),
    array(
        'title' => 'SES - Page Notes Extension - Note Gutter Photo',
        'description' => 'Displays owner\'s or/and note\'s photo in the note gutter.',
        'category' => 'SES - Page Notes Extension',
        'type' => 'widget',
        'name' => 'sespagenote.profile-gutter-photo',
        'adminForm' => array(
            'elements' => array(
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show in this widget.",
                        'multiOptions' => array(
                            'featured' => 'Featured Label',
                            'sponsored' => 'Sponsored Label',
                            'by' => 'Owner\'s Name',
                            'ownerphoto' => 'Owner\'s Photo',
                        ),
                        'escape' => false,
                    )
                ),
            )
        ),
    ),
    array(
        'title' => 'SES - Page Notes Extension - Note View Page',
        'description' => 'Displays a page\'s notes on it\'s profile.',
        'category' => 'SES - Page Notes Extension',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sespagenote.profile-view-page',
        'requirements' => array(
            'subject' => 'pagenote',
        ),
        'adminForm' => array(
            'elements' => array(
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show in this widget.",
                        'multiOptions' => array(
                            'featured' => 'Featured Icon',
                            'sponsored' => 'Sponsored Icon',
                            'likecount' => 'Likes Count',
                            'commentcount' => 'Comments Count',
                            'viewcount' => 'Views Count',
                            'favouritecount' => "Favourite Count",
                            'posteddate' => "Posted Date",
                            'tags' => "Tags",
                            'by' => 'Owner\'s Name',
                            'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                            'siteshare' => "Share On Site",
                            'likeButton' => 'Like Button',
                            'favouriteButton' => 'Favourite Button',
                        ),
                        'escape' => false,
                    )
                ),
                $socialshare_enable_plusicon,
                $socialshare_icon_limit,
            )
        ),
    ),
    array(
        'title' => 'SES - Page Notes Extension - Page Profile Notes',
        'description' => 'Displays a page\'s notes on page profile.',
        'category' => 'SES - Page Notes Extension',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sespagenote.profile-notes',
        'defaultParams' => array(
            'title' => 'Notes',
            'titleCount' => false,
        ),
        'requirements' => array(
            'subject' => 'sespage_page',
        ),
        'adminForm' => array(
            'elements' => array(
                array(
                    'Radio',
                    'sort',
                    array(
                        'label' => 'Choose Note Display Criteria.',
                        'multiOptions' => array(
                            "creation_date" => "Recently Created",
                            "modified_date" => "Recently Modified",
                            "view_count" => "Most Viewed",
                            "like_count" => "Most Liked",
                            "comment_count" => "Most Commented",
                            "favourite_count" => "Most Favourite",
                            'featured' => "Only featured",
                            'sponsored' => "Only Sponsored",
                        ),
                        'value' => 'creation_date',
                    )
                ),
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show for notes in this widget.",
                        'multiOptions' => array(
                            'by' => 'Owner Name',
                            'pagename' => "Page Name",
                            'description' => 'Note Description',
                            'posteddate' => 'Created On',
                            'likecount' => 'Likes Count',
                            'commentcount' => 'Comments Count ',
                            'favouritecount' => 'Favourites Count ',
                            'viewcount' => 'Views Count ',
                            'featured' => 'Featured Label',
                            'sponsored' => 'Sponsored Label',
                            'likeButton' => 'Like Button',
                            'favouriteButton' => "Favourite Button",
                            'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                        ),
                        'escape' => false,
                    )
                ),
                $socialshare_enable_plusicon,
                $socialshare_icon_limit,
                array(
                    'Text',
                    'grid_title_truncation',
                    array(
                        'label' => 'Note title truncation limit.',
                        'value' => 45,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                array(
                    'Text',
                    'grid_description_truncation',
                    array(
                        'label' => 'Note Description truncation limit.',
                        'value' => 100,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                array(
                    'Radio',
                    'load_content',
                    array(
                        'label' => "Do you want the notes to be auto-loaded when users scroll down the page?",
                        'multiOptions' => array(
                            'auto_load' => 'Yes, Auto Load.',
                            'button' => 'No, show \'View more\' link.',
                            'pagging' => 'No, show \'Pagination\'.'
                        ),
                        'value' => 'auto_load',
                    )
                ),
                array(
                    'Text',
                    'limit_data',
                    array(
                        'label' => 'Count (number of notes to show.)',
                        'value' => 20,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
            )
        ),
    ),
);
