<?php
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
      'validators' => array(
          array('Int', true),
          array('GreaterThan', true, array(0)),
      ),
    ),
  );
$viewType = array(
    'MultiCheckbox',
    'enableTabs',

    array(
        'label' => "Choose the View Type.",
        'multiOptions' => array(
            'list' => 'List View',
            'grid' => 'Grid View',
        ),
    )
);
$defaultType = array(
    'Select',
    'openViewType',
    array(
        'label' => "Default open View Type (apply if select Both View option in above tab)?",
        'multiOptions' => array(
            'list' => 'List View',
            'grid' => 'Grid View',
        ),
        'value' => 'list',
    )
);
$showCustomData = array(
    'MultiCheckbox',
    'show_criteria',
    array(
        'label' => "Data show in widget ?",
        'multiOptions' => array(
            'featuredLabel' => 'Featured Label',
            'sponsoredLabel' => 'Sponsored Label',
            'verifiedLabel' => 'Verified Label',
            'favouriteButton' => 'Favourite Button',
            'likeButton' => 'Like Button',
            'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
            'like' => 'Likes Count',
            'comment' => 'Comments Count',
            'favourite' => 'Favourite Count',
            //'rating' => 'Ratings',
            'title' => 'Title',
            'category' => 'Category',
            'by' => 'Item Owner Name',
            'listdescription' => 'Description (List View)',
            'griddescription' => 'Description (Grid View)',
            'profile' => 'Owner Photo',
            'docType' => 'Document Type',
            'creationDate' => 'Creation Date',
            'view' => 'View Counts',
        ),
        'escape' => false,
    )
);
$limitData = array(
    'Text',
    'limit_data',
    array(
        'label' => 'count (number of documents to show).',
        'value' => 20,
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    )
);
$pagging = array(
    'Radio',
    'pagging',
    array(
        'label' => "Do you want the documents to be auto-loaded when users scroll down the page?",
        'multiOptions' => array(
            'button' => 'View more',
            'auto_load' => 'Auto Load',
            'pagging' => 'Pagination'
        ),
        'value' => 'auto_load',
    )
);
$titleTruncationList = array(
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
);
$titleTruncationGrid = array(
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
);
$DescriptionTruncationList = array(
    'Text',
    'description_truncation_list',
    array(
        'label' => 'Description truncation limit for List View.',
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
        'label' => 'Description truncation limit for Grid View.',
        'value' => 45,
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    )
);
$heightOfContainer = array(
    'Text',
    'height',
    array(
        'label' => 'Enter the height of List block (in pixels).',
        'value' => '160',
    )
);
$widthOfContainer = array(
    'Text',
    'width',
    array(
        'label' => 'Enter the width of List block (in pixels).',
        'value' => '250',
    )
);
$heightOfGridPhotoContainer = array(
    'Text',
    'photo_height',
    array(
        'label' => 'Enter the height of grid photo block (in pixels).',
        'value' => '160',
    )
);
$widthOfGridPhotoContainer = array(
    'Text',
    'photo_width',
    array(
        'label' => 'Enter the width of grid photo block (in pixels).',
        'value' => '250',
    )
);
$heightOfGridInfoContainer = array(
    'Text',
    'info_height',
    array(
        'label' => 'Enter the height of grid info block (in pixels).',
        'value' => '160',
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
return array(
    array(
        'title' => 'SES - Documents Sharing - Document Profile - Advanced Share Widget',
        'description' => 'This widget allow users to share the current document on your website and on other social networking websites. The recommended page for this widget is "SES - Documents Sharing - Document Profile Page".',
        'category' => 'Documents Sharing Plugin',
        'type' => 'widget',
        'name' => 'sesdocument.advance-share',
        'autoEdit' => true,
        'adminForm' => 'Sesdocument_Form_Admin_Share',
    ),
    array(
        'title' => 'SES - Documents Sharing - Category View Page for All Category Levels',
        'description' => 'Displays banner, 2nd-level or 3rd level categories, documents associated with the current categor\'s view page.',
        'category' => 'Documents Sharing Plugin',
        'type' => 'widget',
        'name' => 'sesdocument.category-view',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
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
                array('Text', "subcategory_title", array(
                    'label' => "Sub-Categories Title for documents",
                    'value'=>'Sub-Categories of this catgeory',
                )),
                array(
                    'MultiCheckbox',
                    'show_subcatcriteria',
                    array(
                        'label' => "Choose from below the details that you want to show on each category block.",
                        'multiOptions' => array(
                            'title' => 'Category title',
                            'icon' => 'Category icon',
                            'countDocuments' => 'Document count in each category',
                        ),
                    )
                ),
                array(
                    'Text',
                    'heightSubcat',
                    array(
                        'label' => 'Enter the height of one 2nd-level or 3rd level category\'s block (in pixels).',
                        'value' => '160px',
                    )
                ),
                array(
                    'Text',
                    'widthSubcat',
                    array(
                        'label' => 'Enter the width of one 2nd-level or 3rd level category\'s block (in pixels).',
                        'value' => '250px',
                    )
                ),
                array('Select', "show_popular_documents", array(
                    'label' => "Do you want to show popular documents in  banner widget",
                    'multiOptions'=>array('1'=>'Yes,want to show popular document',0=>'No,don\'t want to show popular documents'),
                    'value'=>1,
                  )),
                array('Text', "pop_title", array(
                    'label' => "Title for documents",
                    'value'=>'Popular Documents',
                )),

                array(
                  'Select',
                  'info',
                  array(
                      'label' => "choose criteria by which document shown in banner widget.",
                      'multiOptions' => array(
                          'creationSPdate' => 'Recently Created',
                          'mostSPviewed' => 'Most Viewed',
                          'mostSPliked' => 'Most Liked',
                          'mostSPcommented' => 'Most Commented',
                          'mostSPrated' => 'Most Rated',
                          'favouriteSPcount' => 'Most Favourite',
                          'featured' => 'Only Featured',
                          'sponsored' => 'Only Sponsored',
                          'verified' => 'Only Verified'
                      ),
                      'value'=>'creationSPdate',
                  )
                ),

                array('Text', "document_title", array(
                    'label' => "Documents Title for documents",
                    'value'=>'Documents of this catgeory',
                )),
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show on each document block.",
                        'multiOptions' => array(
                            'featuredLabel' => 'Featured Label',
                            'sponsoredLabel' => 'Sponsored Label',
                            'like' => 'Likes Count',
                            'comment' => 'Comments Count',
                                                        'favouriteButton' => 'Favourite Button',
                            'likeButton' => 'Like Button',

                                  'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                            'verifiedLabel' => 'Verified Label',

                            'rating' => 'Rating Stars',
                            'view' => 'Views Count',
                            'title' => 'DocumentTitle',
                            'by' => 'Document Owner\'s Name',
                            'favourite' => 'Favourites Count',
                        ),
                        'escape' => false,
                    )
                ),
                array(
                    'Radio',
                    'pagging',
                    array(
                        'label' => "Do you want the documents to be auto-loaded when users scroll down the page?",
                        'multiOptions' => array(
                            'auto_load' => 'Yes, Auto Load.',
                            'button' => 'No, show \'View more\' link.',
                            'pagging' => 'No, show \'Pagination\'.'
                        ),
                        'value' => 'auto_load',
                    )
                ),
                array(
                    'Text',
                    'document_limit',
                    array(
                        'label' => 'count (number of documents to show).',
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
                        'label' => 'Enter the height of one document block (in pixels). ',
                        'value' => '160px',
                    )
                ),
                array(
                    'Text',
                    'width',
                    array(
                        'label' => 'Enter the width of one document block (in pixels).',
                        'value' => '160px',
                    )
                )
            )
        ),
    ),
    array(
        'title' => 'SES - Documents Sharing - Document Category Block',
        'description' => 'Displays document categories in block view with their icon, and statistics. We recommend you to place this widget on "Browse Categories Page", but if you want, then you can place this widget on any widgetized page as per your requirement.',
        'category' => 'Documents Sharing Plugin',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesdocument.document-category',
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
                            'most_document' => 'Categories with maximum Documents first',
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
                            'icon' => 'Category icon',
                            'countDocuments' => 'Document count in each category',
                        ),
                    )
                )
            ),
        ),
    ),
    array(
      'title' => 'SES - Documents Sharing -  Category Banner Widget',
      'description' => 'Displays a banner for categories. You can place this widget at browse page of category on your site.',
      'category' => 'Documents Sharing Plugin',
      'type' => 'widget',
      'autoEdit' => true,
      'name' => 'sesdocument.banner-category',
      'adminForm' => 'Sesdocument_Form_Admin_Categorywidget',
    ),
    array(
        'title' => 'SES - Documents Sharing - Category Based Documents Slideshow',
        'description' => 'Displays documents in slideshow on the basis of their categories. This widget can be placed any where on your website.',
        'category' => 'Documents Sharing Plugin',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesdocument.category-associate-document',
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'view_type',
                    array(
                        'label' => "Select the view type.",
                        'multiOptions' => array(
                            '1' => 'Slideshow',
                            '2' => 'Grid View',

                        ),
                        'value' => 1,
                    ),
                ),
                array('Text', "photo_height", array(
                    'label' => 'Enter the height of grid photo block (in pixels).',
                    'value' => '160',
                )),
                array('Text', "photo_width", array(
                    'label' => 'Enter the width of grid photo block  (in pixels).',
                    'value' => '250',
                )),

                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show for documents in this widget.",
                        'multiOptions' => array(
                            'title' => 'Document Title',
                            'description' => 'Document Description',
                            'category'=>'Show Category',
                            'like' => 'Likes Count',
                            'comment' => 'Comments Count',
                            'favourite' => 'Favourites Count',
                            'featuredLabel' => 'Featured Label',
                            'verifiedLabel' => 'Verified Label',
                            'sponsoredLabel' => 'Sponsored Label',
                            //'eventPhoto' => 'Current Event\'s Main Photo',
                            'photoThumbnail' => 'Document Type below category name',
                            'favouriteButton' => 'Favourite Button',
                            'likeButton' => 'Like Button',

                            'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',

                            'rating' => 'Rating Stars',
                        ),
                        'escape' => false,
                    )
                ),

                $socialshare_enable_plusicon,
                $socialshare_icon_limit,
                $heightOfGridPhotoContainer,
                $widthOfGridPhotoContainer,

                array(
                    'Radio',
                    'pagging',
                    array(
                        'label' => "Do you want the documents to be auto-loaded when users scroll down the page?",
                        'multiOptions' => array(
                            'auto_load' => 'Yes, Auto Load.',
                            'button' => 'No, show \'View more\' link.',
                            'pagging' => 'No, show \'Pagination\'.'
                        ),
                        'value' => 'auto_load',
                    )
                ),
                array(
                    'Select',
                    'count_document',
                    array(
                        'label' => "Show documents count in each category.",
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
                            'alphabetical' => 'Alphabetical order',
                            'most_document' => 'Categories with maximum documents first',
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
                    'document_limit',
                    array(
                        'label' => 'count (number of documents to show in each category).',
                        'value' => '10',
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
                            'left' => 'Left',
                            'right' => 'Right'
                        ),
                    ),
                ),
                array(
                    'Text',
                    'title_truncation',
                    array(
                        'label' => 'Document title truncation limit.',
                        'value' => '150',
                    )
                ),
                array(
                    'Text',
                    'description_truncation',
                    array(
                        'label' => 'Document description truncation limit.',
                        'value' => '200',
                    )
                ),
            )
        ),
    ),
    array(
    'title' => 'SES - Documents Sharing - Browse Documents',
    'description' => 'Display all documents on your website. The recommended page for this widget is "SES - Documents Sharing - Browse Documents Page".',
    'category' => 'Documents Sharing Plugin',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesdocument.browse-documents',
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
					'sort',
					array(
						'label' => 'Choose Document Display Criteria.',
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
						),
					),
						'value' => 'most_liked',
				),
				array(
					'Select',
					'show_item_count',
					array(
						'label' => 'Do you want to show documents count in this widget?',
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
						'label' => 'Count for Grid Views (number of documents to show).',
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
						'label' => 'Count for List Views (number of documents to show).',
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
       'title' => 'SES - Documents Sharing - Document Navigation Menu',
       'description' => 'Displays a menu in all pages.',
       'category' => 'Documents Sharing Plugin',
       'type' => 'widget',
       'name' => 'sesdocument.browse-menu',
       'requirements' => array(
            'no-subject',
        ),
    ),


    array(
        'title' => 'SES - Documents Sharing Plugin - Tabbed widget for Popular Documents',
        'description' => 'Displays a tabbed widget for popular documents on your website based on various popularity criterias. Edit this widget to choose tabs to be shown in this widget. This widget can be placed anywhere on your website.',
        'category' => 'Documents Sharing Plugin',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesdocument.tabbed-widget-document',
        'adminForm' => 'Sesdocument_Form_Admin_Tabbed',
    ),

        array(
        'title' => 'SES - Documents Sharing - Featured / Sponsored / Verified Documents',
        'description' => "Displays documents as chosen by you based on chosen criteria for this widget. The placement of this widget depends on the criteria chosen for this widget.",
        'category' => 'Documents Sharing Plugin',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesdocument.featured-sponsored',
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'viewType',
                    array(
                        'label' => "View Type",
                        'multiOptions' => array(
                            'list' => 'List View',
                            'gridInside' => 'Grid View',

                        ),
                    )
                ),
                                  array(
                    'Select',
                    'gridInsideOutside',
                    array(
                        'label' => "Grid View Inside/Outside (setting work only if you select \"Grid View\" in above setting) ",
                        'multiOptions' => array(
                            'in' => 'Inside View',
                            'out' => 'Outside View',
                        ),
                                                'value'=>'in'
                    )
                ),
                                 array(
                    'Select',
                    'mouseOver',
                    array(
                        'label' => "Show Grid View Data on Mouse Over (setting work only if you select \"Inside View\" in above setting) ",
                        'multiOptions' => array(
                            'over' => 'Yes,show data on Mouse Over',
                            '' => 'No,don\'t show data on Mouse Over',
                        ),
                                                'value'=>'over',
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
                            '6' => 'Only Verified',
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
                            "creation_date" => "Recently Created",

                            "most_liked" => "Most Liked",
                            "most_rated" => "Most Rated",
                            "most_commented" => "Most Commented",
                            "favourite_count" => "Most Favourite",
                            "most_viewed"=>"Most Viewed",

                        )
                    ),
                    'value' => 'recently_updated',
                ),
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show for document in this widget.",
                        'multiOptions' => array(
                            'title' => 'Document Title',
                            'by' => 'Owner\'s Name',
                            'category' => 'Category',
                            'like' => 'Likes Count',
                            'comment' => 'Comments Count',
                            'view' => 'Views Count',
                            'favourite' => 'Favourite Count',

                            'rating' => 'Ratings',
                            'featuredLabel' => 'Featured Label',
                            'sponsoredLabel' => 'Sponsored Label',
                            'verifiedLabel' => 'Verified Label',
                            'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                            'likeButton' => 'Like Button',
                            'favouriteButton' => 'Favourite Button',

                        ),
                        'escape' => false,
                    ),
                ),
                $socialshare_enable_plusicon,
                $socialshare_icon_limit,
                $titleTruncationGrid,
                $titleTruncationList,
                array(
                    'Text',
                    'height',
                    array(
                        'label' => 'Enter the height of one document block (in pixels).',
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
                        'label' => 'Enter the width of one document block (in pixels).',
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
                        'label' => 'Count (number of document to show).',
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
        'title' => 'SES - Documents Sharing - Featured / Sponsored / Verified Documents Carousel',
        'description' => "Displays documents as chosen by you based on chosen criteria for this widget. The placement of this widget depends on the criteria chosen for this widget.",
        'category' => 'Documents Sharing Plugin',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesdocument.featured-sponsored-carousel',
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'criteria',
                    array(
                        'label' => "Display Content",
                        'multiOptions' => array(
                            '5' => 'All including Featured and Sponsored',
                            '1' => 'Only Featured',
                            '2' => 'Only Sponsored',
                            '6' => 'Only Verified',
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
                            "creation_date" => "Recently Created",
                            "most_liked" => "Most Liked",
                            "most_rated" => "Most Rated",
                            "most_commented" => "Most Commented",
                            "favourite_count" => "Most Favourite",
                            "most_viewed"=>"Most Viewed" ,
                        )
                    ),
                    'value' => 'creation_date',
                ),
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show for document in this widget.",
                        'multiOptions' => array(
                            'title' => 'Document Title',
                            'by' => 'Owner\'s Name',
                            'category' => 'Category',
                            'like' => 'Likes Count',
                            'comment' => 'Comments Count',
                            'favourite' => 'Favourite Count',
                            'rating' => 'Ratings',
                            'featuredLabel' => 'Featured Label',
                            'sponsoredLabel' => 'Sponsored Label',
                            'verifiedLabel' => 'Verified Label',
                            'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                            'likeButton' => 'Like Button',
                            'favouriteButton' => 'Favourite Button',
                            'profile' => 'Owner Photo',
                            'creationDate' => 'Creation Date',
                            'view' => 'View Counts',
                        ),
                        'escape' => false,
                    ),
                ),
                $socialshare_enable_plusicon,
                $socialshare_icon_limit,
                array(
                    'Select',
                    'gridInsideOutside',
                    array(
                        'label' => "View Inside/Outside",
                        'multiOptions' => array(
                            'in' => 'Inside View',
                            'out' => 'Outside View',
                        ),
                        'value'=>'in'
                    )
                ),
                array(
                    'Select',
                    'mouseOver',
                    array(
                        'label' => "Show  Data on Mouse Over (setting work only if you select \"Inside View\" in above setting) ",
                        'multiOptions' => array(
                            'over' => 'Yes,show data on Mouse Over',
                            '' => 'No,don\'t show data on Mouse Over',
                        ),
                        'value'=>'over',
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
                        'label' => 'Enter the height of one document block (in pixels).',
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
                        'label' => 'Enter the width of one document block (in pixels).',
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
                        'label' => 'Count (number of document to show).',
                        'value' => 5,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                array(
                    'Text',
                    'title_truncation',
                    array(
                        'label' => 'Title truncation limit .',
                        'value' => 45,
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
    'title' => 'SES - Documents Sharing - Popular / Featured / Sponsored / Verified Documents Slideshow',
    'description' => "Displays slideshow of documents as chosen by you based on chosen criteria for this widget. You can also choose to show Documents of specific categories in this widget. The placement of this widget depends on the criteria chosen for this widget.",
    'category' => 'Documents Sharing Plugin',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesdocument.featured-sponsored-verified-category-slideshow',
    'adminForm' => array(
      'elements' => array(
    array(
	  'Select',
	  'criteria',
	  array(
	    'label' => "Display Content",
	    'multiOptions' => array(
          '0' => 'All Documents',
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
			'label' => 'Duration criteria for the documents to be shown in this widget.',
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
	    'label' => "Do you want to enable autoplay of documents?",
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
	    'label' => 'Delay time for next document when you have enabled autoplay.',
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
	    'label' => "Choose from below the details that you want to show for documents in this widget.",
	    'multiOptions' => array(
            'like' => 'Likes Count',
            'comment' => 'Comments Count',
            'favourite' => 'Favourites Count',
            'view' => 'Views Count',
            'title' => 'Document Title',
            'by' => 'Document Owner\'s Name',
            'featuredLabel' => 'Featured Label',
            'sponsoredLabel' => 'Sponsored Label',
            'verifiedLabel' => 'Verified Label',
            'favouriteButton' => 'Favourite Button',
            'likeButton' => 'Like Button',
            'category' => 'Category',
            'socialSharing' =>'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
            'likeButton' => 'Like Button',
            'favouriteButton' => 'Favourite Button',
            'creationDate' => 'Show Creation Date',
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
	    'label' => 'Document title truncation limit.',
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
	    'label' => 'Count (number of documents to show).',
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
		'title' => 'SES - Documents Sharing - Profile Documents',
		'description' => 'Displays a member\'s document entries on their profiles. The recommended page for this widget is "Member Profile Page"',
		'category' => 'Documents Sharing Plugin',
		'type' => 'widget',
		'autoEdit' => true,
		'name' => 'sesdocument.profile-sesdocuments',
		'requirements' => array(
			'subject' => 'user',
		),
		'adminForm' => 'Sesdocument_Form_Admin_Tabbed',
	),
    array(
        'title' => 'SES - Documents Sharing - Manage Page Widget',
        'description' => 'Displays a manage page widget for documents. You can place this widget on document manage on your site.',
        'category' => 'Documents Sharing Plugin',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesdocument.manage-documents',
        'adminForm' => 'Sesdocument_Form_Admin_Managetabbed',
    ),
    array(
        'title' => 'SES - Documents Sharing - Document Browse Search',
        'description' => 'Displays a search form in the Document browse page.',
        'category' => 'Documents Sharing Plugin',
        'type' => 'widget',
        'name' => 'sesdocument.browse-search',
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
            'mostSPfavourite' => 'Most Favourite',
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
            'mostSPfavourite' => 'Most Favourite',
            'featured' => 'Only Featured',
            'sponsored' => 'Only Sponsored',
            'verified' => 'Only Verified'
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
            'label' => "Show \'Search Documents Keyword\' search field?",
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

        )
        ),
    ),
    array(
        'title' => 'SES - Documents Sharing Plugin - Document Browse Quick Menu',
        'description' => 'Displays a small menu in the document browse page.',
        'category' => 'Documents Sharing Plugin',
        'type' => 'widget',
        'name' => 'sesdocument.browse-menu-quick',
        'autoEdit' => true,
        'requirements' => array(
            'no-subject',
        ),
    ),

    array(
        'title' => 'SES - Documents Sharing - Tags Cloud / Tab View',
        'description' => 'Displays all tags of documents in cloud view. Edit this widget to choose various other settings.',
        'category' => 'Documents Sharing Plugin',
        'type' => 'widget',
        'name' => 'sesdocument.tag-cloud',
        'autoEdit' => true,
        'adminForm' => 'Sesdocument_Form_Admin_Tagcloud',
    ),
    array(
        'title' => 'SES - Documents Sharing - Document tags',
        'description' => 'Displays all document tags on your website. The recommended page for this widget is "SES - Documents Sharing Plugin - Browse Tags Page".',
        'category' => 'Documents Sharing Plugin',
        'type' => 'widget',
        'name' => 'sesdocument.tag-documents',
    ),
    array(
        'title' => 'SES - Documents Sharing - Recently Viewed Documents',
        'description' => 'This widget displays the recently viewed documents by the user who is currently viewing your website or by the logged in members friend or by all the members of your website. Edit this widget to choose whose recently viewed content will show in this widget.',
        'category' => 'Documents Sharing Plugin',
        'type' => 'widget',
        'name' => 'sesdocument.recently-viewed-item',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                                array(
                    'Select',
                    'view_type',
                    array(
                        'label' => "View Type",
                        'multiOptions' => array(
                            'list' => 'List View',
                            'gridInside' => 'Grid View',
                        ),
                    )
                ),
               array(
                    'Select',
                    'gridInsideOutside',
                    array(
                        'label' => "Grid View Inside/Outside",
                        'multiOptions' => array(
                            'in' => 'Inside View',
                            'out' => 'Outside View',
                        ),
                                                'value'=>'in'
                    )
                ),
                                 array(
                    'Select',
                    'mouseOver',
                    array(
                        'label' => "Show Grid View Data on Mouse Over (setting work only if you select \"Inside View\" in above setting) ",
                        'multiOptions' => array(
                            'over' => 'Yes,show data on Mouse Over',
                            '' => 'No,don\'t show data on Mouse Over',
                        ),
                                                'value'=>'over',
                    )
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
                        'label' => "Choose from below the details that you want to show for document in this widget.",
                        'multiOptions' => array(
                            'title' => 'Document Title',
                            'by' => 'Owner\'s Name',
                            'category' => 'Category',
                            'like' => 'Likes Count',
                            'comment' => 'Comments Count',
                            'favourite' => 'Favourite Count',
                            'rating' => 'Ratings',
                            'featuredLabel' => 'Featured Label',
                            'sponsoredLabel' => 'Sponsored Label',
                            'verifiedLabel' => 'Verified Label',
                            'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                            'likeButton' => 'Like Button',
                            'favouriteButton' => 'Favourite Button',
                            'profile' => 'Owner Photo',
                            //'docType' => 'Document Type',
                            'creationDate' => 'Publish Date',
                            'view' => 'View Counts',

                        ),
                        'escape' => false,
                    ),
                ),
                $socialshare_enable_plusicon,
                $socialshare_icon_limit,
                $titleTruncationGrid,
                $titleTruncationList,
                                array(
                    'Text',
                    'height',
                    array(
                        'label' => 'Enter the height of one document block (in pixels).',
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
                        'label' => 'Enter the width of one document block (in pixels).',
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
                        'label' => 'Count (number of documents to show.)',
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
        'title' => 'SES Documents Sharing - Documents of the Day',
        'description' => "This widget displays Documents of the day as chosen by you from the Edit Settings of this widget.",
        'category' => 'Documents Sharing Plugin',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesdocument.of-the-day',
        'adminForm' => array(
            'elements' => array(
                 array(
                    'Select',
                    'viewType',
                    array(
                        'label' => "View Type",
                        'multiOptions' => array(
                            'list' => 'List View',
                            'gridInside' => 'Grid View',

                        ),
                    )
                ),
                                  array(
                    'Select',
                    'gridInsideOutside',
                    array(
                        'label' => "Grid View Inside/Outside (setting work only if you select \"Grid View\" in above setting) ",
                        'multiOptions' => array(
                            'in' => 'Inside View',
                            'out' => 'Outside View',
                        ),
                                                'value'=>'in'
                    )
                ),
                                 array(
                    'Select',
                    'mouseOver',
                    array(
                        'label' => "Show Grid View Data on Mouse Over (setting work only if you select \"Inside View\" in above setting) ",
                        'multiOptions' => array(
                            'over' => 'Yes,show data on Mouse Over',
                            '' => 'No,don\'t show data on Mouse Over',
                        ),
                                                'value'=>'over',
                    )
                ),
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show for event in this widget.",
                        'multiOptions' => array(
                            'title' => 'Document Title',
                            'by' => 'Owner\'s Name',
                            'category' => 'Category',
                            'like' => 'Likes Count',
                            'comment' => 'Comments Count',
                            'view' => 'Views Count',
                            'favourite' => 'Favourite Count',
                            'rating' => 'Ratings',
                            'featuredLabel' => 'Featured Label',
                            'sponsoredLabel' => 'Sponsored Label',
                            'verifiedLabel' => 'Verified Label',
                            'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                            'likeButton' => 'Like Button',
                            'favouriteButton' => 'Favourite Button',
                            //'docType' => 'Document Type',
                            'creationDate' => 'Creation Date',
                        ),
                        'escape' => false,
                    ),
                ),
                $limitData,
                $socialshare_enable_plusicon,
                $socialshare_icon_limit,
                $titleTruncationGrid,
                $titleTruncationList,
                array(
                    'Text',
                    'height',
                    array(
                        'label' => 'Enter the height of one document block (in pixels).',
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
                        'label' => 'Enter the width of one Document block (in pixels).',
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
        'title' => 'SES - Documents Sharing - Breadcrumb for Document View Page',
        'description' => 'Displays breadcrumb for Document. This widget should be placed on the Document-view-page of the selected content type.',
        'category' => 'Documents Sharing Plugin',
        'autoEdit' => true,
        'type' => 'widget',
        'name' => 'sesdocument.document-breadcrumb',
        'autoEdit' => true,
    ),
    array(
        'title' => 'SES - Documents Sharing - Document Profile Like Button',
        'description' => 'Displays like button for document. This widget is only placed on "Document View Page" only.',
        'category' => 'Documents Sharing Plugin',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesdocument.document-profile-like',
        'defaultParams' => array(
            'title' => '',
        ),
    ),
    array(
        'title' => 'SES - Documents Sharing - Document Profile Favourite Button',
        'description' => 'Displays favourite button for document. This widget is only placed on "Document View Page" only.',
        'category' => 'Documents Sharing Plugin',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesdocument.document-profile-favourite',
        'defaultParams' => array(
            'title' => '',
        ),
    ),

    array(
        'title' => 'SES - Documents Sharing - Document Labels',
        'description' => 'Displays a featured, sponsored and verified labels on a document on it\'s profile.',
        'category' => 'Documents Sharing Plugin',
        'type' => 'widget',
        'name' => 'sesdocument.document-label',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'MultiCheckbox',
                    'option',
                    array(
                        'label' => "Choose options to be shown in this widget.",
                        'multiOptions' => array(
                            'featured' => 'Featured',
                            'sponsored' => 'Sponsored',
                            'verified' => 'Verified',
                        ),
                    )
                ),
            ),
        ),
    ),
    array(
        'title' => 'SES - Documents Sharing - Owner Photo',
        'description' => 'Displays document owner profile photo.',
        'category' => 'Documents Sharing Plugin',
        'type' => 'widget',
        'name' => 'sesdocument.document-view-gutter-photo',
        'defaultParams' => array(
            'title' => '',
        ),
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'showTitle',
                    array(
                        'label' => 'Member\'s Name',
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
        'title' => 'SES - Documents Sharing - View Page',
        'description' => 'Displays document view page.',
        'category' => 'Documents Sharing Plugin',
        'type' => 'widget',
        'name' => 'sesdocument.document-view-page',
        'adminForm' => array(
            'elements' => array(
                array(
                    'MultiCheckbox',
                    'option',
                    array(
                        'label' => "Choose options to be shown in this widget.",
                        'multiOptions' => array(
                            'by' => 'Owner Name',
                            'creationdate' => 'Creation Date',
                            'category' => 'Category',
                            'viewcount' => 'View Count',
                            'likecount' => 'Like Count',
                            'commentcount' => 'Comment Count',
                            'ratings' => "Rating Stars",
                        ),
                    )
                ),
            )
        ),
    ),
);
