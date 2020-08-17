<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesarticle
 * @package    Sesarticle
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: content.php 2016-07-23 00:00:00 SocialEngineSolutions $
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

$headScript = new Zend_View_Helper_HeadScript();
$headScript->appendFile(Zend_Registry::get('StaticBaseUrl') . 'application/modules/Sesbasic/externals/scripts/jscolor/jscolor.js');
$headScript->appendFile(Zend_Registry::get('StaticBaseUrl') . 'application/modules/Sesbasic/externals/scripts/jquery.min.js');

$categories = array();
if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.pluginactivated')) {
  $categories = Engine_Api::_()->getDbtable('categories', 'sesarticle')->getCategoriesAssoc(array('module'=>true));
}

$viewType = array(
  'MultiCheckbox',
  'enableTabs',
  array(
      'label' => "Choose the View Type.",
      'multiOptions' => array(
      'list' => 'List View 1',
			'simplelist' => 'List View 2',
      'advlist' => 'List View 3',
			'advlist2' => 'List View 4',
      'grid' => 'Grid View 1',
      'advgrid' => 'Grid View 2',
      'supergrid' => 'Grid View 3',
      'grid2' => 'Grid View 4',
      'pinboard' => 'Pinboard View',
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
			'list' => 'List View 1',
			'simplelist' => 'List View 2',
      'advlist' => 'List View 3',
			'advlist2' => 'List View 4',
      'grid' => 'Grid View 1',
      'advgrid' => 'Grid View 2',
      'supergrid' => 'Grid View 3',
      'grid2' => 'Grid View 4',
      'pinboard' => 'Pinboard View',
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
      'favouriteButton' => 'Favourite Button',
      'likeButton' => 'Like Button',
      'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
      'like' => 'Likes Count',
      'favourite' => 'Favorites Count',
      'comment' => 'Comments Count',
      'ratingStar' => 'Ratings Star',
      'rating' => 'Ratings Count',
      'view' => 'Views Count',
      'title' => 'Article Title',
      'category' => 'Category',
      'by' => 'Article Owner Name',
      'readmore' => 'Read More Button',
      'creationDate' => 'Creation Date',
      'location'=> 'Location',
      'descriptionlist' => 'Description (In List View)',
      'descriptiongrid' => 'Description (In Grid View)',
      'descriptionpinboard' => 'Description (In Pinboard View)',
			'descriptionsimplelist' => 'Description (In List View 2)',
			'descriptionadvlist' => 'Description (In List View 3)',
			'descriptionadvlist2' => 'Description (In List View 4)',
			'descriptionadvgrid' => 'Description (In Grid View 2)',
			'descriptionsupergrid' => 'Description (In Grid View 3)',
			'descriptiongrid2' => 'Description (In Grid View 4)',
      'enableCommentPinboard'=>'Enable commenting in Pinboard View',
    ),
    'escape' => false,
  )
);
$pagging = array(
  'Radio',
  'pagging',
  array(
    'label' => "Do you want the articles to be auto-loaded when users scroll down the page?",
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
$titleTruncationPinboard = array(
  'Text',
  'title_truncation_pinboard',
  array(
    'label' => 'Title truncation limit for Pinboard View.',
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
$DescriptionTruncationPinboard = array(
  'Text',
  'description_truncation_pinboard',
  array(
    'label' => 'Description truncation limit for Pinboard View.',
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
$widthOfContainerPinboard = array(
  'Text',
  'width_pinboard',
  array(
    'label' => 'Enter the width of one block in Pinboard View (in pixels).',
    'value' => '300',
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

return array(
  array(
    'title' => 'SES - Advanced Article - People Like Article',
    'description' => 'Placed on  a Article view page.',
    'category' => 'SES - Advanced Article',
    'type' => 'widget',
    'name' => 'sesarticle.people-like-item',
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
    'title' => 'SES - Advanced Article - Popular / Featured / Sponsored / Verified Articles Carousel',
    'description' => "Disaplys carousel of articles as configured by you based on chosen criteria for this widget. You can also choose to show Articles of specific categories in this widget.",
    'category' => 'SES - Advanced Article',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesarticle.featured-sponsored-verified-category-carousel',
    'adminForm' => array(
      'elements' => array(
			array(
	  'Select',
	  'carousel_type',
	  array(
	    'label' => 'Choose the view type. [In Slick View, first and last article will partially show in the carousel.]',
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
			'label' => 'Duration criteria for the articles to be shown in this widget',
			'multiOptions' => array(
				'' => 'All Articles',
				'week' => 'This Week Articles',
				'month' => 'This Month Articles',
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
	    'label' => "Do you want to enable autoplay of articles?",
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
	    'label' => 'Delay time for next article when you have enabled autoplay.',
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
	      'title' => 'Article Title',
	      'by' => 'Article Owner\'s Name',
				'rating' =>'Rating Count',
				'ratingStar' =>'Rating Stars',
				'featuredLabel' => 'Featured Label',
				'sponsoredLabel' => 'Sponsored Label',
				'verifiedLabel' => 'Verified Label',
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
	    'label' => 'Article title truncation limit.',
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
	    'label' => 'Count (number of articles to show).',
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
    'title' => 'SES - Advanced Article - Tabbed widget for Popular Articles',
    'description' => 'Displays a tabbed widget for popular articles on your website based on various popularity criterias. Edit this widget to choose tabs to be shown in this widget. This widget can be placed anywhere on your website.',
    'category' => 'SES - Advanced Article',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesarticle.tabbed-widget-article',
    'requirements' => array(
      'subject' => 'article',
    ),
    'adminForm' => 'Sesarticle_Form_Admin_Tabbed',
  ),
	array(
		'title' => 'SES - Advanced Article - Content Profile Articles',
		'description' => 'This widget enables you to allow users to create articles on different content on your website like Groups. Place this widget on the content profile page, for example SE Group to enable group owners to create articles in their Groups. You can choose the visibility of the articles created in a content to only that content or show in this plugin as well from the "Articles Created in Content Visibility" setting in Global setting of this plugin.',
		'category' => 'SES - Advanced Article',
		'type' => 'widget',
		'autoEdit' => true,
		'name' => 'sesarticle.other-modules-profile-sesarticles',
		'requirements' => array(
			'subject' => 'user',
		),
		'adminForm' => 'Sesarticle_Form_Admin_OtherModulesTabbed',
	),
	array(
		'title' => 'SES - Advanced Article - Profile Articles',
		'description' => 'Displays a member\'s article entries on their profiles. The recommended page for this widget is "Member Profile Page"',
		'category' => 'SES - Advanced Article',
		'type' => 'widget',
		'autoEdit' => true,
		'name' => 'sesarticle.profile-sesarticles',
		'requirements' => array(
			'subject' => 'user',
		),
		'adminForm' => 'Sesarticle_Form_Admin_Tabbed',
	),
  array(
    'title' => 'SES - Advanced Article - Browse Articles',
    'description' => 'Display all articles on your website. The recommended page for this widget is "SES - Advanced Article - Browse Articles Page".',
    'category' => 'SES - Advanced Article',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesarticle.browse-articles',
    'requirements' => array(
      'subject' => 'article',
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
                'label' => "Enable plus (+) icon for social share buttons in List View 1?",
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
            'label' => 'Enter the number of Social Share Buttons after which plus (+) icon will come in List View 1. Other social sharing icons will display on clicking this plus icon.',
            'value' => 2,
            'validators' => array(
                array('Int', true),
                array('GreaterThan', true, array(0)),
            ),
          ),
        ),

        array(
            'Select',
            'socialshare_enable_listview2plusicon',
            array(
                'label' => "Enable plus (+) icon for social share buttons in List View 2?",
                'multiOptions' => array(
                  '1' => 'Yes',
                  '0' => 'No',
                ),
            )
        ),
        array(
          'Text',
          'socialshare_icon_listview2limit',
          array(
            'label' => 'Enter the number of Social Share Buttons after which plus (+) icon will come in List View 2. Other social sharing icons will display on clicking this plus icon.',
            'value' => 2,
            'validators' => array(
                array('Int', true),
                array('GreaterThan', true, array(0)),
            ),
          ),
        ),

        array(
            'Select',
            'socialshare_enable_listview3plusicon',
            array(
                'label' => "Enable plus (+) icon for social share buttons in List View 3?",
                'multiOptions' => array(
                  '1' => 'Yes',
                  '0' => 'No',
                ),
            )
        ),
        array(
          'Text',
          'socialshare_icon_listview3limit',
          array(
            'label' => 'Enter the number of Social Share Buttons after which plus (+) icon will come in List View 3. Other social sharing icons will display on clicking this plus icon.',
            'value' => 2,
            'validators' => array(
                array('Int', true),
                array('GreaterThan', true, array(0)),
            ),
          ),
        ),

        array(
            'Select',
            'socialshare_enable_listview4plusicon',
            array(
                'label' => "Enable plus (+) icon for social share buttons in List View 4?",
                'multiOptions' => array(
                  '1' => 'Yes',
                  '0' => 'No',
                ),
            )
        ),
        array(
          'Text',
          'socialshare_icon_listview4limit',
          array(
            'label' => 'Enter the number of Social Share Buttons after which plus (+) icon will come in List View 4. Other social sharing icons will display on clicking this plus icon.',
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
                'label' => "Enable plus (+) icon for social share buttons in Grid View 1?",
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
            'label' => 'Enter the number of Social Share Buttons after which plus (+) icon will come in Grid View 1. Other social sharing icons will display on clicking this plus icon.',
            'value' => 2,
            'validators' => array(
                array('Int', true),
                array('GreaterThan', true, array(0)),
            ),
          ),
        ),

        array(
            'Select',
            'socialshare_enable_gridview2plusicon',
            array(
                'label' => "Enable plus (+) icon for social share buttons in Grid View 2?",
                'multiOptions' => array(
                  '1' => 'Yes',
                  '0' => 'No',
                ),
            )
        ),
        array(
          'Text',
          'socialshare_icon_gridview2limit',
          array(
            'label' => 'Enter the number of Social Share Buttons after which plus (+) icon will come in Grid View 2. Other social sharing icons will display on clicking this plus icon.',
            'value' => 2,
            'validators' => array(
                array('Int', true),
                array('GreaterThan', true, array(0)),
            ),
          ),
        ),

        array(
            'Select',
            'socialshare_enable_gridview3plusicon',
            array(
                'label' => "Enable plus (+) icon for social share buttons in Grid View 3?",
                'multiOptions' => array(
                  '1' => 'Yes',
                  '0' => 'No',
                ),
            )
        ),
        array(
          'Text',
          'socialshare_icon_gridview3limit',
          array(
            'label' => 'Enter the number of Social Share Buttons after which plus (+) icon will come in Grid View 3. Other social sharing icons will display on clicking this plus icon.',
            'value' => 2,
            'validators' => array(
                array('Int', true),
                array('GreaterThan', true, array(0)),
            ),
          ),
        ),

        array(
            'Select',
            'socialshare_enable_gridview4plusicon',
            array(
                'label' => "Enable plus (+) icon for social share buttons in Grid View 4?",
                'multiOptions' => array(
                  '1' => 'Yes',
                  '0' => 'No',
                ),
            )
        ),
        array(
          'Text',
          'socialshare_icon_gridview4limit',
          array(
            'label' => 'Enter the number of Social Share Buttons after which plus (+) icon will come in Grid View 4. Other social sharing icons will display on clicking this plus icon.',
            'value' => 2,
            'validators' => array(
                array('Int', true),
                array('GreaterThan', true, array(0)),
            ),
          ),
        ),

        array(
            'Select',
            'socialshare_enable_pinviewplusicon',
            array(
                'label' => "Enable plus (+) icon for social share buttons in Pinboard View?",
                'multiOptions' => array(
                  '1' => 'Yes',
                  '0' => 'No',
                ),
            )
        ),
        array(
          'Text',
          'socialshare_icon_pinviewlimit',
          array(
            'label' => 'Enter the number of Social Share Buttons after which plus (+) icon will come in Pinboard View. Other social sharing icons will display on clicking this plus icon.',
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
						'label' => 'Choose Article Display Criteria.',
						'multiOptions' => array(
						"recentlySPcreated" => "Recently Created",
						"mostSPviewed" => "Most Viewed",
						"mostSPliked" => "Most Liked",
						"mostSPated" => "Most Rated",
						"mostSPcommented" => "Most Commented",
						"mostSPfavourite" => "Most Favourite",
						'featured' => 'Only Featured',
						'sponsored' => 'Only Sponsored',
						'verified' => 'Only Verified'
						),
					),
						'value' => 'most_liked',
				),
				array(
					'Select',
					'show_item_count',
					array(
						'label' => 'Do you want to show articles count in this widget?',
						'multiOptions' => array(
							'1' => 'Yes',
							'0' => 'No',
						),
						'value' => '0',
					),
				),
				$titleTruncationList,
				$titleTruncationGrid,
				$titleTruncationPinboard,
				array('Text', "title_truncation_simplelist", array(
					'label' => 'Title truncation limit for List View 2.',
					'value' => 45,
					'validators' => array(
						array('Int', true),
						array('GreaterThan', true, array(0)),
						)
					)
				),
			array('Text', "title_truncation_advlist", array(
				'label' => 'Title truncation limit for List View 3.',
				'value' => 45,
				'validators' => array(
					array('Int', true),
					array('GreaterThan', true, array(0)),
				)
			)),
			array('Text', "title_truncation_advlist2", array(
				'label' => 'Title truncation limit for List View 4.',
				'value' => 45,
				'validators' => array(
					array('Int', true),
					array('GreaterThan', true, array(0)),
				)
			)),
				array('Text', "title_truncation_advgrid", array(
      'label' => 'Title truncation limit for Grid View 2.',
      'value' => 45,
      'validators' => array(
				array('Int', true),
				array('GreaterThan', true, array(0)),
      )
    )),
				array('Text', "title_truncation_supergrid", array(
      'label' => 'Title truncation limit for Grid View 3.',
      'value' => 45,
      'validators' => array(
				array('Int', true),
				array('GreaterThan', true, array(0)),
      )
    )),
		array('Text', "title_truncation_grid2", array(
      'label' => 'Title truncation limit for Grid View 4.',
      'value' => 45,
      'validators' => array(
				array('Int', true),
				array('GreaterThan', true, array(0)),
      )
    )),
				$DescriptionTruncationList,
				$DescriptionTruncationGrid,
				$DescriptionTruncationPinboard,
				array('Text', "description_truncation_simplelist", array(
      'label' => 'Description truncation limit for List View 2.',
      'value' => 45,
      'validators' => array(
				array('Int', true),
				array('GreaterThan', true, array(0)),
      )
    )),
				array('Text', "description_truncation_advlist", array(
      'label' => 'Description truncation limit for List View 3.',
      'value' => 45,
      'validators' => array(
				array('Int', true),
				array('GreaterThan', true, array(0)),
      )
    )),
		array('Text', "description_truncation_advlist2", array(
      'label' => 'Description truncation limit for List View 4.',
      'value' => 45,
      'validators' => array(
				array('Int', true),
				array('GreaterThan', true, array(0)),
      )
    )),
		array('Text', "description_truncation_advlist2", array(
      'label' => 'Description truncation limit for List View 4.',
      'value' => 45,
      'validators' => array(
				array('Int', true),
				array('GreaterThan', true, array(0)),
      )
    )),
				array('Text', "description_truncation_advgrid", array(
      'label' => 'Description truncation limit for Grid View 2.',
      'value' => 45,
      'validators' => array(
				array('Int', true),
				array('GreaterThan', true, array(0)),
      )
    )),
				array('Text', "description_truncation_supergrid", array(
      'label' => 'Description truncation limit for Grid View 3.',
      'value' => 45,
      'validators' => array(
				array('Int', true),
				array('GreaterThan', true, array(0)),
      )
    )),
		array('Text', "description_truncation_advgrid2", array(
      'label' => 'Description truncation limit for Grid View 4.',
      'value' => 45,
      'validators' => array(
				array('Int', true),
				array('GreaterThan', true, array(0)),
      )
    )),
				$heightOfContainerList,
				$widthOfContainerList,
				$heightOfContainerGrid,
				$widthOfContainerGrid,

				array('Text', "height_simplelist", array(
      'label' => 'Enter the height of main photo block in List View 2 (in pixels).',
      'value' => '230',
    )),
				array('Text', "width_simplelist", array(
      'label' => 'Enter the width of main photo block in List View 2 (in pixels).',
      'value' => '260',
    )),
				array('Text', "height_advgrid", array(
      'label' => 'Enter the height of main photo block in Grid View 2 (in pixels).',
      'value' => '230',
    )),
				array('Text', "width_advgrid", array(
      'label' => 'Enter the width of main photo block in Grid View 2 (in pixels).',
      'value' => '260',
    )),
				array('Text', "height_supergrid", array(
      'label' => 'Enter the height of main photo block in Grid View 3 (in pixels).',
      'value' => '230',
    )),
				array('Text', "width_supergrid", array(
      'label' => 'Enter the width of main photo block in Grid View 3 (in pixels).',
      'value' => '260',
    )),
		array('Text', "height_grid2", array(
      'label' => 'Enter the height of main photo block in Grid View 4 (in pixels).',
      'value' => '230',
    )),
				array('Text', "width_grid2", array(
      'label' => 'Enter the width of main photo block in Grid View 4 (in pixels).',
      'value' => '260',
    )),



				$widthOfContainerPinboard,
				array(
					'Text',
					'limit_data_pinboard',
					array(
						'label' => 'Count for Pinboard View (number of articles to show).',
						'value' => 10,
						'validators' => array(
							array('Int', true),
							array('GreaterThan', true, array(0)),
						)
					)
				),
				array(
					'Text',
					'limit_data_grid',
					array(
						'label' => 'Count for Grid Views (number of articles to show).',
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
						'label' => 'Count for List Views (number of articles to show).',
						'value' => 20,
						'validators' => array(
							array('Int', true),
							array('GreaterThan', true, array(0)),
						)
					)
				),

				array('Text', "limit_data_simplelist", array(
      'label' => 'Count for List View 2 (number of articles to show).',
      'value' => 10,
      'validators' => array(
	array('Int', true),
	array('GreaterThan', true, array(0)),
      )
    )),
				array('Text', "limit_data_advlist", array(
      'label' => 'Count for List View 3 (number of articles to show).',
      'value' => 10,
      'validators' => array(
	array('Int', true),
	array('GreaterThan', true, array(0)),
      )
    )),array('Text', "limit_data_advlist2", array(
      'label' => 'Count for List View 4 (number of articles to show).',
      'value' => 10,
      'validators' => array(
	array('Int', true),
	array('GreaterThan', true, array(0)),
      )
    )),
				array('Text', "limit_data_advgrid", array(
      'label' => 'Count for Grid View 2 (number of articles to show).',
      'value' => 10,
      'validators' => array(
	array('Int', true),
	array('GreaterThan', true, array(0)),
      )
    )),
				array('Text', "limit_data_supergrid", array(
      'label' => 'Count for Grid View 3 (number of articles to show).',
      'value' => 10,
      'validators' => array(
	array('Int', true),
	array('GreaterThan', true, array(0)),
      )
    )),
		array('Text', "limit_data_grid2", array(
      'label' => 'Count for Grid View 4 (number of articles to show).',
      'value' => 10,
      'validators' => array(
	array('Int', true),
	array('GreaterThan', true, array(0)),
      )
    )),
		
	      $pagging,
      )
    ),
  ),
  array(
    'title' => 'SES - Advanced Article - Tabbed widget for Manage Articles',
    'description' => 'This widget displays articles created, favourite, liked, rated, etc by the member viewing the manage page. Edit this widget to configure various settings.',
    'category' => 'SES - Advanced Article',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesarticle.manage-articles',
    'requirements' => array(
      'subject' => 'article',
    ),
    'adminForm' => 'Sesarticle_Form_Admin_Tabbed',
  ),
  /*array(
    'title' => 'SES - Advanced Article - Article Profile Gutter Search',
    'description' => 'Displays a search form in the article profile gutter.',
    'category' => 'SES - Advanced Article',
    'type' => 'widget',
    'name' => 'sesarticle.gutter-search',
  ),*/
  array(
    'title' => 'SES - Advanced Article - Profile Options for Articles',
    'description' => 'Displays a menu of actions (edit, report, add to favourite, share, subscribe, etc) that can be performed on a article on its profile.',
    'category' => 'SES - Advanced Article',
    'type' => 'widget',
    'name' => 'sesarticle.gutter-menu',
  ),
  array(
    'title' => 'SES - Advanced Article - Article Profile - Owner Photo',
    'description' => 'Displays the owner\'s photo on the article view page.',
    'category' => 'SES - Advanced Article',
    'type' => 'widget',
    'name' => 'sesarticle.gutter-photo',
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
    'title' => 'SES - Advanced Article - Article Browse Search',
    'description' => 'Displays a search form in the article browse page as configured by you.',
    'category' => 'SES - Advanced Article',
    'type' => 'widget',
    'name' => 'sesarticle.browse-search',
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
	      'mostSPrated' => 'Most Rated',
	      'featured' => 'Only Featured',
	      'sponsored' => 'Only Sponsored',
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
	      'mostSPrated' => 'Most Rated',
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
	    'label' => "Show \'Search Articles Keyword\' search field?",
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
	array(
		'Radio',
		'has_photo',
		array(
			'label' => "Show \'Article With Photos\' search field?",
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
    'title' => 'SES - Advanced Article - Articles Navigation Menu',
    'description' => 'Displays a navigation menu bar in the Advanced Article\'s pages for Articles Home, Browse Articles, Browse Categories, etc pages.',
    'category' => 'SES - Advanced Article',
    'type' => 'widget',
    'name' => 'sesarticle.browse-menu',
    'requirements' => array(
      'no-subject',
    ),
  ),
  array(
    'title' => 'SES - Advanced Article - Create New Article Link',
    'description' => 'Displays a link to create new article.',
    'category' => 'SES - Advanced Article',
    'type' => 'widget',
    'name' => 'sesarticle.browse-menu-quick',
    'requirements' => array(
      'no-subject',
    ),
  ),
  array(
      'title' => 'SES Advanced Articles - Categories Cloud / Hierarchy View',
      'description' => 'Displays all categories of articles in cloud or hierarchy view. Edit this widget to choose various other settings.',
      'category' => 'SES - Advanced Article',
      'type' => 'widget',
      'name' => 'sesarticle.tag-cloud-category',
      'autoEdit' => true,
      'adminForm' => 'Sesarticle_Form_Admin_Tagcloudcategory',
  ),
  array(
    'title' => 'SES - Advanced Article - Article Profile - Similar Articles',
    'description' => 'Displays articles similar to the current article based on the article category. The recommended page for this widget is "SES - Advanced Article - Article Profile Page".',
    'category' => 'SES - Advanced Article',
    'type' => 'widget',
		'autoEdit' => true,
    'name' => 'sesarticle.similar-articles',
    'adminForm' => array(
      'elements' => array (
        array(
          'MultiCheckbox',
          'show_criteria',
          array(
            'label' => "Choose from below the details that you want to show for article in this widget.",
            'multiOptions' => array(
              'like' => 'Likes Count',
              'comment' => 'Comments Count',
              'favourite' => 'Favourites Count',
              'view' => 'Views Count',
              'title' => 'Article Title',
              'by' => 'Article Owner\'s Name',
              'rating' =>'Rating Stars',
              'featuredLabel' => 'Featured Label',
              'sponsoredLabel' => 'Sponsored Label',
              'verifiedLabel' => 'Verified Label',
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
            'label' => 'Do you want to allow users to view more similar articles in this widget? (If you choose Yes, then users will see Next & Previous buttons to view more articles.)',
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
            'label' => 'Count (number of articles to show).',
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
      'title' => 'SES Advanced Articles - Article Profile - Tags',
      'description' => 'Displays all tags of the current article on Article Profile Page. The recommended page for this widget is "SES - Advanced Article - Article Profile Page".',
      'category' => 'SES - Advanced Article',
      'type' => 'widget',
      'name' => 'sesarticle.profile-tags',
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
    'title' => 'SES Advanced Articles - Tags Horizantal View',
    'description' => 'Displays all tags of articles in horizantal view. Edit this widget to choose various other settings.',
    'category' => 'SES - Advanced Article',
    'type' => 'widget',
    'name' => 'sesarticle.tag-horizantal-articles',
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
      'title' => 'SES Advanced Articles - Tags Cloud / Tab View',
      'description' => 'Displays all tags of articles in cloud or tab view. Edit this widget to choose various other settings.',
      'category' => 'SES - Advanced Article',
      'type' => 'widget',
      'name' => 'sesarticle.tag-cloud-articles',
      'autoEdit' => true,
      'adminForm' => 'Sesarticle_Form_Admin_Tagcloudarticle',
  ),
  array(
      'title' => 'SES Advanced Articles - Browse All Tags',
      'description' => 'Displays all articles tags on your website. The recommended page for this widget is "SES - Advanced Article - Browse Tags Page".',
      'category' => 'SES - Advanced Article',
      'type' => 'widget',
      'name' => 'sesarticle.tag-albums',
  ),
  array(
		'title' => 'SES Advanced Articles - Top Article Posters',
		'description' => 'Displays all top posters on your website.',
		'category' => 'SES - Advanced Article',
		'type' => 'widget',
		'name' => 'sesarticle.top-articlegers',
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
							'count' => 'Articles Count',
							'ownername' => 'Article Owner\'s Name',
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
						'label' => 'Do you want to allow users to view more article posters in this widget? (If you choose Yes, then users will see Next & Previous buttons to view more article posters.)',
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
						'label' => 'Count (number of article posters to show).',
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
    'title' => 'SES - Advanced Article - Article Profile - Advanced Share Widget',
    'description' => 'This widget allow users to share the current article on your website and on other social networking websites. The recommended page for this widget is "SES - Advanced Article - Article Profile Page".',
    'category' => 'SES - Advanced Article',
    'type' => 'widget',
    'name' => 'sesarticle.advance-share',
    'autoEdit' => true,
    'adminForm' => 'Sesarticle_Form_Admin_Share',
  ),
  array(
    'title' => 'SES Advanced Articles - Article of the Day',
    'description' => "This widget displays articles of the day as chosen by you from the Edit Settings of this widget.",
    'category' => 'SES - Advanced Article',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesarticle.of-the-day',
    'adminForm' => array(
	'elements' => array(
			array(
			'Select',
			'viewType',
			array(
				'label' => 'Choose the view type.',
				'multiOptions' => array(
					"grid1" => "Grid View 1",
					"grid2" => "Grid View 2",
					"grid3" => "Grid View 3"
				)
			),
			'value' => 'grid1'
		),
	 array(
		'MultiCheckbox',
		'show_criteria',
		array(
		    'label' => "Choose from below the details that you want to show for articles in this widget.",
				'multiOptions' => array(
					'title' => 'Article Title',
					'category' => 'Category',
					'description' => 'Descripotion',
					'like' => 'Likes Count',
					'view' => 'Views Count',
					'comment' => 'Comment Count',
					'favourite' => 'Favourites Count',
					'rating' => 'Rating Count',
					'ratingStar' => 'Rating Star',
					'by' => 'Owner\'s Name',
					'favouriteButton' => 'Favourite Button',
					'likeButton' => 'Like Button',
					'featuredLabel' => 'Featured Label',
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
		    'label' => 'Article title truncation limit.',
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
	    'label' => 'Article description truncation limit.',
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
    'title' => 'SES - Advanced Article - Popular / Featured / Sponsored / Verified Articles',
    'description' => "Displays articles as chosen by you based on chosen criteria for this widget. The placement of this widget depends on the criteria chosen for this widget.",
    'category' => 'SES - Advanced Article',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesarticle.featured-sponsored',
    'adminForm' => array(
      'elements' => array(
	array(
	  'Select',
	  'viewType',
	  array(
	    'label' => 'Choose the view type.',
	    'multiOptions' => array(
	      "list" => "List",
	      "grid1" => "Grid View 1",
	      "grid2" => "Grid View 2"
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
	      '4' => 'All except Featured and Sponsored',
	    ),
	    'value' => 5,
	  )
	),
	array(
		'Select',
		'order',
		array(
			'label' => 'Duration criteria for the articles to be shown in this widget',
			'multiOptions' => array(
				'' => 'All Articles',
				'week' => 'This Week Articles',
				'month' => 'This Month Articles',
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
	  'MultiCheckbox',
	  'show_criteria',
	  array(
	    'label' => "Choose from below the details that you want to show for article in this widget.",
	    'multiOptions' => array(
	      'like' => 'Likes Count',
	      'comment' => 'Comments Count',
	      'favourite' => 'Favourites Count',
	      'view' => 'Views Count',
	      'title' => 'Article Title',
	      'description' => 'Article Description',
	      'by' => 'Article Owner\'s Name',
	      'creationDate' => 'Show Publish Date',
	      'category' => 'Category',
	      'rating' => 'Ratings Count',
	      'ratingStar' => 'Ratings Star',
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
		'Radio',
		'show_star',
		array(
				'label' => "Do you want to show rating stars in this widget? (Note: Please choose star setting yes, when you are selction \"Most Rated\" from above setting.)",
				'multiOptions' => array(
						'1' => 'Yes',
						'0' => 'No',
				),
				'value' => 0,
		)
  ),
  array(
	'Select',
	'showLimitData',
	array(
		'label' => 'Do you want to allow users to view more article posters in this widget? (If you choose Yes, then users will see Next & Previous buttons to view more article posters.)',
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
	    'label' => 'Article title truncation limit.',
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
	    'label' => 'Article description truncation limit.',
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
	    'label' => 'Count (number of articles to show).',
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
        'title' => 'SES - Advanced Article - Article Profile - Albums',
        'description' => 'Displays albums on article profile page. The recommended page for this widget is "SES - Advanced Article - Article Profile Page".',
        'category' => 'SES - Advanced Article',
        'type' => 'widget',
				'autoEdit' => true,
        'name' => 'sesarticle.profile-photos',
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
                            'inside' => 'Inside Album Blocks',
                            'outside' => 'Outside Album Blocks',
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
                            'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                            'photoCount' => 'Photos Count',
                            'likeButton' => 'Like Button',
                            'favouriteButton' => 'Favourite Button',
                        ),
                        'escape' => false,
                    //'value' => array('like','comment','view','rating','title','by','socialSharing'),
                    )
                ),
                $socialshare_enable_plusicon,
                $socialshare_icon_limit,
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
        'requirements' => array(
            'subject' => 'sesarticle',
        ),
    ),

     array(
      'title' => 'SES Advanced Articles - Album View Page - Options',
      'description' => "This widget enables you to choose various options to be shown on album view page like Likes count, Like button, etc.",
      'category' => 'SES - Advanced Article',
      'type' => 'widget',
      'autoEdit' => true,
      'name' => 'sesarticle.album-view-page',
      'adminForm' => 'Sesarticle_Form_Admin_Albumviewpage',
    ),

    		array(
        'title' => 'SES Advanced Articles - Photo View Page - Options',
        'description' => 'This widget enables you to choose various options to be shown on photo view page like Slideshow of other photos associated with same album as the current photo, etc.',
        'category' => 'SES - Advanced Article',
        'type' => 'widget',
        'name' => 'sesarticle.photo-view-page',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'Radio',
                    'criteria',
                    array(
                        'label' => 'Slideshow of other photos associated with same album?',
                        'multiOptions' =>
                        array(
                        	'1' => 'Yes',
				'0' =>'No'
                        ),
				'value' => 1
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
            ),
        ),
    ),

//   array(
//     'title' => 'SES - Advanced Article - Article Profile - Music Albums',
//     'description' => 'Displays music albums on article profile page. Edit this widget to choose content type to be shown. The recommended page for this widget is "SES - Advanced Article - Article Profile Page".',
//     'category' => 'SES - Advanced Article',
//     'type' => 'widget',
//     'name' => 'sesarticle.profile-musicalbums',
//     'autoEdit' => true,
//     'adminForm' => array(
//         'elements' => array(
//             array(
//                 'MultiCheckbox',
//                 'informationAlbum',
//                 array(
//                     'label' => 'Choose from below the details that you want to show for "Music Albums" shown in this widget.',
//                     'multiOptions' => array(
//                         "featured" => "Featured Label",
//                         "sponsored" => "Sponsored Label",
//                         "hot" => "Hot Label",
//                         "postedBy" => "Music Album Owner\'s Name",
//                         "commentCount" => "Comments Count",
//                         "viewCount" => "Views Count",
//                         "likeCount" => "Likes Count",
//                         "ratingStars" => "Rating Stars",
//                         "songCount" => "Song Count",
//                         "favourite" => "Favorite Icon on Mouse-Over",
//                         "share" => "Share Icon on Mouse-Over",
//                     ),
//                 ),
//             ),
//             array(
//                 'Select',
//                 'pagging',
//                 array(
//                     'label' => "Do you want music albums to be auto-loaded when users scroll down the page?",
//                     'multiOptions' => array(
//                         'button' => 'No, show \'View more\'',
//                         'auto_load' => 'Yes',
//                     ),
//                     'value' => 'auto_load',
//                 )
//             ),
//             array(
//                 'Text',
//                 'Height',
//                 array(
//                     'label' => 'Enter the height of one block [for Grid View (in pixels)].',
//                     'value' => '180',
//                 )
//             ),
//             array(
//                 'Text',
//                 'Width',
//                 array(
//                     'label' => 'Enter the width of one block [for Grid View (in pixels)].',
//                     'value' => '180',
//                 )
//             ),
//             array(
//                 'Text',
//                 'limit_data',
//                 array(
//                     'label' => 'count (number of music albums to show)',
//                     'value' => 3,
//                 )
//             ),
//         )
//     ),
//   ),
  array(
    'title' => 'SES - Advanced Article - Article Profile - Videos',
    'description' => 'Displays videos on article profile page. The recommended page for this widget is "SES - Advanced Article - Article Profile Page".',
    'category' => 'SES - Advanced Article',
    'type' => 'widget',
    'name' => 'sesarticle.profile-videos',
    'autoEdit' => true,
    'adminForm' => 'Sesarticle_Form_Admin_Profilevideos',
  ),
array(
	'title' => 'SES - Advanced Article - Review Profile',
	'description' => 'Displays review and review statistics on "SES - Advanced Article - Review Profile Page".',
	'category' => 'SES - Advanced Article',
	'type' => 'widget',
	'name' => 'sesarticle.review-profile',
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
							"description" => "Description",
							"recommended" => "Recommended",
							'postedin' => "Posted In",
							"creationDate" => "Creation Date",
							'parameter'=>'Review Parameters',
							'rating' => 'Rating Stars',
							'customfields' => 'Form Questions',
							'likeButton' => 'Like Button',
							'socialSharing' =>'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
							'share' => 'Share Review',
									),
									'escape' => false,
							),
					),
          $socialshare_enable_plusicon,
          $socialshare_icon_limit,
					),
			),
	),
  array(
      'title' => 'SES - Advanced Article - Review Profile - Breadcrumb',
      'description' => 'Displays breadcrumb for Reviews. This widget should be placed on the "SES - Advanced Article - Review Profile Page".',
      'category' => 'SES - Advanced Article',
      'autoEdit' => true,
      'type' => 'widget',
      'name' => 'sesarticle.review-breadcrumb',
      'autoEdit' => true,
  ),
	array(
		'title' => 'SES - Advanced Article - Album Profile - Breadcrumb',
		'description' => 'Displays breadcrumb for Albums. This widget should be placed on the SES - Advanced Article - Album Profile Page.',
		'category' => 'SES - Advanced Article',
		'autoEdit' => true,
		'type' => 'widget',
		'name' => 'sesarticle.album-breadcrumb',
		'autoEdit' => true,
  ),
  array(
      'title' => 'SES - Advanced Article - Review Profile - Options',
      'description' => 'Displays a menu of actions (edit, report, share, etc) that can be performed on reviews on its profile. The recommended page for this widget is "SES - Advanced Article - Review Profile Page".',
      'category' => 'SES - Advanced Article',
      'type' => 'widget',
      'name' => 'sesarticle.review-profile-options',
      'autoEdit' => true,
      'adminForm' => array(
          'elements' => array(
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
      'title' => "SES - Advanced Article - Review Owner's Photo",
      'description' => 'This widget displays photo of the member who has written the current review. The recommended page for this widget is "SES - Advanced Article - Review View Page".',
      'category' => 'SES - Advanced Article',
      'type' => 'widget',
      'autoEdit' => true,
      'name' => 'sesarticle.review-owner-photo',
      'defaultParams' => array(
          'title' => '',
      ),
      'adminForm' => array(
          'elements' => array(
              array(
                  'Select',
                  'showTitle',
                  array(
                      'label' => 'Do you want to show Member’s Name in this widget?',
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
    'title' => 'SES - Advanced Article - Category Carousel',
    'description' => 'Displays categories in attractive carousel in this widget. The placement of this widget depends on the criteria chosen for this widget.',
    'category' => 'SES - Advanced Article',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesarticle.category-carousel',
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
	      'most_article' => 'Categories with maximum articles first',
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
	      'countArticles' => 'Article count in each category',
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
    'title' => 'SES Advanced Articles - Categories Icon View',
    'description' => 'Displays all categories of articles in icon view with their icon. Edit this widget to configure various settings.',
    'category' => 'SES - Advanced Article',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesarticle.article-category-icons',
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
	      'most_article' => 'Categories with maximum articles first',
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
	      'countArticles' => 'Article count in each category',
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
    'title' => 'SES - Advanced Article - Alphabetic Filtering of Articles',
    'description' => "This widget displays all the alphabets for alphabetic filtering of articles which will enable users to filter articles on the basis of selected alphabet.",
    'category' => 'SES - Advanced Article',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesarticle.alphabet-search',
    'defaultParams' => array(
      'title' => "",
    ),
  ),
  array(
    'title' => 'SES - Advanced Article - Article Profile - Breadcrumb',
    'description' => 'Displays breadcrumb for Article. This widget should be placed on the Advanced Article - View page of the selected content type.',
    'category' => 'SES - Advanced Article',
    'type' => 'widget',
    'name' => 'sesarticle.breadcrumb',
    'autoEdit' => true,
  ),
	 array(
    'title' => 'SES - Advanced Article - Article Custom Field Info',
    'description' => 'Displays article custom fields for Article. This widget should be placed on the Advanced Article - View page of article.',
    'category' => 'SES - Advanced Article',
    'type' => 'widget',
    'name' => 'sesarticle.article-info',
		'defaultParams' => array(
      'title' => "Custom Fields",
    ),
    'autoEdit' => false,
  ),
    array(
    'title' => 'SES - Advanced Article - New Claim Request Form',
    'description' => 'Displays form to make new request to claim a article. This widget should be placed on the "SES - Advanced Article - New Claims Page".',
    'category' => 'SES - Advanced Article',
    'type' => 'widget',
    'name' => 'sesarticle.claim-article',
    'autoEdit' => true,
  ),
    array(
    'title' => 'SES - Advanced Article - Browse Claim Requests',
    'description' => 'Displays all claim requests made by the current member viewing the page. The recommended page for this widget is "SES - Advanced Article - Browse Claim Requests Page',
    'category' => 'SES - Advanced Article',
    'autoEdit' => true,
    'type' => 'widget',
    'name' => 'sesarticle.claim-requests',
    'autoEdit' => true,
  ),
	array(
		'title' => 'SES - Advanced Article - Article Profile - Reviews	',
		'description' => 'Displays reviews on article profile page. The recommended page for this widget is "SES - Advanced Article - Article Profile Page".',
		'category' => 'SES - Advanced Article',
		'type' => 'widget',
		'name' => 'sesarticle.article-reviews',
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
							"share" => "Share Button",
							"report" => "Report Button",
							"pros" => "Pros",
							"cons" => "Cons",
							"description" => "Description",
							"recommended" => "Recommended",
							'postedBy' => "Posted By",
							'parameter' => 'Review Parameters',
							"creationDate" => "Creation Date",
							'rating' => 'Rating Stars',
							'likeButton' => 'Like Button',
              'socialSharing' =>'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
						),
						'escape' => false,
					),
				),
        $socialshare_enable_plusicon,
        $socialshare_icon_limit,
				$pagging,
				array(
					'Text',
					'limit_data',
					array(
						'label' => 'count (number of reviews to show).',
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
		'title' => 'SES - Advanced Article - Popular / Featured / Verified Reviews',
		'description' => "Displays reviews as chosen by you based on chosen criteria for this widget. The placement of this widget depends on the criteria chosen for this widget.",
		'category' => 'SES - Advanced Article',
		'type' => 'widget',
		'autoEdit' => true,
		'name' => 'sesarticle.popular-featured-verified-reviews',
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
				$imageType,
				array(
				'Select',
					'showLimitData',
					array(
						'label' => 'Do you want to allow users to view more reviews in this widget? (If you choose Yes, then users will see Next & Previous buttons to view more reviews.',
						'multiOptions' => array(
							"1" => "Yes",
							"0" => "No",
						)
					),
					'value' => '1',
				),
				array(
					'MultiCheckbox',
					'show_criteria',
					array(
						'label' => "Choose from below the details that you want to show for article in this widget.",
						'multiOptions' => array(
							'title' => 'Review Title',
							'like' => 'Likes Count',
							'view' => 'Views Count',
							'comment' => 'Comments Count',
							'rating' => 'Ratings',
							'verifiedLabel' => 'Verified Label',
							'featuredLabel' => 'Featured Label',
							'description' => 'Description',
							'by' => 'By',
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
						'label' => 'Descripotion truncation limit.',
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
						'label' => 'Count (number of reviews to show).',
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
		'title' => 'SES - Advanced Article - Review of the Day',
		'description' => "This widget displays review of the day as chosen by you from the \"Manage Reviews\" settings of this plugin.",
		'category' => 'SES - Advanced Article',
		'type' => 'widget',
		'autoEdit' => true,
		'name' => 'sesarticle.review-of-the-day',
		'adminForm' => array(
			'elements' => array(
				array(
					'MultiCheckbox',
					'show_criteria',
					array(
						'label' => "Choose from below the details that you want to show for member in this widget.",
						'multiOptions' => array(
							'title' => 'Display Review Title',
							'like' => 'Likes Count',
							'view' => 'Views Count',
							'rating' => 'Ratings',
							'featuredLabel' => 'Featured Label',
							'verifiedLabel' => 'Verified Label',
							'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
							'by' => 'Review Owner Name',
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
					'height',
					array(
						'label' => 'Enter the height of photo block of review(in pixels).',
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
		'title' => 'SES - Advanced Article - Browse Reviews',
		'description' => 'Displays all reviews for articles on your webiste. This widget is placed on "SES - Advanced Article - Browse Reviews Page".',
		'category' => 'SES - Advanced Article',
		'type' => 'widget',
		'autoEdit' => true,
		'name' => 'sesarticle.browse-reviews',
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
								"share" => "Share Button",
								"report" => "Report Button",
								"pros" => "Pros",
								"cons" => "Cons",
								"description" => "Description",
								"recommended" => "Recommended",
								'postedBy' => "Posted By",
								'parameter' => 'Review Parameters',
								"creationDate" => "Creation Date",
								'rating' => 'Rating Stars',
								'likeButton' => 'Like Button',
                'socialSharing' =>'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
							),
							'escape' => false,
						)
					),
          $socialshare_enable_plusicon,
          $socialshare_icon_limit,
					array(
						'MultiCheckbox',
						'show_criteria',
						array(
								'label' => "Choose from below the details that you want to show for article in this widget.",
								'multiOptions' => array(
										'likemainButton' => 'Like Button',
										'featuredLabel' => 'Featured Label',
										'verifiedLabel' => 'Verified Label',
								),
						),
					),
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
		'title' => 'SES - Advanced Article - Review Browse Search',
		'description' => 'Displays a search form in the review browse page as configured by you.',
		'category' => 'SES - Advanced Article',
		'type' => 'widget',
		'name' => 'sesarticle.browse-review-search',
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
						'label' => "Show \'Review Title\' search field?",
						'multiOptions' => array(
								'1' => 'Yes',
								'0' => 'No'
						),
						'value' => '1',
					)
				),
				array(
					'Radio',
					'review_search',
					array(
						'label' => "Show \'Browse By\' search field?",
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
						'label' => "Choose options to be shown in \'Browse By\' search fields.",
						'multiOptions' => array(
							'mostSPliked' => 'Most Liked',
							'mostSPviewed' => 'Most Viewed',
							'mostSPcommented' => 'Most Commented',
							'mostSPrated' => 'Most Rated',
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
					'review_recommendation',
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
// 	  array(
//     'title' => 'SES - Advanced Article - Article Cover',
//     'description' => 'This widget displaysarticle cover photo on Article Profile Page. The recommended page for this widget is "SES - Advanced Article - Article Profile Page".',
//     'category' => 'SES - Advanced Article',
//     'type' => 'widget',
//     'autoEdit' => true,
//     'name' => 'sesarticle.article-cover',
//     'requirements' => array(
//       'subject' => 'article',
//     ),
//   ),
 array(
    'title' => 'SES - Advanced Article - Labels',
    'description' => 'This widget displays Featured, Sponsored and Verified labels on Article Profile Page. The recommended page for this widget is "SES - Advanced Article - Article Profile Page".',
    'category' => 'SES - Advanced Article',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesarticle.labels',
  ),
	 array(
    'title' => 'SES - Advanced Article - Tabs',
    'description' => '',
    'category' => 'SES - Advanced Article',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesarticle.profile-sidebar-tabs',
  ),
  array(
    'title' => 'SES - Advanced Article - Article Sidebar Tabbed Widget',
    'description' => 'Displays a tabbed widget for articles. You can place this widget anywhere on your site.',
    'category' => 'SES - Advanced Article',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesarticle.sidebar-tabbed-widget',
    'requirements' => array(
      'subject' => 'article',
    ),
    'adminForm' => 'Sesarticle_Form_Admin_SidebarTabbed',
  ),
  array(
    'title' => 'SES - Advanced Article - Article Profile - Content',
    'description' => 'Displays article content according to the design choosen by the article poster while creating or editing the article. The recommended page for this widget is "SES - Advanced Article - Article Profile Page".',
    'category' => 'SES - Advanced Article',
    'type' => 'widget',
    'name' => 'sesarticle.view-article',
		'adminForm' => array(
			'elements' => array(
				array(
					'MultiCheckbox',
					'show_criteria',
					array(
						'label' => "Choose from below the details that you want to show in this widget.",
						'multiOptions' => array(
							'title' => 'Title',
							'description' => 'Show Description',
							'photo' => 'Article Photo',
							'socialShare' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
							'ownerOptions' => 'Owner Options',
							'postComment' => 'Comment Button',
							'rating' => 'Rating Star',
							'likeButton' => 'Like Button',
							'favouriteButton' => 'Favourite Button',
							'shareButton' => 'Large Share Button',
							'smallShareButton' => 'Small Share Button',
							'view' => 'View Count',
							'like' => 'Like Count',
							'comment' => 'Comment Count',
							'review' => 'Review Count',
							'statics' => 'Show Statstics'
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
                        'label' => 'Enter the height of article image(in pixels).',
                        'value' => '500',
                    )
                ),
			),
		),
  ),
array(
		'title' => 'SES - Advanced Article - Category Banner Widget',
		'description' => 'Displays a banner for categories. You can place this widget at browse page of category on your site.',
		'category' => 'SES - Advanced Article',
		'type' => 'widget',
		'autoEdit' => true,
		'name' => 'sesarticle.banner-category',
		'requirements' => array(
				'subject' => 'article',
		),
		'adminForm' => 'Sesarticle_Form_Admin_Categorywidget',
	),
	array(
		'title' => 'SES - Advanced Article - Calendar Widget',
		'description' => 'Displays calendar . You can place this widget at browse page of article on your site.',
		'category' => 'SES - Advanced Article',
		'type' => 'widget',
		'autoEdit' => false,
		'name' => 'sesarticle.calendar'
	),
	    array(
        'title' => 'SES - Advanced Article - Categories Square Block View',
        'description' => 'Displays all categories of articles in square blocks. Edit this widget to configure various settings.',
        'category' => 'SES - Advanced Article',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesarticle.article-category',
        'requirements' => array(
            'subject' => 'article',
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
                    'video_required',
                    array(
                        'label' => "Do you want to show only those categories under which atleast 1 article is posted?",
                        'multiOptions' => array(
                            '1' => 'Yes, show only categories with articles',
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
                            'most_article' => 'Most Articles Category First',
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
                            'countArticles' => 'Article count in each category',
                        ),
                    )
                ),
            ),
        ),
    ),
        array(
        'title' => 'SES - Advanced Article - Category Based Articles Block View',
        'description' => 'Displays articles in attractive square block view on the basis of their categories. This widget can be placed any where on your website.',
        'category' => 'SES - Advanced Article',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesarticle.category-associate-article',
        'requirements' => array(
            'subject' => 'article',
        ),
        'adminForm' => array(
            'elements' => array(
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show for albums in this widget.",
                        'multiOptions' => array(
                            'like' => 'Likes Count',
                            'comment' => 'Comments Count',
                            'rating' => 'Rating Count',
                            'ratingStar' => 'Rating Star',
                            'view' => 'Views Count',
                            'title' => 'Title Count',
                            'favourite' => 'Favourites Count',
                            'by' => 'Article Owner\'s Name',
                            'featuredLabel' => 'Featured Label',
                            'sponsoredLabel' => 'Sponsored Label',
                            'creationDate' => 'Show Publish Date',
                            'readmore' => 'Read More',
                        ),
                    )
                ),
                array(
                    'Radio',
                    'popularity_article',
                    array(
                        'label' => 'Choose Article Display Criteria.',
                        'multiOptions' => array(
                            "creation_date" => "Recently Created",
                            "view_count" => "Most Viewed",
                            "like_count" => "Most Liked",
                            "rating" => "Most Rated",
                            "comment_count" => "Most Commented",
                            "favourite_count" => "Most Favourite",
                            'featured' => 'Only Featured',
                            'sponsored' => 'Only Sponsored',
                        ),
                        'value' => 'like_count',
                    )
                ),
                $pagging,
                array(
                    'Select',
                    'count_article',
                    array(
                        'label' => "Show articles count in each category.",
                        'multiOptions' => array(
                            '1' => 'Yes',
                            '0' => 'No'
                        ),
                    ),
                ),
                array(
                    'Select',
                    'criteria',
                    array(
                        'label' => "Choose Popularity Criteria.",
                        'multiOptions' => array(
                            'alphabetical' => 'Alphabetical Order',
                            'most_article' => 'Categories with maximum articles first',
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
                    'article_limit',
                    array(
                        'label' => 'count (number of articles to show in each category. This settging will work, if you choose "Yes" for "Show articles count in each category" setting above.").',
                        'value' => '8',
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
								array(
									'Text',
									'article_description_truncation',
									array(
										'label' => 'Descripotion truncation limit.',
										'value' => 45,
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
                        'label' => "Choose alignment of \"+ See All\" field
",
                        'multiOptions' => array(
                            'left' => 'left',
                            'right' => 'right'
                        ),
                    ),
                ),
                $heightOfContainer,
                $widthOfContainer,
            )
        ),
    ),
        array(
        'title' => 'SES - Advanced Article - Category View Page Widget',
        'description' => 'Displays a view page for categories. You can place this widget at view page of category on your site.',
        'category' => 'SES - Advanced Article',
        'type' => 'widget',
        'name' => 'sesarticle.category-view',
        'requirements' => array(
            'subject' => 'article',
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
                            'countArticle' => 'Articles count in each category',
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
                    'textArticle',
                    array(
                        'label' => 'Enter teh text for \'heading\' of this widget.',
                        'value' => 'Articles we like',
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
                            'like' => 'Likes',
                            'comment' => 'Comments',
                            'rating' => 'Rating Count',
                            'ratingStar' => 'Rating Star',
                            'favourite'=>'Favourite',
                            'view' => 'Views',
                            'title' => 'Titles',
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
                    'article_limit',
                    array(
                        'label' => 'count (number of articles to show).',
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
        'title' => 'SES - Advanced Article - Article tags',
        'description' => 'Displays all article tags on your website. The recommended page for this widget is "SES - Advanced Article - Browse Tags Page".',
        'category' => 'SES - Advanced Article',
        'type' => 'widget',
        'name' => 'sesarticle.tag-articles',
    ),
    array(
		'title' => 'SES - Advanced Article - Popular / Featured / Sponsored / Verified 3 Articles View',
		'description' => '',
		'category' => 'SES - Advanced Article',
		'type' => 'widget',
		'autoEdit' => true,
		'name' => 'sesarticle.featured-sponsored-verified-random-article',
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
	      '4' => 'All except Featured and Sponsored',
	    ),
	    'value' => 5,
	  )
	),
		array(
		'Select',
		'order',
		array(
			'label' => 'Duration criteria for the articles to be shown in this widget.',
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
	    'label' => "Choose from below the details that you want to show for article in this widget.",
	    'multiOptions' => array(
	      'like' => 'Likes Count',
	      'comment' => 'Comments Count',
	      'favourite' => 'Favourites Count',
	      'view' => 'Views Count',
	      'title' => 'Article Title',
	      'by' => 'Article Owner\'s Name',
		'rating' =>'Rating Count',
		'ratingStar' =>'Rating Stars',
		'featuredLabel' => 'Featured Label',
		'sponsoredLabel' => 'Sponsored Label',
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
    'title' => 'SES - Advanced Article - Article Profile - Sub Articles',
    'description' => 'Displays sub articles on article profile page. The recommended page for this widget is "SES - Advanced Article - Article Profile Page".',
    'category' => 'SES - Advanced Article',
    'type' => 'widget',
    'name' => 'sesarticle.related-articles',
        'adminForm' => array(
			'elements' => array (
	array(
	  'MultiCheckbox',
	  'show_criteria',
	  array(
	    'label' => "Choose from below the details that you want to show for article in this widget.",
	    'multiOptions' => array(
	      'like' => 'Likes Count',
	      'comment' => 'Comments Count',
	      'favourite' => 'Favourites Count',
	      'view' => 'Views Count',
	      'title' => 'Article Title',
	      'by' => 'Article Owner\'s Name',
				'rating' =>'Rating Count',
				'ratingStar' =>'Rating Stars',
				'featuredLabel' => 'Featured Label',
				'sponsoredLabel' => 'Sponsored Label',
				'verifiedLabel' => 'Verified Label',
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
		'label' => 'Do you want to allow users to view more sub articles in this widget? (If you choose Yes, then users will see Next & Previous buttons to view more sub articles.',
		'multiOptions' => array(
			"1" => "Yes",
			"0" => "No",
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
	    'label' => 'Article title truncation limit.',
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
	    'label' => 'Count (number of articles to show).',
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
        'title' => 'SES - Advanced Article - Article Locations',
        'description' => 'This widget displays articles based on their locations in Google Map.',
        'category' => 'SES - Advanced Article',
        'type' => 'widget',
        'name' => 'sesarticle.article-location',
				'autoEdit' => true,
    		'adminForm' => 'Sesarticle_Form_Admin_Location',
    ),

    	array(
    'title' => 'SES - Advanced Article - Popular / Featured / Sponsored / Verified Articles Slideshow',
    'description' => "Displays slideshow of articles as chosen by you based on chosen criteria for this widget. You can also choose to show Articles of specific categories in this widget. The placement of this widget depends on the criteria chosen for this widget.",
    'category' => 'SES - Advanced Article',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesarticle.featured-sponsored-verified-category-slideshow',
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
			  '0' => 'All Articles',
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
			'label' => 'Duration criteria for the articles to be shown in this widget.',
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
	    'label' => "Do you want to enable autoplay of articles?",
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
	    'label' => 'Delay time for next article when you have enabled autoplay.',
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
	    'label' => "Choose from below the details that you want to show for articles in this widget.",
	    'multiOptions' => array(
	      'like' => 'Likes Count',
	      'comment' => 'Comments Count',
	      'favourite' => 'Favourites Count',
	      'view' => 'Views Count',
	      'title' => 'Article Title',
	      'description' => 'Article Descripotion',
	      'by' => 'Article Owner\'s Name',
				'rating' =>'Rating Count',
				'ratingStar' =>'Rating Stars',
				'featuredLabel' => 'Featured Label',
				'sponsoredLabel' => 'Sponsored Label',
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
	    'label' => 'Article title truncation limit.',
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
	    'label' => 'Article description truncation limit.',
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
	    'label' => 'Count (number of articles to show).',
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
    'title' => 'SES - Advanced Article - Article Content Widget',
    'description' => 'Displays a content widget for article. You can place this widget on article profile page in tab container only on your site.',
    'category' => 'SES - Advanced Article',
    'type' => 'widget',
    'name' => 'sesarticle.content',
    'requirements' => array(
      'subject' => 'article',
    ),
  ),
  	  array(
    'title' => 'SES - Advanced Article - Article Profile - Photo',
    'description' => 'Displays a article photo widget. You can place this widget on article profile page only on your site.',
    'category' => 'SES - Advanced Article',
    'type' => 'widget',
    'name' => 'sesarticle.article-photo',
    'requirements' => array(
      'subject' => 'article',
    ),
  ),
    	  array(
    'title' => 'SES - Advanced Article - Article Title Widget',
    'description' => 'Displays a article title widget. You can place this widget on article profile page only on your site.',
    'category' => 'SES - Advanced Article',
    'type' => 'widget',
    'name' => 'sesarticle.article-title',
    'requirements' => array(
      'subject' => 'article',
    ),
  ),
    	  array(
    'title' => 'SES - Advanced Article - Article Social Share Widget',
    'description' => 'Displays a article social share widget. You can place this widget on article profile page only on your site.',
    'category' => 'SES - Advanced Article',
    'type' => 'widget',
    'name' => 'sesarticle.article-socialshare',
    'adminForm' => array(
			'elements' => array(
				array(
					'Radio',
					'socialshare_design',
					array(
						'label' => "Do you want this social share widget on article profile page ?",
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
      'subject' => 'article',
    ),
  ),
      array(
        'title' => 'SES - Advanced Article - Article Profile - Map',
        'description' => 'Displays a article location on map on it\'s profile.',
        'category' => 'SES - Advanced Article',
        'type' => 'widget',
        'name' => 'sesarticle.article-map',
        'defaultParams' => array(
            'title' => 'Map',
            'titleCount' => true,
        ),
        'requirements' => array(
            'subject' => 'user',
        ),
    ),

    	  array(
    'title' => 'SES - Advanced Article - Css Article Widget',
    'description' => 'Displays a article title widget. You can place this widget on article profile page only on your site.',
    'category' => 'SES - Advanced Article',
    'type' => 'widget',
    'name' => 'sesarticle.css-article',
    'requirements' => array(
      'subject' => 'article',
    ),
  ),
  		array(
        'title' => 'SES - Advanced Article - Article Contact Information',
        'description' => 'Displays article contact information in this widget. The placement of this widget depends on the article profile page.',
        'category' => 'SES - Advanced Article',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesarticle.article-contact-information',
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
        'title' => 'SES - Advanced Article - Profile Article\'s Like Button',
        'description' => 'Displays like button for article. This widget is only placed on "Article Profile Page" only.',
        'category' => 'SES - Advanced Article',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesarticle.like-button',
        'defaultParams' => array(
            'title' => '',
        ),
    ),

    		    array(
        'title' => 'SES - Advanced Article - Profile Article\'s Favourite Button',
        'description' => 'Displays favourite button for article. This widget is only placed on "Article Profile Page" only.',
        'category' => 'SES - Advanced Article',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesarticle.favourite-button',
        'defaultParams' => array(
            'title' => '',
        ),
    ),


  array(
    'title' => 'SES Advanced Articles - Double Article Slideshow',
    'description' => 'This widget displays 2 types of articles. The one section of this widget will be slideshow and the other will show 3 articles based on the criterion chosen in this widget.',
    'category' => 'SES - Advanced Article',
    'type' => 'widget',
    'name' => 'sesarticle.articles-slideshow',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Select',
          'criteria',
          array(
            'label' => "Content for 3 articles display in left side.",
            'multiOptions' => array(
              '5' => 'All including Featured and Sponsored',
              '1' => 'Only Featured',
              '2' => 'Only Sponsored',
              '3' => 'Both Featured and Sponsored',
              '6' => 'Only Verified',
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
          'leftArticle',
          array(
            'label' => "Do you want to enable the 3 Articles in left side?",
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
            'label' => 'Duration criteria for the 3 articles to be shown in this widget in left side.',
            'multiOptions' => array(
              '' => 'All Articles',
              'week' => 'This Week Articles',
              'month' => 'This Month Articles',
            ),
            'value' => '',
          )
        ),
        array(
          'Select',
          'info',
          array(
            'label' => 'Choose popularity criteria for the 3 articles to be displayed in left side.',
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
          'criteria_right',
          array(
            'label' => "Content for slideshow in right side",
            'multiOptions' => array(
              '5' => 'All including Featured and Sponsored',
              '1' => 'Only Featured',
              '2' => 'Only Sponsored',
              '3' => 'Both Featured and Sponsored',
              '6' => 'Only Verified',
              '4' => 'All except Featured and Sponsored',
            ),
            'value' => 5,
          )
        ),
        array(
          'Select',
          'order_right',
          array(
            'label' => 'Duration criteria for the articles to be shown in the slideshow of this widget in right side',
            'multiOptions' => array(
              '' => 'All Articles',
              'week' => 'This Week Articles',
              'month' => 'This Month Articles',
            ),
            'value' => '',
          )
        ),
        array(
          'Select',
          'info_right',
          array(
            'label' => 'Choose popularity criteria for the articles to be displayed in the slideshow in right side.',
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
          'autoplay',
          array(
            'label' => "Do you want to enable the autoplay of articles slideshow?",
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
            'label' => 'Enter the delay time for the next article to be displayed in slideshow. (work if autoplay is enabled.)',
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
            'label' => "Choose from below the details that you want to show for articles in this widget.",
            'multiOptions' => array(
              'like' => 'Likes Count',
              'comment' => 'Comments Count',
              'favourite' => 'Favourites Count',
              'view' => 'Views Count',
              'title' => 'Article Title',
              'by' => 'Article Owner\'s Name',
              'rating' =>'Rating Count',
              //'ratingStar' =>'Rating Stars',
              //'featuredLabel' => 'Featured Label',
              // 'sponsoredLabel' => 'Sponsored Label',
              // 'verifiedLabel' => 'Verified Label',
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
            'label' => 'Count for the articles to be displayed in slideshow.',
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
    'title' => 'SES - Advanced Article - Popular / Featured / Sponsored / Verified Articles Crawl',
    'description' => '',
    'category' => 'SES - Advanced Article',
    'type' => 'widget',
    'name' => 'sesarticle.articles-crawl',
    'requirements' => array(
      'subject' => 'article',
    ),
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Select',
          'criteria',
          array(
            'label' => "Content for articles display in this widget.",
            'multiOptions' => array(
              '5' => 'All including Featured and Sponsored',
              '1' => 'Only Featured',
              '2' => 'Only Sponsored',
              '3' => 'Both Featured and Sponsored',
              '6' => 'Only Verified',
              '4' => 'All except Featured and Sponsored',
            ),
            'value' => 5,
          )
        ),
        array(
          'Select',
          'order',
          array(
            'label' => 'Duration criteria for the articles to be shown in this widget.',
            'multiOptions' => array(
              '' => 'All Articles',
              'week' => 'This Week Articles',
              'month' => 'This Month Articles',
            ),
            'value' => '',
          )
        ),
        array(
          'Select',
          'info',
          array(
            'label' => 'Choose popularity criteria for the articles to be displayed in this widget.',
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
          'showCreationDate',
          array(
            'label' => "Do you want show Creation Date?",
            'multiOptions' => array(
              1=>'Yes',
              0=>'No'
            ),
          ),
        ),
        array(
          'Select',
          'autoplay',
          array(
            'label' => "Do you want to enable the autoplay of articles slideshow?",
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
            'label' => 'Enter the delay time for the next article to be displayed in slideshow. (work if autoplay is enabled.)',
            'value' => '2000',
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
            'label' => 'Count for the articles to be displayed in slideshow.',
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
?>
