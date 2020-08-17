<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmusicapp
 * @package    Sesmusicapp
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: content.php  2018-12-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

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
$chooseAlbumOrSong = array('Select', 'contentType', array(
        'label' => 'Choose the content type belonging to which categories will be shown in this.',
        'multiOptions' => array(
            'album' => 'Music Album',
            'song' => 'Song',
        ),
        'value' => 'album',
    ));

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
						"favouriteCount" => "Favorite Count",
            "songsCount" => "Songs Count",
            "ratingCount" => "Rating Stars",
            "title" => "Music Album Title [For Grid View Only]",
            "postedby" => "Music Albums Owner's Name",
            'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
            "addLikeButton" => "Like Icon on Mouse Over",
            "favourite" => "Add to Favorite Icon on Mouse Over",
        ),
        'escape' => false,
    ),
);


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
            "favouriteCount" => "Favorited Count",
            "downloadCount" => "Downloaded Count",
            "playCount" => "Plays Count",
            "ratingCount" => "Rating Stars",
            "title" => "Album Title",
            "postedby" => "Song Owner's Name",
            'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
            "addLikeButton" => "Like Icon on Mouse Over",
            "favourite" => "Add to Favorite Icon on Mouse Over",
        ), 
        'escape' => false,
    ),
);
//artist information show
$artistStats = array(
    'MultiCheckbox',
    'information',
    array(
        'label' => 'Choose the options that you want to be displayed in this widget.',
        'multiOptions' => array(
            "rating" => "Show Rating",
            "favouritecount" => "Show Favourite Counts",
        ), 
        'escape' => false,
    ),
);
$artistsPopularityParameters = array(
    'Select',
    'popularity',
    array(
        'label' => 'Popularity Criteria',
        'multiOptions' => array(
            'favourite_count' => 'Most Favorite',
            'rating' => 'Most Rated',
        //'song_count' => "Top Songs (Means here accociate with songs)",
        ),
        'value' => 'favourite_count',
    )
);
return array(
   array(
    'title' => 'SES - Custom Music for Mobile Apps Ext - Music Albums / Songs Categories',
    'description' => 'Displays all categories of music albums / songs in category level hierarchy view or cloud view as chosen by you. Edit this widget to choose the view type and various other settings.',
    'category' => 'SES - Custom Music for Mobile Apps Extension',
    'type' => 'widget',
    'name' => 'sesmusicapp.category',
    'autoEdit' => true,
    'adminForm' => 'Sesmusicapp_Form_Admin_Tagcloudcategory',
   ),
   array(
        'title' => 'SES - Custom Music for Mobile Apps Ext - Featured, Sponsored and Hot Music Albums / Songs Carousel',
        'description' => "Disaplys Featured, Sponsored or Hot Carousel of songs / music albums.",
        'category' => 'SES - Custom Music for Mobile Apps Extension',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesmusicapp.featured-sponsored-hot-carousel',
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
														"favouriteCount" => "Favorited Count",
                            "songsCount" => "Songs Count",
                            "ratingCount" => "Rating Stars",
                            "downloadCount" => "Downloaded Count [Only For Songs]",
                            "playCount" => "Plays Count [Only For Songs]",
                            "title" => "Music Album / Song Title",
                            "postedby" => "Music Albums / Song Owner's Name",
                            "share" => "Share Icon on Mouse-Over",
                            "favourite" => "Favorite Icon on Mouse-Over",
                            "addplaylist" => "Add to Playlist Icon on Mouse-Over",
                            'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                            "addLikeButton" => "Like Icon on Mouse-Over",
                        ),
                        'escape' => false,
                    ),
                ),
                $socialshare_enable_plusicon,
                $socialshare_icon_limit,
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
        'title' => 'SES - Custom Music for Mobile Apps Extension - Album / Song / Artist of the Day',
        'description' => 'This widget displays music album / song / artist of the day as choosen by you from the Edit setting of this widget.',
        'category' => 'SES - Custom Music for Mobile Apps Extension',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesmusicapp.album-song-playlist-artist-day-of-the',
        'adminForm' => 'Sesmusicapp_Form_Admin_AlbumSongPlaylistArtistDayOfThe',
        'defaultParams' => array(
            'title' => 'Album of the Day',
        ),
    ),
    array(
        'title' => 'SES - Custom Music for Mobile Apps Ext - Recently Viewed Music Albums / Songs',
        'description' => 'This widget displays the recently viewed music albums or songs by the user who is currently viewing your website or by the logged in members friend. Edit this widget to choose whose recently viewed content will show in this widget.',
        'category' => 'SES - Custom Music for Mobile Apps Extension',
        'type' => 'widget',
        'name' => 'sesmusicapp.recently-viewed-item',
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
                            'sesmusic_album' => 'Music Albums',
                            'sesmusic_albumsong' => 'Songs',
                        // 'sesmusic_artist' => 'Artists',
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
                        //  'on_site' => 'Content View On site'
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
                            "addplaylist" => "Add to Playlist Icon on Mouse-Over",
                            'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                            "addLikeButton" => "Like Button",
                        ),
                        'escape' => false,
                    )
                ),
                $socialshare_enable_plusicon,
                $socialshare_icon_limit,
                array(
                    'Text',
                    'height',
                    array(
                        'label' => 'Enter the height of one block [for Grid View (in pixels)].',
                        'value' => '180',
                    )
                ),
                array(
                    'Text',
                    'width',
                    array(
                        'label' => 'Enter the width of one block [for Grid View (in pixels)].',
                        'value' => '180',
                    )
                ),
                array(
                    'Text',
                    'limit',
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
        'title' => 'SES - Custom Music for Mobile Apps Ext - Popular / Recommended / Related / Owner\'s Other Songs',
        'description' => 'Displays songs based on chosen criteria for this widget. The placement of this widget depends on the criteria chosen for this widget.',
        'category' => 'SES - Custom Music for Mobile Apps Extension',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesmusicapp.popular-recommanded-other-related-songs',
        'adminForm' => array(
            'elements' => array(
                array(
                    'Radio',
                    'showType',
                    array(
                        'label' => "Show",
                        'multiOptions' => array(
                            'all' => 'Popular Songs [With this option, place this widget anywhere on your website. Choose criteria from "Popularity Criteria" setting below.]',
                        ),
                        'value' => 'all',
                    ),
                ),
                $view_type,
                $songPopularityParameters,
                $songStats,
                $socialshare_enable_plusicon,
                $socialshare_icon_limit,
                $height,
                $width,
                $limit,
            )
        ),
    ),
    /*array(
        'title' => 'SES - Custom Music for Mobile Apps Ext - You May Also Like Music Albums',
        'decription' => 'This widget display those music albums which the viewer may also Like.',
        'category' => 'SES - Custom Music for Mobile Apps Extension',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesmusicapp.you-may-also-like-album-songs',
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
    ),*/
    array(
        'title' => 'SES - Custom Music for Mobile Apps Ext - Popular Artists',
        'description' => 'Displays artists based on chosen criteria for this widget. Edit this widget to choose various settings.',
        'category' => 'SES - Custom Music for Mobile Apps Extension',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesmusicapp.popular-artists',
        'adminForm' => array(
            'elements' => array(
                $artistsPopularityParameters,
                $view_type,
								$artistStats,
                $height,
                $width,
                $limit,
            )
        ),
    ),
  array(
    'title' => 'SES - Custom Music for Mobile Apps Ext - Popular / Recommended Songs',
    'description' => 'Displays songs based on chosen criteria for this widget. The placement of this widget depends on the criteria chosen for this widget.',
    'category' => 'SES - Custom Music for Mobile Apps Extension',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesmusicapp.popular-recommanded-songs',
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
                    ),
                    'value' => 'all',
                ),
            ),
            $view_type,
            $songPopularityParameters,
            $songStats,
            $socialshare_enable_plusicon,
            $socialshare_icon_limit,
            $height,
            $width,
            $limit,
        )
    ),
  ),
  array(
    'title' => 'SES - Custom Music for Mobile Apps Ext - Popular Music Albums',
    'description' => 'Displays music albums based on chosen criteria for this widget. The placement of this widget depends on the criteria chosen for this widget.',
    'category' => 'SES - Custom Music for Mobile Apps Extension',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesmusicapp.popular-albums',
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
              ),
              'value' => 'all',
          ),
        ),
        $albumPopularityParameters,
        $view_type,
        $show_photo,
        $AlbumStats,
        $socialshare_enable_plusicon,
        $socialshare_icon_limit,
        $height,
        $width,
        $limit,
      )
    ),
  ),
  array(
    'title' => 'SES - Custom Music for Mobile Apps Ext - Popular Music Playlist',
    'description' => 'Displays music Playlist based on chosen criteria for this widget. The placement of this widget depends on the criteria chosen for this widget.',
    'category' => 'SES - Custom Music for Mobile Apps Extension',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesmusicapp.popular-playlist',
    'adminForm' => array(
      
            'elements' => array(
                array(
                    'Radio',
                    'showOptionsType',
                    array(
                        'label' => "Show",
                        'multiOptions' => array(
                            'all' => 'Popular Playlist [With this option, place this widget anywhere on your website. Choose criteria from "Popularity Criteria" setting below.]',
                            'recommanded' => 'Recommended Playlist [With this option, place this widget anywhere on your website.]',
                            'other' => 'Member’s Other Playlists [With this option, place this widget on SES - Advanced Music - Playlist View Page.]',
                        ),
                        'value' => 'all',
                    ),
                ),
                array(
                    'Select',
                    'showType',
                    array(
                        'label' => "Do you want to show carousel?",
                        'multiOptions' => array(
                            'carouselview' => 'Yes',
                            'gridview' => 'No',
                        ),
                        'value' => 'carouselview',
                    ),
                ),
                array(
                    'Select',
                    'popularity',
                    array(
                        'label' => 'Popularity Criteria',
                        'multiOptions' => array(
                            'featured' => 'Only Featured',
                            'view_count' => 'Most Viewed',
                            'creation_date' => 'Most Recent',
                            'modified_date' => 'Recently Updated',
                            'favourite_count' => "Most Favorite",
                            'song_count' => "Maximum Songs",
                        ),
                        'value' => 'creation_date',
                    )
                ),
                array(
                    'MultiCheckbox',
                    'information',
                    array(
                        'label' => "Choose the options that you want to be displayed in this widget.",
                        'multiOptions' => array(
                            "postedby" => "Playlist Owner's Name",
                            "viewCount" => "Views Count",
                            "title" => "Title",
                            "favouriteCount" => "Favorite Count",
                            "songCount" => "Songs Count",
                            "songsListShow" => "Songs of each Playlist"
                        ),
                    )
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
                        'label' => 'Enter the height of one block.',
                        'value' => 200,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    ),
                ),
                $width,
                $limit,
            )
    ),
  ),
	/*array(
		'title' => 'SES - Custom Music for Mobile Apps Ext - Category based Songs/Albums',
		'description' => 'Display Albums or Songs based on category , Subcategory and Subsubcategory',
		'category' => 'SES - Custom Music for Mobile Apps Extension',
		'type' => 'widget',
		'autoEdit' => true,
		'name' => 'sesmusicapp.category-based-music',
		'adminForm' => 'Sesmusicapp_Form_Admin_CategoryBasedMusic',
	),*/
);