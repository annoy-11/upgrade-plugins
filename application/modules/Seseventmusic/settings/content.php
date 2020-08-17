<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventmusic
 * @package    Seseventmusic
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: content.php 2015-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
$songPopularityParameters = array(
    'Select',
    'popularity',
    array(
        'label' => 'Popularity Criteria',
        'multiOptions' => array(
            'featured' => 'Only Featured',
            'sponsored' => 'Only Sponsored',
            'hot' => 'Only Hot',
            'upcoming' => 'Only Latest',
            'bothfesp' => 'Both Featured and Sponsored',
            'view_count' => 'Most Viewed',
            'like_count' => 'Most Liked',
            'comment_count' => 'Most Commented',
            'download_count' => 'Most Downloaded',
            "play_count" => "Most Played",
            'favourite_count' => 'Most Favorite',
            'creation_date' => 'Most Recent',
            'rating' => 'Most Rated',
            'modified_date' => 'Recently Updated',
        ),
        'value' => 'creation_date',
    )
);


$albumPopularityParameters = array(
    'Select',
    'popularity',
    array(
        'label' => 'Popularity Criteria',
        'multiOptions' => array(
            'featured' => 'Only Featured',
            'sponsored' => 'Only Sponsored',
            'hot' => 'Only Hot',
            'upcoming' => 'Only Latest',
            'bothfesp' => 'Both Featured and Sponsored',
            'view_count' => 'Most Viewed',
            'like_count' => 'Most Liked',
            'comment_count' => 'Most Commented',
            'favourite_count' => 'Most Favorite',
            'creation_date' => 'Most Recent',
            'rating' => 'Most Rated',
            'modified_date' => 'Recently Updated',
            'song_count' => "Maximum Songs",
        ),
        'value' => 'creation_date',
    )
);

$view_type = array(
    'Select',
    'viewType',
    array(
        'label' => 'Choose the View Type.',
        'multiOptions' => array(
            'listview' => 'List View',
            'gridview' => 'Grid View'
        ),
        'value' => 'listview',
    )
);

$limit = array(
    'Text',
    'limit',
    array(
        'label' => 'Count (number of content to show)',
        'value' => 3,
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    ),
);

//Song information show
$songStats = array(
    'MultiCheckbox',
    'information',
    array(
        'label' => 'Choose the options that you want to be displayed in this widget.',
        'multiOptions' => array(
            "featured" => "Featured Label",
            "sponsored" => "Sponsored Label",
            "hot" => "Hot Label",
            "likeCount" => "Likes Count",
            "commentCount" => "Comments Count",
            "viewCount" => "Views Count",
            "downloadCount" => "Downloaded Count",
            "playCount" => "Plays Count",
            "ratingCount" => "Rating Stars",
            "title" => "Album Title",
            "postedby" => "Song Owner's Name"
        )
    ),
);


//Album information show
$AlbumStats = array(
    'MultiCheckbox',
    'information',
    array(
        'label' => 'Choose the options that you want to be displayed in this widget.',
        'multiOptions' => array(
            "featured" => "Featured Label",
            "sponsored" => "Sponsored Label",
            "hot" => "Hot Label",
            "likeCount" => "Likes Count",
            "commentCount" => "Comments Count",
            "viewCount" => "Views Count",
            "songsCount" => "Songs Count",
            "ratingCount" => "Rating Stars",
            "title" => "Music Album Title [For Grid View Only]",
            "postedby" => "Music Albums Owner's Name"
        )
    ),
);

$height = array(
    'Text',
    'height',
    array(
        'label' => 'Enter the height of one block [for Grid View (in pixels)].',
        'value' => 200,
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    ),
);

$width = array(
    'Text',
    'width',
    array(
        'label' => 'Enter the width of one block [for Grid View (in pixels)].',
        'value' => 200,
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    ),
);


$show_photo = array(
    'Select',
    'showPhoto',
    array(
        'label' => 'Do you want to show only those music albums which have main photos?',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No'
        ),
        'value' => '0'
    )
);

return array(
    array(
        'title' => 'SES - Advanced Events - Albums Browse Search',
        'description' => 'Displays a search form in the event music albums browse page. Edit this widget to choose the search option to be shown in the search form.',
        'category' => 'Advanced Events - Music Extension',
        'autoEdit' => true,
        'type' => 'widget',
        'name' => 'seseventmusic.browse-search',
        'adminForm' => array(
            'elements' => array(
                array(
                    'MultiCheckbox',
                    'searchOptionsType',
                    array(
                        'label' => "Choose from below the searching options that you want to show in this widget.",
                        'multiOptions' => array(
                            'searchBox' => 'Search Music Album',
                            'view' => 'View',
                            'show' => 'List By',
                        ),
                    )
                ),
            )
        ),
    ),
    array(
        'title' => 'SES - Advanced Events - Browse Music Albums',
        'description' => 'Displays all event music albums on your website. The recommended page for this widget is "SES - Advanced Events - Event Browse Music Albums Page".',
        'category' => 'Advanced Events - Music Extension',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'seseventmusic.browse-albums',
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
                    'Type',
                    array(
                        'label' => 'Do you want the music albums to be auto-loaded when users scroll down the page?',
                        'multiOptions' => array(
                            '1' => 'Yes',
                            '0' => 'No, show \'View More\''
                        ),
                        'value' => 1,
                    )
                ),
                array(
								    'Select',
								    'popularity',
								    array(
								        'label' => 'Popularity Criteria',
								        'multiOptions' => array(
								            'featured' => 'Only Featured',
								            'sponsored' => 'Only Sponsored',
								            'hot' => 'Only Hot',
								            'upcoming' => 'Only Latest',
								            'bothfesp' => 'Both Featured and Sponsored',
								            'view_count' => 'Most Viewed',
								            'like_count' => 'Most Liked',
								            'comment_count' => 'Most Commented',
								            'favourite_count' => 'Most Favorite',
								            'creation_date' => 'Most Recent',
								            'rating' => 'Most Rated',
								            'modified_date' => 'Recently Updated',
								            'song_count' => "Maximum Songs",
								        ),
								        'value' => 'creation_date',
								    )
								),
                array(
                    'MultiCheckbox',
                    'information',
                    array(
                        'label' => 'Choose the options that you want to be displayed in this widget.',
                        'multiOptions' => array(
                            "featured" => "Featured Label",
                            "sponsored" => "Sponsored Label",
                            "hot" => "Hot Label",
                            "likeCount" => "Likes Count",
                            "commentCount" => "Comments Count",
                            "viewCount" => "Views Count",
                            "ratingStars" => "Rating Stars",
                            "favouriteCount" => "Favorite Count [For List View Only]",
                            "ratingCount" => "Rating Count [For List View Only]",
                            "description" => "Description [For List View Only]",
                            "songCount" => "Songs Count",
                            "title" => "Music Album Title",
                            "postedby" => "Music Album Owner's Name",
                            "favourite" => "Favorite Icon on Mouse-Over",
                            "share" => "Share Icon on Mouse-Over",
                            'showSongsList' => "Show songs of each playlist [For List View Only]"
                        )
                    ),
                ),
                array(
                    'Text',
                    'height',
                    array(
                        'label' => 'Enter the height of one block [for Grid View (in pixels)].',
                        'value' => 200,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    ),
                ),
                array(
                    'Text',
                    'width',
                    array(
                        'label' => 'Enter the width of one block [for Grid View (in pixels)].',
                        'value' => 200,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    ),
                ),
                array(
                    'Text',
                    'itemCount',
                    array(
                        'label' => 'Count (number of music albums to show)',
                        'value' => 10,
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
        'title' => 'SES - Advanced Events - Recently Viewed Music Albums / Songs',
        'description' => 'This widget displays the recently viewed music albums or songs by the user who is currently viewing your website or by the logged in members friend. Edit this widget to choose whose recently viewed content will show in this widget.',
        'category' => 'Advanced Events - Music Extension',
        'type' => 'widget',
        'name' => 'seseventmusic.recently-viewed-item',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'category',
                    array(
                        'label' => 'Choose from below the content types that you want to show in this widget.',
                        'multiOptions' =>
                        array(
                            'seseventmusic_album' => 'Music Albums',
                            'seseventmusic_albumsong' => 'Songs',
                        ),
                    ),
                ),
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
                    'criteria',
                    array(
                        'label' => 'Popularity Criteria',
                        'multiOptions' =>
                        array(
                            'by_me' => 'Content viewed by me',
                            'by_myfriend' => 'Content viewed by my friends',
                        ),
                    ),
                ),
                array(
                    'MultiCheckbox',
                    'information',
                    array(
                        'label' => "Choose the options that you want to be displayed in this widget.",
                        'multiOptions' => array(
                            "hot" => "Hot Label",
                            "featured" => "Featured Label",
                            "sponsored" => "Sponsored Label",
                            "viewCount" => "Views Count",
                            "likeCount" => "Likes Count",
                            "songsCount" => "Songs Count [for Music Album]",
                            "ratingCount" => "Rating Stars",
                            "commentCount" => "Comments Count",
                            "downloadCount" => "Song Download Count [for songs]",
                            "share" => "Share Icon on Mouse-Over",
                            "postedby" => "Music Albums / Songs Owner's Name",
                            "favourite" => "Favorite Icon on Mouse-Over",
                        ),
                    )
                ),
                array(
                    'Text',
                    'Height',
                    array(
                        'label' => 'Enter the height of one block [for Grid View (in pixels)].',
                        'value' => '180',
                    )
                ),
                array(
                    'Text',
                    'Width',
                    array(
                        'label' => 'Enter the width of one block [for Grid View (in pixels)].',
                        'value' => '180',
                    )
                ),
                array(
                    'Text',
                    'limit_data',
                    array(
                        'label' => 'count (number of content to show)',
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
        'title' => 'SES - Advanced Events - Event Profile Music',
        'description' => 'Displays a event music albums on event profile. Edit this widget to choose content type to be shown. The recommended page for this widget is "Event Profile Page".',
        'category' => 'SES - Advanced Events',
        'type' => 'widget',
        'name' => 'seseventmusic.profile-musicalbums',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'MultiCheckbox',
                    'informationAlbum',
                    array(
                        'label' => 'Choose from below the details that you want to show for "Music Albums" shown in this widget.',
                        'multiOptions' => array(
                            "featured" => "Featured Label",
                            "sponsored" => "Sponsored Label",
                            "hot" => "Hot Label",
                            "postedBy" => "Song Owner\'s Name",
                            "commentCount" => "Comments Count",
                            "viewCount" => "Views Count",
                            "likeCount" => "Likes Count",
                            "ratingStars" => "Rating Stars",
                            "songCount" => "Song Count",
                            "favourite" => "Favorite Icon on Mouse-Over",
                            "share" => "Share Icon on Mouse-Over",
                        ),
                    ),
                ),
                array(
                    'Select',
                    'pagging',
                    array(
                        'label' => "Do you want the content to be auto-loaded when users scroll down the page?",
                        'multiOptions' => array(
                            'button' => 'No, show \'View more\'',
                            'auto_load' => 'Yes',
                        ),
                        'value' => 'auto_load',
                    )
                ),
                array(
                    'Text',
                    'Height',
                    array(
                        'label' => 'Enter the height of one block [for Grid View (in pixels)].',
                        'value' => '180',
                    )
                ),
                array(
                    'Text',
                    'Width',
                    array(
                        'label' => 'Enter the width of one block [for Grid View (in pixels)].',
                        'value' => '180',
                    )
                ),
                array(
                    'Text',
                    'limit_data',
                    array(
                        'label' => 'count (number of content to show)',
                        'value' => 3,
                    )
                ),
            )
        ),
    ),
    array(
        'title' => 'SES - Advanced Events - Popular / Recommended / Related / Owner\'s Other Songs',
        'description' => 'Displays songs based on chosen criteria for this widget. The placement of this widget depends on the criteria chosen for this widget.',
        'category' => 'Advanced Events - Music Extension',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'seseventmusic.popular-recommanded-other-related-songs',
        'adminForm' => array(
            'elements' => array(
                array(
                    'Radio',
                    'showType',
                    array(
                        'label' => "Show",
                        'multiOptions' => array(
                            'all' => 'Popular Songs [With this option, place this widget anywhere on your website. Choose criteria from "Popularity Criteria" setting below.]',
                            'recommanded' => 'Recommended Songs [With this option, place this widget anywhere on your website.]',
                            'other' => 'Song Owner\'s Other Albums [With this option, place this widget on SES - Advanced Events - Music Album View Page.]',
                            'related' => 'Related Songs [With this option, place this widget on SES - Advanced Events - Music Album View Page.]',
                            'otherSongView' => 'Other Songs of associated Music Album [With this option, place this widget on SES - Advanced Events - Song View Page.]',
                        ),
                        'value' => 'all',
                    ),
                ),
                $view_type,
                $songPopularityParameters,
                $songStats,
                $height,
                $width,
                $limit,
            )
        ),
    ),
    array(
        'title' => 'SES - Advanced Events - Popular / Recommended / Related / Owner\'s Other Music Albums',
        'description' => 'Displays music albums based on chosen criteria for this widget. The placement of this widget depends on the criteria chosen for this widget.',
        'category' => 'Advanced Events - Music Extension',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'seseventmusic.popular-recommanded-other-related-albums',
        'adminForm' => array(
            'elements' => array(
                array(
                    'Radio',
                    'showType',
                    array(
                        'label' => "Display",
                        'multiOptions' => array(
                            'all' => 'Popular Albums [With this option, place this widget anywhere on your website. Choose criteria from "Popularity Criteria" setting below.]',
                            'recommanded' => 'Recommended Albums [With this option, place this widget anywhere on your website.]',
                            'other' => 'Music Album Owner\'s Other Albums [With this option, place this widget on SES - Advanced Events - Music Album View Page.]',
                            'related' => 'Related Albums [With this option, place this widget on SES - Advanced Events - Music Album View Page.]',
                        ),
                        'value' => 'all',
                    ),
                ),
                $albumPopularityParameters,
                $view_type,
                $show_photo,
                $AlbumStats,
                $height,
                $width,
                $limit,
            )
        ),
    ),
    array(
        'title' => 'SES - Advanced Events - Profile Options for Music Album / Song',
        'description' => 'Displays a menu of actions (edit, report, add to favorite, share, etc) that can be performed on a music album / song on its profile. The recommended page for this widget is "SES - Advanced Events - Music Album View Page" / "SES - Advanced Events - Song View Page".',
        'category' => 'Advanced Events - Music Extension',
        'type' => 'widget',
        'name' => 'seseventmusic.profile-options',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'viewPageType',
                    array(
                        'label' => "Choose Content Type.",
                        'multiOptions' => array(
                            'album' => 'Music Album',
                            'song' => 'Song',
                        ),
                        'value' => 'album',
                    ),
                ),
                array(
                    'Select',
                    'viewType',
                    array(
                        'label' => "Choose the View Type.",
                        'multiOptions' => array(
                            'horizontal' => 'Horizontal',
                            'vertical' => 'Vertical',
                        ),
                        'value' => 'vertical',
                    ),
                ),
            ),
        ),
    ),
    array(
        'title' => 'SES - Advanced Events - Song Cover',
        'description' => 'This widget displays song cover photo on Song View page. The recommended page for this widget is "SES - Advanced Events - Song View Page".',
        'category' => 'Advanced Events - Music Extension',
        'type' => 'widget',
        'name' => 'seseventmusic.song-cover',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'Text',
                    'height',
                    array(
                        'label' => 'Enter the height of cover photo block (in pixels).',
                        'value' => 400,
                    )
                ),
                array(
                    'Text',
                    'mainPhotoHeight',
                    array(
                        'label' => 'Enter the height of Song\'s main photo (in pixels).',
                        'value' => 350,
                    )
                ),
                array(
                    'Text',
                    'mainPhotowidth',
                    array(
                        'label' => 'Enter the width of Song\'s main photo (in pixels).',
                        'value' => 350,
                    )
                ),
                array(
                    'MultiCheckbox',
                    'information',
                    array(
                        'label' => 'Choose from below the details that you want to show in this widget.',
                        'multiOptions' => array(
                            "featured" => "Featured Label",
                            "sponsored" => "Sponsored Label",
                            "hot" => "Hot Label",
                            "postedBy" => "Song Owner\'s Name",
                            "creationDate" => "Released Date",
                            "commentCount" => "Comments Count",
                            "viewCount" => "Views Count",
                            "likeCount" => "Likes Count",
                            "ratingCount" => "Rating Count",
                            "ratingStars" => "Rating Stars",
                            "favouriteCount" => "Favorite Count",
                            "playCount" => "Play Count",
                            "playButton" => "Play Song Button",
                            "editButton" => "Edit Song Button",
                            "deleteButton" => "Delete Song Button",
                            "share" => "Share Button",
                            "report" => "Report Button",
                            "printButton" => "Print Button",
                            "downloadButton" => "Download Button",
                            "addFavouriteButton" => "Add to Favorite Button",
                            'photo' => "Song's Main Photo [Photo will show in the right side above the song cover.]",
                            "category" => "Category / 2nd-level category/ 3rd-level category"
                        ),
                    ),
                ),
            )
        ),
    ),
    array(
        'title' => 'SES - Advanced Events - Music Album Cover',
        'description' => 'This widget displays music album cover photo on Music Album View page. The recommended page for this widget is "SES - Advanced Events - Music Album View Page".',
        'category' => 'Advanced Events - Music Extension',
        'type' => 'widget',
        'name' => 'seseventmusic.album-cover',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'Text',
                    'height',
                    array(
                        'label' => 'Enter the height of cover photo block (in pixels).',
                        'value' => 250,
                    )
                ),
                array(
                    'Text',
                    'mainPhotoHeight',
                    array(
                        'label' => 'Enter the height of Music Album\'s main photo (in pixels).',
                        'value' => 350,
                    )
                ),
                array(
                    'Text',
                    'mainPhotowidth',
                    array(
                        'label' => 'Enter the width of Music Album\'s main photo (in pixels).',
                        'value' => 350,
                    )
                ),
                array(
                    'MultiCheckbox',
                    'information',
                    array(
                        'label' => 'Choose from below the details that you want to show in this widget.',
                        'multiOptions' => array(
                            "featured" => "Featured Label",
                            "sponsored" => "Sponsored Label",
                            "hot" => "Hot Label",
                            "postedBy" => "Music Album Owner's Name",
                            "creationDate" => "Creation Date",
                            "commentCount" => "Comments Count",
                            "viewCount" => "Views Count",
                            "likeCount" => "Likes Count",
                            "ratingCount" => "Rating Count",
                            "ratingStars" => "Rating Stars",
                            "favouriteCount" => "Favorites Count",
                            "songCount" => "Songs Count",
                            "description" => "Description",
                            // "uploadButton" => "Upoload Button",
                            "editButton" => "Edit Music Album Button",
                            "deleteButton" => "Delete Music Album Button",
                            "share" => "Share Button",
                            "report" => "Report Button",
                            //"downloadButton" => "Download Button",
                            "addFavouriteButton" => "Add to Favorite Button",
                            'photo' => "Music Album\'s Main Photo [Photo will show in the right side above the music album cover.]",
                            "category" => "Category / 2nd-level category/ 3rd-level category"
                        ),
                    ),
                ),
            )
        ),
    ),
    array(
        'title' => 'SES - Advanced Events - Tabbed widget for Popular Songs',
        'description' => 'Displays a tabbed widget for popular songs on your website on various popularity criteria. Edit this widget to choose tabs to be shown in this widget.',
        'category' => 'Advanced Events - Music Extension',
        'type' => 'widget',
        'name' => 'seseventmusic.tabbed-widget-songs',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'Text',
                    'height',
                    array(
                        'label' => 'Enter the height of one block (in pixels).',
                        'value' => '200px',
                    )
                ),
                array(
                    'Text',
                    'width',
                    array(
                        'label' => 'Enter the width of one block (in pixels).',
                        'value' => '195px',
                    )
                ),
                array(
                    'Select',
                    'showTabType',
                    array(
                        'label' => 'Choose the design of the tabs.',
                        'multiOptions' => array(
                            '0' => 'Default SE Tabs',
                            '1' => 'Advanced Music Plugin\'s Tabs'
                        ),
                        'value' => 1,
                    )
                ),
                array(
                    'Select',
                    'pagging',
                    array(
                        'label' => 'Do you want the music albums to be auto-loaded when users scroll down the page?',
                        'multiOptions' => array(
                            '1' => 'Yes',
                            '0' => 'No, show \'View More\''
                        ),
                        'value' => 0,
                    )
                ),
                array(
                    'MultiCheckbox',
                    'search_type',
                    array(
                        'label' => "Choose the tabs which you want to be shown in this widget.",
                        'multiOptions' => array(
                            'recently1Created' => 'Recently Created',
                            'recently1Updated' => 'Recently Updated',
                            'most1Viewed' => 'Most Viewed',
                            'most1Liked' => 'Most Liked',
                            'most1Commented' => 'Most Commented',
                            'play1Count' => 'Most Played',
                            'most1Favourite' => 'Most Favorite',
                            'most1Rated' => 'Most Rated',
                            'hot' => 'Hot',
                            'upcoming' => 'Latest',
                            'most1Downloaded' => 'Most Downloaded',
                            'featured' => 'Featured',
                            'sponsored' => 'Sponsored'
                        ),
                    ),
                ),
                array(
                    'Select',
                    'default',
                    array(
                        'label' => "Choose the tab which you want to open by default.",
                        'multiOptions' => array(
                            'recently1Created' => 'Recently Created',
                            'recently1Updated' => 'Recently Updated',
                            'most1Viewed' => 'Most Viewed',
                            'most1Liked' => 'Most Liked',
                            'most1Commented' => 'Most Commented',
                            'play1Count' => 'Most Played',
                            'most1Favourite' => 'Most Favorite',
                            'most1Rated' => 'Most Rated',
                            'hot' => 'Hot',
                            'upcoming' => 'Latest',
                            'most1Downloaded' => 'Most Downloaded',
                            'featured' => 'Featured',
                            'sponsored' => 'Sponsored'
                        ),
                        'value' => 'recently1Updated',
                    )
                ),
                array(
                    'MultiCheckbox',
                    'information',
                    array(
                        'label' => 'Choose from below the details that you want to show in this widget.',
                        'multiOptions' => array(
                            "featured" => "Featured Label",
                            "sponsored" => "Sponsored Label",
                            "hot" => "Hot Label",
                            "likeCount" => "Likes Count",
                            "commentCount" => "Comments Count",
                            "viewCount" => "Views Count",
                            "ratingStars" => "Rating Stars",
                            "playCount" => "Play Count",
                            "postedby" => "Song Owner's Name",
                            "favourite" => "Favorite Icon on Mouse-Over",
                            "share" => "Share Icon on Mouse-Over",
                        ),
                    ),
                ),
                array(
                    'Text',
                    'limit_data',
                    array(
                        'label' => 'count (number of songs to show).',
                        'value' => '12',
                    )
                )
            )
        ),
    ),
    array(
        'title' => 'SES - Advanced Events - Tabbed widget for Popular Music Albums',
        'description' => 'Displays a tabbed widget for popular music albums on your website on various popularity criteria. Edit this widget to choose tabs to be shown in this widget.',
        'category' => 'Advanced Events - Music Extension',
        'type' => 'widget',
        'name' => 'seseventmusic.tabbed-widget',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'Text',
                    'height',
                    array(
                        'label' => 'Enter the height of one block (in pixels).',
                        'value' => '200px',
                    )
                ),
                array(
                    'Text',
                    'width',
                    array(
                        'label' => 'Enter the width of one block (in pixels).',
                        'value' => '195px',
                    )
                ),
                array(
                    'Select',
                    'showTabType',
                    array(
                        'label' => 'Choose the design of the tabs.',
                        'multiOptions' => array(
                            '0' => 'Default SE Tabs',
                            '1' => 'Advanced Music Plugin\'s Tabs'
                        ),
                        'value' => 1,
                    )
                ),
                array(
                    'Select',
                    'pagging',
                    array(
                        'label' => 'Do you want the music albums to be auto-loaded when users scroll down the page?',
                        'multiOptions' => array(
                            '1' => 'Yes',
                            '0' => 'No, show \'View More\''
                        ),
                        'value' => 0,
                    )
                ),
                array(
                    'MultiCheckbox',
                    'search_type',
                    array(
                        'label' => "Choose the tabs which you want to be shown in this widget.",
                        'multiOptions' => array(
                            'recently1Created' => 'Recently Created',
                            'recently1Updated' => 'Recently Updated',
                            'most1Viewed' => 'Most Viewed',
                            'most1Liked' => 'Most Liked',
                            'most1Commented' => 'Most Commented',
                            'song1Count' => 'Maximum Songs',
                            'most1Favourite' => 'Most Favorite',
                            'most1Rated' => 'Most Rated',
                            'hot' => 'Hot',
                            'upcoming' => 'Latest',
                            'featured' => 'Featured',
                            'sponsored' => 'Sponsored'
                        ),
                    )
                ),
                array(
                    'Select',
                    'default',
                    array(
                        'label' => "Choose the tab which you want to open by default.",
                        'multiOptions' => array(
                            'recently1Created' => 'Recently Created',
                            'recently1Updated' => 'Recently Updated',
                            'most1Viewed' => 'Most Viewed',
                            'most1Liked' => 'Most Liked',
                            'most1Commented' => 'Most Commented',
                            'song1Count' => 'Maximum Songs',
                            'most1Favourite' => 'Most Favorite',
                            'most1Rated' => 'Most Rated',
                            'hot' => 'Hot',
                            'upcoming' => 'Latest',
                            'featured' => 'Featured',
                            'sponsored' => 'Sponsored'
                        ),
                        'value' => 'recently1Updated',
                    )
                ),
                array(
                    'MultiCheckbox',
                    'information',
                    array(
                        'label' => 'Choose from below the details that you want to show in this widget.',
                        'multiOptions' => array(
                            "featured" => "Featured Label",
                            "sponsored" => "Sponsored Label",
                            "hot" => "Hot Label",
                            "likeCount" => "Likes Count",
                            "commentCount" => "Comments Count",
                            "viewCount" => "Views Count",
                            "songCount" => "Songs Count",
                            "ratingStars" => "Rating Stars",
                            "title" => "Music Album Title",
                            "postedby" => "Music Album Owner's Name",
                            "favourite" => "Favorite Icon on Mouse-Over",
                            "share" => "Share Icon on Mouse-Over",
                        ),
                    ),
                ),
                array(
                    'Text',
                    'limit_data',
                    array(
                        'label' => 'count (number of music albums to show).',
                        'value' => '12',
                    )
                ),
            )
        ),
    ),
    array(
        'title' => 'SES - Advanced Events - Music Home No Music Albums Message',
        'description' => 'Displays a message when there is no Music Album on your website. The recommended page for this widget is "SES - Advanced Events - Music Album Home Page".',
        'category' => 'Advanced Events - Music Extension',
        'type' => 'widget',
        'name' => 'seseventmusic.music-home-error',
    ),
    array(
        'title' => 'SES - Advanced Events - Advanced Music Player',
        'description' => 'Displays the music player in footer of your website. This widget should be placed in the Footer of your website only.',
        'category' => 'Advanced Events - Music Extension',
        'type' => 'widget',
        'name' => 'seseventmusic.player',
    ),
    array(
        'title' => 'SES - Advanced Events - Breadcrumb for Music Album / Song / View Page',
        'description' => 'Displays breadcrumb for Album / Song . This widget should be placed on the SES - Advanced Events - View page of the selected content type.',
        'category' => 'Advanced Events - Music Extension',
        'autoEdit' => true,
        'type' => 'widget',
        'name' => 'seseventmusic.breadcrumb',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'viewPageType',
                    array(
                        'label' => "Choose content type.",
                        'multiOptions' => array(
                            'album' => 'Music Album',
                            'song' => 'Song',
                        ),
                        'value' => 'album',
                    ),
                ),
            )
        ),
    ),
    array(
        'title' => 'SES - Advanced Events - Quick AJAX based Search',
        'description' => 'Displays a quick search box to enable users to quickly search Music Albums, Songs of their choice.',
        'category' => 'Advanced Events - Music Extension',
        'autoEdit' => true,
        'type' => 'widget',
        'name' => 'seseventmusic.search',
    ),
    array(
        'title' => 'SES - Advanced Events - Alphabetic Filtering of Music Albums / Songs',
        'description' => "This widget displays all the alphabets for alphabetic filtering of music albums / songs which will enable users to filter content on the basis of selected alphabet.",
        'category' => 'Advanced Events - Music Extension',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'seseventmusic.album-songs-alphabet',
        'defaultParams' => array(
            'title' => "",
        ),
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'contentType',
                    array(
                        'label' => "Choose content type.",
                        'multiOptions' => array(
                            'albums' => 'Music Albums',
                            'songs' => 'Songs',
                        ),
                        'value' => 'albums',
                    )
                ),
            )
        ),
    ),
    array(
        'title' => 'SES - Advanced Events - Album / Song of the Day',
        'description' => 'This widget displays music album / song / of the day as choosen by you from the Edit setting of this widget.',
        'category' => 'Advanced Events - Music Extension',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'seseventmusic.album-song-day-of-the',
        'adminForm' => 'Seseventmusic_Form_Admin_Settings_AlbumSongDayOfThe',
        'defaultParams' => array(
            'title' => 'Album of the Day',
        ),
    ),
    array(
        'title' => 'SES - Advanced Events - Featured, Sponsored and Hot Music Albums / Songs Carousel',
        'description' => "Disaplys Featured, Sponsored or Hot Carousel of songs / music albums.",
        'category' => 'Advanced Events - Music Extension',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'seseventmusic.featured-sponsored-hot-carousel',
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'contentType',
                    array(
                        'label' => "Which content do you want to show on this widget?",
                        'multiOptions' => array(
                            'albums' => 'Music Albums',
                            'songs' => 'Songs',
                        ),
                        'value' => 'albums',
                    )
                ),
                array(
                    'Select',
                    'popularity',
                    array(
                        'label' => 'Popularity Criteria',
                        'multiOptions' => array(
                            'view_count' => 'Most Viewed',
                            'like_count' => 'Most Liked',
                            'comment_count' => 'Most Commented',
                            'favourite_count' => 'Most Favorite',
                            'creation_date' => 'Most Recent',
                            'rating' => 'Most Rated',
                            'modified_date' => 'Recently Updated',
                            'song_count' => "Maximum Songs",
                        ),
                        'value' => 'creation_date',
                    )
                ),
                array(
                    'Select',
                    'displayContentType',
                    array(
                        'label' => "Display Content",
                        'multiOptions' => array(
                            'featured' => 'Only Featured',
                            'sponsored' => 'Only Sponsored',
                            'hot' => 'Only Hot',
                            'upcoming' => 'Only Latest',
                            'feaspo' => 'Both Featured and Sponsored',
                            'hotlat' => 'Both Hot and Latest',
                        ),
                        'value' => 'featured',
                    ),
                ),
                array(
                    'MultiCheckbox',
                    'information',
                    array(
                        'label' => 'Choose the options that you want to be displayed in this widget.',
                        'multiOptions' => array(
                            "featured" => "Featured Label",
                            "sponsored" => "Sponsored Label",
                            "hot" => "Hot Label",
                            "likeCount" => "Likes Count",
                            "commentCount" => "Comments Count",
                            "viewCount" => "Views Count",
                            "songsCount" => "Songs Count",
                            "ratingCount" => "Rating Stars",
                            "downloadCount" => "Downloaded Count [Only For Songs]",
                            "playCount" => "Plays Count [Only For Songs]",
                            "title" => "Music Album / Song Title",
                            "postedby" => "Music Albums / Song Owner's Name",
                            "share" => "Share Icon on Mouse-Over",
                            "favourite" => "Favorite Icon on Mouse-Over",
                        )
                    ),
                ),
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
                    'Text',
                    'height',
                    array(
                        'label' => 'Enter the height of one block [in pixels].',
                        'value' => 200,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    ),
                ),
                array(
                    'Text',
                    'width',
                    array(
                        'label' => 'Enter the width of one block [in pixels].',
                        'value' => 200,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    ),
                ),
                $limit,
            )
        ),
    ),
    array(
        'title' => 'SES - Advanced Events - Liked Music Album / Song by Members',
        'description' => 'Displays a list of members (you can choose to show all members or friend of member viewing the content) who liked the content on which the widget is placed. The recommended page for this widget is "SES - Advanced Events - Music Album View Page".',
        'category' => 'Advanced Events - Music Extension',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'seseventmusic.albums-songs-like',
        'defaultParams' => array(
            'title' => '',
        ),
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'contentType',
                    array(
                        'label' => "Choose the content type of the associated view page on which this widget is placed.",
                        'multiOptions' => array(
                            'albums' => 'Music Albums',
                            'songs' => 'Songs',
                        ),
                        'value' => 'albums',
                    )
                ),
                array(
                    'Select',
                    'showUsers',
                    array(
                        'label' => "Who all members do you want to show in this widget?",
                        'multiOptions' => array(
                            'all' => 'All Members',
                            'friends' => 'Friends of the member viewing the content.',
                        ),
                        'value' => 'all',
                    )
                ),
                array(
                    'Select',
                    'showViewType',
                    array(
                        'label' => 'Choose the View Type.',
                        'multiOptions' => array(
                            '1' => 'List View [member\'s photo with names will show]',
                            '0' => 'Grid View [only member\'s photo will show]'
                        ),
                        'value' => 1,
                    )
                ),
                array(
                    'Text',
                    'itemCount',
                    array(
                        'label' => 'Count (number of members to show)',
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
        'title' => 'SES - Advanced Events - You May Also Like Music Albums',
        'description' => 'This widget display those music albums which the viewer may also Like.',
        'category' => 'Advanced Events - Music Extension',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'seseventmusic.you-may-also-like-album-songs',
        'defaultParams' => array(
            'title' => '',
        ),
        'adminForm' => array(
            'elements' => array(
                $show_photo,
                array(
                    'MultiCheckbox',
                    'information',
                    array(
                        'label' => 'Choose the options that you want to be displayed in the List and Grid View.',
                        'multiOptions' => array(
                            "featured" => "Featured Label",
                            "sponsored" => "Sponsored Label",
                            "hot" => "Hot Label",
                            "likeCount" => "Likes Count",
                            "commentCount" => "Comments Count",
                            "viewCount" => "Views Count",
                            "ratingCount" => "Rating Stars",
                            "songCount" => "Songs Count",
                            "title" => "Music Album Title",
                            "postedby" => "Music Album Owner’s Name"
                        )
                    ),
                ),
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
                $height,
                $width,
                array(
                    'Text',
                    'itemCount',
                    array(
                        'label' => 'Count (number of content to show)',
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
        'title' => 'SES - Advanced Events - You May Also Like Songs',
        'description' => 'This widget display those songs which the viewer may also Like.',
        'category' => 'Advanced Events - Music Extension',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'seseventmusic.you-may-also-like-songs',
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
                    'MultiCheckbox',
                    'information',
                    array(
                        'label' => 'Choose the options that you want to be displayed in this widget.',
                        'multiOptions' => array(
                            "featured" => "Featured Label",
                            "sponsored" => "Sponsored Label",
                            "hot" => "Hot Label",
                            "likeCount" => "Likes Count",
                            "commentCount" => "Comments Count",
                            "viewCount" => "Views Count",
                            "ratingCount" => "Rating Stars",
                            "downloadCount" => "Downloaded Count",
                            "playCount" => "Plays Count",
                            "title" => "Song Title",
                            "postedby" => "Song Owner's Name",
                            "share" => "Share Icon on Mouse-Over",
                            "favourite" => "Favorite Icon on Mouse-Over",
                        )
                    ),
                ),
                $height,
                $width,
                array(
                    'Text',
                    'itemCount',
                    array(
                        'label' => 'Count (number of content to show)',
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
        'title' => "SES - Advanced Events - Owner's Photo",
        'description' => 'This widget display on "SES - Advanced Events - Music Album View Page", "SES - Advanced Events - Song View Page".',
        'category' => 'Advanced Events - Music Extension',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'seseventmusic.owner-photo',
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
);
?>