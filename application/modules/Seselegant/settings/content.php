<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Seselegant
 * @package    Seselegant
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: content.php 2016-04-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


$albumWidget = array(
    array(
        'title' => 'SES - Responsive Elegant Theme - Popular Albums',
        'description' => 'Displays a widget for popular albums on your website on various popularity criteria. Edit this widget to choose tabs to be shown in this widget. This widget only for Landing Page.',
        'category' => 'SES - Responsive Elegant Theme',
        'type' => 'widget',
        'name' => 'seselegant.popularalbum-widget',
        'autoEdit' => true,
        'adminForm' => 'Seselegant_Form_Admin_Tabbed',
    ),
);


if (Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesmusic')) {

	$musicWidget = array(
		array(
			'title' => 'SES - Responsive Elegant Theme - Featured, Sponsored and Hot Music Albums Carousel',
			'description' => "Disaplys Featured, Sponsored or Hot Carousel of music albums. This widget only for Landing Page.",
			'category' => 'SES - Responsive Elegant Theme',
			'type' => 'widget',
			'autoEdit' => true,
			'name' => 'seselegant.featured-sponsored-hot-carousel',
			'adminForm' => array(
			'elements' => array(
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
										"likeCount" => "Likes Count",
										"commentCount" => "Comments Count",
										"viewCount" => "Views Count",
										"title" => "Music Album Title",
										"postedby" => "Music Albums Owner's Name",
								)
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
	);
}

$arrayGallery = array();
$results = Engine_Api::_()->getDbtable('banners', 'seselegant')->getBanner(array('fetchAll' => true));
if (count($results) > 0) {
  foreach ($results as $gallery)
    $arrayGallery[$gallery['banner_id']] = $gallery['banner_name'];
}

$elegant_theme_widget = array(
    array(
        'title' => 'SES - Responsive Elegant Theme - Banner Slideshow',
        'description' => 'You can place this widget anywhere. You can choose Slideshow in this widget. This widget can be placed multiple times on a single or separate pages.',
        'category' => 'SES - Responsive Elegant Theme',
        'type' => 'widget',
        'name' => 'seselegant.banner-slideshow',
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'banner_id',
                    array(
                        'label' => 'Choose the Banner to be shown in this widget.',
                        'multiOptions' => $arrayGallery,
                        'value' => 1,
                    )
                ),
                array(
                    'Select',
                    'full_width',
                    array(
                        'label' => 'Do you want to show this Banner in full width?',
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
                        'label' => 'Enter the height of this Banner (in pixels).',
                        'value' => 200,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    ),
                ),
            ),
        ),
    ),
    array(
        'title' => 'SES - Responsive Elegant Theme - Mini Menu',
        'description' => 'This widget shows the site-wide mini menu. You can edit  its contents in your menu editor.',
        'category' => 'SES - Responsive Elegant Theme',
        'type' => 'widget',
        'name' => 'seselegant.menu-mini'
    ),
    array(
			'title' => 'SES - Responsive Elegant Theme - Main Menu',
			'description' => 'This widget shows the site-wide main menu. You can edit its contents in your menu editor. You can upload icons for each menu item of Main Navigation Menu from the "Manage Menu Icons" section of Elegant Theme.',
			'category' => 'SES - Responsive Elegant Theme',
			'type' => 'widget',
			'name' => 'seselegant.menu-main',
			'adminForm' => array(
			'elements' => array(
					array(
							'Text',
							'seselegant_main_navigation',
							array(
									'label' => 'Enter count for Main Navigation Menu items to be shown in this widget.',
									'value' => '10',
							)
					),
					array(
							'Radio',
							'show_main_menu',
							array(
									'label' => "Do you want to show this Main Menu Navigation to non-logged in users?",
									'multiOptions' => array(
											'1' => 'Yes',
											'0' => 'No',
									),
									'value' => 1,
							)
					),
			)
			),
    ),
    array(
			'title' => 'SES - Responsive Elegant Theme - Footer Menu',
			'description' => 'This widget shows the site-wide footer menu. You can edit its contents in your menu editor. You can upload icons for each menu item of Footer Menu from the "Manage Menu Icons" section of Elegant Theme.',
			'category' => 'SES - Responsive Elegant Theme',
			'type' => 'widget',
			'name' => 'seselegant.menu-footer',
			'adminForm' => array(
			'elements' => array(
					array(
							'Text',
							'facebook_url_path',
							array(
									'label' => 'Enter your Facebook Page URL.',
									'value' => 'http://www.facebook.com/',
							)
					),
					array(
							'Text',
							'googleplus_url_path',
							array(
									'label' => 'Enter your Google Plus URL.',
									'value' => 'http://plus.google.com/',
							)
					),
					array(
							'Text',
							'twitter_url_path',
							array(
									'label' => 'Enter your Twitter Page URL.',
									'value' => 'https://www.twitter.com/',
							)
					),
					array(
							'Text',
							'pinterest_url_path',
							array(
									'label' => 'Enter your Pinterest Page URL.',
									'value' => 'https://www.pinterest.com/',
							)
					)
			)
			),
    ),
    array(
			'title' => 'SES - Responsive Elegant Theme - Slideshow',
			'description' => 'This widget displays elegant theme slideshow as chosen by you from the "Manage Slides" section of Elegant Theme.',
			'category' => 'SES - Responsive Elegant Theme',
			'type' => 'widget',
			'name' => 'seselegant.home-slideshow'
    ),
    array(
			'title' => 'SES - Responsive Elegant Theme - Text and Feature Blocks',
			'description' => 'This widget displays the text and feature blocks as configured by you from the "Global Settings" of Elegant Theme.',
			'category' => 'SES - Responsive Elegant Theme',
			'type' => 'widget',
			'name' => 'seselegant.html-block-1',
			'adminForm' => array(
			'elements' => array(
					array(
							'Text',
							'content_height',
							array(
									'label' => 'Height',
									'value' => '',
							)
					),
					array(
							'Text',
							'content_width',
							array(
									'label' => 'Width',
									'value' => '',
							)
					)
			)
			),
    ),
    array(
			'title' => 'SES - Responsive Elegant Theme - Member Cloud',
			'description' => "Displays members of your site in an attractive widget with a color affect on mouse-over on member's profile picture. You can configure various settings of this widget by clicking on 'edit'.",
			'category' => 'SES - Responsive Elegant Theme',
			'type' => 'widget',
			'autoEdit' => true,
			'name' => 'seselegant.member-cloud',
			'adminForm' => array(
				'elements' => array(
						array(
								'Radio',
								'heading',
								array(
										'label' => "Do you want to show total member's count on your site in this widget?",
										'multiOptions' => array(
												'1' => 'Yes',
												'0' => 'No',
										),
										'value' => 1,
								)
						),
					  array(
								'Radio',
								'showTitle',
								array(
										'label' => "Do you want to show title of member name in this widget?",
										'multiOptions' => array(
												'1' => 'Yes',
												'0' => 'No',
										),
										'value' => 1,
								)
						),
						array(
								'Text',
								'memberCount',
								array(
										'label' => 'Enter number of members to be shown in this widget.',
										'value' => 33,
								)
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
				)
			),
    ),
		 array(
			'title' => 'SES - Responsive Elegant Theme - Search',
			'description' => "'",
			'category' => 'SES - Responsive Elegant Theme',
			'type' => 'widget',
			'autoEdit' => false,
			'name' => 'seselegant.search',
    ),
		array(
			'title' => 'SES - Responsive Elegant Theme - Custom browse Menu',
			'description' => "'",
			'category' => 'SES - Responsive Elegant Theme',
			'type' => 'widget',
			'autoEdit' => false,
			'name' => 'seselegant.custom-browse-menu',
    ),
    array(
			'title' => 'SES - Responsive Elegant Theme - Paralex Effect Widget',
			'description' => 'You can place this widget anywhere. Image to be chosen in this widget should be first uploaded from the "Layout" >> "File & Media Manager" section. This widget can be placed multiple times on a single or separate pages.',
			'category' => 'SES - Responsive Elegant Theme',
			'type' => 'widget',
			'autoEdit' => true,
			'name' => 'seselegant.paralex',
			'adminForm' => 'Seselegant_Form_Admin_Paralex',
    )
  );
if (!empty($musicWidget)) {
  $elegant_theme_widget = array_merge($elegant_theme_widget, $musicWidget);
}
if (!empty($albumWidget)) {
  $elegant_theme_widget = array_merge($elegant_theme_widget, $albumWidget);
}
return $elegant_theme_widget;
