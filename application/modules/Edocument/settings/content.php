<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Edocument
 * @package    Edocument
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: content.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$headScript = new Zend_View_Helper_HeadScript();
$headScript->appendFile(Zend_Registry::get('StaticBaseUrl') . 'application/modules/Sesbasic/externals/scripts/jscolor/jscolor.js');
$headScript->appendFile(Zend_Registry::get('StaticBaseUrl') . 'application/modules/Sesbasic/externals/scripts/jquery.min.js');

$categories = array();
if(Engine_Api::_()->getApi('settings', 'core')->getSetting('edocument.pluginactivated')) {
  $categories = Engine_Api::_()->getDbtable('categories', 'edocument')->getCategoriesAssoc(array('module'=>true));
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
    'label' => "Choose the view type which you want to display by default. (Settings will apply, if you have selected more than one option in above tab.)",
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
      'title' => 'Document Title',
      'category' => 'Category',
      'by' => 'Document Owner Name',
      'readmore' => 'Read More Button',
      'creationDate' => 'Creation Date',
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
    'label' => "Do you want the documents to be auto-loaded when users scroll down the page?",
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
    'title' => 'SES - Documents Sharing - Document Tags',
    'description' => 'Displays all document tags on your website. The recommended page for this widget is "SES - Documents Sharing - Browse Tags Page".',
    'category' => 'SES - Documents Sharing',
    'type' => 'widget',
    'name' => 'edocument.tag-documents',
  ),
  array(
    'title' => 'SES - Documents Sharing - Category Carousel',
    'description' => 'Displays categories in attractive carousel in this widget. The placement of this widget depends on the criteria chosen for this widget.',
    'category' => 'SES - Documents Sharing',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'edocument.category-carousel',
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
              'most_document' => 'Categories with maximum documents first',
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
              'countDocuments' => 'Document count in each category',
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
      ),
    ),
  ),
  array(
    'title' => 'SES - Documents Sharing - Documents Navigation Menu',
    'description' => 'Displays a navigation menu bar in the Documents Sharing\'s pages for Documents Home, Browse Documents, Browse Categories, etc pages.',
    'category' => 'SES - Documents Sharing',
    'type' => 'widget',
    'name' => 'edocument.browse-menu',
  ),
  array(
    'title' => 'SES - Documents Sharing - Category Banner Widget',
    'description' => 'Displays a banner for categories. You can place this widget at browse page of category on your site.',
    'category' => 'SES - Documents Sharing',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'edocument.banner-category',
    'adminForm' => 'Edocument_Form_Admin_Categorywidget',
  ),
  array(
    'title' => 'SES Documents Sharings - Categories Icon View',
    'description' => 'Displays all categories of documents in icon view with their icon. Edit this widget to configure various settings.',
    'category' => 'SES - Documents Sharing',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'edocument.document-category-icons',
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
              'most_document' => 'Categories with maximum documents first',
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
              'countDocuments' => 'Document count in each category',
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
        'title' => 'SES - Documents Sharing - Category Based Documents Block View',
        'description' => 'Displays documents in attractive square block view on the basis of their categories. This widget can be placed any where on your website.',
        'category' => 'SES - Documents Sharing',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'edocument.category-associate-document',
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
                            'by' => 'Document Owner\'s Name',
                            'featuredLabel' => 'Featured Label',
                            'sponsoredLabel' => 'Sponsored Label',
                            'creationDate' => 'Show Publish Date',
                            'readmore' => 'Read More',
                        ),
                    )
                ),
                array(
                    'Radio',
                    'popularity_document',
                    array(
                        'label' => 'Choose Document Display Criteria.',
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
                            'alphabetical' => 'Alphabetical Order',
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
                        'label' => 'count (number of documents to show in each category. This settging will work, if you choose "Yes" for "Show documents count in each category" setting above.").',
                        'value' => '8',
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                array(
                    'Text',
                    'document_description_truncation',
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
                        'label' => "Choose alignment of \"+ See All\" field",
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
        'title' => 'SES Documents Sharings - Document of the Day',
        'description' => "This widget displays documents of the day as chosen by you from the Edit Settings of this widget.",
        'category' => 'SES - Documents Sharing',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'edocument.of-the-day',
        'adminForm' => array(
            'elements' => array(
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show for documents in this widget.",
                        'multiOptions' => array(
                            'title' => 'Document Title',
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
                    'description_truncation',
                    array(
                        'label' => 'Document description truncation limit.',
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
            ),
        ),
    ),
    array(
        'title' => 'SES - Documents Sharing - Document Sidebar Tabbed Widget',
        'description' => 'Displays a tabbed widget for documents. You can place this widget anywhere on your site.',
        'category' => 'SES - Documents Sharing',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'edocument.sidebar-tabbed-widget',
        'adminForm' => 'Edocument_Form_Admin_SidebarTabbed',
    ),
    array(
        'title' => 'SES Documents Sharings - Tags Cloud / Tab View',
        'description' => 'Displays all tags of documents in cloud or tab view. Edit this widget to choose various other settings.',
        'category' => 'SES - Documents Sharing',
        'type' => 'widget',
        'name' => 'edocument.tag-cloud-documents',
        'autoEdit' => true,
        'adminForm' => 'Edocument_Form_Admin_Tagclouddocument',
    ),
    array(
        'title' => 'SES - Documents Sharing - Popular / Featured / Sponsored / Verified Documents Carousel',
        'description' => "Disaplys carousel of documents as configured by you based on chosen criteria for this widget. You can also choose to show Documents of specific categories in this widget.",
        'category' => 'SES - Documents Sharing',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'edocument.featured-sponsored-verified-category-carousel',
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'carousel_type',
                    array(
                        'label' => 'Choose the view type. [In Slick View, first and last document will partially show in the carousel.]',
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
                        'label' => 'Duration criteria for the documents to be shown in this widget',
                        'multiOptions' => array(
                            '' => 'All Documents',
                            'week' => 'This Week Documents',
                            'month' => 'This Month Documents',
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
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show in this widget.",
                        'multiOptions' => array(
                            'like' => 'Likes Count',
                            'comment' => 'Comments Count',
                            'favourite' => 'Favourites Count',
                            'view' => 'Views Count',
                            'title' => 'Document Title',
                            'by' => 'Document Owner\'s Name',
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
                        'label' => 'Count (number of documents to show).',
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
    'title' => 'SES - Documents Sharing - Popular / Featured / Sponsored / Verified Documents',
    'description' => "Displays documents as chosen by you based on chosen criteria for this widget. The placement of this widget depends on the criteria chosen for this widget.",
    'category' => 'SES - Documents Sharing',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'edocument.featured-sponsored',
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
	      '4' => 'All except Featured and Sponsored',
	    ),
	    'value' => 5,
	  )
	),
	array(
		'Select',
		'order',
		array(
			'label' => 'Duration criteria for the documents to be shown in this widget',
			'multiOptions' => array(
				'' => 'All Documents',
				'week' => 'This Week Documents',
				'month' => 'This Month Documents',
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
	    'label' => "Choose from below the details that you want to show for document in this widget.",
	    'multiOptions' => array(
	      'like' => 'Likes Count',
	      'comment' => 'Comments Count',
	      'favourite' => 'Favourites Count',
	      'view' => 'Views Count',
	      'title' => 'Document Title',
	      'by' => 'Document Owner\'s Name',
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
		'label' => 'Do you want to allow users to view more document posters in this widget? (If you choose Yes, then users will see Next & Previous buttons to view more document posters.)',
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
	  'description_truncation',
	  array(
	    'label' => 'Document description truncation limit.',
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
    'title' => 'SES - Documents Sharing - Browse Documents',
    'description' => 'Display all documents on your website. The recommended page for this widget is "SES - Documents Sharing - Browse Documents Page".',
    'category' => 'SES - Documents Sharing',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'edocument.browse-documents',
    'requirements' => array(
      'subject' => 'document',
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
                'verified' => 'Only Verified'
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
    'title' => 'SES - Documents Sharing - Alphabetic Filtering of Documents',
    'description' => "This widget displays all the alphabets for alphabetic filtering of documents which will enable users to filter documents on the basis of selected alphabet.",
    'category' => 'SES - Documents Sharing',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'edocument.alphabet-search',
    'defaultParams' => array(
      'title' => "",
    ),
  ),
  array(
    'title' => 'SES - Documents Sharing - Create New Document Link',
    'description' => 'Displays a link to create new document.',
    'category' => 'SES - Documents Sharing',
    'type' => 'widget',
    'name' => 'edocument.browse-menu-quick',
    'requirements' => array(
      'no-subject',
    ),
  ),
  array(
    'title' => 'SES - Documents Sharing - Document Browse Search',
    'description' => 'Displays a search form in the document browse page as configured by you.',
    'category' => 'SES - Documents Sharing',
    'type' => 'widget',
    'name' => 'edocument.browse-search',
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
	array(
		'Radio',
		'has_photo',
		array(
			'label' => "Show \'Document With Photos\' search field?",
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
    'title' => 'SES - Documents Sharing - Popular / Featured / Sponsored / Verified Documents Slideshow',
    'description' => "Displays slideshow of documents as chosen by you based on chosen criteria for this widget. You can also choose to show Documents of specific categories in this widget. The placement of this widget depends on the criteria chosen for this widget.",
    'category' => 'SES - Documents Sharing',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'edocument.featured-sponsored-verified-category-slideshow',
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
    'title' => 'SES - Documents Sharing - Tabbed widget for Popular Documents',
    'description' => 'Displays a tabbed widget for popular documents on your website based on various popularity criterias. Edit this widget to choose tabs to be shown in this widget. This widget can be placed anywhere on your website.',
    'category' => 'SES - Documents Sharing',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'edocument.tabbed-widget-document',
    'requirements' => array(
      'subject' => 'document',
    ),
    'adminForm' => 'Edocument_Form_Admin_Tabbed',
  ),

  array(
      'title' => 'SES Documents Sharings - Categories Cloud / Hierarchy View',
      'description' => 'Displays all categories of documents in cloud or hierarchy view. Edit this widget to choose various other settings.',
      'category' => 'SES - Documents Sharing',
      'type' => 'widget',
      'name' => 'edocument.tag-cloud-category',
      'autoEdit' => true,
      'adminForm' => 'Edocument_Form_Admin_Tagcloudcategory',
  ),
  array(
    'title' => 'SES - Documents Sharing - People Like Document',
    'description' => 'Placed on  a Document view page.',
    'category' => 'SES - Documents Sharing',
    'type' => 'widget',
    'name' => 'edocument.people-like-item',
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
        'title' => 'SES - Documents Sharing - Profile Documents',
        'description' => 'Displays a member\'s document entries on their profiles. The recommended page for this widget is "Member Profile Page"',
        'category' => 'SES - Documents Sharing',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'edocument.profile-edocuments',
        'requirements' => array(
            'subject' => 'user',
        ),
        'adminForm' => 'Edocument_Form_Admin_Tabbed',
    ),

  array(
    'title' => 'SES - Documents Sharing - Tabbed widget for Manage Documents',
    'description' => 'This widget displays documents created, favourite, liked, rated, etc by the member viewing the manage page. Edit this widget to configure various settings.',
    'category' => 'SES - Documents Sharing',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'edocument.manage-documents',
    'requirements' => array(
      'subject' => 'document',
    ),
    'adminForm' => 'Edocument_Form_Admin_Tabbed',
  ),

  array(
    'title' => 'SES - Documents Sharing - Profile Options for Documents',
    'description' => 'Displays a menu of actions (edit, report, add to favourite, share, subscribe, etc) that can be performed on a document on its profile.',
    'category' => 'SES - Documents Sharing',
    'type' => 'widget',
    'name' => 'edocument.gutter-menu',
  ),

  array(
    'title' => 'SES - Documents Sharing - Document Profile - Owner Photo',
    'description' => 'Displays the owner\'s photo on the document view page.',
    'category' => 'SES - Documents Sharing',
    'type' => 'widget',
    'name' => 'edocument.gutter-photo',
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
    'title' => 'SES - Documents Sharing - Document Profile - Similar Documents',
    'description' => 'Displays documents similar to the current document based on the document category. The recommended page for this widget is "SES - Documents Sharing - Document Profile Page".',
    'category' => 'SES - Documents Sharing',
    'type' => 'widget',
		'autoEdit' => true,
    'name' => 'edocument.similar-documents',
    'adminForm' => array(
      'elements' => array (
        array(
          'MultiCheckbox',
          'show_criteria',
          array(
            'label' => "Choose from below the details that you want to show for document in this widget.",
            'multiOptions' => array(
              'like' => 'Likes Count',
              'comment' => 'Comments Count',
              'favourite' => 'Favourites Count',
              'view' => 'Views Count',
              'title' => 'Document Title',
              'by' => 'Document Owner\'s Name',
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
            'label' => 'Do you want to allow users to view more similar documents in this widget? (If you choose Yes, then users will see Next & Previous buttons to view more documents.)',
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
            'label' => 'Count (number of documents to show).',
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
      'title' => 'SES Documents Sharings - Document Profile - Tags',
      'description' => 'Displays all tags of the current document on Document Profile Page. The recommended page for this widget is "SES - Documents Sharing - Document Profile Page".',
      'category' => 'SES - Documents Sharing',
      'type' => 'widget',
      'name' => 'edocument.profile-tags',
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
    'title' => 'SES - Documents Sharing - Document Profile - Advanced Share Widget',
    'description' => 'This widget allow users to share the current document on your website and on other social networking websites. The recommended page for this widget is "SES - Documents Sharing - Document Profile Page".',
    'category' => 'SES - Documents Sharing',
    'type' => 'widget',
    'name' => 'edocument.advance-share',
    'autoEdit' => true,
    'adminForm' => 'Edocument_Form_Admin_Share',
  ),
  array(
    'title' => 'SES - Documents Sharing - Document Profile - Breadcrumb',
    'description' => 'Displays breadcrumb for Document. This widget should be placed on the Documents Sharing - View page of the selected content type.',
    'category' => 'SES - Documents Sharing',
    'type' => 'widget',
    'name' => 'edocument.breadcrumb',
    'autoEdit' => true,
  ),
	 array(
    'title' => 'SES - Documents Sharing - Document Custom Field Info',
    'description' => 'Displays document custom fields for Document. This widget should be placed on the Documents Sharing - View page of document.',
    'category' => 'SES - Documents Sharing',
    'type' => 'widget',
    'name' => 'edocument.document-info',
		'defaultParams' => array(
      'title' => "Custom Fields",
    ),
    'autoEdit' => false,
  ),

 array(
    'title' => 'SES - Documents Sharing - Labels',
    'description' => 'This widget displays Featured, Sponsored and Verified labels on Document Profile Page. The recommended page for this widget is "SES - Documents Sharing - Document Profile Page".',
    'category' => 'SES - Documents Sharing',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'edocument.labels',
  ),
  array(
    'title' => 'SES - Documents Sharing - Document Profile - Content',
    'description' => 'Displays document content according to the design choosen by the document poster while creating or editing the document. The recommended page for this widget is "SES - Documents Sharing - Document Profile Page".',
    'category' => 'SES - Documents Sharing',
    'type' => 'widget',
    'name' => 'edocument.view-document',
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
							'document' => 'Document',
							'socialShare' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
							'ownerOptions' => 'Owner Options',
							'postComment' => 'Comment Button',
							'rating' => 'Rating Star',
							'likeButton' => 'Like Button',
                            'shareButton' => 'Large Share Button',
                            'smallShareButton' => 'Small Share Button',
							'favouriteButton' => 'Favourite Button',
							'view' => 'View Count',
							'like' => 'Like Count',
							'comment' => 'Comment Count',
							'statics' => 'Show Statstics'
						),
                        'value' => array('title', 'description', 'photo', 'socialShare', 'ownerOptions', 'rating', 'postComment', 'likeButton', 'favouriteButton', 'view', 'like', 'comment', 'review', 'statics','shareButton','smallShareButton'),
						'escape' => false,
					)
				),
				$socialshare_enable_plusicon,
				$socialshare_icon_limit,
			),
		),
  ),

    array(
        'title' => 'SES - Documents Sharing - Categories Square Block View',
        'description' => 'Displays all categories of documents in square blocks. Edit this widget to configure various settings.',
        'category' => 'SES - Documents Sharing',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'edocument.document-category',
        'requirements' => array(
            'subject' => 'document',
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
                        'label' => "Do you want to show only those categories under which atleast 1 document is posted?",
                        'multiOptions' => array(
                            '1' => 'Yes, show only categories with documents',
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
                            'most_document' => 'Most Documents Category First',
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
                            'countDocuments' => 'Document count in each category',
                        ),
                    )
                ),
            ),
        ),
    ),

        array(
        'title' => 'SES - Documents Sharing - Category View Page Widget',
        'description' => 'Displays a view page for categories. You can place this widget at view page of category on your site.',
        'category' => 'SES - Documents Sharing',
        'type' => 'widget',
        'name' => 'edocument.category-view',
        'requirements' => array(
            'subject' => 'document',
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
                            'countDocument' => 'Documents count in each category',
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
                    'textDocument',
                    array(
                        'label' => 'Enter teh text for \'heading\' of this widget.',
                        'value' => 'Documents we like',
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
// 	  array(
//     'title' => 'SES - Documents Sharing - Document Content Widget',
//     'description' => 'Displays a content widget for document. You can place this widget on document profile page in tab container only on your site.',
//     'category' => 'SES - Documents Sharing',
//     'type' => 'widget',
//     'name' => 'edocument.content',
//     'requirements' => array(
//       'subject' => 'document',
//     ),
//   ),
  	  array(
    'title' => 'SES - Documents Sharing - Document Profile - Photo',
    'description' => 'Displays a document photo widget. You can place this widget on document profile page only on your site.',
    'category' => 'SES - Documents Sharing',
    'type' => 'widget',
    'name' => 'edocument.document-photo',
    'requirements' => array(
      'subject' => 'document',
    ),
  ),
  array(
    'title' => 'SES - Documents Sharing - Document Social Share Widget',
    'description' => 'Displays a document social share widget. You can place this widget on document profile page only on your site.',
    'category' => 'SES - Documents Sharing',
    'type' => 'widget',
    'name' => 'edocument.document-socialshare',
    'adminForm' => array(
			'elements' => array(
				array(
					'Radio',
					'socialshare_design',
					array(
						'label' => "Do you want this social share widget on document profile page ?",
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
      'subject' => 'document',
    ),
  ),

		    array(
        'title' => 'SES - Documents Sharing - Profile Document\'s Like Button',
        'description' => 'Displays like button for document. This widget is only placed on "Document Profile Page" only.',
        'category' => 'SES - Documents Sharing',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'edocument.like-button',
        'defaultParams' => array(
            'title' => '',
        ),
    ),

    		    array(
        'title' => 'SES - Documents Sharing - Profile Document\'s Favourite Button',
        'description' => 'Displays favourite button for document. This widget is only placed on "Document Profile Page" only.',
        'category' => 'SES - Documents Sharing',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'edocument.favourite-button',
        'defaultParams' => array(
            'title' => '',
        ),
    ),

);
