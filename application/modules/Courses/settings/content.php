<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: content.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
$banner_video = array();
$arrayGallery = array();
if(Engine_Api::_()->getDbtable("modules", "core")->isModuleEnabled("courses")) {
  $banner_options = array();
  $path = new DirectoryIterator(APPLICATION_PATH . '/public/admin/');
  foreach ($path as $file) {
    if ($file->isDot() || !$file->isFile())
      continue;
    $base_name = basename($file->getFilename());
    if (!($pos = strrpos($base_name, '.')))
      continue;
    $extension = strtolower(ltrim(substr($base_name, $pos), '.'));
    if (in_array($extension, array('mp4','avi','mov','flv','wmv'))) {
      $banner_video['public/admin/' . $base_name] = $base_name;
    }
    if (!in_array($extension, array('gif', 'jpg', 'jpeg', 'png')))
      continue;
    $banner_options['public/admin/' . $base_name] = $base_name;
  }
  $results = Engine_Api::_()->getDbtable('offers', 'courses')->getOffers(array('fetchAll' => true));
  if (count($results) > 0) {
    foreach ($results as $gallery)
      $arrayGallery[$gallery['offer_id']] = $gallery['offer_name'];
  }
}
$levelOptions = array();
$levelValues = array();
foreach (Engine_Api::_()->getDbtable('levels', 'authorization')->fetchAll() as $level) {
      if($level->getTitle() == 'Public')
        continue;
    $levelOptions[$level->level_id] = $level->getTitle();
    $levelValues[] = $level->level_id;
}
        
$categories = array();
if(Engine_Api::_()->getApi('settings', 'core')->getSetting('courses.pluginactivated')) {
  $categories = Engine_Api::_()->getDbtable('categories', 'courses')->getCategoriesAssoc(array('module'=>true));
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
$titleTruncation = array(
    'Text',
    'title_truncation',
    array(
        'label' => 'Enter Title truncation limit.',
        'value' => 45,
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    )
);
$descriptionTruncation = array(
    'Text',
    'description_truncation',
    array(
        'label' => 'Enter Description Truncation Limit.',
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
$widthOfContainer = array(
  'Text',
  'width_grid',
  array(
    'label' => 'Enter the width of one block (in pixels).',
    'value' => '389',
  )
);

$pagging = array(
  'Radio',
  'pagging',
  array(
    'label' => "Do you want the courses to be auto-loaded when users scroll down the page?",
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
        'label' => "Image Type",
        'multiOptions' => array(
            'rounded' => 'Rounded View',
            'square' => 'Square View',
        ),
        'value' => 'square',
    )
);
return array(
     array(
        'title' => 'SNS - Courses - Category Carousel',
        'description' => 'Displays Categories in attractive Carousel in this widget. The placement of this widget depends on the criteria chosen for this widget.',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'courses.category-carousel',
        'adminForm' => array(
            'elements' => array(
                $titleTruncation,
                $descriptionTruncation,
                array(
                    'Text',
                    'height',
                    array(
                        'label' => 'Enter the height of one page block (in pixels).',
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
                        'label' => 'Enter the width of one page block (in pixels)',
                        'value' => '180',
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                array(
                    'Text',
                    'speed',
                    array(
                        'label' => 'Enter the delay time for next category when you have enabled autoplay.',
                        'value' => '300',
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
                        'label' => "Enables auto play of slides",
                        'multiOptions' => array(
                            1 => 'Yes',
                            0 => 'No'
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
                            'most_course' => 'Categories with maximum Courses first.',
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
                            'countCourse' => 'Courses count in each category',
                            'followButton' => 'Follow Button',
                            'socialshare' => 'Social Share Button',
                        ),
                    )
                ),
                $socialshare_enable_plusicon,
                $socialshare_icon_limit,
                array(
                    'Select',
                    'isfullwidth',
                    array(
                        'label' => 'Do you want to show category carousel in full width?',
                        'multiOptions' => array(
                            1 => 'Yes,want to show this widget in full width.',
                            0 => 'No,don\'t want to show this widget in full width.'
                        ),
                        'value' => 1,
                    )
                ),
                array(
                    'Text',
                    'limit_data',
                    array(
                        'label' => 'Count (number of category to show in this widget, put 0 for unlimited).',
                        'value' => 10,
                    )
                ),
            )
        ),
    ),
    array(
        'title' => 'SNS - Courses - Categories Cloud / Hierarchy View',
        'description' => 'Displays all categories of Courses in Cloud or Hierarchy view. Edit this widget to choose various other settings.',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'name' => 'courses.tag-cloud-category',
        'autoEdit' => true,
        'adminForm' => 'Courses_Form_Admin_Tagcloudcategory',
    ),
    array(
        'title' => 'SNS - Courses - Tags Cloud / Tab View',
        'description' => 'Displays all Tags of Courses in Cloud or Tab View. Edit this widget to choose various other settings.',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'name' => 'courses.tag-cloud-courses',
        'autoEdit' => true,
        'adminForm' => 'Courses_Form_Admin_Tagcloudcourse',
    ),
    array(
        'title' => 'SNS - Courses - Course Tags',
        'description' => 'Displays all Course Tags on your website. The recommended page for this widget is "SNS - Courses - Browse Course Page".',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'courses.tag-courses',
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
         'title' => 'SNS - Courses -Browse Courses',
         'description' => 'Displays courses on browse courses page. ',
         'category' => 'Courses - Learning Management System',
         'type' => 'widget',
         'name' => 'courses.browse-courses',
         'adminForm' => 'Courses_Form_Admin_Browse',
         'autoEdit' => true,
    ),
    array(
        'title' => 'SNS - Courses - Profile - Course Content',
        'description' => 'Displays Course content according to the design chosen by the Instructor while creating or editing the Course. The recommended page for this widget is "SNS - Courses - Profile View Page" ',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'name' => 'courses.course-view',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show in this widget.",
                        'multiOptions' => array(
                            'title' => 'Course Title',
                            'coursePhoto' => 'Course Photo',
                            'category' => 'Category',
                            'by' => 'Instructor Name',
                            'creationDate' => 'Created On',
                            'description' => 'Show Description',
                            'price'=>'Price',
                            'discount'=>'Discount',
                            'purchaseNote'=>'Purchase Note',
                            'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                            'commentButton'=>'Comment Button',
                            'likeButton' => 'Like Button',
                            'favouriteButton' => 'Favourite Button',
                            'lectureCount'=>'Lecture Count',
                            'like' => 'Likes Count',
                            'favourite' => 'Favourite Count',
                            'rating' => 'Reviews & Rating Counts',
                            'view' => 'Views Count',
                            'testCount'=>'Test Count',
                            'classroonNamePhoto'=>'Classroom Name & Photo (Display only when Classroom exists)',
                            'addCart'=>'Add to Cart',
                            'addWishlist'=>'Add to Wishlist',
                            'addCompare'=>'Add to Compare'
                        ),
                        'escape' => false,
                    )
                ),
                $socialshare_enable_plusicon,
                $socialshare_icon_limit,
                array(
                    'Text',
                    'maxHeight',
                    array(
                        'label' => 'Enter the height of Course Photo (in pixels).',
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
        'title' => 'SNS - Courses - Profile - Favourite Button',
        'description' => 'The recommended page for this widget is "Courses - Profile View Page" &  displays favorite button.',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'courses.favourite-button',
        'defaultParams' => array(
        ),
    ),
    array(
        'title' => 'SNS - Courses - Course View Features',
        'description' => 'Displays courses features on side widget in view page. ',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'name' => 'courses.course-view-features',
        'autoEdit' => true,
        'adminForm' => array(
          'elements' => array(
              array(
                  'MultiCheckbox',
                  'stats',
                  array(
                      'label' => 'Choose the options that you want to be displayed in this widget.',
                      'multiOptions' => array(
                          "duration" => "Duration",
                          "lectures" => "Lectures",
                          "tests" => "Tests",
                          "passparcentage" => "Pass Percentage",
                      )
                  ),
              )
          ),
      ),
    ),  
    array(
        'title' => 'SNS - Courses - Compare Fixed',
        'description' => 'This widget displays the courses to be compared. The widget is shown in the Footer of your website. Place this widget in the Header of your website.',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'name' => 'courses.compare-fixed',
        'requirements' => array(
        'subject' => 'courses',
        ),
    ),
    array(
        'title' => 'SNS - Courses - Course Profile Breadcrumb',
        'description' => 'Displays Course contact information in this widget. The placement of this widget depends on the Course Profile View Page.',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'name' => 'courses.breadcrumb',
        'autoEdit' => true,
    ),
    array(
        'title' => 'SNS - Courses - Lecture Profile Breadcrumb',
        'description' => 'This widget should be placed only on “Courses - Lecture Profile Page”',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'name' => 'courses.lecture-breadcrumb',
        'autoEdit' => true,
    ),
    array(
        'title' => 'SNS - Courses - Profile - Advance Share Widget',
        'description' => 'This widget allows users to share the current Course on your website and other social networking websites. The recommended page for this widget is "Courses -  Course Profile View Page"',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'name' => 'courses.advance-share',
        'autoEdit' => true,
        'adminForm' => 'Courses_Form_Admin_Share',
    ),
    array(
      'title' => 'SNS - Courses - Profile - Social Share Widget',
      'description' => 'The recommended page for this widget is "Courses - Profile View Page" & this widget displays different views for social share.',
      'category' => 'Courses - Learning Management System',
      'type' => 'widget',
      'name' => 'courses.course-socialshare',
      'requirements' => array(
        'subject' => 'course',
      ),
      'adminForm' => array(
        'elements' => array(
          array(
            'Radio',
            'socialshare_design',
            array(
              'label' => "Do you want this social share widget on course profile page ?",
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
    ),
    array(
    'title' => 'SNS - Courses - Profile - Course Instructor’s Photo',
    'description' => 'Displays the Instructor\'s photo on the “SNS - Courses - Course Profile View Page”.',
    'category' => 'Courses - Learning Management System',
    'type' => 'widget',
    'name' => 'courses.gutter-photo',
    'autoEdit' => true,
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
		'title' => 'SNS - Courses - Profile - Course Reviews',
		'description' => 'The recommended page for this widget is "Courses - Profile View Page" & displays Reviews of Courses.',
		'category' => 'Courses - Learning Management System',
		'type' => 'widget',
		'name' => 'courses.course-reviews',
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
						),
						'escape' => false,
					),
				),
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
		'title' => 'SNS - Courses - Browse Reviews',
		'description' => 'Displays all reviews for Courses on your website. This widget should be placed on "Courses - Browse Reviews Page"',
		'category' => 'Courses - Learning Management System',
		'type' => 'widget',
		'autoEdit' => true,
		'name' => 'courses.browse-reviews',
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
								//'likeButton' => 'Like Button',
                //'socialSharing' =>'Social Share Buttons',
							),
						)
					),
					/*array(
						'MultiCheckbox',
						'show_criteria',
						array(
								'label' => "Choose from below the details that you want to show for blog in this widget.",
								'multiOptions' => array(
										'likemainButton' => 'Like Button with Social Sharing Button',
										'featuredLabel' => 'Featured Label',
										'verifiedLabel' => 'Verified Label',
								),
						),
					),*/
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
        'title' => 'SNS - Courses - Review Profile widget',
        'description' => 'Displays review and review statistics on "Courses - Review Profile Page".',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'courses.profile-review',
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
                            "share" => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                        ),
                        'escape' => false,
                    ),
                )
            ),
        ),
    ),
    array(
        'title' => 'SNS - Courses - Review Profile Breadcrumb',
        'description' => 'Displays breadcrumb for Reviews. This widget should be placed on the "Courses - Review Profile Page"',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'name' => 'courses.review-breadcrumb',
        'autoEdit' => true,
    ),
  array(
		'title' => 'SNS - Courses - Reviews Browse Search',
		'description' => 'Displays a search form on the “Courses - Browse Reviews Page” as configured by you.',
		'category' => 'Courses - Learning Management System',
		'type' => 'widget',
		'name' => 'courses.browse-review-search',
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
  array(
        'title' => 'SNS - Courses - Popular / Featured / Verified Reviews',
        'description' => "Displays reviews as chosen by you based on the chosen criteria for this widget. The placement of this widget depends on the criteria chosen for this widget.",
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'courses.popular-featured-verified-reviews',
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
                $mageType,
                array(
                    'Select',
                    'showLimitData',
                    array(
                        'label' => 'Do you want to allow users to view more reviews in this widget? (If you choose Yes, then users will see Next & Previous buttons to view more reviews.',
                        'multiOptions' => array(
                            "1" => "Yes, want to show next/previous buttons",
                            "0" => "No, don't want to show next/previous buttons",
                        )
                    ),
                    'value' => '1',
                ),
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show for Course in this widget.",
                        'multiOptions' => array(
                            'title' => 'Review Title',
                            'like' => 'Likes Count',
                            'view' => 'Views Count',
                            'comment' => 'Comments Count',
                            'rating' => 'Ratings',
                            'verifiedLabel' => 'Verified Label',
                            'featuredLabel' => 'Featured Label',
                            'description' => 'Description',
                            'reviewOwnerName' => 'Review Owner Name',
                            'courseName' => 'Course Name',
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
        'title' => "SNS - Courses - Review Owner’s Photo",
        'description' => 'This widget displays a photo of the member who has written the current review. The recommended page for this widget is "Courses - Review Profile Page"',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'courses.review-owner-photo',
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
        'title' => 'SNS - Courses - Review Profile Options',
        'description' => 'Displays a menu of actions (edit, report, share, etc) that can be performed on reviews on its profile. The recommended page for this widget is "Courses - Review Profile Page"',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'name' => 'courses.review-profile-options',
        'autoEdit' => true,
    ),
    array(
        'title' => 'SNS - Courses - Profile - People Like Course',
        'description' => 'This widget displays members those who liked the Course on "Courses - Profile View Page".',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'name' => 'courses.people-like-item',
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
      'title' => 'SNS - Courses - Profile - Course Tags',
      'description' => 'The recommended page for this widget is "Courses - Profile - Course Tags" & displays all tags of the current Course.',
      'category' => 'Courses - Learning Management System',
      'type' => 'widget',
      'name' => 'courses.profile-tags',
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
    'title' => 'SNS - Courses - People Also Bought Courses',
    'description' => 'Displays Frequently Buy Courses on your website and placed on courses profile view page.',
    'category' => 'Courses - Learning Management System',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'courses.upsell-courses',
        'requirements' => array(
            'subject' => 'courses',
        ),
        'adminForm' => array(
            'elements' => array(
                 array(
                'MultiCheckbox',
                'show_criteria',
                    array(
                        'label' => "Choose the options that you want to be displayed in this widget.",
                        'multiOptions' => array(
                            'title' => 'Course Title',
                            'coursePhoto'=>'Course Photo',
                            'by'=>"Instructor's Name",
                            'price' =>'Price',
                            'discount'=>'Discount',
                            'creationDate'=>'Publish Date',
                            'featuredLabel' => 'Featured Label',
                            'sponsoredLabel' => 'Sponsored Label',
                            'verifiedLabel' => 'Verified Label',
                            'favouriteButton' => 'Favourite Button',
                            'likeButton' => 'Like Button',
                            'category' => 'Category',
                            'socialSharing' =>'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                            'like' => 'Likes Count',
                            'comment' => 'Comments Count',
                            'favourite' => 'Favourites Count',
                            'rating' =>'Reviews & Rating Counts',
                            'view' => 'Views Count',
                            'lectureCount'=>'Lectures Counts',
                            'addCart'=>'Add to Cart',
                            'addWishlist'=>'Add to Wishlist',
                            'addCompare'=>'Add to Compare',
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
                    'width_grid',
                    array(
                        'label' => 'Enter the width of one block (in pixels).',
                        'value' => '389',
                    )
                ),
                array(
                    'Text',
                    'height_grid',
                    array(
                        'label' => 'Enter the height of one block (in pixels).',
                        'value' => '270',
                    )
                ),
                array(
                    'Select',
                    'show_item_count',
                    array(
                        'label' => 'Do you want to show Courses count in this widget?',
                        'multiOptions' => array(
                            '1' => 'Yes',
                            '0' => 'No',
                        ),
                        'value' => '0',
                    ),
                ),
                array(
                    'Text',
                    'limit_data_grid',
                    array(
                        'label' => 'Count (number of courses to show).',
                        'value' => 20,
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
    'title' => 'SNS - Courses - cross sell Courses',
    'description' => 'Displays Frequently Buy Courses on your website and placed on courses checkout page.',
    'category' => 'Courses - Learning Management System',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'courses.cross-sell-courses',
        'requirements' => array(
            'subject' => 'courses',
        ),
        'adminForm' => array(
            'elements' => array(
                 array(
                'MultiCheckbox',
                'show_criteria',
                    array(
                        'label' => "Choose the options that you want to be displayed in this widget.",
                        'multiOptions' => array(
                            'title' => 'Course Title',
                            'coursePhoto'=>'Course Photo',
                            'by'=>"Instructor's Name",
                            'price' =>'Price',
                            'discount'=>'Discount',
                            'creationDate'=>'Publish Date',
                            'featuredLabel' => 'Featured Label',
                            'sponsoredLabel' => 'Sponsored Label',
                            'verifiedLabel' => 'Verified Label',
                            'favouriteButton' => 'Favourite Button',
                            'likeButton' => 'Like Button',
                            'category' => 'Category',
                            'socialSharing' =>'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                            'like' => 'Likes Count',
                            'comment' => 'Comments Count',
                            'favourite' => 'Favourites Count',
                            'rating' =>'Reviews & Rating Counts',
                            'view' => 'Views Count',
                            'lectureCount'=>'Lectures Counts',
                            'addCart'=>'Add to Cart',
                            'addWishlist'=>'Add to Wishlist',
                            'addCompare'=>'Add to Compare',
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
                    'width',
                    array(
                        'label' => 'Enter the width of one block (in pixels).',
                        'value' => '389',
                    )
                ),
                array(
                    'Text',
                    'height_grid',
                    array(
                        'label' => 'Enter the height of one block (in pixels).',
                        'value' => '270',
                    )
                ),
                array(
                    'Select',
                    'show_item_count',
                    array(
                        'label' => 'Do you want to show Courses count in this widget?',
                        'multiOptions' => array(
                            '1' => 'Yes',
                            '0' => 'No',
                        ),
                        'value' => '0',
                    ),
                ),
                array(
                    'Text',
                    'limit_data_grid',
                    array(
                        'label' => 'Count (number of courses to show).',
                        'value' => 20,
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
        'title' => 'SNS - Courses - Profile - Similar Courses',
        'description' => 'Displays Courses similar to the current Course based on the Course category. The recommended page for this widget is "Courses - Profile View Page".',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'courses.similar-courses',
        'adminForm' => array(
            'elements' => array (
                array(
                'MultiCheckbox',
                'show_criteria',
                array(
                    'label' => "Choose from below the details that you want to show for Course in this widget.",
                    'multiOptions' => array(
                    'title' => 'Course Title',
                    'coursePhoto'=>'Course Photo',
                    'by'=>"Instructor's Name",
                    'rating' =>'Reviews & Rating',
                    'price' =>'Price',
                    'featuredLabel' => 'Featured Label',
                    'sponsoredLabel' => 'Sponsored Label',
                    'verifiedLabel' => 'Verified Label',
                    'favouriteButton' => 'Favourite Button',
                    'likeButton' => 'Like Button',
                    'category' => 'Category',
                    'socialSharing' =>'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                    'like' => 'Likes Count',
                    'comment' => 'Comments Count',
                    'favourite' => 'Favourites Count',
                    'view' => 'Views Count',
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
                        'label' => 'Do you want to allow users to view more similar Courses in this widget? (If you choose Yes, then users will see Next & Previous buttons to view more Courses.)',
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
        'title' => 'SNS - Courses - Lecture Profile Options',
        'description' => 'Displays lecture edit, delete, create test etc. This widget should be placed on Courses - Lecture Profile Page.',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'name' => 'courses.lecture-profile-options',
    ),
    array(
        'title' => 'SNS - Courses - Browse Wishlists',
        'description' => 'Displays all wishlists on your website.  The recommended page for this widget is "Courses - Browse Wishlists Page"',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'courses.browse-wishlists',
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'popularity',
                    array(
                        'label' => 'Popularity Criteria',
                        'multiOptions' => array(
                            'is_featured' => 'Only Featured',
                            'is_sponsored'=> 'Only Sponsored',
                            'view_count' => 'Most Viewed',
                            'creation_date' => 'Most Recent',
                            'modified_date' => 'Recently Updated',
                        ),
                        'value' => 'creation_date',
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
                            'courseCount' => "Show courses of each wishlists",
                        ),
                        'escape' => false,
                    ),
                ),
                $socialshare_enable_plusicon,
                $socialshare_icon_limit,
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
                array('Radio', "pagging", array(
                  'label' => "Do you want the Courses to be auto-loaded when users scroll down the page?",
                  'multiOptions' => array(
                      'auto_load' => 'Yes, Auto Load',
                      'button' => 'No, show \'View more\' link.',
                      'pagging' => 'No, show \'Pagination\'.'
                  ),
                  'value' => 'auto_load',
                )),
            )
        ),
    ),
    array(
        'title' => 'SNS - Courses - Popular Wishlists',
        'description' => 'Displays wishlists based on the chosen criteria for this widget. The placement of this widget depends on the criteria chosen for this widget.',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'courses.popular-wishlists',
        'adminForm' => array(
            'elements' => array(
                array(
                    'Radio',
                    'showOptionsType',
                    array(
                        'label' => "Show",
                        'multiOptions' => array(
                            'all' => 'Popular Wishlist [with this option, place this widget anywhere on your website. Choose criteria from "Popularity Criteria" setting below.]',
                            'recommanded' => 'Recommended Wishlist [With this option, place this widget anywhere on your website.]',
                            'other' => 'Member’s Other Wishlists [With this option, place this widget on the “Courses - Wishlist Profile Page.]',
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
                            'creation_date' => 'Most Recent',
                            'view_count' => 'Most Viewed',
                            'like_count' => 'Most Liked',
                            'modified_date' => 'Recently Updated',
                            'favourite_count' => "Most Favourite",
                            'courses_count' => "Maximum Courses",
                            'featured' => 'Only Featured',
                            'sponsored' => 'Only Sponsored',
                            'verified' => 'Only Verified',
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
                            "postedby" => "Wishlist Owner's Name",
                            "title" => "Wishlist Title",
                            "wishlistPhoto"=>"Wishlist Title",
                            "featuredLabel"=>"Featured Label",
                            "sponsoredLabel"=>"Sponsored Label",
                            "viewCount" => "Views Count",
                            "likeCount" => "Likes Count",
                            "favouriteCount" => "Favorite Count",
                            "courseCount" => "Courses Count",
                            "courseList"=>"Courses of each Wishlist.",
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
        'title' => 'SNS - Courses - Browse Search',
        'description' => 'This widget should be placed on the “Courses - Browse Wishlist Page” & displays a search form in the wishlist browse page. Edit this widget to choose the search option to be shown in the search form.',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'name' => 'courses.browse-search',
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
                        'mostSPrated' => 'Most Rated',
                        'featured' => 'Only Featured',
                        'sponsored' => 'Only Sponsored',
                        'verified' => 'Only Verified',
                        'mostSPlecture' => 'Most lecture',
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
                        'mostSPrated' => 'Most Rated',
                        'featured' => 'Only Featured',
                        'sponsored' => 'Only Sponsored',
                        'verified' => 'Only Verified',
                        'mostSPlecture' => 'Most lecture',
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
                        'label' => "Show \'Search Courses Keyword\' search field?",
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
//                 array(
//                     'Radio',
//                     'kilometer_miles',
//                     array(
//                         'label' => "Show \'Kilometer or Miles\' search field?",
//                         'multiOptions' => array(
//                         'yes' => 'Yes',
//                         'no' => 'No'
//                         ),
//                         'value' => 'yes',
//                     )
//                 ),
                array(
                    'Radio',
                    'price',
                    array(
                        'label' => "Show \'Price\' search field?",
                        'multiOptions' => array(
                            'yes' => 'Yes',
                            'no' => 'No',
                        ),
                        'value' => 'yes',
                    )
                ),
//                 array(
//                     'Radio',
//                     'priceType',
//                     array(
//                         'label' => "Show \'Course Type - Free/Paid \' search field?",
//                         'multiOptions' => array(
//                             'yes' => 'Yes',
//                             'no' => 'No',
//                         ),
//                         'value' => 'yes',
//                     )
//                 ),
               /* array(
                    'Radio',
                    'duration',
                    array(
                        'label' => "Show \'Course Duration \' search field?",
                        'multiOptions' => array(
                            'yes' => 'Yes',
                            'no' => 'No',
                        ),
                        'value' => 'yes',
                    )
                ),*/
                /*array(
                    'Radio',
                    'lecture',
                    array(
                        'label' => "Show \'Lectures \' search field?",
                        'multiOptions' => array(
                            'yes' => 'Yes',
                            'no' => 'No',
                        ),
                        'value' => 'yes',
                    )
                ),*/
            )
        ),
    ),
    array(
        'title' => 'SNS - Courses - Wishlists Browse Search',
        'description' => 'This widget should be placed on the “Courses - Browse Wishlist Page” & displays a search form in the wishlist browse page. Edit this widget to choose the search option to be shown in the search form.',
        'category' => 'Courses - Learning Management System',
        'autoEdit' => true,
        'type' => 'widget',
        'name' => 'courses.wishlists-browse-search',
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
        'title' => 'SNS - Courses - Alphabetic Filtering of Courses / Wishlists',
        'description' => "This widget displays all the alphabets for alphabetic filtering of Courses/Wishlists which will enable users to filter Courses/Wishlists on the basis of selected alphabet.",
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'courses.alphabet-search',
        'defaultParams' => array(
        'title' => "",
        ),
    ),
    array(
        'title' => 'SNS - Courses - Wishlists Profile Page Breadcrumb',
        'description' => 'This widget should be placed on the “Courses - Wishlists Profile Page” & displays Breadcrumb for Wishlist page.',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'name' => 'courses.wishlist-breadcrumb',
        'autoEdit' => true,
    ),
    array(
        'title' => 'SNS - Courses - Wishlist Profile Page widget',
        'description' => 'This widget displays wishlist details and various options. The recommended page for this widget is "Courses - Wishlist Profile Page".',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'name' => 'courses.wishlist-view-page',
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
                            'totalCourse' =>'Courses Count',
                            'favouriteCountWishlist'=>'Favourite Count Wishlist',
                        ),
                        'escape' => false,
                    ),
                ),
            )
        ),
    ),
//     array(
// 		'title' => 'SNS - Courses - Wishlist Tabbed Widget',
// 		'description' => 'Display all Courses under the wishlists on your website. The recommended page for this widget is "Courses - Wishlist Profile Page".',
// 		'category' => 'Courses - Learning Management System',
// 		'type' => 'widget',
// 		'autoEdit' => true,
// 		'name' => 'courses.wishlist-tabbed-widget',
// 		'requirements' => array(
// 			'subject' => 'user',
// 		),
// 		'adminForm' => 'Courses_Form_Admin_WishlistTabbed',
// 	),
    array(
        'title' => 'SNS - Courses - Profile Options for Courses',
        'description' => 'Displays a menu of actions (edit, report, add to favourite, share etc) that can be performed on a course on its profile.',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'name' => 'courses.course-profile-options',
    ),
    array(
        'title' => 'SNS - Courses - Profile - Course Contact Information',
        'description' => 'Displays Course contact information in this widget. The placement of this widget depends on the Course Profile View Page.',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'courses.course-contact-information',
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
                            'twitter'=>'Contact Twitter',
                            'website'=>'Contact Website',
                            'instagram'=>'Contact Instagram',
                            'pinterest'=>'Contact Pinterest',
                        ),
                    )
                ),
            )
        ),
    ),
    array(
        'title' => 'SNS - Courses - Profile -  Labels',
        'description' => 'This widget displays Featured, Sponsored and Verified labels on "Courses - Profile View Page". ',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'courses.labels',
    ),
    array(
		'title' => 'SNS - Courses - Review Of The Day',
		'description' => "This widget displays review of the day as chosen by you from the \"Manage Reviews\" settings of this plugin.",
		'category' => 'Courses - Learning Management System',
		'type' => 'widget',
		'autoEdit' => true,
		'name' => 'courses.review-of-the-day',
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
							'reviewOwnerName' => 'Review Owner Name',
							'courseName' => 'Course Title',
              'creationDate' => 'Publish Date',
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
			)
		),
    ),
    array(
        'title' => 'SNS - Courses - Popular / Featured / Sponsored / Verified Courses Slideshow',
        'description' => "Displays slideshow of Courses as chosen by you based on chosen criteria for this widget. You can also choose to show Courses of specific categories in this widget. The placement of this widget depends on the criteria chosen for this widget.",
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'courses.featured-sponsored-verified-category-slideshow',
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
                            '0' => 'All Courses',
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
                        'label' => 'Duration criteria for the Courses to be shown in this widget.',
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
                        )
                    ),
                    'value' => 'recently_created',
                ),
                array(
                'Select',
                'isfullwidth',
                    array(
                        'label' => 'Do you want to show slideshow in full width?',
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
                        'label' => "Do you want to enable autoplay of Courses?",
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
                        'label' => 'Delay time for next Course when you have enabled autoplay.',
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
                        'label' => "Choose the effects while sliding changes.",
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
                        'label' => "What do you want to show buttons or circles to navigate to the next slide?",
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
                        'label' => "Choose from below the details that you want to show for Courses in this widget.",
                        'multiOptions' => array(
                            'like' => 'Likes Count',
                            'comment' => 'Comments Count',
                            'favourite' => 'Favourites Count',
                            'view' => 'Views Count',
                            'title' => 'Course Title',
                            'coursePhoto' => 'Course Photo',
                            'rating' =>'Reviews & Ratings Count',
                            'featuredLabel' => 'Featured Label',
                            'sponsoredLabel' => 'Sponsored Label',
                            'verifiedLabel' => 'Verified Label',
                            'favouriteButton' => 'Favourite Button',
                            'likeButton' => 'Like Button',
                            'category' => 'Category',
                            'socialSharing' =>'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
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
                        'label' => 'Course title truncation limit.',
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
                        'label' => 'Course Description truncation limit.',
                        'value' => 100,
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
                        'label' => 'Count (number of courses to show).',
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
        'title' => 'SNS - Courses - Tabbed widget for Popular Courses',
        'description' => 'Displays a tabbed widget for popular Courses on your website based on various popularity criteria. Edit this widget to choose tabs to be shown in this widget. This widget can be placed anywhere on your website',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'courses.tabbed-widget-course',
        'requirements' => array(
            'subject' => 'courses',
        ),
        'adminForm' => 'Courses_Form_Admin_Tabbed',
    ),
    array(
        'title' => 'SNS - Courses - Create Lecture',
        'description' => 'This widget should be placed only on “SNS - Courses -  Profile Page”',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'name' => 'courses.profile-lecture-create',
        'requirements' => array(
            'subject' => 'courses',
        ),
    ),
    array(
      'title' => 'SNS - Courses - Profile Courses',
      'description' => 'Displays a member\'s Course entries on their profiles. The recommended page for this widget is "Member Profile Page"',
      'category' => 'Courses - Learning Management System',
      'type' => 'widget',
      'autoEdit' => true,
      'name' => 'courses.profile-courses',
      'requirements' => array(
        'subject' => 'user',
      ),
      'adminForm' => 'Courses_Form_Admin_Tabbed',
    ),
    array(
    'title' => 'SNS - Courses - Course Of The Day',
    'description' => "This widget displays Courses of the Day as chosen by you from the Edit Settings of this widget.",
    'category' => 'Courses - Learning Management System',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'courses.of-the-day',
        'adminForm' => array(
            'elements' => array(
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show for courses in this widget.",
                            'multiOptions' => array(
                                'title' => 'Course Title',
                                'coursePhoto'=>'Course Photo',
                                'description'=>'Description',
                                'by'=>"Instructor's Name",
                                'price' =>'Price',
                                'discount' => 'Discount',
                                'ceationDate'=>'Duration',
                                'category' => 'Category',
                                'like' => 'Likes Count',
                                'view' => 'Views Count',
                                'comment' => 'Comment Count',
                                'favourite' => 'Favourites Count',
                                'lectureCount'=>'Lectures Count',
                                'rating' => 'Review & Rating Count',
                                'favouriteButton' => 'Favourite Button',
                                'likeButton' => 'Like Button',
                                'featuredLabel' => 'Featured Label',
                                'verifiedLabel' => 'Verified Label',
                                'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                                'addCart' => 'Add to Cart Button',
                                'addCompare'=>'Add to Compare',
                                'addWishlist' => 'Add to wishlists',
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
                        'label' => 'Course Title truncation limit.',
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
                        'label' => 'Course Description truncation limit.',
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
      'title' => 'SNS - Courses - Wishlist Of The Day',
      'description' => "This widget display “Wishlists Of The Day” as chosen by you from the Edit Settings of this widget.",
      'category' => 'Courses - Learning Management System',
      'type' => 'widget',
      'autoEdit' => true,
      'name' => 'courses.wishlist-of-the-day',
        'adminForm' => array(
            'elements' => array(
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show for wishlists in this widget.",
                            'multiOptions' => array(
                                'title' => 'Wishlist Title',
                                'wishlistPhoto'=>'Wishlist Photo',
                                'like' => 'Likes Count',
                                'view' => 'Views Count',
                                'favourite' => 'Favourites Count',
                                'courseCount'=>'Course Count',
                                'creationDate'=>'Creation Date',
                                'favouriteButton' => 'Favourite Button',
                                'likeButton' => 'Like Button',
                                'featuredLabel' => 'Featured Label',
                                'sponsoredLabel' => 'Sponsored Label',
                        ),
                            'escape' => false,
                    )
                ),
                array(
                'Text',
                'title_truncation',
                    array(
                        'label' => 'Wishlist Title truncation limit.',
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
    'title' => 'SNS - Courses - Popular / Featured / Sponsored / Verified Courses',
    'description' => "Displays Courses as chosen by you based on chosen criteria for this widget. The placement of this widget depends on the criteria chosen for this widget.",
    'category' => 'Courses - Learning Management System',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'courses.featured-sponsored',
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
                        'label' => 'Duration criteria for the Courses to be shown in this widget.',
                        'multiOptions' => array(
                            '' => 'All Courses',
                            'week' => 'This Week Courses',
                            'month' => 'This Month Courses',
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
                        'label' => "Choose from below the details that you want to show for Courses in this widget.",
                        'multiOptions' => array(
                            'like' => 'Likes Count',
                            'comment' => 'Comments Count',
                            'favourite' => 'Favourites Count',
                            'view' => 'Views Count',
                            'title' => 'Course Title',
                            'price'=>'Price',
                            'by' => "Instructor's Name",
                            'creationDate' => 'Show Publish Date',
                            'category' => 'Category',
                            'rating' => 'Reviews & Ratings Count',
                            'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                            'likeButton' => 'Like Button',
                            'favouriteButton' => 'Favourite Button ',
                        ),
                        'escape' => false,
                    )
                ),
                $socialshare_enable_plusicon,
                $socialshare_icon_limit,
//                 array(
//                     'Radio',
//                     'show_star',
//                     array(
//                             'label' => "Do you want to show rating stars in this widget? (Note: Please choose star setting yes, when you are selction \"Most Rated\" from above setting.)",
//                             'multiOptions' => array(
//                                     '1' => 'Yes',
//                                     '0' => 'No',
//                             ),
//                             'value' => 0,
//                     )
//                 ),
                array(
                    'Select',
                    'showLimitData',
                    array(
                        'label' => 'Do you want to allow users to view more Courses in this widget? (If you choose Yes, then users will see Next & Previous buttons to view more Courses.)',
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
                        'label' => 'Course Title truncation limit.',
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
                        'label' => 'Course Description truncation limit.',
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
                        'label' => 'Count (Number of Courses to show)',
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
        'title' => 'SNS - Courses - Category Banner widget',
        'description' => 'Displays a Banner for Categories. You can place this widget at Courses - Browse Categories Page on your site.',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'courses.banner-category',
        'requirements' => array(
                'subject' => 'course',
        ),
        'adminForm' => 'Courses_Form_Admin_Categorywidget',
    ),
    array(
        'title' => 'SNS - Courses - Categories Icon View',
        'description' => 'Displays all Categories of Courses in Icon View with their Icon. Edit this widget to configure various settings.',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'courses.course-category-icons',
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
                            'most_course' => 'Categories with maximum Courses first.',
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
                            'countProducts' => 'Course count in each Category.',
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
        'title' => 'SNS - Courses  - Categories Square Block View',
        'description' => 'Displays Courses in attractive square block view on the basis of their Categories. This widget can be placed anywhere on your website.',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'courses.course-category',
        'requirements' => array(
            'subject' => 'course',
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
                    'course_required',
                    array(
                        'label' => "Do you want to show only those Categories under which at least the Course is posted?",
                        'multiOptions' => array(
                            '1' => 'Yes, show only categories with courses',
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
                            'most_course' => 'Most Courses Category first.',
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
                            'countCourses' => 'Course count in each category',
                        ),
                    )
                ),
            ),
        ),
    ),
    array(
        'title' => 'SNS - Courses - Category View Page Widget',
        'description' => 'Displays a view page for Categories. You can place this widget at view page of Category on your site.',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'name' => 'courses.category-view',
        'requirements' => array(
            'subject' => 'courses',
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
                        'label' => "Choose from below the details that you want to show on each Category block.",
                        'multiOptions' => array(
                            'icon' => 'Category Icon',
                            'title' => 'Category Title',
                            'countCourses' => 'Courses count in each Category.',
                        ),
                    )
                ),
                array(
                    'Text',
                    'heightSubcat',
                    array(
                        'label' => 'Enter the height of one 2nd-level or 3rd level categor\'s block (in pixels).',
                        'value' => '160px',
                    )
                ),
                array(
                    'Text',
                    'widthSubcat',
                    array(
                        'label' => 'Enter the width of one 2nd-level or 3rd level categor\'s block (in pixels).',
                        'value' => '250px',
                    )
                ),
								 array(
                    'Text',
                    'textProduct',
                    array(
                        'label' => 'Enter teh text for \'heading\' of this widget.',
                        'value' => 'Courses we like',
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
                        'label' => "Choose from below the details that you want to show on each Course block.",
                        'multiOptions' => array(
                            'featuredLabel' => 'Featured Label',
                            'sponsoredLabel' => 'Sponsored Label',
                            'like' => 'Likes',
                            'comment' => 'Comments',
                            'rating' => 'Reviews & Ratings Count',
                            'favouriteCount'=>'Favourite',
                            'viewCount' => 'Views Count',
                            'lectureCount'=>'Lecture Count',
                            'favouriteButton' => 'Favourite Button',
                            'likeButton'=>'Like Button',
                            'title' => 'Titles',
                            'coursePhoto'=>'Course Photo',
                            'by'=>"Instructor's Name",
                            'description' => 'Show Description',
                            'creationDate' => 'Show Publish Date',
                            'discount' => 'Discount',
                            'price' => 'Price',
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
                    'course_limit',
                    array(
                        'label' => 'count (number of courses to show).',
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
        'title' => 'SNS - Courses - Tabbed Widget for Manage Courses',
        'description' => 'This widget displays Courses created, favorite, liked, rated, etc by the member viewing the manage page. Edit this widget to configure various settings.',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'courses.manage-courses',
        'requirements' => array(
        'subject' => 'courses',
        ),
        'adminForm' => 'Courses_Form_Admin_Tabbed',
    ),
    array(
        'title' => 'SNS - Courses - Course Compare widget',
        'description' => 'This widget displays a comparison between different courses with their details. This widget should be placed only on SNS - Courses - Compare Page. ',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'name' => 'courses.compare-courses-view',
        'requirements' => array(
        'subject' => 'course',
        ),
        'adminForm' => array(
            'elements' => array(
              array(
                'MultiCheckbox',
                'show_criteria',
                array(
                    'label' => "Choose the options that you want to be displayed in this widget.",
                    'multiOptions' => array(
                      'courseTitle' => 'Courses Title',
                      'coursePhoto'=>'Course Photo',
                      'by' => 'Instructor Name',
                      'description'=>'Description',
                      'creationDate'=>'Publish Date',
                      'duration'=>'Duration',
                      'price' =>'Price',
                      'discount' => 'Discount',
                      'category' => 'Category',
                      'classroomName' =>'Classroom Name & Photo (Display only when Classroom exits)',
                      'view' => 'Views Count',
                      'like' => 'Like Count',
                      'favourite' => 'Favorites Count',
                      'comment' => 'Comments Count',
                      'testCount'=>'Total Tests',
                      'lectureCount'=>'Lecture Count',
                      'rating' => 'Reviews and Ratings',
                      'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                      'addCart' => 'Add to Cart Button',
                      'addWishlist' => 'Add to wishlist Button',
                    ),
                    'escape' => false,
                )
              )
            )
        ),
    ),
    array(
        'title' => 'SNS - Courses - Profile Lectures',
        'description' => 'This widget displays Lectures on courses page.',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'courses.profile-lectures',
        'adminForm' => array(
            'elements' => array(
                array(
                'Text',
                    'limit_data',
                    array(
                        'label' => 'count (number of lecture to show).',
                        'value' => '10',
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
        'title' => 'SNS - Courses - Test Question View',
        'description' => 'This widget displays Lectures on courses page.',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'courses.question-view',
    ),
		 array(
        'title' => 'SNS - Courses - Checkout',
        'description' => '',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'courses.course-checkout',
    ),
    array(
        'title' => 'SNS - Courses - Test List View',
        'description' => 'This widget displays Lectures on courses page.',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'courses.test-list-view',
        'adminForm' => array(
            'elements' => array(
                array(
                  'Text',
                  'limit_data',
                  array(
                      'label' => 'count (number of test to show).',
                      'value' => '10',
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
        'title' => 'SNS - Courses - My Account',
        'description' => 'This widget should be placed on My Account page and display user details.',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'name' => 'courses.my-account',
        'autoEdit' => false,
    ),
		array(
        'title' => 'SNS - Courses - Test Result',
        'description' => 'This widget should be placed on test result page.',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'name' => 'courses.test-result',
        'autoEdit' => false,
    ),
		array(
        'title' => 'SNS - Courses - Lecture View',
        'description' => 'This widget should be placed on Lecture View Page.',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'name' => 'courses.lecture-view',
    ),
		array(
        'title' => 'SNS - Courses - Lecture View Sidebar',
        'description' => 'This widget should be placed on Lecture View Page.',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'name' => 'courses.lecture-view-sidebar',
        'adminForm' => array(
            'elements' => array( 
                array('Text','limit_data',
                  array(
                    'label' => 'count (number of lecture to show).',
                    'value' => '10',
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
        'title' => 'SNS - Courses - Banner with AJAX Search and Categories',
        'description' => 'This widget allows you to add an attractive banner and AJAX Search to search Courses based on their categories and locations. You can also enable Categories to be shown attractively in carousel in this widget.',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'name' => 'courses.banner-search',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
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
                            'title' => 'Course Title',
                            'category' => 'Course Categories',
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
        'title' => 'Courses - Courses Custom Offer',
        'description' => 'This widget should be placed on the Welcome page and displays courses with different designs. Also Displays Offer with timer.',
        'category' => 'Courses - Learning Management System',
        'type' => 'widget',
        'name' => 'courses.custom-offer',
        'requirements' => array(
            'subject' => 'course',
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
                    'label' => 'Choose the options that you want to be displayed in this widget.',
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
    'title' => 'SNS - Courses - Profile - Course Custom Field Info',
    'description' => 'Displays Course Custom Fields that are created & mapped from Categories Profiles fields. This widget should be placed on the “Courses - Profile View Page”',
    'category' => 'Courses - Learning Management System',
    'type' => 'widget',
    'name' => 'courses.course-info',
		'defaultParams' => array(
      'title' => "Custom Fields",
    ),
    'autoEdit' => false,
  ),
	array(
    'title' => 'SNS - Courses - Profile - Course Profile Earnings',
    'description' => 'Displays Course Course Profile Earnings. This widget should be placed on the “Courses - Profile View Page”',
    'category' => 'Courses - Learning Management System',
    'type' => 'widget',
    'name' => 'courses.course-profile-earnings',
    'autoEdit' => false,
  ),
	array(
    'title' => 'SNS - Courses - Profile - Course Certificate',
    'description' => 'Displays Course Course Certificate.',
    'category' => 'Courses - Learning Management System',
    'type' => 'widget',
    'name' => 'courses.course-certificate',
		'defaultParams' => array(
      'title' => "Custom Fields",
    ),
    'autoEdit' => false,
  ),
	 array(
    'title' => 'SNS - Courses - Welcome Page Banner',
    'description' => 'Displays Course Welcome Page Banner”',
    'category' => 'Courses - Learning Management System',
    'type' => 'widget',
    'name' => 'courses.welcome-banner',
    'adminForm' => array(
        'elements' => array(             
            array(
                'Text',
                'heading',
                array(
                    'label' => 'Enter Heading of Banner.',
                )
            ),
            array(
                'Text',
                'description',
                array(
                    'label' => 'Enter Text for banner',
                )
            ),
            array(
                'Text',
                'button1Title',
                array(
                    'label' => 'Enter Titile for button 1',
                )
            ),
            array(
                'Text',
                'button1Link',
                array(
                    'label' => 'Enter Link for button 1',
                )
            ),
            array(
                'Text',
                'button2Title',
                array(
                    'label' => 'Enter Titile for button 2',
                )
            ),
            array(
                'Text',
                'button2Link',
                array(
                    'label' => 'Enter Link for button 2',
                )
            ),
            array(
                'Radio',
                'video_type',
                array(
                    'label' => 'choose type of video',
                    'multiOptions'=>array(
                        'uploaded' => 'Use Uploaded video',
                        'embed' => 'Use video Url'
                    )
                )
            ),
            array(
                'Select',
                'video',
                array(
                    'label' => 'Choose the Video to show In this widget.',
                    'multiOptions'=>$banner_video
                )
            ),
            array(
                'Text',
                'embedCode',
                array(
                    'label' => 'Enter the Embed Code for the Video here.',
                )
            ),
            array(
                'Select',
                'image',
                array(
                    'label' => 'Choose the  Image.',
                    'multiOptions' => $banner_options,
                    'value' => '',
                )
            ),
        ),
    ),
  ),
	 array(
    'title' => 'SNS - Courses - Welcome Features Block',
    'description' => 'Displays Course Welcome Page Banner”',
    'category' => 'Courses - Learning Management System',
    'type' => 'widget',
    'name' => 'courses.welcome-features-block',
    'adminForm' => array(
      'elements' => array(             
            array(
                'Text',
                'heading',
                array(
                    'label' => 'Enter Heading of Features Block.',
                )
            ),
            array(
                'Text',
                'headingText',
                array(
                    'label' => 'Enter Text for Features Block',
                )
            ),
            array(
                'Text',
                'description',
                array(
                    'label' => 'Enter Description for Features Block',
                )
            ),
            array(
                'Text',
                'buttonTitle',
                array(
                    'label' => 'Enter Titile for button',
                )
            ),
            array(
                'Text',
                'buttonLink',
                array(
                    'label' => 'Enter Link for button',
                )
            ),
            
            array(
                'Text',
                'block1title',
                array(
                    'label' => 'Enter Titile for Block 1',
                )
            ),
            array(
                'Text',
                'block1Text',
                array(
                    'label' => 'Enter Text for Block 1',
                )
            ),
            array(
                'Select',
                'image1',
                array(
                    'label' => 'Choose the  icon for block 1.',
                    'multiOptions' => $banner_options,
                    'value' => '',
                )
            ),
            
            array(
                'Text',
                'block2title',
                array(
                    'label' => 'Enter Titile for Block 2',
                )
            ),
            array(
                'Text',
                'block2Text',
                array(
                    'label' => 'Enter Text for Block 2',
                )
            ),
            array(
                'Select',
                'image2',
                array(
                    'label' => 'Choose the  icon for block 2.',
                    'multiOptions' => $banner_options,
                    'value' => '',
                )
            ),
            
            array(
                'Text',
                'block3title',
                array(
                    'label' => 'Enter Titile for Block 3',
                )
            ),
            array(
                'Text',
                'block3Text',
                array(
                    'label' => 'Enter Text for Block 3',
                )
            ),
            array(
                'Select',
                'image3',
                array(
                    'label' => 'Choose the  icon for block 3.',
                    'multiOptions' => $banner_options,
                    'value' => '',
                )
            ),
      
            array(
                'Text',
                'block4title',
                array(
                    'label' => 'Enter Titile for Block 4',
                )
            ),
            array(
                'Text',
                'block4Text',
                array(
                    'label' => 'Enter Text for Block 4',
                )
            ),
            array(
                'Select',
                'image4',
                array(
                    'label' => 'Choose the  icon for block 4.',
                    'multiOptions' => $banner_options,
                    'value' => '',
                )
            ),
        ),
    ),
  ),
	 array(
    'title' => 'SNS - Courses - Welcome Strip',
    'description' => 'Displays Course Welcome Page Banner”',
    'category' => 'Courses - Learning Management System',
    'type' => 'widget',
    'name' => 'courses.welcome-strip',
    'adminForm' => array(
        'elements' => array(             
            array(
                'Text',
                'heading1',
                array(
                    'label' => 'Enter First Text of Strip.',
                )
            ),
             array(
                'Text',
                'heading2',
                array(
                    'label' => 'Enter Second Text of Strip.',
                )
            ),
            array(
                'Text',
                'buttonTitle',
                array(
                    'label' => 'Enter Titile for button ',
                )
            ),
            array(
                'Text',
                'buttonLink',
                array(
                    'label' => 'Enter Link for button ',
                )
            ),
        ),
    ),
    
  ),
	array(
    'title' => 'SNS - Courses - Welcome Members',
    'description' => 'Displays Course Welcome Page Banner”',
    'category' => 'Courses - Learning Management System',
    'type' => 'widget',
    'name' => 'courses.welcome-members',
    'adminForm' => array(
    'elements' => array(             
            array(
                'Text',
                'heading',
                array(
                    'label' => 'Enter Heading.',
                )
            ),
            array(
                'Text',
                'description',
                array(
                    'label' => 'Enter Description',
                )
            ),
            array(
                'Select',
                'showMemberLeft',
                array(
                    'label' => 'Do you want to show Member in left side of widgets',
                    'multiOptions' => array(
                      "1" => "YES",
                      "0" => "NO",
                    ),
                    'value' => '1',
                )
            ),
            array(
                'Select',
                'MemberLevelLeft',
                array(
                    'label' => 'Which profile types members do want to show on left side of widget',
                    'multiOptions' => $levelOptions,
                    'value' => '',
                )
            ),
            array(
                'Text',
                'leftMemberCount',
                array(
                    'label' => 'Count (number of member to show)',
                    'value' => 10,
                    'validators' => array(
                        array('Int', true),
                        array('GreaterThan', true, array(0)),
                    ),
                )
            ),
            array(
                'Select',
                'showMemberRight',
                array(
                    'label' => 'Do you want to show Member in Right side of widgets',
                    'multiOptions' => array(
                      "1" => "YES",
                      "0" => "NO",
                    ),
                    'value' => '1',
                )
            ),
            array(
                'Select',
                'MemberLevelRight',
                array(
                    'label' => 'Which profile types members do want to show on Right side of widget',
                    'multiOptions' => $levelOptions,
                    'value' => '',
                )
            ),
            array(
                'Text',
                'rightMemberCount',
                array(
                    'label' => 'Count (number of member to show)',
                    'value' => 10,
                    'validators' => array(
                        array('Int', true),
                        array('GreaterThan', true, array(0)),
                    ),
                )
            ),
        ),
    ),
    
  ),
  array(
    'title' => 'SNS - Courses - Top Instructors',
    'description' => 'Displays all top posters on your website.',
    'category' => 'Courses - Learning Management System',
    'type' => 'widget',
    'name' => 'courses.popular-owner-photo',
		'defaultParams' => array(
      'title' => "Custom Fields",
    ),
    'autoEdit' => true,
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
              'MultiCheckbox',
              'show_criteria',
              array(
                  'label' => "Choose the details that you want to be shown in this widget.",
                  'multiOptions' => array(
                      'by' => "Instructor's Name",
                      'courseCount' => 'Courses Count',
                      'testCount' => 'Tests Count',
                      'lectureCount' => 'Lectures Count',
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
              'Select',
              'contentInsideOutside',
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
              'label' => "Show Grid View Data on Mouse Over",
              'multiOptions' => array(
                  '1' => 'Yes,show data on Mouse Over',
                  '0' => 'No,don\'t show data on Mouse Over',
              ),
              'value'=>'1',
            )
          ),
          array(
              'Text',
              'limit_data',
              array(
                  'label' => 'Count (number of Instructor to show).',
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
)
?>
