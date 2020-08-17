<?php
return array(
    array(
        'title' => 'SES - Group Albums Extension - Album View Page Options',
        'description' => "Album View Page",
        'category' => 'SES - Group Albums Extension',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesgroupalbum.album-view-page',
        'adminForm' => 'Sesgroupalbum_Form_Admin_Albumviewpage',
    ),
    array(
        'title' => 'SES - Group Albums Extension - Browse Albums',
        'description' => 'Display all albums on your website. The recommended page for this widget is "SES - Advanced Photos - Browse Albums Page".',
        'category' => 'SES - Group Albums Extension',
        'type' => 'widget',
        'name' => 'sesgroupalbum.browse-albums',
        'autoEdit' => true,
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
                            "mostSPated" => "Most Rated",
                            "mostSPcommented" => "Most Commented",
                            "mostSPfavourite" => "Most Favourite",
                            'featured' => 'Only Featured',
                            'sponsored' => 'Only Sponsored',
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
                            'like' => 'Likes Count',
                            'comment' => 'Comments Count',
                            'rating' => 'Rating Stars',
                            'view' => 'Views Count',
                            'title' => 'Album Title',
                            'by' => 'Owner\'s Name',
                            'socialSharing' => 'Social Sharing Buttons',
                            'favouriteCount' => 'Favourites Count',
                            'downloadCount' => 'Downloads Count',
                            'photoCount' => 'Photos Count',
                            'featured' => 'Featured Label',
                            'sponsored' => 'Sponsored Label',
                            'likeButton' => 'Like Button',
                            'favouriteButton' => 'Favourite Button',
                        ),
                    //'value' => array('like','comment','view','rating','title','by','socialSharing'),
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
        'title' => 'SES - Group Albums Extension - Album/Photo Browse Search',
        'description' => 'Displays a search form in the album / photo browse page as placed by you. Edit this widget to choose the search option to be shown in the search form.',
        'category' => 'SES - Group Albums Extension',
        'type' => 'widget',
        'name' => 'sesgroupalbum.browse-search',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'Radio',
                    'search_for',
                    array(
                        'label' => "Choose the content for which results will be shown.",
                        'multiOptions' => array(
                            'album' => 'Albums',
                            'photo' => 'Photos'
                        ),
                        'value' => 'album',
                    )
                ),
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
                            'mostSPrated' => 'Most Rated',
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
                            'mostSPrated' => 'Most Rated',
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
                array(
                    'Radio',
                    'categories',
                    array(
                        'label' => "Show \'Categories\' search field?",
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
        'title' => 'SES - Group Albums Extension - Recently Viewed Photos / Albums',
        'description' => 'This widget displays the recently viewed albums or photos by the user who is currently viewing your website or by the logged in members friend or by all the members of your website. Edit this widget to choose whose recently viewed content will show in this widget.',
        'category' => 'SES - Group Albums Extension',
        'type' => 'widget',
        'name' => 'sesgroupalbum.recently-viewed-item',
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
                            'album' => 'Albums',
                            'photo' => 'Photos',
                        ),
                    ),
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
                    'Select',
                    'insideOutside',
                    array(
                        'label' => "Choose where do you want to show the statistics of photos / albums.",
                        'multiOptions' => array(
                            'inside' => 'Inside the Photo / Album Block',
                            'outside' => 'Outside the Photo / Album Block',
                        ),
                        'value' => 'inside',
                    )
                ),
                array(
                    'Select',
                    'fixHover',
                    array(
                        'label' => "Show photo / album statistics Always or when users Mouse-over on photo / album blocks (this setting will work only if you choose to show information inside the Photo / Album block.)",
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
                            'like' => 'Likes Count',
                            'comment' => 'Comments Count',
                            'rating' => 'Rating Stars',
                            'view' => 'Views Count',
                            'title' => 'Photo / Album Title',
                            'by' => 'Owner\'s Name',
                            'socialSharing' => 'Social Sharing Buttons',
                            'favouriteCount' => 'Favourites Count',
                            'downloadCount' => 'Downloads Count',
                            'photoCount' => 'Photos Count',
                            'featured' => 'Featured Label',
                            'sponsored' => 'Sponsored Label',
                            'likeButton' => 'Like Button',
                            'favouriteButton' => 'Favourite Button',
                        ),
                    )
                ),
                array(
                    'Text',
                    'title_truncation',
                    array(
                        'label' => 'Photo / Album title truncation limit.',
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
                        'label' => 'Enter the height of one photo / album block (in pixels).',
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
                        'label' => 'Enter the width of one photo / album block (in pixels).',
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
                        'label' => 'Count (number of photo / album to show.)',
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
        'title' => 'SES - Group Albums Extension - Album Tags Cloud',
        'description' => 'Displays all tags of albums in cloud view. Edit this widget to choose various other settings.',
        'category' => 'SES - Group Albums Extension',
        'type' => 'widget',
        'name' => 'sesgroupalbum.tag-cloud-albums',
        'autoEdit' => true,
        'adminForm' => 'Sesgroupalbum_Form_Admin_Tagcloudalbum',
    ),
    array(
        'title' => 'SES - Group Albums Extension - Album / Photo Home No Album Message',
        'description' => 'Displays a message when there is no Album or Photo on your website. Edit this widget to choose for which content you want to place this widget.',
        'category' => 'SES - Group Albums Extension',
        'type' => 'widget',
        'name' => 'sesgroupalbum.album-home-error',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'itemType',
                    array(
                        'label' => 'Choose the content type.',
                        'multiOptions' =>
                        array(
                            'album' => 'Albums',
                            'photo' => 'Photos',
                        ),
                    ),
                ),
            ),
        ),
    ),
    array(
        'title' => 'SES - Group Albums Extension - Tabbed widget for Popular Photos / Albums',
        'description' => 'Displays a tabbed widget for popular photos / albums on your website on various popularity criteria. Edit this widget to choose tabs to be shown in this widget.',
        'category' => 'SES - Group Albums Extension',
        'type' => 'widget',
        'name' => 'sesgroupalbum.tabbed-widget',
        'autoEdit' => true,
        'adminForm' => 'Sesgroupalbum_Form_Admin_Tabbed',
    ),
    array(
        'title' => 'SES - Group Albums Extension - Popular / Featured / Sponsored Photos or Albums',
        'description' => "Displays photos or albums as chosen by you based on chosen criteria for this widget. The placement of this widget depends on the criteria chosen for this widget.",
        'category' => 'SES - Group Albums Extension',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesgroupalbum.featured-sponsored',
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'tableName',
                    array(
                        'label' => 'Choose the content type.',
                        'multiOptions' => array(
                            "album" => "Album",
                            "photo" => "Photo"
                        )
                    ),
                    'value' => 'photo'
                ),
                array(
                    'Select',
                    'criteria',
                    array(
                        'label' => "Display Content",
                        'multiOptions' => array(
                            '5' => 'All including Featured and Sponsored',
                            '1' => 'Only Featured',
                            '2' => 'Only Sponsored',
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
                            "most_download" => "Most Downloaded",
                        )
                    ),
                    'value' => 'recently_updated',
                ),
                array(
                    'Select',
                    'insideOutside',
                    array(
                        'label' => "Choose where do you want to show the statistics of photos or albums.",
                        'multiOptions' => array(
                            'inside' => 'Inside the Photo / Album Block',
                            'outside' => 'Outside the Photo / Album Block',
                        ),
                        'value' => 'inside',
                    )
                ),
                array(
                    'Select',
                    'fixHover',
                    array(
                        'label' => "Show photo / album statistics Always or when users Mouse-over on photos / albums (this setting will work only if you choose to show information inside the Photo / Album block.)",
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
                        'label' => "Choose from below the details that you want to show for Photos / Albums in this widget.",
                        'multiOptions' => array(
                            'like' => 'Likes Count',
                            'comment' => 'Comments Count',
                            'rating' => 'Rating Stars',
                            'view' => 'Views Count',
                            'title' => 'Photo / Album Title',
                            'by' => 'Owner\'s Name',
                            'socialSharing' => 'Social Sharing Buttons',
                            'favouriteCount' => 'Favourites Count',
                            'downloadCount' => 'Downloads Count',
                            'photoCount' => 'Photos Count',
                            'featured' => 'Featured Label',
                            'sponsored' => 'Sponsored Label',
                            'likeButton' => 'Like Button',
                            'favouriteButton' => 'Favourite Button',
                        ),
                    )
                ),
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
                        'label' => 'Photo / Album title truncation limit.',
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
                        'label' => 'Enter the height of one photo / album block (in pixels).',
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
                        'label' => 'Enter the width of one photo / album block (in pixels).',
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
                        'label' => 'Count (number of photos / albums to show).',
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
        'title' => 'SES - Group Albums Extension - Photos / Albums of the Day',
        'description' => "This widget displays photos / albums of the day as chosen by you from the Edit Settings of this widget.",
        'category' => 'SES - Group Albums Extension',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesgroupalbum.of-the-day',
        'adminForm' => array(
            'elements' => array(
                array(
                    'Radio',
                    'ofTheDayType',
                    array(
                        'label' => 'Choose content type to be shown in this widget.',
                        'multiOptions' => array(
                            'albums' => 'Album',
                            'photos' => 'Photo',
                        ),
                        'value' => 'albums',
                    )
                ),
                array(
                    'Select',
                    'insideOutside',
                    array(
                        'label' => "Choose where do you want to show the statistics of photos / albums.",
                        'multiOptions' => array(
                            'inside' => 'Inside the Photo / Album Block',
                            'outside' => 'Outside the Photo / Album Block',
                        ),
                        'value' => 'inside',
                    )
                ),
                array(
                    'Select',
                    'fixHover',
                    array(
                        'label' => "Show photo / album statistics Always or when users Mouse-over on photo / album blocks (this setting will work only if you choose to show information inside the Photo / Album block.)",
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
                        'label' => "Choose from below the details that you want to show for photos / albums in this widget.",
                        'multiOptions' => array(
                            'like' => 'Likes Count',
                            'comment' => 'Comments Count',
                            'rating' => 'Rating Stars',
                            'view' => 'Views Count',
                            'title' => 'Photo / Album Title',
                            'by' => 'Owner\'s Name',
                            'socialSharing' => 'Social Sharing Buttons',
                            'favouriteCount' => 'Favourites Count',
                            'downloadCount' => 'Downloads Count',
                            'photoCount' => 'Photos Count',
                            'featured' => 'Featured Label',
                            'sponsored' => 'Sponsored Label',
                            'likeButton' => 'Like Button',
                            'favouriteButton' => 'Favourite Button',
                        ),
                    )
                ),
                array(
                    'Text',
                    'title_truncation',
                    array(
                        'label' => 'Photo / Album title truncation limit.',
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
                        'label' => 'Enter the height of one photo / album block (in pixels).',
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
                        'label' => 'Enter the width of one photo / album block (in pixels).',
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
        'title' => 'SES - Group Albums Extension - Featured / Sponsored Photos or Albums Carousel',
        'description' => "Disaplys Featured or Sponsored Carousel of photos / albums.",
        'category' => 'SES - Group Albums Extension - ',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesgroupalbum.featured-sponsored-carosel',
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'featured_sponsored_carosel',
                    array(
                        'label' => "Choose the content you want to show in this widget.",
                        'multiOptions' => array(
                            '1' => 'Featured Photos',
                            '2' => 'Featured Albums',
                            '3' => 'Sponsored Photos',
                            '4' => 'Sponsored Albums'
                        ),
                        'value' => 1,
                    )
                ),
                array(
                    'Select',
                    'mouseover',
                    array(
                        'label' => "Show nav buttons on mouseover?",
                        'multiOptions' => array(
                            '1' => 'Yes',
                            '0' => 'No',
                        ),
                        'value' => '1',
                    )
                ),
                array(
                    'Select',
                    'insideOutside',
                    array(
                        'label' => "Choose where do you want to show the statistics of photos / albums.",
                        'multiOptions' => array(
                            'inside' => 'Inside the Photo / Album Block',
                            'outside' => 'Outside the Photo / Album Block',
                        ),
                        'value' => 'inside',
                    )
                ),
                array(
                    'Select',
                    'fixHover',
                    array(
                        'label' => "Show photo / album statistics Always or when users Mouse-over on photo / album blocks (this setting will work only if you choose to show information inside the Photo / Album block.)",
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
                        'label' => "Choose from below the details that you want to show for photos / albums in this widget.",
                        'multiOptions' => array(
                            'like' => 'Likes Count',
                            'comment' => 'Comments Count',
                            'rating' => 'Rating Stars',
                            'view' => 'Views Count',
                            'title' => 'Photo / Album Title',
                            'by' => 'Owner\'s Name',
                            'socialSharing' => 'Social Sharing Buttons',
                            'favouriteCount' => 'Favourites Count',
                            'downloadCount' => 'Downloads Count',
                            'photoCount' => 'Photos Count',
                            'featured' => 'Featured Label',
                            'sponsored' => 'Sponsored Label',
                            'likeButton' => 'Like Button',
                            'favouriteButton' => 'Favourite Button',
                        ),
                    )
                ),
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
                    'height',
                    array(
                        'label' => 'Enter the height of one photo / album block (in pixels).',
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
                        'label' => 'Enter the width of one photo / album block (in pixels).',
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
                            "most_download" => "Most Downloaded",
                        )
                    ),
                    'value' => 'recently_updated',
                ),
                array(
                    'Text',
                    'title_truncation',
                    array(
                        'label' => 'Photo / Album Title truncation limit.',
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
                        'label' => 'Count (number of photos / albums to show.)',
                        'value' => 5,
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
    'title' => 'SES - Group Albums Extension - Photo View Page Options',
      'description' => 'This widget enables you to choose various options to be shown on photo view page like Slideshow of other photos associated with same album as the current photo, etc.',
      'category' => 'SES - Group Albums Extension',
      'type' => 'widget',
      'name' => 'sesgroupalbum.photo-view-page',
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
                          'like' => 'People who Liked the current photo',
                          'favourite' => 'People who added current photo as Favourite',
                          'tagged' => 'People who are Tagged in current photo',
                          'slideshowPhoto' => 'Slideshow of other photos associated with same album',
                      ),
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
              array(
                  'Text',
                  'view_more_like',
                  array(
                      'label' => 'Enter the number of photos to be shown in "People Who Liked This Photo" block. After the number of photos entered below, option to view more photos in popup will be shown.',
                      'value' => 10,
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
                      'label' => 'Enter the number of photos to be shown in "People Who Favourite This Photo" block. After the number of photos entered below, option to view more photos in popup will be shown.',
                      'value' => 10,
                      'validators' => array(
                          array('Int', true),
                          array('GreaterThan', true, array(0)),
                      )
                  )
              ),
              array(
                  'Text',
                  'view_more_tagged',
                  array(
                      'label' => 'Enter the number of photos to be shown in "People Who are Tagged in This Photo" block. After the number of photos entered below, option to view more photos in popup will be shown. ',
                      'value' => 10,
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
      'title' => 'SES - Group Albums Extension - Breadcrumb for Photo View Page',
      'description' => 'Displays breadcrumb for photos. This widget should be placed on the \'SES - Advanced Photos - Photo View page\'.',
      'category' => 'SES - Group Albums Extension',
      'autoEdit' => false,
      'type' => 'widget',
      'name' => 'sesgroupalbum.breadcrumb-photo-view',
  ),
  array(
      'title' => 'SES - Group Albums Extension - Breadcrumb for Album View Page',
      'description' => 'Displays breadcrumb for albums. This widget should be placed on the \'SES - Advanced Photos - Album View page\'.',
      'category' => 'SES - Group Albums Extension',
      'autoEdit' => false,
      'type' => 'widget',
      'name' => 'sesgroupalbum.breadcrumb-album-view',
  ),
  array(
    'title' => 'SES - Group Albums Extension - Group Profile Albums',
    'description' => 'Displays a group\'s albums on group profile page.',
    'category' => 'SES - Group Albums Extension',
    'type' => 'widget',
		'autoEdit' => true,
    'name' => 'sesgroupalbum.profile-photos',
    'isPaginated' => true,
    'defaultParams' => array(
        'title' => 'Photos',
        'titleCount' => false,
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
                        'favouriteCount' => 'Favourites Count',
                        'title' => 'Album Title',
                        'by' => 'Owner\'s Name',
                        'socialSharing' => 'Social Sharing Buttons',
                        'photoCount' => 'Photos Count',
                        'likeButton' => 'Like Button',
                        'favouriteButton' => 'Favourite Button',
                    ),
                //'value' => array('like','comment','view','rating','title','by','socialSharing'),
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
);