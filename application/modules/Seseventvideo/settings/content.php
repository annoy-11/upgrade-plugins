<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventvideo
 * @package    Seseventvideo
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: content.php 2016-07-28 00:00:00 SocialEngineSolutions $
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
 
$viewTypeStyle = array(
    'Select',
    'viewTypeStyle',
    array(
        'label' => 'Show Data in this widget on mouse over/fixed (work in grid view only)?',
        'multiOptions' => array(
            'mouseover' => 'Yes,on mouse over',
            'fixed' => 'No,not on mouse over'
        ),
        'value' => 'fixed',
    )
);
return array(
    array(
        'title' => 'SES - Advanced Events Video Ext - Event Profile Videos',
        'description' => 'Displays a event\'s videos on event profile page. The recommended page for this widget is "Event Profile Page".',
        'category' => 'SES - Advanced Events Video Ext',
        'type' => 'widget',
        'name' => 'seseventvideo.profile-videos',
        'autoEdit' => true,
        'adminForm' => 'Seseventvideo_Form_Admin_Settings_Profilevideos',
    ),
    array(
        'title' => "SES - Advanced Events Video Ext - Owner's Photo",
        'description' => 'This widget display on "SES - Advanced Events Video Ext - Video View Page".',
        'category' => 'SES - Advanced Events Video Ext',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'seseventvideo.owner-photo',
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
        'title' => 'SES - Advanced Events Video Ext - Featured / Sponsored Videos Carousel',
        'description' => "Disaplys Featured or Sponsored Carousel of Videos.",
        'category' => 'SES - Advanced Events Video Ext',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'seseventvideo.featured-sponsored-carosel',
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'featured_sponsored_carosel',
                    array(
                        'label' => "Choose the content you want to show in this widget.",
                        'multiOptions' => array(
                            'featured' => 'Featured',
                            'sponsored' => 'Sponsored',
                            'hot' => 'Hot',
														'all' => 'All',
                        ),
                        'value' => 'all',
                    )
                ),
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show for videos in this widget.",
                        'multiOptions' => array(
                            'like' => 'Likes Count',
                            'comment' => 'Comments Count',
                            'rating' => 'Rating Stars',
                            'view' => 'Views Count',
                            'title' => 'Title',
                            'by' => 'Owner\'s Name',
                            'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                            'favouriteCount' => 'Favourites Count',
                            'featured' => 'Featured Label',
														'sponsored' => 'Sponsored Label',
														'hot' => 'Hot',
														'duration' =>'Duration',
														'watchlater' =>'Watchlater',
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
                    'duration',
                    array(
                        'label' => 'Enter the delay time.',
                        'value' => '300',
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
								array(
                    'Text',
                    'bgColor',
                    array(
                        'label' => 'Enter the background color (worked for horizontal).',
                        'value' => '',
                    )
                ),
								array(
                    'Text',
                    'textColor',
                    array(
                        'label' => 'Enter the text color (worked for horizontal).',
                        'value' => '',
                    )
                ),
								array(
                    'Text',
                    'spacing',
                    array(
                        'label' => 'Enter the height of spacing from top container (worked for horizontal).',
                        'value' => '',
                    )
                ),
								array(
                    'Text',
                    'heightMain',
                    array(
                        'label' => 'Enter the height of Main Container (in pixels).',
                        'value' => '300',
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
                        'label' => 'Enter the height of one  block of item (in pixels).',
                        'value' => '200',
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
                        'label' => 'Enter the width of one  block of item(in pixels).',
                        'value' => '200',
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                array(
                    'Select',
                    'info',
                    array(
                        'label' => 'Choose Popularity Criteria.',
                        'multiOptions' => array(
                            "recently_created" => "Recently Created",
                            "most_viewed" => "Most Viewed",
                            "most_liked" => "Most Liked",
                            "most_rated" => "Most Rated",
                            "most_commented" => "Most Commented",
                            "most_favourite" => "Most Favourite",
                        )
                    ),
                    'value' => 'recently_updated',
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
                    'limit_data',
                    array(
                        'label' => 'Count (number of data to show.)',
                        'value' => 15,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                array(
                    'Radio',
                    'aliganment_of_widget',
                    array(
                        'label' => "Choose the View Type.",
                        'multiOptions' => array(
                            '1' => 'Horizontal',
                            '2' => 'Vertical',
                        ),
                        'value' => 1,
                    )
                )
            )
        ),
    ),
		array(
        'title' => 'SES - Advanced Events Video Ext - Featured / Sponsored Videos Fixed View',
        'description' => "Disaplys Featured or Sponsored Carousel of Videos.",
        'category' => 'SES - Advanced Events Video Ext',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'seseventvideo.featured-sponsored-fixed-view',
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'featured_sponsored_carosel',
                    array(
                        'label' => "Choose the content you want to show in this widget.",
                        'multiOptions' => array(
                            'featured' => 'Featured',
                            'sponsored' => 'Sponsored',
                            'hot' => 'Hot',
														'all' => 'All',
                        ),
                        'value' => 'all',
                    )
                ),
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show for videos in this widget.",
                        'multiOptions' => array(
                            'like' => 'Likes Count',
                            'comment' => 'Comments Count',
                            'rating' => 'Rating Stars',
                            'view' => 'Views Count',
                            'title' => 'Title',
                            'by' => 'Owner\'s Name',
                            'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                            'favouriteCount' => 'Favourites Count',
                            'featured' => 'Featured Label',
														'sponsored' => 'Sponsored Label',
														'hot' => 'Hot',
														'duration' =>'Duration',
														'watchlater' =>'Watchlater',
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
                    'heightMain',
                    array(
                        'label' => 'Height of First big video (in pixels).',
                        'value' => '300',
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
                        'label' => 'Enter the height of small videos (in pixels).',
                        'value' => '200',
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                array(
                    'Select',
                    'info',
                    array(
                        'label' => 'Choose Popularity Criteria.',
                        'multiOptions' => array(
                            "recently_created" => "Recently Created",
                            "most_viewed" => "Most Viewed",
                            "most_liked" => "Most Liked",
                            "most_rated" => "Most Rated",
                            "most_commented" => "Most Commented",
                            "most_favourite" => "Most Favourite",
                        )
                    ),
                    'value' => 'recently_updated',
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
                    'limit_data',
                    array(
                        'label' => 'Count (number of data to show.)',
                        'value' => 15,
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
        'title' => 'SES - Advanced Events Video Ext - Video Browse Search',
        'description' => 'Displays a search form in the video  browse page as placed by you. Edit this widget to choose the search option to be shown in the search form.',
        'category' => 'SES - Advanced Events Video Ext',
        'type' => 'widget',
        'name' => 'seseventvideo.browse-search',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
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
                            'mostSPrated' => 'Most Rated',
                            'mostSPfavourite' => 'Most Favourite',
                            'featured' => 'Only Featured',
                            'sponsored' => 'Only Sponsored',
                            'verified' => 'Only Verified',
                            'hot' => 'Only Hot'
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
                            'mostSPrated' => 'Most Rated',
                            'mostSPfavourite' => 'Most Favourite',
                            'featured' => 'Only Featured',
                            'sponsored' => 'Only Sponsored',
                            'hot' => 'Only Hot'
                        ),
                    )
                ),
                array(
                    'Radio',
                    'search_title',
                    array(
                        'label' => "Show \'Search Videos field?",
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
                array(
                    'Radio',
                    'location',
                    array(
                        'label' => "Show \'Location\' search field?",
                        'multiOptions' => array(
                            'yes' => 'Yes',
                            'no' => 'No'
                        ),
                        'value' => 'yes',
                    )
                ),
                array(
                    'Radio',
                    'kilometer_miles',
                    array(
                        'label' => "Show \'Kilometer or Miles\' search field?",
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
        'title' => 'SES - Advanced Events Video Ext - Popular / Featured / Sponsored Videos',
        'description' => "Displays videos as chosen by you based on chosen criteria for this widget. The placement of this widget depends on the criteria chosen for this widget.",
        'category' => 'SES - Advanced Events Video Ext',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'seseventvideo.featured-sponsored',
        'adminForm' => array(
            'elements' => array(
								array(
                    'Select',
                    'type',
                    array(
                        'label' => 'Choose the view type.',
                        'multiOptions' => array(
                            "list" => "List",
                            "grid" => "Grid"
                        )
                    ),
                    'value' => 'list'
								),
								$viewTypeStyle
								,
                array(
                    'Select',
                    'criteria',
                    array(
                        'label' => "Display Content",
                        'multiOptions' => array(
                            '5' => 'All including Featured and Sponsored',
                            '1' => 'Only Featured',
                            '2' => 'Only Sponsored',
                            '6' => 'Only Hot',
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
                            "recently_created" => "Recently Created",
                            "most_viewed" => "Most Viewed",
                            "most_liked" => "Most Liked",
                            "most_rated" => "Most Rated",
                            "most_commented" => "Most Commented",
                            "most_favourite" => "Most Favourite",
                        )
                    ),
                    'value' => 'recently_created',
                ),
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show for video in this widget.",
                        'multiOptions' => array(
                            'like' => 'Likes Count',
                            'comment' => 'Comments Count',
                            'rating' => 'Rating Stars',
                            'favourite' => 'Favourite Count',
                            'view' => 'Views Count',
                            'title' => 'Video Title',
                            'by' => 'Owner\'s Name',
                            'category' => 'Category',
                            'duration' => 'Duration',
                            'watchLater' => 'WatchLater' ,
														'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
														'likeButton' => 'Like Button for Grid view only',
                            'favouriteButton' => 'Favourite Button for Grid view only',
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
                        'label' => 'Video title truncation limit.',
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
                        'label' => 'Enter the height of one video block (in pixels).',
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
                        'label' => 'Enter the width of one video block (in pixels).',
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
                        'label' => 'Count (number of videos to show).',
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
        'title' => 'SES - Advanced Events Video Ext - Recently Viewed Videos',
        'description' => 'This widget displays the recently viewed videos by the user who is currently viewing your website or by the logged in members friend or by all the members of your website. Edit this widget to choose whose recently viewed content will show in this widget.',
        'category' => 'SES - Advanced Events Video Ext',
        'type' => 'widget',
        'name' => 'seseventvideo.recently-viewed-item',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
								array(
                    'Select',
                    'type',
                    array(
                        'label' => 'Choose the view type.',
                        'multiOptions' => array(
                            "list" => "List",
                            "grid" => "Grid"
                        )
                    ),
                    'value' => 'list'
								),
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
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show for video in this widget.",
                        'multiOptions' => array(
                            'like' => 'Likes Count',
                            'comment' => 'Comments Count',
                            'rating' => 'Rating Stars',
                            'favourite' => 'Favourite Count',
                            'view' => 'Views Count',
                            'title' => 'Video Title',
                            'by' => 'Owner\'s Name',
                            'category' => 'Category',
                            'duration' => 'Duration',
                            'watchLater' => 'WatchLater' ,
                        ),
                    )
                ),
                array(
                    'Text',
                    'title_truncation',
                    array(
                        'label' => 'Video title truncation limit.',
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
                        'label' => 'Enter the height of one video block (in pixels).',
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
                        'label' => 'Enter the width of one video block (in pixels).',
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
                        'label' => 'Count (number of video to show.)',
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
        'title' => 'Advanced Events Video Ext - Video of the Day',
        'description' => "This widget displays videos of the day as chosen by you from the Edit Settings of this widget.",
        'category' => 'SES - Advanced Events Video Ext',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'seseventvideo.of-the-day',
        'adminForm' => array(
            'elements' => array(
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show for videos in this widget.",
                        'multiOptions' => array(
                            'like' => 'Likes Count',
                            'comment' => 'Comments Count',
														'favourite' => 'Favourite Count',
                            'rating' => 'Rating Stars',
                            'view' => 'Views Count',
                            'title' => 'Video Title',
                            'by' => 'Owner\'s Name',
                            'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                            'featuredLabel' => 'Featured Label',
                            'sponsoredLabel' => 'Sponsored Label',
                            'hotLabel' => 'Hot Label',
                            'likeButton' => 'Like Button',
                            'favouriteButton' => 'Favourite Button',
														'watchLater' =>'Watch Later',
                            'videoListShow' => "Videos List Show Playlist",
														'duration' =>'Duration',
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
                        'label' => 'Video title truncation limit.',
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
                        'label' => 'Enter the height of one video block (in pixels).',
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
                        'label' => 'Enter the width of one video block (in pixels).',
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
        'title' => 'SES - Advanced Events Video Ext - Quick AJAX based Search',
        'description' => 'Displays a quick search box to enable users to quickly search Videos of their choice.',
        'category' => 'SES - Advanced Events Video Ext',
        'autoEdit' => true,
        'type' => 'widget',
        'name' => 'seseventvideo.search',
    ),
   
    array(
        'title' => 'SES - Advanced Events Video Ext - Breadcrumb for Video View Page',
        'description' => 'Displays breadcrumb for Video. This widget should be placed on the Advanced Video - View page.',
        'category' => 'SES - Advanced Events Video Ext',
        'autoEdit' => true,
        'type' => 'widget',
        'name' => 'seseventvideo.breadcrumb',
        'autoEdit' => true,
    ),
   
    array(
        'title' => 'SES - Advanced Events Video Ext - Tabbed Widget',
        'description' => 'Displays a tabbed widget for videos. You can place this widget anywhere on your site.',
        'category' => 'SES - Advanced Events Video Ext',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'seseventvideo.tabbed-widget-video',
        'requirements' => array(
            'subject' => 'seseventvideo_video',
        ),
        'adminForm' => 'Seseventvideo_Form_Admin_Settings_Tabbed',
    ),

    array(
        'title' => 'SES - Advanced Events Video Ext - Video Home No Video Message',
        'description' => 'Displays a message when there is no Video on your website. The recommended page for this widget is "Advanced Video - Video Home Page".',
        'category' => 'SES - Advanced Events Video Ext',
        'type' => 'widget',
        'name' => 'seseventvideo.video-home-error',
    ),
    
    array(
        'title' => 'SES - Advanced Events Video Ext - Video People Also Liked',
        'description' => 'Displays a list of other videos that the people who liked this video also liked.',
        'category' => 'SES - Advanced Events Video Ext',
        'type' => 'widget',
        'name' => 'seseventvideo.show-also-liked',
        'defaultParams' => array(
            'title' => 'People Also Liked',
        ),
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
								array(
                    'Select',
                    'type',
                    array(
                        'label' => 'Choose the view type.',
                        'multiOptions' => array(
                            "list" => "List",
                            "grid" => "Grid"
                        )
                    ),
                    'value' => 'list'
								),
								$viewTypeStyle,
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show for video in this widget.",
                        'multiOptions' => array(
                            'like' => 'Likes Count',
                            'comment' => 'Comments Count',
                            'rating' => 'Rating Stars',
                            'favourite' => 'Favourite Count',
                            'view' => 'Views Count',
                            'title' => 'Video Title',
                            'by' => 'Owner\'s Name',
                            'category' => 'Category',
                            'duration' => 'Duration',
                            'watchLater' => 'WatchLater' ,
                        ),
                    )
                ),
                array(
                    'Text',
                    'title_truncation',
                    array(
                        'label' => 'Video title truncation limit.',
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
                        'label' => 'Enter the height of one video block (in pixels).',
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
                        'label' => 'Enter the width of one video block (in pixels).',
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
                        'label' => 'Count (number of videos to show).',
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
        'title' => 'SES - Advanced Events Video Ext - Other Videos From Member',
        'description' => 'Displays a list of other videos that the member that uploaded this video uploaded.',
        'category' => 'SES - Advanced Events Video Ext',
        'type' => 'widget',
        'name' => 'seseventvideo.show-same-poster',
        'defaultParams' => array(
            'title' => 'From the same member',
        ),
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'type',
                    array(
                        'label' => 'Choose the view type.',
                        'multiOptions' => array(
                            "list" => "List",
                            "grid" => "Grid"
                        )
                    ),
                    'value' => 'list'
								),
								$viewTypeStyle,
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show for video in this widget.",
                        'multiOptions' => array(
                            'like' => 'Likes Count',
                            'comment' => 'Comments Count',
                            'rating' => 'Rating Stars',
                            'favourite' => 'Favourite Count',
                            'view' => 'Views Count',
                            'title' => 'Video Title',
                            'by' => 'Owner\'s Name',
                            'category' => 'Category',
                            'duration' => 'Duration',
                            'watchLater' => 'WatchLater' ,
                        ),
                    )
                ),
                array(
                    'Text',
                    'title_truncation',
                    array(
                        'label' => 'Video title truncation limit.',
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
                        'label' => 'Enter the height of one video block (in pixels).',
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
                        'label' => 'Enter the width of one video block (in pixels).',
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
                        'label' => 'Count (number of videos to show).',
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
        'title' => 'SES - Advanced Events Video Ext - Similar Videos',
        'description' => 'Displays a list of other videos that are similar to the current video, based on tags.',
        'category' => 'SES - Advanced Events Video Ext',
        'type' => 'widget',
        'name' => 'seseventvideo.show-same-tags',
        'defaultParams' => array(
            'title' => 'Similar Videos',
        ),
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
               array(
                    'Select',
                    'type',
                    array(
                        'label' => 'Choose the view type.',
                        'multiOptions' => array(
                            "list" => "List",
                            "grid" => "Grid"
                        )
                    ),
                    'value' => 'list'
								),
								$viewTypeStyle,
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show for video in this widget.",
                        'multiOptions' => array(
                            'like' => 'Likes Count',
                            'comment' => 'Comments Count',
                            'rating' => 'Rating Stars',
                            'favourite' => 'Favourite Count',
                            'view' => 'Views Count',
                            'title' => 'Video Title',
                            'by' => 'Owner\'s Name',
                            'category' => 'Category',
                            'duration' => 'Duration',
                            'watchLater' => 'WatchLater' ,
                        ),
                    )
                ),
                array(
                    'Text',
                    'title_truncation',
                    array(
                        'label' => 'Video  title truncation limit.',
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
                        'label' => 'Enter the height of one video block (in pixels).',
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
                        'label' => 'Enter the width of one video block (in pixels).',
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
                        'label' => 'Count (number of videos to show).',
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
        'title' => 'SES - Advanced Events Video Ext - Video Labels ',
        'description' => 'Displays a featured, sponsored , verified and hot on a video on it\'s profile.',
        'category' => 'SES - Advanced Events Video Ext',
        'type' => 'widget',
        'name' => 'seseventvideo.chanel-video-label',
				'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
						 array(
												'MultiCheckbox',
												'option',
												array(
														'label' => "Choose options to be shown in this widget.",
														'multiOptions' => array(
																'hot' => 'Hot',
																'featured' => 'Featured',
																'sponsored' => 'Sponsored',
																'verified' => 'Verified',
																'offtheday' => 'Of The Day',
														),
												)
										),
						   ),
				 ),
    ),

    array(
        'title' => 'SES - Advanced Events Video Ext - People favourite Video',
        'description' => 'Placed on  a video\'s view page.',
        'category' => 'SES - Advanced Events Video Ext',
        'type' => 'widget',
        'name' => 'seseventvideo.people-favourite-item',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'Text',
                    'limit_data',
                    array(
                        'label' => 'Show view more after how much data?.',
                        'value' => 11,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
            )
        )
    ),
    array(
        'title' => 'SES - Advanced Events Video Ext - People like Video',
        'description' => 'Placed on  a video\'s view page.',
        'category' => 'SES - Advanced Events Video Ext',
        'type' => 'widget',
        'name' => 'seseventvideo.people-like-item',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'Text',
                    'limit_data',
                    array(
                        'label' => 'Show view more after how much data?.',
                        'value' => 11,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
            )
        )
    ),
    array(
        'title' => 'SES - Advanced Events Video Ext - Video View Page',
        'description' => 'Displays a video\'s view page.',
        'category' => 'SES - Advanced Events Video Ext',
        'type' => 'widget',
        'name' => 'seseventvideo.video-view-page',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'MultiCheckbox',
                    'advSearchOptions',
                    array(
                        'label' => "Choose options to be shown in this widget.",
                        'multiOptions' => array(
                            'likeCount' => 'Likes Count',
                            'viewCount' => 'Views Count',
                            'commentCount' => 'Comments Count',
                            'favouriteButton' => 'Favourite Button',
                            'watchLater' => 'Watch Later Button',
                            'favouriteCount' => 'Favourites Count',
                            'rateCount' => 'Rating Stars',
                            'openVideoLightbox' => 'Video Lightbox Button',
                            'editVideo' => 'Edit Button',
                            'deleteVideo' => 'Delete Button',
                            'embedVideo' => 'Embed Button',
                            'shareSimple' => 'Simple Share Button',
                            'shareAdvance' => 'Advance Share Button',
                            'reportVideo' => 'Report Button',
														'peopleLike' => 'User like this video',
														'favourite' => 'Show Favourite',
														'comment' =>'Show Comments',
														'artist' =>'Show Artists',
                        ),
                    )
                ),
								array(
                    'Select',
                    'autoplay',
                    array(
                        'label' => "Autoplay Video ?",
                        'multiOptions' => array(
                            '1' => 'Yes,autoplay video',
                            '0' => 'No,don\'t autoplay video',
                        ),
                        'value' => '0',
                    )
                ),
								 array(
                    'Text',
                    'likelimit_data',
                    array(
                        'label' => 'Show view more for user like after how much data?',
                        'value' => 11,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
								array(
                    'Text',
                    'favouritelimit_data',
                    array(
                        'label' => 'Show view more for show favourite after how much data?',
                        'value' => 11,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                array(
                    'MultiCheckbox',
                    'advShareOptions',
                    array(
                        'label' => "Choose options to be shown in Advance Share in this widget.",
                        'multiOptions' => array(
                            'privateMessage' => 'Private Message',
                            'siteShare' => 'Site Share',
                            'quickShare' => 'Quick Share',
                            'addThis' => 'Add This Share Links',
                            'embed' => 'Embed Code',
                        ),
                    )
                ),
            )
        ),
    ),
    array(
        'title' => 'SES - Advanced Events Video Ext - Popularity Videos Widget',
        'description' => 'Displays a videos according to popularity.',
        'category' => 'SES - Advanced Events Video Ext',
        'type' => 'widget',
        'name' => 'seseventvideo.popularity-videos',
        'adminForm' => array(
        'elements' => array(
                array(
                    'Select',
                    'popularity',
                    array(
                        'label' => 'Popularity Criteria',
                        'multiOptions' => array(
                            'is_featured' => 'Only Featured',
                            'is_sponsored' => 'Only Sponsored',
                            'is_hot' => 'Only Hot',
                            'view_count' => 'Most Viewed',
														'like_count' => 'Most Liked',
                            'creation_date' => 'Most Recent',
                            'modified_date' => 'Recently Updated',
                            'favourite_count' => "Most Favorite",
                        ),
                        'value' => 'creation_date',
                    )
                ),
							  array(
                    'Text',
                    'textVideo',
                    array(
                        'label' => 'Text Heading For Videos.',
                        'value' => 'Videos we love',
                    )
                ),
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Data show in videos ?",
                        'multiOptions' => array(
                            'featuredLabel' => 'Featured Label',
                            'sponsoredLabel' => 'Sponsored Label',
														'hotLabel'=>'Hot Label',
                            'like' => 'Likes',
                            'comment' => 'Comments',
                            'rating' => 'Ratings',
														'favourite'=>'Favourite',
                            'view' => 'Views',
                            'title' => 'Titles',
                            'by' => 'Item Owner Name',
														'watchnow' =>'Watch Now Button'
                        ),
                    )
                ),
                array(
							    'Radio',
							    'pagging',
							    array(
						        'label' => "Do you want the videos to be auto-loaded when users scroll down the page?",
						        'multiOptions' => array(
						            'button' => 'View more',
						            'auto_load' => 'Auto Load',
						            'pagging' => 'Pagination',
						            'fixedbutton' => 'Fixed Data'
						        ),
						        'value' => 'fixedbutton',
							    )
								),
                array(
                    'Text',
                    'video_limit',
                    array(
                        'label' => 'count (number of videos to show).',
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
                        'label' => 'Enter the height of one block (in pixels,this setting will effect after 3 designer blocks).',
                        'value' => '160px',
                    )
                ),
                array(
                    'Text',
                    'width',
                    array(
                        'label' => 'Enter the width of one block (in pixels,this setting will effect after 3 designer blocks).',
                        'value' => '160px',
                    )
                ),
            ),
            ),
        ),
        array(
          'title' => 'SES - Advanced Events Video Ext - Video Location Page',
          'description' => 'Displays a video\'s location.',
          'category' => 'SES - Advanced Events Video Ext',
          'type' => 'widget',
          'name' => 'seseventvideo.video-location',
          'autoEdit' => true,
          'adminForm' => 'Seseventvideo_Form_Admin_Location',   
    ),
    
 );
?>