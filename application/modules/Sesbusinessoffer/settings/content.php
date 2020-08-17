<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessoffer
 * @package    Sesbusinessoffer
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: content.php  2019-03-30 00:00:00 SocialEngineSolutions $
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
$options = array('recentlySPcreated' => 'Recently Created', 'mostSPviewed' => 'Most Viewed','mostSPliked' => 'Most Liked','mostSPcommented' => 'Most Commented','featured' => 'Only Featured','hot' => 'Only Hot','new' => 'Only New');
// $viewOptions = array('0' => 'All Business Directories','4' => 'Open Business Directories','5' => 'Closed Business Directories','1' => 'Only My Friend\'s Business Directories','2' => 'Only My Network Business Directories','3' => 'Only My Businesss Directories');


return array(
    array(
        'title' => 'SES - Business Offers Extension - Info Sidebar',
        'description' => 'Displays a Business Offer info (likes creation details, stats) on their view business. This widget should be placed in the right or left sidebar column on the "SES - Business Offers Extension - Business Offer View Business".',
        'category' => 'SES - Business Offers Extension',
        'type' => 'widget',
        'name' => 'sesbusinessoffer.profile-info',
        'requirements' => array(
            'subject' => 'businessoffer',
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
                            'businessname' => 'Business Name',
                            'likecount' => 'Like Counts',
                            'followcount' => 'Follows Count ',
                            'favouritecount' => 'Favourites Count ',
                            'commentcount' => 'Comment Counts',
                            'viewcount' => 'View Counts',
                            'totalquantitycount' => 'Total Quantity',
                        ),
                    )
                ),
            )
        ),
    ),
    array(
        'title' => 'SES - Business Offers Extension - Recently Viewed Business Offers',
        'description' => 'Displays business offers which are viewed by current member / by his friends (if logged in) / by all members of your website. Edit this widget to configure various settings.',
        'category' => 'SES - Business Offers Extension',
        'type' => 'widget',
        'name' => 'sesbusinessoffer.recently-viewed-item',
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
                        'label' => "Choose from below the details that you want to show for offers in this widget.",
                        'multiOptions' => array(
                            'title' => 'Offer Title',
                            'by' => 'Owner Name',
                            'businessname' => "Business Name",
                            'description' => 'Offer Description',
                            'posteddate' => 'Created On',
                            'likecount' => 'Likes Count',
                            'followcount' => 'Follows Count ',
                            'favouritecount' => 'Favourites Count ',
                            'commentcount' => 'Comments Count ',
                            'viewcount' => 'Views Count',
                            'totalquantitycount' => 'Total Quantity Count',
                            'offerlink' => 'Offer Link',
                            'offertypevalue' => "Offer Type / Value",
                            'showcouponcode' => "Show Coupon Code",
                            'claimedcount' => "Claimed Count",
                            'remainingcount' => "Remaining Count",
                            'getofferlink' => "Get Offer Link",
                            'featured' => 'Featured Label',
                            'hot' => 'Hot Label',
                            'new' => 'New Label',
                            'likeButton' => 'Like Button',
                            'favouriteButton' => "Favourite Button",
                            'followButton' => "Follow Button",
                            'griddescription' => "Description for Grid View only",
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
                        'label' => 'Count for (number of offers to show).',
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
        'title' => 'SES - Business Offers Extension - Other Business Offer of Owner',
        'description' => "Displays business offers based on the chosen criteria in this widget. This widget will be placed on SES - Business Offers Extension - Business Offer View Business.",
        'category' => 'SES - Business Offers Extension',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesbusinessoffer.other-offers',
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
                            "favourite_count" => "Most Favourite",
                            "follw_count" => "Most Followed",
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
                        'label' => "Choose from below the details that you want to show for offers in this widget.",
                        'multiOptions' => array(
                            'title' => 'Offer Title',
                            'by' => 'Owner Name',
                            'businessname' => "Business Name",
                            'description' => 'Offer Description',
                            'posteddate' => 'Created On',
                            'likecount' => 'Likes Count',
                            'commentcount' => 'Comments Count ',
                            'followcount' => 'Follows Count ',
                            'favouritecount' => 'Favourites Count ',
                            'viewcount' => 'Views Count',
                            'totalquantitycount' => 'Total Quantity Count',
                            'offerlink' => 'Offer Link',
                            'offertypevalue' => "Offer Type / Value",
                            'showcouponcode' => "Show Coupon Code",
                            'claimedcount' => "Claimed Count",
                            'remainingcount' => "Remaining Count",
                            'getofferlink' => "Get Offer Link",
                            'featured' => 'Featured Label',
                            'hot' => 'Hot Label',
                            'new' => 'New Label',
                            'likeButton' => 'Like Button',
                            'favouriteButton' => "Favourite Button",
                            'followButton' => "Follow Button",
                            'griddescription' => "Description for Grid View only",
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
                        'label' => 'Count for (number of offers to show).',
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
        'title' => 'SES - Business Offers Extension - Breadcrumb for Offer View Business',
        'description' => 'Displays breadcrumb for Offer. This widget should be placed on the Business Offer Extension View business.',
        'category' => 'SES - Business Offers Extension',
        'autoEdit' => false,
        'type' => 'widget',
        'name' => 'sesbusinessoffer.profile-breadcrumb',
        'autoEdit' => true,
    ),
    array(
        'title' => 'SES - Business Offers Extension - Offer Labels ',
        'description' => 'Displays a featured, hot and new on a offer on it\'s profile.',
        'category' => 'SES - Business Offers Extension',
        'type' => 'widget',
        'name' => 'sesbusinessoffer.profile-label',
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
                            'hot' => 'Hot Label',
                            'new' => 'New Label',
                        ),
                    ),
                ),
            ),
        ),
    ),
    array(
        'title' => 'SES - Business Offers Extension - Offer Gutter Menu',
        'description' => 'Displays a menu in the business offer gutter on Business Offer View Business only.',
        'category' => 'SES - Business Offers Extension',
        'type' => 'widget',
        'name' => 'sesbusinessoffer.profile-gutter-menu',
    ),
    array(
        'title' => 'SES - Business Offers Extension - Offer Gutter Photo',
        'description' => 'Displays owner\'s or/and offer\'s photo in the offer gutter.',
        'category' => 'SES - Business Offers Extension',
        'type' => 'widget',
        'name' => 'sesbusinessoffer.profile-gutter-photo',
        'adminForm' => array(
            'elements' => array(
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show in this widget.",
                        'multiOptions' => array(
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
        'title' => 'SES - Business Offers Extension - Offer View Business',
        'description' => 'Displays a business\'s offers on it\'s profile.',
        'category' => 'SES - Business Offers Extension',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesbusinessoffer.profile-view-business',
        'requirements' => array(
            'subject' => 'businessoffer',
        ),
        'adminForm' => array(
            'elements' => array(
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show for offers in this widget.",
                        'multiOptions' => array(
                            'by' => 'Owner Name',
                            'businessname' => "Business Name",
                            'posteddate' => 'Created On',
                            'likecount' => 'Likes Count',
                            'followcount' => 'Follows Count ',
                            'favouritecount' => 'Favourites Count ',
                            'commentcount' => 'Comments Count ',
                            'viewcount' => 'Views Count',
                            'totalquantitycount' => 'Total Quantity Count',
                            'offerlink' => 'Offer Link',
                            'showcouponcode' => "Show Coupon Code",
                            'claimedcount' => "Claimed Count",
                            'remainingcount' => "Remaining Count",
                            'offertypevalue' => "Offer Type / Value",
                            'showcouponcode' => "Show Coupon Code",
                            'claimedcount' => "Claimed Count",
                            'remainingcount' => "Remaining Count",
                            'getofferlink' => "Get Offer Link",
                            'featured' => 'Featured Label',
                            'hot' => 'Hot Label',
                            'new' => 'New Label',
                            'likeButton' => 'Like Button',
                            'favouriteButton' => "Favourite Button",
                            'followButton' => "Follow Button",
                            'description' => "Description",
                            'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
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
        'title' => 'SES - Business Offers Extension - Business Offers Slideshow',
        'description' => "Display business offers in slideshow in this widget.",
        'category' => 'SES - Business Offers Extension',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesbusinessoffer.slideshow',
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
                            "favourite_count" => "Most Favourite",
                            "follw_count" => "Most Followed",
                            "featured" => "Only Featured",
                            "hot" => "Only Hot",
                            "new" => "Only New",
                        )
                    ),
                    'value' => 'creation_date',
                ),
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show for offers in this widget.",
                        'multiOptions' => array(
                            'title' => 'Offer Title',
                            'by' => 'Owner Name',
                            'businessname' => "Business Name",
                            'description' => 'Offer Description',
                            'posteddate' => 'Created On',
                            'likecount' => 'Likes Count',
                            'followcount' => 'Follows Count ',
                            'favouritecount' => 'Favourites Count ',
                            'commentcount' => 'Comments Count ',
                            'viewcount' => 'Views Count',
                            'totalquantitycount' => 'Total Quantity Count',
                            'offerlink' => 'Offer Link',
                            'offertypevalue' => "Offer Type / Value",
                            'showcouponcode' => "Show Coupon Code",
                            'claimedcount' => "Claimed Count",
                            'remainingcount' => "Remaining Count",
                            'getofferlink' => "Get Offer Link",
                            'featured' => 'Featured Label',
                            'hot' => 'Hot Label',
                            'new' => 'New Label',
                            'likeButton' => 'Like Button',
                            'favouriteButton' => "Favourite Button",
                            'followButton' => "Follow Button",
                            'griddescription' => "Description for Grid View only",
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
                        'label' => 'Count (number of business offers to show).',
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
        'title' => 'SES - Business Offers Extension - Popular Business Offers Carousel',
        'description' => "Displays business offers in attractive carousel based on the chosen criteria in this widget. The placement of this widget is based on the criteria chosen.",
        'category' => 'SES - Business Offers Extension',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesbusinessoffer.carousel',
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
                            "favourite_count" => "Most Favourite",
                            "follw_count" => "Most Followed",
                            "featured" => "Only Featured",
                            "hot" => "Only Hot",
                            "new" => "Only New",
                        )
                    ),
                    'value' => 'creation_date',
                ),
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show for offers in this widget.",
                        'multiOptions' => array(
                            'title' => 'Offer Title',
                            'by' => 'Owner Name',
                            'businessname' => "Business Name",
                            'description' => 'Offer Description',
                            'posteddate' => 'Created On',
                            'likecount' => 'Likes Count',
                            'followcount' => 'Follows Count ',
                            'favouritecount' => 'Favourites Count ',
                            'commentcount' => 'Comments Count ',
                            'viewcount' => 'Views Count',
                            'totalquantitycount' => 'Total Quantity Count',
                            'offerlink' => 'Offer Link',
                            'offertypevalue' => "Offer Type / Value",
                            'showcouponcode' => "Show Coupon Code",
                            'claimedcount' => "Claimed Count",
                            'remainingcount' => "Remaining Count",
                            'getofferlink' => "Get Offer Link",
                            'featured' => 'Featured Label',
                            'hot' => 'Hot Label',
                            'new' => 'New Label',
                            'likeButton' => 'Like Button',
                            'favouriteButton' => "Favourite Button",
                            'followButton' => "Follow Button",
                            'griddescription' => "Description for Grid View only",
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
                        'label' => 'Count (number of business offers to show).',
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
        'title' => 'SES - Business Offers Extension - Browse Business Offers',
        'description' => 'Displays all the browse business offers on the business in different views.',
        'category' => 'SES - Business Offers Extension',
        'type' => 'widget',
        'name' => 'sesbusinessoffer.browse-offers',
        'autoEdit' => true,
        'adminForm' => 'Sesbusinessoffer_Form_Admin_Browse',
    ),
    array(
        'title' => 'SES - Business Offers Extension - Business Offers Browse Search',
        'description' => 'Displays search form in the Business Offers Browse Business. This widget should be placed on "Business Offers Browse Business".',
        'category' => 'SES - Business Offers Extension',
        'type' => 'widget',
        'autoEdit' => 'true',
        'name' => 'sesbusinessoffer.browse-search',
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
        'title' => 'SES - Business Offer Extension - Business Offer of the Day',
        'description' => 'This widget displays Business Offer of the day. If there are more than 1 business offers marked as "of the day", then those will show randomly on each business refresh in this widget.',
        'category' => 'SES - Business Offers Extension',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesbusinessoffer.of-the-day',
        'adminForm' => 'Sesbusinessoffer_Form_Admin_WidgetOfTheDay',
        'defaultParams' => array(
            'title' => 'Offer of the Day',
        ),
    ),
    array(
        'title' => 'SES - Business Offers Extension - Tabbed Widget for Popular Business Offers',
        'description' => 'Displays tabbed widget for business offers on your website. Edit this widget to choose and configure the tabs to be shown in this widget.',
        'category' => 'SES - Business Offers Extension',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesbusinessoffer.tabbed-widget-offer',
        'adminForm' => 'Sesbusinessoffer_Form_Admin_Tabbed',
    ),
    array(
        'title' => 'SES - Business Offers Extension - Browse Offers Business Button',
        'description' => 'This widget displays a button clicking on which users will be redirected to the "SES - Business Offers Extension - Browse Offers Business".',
        'category' => 'SES - Business Offers Extension',
        'type' => 'widget',
        'name' => 'sesbusinessoffer.browse-offer-button',
    ),
    array(
        'title' => 'SES - Business Offers Extension - Offer Home No Offer Message',
        'description' => 'Displays a message when there is no Offer on your website. The recommended business for this widget is "SES - Business Offers Extension - Offer Home Business".',
        'category' => 'SES - Business Offers Extension',
        'type' => 'widget',
        'name' => 'sesbusinessoffer.offer-home-error',
    ),
    array(
        'title' => 'SES - Business Offers Extension - Popular Business Offer',
        'description' => "Displays business offers based on the chosen criteria in this widget. The placement of this widget depend upon the criteria chosen.",
        'category' => 'SES - Business Offers Extension',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesbusinessoffer.popular-offers',
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
                            "favourite_count" => "Most Favourite",
                            "follw_count" => "Most Followed",
                            "featured" => "Only Featured",
                            "hot" => "Only Hot",
                            "new" => "Only New",
                        )
                    ),
                    'value' => 'creation_date',
                ),
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show for offers in this widget.",
                        'multiOptions' => array(
                            'title' => 'Offer Title',
                            'by' => 'Owner Name',
                            'businessname' => "Business Name",
                            'description' => 'Offer Description',
                            'posteddate' => 'Created On',
                            'likecount' => 'Likes Count',
                            'followcount' => 'Follows Count ',
                            'favouritecount' => 'Favourites Count ',
                            'commentcount' => 'Comments Count ',
                            'viewcount' => 'Views Count',
                            'totalquantitycount' => 'Total Quantity Count',
                            'offerlink' => 'Offer Link',
                            'offertypevalue' => "Offer Type / Value",
                            'showcouponcode' => "Show Coupon Code",
                            'claimedcount' => "Claimed Count",
                            'remainingcount' => "Remaining Count",
                            'getofferlink' => "Get Offer Link",
                            'featured' => 'Featured Label',
                            'hot' => 'Hot Label',
                            'new' => 'New Label',
                            'likeButton' => 'Like Button',
                            'favouriteButton' => "Favourite Button",
                            'followButton' => "Follow Button",
                            'griddescription' => "Description for Grid View only",
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
                        'label' => 'Count for (number of offers to show).',
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
        'title' => 'SES - Business Offers Extension - Business Profile Offers',
        'description' => 'Displays a business\'s offers on business profile business.',
        'category' => 'SES - Business Offers Extension',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesbusinessoffer.profile-offers',
        'defaultParams' => array(
            'title' => 'Offers',
            'titleCount' => false,
        ),
        'requirements' => array(
            'subject' => 'businesses',
        ),
        'adminForm' => array(
            'elements' => array(
                array(
                    'Radio',
                    'sort',
                    array(
                        'label' => 'Choose Offer Display Criteria.',
                        'multiOptions' => array(
                            "creation_date" => "Recently Created",
                            "modified_date" => "Recently Modified",
                            "view_count" => "Most Viewed",
                            "like_count" => "Most Liked",
                            "comment_count" => "Most Commented",
                            "favourite_count" => "Most Favourite",
                            "follw_count" => "Most Followed",
                            'featured' => "Only Featured",
                            'hot' => "Only Hot",
                            'new' => "Only New",
                        ),
                        'value' => 'creation_date',
                    )
                ),
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show for offers in this widget.",
                        'multiOptions' => array(
                            'by' => 'Owner Name',
                            'businessname' => "Business Name",
                            'description' => 'Offer Description',
                            'posteddate' => 'Created On',
                            'likecount' => 'Likes Count',
                            'followcount' => 'Follows Count ',
                            'favouritecount' => 'Favourites Count ',
                            'commentcount' => 'Comments Count ',
                            'viewcount' => 'Views Count',
                            'totalquantitycount' => 'Total Quantity Count',
                            'offerlink' => 'Offer Link',
                            'offertypevalue' => "Offer Type / Value",
                            'showcouponcode' => "Show Coupon Code",
                            'claimedcount' => "Claimed Count",
                            'remainingcount' => "Remaining Count",
                            'getofferlink' => "Get Offer Link",
                            'featured' => 'Featured Label',
                            'hot' => 'Hot Label',
                            'new' => 'New Label',
                            'likeButton' => 'Like Button',
                            'favouriteButton' => "Favourite Button",
                            'followButton' => "Follow Button",
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
                        'label' => 'Offer title truncation limit.',
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
                        'label' => 'Offer Description truncation limit.',
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
                        'label' => "Do you want the offers to be auto-loaded when users scroll down the business?",
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
                        'label' => 'Count (number of offers to show.)',
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
