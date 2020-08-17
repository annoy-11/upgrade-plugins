<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: content.php  2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$headScript = new Zend_View_Helper_HeadScript();
$headScript->appendFile(Zend_Registry::get('StaticBaseUrl') . 'application/modules/Sesbasic/externals/scripts/jscolor/jscolor.js');
$headScript->appendFile(Zend_Registry::get('StaticBaseUrl') . 'application/modules/Sesbasic/externals/scripts/jquery.min.js');

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

$categories = array();
if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.pluginactivated')) {
  $categories = Engine_Api::_()->getDbtable('categories', 'sesjob')->getCategoriesAssoc(array('module'=>true));
}

$viewType = array(
  'MultiCheckbox',
  'enableTabs',
  array(
      'label' => "Choose the View Type.",
      'multiOptions' => array(
      'list' => 'List View',
      'grid' => 'Grid View',
      'map' => 'Map View',
    ),
  )
);

$defaultType = array(
  'Select',
  'openViewType',
  array(
    'label' => "Choose the view type which you want to display by default. (Settings will apply, if you have selected more than one option in above tab.)",
    'multiOptions' => array(
      'list' => 'List View',
      'grid' => 'Grid View',
      'map' => 'Map View',
    ),
    'value' => 'list',
  )
);

$showCustomData = array(
  'MultiCheckbox',
  'show_criteria',
  array(
    'label' => "Choose the options that you want to be displayed in this widget.",
    'multiOptions' => array(
      'featuredLabel' => 'Featured Label',
      'sponsoredLabel' => 'Sponsored Label',
      'verifiedLabel' => 'Verified Label',
      'hotLabel' => 'Hot Label',
      'favouriteButton' => 'Favourite Button',
      'likeButton' => 'Like Button',
      'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
      'like' => 'Likes Count',
      'favourite' => 'Favorites Count',
      'comment' => 'Comments Count',
      'view' => 'Views Count',
      'title' => 'Job Title',
      'companyname'=>'Company Name',
      'industry' => "Company Industry",
      'category' => 'Category',
      'by' => 'Job Owner Name',
      'expiredLabel' => "Expired Label",
      'readmore' => 'Read More Button',
      'creationDate' => 'Creation Date',
      'location'=> 'Location',
      'descriptionlist' => 'Description (In List View)',
      'descriptiongrid' => 'Description (In Grid View)',
    ),
    'escape' => false,
  )
);
$pagging = array(
  'Radio',
  'pagging',
  array(
    'label' => "Do you want the jobs to be auto-loaded when users scroll down the page?",
    'multiOptions' => array(
	'auto_load' => 'Yes, Auto Load',
	'button' => 'No, show \'View more\' link.',
	'pagging' => 'No, show \'Pagination\'.'
    ),
    'value' => 'auto_load',
  )
);
$imageType = array(
    'Select',
    'imageType',
    array(
        'label' => "Choose the shape of Photo.",
        'multiOptions' => array(
            'rounded' => 'Circle',
            'square' => 'Square',
        ),
        'value' => 'square',
    )
);
$photoHeight = array(
    'Text',
    'photo_height',
    array(
        'label' => 'Enter the height of main photo block in Grid Views (in pixels).',
        'value' => '160',
    )
);
$photowidth = array(
    'Text',
    'photo_width',
    array(
        'label' => 'Enter the width of main photo block in Grid Views (in pixels).',
        'value' => '250',
    )
);
$titleTruncationList = array(
  'Text',
  'title_truncation_list',
  array(
    'label' => 'Title truncation limit for List Views.',
    'value' => 45,
    'validators' => array(
      array('Int', true),
      array('GreaterThan', true, array(0)),
    )
  )
);
$titleTruncationGrid = array(
  'Text',
  'title_truncation_grid',
  array(
    'label' => 'Title truncation limit for Grid Views.',
    'value' => 45,
    'validators' => array(
      array('Int', true),
      array('GreaterThan', true, array(0)),
    )
  )
);

$DescriptionTruncationList = array(
  'Text',
  'description_truncation_list',
  array(
    'label' => 'Description truncation limit for List Views.',
    'value' => 45,
    'validators' => array(
      array('Int', true),
      array('GreaterThan', true, array(0)),
    )
  )
);
$DescriptionTruncationGrid = array(
  'Text',
  'description_truncation_grid',
  array(
    'label' => 'Description truncation limit for Grid Views.',
    'value' => 45,
    'validators' => array(
      array('Int', true),
      array('GreaterThan', true, array(0)),
    )
  )
);

$heightOfContainerList = array(
  'Text',
  'height_list',
  array(
    'label' => 'Enter the height of main photo block in List Views (in pixels).',
    'value' => '230',
  )
);
$widthOfContainerList = array(
  'Text',
  'width_list',
  array(
    'label' => 'Enter the width of main photo block in List Views (in pixels).',
    'value' => '260',
  )
);
$heightOfContainerGrid = array(
  'Text',
  'height_grid',
  array(
    'label' => 'Enter the height of one block in Grid Views (in pixels).',
    'value' => '270',
  )
);
$widthOfContainerGrid = array(
  'Text',
  'width_grid',
  array(
    'label' => 'Enter the width of one block in Grid Views (in pixels).',
    'value' => '389',
  )
);

$widthOfContainerGridPhoto = array(
  'Text',
  'width_grid_photo',
  array(
    'label' => 'Enter the width of main photo block in Grid Views (in pixels).',
    'value' => '260',
  )
);

$heightOfContainer = array(
    'Text',
    'height',
    array(
        'label' => 'Enter the height of one block (in pixels).',
        'value' => '160',
    )
);
$widthOfContainer = array(
    'Text',
    'width',
    array(
        'label' => 'Enter the width of one block (in pixels).',
        'value' => '250',
    )
);

if(Engine_Api::_()->getDbtable("modules", "core")->isModuleEnabled("sesjob")) {

  $banner_options = array('' => '');
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
}

return array(
    array(
        'title' => 'SES - Advanced Job - Banner with AJAX Search and Categories',
        'description' => 'This widget allows you to add an attractive banner and AJAX Search to search Jobs based on their categories and locations. You can also enable Categories to be shown attractively in carousel in this widget.',
        'category' => 'SES - Advanced Job',
        'type' => 'widget',
        'name' => 'sesjob.banner-search',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'bgimage',
                    array(
                        'label' => 'Choose the background image to be shown in this widget.',
                        'multiOptions' => $banner_options,
                        'value' => '',
                    )
                ),
                array(
                    'Text',
                    'banner_title',
                    array(
                        'label' => 'Enter the title of Banner.',
                        'value' => '',
                    )
                ),
                array(
                    'Textarea',
                    'description',
                    array(
                        'label' => "Enter the description of Banner.",
                        'value' => "",
                    )
                ),
                array(
                    'Text',
                    'height_image',
                    array(
                        'label' => 'Enter the height of Banner image (in pixels).',
                        'value' => 400,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        ),
                    ),
                ),
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => 'Choose the options to be shown in the search bar in this widget.',
                        'multiOptions' => array(
                            'title' => 'Job Title',
                            'location' => 'Location',
                            'category' => 'Categories',
                        ),
                    )
                ),
                array(
                    'Radio',
                    'show_carousel',
                    array(
                        'label' => " Do you want to show categories carousel in this widget?",
                        'multiOptions' => array(
                            '1' => 'Yes',
                            '0' => 'No',
                        ),
                        'value' => 1,
                    )
                ),
                array(
                    'Text',
                    'category_carousel_title',
                    array(
                        'label' => 'Enter the Title of category carousel.',
                        'value' => '',
                    )
                ),
                array(
                    'Radio',
                    'show_full_width',
                    array(
                        'label' => "Show this widget in full width?",
                        'multiOptions' => array(
                            'yes' => 'Yes',
                            'no' => 'No'
                        ),
                        'value' => 'yes',
                    )
                ),
            ),
        ),
    ),
	array(
		'title' => 'SES - Advanced Job - Content Profile Jobs',
		'description' => 'This widget enables you to allow users to create jobs on different content on your website like Groups. Place this widget on the content profile page, for example SE Group to enable group owners to create jobs in their Groups. You can choose the visibility of the jobs created in a content to only that content or show in this plugin as well from the "Jobs Created in Content Visibility" setting in Global setting of this plugin.',
		'category' => 'SES - Advanced Job',
		'type' => 'widget',
		'autoEdit' => true,
		'name' => 'sesjob.other-modules-profile-sesjobs',
		'requirements' => array(
			'subject' => 'user',
		),
		'adminForm' => 'Sesjob_Form_Admin_OtherModulesTabbed',
	),
  array(
    'title' => 'SES - Advanced Job - Job Profile - Apply For Job',
    'description' => 'This widget for user to apply job. You can place this widget on Job Profile Page',
    'category' => 'SES - Advanced Job',
    'type' => 'widget',
    'name' => 'sesjob.job-apply-button',
    'autoEdit' => false,
  ),
  array(
    'title' => 'SES - Advanced Job - Job Profile - People Like Job',
    'description' => 'Placed on a Job view page.',
    'category' => 'SES - Advanced Job',
    'type' => 'widget',
    'name' => 'sesjob.people-like-item',
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
    'title' => 'SES - Advanced Job - Popular / Featured / Sponsored / Verified Jobs Carousel',
    'description' => "Disaplys carousel of jobs as configured by you based on chosen criteria for this widget. You can also choose to show Jobs of specific categories in this widget.",
    'category' => 'SES - Advanced Job',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesjob.featured-sponsored-verified-category-carousel',
    'adminForm' => array(
      'elements' => array(
			array(
	  'Select',
	  'carousel_type',
	  array(
	    'label' => 'Choose the view type. [In Slick View, first and last job will partially show in the carousel.]',
	    'multiOptions' => array(
	      "1" => "Slick View",
	      "2" => "Simple View"
	    )
	  ),
	  'value' => '1'
	),
	array(
	  'Text',
	  'slidesToShow',
	    array(
	    'label' => 'Enter number of slides to be shown at once. (This setting will only work when "Simple View" is selected for above setting).',
	    'value' => '3',
	    'validators' => array(
	      array('Int', true),
	      array('GreaterThan', true, array(0)),
	    )
	  )
	),
	array(
	  'Select',
	  'category',
	  array(
	    'label' => 'Choose the category.',
	    'multiOptions' => $categories
	  ),
	  'value' => ''
	),

	array(
	  'Select',
	  'criteria',
	  array(
	    'label' => "Display Content",
	    'multiOptions' => array(
			  '0' => 'All including Featured and Sponsored',
	      '1' => 'Only Featured',
	      '2' => 'Only Sponsored',
	      '6' => 'Only Verified',
	    ),
	    'value' => 5,
	  )
	),
	array(
		'Select',
		'order',
		array(
			'label' => 'Duration criteria for the jobs to be shown in this widget',
			'multiOptions' => array(
				'' => 'All Jobs',
				'week' => 'This Week Jobs',
				'month' => 'This Month Jobs',
			),
			'value' => '',
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
	  'Select',
	  'isfullwidth',
	  array(
	    'label' => 'Do you want to show carousel in full width?',
	    'multiOptions'=>array(
	      1=>'Yes',
	      0=>'No'
	    ),
	    'value' => 1,
	  )
	),
		array(
	  'Select',
	  'autoplay',
	  array(
	    'label' => "Do you want to enable autoplay of jobs?",
	    'multiOptions' => array(
	      1=>'Yes',
	      0=>'No'
	    ),
	  ),
	),
	array(
	  'Text',
	  'speed',
	    array(
	    'label' => 'Delay time for next job when you have enabled autoplay.',
	    'value' => '2000',
	    'validators' => array(
	      array('Int', true),
	      array('GreaterThan', true, array(0)),
	    )
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
            'favourite' => 'Favourites Count',
            'view' => 'Views Count',
            'title' => 'Job Title',
            'companyname'=>'Company Name',
            'industry' => "Company Industry",
            'by' => 'Job Owner\'s Name',
            'featuredLabel' => 'Featured Label',
            'sponsoredLabel' => 'Sponsored Label',
            'verifiedLabel' => 'Verified Label',
            'hotLabel' => 'Hot Label',
            'favouriteButton' => 'Favourite Button',
            'likeButton' => 'Like Button',
            'category' => 'Category',
            'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
            'creationDate' => 'Show Publish Date',
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
	    'label' => 'Job title truncation limit.',
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
	    'label' => 'Count (number of jobs to show).',
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
    'title' => 'SES - Advanced Job - Tabbed widget for Popular Jobs',
    'description' => 'Displays a tabbed widget for popular jobs on your website based on various popularity criterias. Edit this widget to choose tabs to be shown in this widget. This widget can be placed anywhere on your website.',
    'category' => 'SES - Advanced Job',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesjob.tabbed-widget-job',
    'requirements' => array(
      'subject' => 'job',
    ),
    'adminForm' => 'Sesjob_Form_Admin_Tabbed',
  ),
	array(
		'title' => 'SES - Advanced Job - Company Profile - Jobs',
		'description' => 'Displays a company job entries on their profiles page. The recommended page for this widget is "SES - Advanced Jobs - Company Profile Page"',
		'category' => 'SES - Advanced Job',
		'type' => 'widget',
		'autoEdit' => true,
		'name' => 'sesjob.company-sesjobs',
		'adminForm' => 'Sesjob_Form_Admin_Tabbed',
	),
	array(
		'title' => 'SES - Advanced Job - Profile Jobs',
		'description' => 'Displays a member\'s job entries on their profiles. The recommended page for this widget is "Member Profile Page"',
		'category' => 'SES - Advanced Job',
		'type' => 'widget',
		'autoEdit' => true,
		'name' => 'sesjob.profile-sesjobs',
		'requirements' => array(
			'subject' => 'user',
		),
		'adminForm' => 'Sesjob_Form_Admin_Tabbed',
	),
  array(
    'title' => 'SES - Advanced Job - Browse Jobs',
    'description' => 'Display all jobs on your website. The recommended page for this widget is "SES - Advanced Job - Browse Jobs Page".',
    'category' => 'SES - Advanced Job',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesjob.browse-jobs',
    'requirements' => array(
      'subject' => 'job',
    ),
    'adminForm' => array(
      'elements' => array(
				$viewType,
				$defaultType,
				$showCustomData,
        array(
            'Select',
            'socialshare_enable_listview1plusicon',
            array(
                'label' => "Enable plus (+) icon for social share buttons in List View?",
                'multiOptions' => array(
                  '1' => 'Yes',
                  '0' => 'No',
                ),
            )
        ),
        array(
          'Text',
          'socialshare_icon_listview1limit',
          array(
            'label' => 'Enter the number of Social Share Buttons after which plus (+) icon will come in List View. Other social sharing icons will display on clicking this plus icon.',
            'value' => 2,
            'validators' => array(
                array('Int', true),
                array('GreaterThan', true, array(0)),
            ),
          ),
        ),
        array(
            'Select',
            'socialshare_enable_gridview1plusicon',
            array(
                'label' => "Enable plus (+) icon for social share buttons in Grid View?",
                'multiOptions' => array(
                  '1' => 'Yes',
                  '0' => 'No',
                ),
            )
        ),
        array(
          'Text',
          'socialshare_icon_gridview1limit',
          array(
            'label' => 'Enter the number of Social Share Buttons after which plus (+) icon will come in Grid View. Other social sharing icons will display on clicking this plus icon.',
            'value' => 2,
            'validators' => array(
                array('Int', true),
                array('GreaterThan', true, array(0)),
            ),
          ),
        ),
        array(
            'Select',
            'socialshare_enable_mapviewplusicon',
            array(
                'label' => "Enable plus (+) icon for social share buttons in Map View?",
                'multiOptions' => array(
                  '1' => 'Yes',
                  '0' => 'No',
                ),
            )
        ),
        array(
          'Text',
          'socialshare_icon_mapviewlimit',
          array(
            'label' => 'Enter the number of Social Share Buttons after which plus (+) icon will come in Map View. Other social sharing icons will display on clicking this plus icon.',
            'value' => 2,
            'validators' => array(
                array('Int', true),
                array('GreaterThan', true, array(0)),
            ),
          ),
        ),
        array(
        'Select',
        'category',
          array(
            'label' => 'Choose the category.',
            'multiOptions' => $categories
          ),
          'value' => ''
        ),
				array(
					'Select',
					'sort',
					array(
						'label' => 'Choose Job Display Criteria.',
						'multiOptions' => array(
						"recentlySPcreated" => "Recently Created",
						"mostSPviewed" => "Most Viewed",
						"mostSPliked" => "Most Liked",
						"mostSPated" => "Most Rated",
						"mostSPcommented" => "Most Commented",
						"mostSPfavourite" => "Most Favourite",
						'featured' => 'Only Featured',
						'sponsored' => 'Only Sponsored',
						'verified' => 'Only Verified',
						'hot' => 'Only Hot',
						),
					),
						'value' => 'most_liked',
				),
				array(
					'Select',
					'show_item_count',
					array(
						'label' => 'Do you want to show jobs count in this widget?',
						'multiOptions' => array(
							'1' => 'Yes',
							'0' => 'No',
						),
						'value' => '0',
					),
				),
				$titleTruncationList,
				$titleTruncationGrid,
				$DescriptionTruncationList,
				$DescriptionTruncationGrid,
				$heightOfContainerList,
				$widthOfContainerList,
				$heightOfContainerGrid,
				$widthOfContainerGrid,
				$widthOfContainerGridPhoto,
				array(
					'Text',
					'limit_data_grid',
					array(
						'label' => 'Count for Grid Views (number of jobs to show).',
						'value' => 20,
						'validators' => array(
							array('Int', true),
							array('GreaterThan', true, array(0)),
						)
					)
				),
				array(
					'Text',
					'limit_data_list',
					array(
						'label' => 'Count for List Views (number of jobs to show).',
						'value' => 20,
						'validators' => array(
							array('Int', true),
							array('GreaterThan', true, array(0)),
						)
					)
				),
                $pagging,
      )
    ),
  ),
  array(
    'title' => 'SES - Advanced Job - Browse Companies',
    'description' => 'Display all companies on your website. The recommended page for this widget is "SES - Advanced Job - Browse Companies Page".',
    'category' => 'SES - Advanced Job',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesjob.browse-company',
    'adminForm' => array(
      'elements' => array(
        array(
            'MultiCheckbox',
            'enableTabs',
            array(
                'label' => "Choose the View Type.",
                'multiOptions' => array(
                    'list' => 'List View',
                    'grid' => 'Grid View',
                ),
            )
        ),
        array(
            'Select',
            'openViewType',
            array(
                'label' => "Choose the view type which you want to display by default. (Settings will apply, if you have selected more than one option in above tab.)",
                'multiOptions' => array(
                    'list' => 'List View',
                    'grid' => 'Grid View',
                ),
                'value' => 'list',
            )
        ),
        array(
            'MultiCheckbox',
            'show_criteria',
            array(
                'label' => "Choose the options that you want to be displayed in this widget.",
                'multiOptions' => array(
                    'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                    'title'=>'Company Name',
                    'by' => "Owner Name",
                    'category' => "Company Industry",
                    'subscribecount' => "Subscribe Count",
                    'jobcount' => "Jobs Count",
                    'readmore' => 'Read More Button',
                    'creationDate' => "Creation Date",
                    'descriptionlist' => 'Description (In List View)',
                    'descriptiongrid' => 'Description (In Grid View)',
                ),
                'escape' => false,
            )
        ),
        array(
            'Select',
            'socialshare_enable_listview1plusicon',
            array(
                'label' => "Enable plus (+) icon for social share buttons in List View?",
                'multiOptions' => array(
                    '1' => 'Yes',
                    '0' => 'No',
                ),
            )
        ),
        array(
          'Text',
          'socialshare_icon_listview1limit',
          array(
            'label' => 'Enter the number of Social Share Buttons after which plus (+) icon will come in List View. Other social sharing icons will display on clicking this plus icon.',
            'value' => 2,
            'validators' => array(
                array('Int', true),
                array('GreaterThan', true, array(0)),
            ),
          ),
        ),
        array(
            'Select',
            'socialshare_enable_gridview1plusicon',
            array(
                'label' => "Enable plus (+) icon for social share buttons in Grid View?",
                'multiOptions' => array(
                  '1' => 'Yes',
                  '0' => 'No',
                ),
            )
        ),
        array(
          'Text',
          'socialshare_icon_gridview1limit',
          array(
            'label' => 'Enter the number of Social Share Buttons after which plus (+) icon will come in Grid View. Other social sharing icons will display on clicking this plus icon.',
            'value' => 2,
            'validators' => array(
                array('Int', true),
                array('GreaterThan', true, array(0)),
            ),
          ),
        ),
//         array(
//             'Select',
//             'sort',
//             array(
//                 'label' => 'Choose Job Display Criteria.',
//                 'multiOptions' => array(
//                 "recentlySPcreated" => "Recently Created",
//                 "mostSPviewed" => "Most Viewed",
//                 "mostSPliked" => "Most Liked",
//                 "mostSPated" => "Most Rated",
//                 "mostSPcommented" => "Most Commented",
//                 "mostSPfavourite" => "Most Favourite",
//                 'featured' => 'Only Featured',
//                 'sponsored' => 'Only Sponsored',
//                 'verified' => 'Only Verified',
//                 'hot' => 'Only Hot',
//                 ),
//             ),
//             'value' => 'most_liked',
//         ),
        array(
            'Select',
            'show_item_count',
            array(
                'label' => 'Do you want to show companies count in this widget?',
                'multiOptions' => array(
                    '1' => 'Yes',
                    '0' => 'No',
                ),
                'value' => '0',
            ),
        ),
        $titleTruncationList,
        $titleTruncationGrid,
        $DescriptionTruncationList,
        $DescriptionTruncationGrid,
        $heightOfContainerList,
        $widthOfContainerList,
        $heightOfContainerGrid,
        $widthOfContainerGrid,
        $widthOfContainerGridPhoto,
        array(
            'Text',
            'limit_data_grid',
            array(
                'label' => 'Count for Grid Views (number of companies to show).',
                'value' => 20,
                'validators' => array(
                    array('Int', true),
                    array('GreaterThan', true, array(0)),
                )
            )
        ),
        array(
            'Text',
            'limit_data_list',
            array(
                'label' => 'Count for List Views (number of companies to show).',
                'value' => 20,
                'validators' => array(
                    array('Int', true),
                    array('GreaterThan', true, array(0)),
                )
            )
        ),
        $pagging,
      )
    ),
  ),
  array(
    'title' => 'SES - Advanced Job - Tabbed widget for Manage Jobs',
    'description' => 'This widget displays jobs created, favourite, liked, rated, etc by the member viewing the manage page. Edit this widget to configure various settings.',
    'category' => 'SES - Advanced Job',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesjob.manage-jobs',
    'requirements' => array(
      'subject' => 'job',
    ),
    'adminForm' => 'Sesjob_Form_Admin_Tabbed',
  ),

  array(
    'title' => 'SES - Advanced Job - Job Profile - Profile Options for Jobs',
    'description' => 'Displays a menu of actions (edit, report, add to favourite, share, subscribe, etc) that can be performed on a job on its profile.',
    'category' => 'SES - Advanced Job',
    'type' => 'widget',
    'name' => 'sesjob.gutter-menu',
  ),
  array(
    'title' => 'SES - Advanced Job - Job Profile - Owner Photo',
    'description' => 'Displays the owner\'s photo on the job view page.',
    'category' => 'SES - Advanced Job',
    'type' => 'widget',
    'name' => 'sesjob.gutter-photo',
    'adminForm' => array(
			'elements' => array (
        array(
          'Select',
          'photoviewtype',
          array(
            'label' => "Choose the shape of Photo.",
            'multiOptions' => array(
              'square' => 'Square',
              'circle' => 'Circle'
            ),
            'value' => 'circle',
          )
        ),
        array(
          'Text',
          'user_description_limit',
          array(
            'label' => 'Truncation limit for "About User" information .',
            'value' => 150,
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
    'title' => 'SES - Advanced Job - Job Browse Search',
    'description' => 'Displays a search form in the job browse page as configured by you.',
    'category' => 'SES - Advanced Job',
    'type' => 'widget',
    'name' => 'sesjob.browse-search',
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
	      'mostSPfavourite' => 'Most Favourite',
	      'featured' => 'Only Featured',
	      'sponsored' => 'Only Sponsored',
	      'hot' => 'Only Hot',
	      'verified' => 'Only Verified'
	    ),
	  )
	),
	array(
	  'Select',
	  'default_search_type',
	  array(
	    'label' => "Default \'Browse By\' search field.",
	    'multiOptions' => array(
	      'recentlySPcreated' => 'Recently Created',
	      'mostSPviewed' => 'Most Viewed',
	      'mostSPliked' => 'Most Liked',
	      'mostSPcommented' => 'Most Commented',
	      'featured' => 'Only Featured',
	       'hot' => 'Only Hot',
	      'sponsored' => 'Only Sponsored',
	      'hot' => 'Only Hot',
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
	    'label' => "Show \'Search Jobs Keyword\' search field?",
	    'multiOptions' => array(
	      'yes' => 'Yes',
	      'no' => 'No'
	    ),
	    'value' => 'yes',
	  )
	),
	array(
	  'Radio',
	  'searchcomp_title',
	  array(
	    'label' => "Show \'Search Company Keyword\' search field?",
	    'multiOptions' => array(
	      'yes' => 'Yes',
	      'no' => 'No'
	    ),
	    'value' => 'yes',
	  )
	),
	array(
	  'Radio',
	  'industry',
	  array(
	    'label' => "Show 'Industry' search field?",
	    'multiOptions' => array(
	      'yes' => 'Yes',
	      'no' => 'No'
	    ),
	    'value' => 'yes',
	  )
	),
	array(
	  'Radio',
	  'employmenttype',
	  array(
	    'label' => "Show 'Employment Type' search field?",
	    'multiOptions' => array(
	      'yes' => 'Yes',
	      'no' => 'No'
	    ),
	    'value' => 'yes',
	  )
	),
// 	array(
// 	  'Radio',
// 	  'educationlevel',
// 	  array(
// 	    'label' => "Show 'Education Level' search field?",
// 	    'multiOptions' => array(
// 	      'yes' => 'Yes',
// 	      'no' => 'No'
// 	    ),
// 	    'value' => 'yes',
// 	  )
// 	),
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
	array(
		'Radio',
		'has_photo',
		array(
			'label' => "Show \'Job With Photos\' search field?",
			'multiOptions' => array(
				'yes' => 'Yes',
				'no' => 'No',
			),
			'value' => 'yes',
		)
	),
      )
    ),
  ),
  array(
    'title' => 'SES - Advanced Job - Company Browse Search',
    'description' => 'Displays a search form in the company browse page as configured by you.',
    'category' => 'SES - Advanced Job',
    'type' => 'widget',
    'name' => 'sesjob.browse-company-search',
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
                'Radio',
                'search_title',
                array(
                    'label' => "Show \'Search Company Keyword\' search field?",
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
                    'label' => "Show \'Industries\' search field?",
                    'multiOptions' => array(
                    'yes' => 'Yes',
                    'no' => 'No'
                    ),
                    'value' => 'yes',
                )
            ),
        ),
    ),
  ),

  array(
    'title' => 'SES - Advanced Job - Jobs Navigation Menu',
    'description' => 'Displays a navigation menu bar in the Advanced Job\'s pages for Jobs Home, Browse Jobs, Browse Categories, etc pages.',
    'category' => 'SES - Advanced Job',
    'type' => 'widget',
    'name' => 'sesjob.browse-menu',
    'requirements' => array(
      'no-subject',
    ),
  ),
  array(
    'title' => 'SES - Advanced Job - Create New Job Link',
    'description' => 'Displays a link to create new job.',
    'category' => 'SES - Advanced Job',
    'type' => 'widget',
    'name' => 'sesjob.browse-menu-quick',
    'requirements' => array(
      'no-subject',
    ),
  ),
  array(
      'title' => 'SES Advanced Jobs - Categories Cloud / Hierarchy View',
      'description' => 'Displays all categories of jobs in cloud or hierarchy view. Edit this widget to choose various other settings.',
      'category' => 'SES - Advanced Job',
      'type' => 'widget',
      'name' => 'sesjob.tag-cloud-category',
      'autoEdit' => true,
      'adminForm' => 'Sesjob_Form_Admin_Tagcloudcategory',
  ),
  array(
    'title' => 'SES - Advanced Job - Job Profile - Similar Jobs',
    'description' => 'Displays jobs similar to the current job based on the job category. The recommended page for this widget is "SES - Advanced Job - Job Profile Page".',
    'category' => 'SES - Advanced Job',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesjob.similar-jobs',
    'adminForm' => array(
      'elements' => array (
        array(
          'MultiCheckbox',
          'show_criteria',
          array(
            'label' => "Choose from below the details that you want to show for job in this widget.",
            'multiOptions' => array(
              'like' => 'Likes Count',
              'comment' => 'Comments Count',
              'favourite' => 'Favourites Count',
              'view' => 'Views Count',
              'title' => 'Job Title',
              'companyname'=>'Company Name',
              'industry' => "Company Industry",
              'by' => 'Job Owner\'s Name',
              'featuredLabel' => 'Featured Label',
              'sponsoredLabel' => 'Sponsored Label',
              'verifiedLabel' => 'Verified Label',
              'hotLabel' => 'Hot Label',
              'favouriteButton' => 'Favourite Button',
              'likeButton' => 'Like Button',
              'category' => 'Category',
              'socialSharing' =>'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
              'likeButton' => 'Like Button',
              'favouriteButton' => 'Favourite Button',
            ),
            'escape' => false,
          )
        ),
        $socialshare_enable_plusicon,
        $socialshare_icon_limit,
        array(
          'Select',
          'showLimitData',
          array(
            'label' => 'Do you want to allow users to view more similar jobs in this widget? (If you choose Yes, then users will see Next & Previous buttons to view more jobs.)',
            'multiOptions' => array(
              "1" => "Yes, allow.",
              "0" => "No, do not allow.",
            )
          ),
          'value' => '1',
        ),

        array(
          'Text',
          'height',
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
          'list_title_truncation',
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
            'label' => 'Count (number of jobs to show).',
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
      'title' => 'SES Advanced Jobs - Job Profile - Tags',
      'description' => 'Displays all tags of the current job on Job Profile Page. The recommended page for this widget is "SES - Advanced Job - Job Profile Page".',
      'category' => 'SES - Advanced Job',
      'type' => 'widget',
      'name' => 'sesjob.profile-tags',
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
    'title' => 'SES Advanced Jobs - Tags Horizantal View',
    'description' => 'Displays all tags of jobs in horizantal view. Edit this widget to choose various other settings.',
    'category' => 'SES - Advanced Job',
    'type' => 'widget',
    'name' => 'sesjob.tag-horizantal-jobs',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
				array(
					'Radio',
					'viewtype',
					array(
            'label' => "Do you want to show widget in full width ?",
            'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
            ),
            'value' => '1',
					)
				),
        array(
          'Text',
          'widgetbgcolor',
          array(
            'class' => 'SEScolor',
            'label'=>'Choose widget background color.',
            'value' => '424242',
          )
        ),
        array(
          'Text',
          'buttonbgcolor',
          array(
            'class' => 'SEScolor',
            'label'=>'Choose background color of the button.',
            'value' => '000000',
          )
        ),
        array(
          'Text',
          'textcolor',
          array(
            'class' => 'SEScolor',
            'label'=>'Choose text color on the button.',
            'value' => 'ffffff',
          )
        ),
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
      'title' => 'SES Advanced Jobs - Tags Cloud / Tab View',
      'description' => 'Displays all tags of jobs in cloud or tab view. Edit this widget to choose various other settings.',
      'category' => 'SES - Advanced Job',
      'type' => 'widget',
      'name' => 'sesjob.tag-cloud-jobs',
      'autoEdit' => true,
      'adminForm' => 'Sesjob_Form_Admin_Tagcloudjob',
  ),
  array(
      'title' => 'SES Advanced Jobs - Browse All Tags',
      'description' => 'Displays all jobs tags on your website. The recommended page for this widget is "SES - Advanced Job - Browse Tags Page".',
      'category' => 'SES - Advanced Job',
      'type' => 'widget',
      'name' => 'sesjob.tag-albums',
  ),
  array(
		'title' => 'SES Advanced Jobs - Top Job Posters',
		'description' => 'Displays all top posters on your website.',
		'category' => 'SES - Advanced Job',
		'type' => 'widget',
		'name' => 'sesjob.top-jobgers',
		'adminForm' => array(
			'elements' => array(
				array(
					'Radio',
					'view_type',
					array(
						'label' => "Choose the View Type.",
						'multiOptions' => array(
							'horizontal' => 'Horizontal',
							'vertical' => 'Vertical',
						),
						'value' => 'vertical',
					)
				),
				array(
					'MultiCheckbox',
					'show_criteria',
					array(
						'label' => "Choose the details that you want to be shown in this widget.",
						'multiOptions' => array(
							'count' => 'Jobs Count',
							'ownername' => 'Job Owner\'s Name',
						),
					)
				),
				array(
					'Text',
					'height',
					array(
						'label' => 'Enter the height of one block [for Horizontal View (in pixels)].',
						'value' => '180',
					)
				),
				array(
					'Text',
					'width',
					array(
						'label' => 'Enter the width of one block [for Horizontal View (in pixels)].',
						'value' => '180',
					)
				),
				array(
					'Select',
					'showLimitData',
					array(
						'label' => 'Do you want to allow users to view more job posters in this widget? (If you choose Yes, then users will see Next & Previous buttons to view more job posters.)',
						'multiOptions' => array(
							"1" => "Yes, allow.",
							"0" => "No, do not allow.",
						)
					),
					'value' => '1',
				),
				array(
					'Text',
					'limit_data',
					array(
						'label' => 'Count (number of job posters to show).',
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
    'title' => 'SES - Advanced Job - Job Profile - Advanced Share Widget',
    'description' => 'This widget allow users to share the current job on your website and on other social networking websites. The recommended page for this widget is "SES - Advanced Job - Job Profile Page".',
    'category' => 'SES - Advanced Job',
    'type' => 'widget',
    'name' => 'sesjob.advance-share',
    'autoEdit' => true,
    'adminForm' => 'Sesjob_Form_Admin_Share',
  ),
  array(
    'title' => 'SES Advanced Jobs - Job of the Day',
    'description' => "This widget displays jobs of the day as chosen by you from the Edit Settings of this widget.",
    'category' => 'SES - Advanced Job',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesjob.of-the-day',
    'adminForm' => array(
	'elements' => array(
	 array(
		'MultiCheckbox',
		'show_criteria',
		array(
		    'label' => "Choose from below the details that you want to show for jobs in this widget.",
				'multiOptions' => array(
					'title' => 'Job Title',
                    'companyname'=>'Company Name',
                    'industry' => "Company Industry",
					'like' => 'Likes Count',
					'view' => 'Views Count',
					'comment' => 'Comment Count',
					'favourite' => 'Favourites Count',
					'by' => 'Owner\'s Name',
					'favouriteButton' => 'Favourite Button',
					'likeButton' => 'Like Button',
					'featuredLabel' => 'Featured Label',
					'sponsoredLabel' => "Sponsored Label",
					"hotLabel" => "Hot Label",
					'verifiedLabel' => 'Verified Label',
					'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
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
		    'label' => 'Job title truncation limit.',
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
	    'label' => 'Job description truncation limit.',
	    'value' => 60,
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
		    'label' => 'Enter the height of block (in pixels).',
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
		    'label' => 'Enter the width of block (in pixels).',
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
    'title' => 'SES - Advanced Job - Popular / Featured / Sponsored / Verified Jobs',
    'description' => "Displays jobs as chosen by you based on chosen criteria for this widget. The placement of this widget depends on the criteria chosen for this widget.",
    'category' => 'SES - Advanced Job',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesjob.featured-sponsored',
    'adminForm' => array(
      'elements' => array(
	array(
	  'Select',
	  'viewType',
	  array(
	    'label' => 'Choose the view type.',
	    'multiOptions' => array(
	      "list" => "List",
	      "grid1" => "Grid View",
	    )
	  ),
	  'value' => 'list'
	),
	$imageType,
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
	      '6' => 'Only Verified',
	      '7' => 'Only Hot',
	      '4' => 'All except Featured and Sponsored',
	    ),
	    'value' => 5,
	  )
	),
	array(
		'Select',
		'order',
		array(
			'label' => 'Duration criteria for the jobs to be shown in this widget',
			'multiOptions' => array(
				'' => 'All Jobs',
				'week' => 'This Week Jobs',
				'month' => 'This Month Jobs',
			),
			'value' => '',
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
	    'label' => "Choose from below the details that you want to show for job in this widget.",
	    'multiOptions' => array(
            'featuredLabel' => 'Featured Label',
            'sponsoredLabel' => 'Sponsored Label',
            'verifiedLabel' => 'Verified Label',
            'hotLabel' => 'Hot Label',
            'like' => 'Likes Count',
            'comment' => 'Comments Count',
            'favourite' => 'Favourites Count',
            'view' => 'Views Count',
            'title' => 'Job Title',
            'companyname'=>'Company Name',
            'industry' => "Company Industry",
            'by' => 'Job Owner\'s Name',
            'creationDate' => 'Show Publish Date',
            'category' => 'Category',
            'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a> for Grid view only',
            'likeButton' => 'Like Button for Grid view only',
            'favouriteButton' => 'Favourite Button for Grid view only',
	    ),
	    'escape' => false,
	  )
	),
	$socialshare_enable_plusicon,
	$socialshare_icon_limit,
  array(
	'Select',
	'showLimitData',
	array(
		'label' => 'Do you want to allow users to view more job posters in this widget? (If you choose Yes, then users will see Next & Previous buttons to view more job posters.)',
		'multiOptions' => array(
			"1" => "Yes, allow.",
			"0" => "No, do not allow.",
		)
	),
	'value' => '1',
),
	array(
	  'Text',
	  'title_truncation',
	  array(
	    'label' => 'Job title truncation limit.',
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
	    'label' => 'Job description truncation limit.',
	    'value' => 60,
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
	    'label' => 'Count (number of jobs to show).',
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
    'title' => 'SES - Advanced Job - Category Carousel',
    'description' => 'Displays categories in attractive carousel in this widget. The placement of this widget depends on the criteria chosen for this widget.',
    'category' => 'SES - Advanced Job',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesjob.category-carousel',
    'adminForm' => array(
      'elements' => array(
	array(
	  'Text',
	  'title_truncation_grid',
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
	  'description_truncation_grid',
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
	    'label' => 'Enter the height of one category block (in pixels).',
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
	    'label' => 'Enter the width of one category block (in pixels).',
	    'value' => '180',
	    'validators' => array(
	      array('Int', true),
	      array('GreaterThan', true, array(0)),
	    )
	  )
	),
	array(
	  'Select',
	  'autoplay',
	  array(
	    'label' => "Do you want to enable auto play of categories?",
	    'multiOptions' => array(
	      1=>'Yes',
	      0=>'No'
	    ),
	  ),
	),
	array(
	  'Text',
	  'speed',
	    array(
	    'label' => 'Delay time for next category when you have enabled autoplay',
	    'value' => '2000',
	    'validators' => array(
	      array('Int', true),
	      array('GreaterThan', true, array(0)),
	    )
	  )
	),
	array(
	  'Select',
	  'criteria',
	  array(
	    'label' => "Choose Popularity Criteria.",
	    'multiOptions' => array(
	      'alphabetical' => 'Alphabetical order',
	      'most_job' => 'Categories with maximum jobs first',
	      'admin_order' => 'Admin selected order for categories',
	    ),
	  ),
	),
	array(
	  'MultiCheckbox',
	  'show_criteria',
	  array(
	    'label' => "Choose from below the details that you want to show on each block.",
	    'multiOptions' => array(
	      'title' => 'Category title',
	      'description' => 'Category description',
	      'countJobs' => 'Job count in each category',
	      'socialshare' =>'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
	    ),
	    'escape' => false,
	  )
	),
	$socialshare_enable_plusicon,
	$socialshare_icon_limit,
	array(
	  'Select',
	  'isfullwidth',
	  array(
	    'label' => 'Do you want to show category carousel in full width?',
	    'multiOptions'=>array(
	      1=>'Yes',
	      0=>'No'
	    ),
	    'value' => 1,
	  )
	),
	array(
	  'Text',
	  'limit_data',
	  array(
	    'label' => 'Count (number of categories to show in this widget).',
	    'value' => 10,
	  )
	),
      )
    ),
  ),
  array(
    'title' => 'SES Advanced Jobs - Categories Icon View',
    'description' => 'Displays all categories of jobs in icon view with their icon. Edit this widget to configure various settings.',
    'category' => 'SES - Advanced Job',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesjob.job-category-icons',
    'adminForm' => array(
      'elements' => array(
	array(
	  'Text',
	  'titleC',
	  array(
	    'label' => 'Enter the title for this widget.',
	    'value' => 'Browse by Popular Categories',
	  )
	),
	array(
	  'Text',
	  'height',
	  array(
	    'label' => 'Enter the height of one block (in pixels).',
	    'value' => '160px',
	  )
	),
	array(
	'Text',
	'width',
	  array(
	    'label' => 'Enter the width of one block (in pixels).',
	    'value' => '160px',
	  )
	),
	array(
	  'Select',
	  'alignContent',
	  array(
	    'label' => "Where you want to show content of this widget?",
	    'multiOptions' => array(
	      'center' => 'In Center',
	      'left' => 'In Left',
	      'right' => 'In Right',
	    ),
	    'value' => 'center',
	  ),
	),
	array(
	  'Select',
	  'criteria',
	  array(
	    'label' => "Choose Popularity Criteria.",
	    'multiOptions' => array(
	      'alphabetical' => 'Alphabetical order',
	      'most_job' => 'Categories with maximum jobs first',
	      'admin_order' => 'Admin selected order for categories',
	    ),
	  ),
	),
	array(
	  'MultiCheckbox',
	  'show_criteria',
	  array(
	    'label' => "Choose from below the details that you want to show on each block.",
	    'multiOptions' => array(
	      'title' => 'Category title',
	      'countJobs' => 'Job count in each category',
	    ),
	  )
	),
	array(
	  'Text',
	  'limit_data',
	  array(
	    'label' => 'Count (number of categories to show.)',
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
    'title' => 'SES - Advanced Job - Alphabetic Filtering of Jobs',
    'description' => "This widget displays all the alphabets for alphabetic filtering of jobs which will enable users to filter jobs on the basis of selected alphabet.",
    'category' => 'SES - Advanced Job',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesjob.alphabet-search',
  ),
  array(
    'title' => 'SES - Advanced Job - Compnay Profile - Breadcrumb',
    'description' => 'Displays breadcrumb for Company. This widget should be placed on the Advanced Job - Compant Profile page of the selected content type.',
    'category' => 'SES - Advanced Job',
    'type' => 'widget',
    'name' => 'sesjob.company-breadcrumb',
  ),
  array(
    'title' => 'SES - Advanced Job - Job Profile - Breadcrumb',
    'description' => 'Displays breadcrumb for Job. This widget should be placed on the Advanced Job - View page of the selected content type.',
    'category' => 'SES - Advanced Job',
    'type' => 'widget',
    'name' => 'sesjob.breadcrumb',
  ),
 array(
    'title' => 'SES - Advanced Job - Job Profile - Labels',
    'description' => 'This widget displays Featured, Sponsored and Verified labels on Job Profile Page. The recommended page for this widget is "SES - Advanced Job - Job Profile Page".',
    'category' => 'SES - Advanced Job',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesjob.labels',
  ),

  array(
    'title' => 'SES - Advanced Job - Job Sidebar Tabbed Widget',
    'description' => 'Displays a tabbed widget for jobs. You can place this widget anywhere on your site.',
    'category' => 'SES - Advanced Job',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesjob.sidebar-tabbed-widget',
    'requirements' => array(
      'subject' => 'job',
    ),
    'adminForm' => 'Sesjob_Form_Admin_SidebarTabbed',
  ),
  array(
    'title' => 'SES - Advanced Job - Company Profile - Information',
    'description' => 'Displays company content. The recommended page for this widget is "SES - Advanced Job - Company Profile Page".',
    'category' => 'SES - Advanced Job',
    'type' => 'widget',
    'name' => 'sesjob.company-view',
   ),
  array(
    'title' => 'SES - Advanced Job - Job Profile - Content',
    'description' => 'Displays job content according to the design choosen by the job poster while creating or editing the job. The recommended page for this widget is "SES - Advanced Job - Job Profile Page".',
    'category' => 'SES - Advanced Job',
    'type' => 'widget',
    'name' => 'sesjob.view-job',
		'adminForm' => array(
			'elements' => array(
				array(
					'MultiCheckbox',
					'show_criteria',
					array(
						'label' => "Choose from below the details that you want to show in this widget.",
						'multiOptions' => array(
							'title' => 'Title',
							'companydetails' => "Company Details",
							'description' => 'Show Description',
							'socialShare' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
							'ownerOptions' => 'Owner Options',
							'postComment' => 'Comment Button',
							'likeButton' => 'Like Button',
                            'shareButton' => 'Large Share Button',
                            'smallShareButton' => 'Small Share Button',
							'favouriteButton' => 'Favourite Button',
							'view' => 'View Count',
							'like' => 'Like Count',
							'comment' => 'Comment Count',
							'statics' => 'Show Statstics'
						),
                        'value' => array('title', 'description', 'photo', 'socialShare', 'ownerOptions', 'rating', 'postComment', 'likeButton', 'favouriteButton', 'view', 'like', 'comment', 'statics','shareButton','smallShareButton'),
						'escape' => false,
					)
				),
				$socialshare_enable_plusicon,
				$socialshare_icon_limit,
			),
		),
  ),
    array(
		'title' => 'SES - Advanced Job - Category Banner Widget',
		'description' => 'Displays a banner for categories. You can place this widget at browse page of category on your site.',
		'category' => 'SES - Advanced Job',
		'type' => 'widget',
		'autoEdit' => true,
		'name' => 'sesjob.banner-category',
		'requirements' => array(
				'subject' => 'job',
		),
		'adminForm' => 'Sesjob_Form_Admin_Categorywidget',
	),
	array(
		'title' => 'SES - Advanced Job - Calendar Widget',
		'description' => 'Displays calendar . You can place this widget at browse page of job on your site.',
		'category' => 'SES - Advanced Job',
		'type' => 'widget',
		'autoEdit' => false,
		'name' => 'sesjob.calendar'
	),
	    array(
        'title' => 'SES - Advanced Job - Categories Square Block View',
        'description' => 'Displays all categories of jobs in square blocks. Edit this widget to configure various settings.',
        'category' => 'SES - Advanced Job',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesjob.job-category',
        'requirements' => array(
            'subject' => 'job',
        ),
        'adminForm' => array(
            'elements' => array(
                array(
                    'Text',
                    'height',
                    array(
                        'label' => 'Enter the height of one block (in pixels).',
                        'value' => '160px',
                    )
                ),
                array(
                    'Text',
                    'width',
                    array(
                        'label' => 'Enter the width of one block (in pixels).',
                        'value' => '160px',
                    )
                ),
								 array(
                    'Text',
                    'limit',
                    array(
                        'label' => 'count (number of categories to show).',
                        'value' => '10',
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
								array(
                    'Select',
                    'job_required',
                    array(
                        'label' => "Do you want to show only those categories under which atleast 1 job is posted?",
                        'multiOptions' => array(
                            '1' => 'Yes, show only categories with jobs',
                            '0' => 'No, show all categories',
                        ),
                    ),
										'value' =>'1'
                ),
                array(
                    'Select',
                    'criteria',
                    array(
                        'label' => "Choose Popularity Criteria.",
                        'multiOptions' => array(
                            'alphabetical' => 'Alphabetical Order',
                            'most_job' => 'Most Jobs Category First',
                            'admin_order' => 'Admin Order',
                        ),
                    ),
                ),
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show on each block.",
                        'multiOptions' => array(
                            'title' => 'Category Title',
                            'icon' => 'Category Icon',
                            'countJobs' => 'Job count in each category',
                        ),
                    )
                ),
            ),
        ),
    ),
        array(
        'title' => 'SES - Advanced Job - Category Based Jobs Block View',
        'description' => 'Displays jobs in attractive square block view on the basis of their categories. This widget can be placed any where on your website.',
        'category' => 'SES - Advanced Job',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesjob.category-associate-job',
        'requirements' => array(
            'subject' => 'job',
        ),
        'adminForm' => array(
            'elements' => array(
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show for jobs in this widget.",
                        'multiOptions' => array(
                            'like' => 'Likes Count',
                            'comment' => 'Comments Count',
                            'view' => 'Views Count',
                            'title' => 'Title',
                            'favourite' => 'Favourites Count',
                            'by' => 'Job Owner\'s Name',
                            'featuredLabel' => 'Featured Label',
                            'sponsoredLabel' => 'Sponsored Label',
                            'hotLabel' => 'Hot Label',
                            'creationDate' => 'Show Publish Date',
                            'readmore' => 'Read More',
                        ),
                    )
                ),
                array(
                    'Radio',
                    'popularity_job',
                    array(
                        'label' => 'Choose Job Display Criteria.',
                        'multiOptions' => array(
                            "creation_date" => "Recently Created",
                            "view_count" => "Most Viewed",
                            "like_count" => "Most Liked",
                            "comment_count" => "Most Commented",
                            "favourite_count" => "Most Favourite",
                            'featured' => 'Only Featured',
                            'sponsored' => 'Only Sponsored',
                            'hot' => 'Only Hot',
                        ),
                        'value' => 'like_count',
                    )
                ),
                $pagging,
                array(
                    'Select',
                    'criteria',
                    array(
                        'label' => "Choose Popularity Criteria.",
                        'multiOptions' => array(
                            'alphabetical' => 'Alphabetical Order',
                            'most_job' => 'Categories with maximum jobs first',
                            'admin_order' => 'Admin selected order for categories',
                        ),
                    ),
                ),
                array(
                    'Text',
                    'category_limit',
                    array(
                        'label' => 'count (number of categories to show).',
                        'value' => '10',
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                array(
                    'Text',
                    'job_limit',
                    array(
                        'label' => 'count (number of jobs to show in each category.").',
                        'value' => '8',
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                array(
                    'Text',
                    'seemore_text',
                    array(
                        'label' => 'Enter the text for "+ See All" link. Leave blank if you don\'t want to show this link. (Use[category_name] variable to show the associated category name).',
                        'value' => '+ See all [category_name]',
                    )
                ),
                array(
                    'Select',
                    'allignment_seeall',
                    array(
                        'label' => "Choose alignment of \"+ See All\" field",
                        'multiOptions' => array(
                            'left' => 'left',
                            'right' => 'right'
                        ),
                    ),
                ),
            )
        ),
    ),
        array(
        'title' => 'SES - Advanced Job - Category View Page Widget',
        'description' => 'Displays a view page for categories. You can place this widget at view page of category on your site.',
        'category' => 'SES - Advanced Job',
        'type' => 'widget',
        'name' => 'sesjob.category-view',
        'requirements' => array(
            'subject' => 'job',
        ),
        'adminForm' => array(
            'elements' => array(
								array(
									'Select',
									'viewType',
									array(
										'label' => 'Choose the view type.',
										'multiOptions' => array(
											"list" => "List View",
											"grid" => "Grid View",
										)
									),
									'value' => 'list'
								),
                array(
                    'Select',
                    'show_subcat',
                    array(
                        'label' => "Show 2nd-level or 3rd level categories blocks.",
                        'multiOptions' => array(
                            '1' => 'Yes',
                            '0' => 'No'
                        ),
                    ),
                ),
                array(
                    'MultiCheckbox',
                    'show_subcatcriteria',
                    array(
                        'label' => "Choose from below the details that you want to show on each categpory block.",
                        'multiOptions' => array(
                            'icon' => 'Category Icon',
                            'title' => 'Category Title',
                            'countJob' => 'Jobs count in each category',
                        ),
                    )
                ),
                array(
                    'Text',
                    'heightSubcat',
                    array(
                        'label' => 'Enter the height of one 2nd-level or 3rd level categor\'s block (in pixels).
',
                        'value' => '160px',
                    )
                ),
                array(
                    'Text',
                    'widthSubcat',
                    array(
                        'label' => 'Enter the width of one 2nd-level or 3rd level categor\'s block (in pixels).
',
                        'value' => '250px',
                    )
                ),
								 array(
                    'Text',
                    'textJob',
                    array(
                        'label' => 'Enter teh text for \'heading\' of this widget.',
                        'value' => 'Jobs we like',
                    )
                ),
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show on each album block.",
                        'multiOptions' => array(
                            'featuredLabel' => 'Featured Label',
                            'sponsoredLabel' => 'Sponsored Label',
                            'hotLabel' => 'Hot Label',
                            'like' => 'Likes',
                            'comment' => 'Comments',
                            'favourite'=>'Favourite',
                            'view' => 'Views',
                            'title' => 'Titles',
                            'companyname'=>'Company Name',
                            'industry' => "Company Industry",
                            'by' => 'Item Owner Name',
                            'description' => 'Show Description',
                            'readmore' => 'Show Read More',
                            'creationDate' => 'Show Publish Date',
                        ),
                    )
                ),
                $pagging,
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
                    'job_limit',
                    array(
                        'label' => 'count (number of jobs to show).',
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
                        'label' => 'Enter the height of one block (in pixels. This setting will effect after 3 designer blocks).',
                        'value' => '160px',
                    )
                ),
                array(
                    'Text',
                    'width',
                    array(
                        'label' => 'Enter the width of one block (in pixels. This setting will effect after 3 designer blocks).',
                        'value' => '160px',
                    )
                )
            )
        ),
    ),
    array(
        'title' => 'SES - Advanced Job - Job Profile - Job tags',
        'description' => 'Displays all job tags on your website. The recommended page for this widget is "SES - Advanced Job - Browse Tags Page".',
        'category' => 'SES - Advanced Job',
        'type' => 'widget',
        'name' => 'sesjob.tag-jobs',
    ),
    array(
		'title' => 'SES - Advanced Job - Popular / Featured / Sponsored / Verified 3 Jobs View',
		'description' => 'SES - Advanced Job - Popular / Featured / Sponsored / Verified 3 Jobs View : Displays Popular / Featured / Sponsored / Verified jobs in 3 Block view. You can place this widget at any page of this plugin.',
		'category' => 'SES - Advanced Job',
		'type' => 'widget',
		'autoEdit' => true,
		'name' => 'sesjob.featured-sponsored-verified-random-job',
		   'adminForm' => array(
      'elements' => array(
      	array(
	  'Select',
	  'category',
	  array(
	    'label' => 'Choose the category.',
	    'multiOptions' => $categories
	  ),
	  'value' => ''
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
	      '6' => 'Only Verified',
	      '7' => 'Only Hot',
	      '4' => 'All except Featured and Sponsored',
	    ),
	    'value' => 5,
	  )
	),
		array(
		'Select',
		'order',
		array(
			'label' => 'Duration criteria for the jobs to be shown in this widget.',
			'multiOptions' => array(
				'' => 'All',
				'week' => 'This Week',
				'month' => 'This Month',
			),
			'value' => '',
		)
	),
		array(
	  'MultiCheckbox',
	  'show_criteria',
	  array(
	    'label' => "Choose from below the details that you want to show for job in this widget.",
	    'multiOptions' => array(
	      'like' => 'Likes Count',
	      'comment' => 'Comments Count',
	      'favourite' => 'Favourites Count',
	      'view' => 'Views Count',
	      'title' => 'Job Title',
        'companyname'=>'Company Name',
        'industry' => "Company Industry",
	      'by' => 'Job Owner\'s Name',
		'featuredLabel' => 'Featured Label',
		'sponsoredLabel' => 'Sponsored Label',
		'hotLabel' => 'Hot Label',
		'verifiedLabel' => 'Verified Label',
		'favouriteButton' => 'Favourite Button',
		'likeButton' => 'Like Button',
		'category' => 'Category',
		'socialSharing' =>'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
		'likeButton' => 'Like Button',
		'favouriteButton' => 'Favourite Button',
		'creationDate' => 'Show Publish Date',
	    ),
	    'escape' => false,
	  )
	),
	        $socialshare_enable_plusicon,
        $socialshare_icon_limit,
      ),
    ),

	),

      array(
        'title' => 'SES - Advanced Job - Job Locations',
        'description' => 'This widget displays jobs based on their locations in Google Map.',
        'category' => 'SES - Advanced Job',
        'type' => 'widget',
        'name' => 'sesjob.job-location',
				'autoEdit' => true,
    		'adminForm' => 'Sesjob_Form_Admin_Location',
    ),

    	array(
    'title' => 'SES - Advanced Job - Popular / Featured / Sponsored / Verified Jobs Slideshow',
    'description' => "Displays slideshow of jobs as chosen by you based on chosen criteria for this widget. You can also choose to show Jobs of specific categories in this widget. The placement of this widget depends on the criteria chosen for this widget.",
    'category' => 'SES - Advanced Job',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesjob.featured-sponsored-verified-category-slideshow',
    'adminForm' => array(
      'elements' => array(
	array(
	  'Select',
	  'category',
	  array(
	    'label' => 'Choose the category.',
	    'multiOptions' => $categories
	  ),
	  'value' => ''
	),

	array(
	  'Select',
	  'criteria',
	  array(
	    'label' => "Display Content",
	    'multiOptions' => array(
          '0' => 'All Jobs',
	      '1' => 'Only Featured',
	      '2' => 'Only Sponsored',
	      '6' => 'Only Verified',
	      '7' => 'Only Hot',
	    ),
	    'value' => 5,
	  )
	),
	array(
		'Select',
		'order',
		array(
			'label' => 'Duration criteria for the jobs to be shown in this widget.',
			'multiOptions' => array(
				'' => 'All',
				'week' => 'This Week',
				'month' => 'This Month',
			),
			'value' => '',
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
	      "most_commented" => "Most Commented",
	      "most_favourite" => "Most Favourite",
	    )
	  ),
	  'value' => 'recently_created',
	),
	array(
	  'Select',
	  'isfullwidth',
	  array(
	    'label' => 'Do you want to show category carousel in full width?',
	    'multiOptions'=>array(
	      1=>'Yes',
	      0=>'No'
	    ),
	    'value' => 1,
	  )
	),
		array(
	  'Select',
	  'autoplay',
	  array(
	    'label' => "Do you want to enable autoplay of jobs?",
	    'multiOptions' => array(
	      1=>'Yes',
	      0=>'No'
	    ),
	  ),
	),
	array(
	  'Text',
	  'speed',
	    array(
	    'label' => 'Delay time for next job when you have enabled autoplay.',
	    'value' => '2000',
	    'validators' => array(
	      array('Int', true),
	      array('GreaterThan', true, array(0)),
	    )
	  )
	),
	array(
	  'Select',
	  'type',
	  array(
	    'label' => "Choose the affect while slide changes.",
	    'multiOptions' => array(
	      'slide'=>'Slide',
	      'fade'=>'Fade'
	    ),
	  ),
	),
	array(
	  'Select',
	  'navigation',
	  array(
	    'label' => "Do you want to show buttons or circles to navigate to next slide.",
	    'multiOptions' => array(
	      'nextprev'=>'Show buttons',
	      'buttons'=>'Show circle'
	    ),
	  ),
	),
	array(
	  'MultiCheckbox',
	  'show_criteria',
	  array(
	    'label' => "Choose from below the details that you want to show for jobs in this widget.",
	    'multiOptions' => array(
	      'like' => 'Likes Count',
	      'comment' => 'Comments Count',
	      'favourite' => 'Favourites Count',
	      'view' => 'Views Count',
	      'title' => 'Job Title',
        'companyname'=>'Company Name',
        'industry' => "Company Industry",
	      'by' => 'Job Owner\'s Name',
				 'featuredLabel' => 'Featured Label',
				'sponsoredLabel' => 'Sponsored Label',
				'hotLabel' => 'Hot Label',
				'verifiedLabel' => 'Verified Label',
				'favouriteButton' => 'Favourite Button',
				'likeButton' => 'Like Button',
	      'category' => 'Category',
	      'socialSharing' =>'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
	      'likeButton' => 'Like Button',
	      'favouriteButton' => 'Favourite Button',
	      'creationDate' => 'Show Publish Date',
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
	    'label' => 'Job title truncation limit.',
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
	    'label' => 'Enter the height of one slide block (in pixels).',
	    'value' => '400',
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
	    'label' => 'Count (number of jobs to show).',
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
    'title' => 'SES - Advanced Job - Job Profile - Job Social Share Widget',
    'description' => 'Displays a job social share widget. You can place this widget on job profile page only on your site.',
    'category' => 'SES - Advanced Job',
    'type' => 'widget',
    'name' => 'sesjob.job-socialshare',
    'adminForm' => array(
			'elements' => array(
				array(
					'Radio',
					'socialshare_design',
					array(
						'label' => "Do you want this social share widget on job profile page ?",
						'multiOptions' => array(
							'1' => 'Social Share Design 1',
							'2' => 'Social Share Design 2',
							'3' => 'Social Share Design 3',
							'4' => 'Social Share Design 4',
						),
						'value' => 'design1',
					)
				),
			),
		),
    'requirements' => array(
      'subject' => 'job',
    ),
  ),
      array(
        'title' => 'SES - Advanced Job - Job Profile - Map',
        'description' => 'Displays a job location on map on it\'s profile.',
        'category' => 'SES - Advanced Job',
        'type' => 'widget',
        'name' => 'sesjob.job-map',
        'defaultParams' => array(
            'title' => 'Map',
            'titleCount' => true,
        ),
        'requirements' => array(
            'subject' => 'user',
        ),
    ),
  		array(
        'title' => 'SES - Advanced Job - Job Profile - Job Contact Information',
        'description' => 'Displays job contact information in this widget. The placement of this widget depends on the job profile page.',
        'category' => 'SES - Advanced Job',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesjob.job-contact-information',
        'adminForm' => array(
            'elements' => array(
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show in this widget.",
                        'multiOptions' => array(
                            'name' => 'Contact Name',
														'email' => 'Contact Eamail',
                            'phone' => 'Contact Phone Number',
														'facebook' =>'Contact Facebook',
														'linkedin'=>'Contact Linkedin',
														'twitter'=>'Contact Twitter',
														'website'=>'Contact Website',
                        ),
                    )
                ),
            )
        ),
		),
		    array(
        'title' => 'SES - Advanced Job - Job Profile Like Button',
        'description' => 'Displays like button for job. This widget is only placed on "Job Profile Page" only.',
        'category' => 'SES - Advanced Job',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesjob.like-button',
        'defaultParams' => array(
            'title' => '',
        ),
    ),

    		    array(
        'title' => 'SES - Advanced Job - Job Profile Favourite Button',
        'description' => 'Displays favourite button for job. This widget is only placed on "Job Profile Page" only.',
        'category' => 'SES - Advanced Job',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesjob.favourite-button',
        'defaultParams' => array(
            'title' => '',
        ),
    ),

  array(
    'title' => 'SES Advanced Jobs - Double Job Slideshow',
    'description' => 'This widget displays 2 types of jobs. The one section of this widget will be slideshow and the other will show 3 jobs based on the criterion chosen in this widget.',
    'category' => 'SES - Advanced Job',
    'type' => 'widget',
    'name' => 'sesjob.jobs-slideshow',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Select',
          'criteria',
          array(
            'label' => "Content for 3 jobs display in left side.",
            'multiOptions' => array(
              '5' => 'All including Featured and Sponsored',
              '1' => 'Only Featured',
              '2' => 'Only Sponsored',
              '3' => 'Both Featured and Sponsored',
              '6' => 'Only Verified',
              '7' => 'Only Hot',
              '4' => 'All except Featured and Sponsored',
            ),
            'value' => 5,
          )
        ),
        array(
            'Text',
            'height',
            array(
                'label' => 'Enter the height of this widget.',
                'value' => '160',
            )
        ),
        array(
          'Select',
          'leftJob',
          array(
            'label' => "Do you want to enable the 3 Jobs in left side?",
            'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
            ),
            'value' => 1,
          )
        ),
        array(
          'Select',
          'enableSlideshow',
          array(
            'label' => "Do you want to enable the slideshow in right side?",
            'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
            ),
            'value' => 1,
          )
        ),
        array(
          'Select',
          'order',
          array(
            'label' => 'Duration criteria for the 3 jobs to be shown in this widget in left side.',
            'multiOptions' => array(
              '' => 'All Jobs',
              'week' => 'This Week Jobs',
              'month' => 'This Month Jobs',
            ),
            'value' => '',
          )
        ),
        array(
          'Select',
          'info',
          array(
            'label' => 'Choose popularity criteria for the 3 jobs to be displayed in left side.',
            'multiOptions' => array(
              "recently_created" => "Recently Created",
              "most_viewed" => "Most Viewed",
              "most_liked" => "Most Liked",
              "most_commented" => "Most Commented",
              "most_favourite" => "Most Favourite",
            )
          ),
          'value' => 'recently_created',
        ),


        array(
          'Select',
          'criteria_right',
          array(
            'label' => "Content for slideshow in right side",
            'multiOptions' => array(
              '5' => 'All including Featured and Sponsored',
              '1' => 'Only Featured',
              '2' => 'Only Sponsored',
              '3' => 'Both Featured and Sponsored',
              '6' => 'Only Verified',
              '7' => 'Only Hot',
              '4' => 'All except Featured and Sponsored',
            ),
            'value' => 5,
          )
        ),
        array(
          'Select',
          'order_right',
          array(
            'label' => 'Duration criteria for the jobs to be shown in the slideshow of this widget in right side',
            'multiOptions' => array(
              '' => 'All Jobs',
              'week' => 'This Week Jobs',
              'month' => 'This Month Jobs',
            ),
            'value' => '',
          )
        ),
        array(
          'Select',
          'info_right',
          array(
            'label' => 'Choose popularity criteria for the jobs to be displayed in the slideshow in right side.',
            'multiOptions' => array(
              "recently_created" => "Recently Created",
              "most_viewed" => "Most Viewed",
              "most_liked" => "Most Liked",
              "most_commented" => "Most Commented",
              "most_favourite" => "Most Favourite",
            )
          ),
          'value' => 'recently_created',
        ),
        array(
          'Select',
          'autoplay',
          array(
            'label' => "Do you want to enable the autoplay of jobs slideshow?",
            'multiOptions' => array(
              1=>'Yes',
              0=>'No'
            ),
          ),
        ),
        array(
          'Text',
          'speed',
            array(
            'label' => 'Enter the delay time for the next job to be displayed in slideshow. (work if autoplay is enabled.)',
            'value' => '2000',
            'validators' => array(
              array('Int', true),
              array('GreaterThan', true, array(0)),
            )
          )
        ),
        array(
          'MultiCheckbox',
          'show_criteria',
          array(
            'label' => "Choose from below the details that you want to show for jobs in this widget.",
            'multiOptions' => array(
              'like' => 'Likes Count',
              'comment' => 'Comments Count',
              'favourite' => 'Favourites Count',
              'view' => 'Views Count',
              'title' => 'Job Title',
              'by' => 'Job Owner\'s Name',
              'favouriteButton' => 'Favourite Button',
              'likeButton' => 'Like Button',
              'category' => 'Category',
              'socialSharing' =>'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
              'likeButton' => 'Like Button',
              'favouriteButton' => 'Favourite Button',
              'creationDate' => 'Show Publish Date',
              'description' => "Description (This will only show in the slideshow.)"
            ),
            'escape' => false,
          )
        ),
        $socialshare_enable_plusicon,
        $socialshare_icon_limit,
        array(
          'Text',
          'limit_data',
          array(
            'label' => 'Count for the jobs to be displayed in slideshow.',
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
);
