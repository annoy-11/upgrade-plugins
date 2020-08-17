<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesexpose
 * @package    Sesexpose
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: content.php 2017-06-17 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$arrayGallery = array();
$results = Engine_Api::_()->getDbtable('banners', 'sesexpose')->getBanner(array('fetchAll' => true));
if (count($results) > 0) {
  foreach ($results as $gallery)
    $arrayGallery[$gallery['banner_id']] = $gallery['banner_name'];
}
$moduleEnable = Engine_Api::_()->sesexpose()->getModulesEnable();

$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
$banner_options[] = '';
$path = new DirectoryIterator(APPLICATION_PATH . '/public/admin/');
foreach ($path as $file) {
  if ($file->isDot() || !$file->isFile())
    continue;
  $base_name = basename($file->getFilename());
  if (!($pos = strrpos($base_name, '.')))
    continue;
  $extension = strtolower(ltrim(substr($base_name, $pos), '.'));
  if (!in_array($extension, array('gif', 'jpg', 'jpeg', 'png')))
    continue;
  $banner_options['public/admin/' . $base_name] = $base_name;
}
$fileLink = $view->baseUrl() . '/admin/files/';

$expose_theme_widget = array(
    array(
        'title' => 'SES - Responsive Expose Theme - Banner Slideshow',
        'description' => 'This widget shows the Banner as created by you from the admin panel of this plugin. Edit the widget to configure various setting and choose banner.',
        'category' => 'SES - Responsive Expose Theme',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesexpose.banner-slideshow',
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
			'title' => 'SES - Responsive Expose Theme - Footer Menu',
			'description' => 'This widget shows the site-wide footer menu. Edit this widget to configure various settings.',
			'category' => 'SES - Responsive Expose Theme',
			'type' => 'widget',
			'autoEdit' => true,
			'name' => 'sesexpose.menu-footer',
			'adminForm' => array(
			'elements' => array(
          array(
							'Text',
							'aboutusheading',
							array(
									'label' => 'Enter About Us Heading.',
									'value' => 'About Us',
							)
					),
          array(
							'Textarea',
							'aboutusdescription',
							array(
									'label' => 'Enter About Us Description.',
									'value' => 'Lorem Ipsum Is Simply Dummy Text Of The Printing And Typesetting Industry.',
							)
					),
          array(
            'Select',
            'footer_image',
            array(
              'label' => 'Choose from below the footer background image for your website. [Note: You can add a new photo from the "File & Media Manager" section.]',
              'multiOptions' => $banner_options,
            ),
          ),
          array(
            'Select',
            'sesexpose_module',
            array(
              'label' => 'Choose the module whose content will show in this widget in small grids.',
              'multiOptions' => $moduleEnable,
            )
          ),
          array(
							'Text',
							'blogsectionheading',
							array(
									'label' => 'Enter the heading for the module section',
									'value' => 'Blogs',
							)
					),
          array(
							'Text',
							'socialmediaheading',
							array(
									'label' => 'Enter heading for Social Media section.',
									'value' => 'FIND US ON',
							)
					),
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
									'label' => 'Enter your Google Plus Page URL.',
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
			'title' => 'SES - Responsive Expose Theme - Member Cloud',
			'description' => "Displays members of your site in an attractive widget with a color affect on mouse-over on member's profile picture. You can configure various settings of this widget by clicking on 'edit'.",
			'category' => 'SES - Responsive Expose Theme',
			'type' => 'widget',
			'autoEdit' => true,
			'name' => 'sesexpose.member-cloud',
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
			'title' => 'SES - Responsive Expose Theme - Header',
			'description' => 'This widget shows the site-wide header which includes Main Menu, Mini Menu, Site Logo, Search and extra links. You can edit this from the admin panel of this theme.',
			'category' => 'SES - Responsive Expose Theme',
			'type' => 'widget',
			'name' => 'sesexpose.header',
			'autoEdit' => false,
		),
  );
return $expose_theme_widget;