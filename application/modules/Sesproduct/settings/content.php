<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: content.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$arrayGallery = array();
if(Engine_Api::_()->getDbtable("modules", "core")->isModuleEnabled("estore")) {
  $banner_options = array();
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
  $results = Engine_Api::_()->getDbtable('offers', 'estore')->getOffers(array('fetchAll' => true));
  if (count($results) > 0) {
    foreach ($results as $gallery)
      $arrayGallery[$gallery['offer_id']] = $gallery['offer_name'];
  }
}

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
if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.pluginactivated')) {
  $categories = Engine_Api::_()->getDbtable('categories', 'sesproduct')->getCategoriesAssoc(array('module'=>true));
}

$viewType = array(
  'MultiCheckbox',
  'enableTabs',
  array(
      'label' => "Choose the View Type.",
      'multiOptions' => array(
      'list' => 'List View',
      'grid' => 'Grid View',
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
      'list' => 'List View',
      'grid' => 'Grid View',
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
      'price' =>'Price',
      'discount' => 'Discount',
      'stock' =>'Stock',
      'storeName' =>'Store Name & Photo',
      'addCart' => 'Add to Cart Button',
      'addWishlist' => 'Add to wishlist',
      'addCompare'=>'Add to Compare',
      'brand' => 'Brand Name',
      'featuredLabel' => 'Featured Label',
      'sponsoredLabel' => 'Sponsored Label',
      'verifiedLabel' => 'Verified Label',
      'favouriteButton' => 'Favourite Button',
      'likeButton' => 'Like Button',
      'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
      'like' => 'Likes Count',
      'favourite' => 'Favorites Count',
      'comment' => 'Comments Count',
      //'ratingStar' => 'Ratings Star',
      'rating' => 'Ratings Count',
      'view' => 'Views Count',
      'title' => 'Product Title',
      'category' => 'Category',
      'creationDate' => 'Creation Date',
      'location'=> 'Location',
      'description' => 'Description',
    //'enableCommentPinboard'=>'Enable commenting in Pinboard View',
    ),
    'escape' => false,
  )
);
$pagging = array(
  'Radio',
  'pagging',
  array(
    'label' => "Do you want the products to be auto-loaded when users scroll down the page?",
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
            'rounded' => 'Rounded',
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
    'title' => 'SES - Products - People Like Product',
    'description' => 'Placed on  a Product view page.',
    'category' => 'SES - Stores Marketplace - Products',
    'type' => 'widget',
    'name' => 'sesproduct.people-like-item',
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
    'title' => 'SES - Products - Popular / Featured / Sponsored / Verified Products Carousel',
    'description' => "Displays carousel of products as configured by you based on chosen criteria for this widget. You can also choose to show Products of specific categories in this widget.",
    'category' => 'SES - Stores Marketplace - Products',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesproduct.featured-sponsored-verified-category-carousel',
    'adminForm' => array(
      'elements' => array(
			array(
	  'Select',
	  'carousel_type',
	  array(
	    'label' => 'Choose the view type. [In Slick View, first and last product will partially show in the carousel.]',
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
	      '7' => 'Discount',
	    ),
	    'value' => 5,
	  )
	),
	array(
		'Select',
		'order',
		array(
			'label' => 'Duration criteria for the products to be shown in this widget',
			'multiOptions' => array(
				'' => 'All Products',
				'week' => 'This Week Products',
				'month' => 'This Month Products',
				'category' => 'Based on Category',
				'myProduct' => 'My Products',
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
	    'label' => "Do you want to enable autoplay of products?",
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
	    'label' => 'Delay time for next product when you have enabled autoplay.',
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
	      'title' => 'Product Title',
          'rating' =>'Reviews and Ratings',
          'ratingStar' =>'Rating Stars',
          'featuredLabel' => 'Featured Label',
          'sponsoredLabel' => 'Sponsored Label',
          'verifiedLabel' => 'Verified Label',
          'favouriteButton' => 'Favourite Button',
          'likeButton' => 'Like Button',
	      'category' => 'Category',
	      'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
	      'creationDate' => 'Show Publish Date',
           'price' =>'Price',
          'discount' => 'Discount',
          'stock' => 'Stock',
          'storeName' => 'Store Name & Photo',
          'addCart' => 'Add to Cart',
          'addWishlist' => 'Add to wishlist',
          'brand' => 'Brand Name',
          'offer' => 'Offer',
          'totalProduct' => 'Product Count',
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
	    'label' => 'Product title truncation limit.',
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
	  'limit_data',
	  array(
	    'label' => 'Count (number of products to show).',
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
    'title' => 'SES - Products - Tabbed widget for Popular Products',
    'description' => 'Displays a tabbed widget for popular products on your website based on various popularity criterias. Edit this widget to choose tabs to be shown in this widget. This widget can be placed anywhere on your website.',
    'category' => 'SES - Stores Marketplace - Products',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesproduct.tabbed-widget-product',
    'requirements' => array(
      'subject' => 'product',
    ),
    'adminForm' => 'Sesproduct_Form_Admin_Tabbed',
  ),
 array(
    'title' => 'SES - Products - Upsell Products',
    'description' => 'Displays Upsell products on your website.',
    'category' => 'SES - Stores Marketplace - Products',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesproduct.upsell-products',
    'requirements' => array(
      'subject' => 'product',
    ),
    'adminForm' => array(
    'elements' => array(
        $showCustomData,
        array(
            'Select',
            'socialshare_enable_gridview1plusicon',
            array(
                'label' => "Enable plus (+) icon for social share buttons in Grid View",
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
            'show_item_count',
            array(
                'label' => 'Do you want to show products count in this widget?',
                'multiOptions' => array(
                    '1' => 'Yes',
                    '0' => 'No',
                ),
                'value' => '0',
            ),
        ),
        $titleTruncationGrid,
        $heightOfContainerGrid,
        $widthOfContainerGrid,
        array(
            'Text',
            'limit_data_grid',
            array(
                'label' => 'Count for Grid Views (number of products to show).',
                'value' => 20,
                'validators' => array(
                    array('Int', true),
                    array('GreaterThan', true, array(0)),
                )
            )
        ),
        array(
            'Select',
            'show_sale',
            array(
                'label' => 'Do you want to display SALE label on Products?',
                'multiOptions' => array(
                    '1' => 'Yes',
                    '0' => 'No',
                ),
                'value' => '0',
            ),
        ),

      )
    ),
  ),
   array(
    'title' => 'SES - Products - Cross-sell Products',
    'description' => 'Displays Cross-sell products on your website.',
    'category' => 'SES - Stores Marketplace - Products',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesproduct.cross-sell-products',
    'requirements' => array(
      'subject' => 'product',
    ),
    'adminForm' => array(
    'elements' => array(
        $showCustomData,
        array(
            'Select',
            'socialshare_enable_gridview1plusicon',
            array(
                'label' => "Enable plus (+) icon for social share buttons in Grid View",
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
        $titleTruncationGrid,
        $heightOfContainerGrid,
        $widthOfContainerGrid,
        array(
            'Text',
            'limit_data_grid',
            array(
                'label' => 'Count for Grid Views (number of products to show).',
                'value' => 20,
                'validators' => array(
                    array('Int', true),
                    array('GreaterThan', true, array(0)),
                )
            )
        ),
        array(
            'Select',
            'show_sale',
            array(
                'label' => 'Do you want to display SALE label on Products?',
                'multiOptions' => array(
                    '1' => 'Yes',
                    '0' => 'No',
                ),
                'value' => '0',
            ),
        ),

      )
    ),
  ),
	array(
		'title' => 'SES - Products - Profile Products',
		'description' => 'Displays a member\'s product entries on their profiles. The recommended page for this widget is "Member Profile Page"',
		'category' => 'SES - Stores Marketplace - Products',
		'type' => 'widget',
		'autoEdit' => true,
		'name' => 'sesproduct.profile-sesproducts',
		'requirements' => array(
			'subject' => 'user',
		),
		'adminForm' => 'Sesproduct_Form_Admin_Tabbed',
	),
    array(
		'title' => 'SES - Products - Wishlist Tabbed widget',
		'description' => 'Display all products on your website. The recommended page for this widget is "SES - Stores Marketplace - Products - Wishlist Tabbed widget".',
		'category' => 'SES - Stores Marketplace - Products',
		'type' => 'widget',
		'autoEdit' => true,
		'name' => 'sesproduct.wishlist-tabbed-widget',
		'requirements' => array(
			'subject' => 'user',
		),
		'adminForm' => 'Sesproduct_Form_Admin_WishlistTabbed',
	),
  array(
    'title' => 'SES - Products - Browse Products',
    'description' => 'Display all products on your website. The recommended page for this widget is "SES - Stores Marketplace - Products - Browse Products Page".',
    'category' => 'SES - Stores Marketplace - Products',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesproduct.browse-products',
    'requirements' => array(
      'subject' => 'product',
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
                'label' => "Enable plus (+) icon for social share buttons in List View",
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
                'label' => "Enable plus (+) icon for social share buttons in Grid View",
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
						'label' => 'Choose Product Display Criteria.',
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
						'label' => 'Do you want to show products count in this widget?',
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

                $DescriptionTruncationList,
                $DescriptionTruncationGrid,
                $DescriptionTruncationPinboard,

				$heightOfContainerList,
				$widthOfContainerList,
				$heightOfContainerGrid,
				$widthOfContainerGrid,

				$widthOfContainerPinboard,
				array(
					'Text',
					'limit_data_pinboard',
					array(
						'label' => 'Count for Pinboard View (number of products to show).',
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
						'label' => 'Count for Grid Views (number of products to show).',
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
						'label' => 'Count for List Views (number of products to show).',
						'value' => 20,
						'validators' => array(
							array('Int', true),
							array('GreaterThan', true, array(0)),
						)
					)
				),

                array(
                        'Select',
                        'show_sale',
                        array(
                            'label' => 'Do you want to display SALE label on Products?',
                            'multiOptions' => array(
                                '1' => 'Yes',
                                '0' => 'No',
                            ),
                            'value' => '0',
                        ),
                ),

	      $pagging,
      )
    ),
  ),
  array(
    'title' => 'SES - Products - Tabbed widget for Manage Products',
    'description' => 'This widget displays products created, favourite, liked, rated, etc by the member viewing the manage page. Edit this widget to configure various settings.',
    'category' => 'SES - Stores Marketplace - Products',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesproduct.manage-products',
    'requirements' => array(
      'subject' => 'product',
    ),
    'adminForm' => 'Sesproduct_Form_Admin_Tabbed',
  ),
  /*array(
    'title' => 'SES - Products - Product Profile Gutter Search',
    'description' => 'Displays a search form in the product profile gutter.',
    'category' => 'SES - Stores Marketplace - Products',
    'type' => 'widget',
    'name' => 'sesproduct.gutter-search',
  ),*/
  array(
    'title' => 'SES - Products - Profile Options for Products',
    'description' => 'Displays a menu of actions (edit, report, add to favourite, share, subscribe, etc) that can be performed on a product on its profile.',
    'category' => 'SES - Stores Marketplace - Products',
    'type' => 'widget',
    'name' => 'sesproduct.gutter-menu',
  ),
  array(
    'title' => 'SES - Products - Product Profile - Owner Photo',
    'description' => 'Displays the owner\'s photo on the product view page.',
    'category' => 'SES - Stores Marketplace - Products',
    'type' => 'widget',
    'name' => 'sesproduct.gutter-photo',
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
    'title' => 'SES - Products - Product Browse Search',
    'description' => 'Displays a search form in the product browse page as configured by you.',
    'category' => 'SES - Stores Marketplace - Products',
    'type' => 'widget',
    'name' => 'sesproduct.browse-search',
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
	      'verified' => 'Only Verified',
 	      'outOfStock' => 'Out of Stock',
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
	      'sponsored' => 'Only Sponsored',
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
	    'label' => "Show \'Search Products Keyword\' search field?",
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
		'price',
		array(
			'label' => "Show \'price\' search field?",
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
      'title' => 'SES - Products - Categories Cloud / Hierarchy View',
      'description' => 'Displays all categories of products in cloud or hierarchy view. Edit this widget to choose various other settings.',
      'category' => 'SES - Stores Marketplace - Products',
      'type' => 'widget',
      'name' => 'sesproduct.tag-cloud-category',
      'autoEdit' => true,
      'adminForm' => 'Sesproduct_Form_Admin_Tagcloudcategory',
  ),
  array(
    'title' => 'SES - Products - Product Profile - Similar Products',
    'description' => 'Displays products similar to the current product based on the product category. The recommended page for this widget is "SES - Stores Marketplace - Products - Product Profile Page".',
    'category' => 'SES - Stores Marketplace - Products',
    'type' => 'widget',
		'autoEdit' => true,
    'name' => 'sesproduct.similar-products',
    'adminForm' => array(
      'elements' => array (

//         array(
//         'Select',
//         'openViewType',
//         array(
//             'label' => "Choose the view type which you want to display by default. (Settings will apply, if you have selected more than one option in above tab.)",
//             'multiOptions' => array(
//             'list' => 'List View',
//             'grid' => 'Grid View',
//             ),
//             'value' => 'list',
//             )
//         ),
        array(
          'MultiCheckbox',
          'show_criteria',
          array(
            'label' => "Choose from below the details that you want to show for product in this widget.",
            'multiOptions' => array(
              'title' => 'Product Title',
              'description' => 'Description',
              'storeName' => 'Store Name & Photo',
              'rating' =>'Reviews & Rating',
              'addCart' => 'Add to Cart',
              'addWishlist' => 'Add to wishlist',
              'brand' => 'Brand Name',
              'price' =>'Price',
              'featuredLabel' => 'Featured Label',
              'sponsoredLabel' => 'Sponsored Label',
              'verifiedLabel' => 'Verified Label',
              'favouriteButton' => 'Favourite Button',
              'creationDate' => 'Show Publish Date',
              'likeButton' => 'Like Button',
              'category' => 'Category',
               'socialSharing' =>'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
              'like' => 'Likes Count',
              'comment' => 'Comments Count',
              'favourite' => 'Favourites Count',
              'view' => 'Views Count',
              'favourites' => 'Favourites',
              'location' => 'Location',
            ),
            'escape' => false,
          )
        ),
        array(
            'Text',
            'title_truncation_limit',
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
            'description_truncation_limit',
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
            'width',
            array(
                'label' => 'Enter the width of one block (in pixels).',
                'value' => '389',
            )
        ),
        array(
            'Text',
            'height',
            array(
                'label' => 'Enter the height of one block (in pixels).',
                'value' => '270',
            )
        ),
        $socialshare_enable_plusicon,
        $socialshare_icon_limit,
        array(
          'Select',
          'showLimitData',
          array(
            'label' => 'Do you want to allow users to view more similar products in this widget? (If you choose Yes, then users will see Next & Previous buttons to view more products.)',
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
      'title' => 'SES - Products - Product Profile - Tags',
      'description' => 'Displays all tags of the current product on Product Profile Page. The recommended page for this widget is "SES - Advanced Product - Product Profile Page".',
      'category' => 'SES - Stores Marketplace - Products',
      'type' => 'widget',
      'name' => 'sesproduct.profile-tags',
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
    'title' => 'SES - Products - Tags Horizontal View',
    'description' => 'Displays all tags of products in horizontal view. Edit this widget to choose various other settings.',
    'category' => 'SES - Stores Marketplace - Products',
    'type' => 'widget',
    'name' => 'sesproduct.tag-horizantal-products',
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
      'title' => 'SES - Products - Tags Cloud / Tab View',
      'description' => 'Displays all tags of products in cloud or tab view. Edit this widget to choose various other settings.',
      'category' => 'SES - Stores Marketplace - Products',
      'type' => 'widget',
      'name' => 'sesproduct.tag-cloud-products',
      'autoEdit' => true,
      'adminForm' => 'Sesproduct_Form_Admin_Tagcloudproduct',
  ),
//   array(
//       'title' => 'SES - Products - Browse All Tags',
//       'description' => 'Displays all products tags on your website. The recommended page for this widget is "SES - Stores Marketplace - Products - Browse Tags Page".',
//       'category' => 'SES - Stores Marketplace - Products',
//       'type' => 'widget',
//       'name' => 'sesproduct.tag-albums',
//   ),
  array(
    'title' => 'SES - Products - Product Profile - Advanced Share Widget',
    'description' => 'This widget allow users to share the current product on your website and on other social networking websites. The recommended page for this widget is "SES - Stores Marketplace - Products - Product Profile Page".',
    'category' => 'SES - Stores Marketplace - Products',
    'type' => 'widget',
    'name' => 'sesproduct.advance-share',
    'autoEdit' => true,
    'adminForm' => 'Sesproduct_Form_Admin_Share',
  ),
  array(
    'title' => 'SES - Products - Product of the Day',
    'description' => "This widget displays products of the day as chosen by you from the Edit Settings of this widget.",
    'category' => 'SES - Stores Marketplace - Products',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesproduct.of-the-day',
    'adminForm' => array(
	'elements' => array(
	 array(
		'MultiCheckbox',
		'show_criteria',
		array(
		    'label' => "Choose from below the details that you want to show for products in this widget.",
				'multiOptions' => array(
					'title' => 'Product Title',
					'like' => 'Likes Count',
					'view' => 'Views Count',
					'comment' => 'Comment Count',
					'favourite' => 'Favourites Count',
					'rating' => 'Rating Count',
                    'quickView' =>'Quick View',
					'storeName' => 'Store Name & Photo',
					'favouriteButton' => 'Favourite Button',
					'likeButton' => 'Like Button',
					'featuredLabel' => 'Featured Label',
					'verifiedLabel' => 'Verified Label',
					'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
					'productDesc' => 'Product Description',
					'brand' => 'Brand Name',
                    'category' => 'Category',
                    'addCart' => 'Add to Cart Button',
                    'price' =>'Price',
                    'discount' => 'Discount',
                    'addCompare'=>'Add to Compare',
                    'addWishlist' => 'Add to wishlists',
                    'stock' =>'Stock',
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
		    'label' => 'Product title truncation limit.',
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
	    'label' => 'Product description truncation limit.',
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
    'title' => 'SES - Products - Popular / Featured / Sponsored / Verified Products',
    'description' => "Displays products as chosen by you based on chosen criteria for this widget. The placement of this widget depends on the criteria chosen for this widget.",
    'category' => 'SES - Stores Marketplace - Products',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesproduct.featured-sponsored',
    'adminForm' => array(
      'elements' => array(
	array(
	  'Select',
	  'viewType',
	  array(
	    'label' => 'Choose the view type.',
	    'multiOptions' => array(
	      "list" => "List View",
	      "grid1" => "Grid View",
	    ),
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
			'label' => 'Duration criteria for the products to be shown in this widget',
			'multiOptions' => array(
				'' => 'All Products',
				'week' => 'This Week Products',
				'month' => 'This Month Products',
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
	    'label' => "Choose from below the details that you want to show for product in this widget.",
	    'multiOptions' => array(
	      'like' => 'Likes Count',
	      'comment' => 'Comments Count',
	      'favourite' => 'Favourites Count',
	      'view' => 'Views Count',
	      'title' => 'Product Title',
	      'storeName' => 'Store Name & photo',
	      'creationDate' => 'Show Publish Date',
	      'category' => 'Category',
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
		'label' => 'Do you want to allow users to view more product posters in this widget? (If you choose Yes, then users will see Next & Previous buttons to view more product posters.)',
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
	    'label' => 'Product title truncation limit.',
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
	    'label' => 'Product description truncation limit.',
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
	    'label' => 'Count (number of products to show).',
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
        'title' => 'SES - Products - Product Profile - Photos',
        'description' => 'Displays albums on product profile page. The recommended page for this widget is "SES - Stores Marketplace - Products - Product Profile Page".',
        'category' => 'SES - Stores Marketplace - Products',
        'type' => 'widget',
				'autoEdit' => true,
        'name' => 'sesproduct.profile-photos',
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
            'subject' => 'sesproduct',
        ),
    ),

    array(
        'title' => 'SES - Products - Photo View Page - Options',
        'description' => 'This widget enables you to choose various options to be shown on photo view page like Slideshow of other photos associated with same album as the current photo, etc.',
        'category' => 'SES - Stores Marketplace - Products',
        'type' => 'widget',
        'name' => 'sesproduct.photo-view-page',
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
  array(
    'title' => 'SES - Products - Product Profile - Videos',
    'description' => 'Displays videos on product profile page. The recommended page for this widget is "SES - Stores Marketplace - Products - Product Profile Page".',
    'category' => 'SES - Stores Marketplace - Products',
    'type' => 'widget',
    'name' => 'sesproduct.profile-videos',
    'autoEdit' => true,
    'adminForm' => 'Sesproduct_Form_Admin_Profilevideos',
  ),

  array(
      'title' => "SES - Products - Review Owner's Photo",
      'description' => 'This widget displays photo of the member who has written the current review. The recommended page for this widget is "SES - Stores Marketplace - Products - Review View Page".',
      'category' => 'SES - Stores Marketplace - Products',
      'type' => 'widget',
      'autoEdit' => true,
      'name' => 'sesproduct.review-owner-photo',
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
    'title' => 'SES - Products - Category Carousel',
    'description' => 'Displays Product Categories in attractive carousel in this widget. This widget should be placed on Product Browse Page, Home Page, Category Page etc',
    'category' => 'SES - Stores Marketplace - Products',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesproduct.category-carousel',
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
	      'most_product' => 'Categories with maximum products first',
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
	      'countProducts' => 'Product count in each category',
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
    'title' => 'SES - Products - Categories Icon View',
    'description' => 'Displays all categories of products in icon view with their icon. Edit this widget to configure various settings.',
    'category' => 'SES - Stores Marketplace - Products',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesproduct.product-category-icons',
    'adminForm' => array(
      'elements' => array(
	/*array(
	  'Text',
	  'titleC',
	  array(
	    'label' => 'Enter the title for this widget.',
	    'value' => 'Browse by Popular Categories',
	  )
	),*/
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
	      'most_product' => 'Categories with maximum products first',
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
	      'countProducts' => 'Product count in each category',
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
    'title' => 'SES - Products - Alphabetic Filtering of Products / Wishlists',
    'description' => "This widget displays all the alphabets for alphabetic filtering of products which will enable users to filter products on the basis of selected alphabet.",
    'category' => 'SES - Stores Marketplace - Products',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesproduct.alphabet-search',
    'defaultParams' => array(
      'title' => "",
    ),
  ),
  array(
    'title' => 'SES - Products - Product Profile - Breadcrumb',
    'description' => 'Displays breadcrumb for Product. This widget should be placed on the Advanced Product - View page of the selected content type.',
    'category' => 'SES - Stores Marketplace - Products',
    'type' => 'widget',
    'name' => 'sesproduct.breadcrumb',
    'autoEdit' => true,
  ),
	 array(
    'title' => 'SES - Products - Product Custom Field Info',
    'description' => 'Displays product custom fields for Product. This widget should be placed on the Advanced Product - View page of product.',
    'category' => 'SES - Stores Marketplace - Products',
    'type' => 'widget',
    'name' => 'sesproduct.product-info',
		'defaultParams' => array(
      'title' => "Custom Fields",
    ),
    'autoEdit' => false,
  ),
	array(
		'title' => 'SES - Products - Product Profile - Reviews	',
		'description' => 'Displays reviews on product profile page. The recommended page for this widget is "SES - Stores Marketplace - Products - Product Profile Page".',
		'category' => 'SES - Stores Marketplace - Products',
		'type' => 'widget',
		'name' => 'sesproduct.product-reviews',
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
		'title' => 'SES - Products - Review of the Day',
		'description' => "This widget displays review of the day as chosen by you from the \"Manage Reviews\" settings of this plugin.",
		'category' => 'SES - Stores Marketplace - Products',
		'type' => 'widget',
		'autoEdit' => true,
		'name' => 'sesproduct.review-of-the-day',
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
							'productTitle' => 'Product Title',
                            'date' => 'Date',
                            'price' =>'Price',
                            'category' => 'Category',
                            'reviewRatings' => 'Reviews and Ratings',
                            'brand' => 'Brand Name',
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
    'title' => 'SES - Products - Labels',
    'description' => 'This widget displays Featured, Sponsored and Verified labels on Product Profile Page. The recommended page for this widget is "SES - Stores Marketplace - Products - Product Profile Page".',
    'category' => 'SES - Stores Marketplace - Products',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesproduct.labels',
  ),

        array(
            'title' => 'SES - Products - Category Banner Widget',
            'description' => 'Displays a banner for categories. You can place this widget at browse page of category on your site.',
            'category' => 'SES - Stores Marketplace - Products',
            'type' => 'widget',
            'autoEdit' => true,
            'name' => 'sesproduct.banner-category',
            'requirements' => array(
                    'subject' => 'product',
            ),
            'adminForm' => 'Sesproduct_Form_Admin_Categorywidget',
        ),

	    array(
        'title' => 'SES - Products - Categories Square Block View',
        'description' => 'Displays all categories of products in square blocks. Edit this widget to configure various settings.',
        'category' => 'SES - Stores Marketplace - Products',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesproduct.product-category',
        'requirements' => array(
            'subject' => 'product',
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
                    'product_required',
                    array(
                        'label' => "Do you want to show only those categories under which atleast 1 product is posted?",
                        'multiOptions' => array(
                            '1' => 'Yes, show only categories with products',
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
                            'most_product' => 'Most Products Category First',
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
                            'countProducts' => 'Product count in each category',
                        ),
                    )
                ),
            ),
        ),
    ),
        array(
        'title' => 'SES - Products - Category View Page Widget',
        'description' => 'Displays a view page for categories. You can place this widget at view page of category on your site.',
        'category' => 'SES - Stores Marketplace - Products',
        'type' => 'widget',
        'name' => 'sesproduct.category-view',
        'requirements' => array(
            'subject' => 'product',
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
                            'countProduct' => 'Products count in each category',
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
                    'textProduct',
                    array(
                        'label' => 'Enter teh text for \'heading\' of this widget.',
                        'value' => 'Products we like',
                    )
                ),

            array(
                'Text',
                'height',
                array(
                    'label' => 'Enter the height of one block in  Views (in pixels).',
                    'value' => '270',
                )
            ),
            array(
                'Text',
                'width',
                array(
                    'label' => 'Enter the width of one block in Views (in pixels).',
                    'value' => '389',
                )
            ),
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show on each category block.",
                        'multiOptions' => array(
                            'featuredLabel' => 'Featured Label',
                            'sponsoredLabel' => 'Sponsored Label',
                            'like' => 'Likes',
                            'comment' => 'Comments',
                            'rating' => 'Rating Count',
                            'favourite'=>'Favourite',
                            'view' => 'Views',
                            'title' => 'Titles',
                            'description' => 'Show Description',
                            'creationDate' => 'Show Publish Date',
                            'brand' => 'Brand Name',
                            'stock' => 'Do you want to show Stock (In Stock || Out of Stock)',
                            'discount' => 'Discount',
                            'location' => 'Location',
                            'price' => 'Price',
                            'storeName' =>'Store Name & Photo',
                            'addCompare' => 'Add to compare',
                            'addWishlist' =>'Add to wishlist',
                            'addCart' => 'Add to cart',
                        ),
                    )
                ),
                $pagging,
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
                    'product_limit',
                    array(
                        'label' => 'count (number of products to show).',
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
                )
            )
        ),
    ),
    array(
        'title' => 'SES - Products - Product tags',
        'description' => 'Displays all product tags on your website. The recommended page for this widget is "SES - Advanced Product - Browse Tags Page".',
        'category' => 'SES - Stores Marketplace - Products',
        'type' => 'widget',
        'name' => 'sesproduct.tag-products',
         'adminForm' => array(
            'elements' => array(

            array(
            'Text',
            'show_count',
            array(
                'label' => 'Count (number of tags to show).',
                'value' => '10',
                'validators' => array(
                array('Int', true),
                array('GreaterThan', true, array(0)),
                )
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
                    'value' => '424242',
                )
            ),
            array(
            'Text',
            'textcolor',
                array(
                    'class' => 'SEScolor',
                    'label'=>'Choose text color on the button.',
                    'value' => '424242',
                )
            ),
        )),
    ),

      array(
        'title' => 'SES - Products - Product Locations',
        'description' => 'This widget displays products based on their locations in Google Map.',
        'category' => 'SES - Stores Marketplace - Products',
        'type' => 'widget',
        'name' => 'sesproduct.product-location',
            'autoEdit' => true,
    		'adminForm' => 'Sesproduct_Form_Admin_Location',
    ),

    	array(
    'title' => 'SES - Products - Popular / Featured / Sponsored / Verified Products Slideshow',
    'description' => "Displays slideshow of products as chosen by you based on chosen criteria for this widget. You can also choose to show Products of specific categories in this widget. The placement of this widget depends on the criteria chosen for this widget.",
    'category' => 'SES - Stores Marketplace - Products',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesproduct.featured-sponsored-verified-category-slideshow',
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
          '0' => 'All Products',
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
			'label' => 'Duration criteria for the products to be shown in this widget.',
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
          "most_rated" => "Most Rated",
	      "only_featured" => "Only Featured",
	      "only_sponsored" => "Only Sponsored",
	      "only_verified" => "Only Verified",
	      "cheapest" => "Cheapest",
	      "popular" => "Popular",
	      "expensive" => "Expensive",
	      "brand" => "Brand Name",
	      "tags" => "Tags",
	      "discount" => "Discount",

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
	    'label' => "Do you want to enable autoplay of products?",
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
	    'label' => 'Delay time for next product when you have enabled autoplay.',
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
	    'label' => "Choose from below the details that you want to show for products in this widget.",
	    'multiOptions' => array(
	      'like' => 'Likes Count',
	      'comment' => 'Comments Count',
	      'favourite' => 'Favourites Count',
	      'view' => 'Views Count',
	      'title' => 'Product Title',
	      'productPhoto' => 'Product Photo',
	      'productDesc' => 'Product Description',
	      'quickViewe' =>'Quick View',
          'rating' =>'Rating Count',
          'ratingStar' =>'Rating Stars',
          'featuredLabel' => 'Featured Label',
          'sponsoredLabel' => 'Sponsored Label',
          'verifiedLabel' => 'Verified Label',
          'favouriteButton' => 'Favourite Button',
          'likeButton' => 'Like Button',
	      'category' => 'Category',
	      'socialSharing' =>'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
	      'creationDate' => 'Show Publish Date',
	      'brand' => 'Brand Name',
	      'stock' => 'Do you want to show Stock (In Stock || Out of Stock)',
	      'discount' => 'Discount',
	      'location' => 'Location',
	      'price' => 'Price',
	      'storeNamePhoto' =>'Store Name & Photo',
	      'addCompare' => 'Add to compare',
	      'addWishlist' =>'Add to wishlist',
	      'addCart' => 'Add to cart',
	    ),
	    'escape' => false,

	  )
	),
  $socialshare_enable_plusicon,
  $socialshare_icon_limit,
  	array(
	  'Select',
	  'more_icon',
	  array(
	    'label' => 'Enable More Icon for social share buttons',
        'multiOptions' => array(
	      1=>'Yes',
	      0=>'No'
	    ),
	  )
	),
	array(
	  'Text',
	  'title_truncation',
	  array(
	    'label' => 'Product title truncation limit.',
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
	    'label' => 'Count (number of products to show).',
	    'value' => 5,
	    'validators' => array(
	      array('Int', true),
	      array('GreaterThan', true, array(0)),
	    )
	  )
	),
    )),
	),
  	  array(
    'title' => 'SES - Products - Product Profile - Photo',
    'description' => 'Displays a product photo widget. You can place this widget on product profile page only on your site.',
    'category' => 'SES - Stores Marketplace - Products',
    'type' => 'widget',
    'name' => 'sesproduct.product-photo',
    'requirements' => array(
      'subject' => 'product',
    ),
  ),

  array(
    'title' => 'SES - Products - Product Social Share Widget',
    'description' => 'Displays a product social share widget. You can place this widget on product profile page only on your site.',
    'category' => 'SES - Stores Marketplace - Products',
    'type' => 'widget',
    'name' => 'sesproduct.product-socialshare',
    'adminForm' => array(
			'elements' => array(
				array(
					'Radio',
					'socialshare_design',
					array(
						'label' => "Do you want this social share widget on product profile page ?",
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
      'subject' => 'product',
    ),
  ),
      array(
        'title' => 'SES - Products - Product Profile - Map',
        'description' => 'Displays a product location on map on it\'s profile.',
        'category' => 'SES - Stores Marketplace - Products',
        'type' => 'widget',
        'name' => 'sesproduct.product-map',
        'defaultParams' => array(
            'title' => 'Map',
            'titleCount' => true,
        ),
        'requirements' => array(
            'subject' => 'user',
        ),
    ),

  		array(
        'title' => 'SES - Products - Product Contact Information',
        'description' => 'Displays product contact information in this widget. The placement of this widget depends on the product profile page.',
        'category' => 'SES - Stores Marketplace - Products',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesproduct.product-contact-information',
        'adminForm' => array(
            'elements' => array(
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show in this widget.",
                        'multiOptions' => array(
                            'name' => 'Contact Name',
                            'email' => 'Contact Email',
                            'phone' => 'Contact Phone Number',
                            'facebook' =>'Contact Facebook',
                            'linkedin'=>'Contact Linkedin',
                            'twitter'=>'Contact Start Time',
                            'website'=>'Contact Website',

                        ),
                    )
                ),
            )
        ),
		),

	// New Widgets
	array(
    'title' => 'SES - Products - Product Information',
    'description' => 'Displays Information of Product.',
    'category' => 'SES - Stores Marketplace - Products',
    'type' => 'widget',
    'name' => 'sesproduct.product-information',
    'requirements' => array(
      'subject' => 'product',
    ),
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'Select',
          'design',
          array(
            'label' => "Chose Design",
            'multiOptions' => array(
              '1' => 'Design 1',
              '2' => 'Design 2',
              '3' => 'Design 3',
              '4' => 'Design 4',
            ),
            'value' => 1,
          ),
        ),
        array(
          'MultiCheckbox',
          'show_criteria',
          array(
            'label' => "Choose from below the details that you want to show for Product  in this widget.",
            'multiOptions' => array(
              //'availability'=>'Product availability',
              'title' => 'Product Title',
              'storeNamePhoto' =>'Store Name & Photo',
              'price' =>'Price',
              'discount' => 'discount',
              'brand'=>'Brand Name',
              'purchaseNote' => 'purchase Note',
              'productDetails' =>'Product Details',
              'paymentOpt' =>'Payment Option display for product',
              'addWishlist'=>'Add to Wishlist Button',
              'addCart' => 'Add to Cart Button',
              'addCompare' => 'Add to Compare Button',
              'featuredLabel' => 'Featured Label',
              'sponsoredLabel' => 'Sponsored Label',
              'verifiedLabel' => 'Verified Label',
              'socialSharing' =>'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
             'location' => 'Location',
             'view' => 'Views Count',
             'like' => 'Likes Count',
             'comment' => 'Comments Count',
             'favourite' => 'Favourites Count',
             'category' => 'Category',
             //'storeName' => 'Store Name & Photo',
             'likeButton' => 'Like Button',
             'commentButton' => 'Comments Button',
             'favouriteButton' => 'Favourite Button',
             'rating' => 'Reviews & Rating',
             'stock'=>'Stocks',
             'reviewButton' => 'Write a Review Button',
            ),
            'escape' => false,
          )
        ),
        $socialshare_icon_limit,
          array(
            'Select',
            'show_sale',
            array(
                'label' => 'Do you want to display SALE label on Products?',
                'multiOptions' => array(
                    '1' => 'Yes',
                    '0' => 'No',
                ),
                'value' => '0',
            ),
        ),
     ),
     ),
    ),
	array(
    'title' => 'SES - Products - My Cart',
    'description' => 'Displays Cart Items',
    'category' => 'SES - Stores Marketplace - Products',
    'type' => 'widget',
    'name' => 'sesproduct.my-cart',
    'requirements' => array(
      'subject' => 'product',
    ),
  ),
  array(
    'title' => 'SES - Products - Product Checkout',
    'description' => 'This widget displays the checkout page on your website.',
    'category' => 'SES - Stores Marketplace - Products',
    'type' => 'widget',
    'name' => 'sesproduct.product-checkout',
    'requirements' => array(
      'subject' => 'product',
    ),
  ),
  array(
    'title' => 'SES - Products - Product Compare',
    'description' => 'This widget displays the product compare page.',
    'category' => 'SES - Stores Marketplace - Products',
    'type' => 'widget',
    'name' => 'sesproduct.product-compare',
    'requirements' => array(
      'subject' => 'product',
    ),
    'adminForm' => array(
     'elements' => array(
     array(
        'MultiCheckbox',
        'show_criteria',
        array(
            'label' => "Choose the options that you want to be displayed in this widget.",
            'multiOptions' => array(
            'productTitle' => 'Product Title',
           // 'productPhoto' => 'Product Photos',
            'price' =>'Price',
            'productDesc' => 'Product Description',
            'category' => 'Category',
           // 'discount' => 'Discount',
            'stock' =>'Stock',
            'storeName' =>'Store Name',
            'addCart' => 'Add to Cart Button',
            'addWishlist' => 'Add to wishlist Button',
            'rating' => 'Reviews and Ratings',
            'brand' => 'Brand Name',
            //'offre' => 'Offer',
            //'totalProduct' => 'Product Count',
            'verifiedLabel' => 'Verified Label',
            'sponsoredLabel' => 'Sponsored Label',
            'featuredLabel' => 'Featured Label',
            'favouriteButton' => 'Favourite Button',
            'likeButton' => 'Like Button',
            'viewCount' => 'Views Count',
            'likeCount' => 'Like Count',
            'favouriteCount' => 'Favorites Count',
            'commentCount' => 'Comments Count',
            'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
            ),
            'escape' => false,
        )
     )
    )),
  ),
  array(
    'title' => 'SES - Products - Compare Fixed',
    'description' => 'This widget displays the products to be compared. The widget is shown in the Footer of your website. Place this widget in the Header of your website.',
    'category' => 'SES - Stores Marketplace - Products',
    'type' => 'widget',
    'name' => 'sesproduct.compare-fixed',
    'requirements' => array(
      'subject' => 'product',
    ),
  ),

  array(
        'title' => 'SES - Products - Browse Wishlists',
        'description' => 'Displays all wishlists on your website.  The recommended page for this widget is "Advanced Product - Browse Wishlists".',
        'category' => 'SES - Stores Marketplace - Products',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesproduct.browse-wishlists',
        'adminForm' => array(
            'elements' => array(
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
                        ),
                        'value' => 'creation_date',
                    )
                ),
                array(
                    'Select',
                    'viewMore',
                    array(
                        'label' => 'Do you want the wishlists to be auto-loaded when users scroll down the page?',
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
                        'label' => 'Choose the options that you want to be displayed in this widget.',
                        'multiOptions' => array(
                            "viewCount" => "Views Count",
                            "title" => "Wishlists Title",
                            "date" => "Creation Date",
//                             "postedby" => "Posted By",
//                             "share" => "Share Button",
                            'favouriteButton'=>'Favourite Button',
                            'favouriteCount'=>'Favourite counts',
                            'featuredLabel'=>'Featured label',
                            'sponsoredLabel'=>'Sponsored label',
                            'likeButton'=>'Like Button',
                            'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                            'likeCount'=>'Like Counts',
                            'showProductList' => "Show products of each wishlists",
                        ),
                        'escape' => false,
                    ),
                ),
                $socialshare_enable_plusicon,
                $socialshare_icon_limit,
								 /* array(
                    'Text',
                    'description_truncation',
                    array(
                        'label' => 'Enter the description truncation of wishlists (numeric value).',
                        'value' => '60',
                    )
                ),*/
                array(
                    'Text',
                    'itemCount',
                    array(
                        'label' => 'Count (number of content to show)',
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
        'title' => 'SES - Products - Wishlists Browse Search',
        'description' => 'Displays a search form in the wishlist browse page. Edit this widget to choose the search option to be shown in the search form.',
        'category' => 'SES - Stores Marketplace - Products',
        'autoEdit' => true,
        'type' => 'widget',
        'name' => 'sesproduct.wishlists-browse-search',
        'adminForm' => array(
            'elements' => array(
                array(
                    'MultiCheckbox',
                    'searchOptionsType',
                    array(
                        'label' => "Choose from below the searching options that you want to show in this widget.",
                        'multiOptions' => array(
                            'searchBox' => 'Search Wishlists',
                            'view' => 'View',
                            'show' => 'List By',
                            'brand' => 'Brand Name',
                            'category' => 'Category',
                        ),
                    )
                ),
            )
        ),
    ),
    array(
        'title' => 'SES - Products - Popular Wishlists',
        'description' => 'Displays wishlists based on chosen criteria for this widget. The placement of this widget depends on the criteria chosen for this widget.',
        'category' => 'SES - Stores Marketplace - Products',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesproduct.popular-wishlists',
        'adminForm' => array(
            'elements' => array(
                array(
                    'Radio',
                    'showOptionsType',
                    array(
                        'label' => "Show",
                        'multiOptions' => array(
                            'all' => 'Popular Wishlist [With this option, place this widget anywhere on your website. Choose criteria from "Popularity Criteria" setting below.]',
                            'recommanded' => 'Recommended Wishlist [With this option, place this widget anywhere on your website.]',
                            'other' => 'Member’s Other Wishlists [With this option, place this widget on SES - Stores Marketplace - Products - Wishlist View Page.]',
                        ),
                        'value' => 'all',
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
                            'like_count' => 'Most Liked',
                            'creation_date' => 'Most Recent',
                            'modified_date' => 'Recently Updated',
                            'favourite_count' => "Most Favourite",
                            'product_count' => "Maximum Products",
                            'most_rated' => 'Most Rated',
                            'sponsored' => 'sponsored',
                            'verified' => 'Verified',
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
                            "title" => "Wishlist Title",
                            "viewCount" => "Views Count",
                            "likeCount" => "Likes Count",
                            "favouriteCount" => "Favorite Count",
                            "productCount" => "Products Count",
                            "songsListShow" => "Product of each Wishlist",
                        ),
                    )
                ),
                $widthOfContainer,
                array(
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
                ),
            )
        ),
    ),
     array(
        'title' => 'SES - Products - Wishlist View Page',
        'description' => 'This widget displays wishlist details and various options. The recommended page for this widget is "Advanced Video - Wishlist View Page".',
        'category' => 'SES - Stores Marketplace - Products',
        'type' => 'widget',
        'name' => 'sesproduct.wishlist-view-page',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'MultiCheckbox',
                    'informationWishlist',
                    array(
                        'label' => 'Choose from below the details that you want to show for "Wishlist" shown in this widget.',
                        'multiOptions' => array(
                            "editButton" => "Edit Button Wishlist",
                            "deleteButton" => "Delete Button Wishlist",
                            "viewCountPlaylist" => "Views Count Wishlist",
                            'likeCountWishlist' =>'Like Counts',
                            'wishlistTitle' => 'Wishlist Title',
                            'wishlistPhoto' => 'Wishlist Photo',
                            'wishlistOwner' => "Owner's Name",
                            'wishlistDesc' =>'Description',
                            'wishlistCreation' => 'Wishlist Creation',
                            'totalProduct' =>'Product Count',
                            'favouriteCountWishlist'=>'Favourite Count Wishlist',
                        ),
                        'escape' => false,
                    ),
                ),
            )
        ),
    ),

    array(
        'title' => 'SES - Products - Custom Offer',
        'description' => 'For Welcome Page',
        'category' => 'SES - Stores Marketplace - Products',
        'type' => 'widget',
        'name' => 'sesproduct.custom-offer',
        'requirements' => array(
            'subject' => 'product',
         ),
         'autoEdit'=>true,
        'adminForm' => array(
        'elements' => array(
            array(
                'Text',
                'heading',
                array(
                    'label' => 'Enter Heading of Offer.',
                )
            ),
            array(
                'Text',
                'button_title',
                array(
                    'label' => 'Enter Title of Button.',
                )
            ),
          array(
            'Select',
            'show_timer',
            array(
                'label' => "Do you want to show timer in Offer (This timer will be show how many time left to end of Offer).",
                'multiOptions' => array(
                'yes' => 'Yes',
                'no' => 'No',
                ),
                'escape' => false,
             )
            ),
            array(
                'Select',
                'design',
                array(
                'label' => 'Choose the options that you want to be displayed in this widget.',
                'multiOptions' => array(
                    "design1" => "Design 1",
                    "design2" => "Design 2",
                    "design3" => "Design 3",
                    "design4" => "Design 4",
                    "design5" => "Design 5",
                    )
                ),
            ),
            array(
                'Select',
                'offer_id',
                array(
                    'label' => 'Choose the Offer to be shown in this widget.',
                    'multiOptions' => $arrayGallery,
                    'value' => 1,
                )
            ),
            array(
                'Text',
                'itemCount',
                array(
                    'label' => 'Count (number of content to show)',
                    'value' => 10,
                    'validators' => array(
                        array('Int', true),
                        array('GreaterThan', true, array(0)),
                    ),
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
         ),
        ),

      ),

    array(
      'title' => 'SES - Products  - Album View Page - Options',
      'description' => "This widget enables you to choose various options to be shown on album view page like Likes count, Like button, etc.",
      'category' => 'SES - Stores Marketplace - Products',
      'type' => 'widget',
      'autoEdit' => true,
      'name' => 'sesproduct.album-view-page',
      'adminForm' => 'Sesproduct_Form_Admin_Albumviewpage',
    ),

    array(
		'title' => 'SES - Products - Album Profile - Breadcrumb',
		'description' => 'Displays breadcrumb for Albums. This widget should be placed on the SES - Products - Album Profile Page.',
		'category' => 'SES - Stores Marketplace - Products',
		'autoEdit' => true,
		'type' => 'widget',
		'name' => 'sesproduct.album-breadcrumb',
		'autoEdit' => true,
    ),

    array(
        'title' => 'SES - Products - Profile Product Review',
        'description' => 'This widget display review of user. This widget placed on "Product View Page" only.',
        'category' => 'SES - Stores Marketplace - Products',
        'type' => 'widget',
       'name' => 'sesproduct.product-reviews',
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
                        )
                    ),
                )
            ),
        ),
    ),


    array(
        'title' => 'SES - Products - Profile Review',
        'description' => 'Displays a product\'s review entries on their profile. This widge is placed on "SES - Advanced Product - Review View Page" only.',
        'category' => 'SES - Stores Marketplace - Products',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesproduct.profile-review',
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
                            'parameter' => 'Review Parameters',
                            'rating' => 'Rating Stars',
                            'productTitle' => 'Product Title',
                            'price' =>'Price',
                            'stock' =>'Stock',
                            'storeName' => 'Store Name & Photo',
                            'addCart' => 'Add to Cart Button',
                            'addWishlist' => 'Add to wishlist Button',
                            'addCompare' =>'Add to Compare Button',
                            'reviewRating' => 'Reviews and Ratings',
                            'brand' => 'Brand Name',
                            'offer' =>'Offer',
                            'totalProduct' =>'Product count',
                        )
                    ),
                )
            ),
        ),
    ),
    array(
        'title' => 'SES - Products - Review Profile Options',
        'description' => 'Displays a menu of actions (edit, report, share, etc) that can be performed on a content on its profile. The recommended page for this widget is "SES - Stores Marketplace - Products - Review View Page".',
        'category' => 'SES - Stores Marketplace - Products',
        'type' => 'widget',
        'name' => 'sesproduct.review-profile-options',
        'autoEdit' => false,
    ),
);
?>
