<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventspeaker
 * @package    Seseventspeaker
 * @copyright  Copyright 2018-2017 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: content.php 2017-03-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


return array(
    array(
        'title' => 'SES - Advanced Events - Event Profile Speakers',
        'description' => 'Displays a event\'s speakers.',
        'category' => 'SES - Advanced Events',
        'type' => 'widget',
        'name' => 'seseventspeaker.profile-speakers',
        'defaultParams' => array(
            'title' => 'Speakers',
        ),
	      'adminForm' => array(
	        'elements' => array(
	            array(
	                'Select',
	                'Type',
	                array(
	                    'label' => 'Do you want speakers to be auto-loaded when users scroll down the page?',
	                    'multiOptions' => array(
	                        '1' => 'Yes',
	                        '0' => 'No, show \'View More\''
	                    ),
	                    'value' => 1,
	                )
	            ),
	            array(
	                'MultiCheckbox',
	                'information',
	                array(
	                    'label' => 'Choose the options that you want to be displayed in this widget".',
	                    'multiOptions' => array(
								        'featured' => 'Featured Label',
								        'sponsored' => 'Sponsored Label',
								        'email' => 'Email',
								        'phone' => 'Phone',
								        'location' => 'Location',
								        'website' => 'Website',
								        'facebook' => 'Facebook Icon',
								        'linkdin' => 'LinkedIn Icon',
								        'twitter' => 'Twitter Icon',
								        'googleplus' => 'Google Plus Icon'
	                    ),
	                ),
	            ),
	            array(
	                'Text',
	                'height',
	                array(
	                    'label' => 'Enter the height for Grid View (in pixels).',
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
	                    'label' => 'Enter the width for Grid View (in pixels).',
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
	                    'label' => 'Count (number of content to show)',
	                    'value' => 2,
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
        'title' => 'SES - Advanced Events - Popular / Featured / Sponsored Event Speakers',
        'description' => "Displays speakers as chosen by you based on chosen criteria for this widget. The placement of this widget depends on the criteria chosen for this widget.",
        'category' => 'SES - Advanced Events',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'seseventspeaker.featured-sponsored',
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'viewType',
                    array(
                        'label' => "View Type",
                        'multiOptions' => array(
                            'list' => 'List View',
                            'grid' => 'Grid View',
                        ),
                    )
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
                            "most_favourite" => "Most Favourite",
                        )
                    ),
                    'value' => 'recently_updated',
                ),
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show for event in this widget.",
                        'multiOptions' => array(
                            'title' => 'Speaker Name',
                            'like' => 'Likes Count',
                            'view' => 'Views Count',
                            'favourite' => 'Favourite Count',
                            'featuredLabel' => 'Featured Label',
                            'sponsoredLabel' => 'Sponsored Label',
                            'favouriteButton' => 'Favourite Button',
                            'likeButton' => 'Like Button',
                            'socialSharing' => 'Social Sharing Buttons',
                        ),
                    )
                ),
                array(
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
								),
                array(
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
								),
                array(
                    'Text',
                    'height',
                    array(
                        'label' => 'Enter the height of one event block (in pixels).',
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
                        'label' => 'Enter the width of one event block (in pixels).',
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
                        'label' => 'Count (number of event to show).',
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
        'title' => 'SES - Advanced Events - Speaker Browse Search',
        'description' => 'Displays a search form in the speakers browse page. Edit this widget to choose the search option to be shown in the search form.',
        'category' => 'SES - Advanced Events',
        'autoEdit' => true,
        'type' => 'widget',
        'name' => 'seseventspeaker.speaker-browse-search',
        'adminForm' => array(
            'elements' => array(
                array(
                    'MultiCheckbox',
                    'searchOptionsType',
                    array(
                        'label' => "Choose from below the searching options that you want to show in this widget.",
                        'multiOptions' => array(
                            'searchBox' => 'Search Speaker',
                            'show' => 'List By',
                        ),
                    )
                ),
            )
        ),
    ),
		array(
		'title' => 'Advanced Events - Speaker Details',
		'description' => 'This widget displays all details of a speaker.The recommended page for this widget is "Advanced Events - Speaker Profile Page".',
		'category' => 'SES - Advanced Events',
		'type' => 'widget',
		'autoEdit' => true,
		'name' => 'seseventspeaker.profile-speaker',
      'adminForm' => array(
          'elements' => array(
              array(
                  'MultiCheckbox',
                  'infoshow',
                  array(
                      'label' => 'Choose from below the details that you want to show in this widget.',
                      'multiOptions' => array(
                          'profilePhoto' => "Profile Photo",
                          'displayname' => 'Display Name',
                          'detaildescription' => 'About Member (Detailed Description)',
                          'phone' => 'Phone',
                          'email' => 'Email',
                          'view' => 'View Count',
                          'favourite' => 'Favourite Count',
                          'speakerEventCount' => 'Associated Event Count',
                          'website' => 'Website',
                          'facebook' => 'Facebook Icon',
                          'twitter' => 'Twitter Icon',
                          'linkdin' => 'Linkdin Icon',
                          'googleplus' => 'Google Plus Icon',
                          'featuredLabel' => 'Featured Label',
                          'sponsoredLabel' => 'Sponsored Label',
                          'favouriteButton' => 'Favourite Button',
                          'socialSharing' => 'Social Sharing Buttons',
                      ),
                  ),
              ),
              array(
                  'Text',
                  'descriptionText',
                  array(
                      'label' => 'Enter the text for "Description"',
                  ),
                  'value' => 'more',
              ),
          )
      ),
		),
		array(
        'title' => 'SES - Advanced Events - Browse Speakers',
        'description' => 'Displays all speakers on your website. The recommended page for this widget is "Advanced Events - Browse Speakers Page".',
        'category' => 'SES - Advanced Events',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'seseventspeaker.browse-speakers',
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'Type',
                    array(
                        'label' => 'Do you want speakers to be auto-loaded when users scroll down the page?',
                        'multiOptions' => array(
                            '1' => 'Yes',
                            '0' => 'No, show \'View More\''
                        ),
                        'value' => 1,
                    )
                ),
                array(
                    'MultiCheckbox',
                    'information',
                    array(
                        'label' => 'Choose the options that you want to be displayed in this widget".',
                        'multiOptions' => array(
									        'featuredLabel' => 'Featured Label',
									        'sponsoredLabel' => 'Sponsored Label',
									        'view' => 'Views Count',
                          'favourite' => 'Favourite Count',
                          'speakerEventCount' => 'Associated Event Count',
// 									        'email' => 'Email',
// 									        'phone' => 'Phone',
// 									        'location' => 'Location',
// 									        'website' => 'Website',
// 									        'facebook' => 'Facebook Icon',
// 									        'linkdin' => 'LinkedIn Icon',
// 									        'twitter' => 'Twitter Icon',
// 									        'googleplus' => 'Google Plus Icon',
									        'favouriteButton' => 'Favourite Button',
									        'socialSharing' => 'Social Sharing Buttons',
                        ),
                    ),
                ),
                array(
                    'Text',
                    'height',
                    array(
                        'label' => 'Enter the height for Grid View (in pixels).',
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
                        'label' => 'Enter the width for Grid View (in pixels).',
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
                        'label' => 'Count (number of content to show)',
                        'value' => 2,
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
        'title' => 'SES - Advanced Events - Speaker of the Day',
        'description' => 'This widget displays speaker as \'Speaker of the Day\' randomly as choosen by you from the admin panel of this plugin.',
        'category' => 'SES - Advanced Events',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'seseventspeaker.oftheday',
        'adminForm' => array(
            'elements' => array(
                array(
                    'MultiCheckbox',
                    'infoshow',
                    array(
                        'label' => 'Choose from below the details that you want to show in this widget. [Display of below options will depend on the Design chosen from above setting.]',
                        'multiOptions' => array(
                            'featured' => 'Featured Label',
                            'sponsored' => 'Sponsored Label',
                            'displayname' => 'Display Name',
//                             'email' => 'Email',
//                             'phone' => 'Phone',
//                             'location' => 'Location',
//                             'website' => 'Website',
//                             'facebook' => 'Facebook Icon',
//                             'linkdin' => 'LinkedIn Icon',
//                             'twitter' => 'Twitter Icon',
//                             'googleplus' => 'Google Plus Icon',
                            'viewMore' => 'More as Team Member',
                        ),
                    ),
                ),
                array(
                    'Text',
                    'viewMoreText',
                    array(
                        'label' => 'Enter the text for "more"',
                    ),
                    'value' => 'more',
                ),
            ),
        ),
    ),
);
?>