<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagereview
 * @package    Sespagereview
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: content.php  2018-11-30 00:00:00 SocialEngineSolutions $
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
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        ),
    ),
);
$titleTruncationList = array(
    'Text',
    'list_title_truncation',
    array(
        'label' => 'Title truncation limit for List View.',
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
$photoHeight = array(
    'Text',
    'photo_height',
    array(
        'label' => 'Enter the height of grid photo block (in pixels).',
        'value' => '160',
    )
);
$photowidth = array(
    'Text',
    'photo_width',
    array(
        'label' => 'Enter the width of grid photo block (in pixels).',
        'value' => '250',
    )
);
$mageType = array(
    'Select',
    'imageType',
    array(
        'label' => "Image Type",
        'multiOptions' => array(
            'rounded' => 'Rounded View',
            'square' => 'Square View',
        ),
        'value' => 'square',
    )
);
$pagging = array(
    'Radio',
    'pagging',
    array(
        'label' => "Do you want the members to be auto-loaded when users scroll down the page?",
        'multiOptions' => array(
            'button' => 'View more',
            'auto_load' => 'Auto Load',
            'pagging' => 'Pagination'
        ),
        'value' => 'auto_load',
    )
);
return array(
    array(
        'title' => 'SES - Page Reviews Extension - Review Breadcrumb for View Page',
        'description' => 'Displays breadcrumb for Review. This widget should be placed on the SES - Page Review Extension - Review View Page.',
        'category' => 'SES - Page Reviews Extension',
        'autoEdit' => false,
        'type' => 'widget',
        'name' => 'sespagereview.breadcrumb-review',
    ),
    array(
        'title' => 'SES - Page Reviews Extension - Review Profile Options',
        'description' => 'Displays a menu of actions (edit, report, share, etc) that can be performed on a content on its profile. The recommended page for this widget is "SES - Page Review Extension - Review View Page".',
        'category' => 'SES - Page Reviews Extension',
        'type' => 'widget',
        'name' => 'sespagereview.review-profile-options',
        'autoEdit' => false,
    ),
    array(
        'title' => 'SES - Page Reviews Extension - Review Page Profile',
        'description' => 'Displays a page review entries on their profile. This widge is placed on "SES - Page Review Extension - Review View Page" only.',
        'category' => 'SES - Page Reviews Extension',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sespagereview.profile-review',
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
                            "share" => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                            "description" => "Description",
                            "recommended" => "Recommended",
                            'postedin' => "Posted In",
                            "creationDate" => "Creation Date",
                            'parameter' => 'Review Parameters',
                            'rating' => 'Rating Stars',
                            'voteButton' => 'Review Vote Button',
                            'likeButton' => 'Like Button',
                        )
                    ),
                    $socialshare_enable_plusicon,
                    $socialshare_icon_limit,
                )
            ),
        ),
    ),
    array(
        'title' => "SES - Page Reviews Extension - Review Owner's Photo",
        'description' => 'This widget display review owner photo. This widget is placed on "SES - Page Review Extension - Review View Page" only.',
        'category' => 'SES - Page Reviews Extension',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sespagereview.review-owner-photo',
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
            )
        ),
    ),
    array(
        'title' => "SES - Page Reviews Extension - Review Taker Photo",
        'description' => 'This widget display review taker photo. This widge is placed on "SES - Page Review Extension - Review View Page" only.',
        'category' => 'SES - Page Reviews Extension',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sespagereview.review-taker-photo',
        'defaultParams' => array(
            'title' => '',
        ),
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'showTitle',
                    array(
                        'label' => 'Page Name',
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
        'title' => 'SES - Page Reviews Extension - Profile Page Review',
        'description' => 'This widget display review of page. This widget placed on "Page Profile Page" only.',
        'category' => 'SES - Page Reviews Extension',
        'type' => 'widget',
        'name' => 'sespagereview.page-reviews',
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
                            "share" => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                            "report" => "Report Button",
                            "pros" => "Pros",
                            "cons" => "Cons",
                            "description" => "Description",
                            "recommended" => "Recommended",
                            'postedBy' => "Posted By",
                            'parameter' => 'Review Parameters',
                            "creationDate" => "Creation Date",
                            'rating' => 'Rating Stars',
                            'voteButton' => 'Review Vote Button',
                            'likeButton' => 'Like Button',
                        )
                    ),
                ),
                $socialshare_enable_plusicon,
                $socialshare_icon_limit,
            ),
        ),
    ),
    array(
        'title' => 'SES - Page Reviews Extension - Browse Page Reviews',
        'description' => 'Displays reviews for page. This widget is only placed on "SES - Page Review Extension - Browse Review Page" only.',
        'category' => 'SES - Page Reviews Extension',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sespagereview.browse-reviews',
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
                            "share" => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                            "report" => "Report Button",
                            "pros" => "Pros",
                            "cons" => "Cons",
                            "description" => "Description",
                            "recommended" => "Recommended",
                            'reviewOwnerName' => 'Review Owner Name',
                            'reviewOwnerPhoto' => 'Review Owner Photo',
                            'pageName' => 'Page Name',
                            'parameter' => 'Review Parameters',
                            "creationDate" => "Creation Date",
                            'rating' => 'Rating Stars',
                            'voteButton' => 'Review Vote Button',
                            'likeButton' => 'Like Button',
                        ),
                    )
                ),
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show for page in this widget.",
                        'multiOptions' => array(
                            'featuredLabel' => 'Featured Label',
                            'verifiedLabel' => 'Verified Label',
                        ),
                    ),
                ),
                array(
                    'Text',
                    'title_truncation',
                    array(
                        'label' => 'Title truncation limit.',
                        'value' => 45,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                array(
                    'Text',
                    'description_truncation',
                    array(
                        'label' => 'Description truncation limit.',
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
                        'label' => 'Enter the height of page photo block (in pixels).',
                        'value' => '100',
                    )
                ),
                array(
                    'Text',
                    'width',
                    array(
                        'label' => 'Enter the width of page photo block (in pixels).',
                        'value' => '100',
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                $socialshare_enable_plusicon,
                $socialshare_icon_limit,
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
        'title' => 'SES - Page Reviews Extension - Review Browse Search',
        'description' => 'Displays a search form in the review browse page. This widgets is placed on "SES - Page Directories - Browse Page Reviews Page" only.',
        'category' => 'SES - Page Reviews Extension',
        'type' => 'widget',
        'name' => 'sespagereview.browse-review-search',
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
                        'label' => "Show 'Review Title' search field?",
                        'multiOptions' => array(
                            '1' => 'Yes',
                            '0' => 'No'
                        ),
                        'value' => '1',
                    )
                ),
                array(
                    'MultiCheckbox',
                    'view',
                    array(
                        'label' => "Choose options to be shown in \'View\' search fields.",
                        'multiOptions' => array(
                            'likeSPcount' => 'Most Liked',
                            'viewSPcount' => 'Most Viewed',
                            'commentSPcount' => 'Most Commented',
                            'mostSPrated' => 'Most Rated',
                            Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagereview.review.first111', 'useful') . 'SPcount' => 'Most ' . Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagereview.review.first', 'Useful'),
                            Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagereview.review.second111', 'funny') . 'SPcount' => 'Most ' . Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagereview.review.second', 'Funny'),
                            Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagereview.review.third111', 'cool') . 'SPcount' => 'Most ' . Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagereview.review.third', 'Cool'),
                            'verified' => 'Verified Only',
                            'featured' => 'Featured Only',
                        ),
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
                    'network',
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
        'title' => 'SES - Page Reviews Extension - Page Review of the Day',
        'description' => "This widget displays review of the day as chosen by you from the Edit Settings of this widget.",
        'category' => 'SES - Page Reviews Extension',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sespagereview.review-of-the-day',
        'adminForm' => array(
            'elements' => array(
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show for page in this widget.",
                        'multiOptions' => array(
                            'title' => 'Display Name',
                            'like' => 'Likes Count',
                            'view' => 'Views Count',
                            'rating' => 'Ratings',
                            'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                            'featuredLabel' => 'Featured Label',
                            'verifiedLabel' => 'Verified Label',
                            'description' => 'Description',
                            'reviewOwnerName' => 'Review Owner Name',
                            'pageName' => 'Page Name',
                            'likeButton' => 'Like Button',
                        ),
                        'escape' => false,
                    ),
                ),
                $socialshare_enable_plusicon,
                $socialshare_icon_limit,
                array(
                    'Text',
                    'title_truncation',
                    array(
                        'label' => 'Title truncation limit.',
                        'value' => 45,
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
                        'label' => 'Enter the width of one page block (in pixels).',
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
        'title' => 'SES - Page Reviews Extension - Popular / Featured / Verified Page Reviews',
        'description' => "Displays page reviews as chosen by you based on chosen criteria for this widget. The placement of this widget depends on the criteria chosen for this widget.",
        'category' => 'SES - Page Reviews Extension',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sespagereview.popular-featured-verified-reviews',
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'info',
                    array(
                        'label' => 'Choose Popularity Criteria.',
                        'multiOptions' => array(
                            "creation_date" => "Recently Created",
                            "most_viewed" => "Most Viewed",
                            "most_liked" => "Most Liked",
                            "most_commented" => "Most Commented",
                            "most_rated" => "Most Rated",
                            "featured" => "Featured",
                            "verified" => "Verified",
                        )
                    ),
                    'value' => 'recently_updated',
                ),
                $mageType,
                array(
                    'Select',
                    'showLimitData',
                    array(
                        'label' => 'Do you want to show next/previous buttons in this widget.',
                        'multiOptions' => array(
                            "1" => "Yes, want to show next/previous buttons",
                            "0" => "No, don't want to show next/previous buttons",
                        )
                    ),
                    'value' => '1',
                ),
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show for page in this widget.",
                        'multiOptions' => array(
                            'title' => 'Review Title',
                            'like' => 'Likes Count',
                            'view' => 'Views Count',
                            'comment' => 'Comments Count',
                            'rating' => 'Ratings',
                            'verifiedLabel' => 'Verified Label',
                            'featuredLabel' => 'Featured Label',
                            'description' => 'Description',
                            'reviewOwnerName' => 'Review Owner Name',
                            'pageName' => 'Page Name',
                        ),
                    ),
                ),
                array(
                    'Text',
                    'title_truncation',
                    array(
                        'label' => 'Title truncation limit.',
                        'value' => 45,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                array(
                    'Text',
                    'review_description_truncation',
                    array(
                        'label' => 'Description truncation limit.',
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
                        'label' => 'Count (number of member to show).',
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
        'title' => 'SES - Page Reviews Extension - Browse Reviews Page Button',
        'description' => 'This widget displays a button clicking on which users will be redirected to the "SES - Page Reviews Extension - Browse Reviews Page".',
        'category' => 'SES - Page Reviews Extension',
        'type' => 'widget',
        'name' => 'sespagereview.browse-review-button',
        'requirements' => array(
            'no-subject',
        ),
    ),
    array(
        'title' => 'SES - Page Reviews Extension - Tabbed widget for Popular Page Reviews',
        'description' => 'Displays a tabbed widget for popular reviews on your website based on various popularity criterias. Edit this widget to configure various settings. This widget can be placed anywhere on your website.',
        'category' => 'SES - Page Reviews Extension',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sespagereview.tabbed-widget-review',
        'adminForm' => 'Sespagereview_Form_Admin_Settings_TabbedWidget',
    ),
);
