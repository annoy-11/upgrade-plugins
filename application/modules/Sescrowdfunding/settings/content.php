<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: content.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$categories = array();
if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfunding.pluginactivated')) {
  $categories = Engine_Api::_()->getDbtable('categories', 'sescrowdfunding')->getCategoriesAssoc();
}

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

$banner_options[] = '';
$path = new DirectoryIterator(APPLICATION_PATH . '/public/admin/');
foreach ($path as $file) {
if ($file->isDot() || !$file->isFile())
    continue;
$base_name = basename($file->getFilename());
if (!($pos = strrpos($base_name, '.')))
    continue;
$extension = strtolower(ltrim(substr($base_name, $pos), '.'));
//     if (!in_array($extension, array('gif', 'jpg', 'jpeg', 'png')))
//       continue;
$banner_options['public/admin/' . $base_name] = $base_name;
}

return array(
  array(
    'title' => 'SES - Crowdfunding - Tabbed widget for Popular Crowdfunding',
    'description' => 'This widget displays a Tabbed Widget for Popular Crowdfunding on your website based on various popularity criteria. Edit this widget to choose tabs to be shown in this widget. This widget can be placed anywhere on your website.',
    'category' => 'SES - Crowdfunding Plugin',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sescrowdfunding.tabbed-widget',
    'adminForm' => 'Sescrowdfunding_Form_Admin_Tabbed',
  ),
	array(
		'title' => 'SES - Advanced Crowdfunding - Content Profile Crowdfundings',
		'description' => 'This widget enables you to allow users to create crowdfundings on different content on your website like Groups. Place this widget on the content profile page, for example SE Group to enable group owners to create crowdfundings in their Groups. You can choose the visibility of the crowdfundings created in a content to only that content or show in this plugin as well from the "Crowdfundings Created in Content Visibility" setting in Global setting of this plugin.',
		'category' => 'SES - Crowdfunding Plugin',
		'type' => 'widget',
		'autoEdit' => true,
		'name' => 'sescrowdfunding.other-modules-profile-sescrowdfundings',
		'requirements' => array(
			'subject' => 'user',
		),
		'adminForm' => 'Sescrowdfunding_Form_Admin_OtherModulesTabbed',
	),
array(
        'title' => 'SES - Crowdfunding - Category Carousel',
        'description' => 'Displays categories in a carousel. The placement criteria of this widget depends upon the chosen criteria for this widget.',
        'category' => 'SES - Crowdfunding Plugin',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sescrowdfunding.category-carousel',
        'adminForm' => array(
            'elements' => array(
                $titleTruncation,
                $descriptionTruncation,
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
                            'most_page' => 'Categories with maximum crowdfundings first',
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
                            'countCrowdfundings' => 'Crowdfunding count in each category',
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
                        'label' => 'Count (number of category to show in this widget,put 0 for unlimited).',
                        'value' => 10,
                    )
                ),
            )
        ),
    ),
  array(
    'title' => 'SES - Crowdfunding - Crowdfunding Owners FAQs',
    'description' => 'This widget shows Crowdfunding Owners FAQs entered by Admin and should placed on SES - Crowdfunding - Crowdfunding Owner FAQs Page.',
    'category' => 'SES - Crowdfunding Plugin',
    'type' => 'widget',
    'name' => 'sescrowdfunding.crowdfunding-owner-faqs',
  ),
  array(
    'title' => 'SES - Crowdfunding - Donor FAQs',
    'description' => 'This widget shows Donor FAQs entered by Admin  and should placed on SES - Crowdfunding - Crowdfunding Donor FAQs Page.',
    'category' => 'SES - Crowdfunding Plugin',
    'type' => 'widget',
    'name' => 'sescrowdfunding.donor-faqs',
  ),
    array(
        'title' => 'SES - Crowdfunding - Create New Crowdfunding Link',
        'description' => 'Displays a link to create a new crowdfunding.',
        'category' => 'SES - Crowdfunding Plugin',
        'type' => 'widget',
        'name' => 'sescrowdfunding.browse-menu-quick',
        'autoEdit' => false,
    ),
  array(
    'title' => 'SES - Crowdfunding - Crowdfunding Navigation Menu',
    'description' => 'This widget displays a Navigation Menu bar in the Crowdfunding pages for Crowdfunding Home, Browse Crowdfunding, Browse Categories, etc pages.',
    'category' => 'SES - Crowdfunding Plugin',
    'type' => 'widget',
    'name' => 'sescrowdfunding.browse-menu',
    'requirements' => array(
      'no-subject',
    ),
  ),
  array(
    'title' => 'SES - Crowdfunding - Profile Map',
    'description' => 'Displays crowdfunding location on map on it\'s profile.',
    'category' => 'SES - Crowdfunding Plugin',
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-map',
    'defaultParams' => array(
      'title' => 'Map',
      'titleCount' => true,
    ),
  ),
  array(
    'title' => 'SES - Crowdfunding - Profile Photos Slideshow',
    'description' => 'This widget display Profile Photos Slideshow & should be placed only on "SES - Crowdfunding - Crowdfunding View Page."',
    'category' => 'SES - Crowdfunding Plugin',
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-photos-slideshow',
    'autoEdit' => true,
  ),
    array(
        'title' => 'SES - Crowdfunding - Profile Overview',
        'description' => 'This widget displays Overview of the Crowdfunding on "SES - Crowdfunding - Crowdfunding View page".',
        'category' => 'SES - Crowdfunding Plugin',
        'type' => 'widget',
        'name' => 'sescrowdfunding.crowdfunding-overview',
        'requirements' => array(
            'crowdfunding',
        ),
    ),
    array(
        'title' => 'SES - Crowdfunding - Profile Cover',
        'description' => 'This widget displays Cover Photo & should be placed only on "SES - Crowdfunding - Crowdfunding View Page."',
        'category' => 'SES - Crowdfunding Plugin',
        'type' => 'widget',
        'name' => 'sescrowdfunding.profile-cover',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array (
                array(
                    'Radio',
                    'desgin',
                    array(
                        'label' => "Choose Cover Template",
                        'multiOptions' => array(
                        'desgin1' => 'Template - 1',
                        'desgin2' => 'Template - 2',
                        ),
                        'value' => 'desgin1',
                    )
                ),
                array(
                'MultiCheckbox',
                'show_criteria',
                array(
                    'label' => "Choose from below the details that you want to show for crowdfunding in this widget.",
                    'multiOptions' => array(
                    'like' => 'Likes Count',
                    'comment' => 'Comments Count',
                    'view' => 'Views Count',
                    'rating' => 'Ratings Count',
                    'location' => "Location",
                    'by' => 'Crowdfunding Owner\'s Name and Owner\'s Photo',
                    'likeButton' => 'Like Button',
                    'category' => 'Category',
                    'donation' => 'Donation Amount Information',
                    'socialSharing' => 'Social Share Button <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                    ),
                    'escape' => false,
                )
                ),
            ),
        ),
   ),
  array(
    'title' => 'SES - Crowdfunding - Profile Description',
    'description' => 'This widget displays full Description of Crowdfunding. This widget should be placed only on "SES - Crowdfunding - Crowdfunding View Page."',
    'category' => 'SES - Crowdfunding Plugin',
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-description',
    'autoEdit' => true,
    'adminForm' => array(
        'elements' => array (
            array(
                'MultiCheckbox',
                'showcriteria',
                array(
                    'label' => "Choose from below the details that you want to show in this widget.",
                    'multiOptions' => array(
                    'shourtdec' => 'Short Descripotion',
                    'slide' => 'Photo Slideshow',
                    'description' => 'Description',
                    'otherinfo' => "Other Info",
                    'share' => "Social Share",
                    'likebutton' => "Like Button",
                    ),
                ),
            ),
        ),
    ),
  ),
  array(
    'title' => 'SES - Crowdfunding - Profile About Crowdfunding Owner',
    'description' => 'Displays details of Crowdfunding Owner. This widget should be placed only on "SES - Crowdfunding - Crowdfunding View Page."',
    'category' => 'SES - Crowdfunding Plugin',
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-aboutme',
    'autoEdit' => false,
  ),
  array(
    'title' => 'SES - Crowdfunding - Profile Donors Information (Sidebar)',
    'description' => 'This widget displays Donors name, amount etc that they have donated on a crowdfunding. This widget should be placed only on "SES - Crowdfunding - Crowdfunding View Page." in left / right sidebar.',
    'category' => 'SES - Crowdfunding Plugin',
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-donors-sidebar',
    'autoEdit' => true,
    'adminForm' => array(
			'elements' => array (
        array(
          'MultiCheckbox',
          'show_criteria',
          array(
            'label' => "Choose from below the details that you want to show for crowdfunding in this widget.",
            'multiOptions' => array(
              'donationAmount' => 'Donation Amount',
             // 'seeAll' => 'See All',
              'date' => 'Ordered Date',
            ),
          )
        ),
        array(
          'Text',
          'itemCount',
          array(
            'label' => 'Enter the limit of donors to be shown in this widget.',
            'value' => 3,
          )
        ),
			),
		),
  ),
	array(
    'title' => 'SES - Crowdfunding - Profile Donors Information',
    'description' => 'This widget displays Donors name, amount etc that they have donated on a crowdfunding. This widget should be placed only on "SES - Crowdfunding - Crowdfunding View Page." in middle or extended column.',
    'category' => 'SES - Crowdfunding Plugin',
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-donors',
    'autoEdit' => true,
    'adminForm' => array(
			'elements' => array (
        array(
          'MultiCheckbox',
          'show_criteria',
          array(
            'label' => "Choose from below the details that you want to show for crowdfunding in this widget.",
            'multiOptions' => array(
              'donationAmount' => 'Donation Amount',
              'date' => 'Ordered Date',
            ),
          )
        ),
        array(
          'Text',
          'itemCount',
          array(
            'label' => 'Enter the limit of donors to be shown in this widget.',
            'value' => 3,
          )
        ),
			),
		),
  ),
    array(
        'title' => 'SES - Crowdfunding - Profile Rewards',
        'description' => 'This widget displays the rewards posted by Crowdfunding Owners (fundraisers) from their Crowdfunding Dashboards. This widget should be placed on the "SES - Crowdfunding - Crowdfunding View page".',
        'category' => 'SES - Crowdfunding Plugin',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sescrowdfunding.profile-rewards',
        'adminForm' => array(
            'elements' => array(
                array(
                    'Text',
                    'limit_data',
                    array(
                        'label' => 'Count (number of rewards to show).',
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
        'title' => 'SES - Crowdfunding - Profile Announcements',
        'description' => 'This widget displays the Announcements posted by crowdfunding owners from their crowdfunding Dashboards. This widget should be placed on the "SES - Crowdfunding - Crowdfunding View page".',
        'category' => 'SES - Crowdfunding Plugin',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sescrowdfunding.profile-announcements',
        'adminForm' => array(
            'elements' => array(
                array(
                    'Text',
                    'limit_data',
                    array(
                        'label' => 'Count (number of crowdfunding announcements to show).',
                        'value' => 5,
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
    'title' => 'SES - Crowdfunding - Profile Crowdfunding Owner\'s Photo',
    'description' => 'This widget displays crowdfunding Owner\'s photo. This widget should be placed only on "SES - Crowdfunding - Crowdfunding View Page."',
    'category' => 'SES - Crowdfunding Plugin',
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-owner-photo',
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
          'height',
          array(
            'label' => 'Enter the height (in pixels).',
            'value' => '150',
          )
        ),
        array(
          'Text',
          'width',
          array(
            'label' => 'Enter the width (in pixels).',
            'value' => '150',
          )
        ),
			),
		),
  ),
  array(
    'title' => 'SES - Crowdfunding - Profile Options',
    'description' => 'Displays a menu of actions (edit, report, share, etc) that can be performed on crowdfunding on its profile. The recommended page for this widget is "SES - Crowdfunding - Crowdfunding View Page".',
    'category' => 'SES - Crowdfunding Plugin',
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-options',
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
    'title' => 'SES - Crowdfunding - Profile Goal',
    'description' => 'This widget displays the crowdfunding Goal amount with its status. The recommended page for this widget is "SES - Crowdfunding - Crowdfunding View Page".',
    'category' => 'SES - Crowdfunding Plugin',
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-goal',
    'autoEdit' => false,
  ),
//     array(
//         'title' => 'SES - Crowdfunding - Crowdfunding Profile - Advance Share Widget',
//         'description' => 'This widget allow users to share the current crowdfunding on your website and on other social networking websites.',
//         'category' => 'SES - Crowdfunding Plugin',
//         'type' => 'widget',
//         'name' => 'sescrowdfunding.advance-share',
//         'autoEdit' => true,
//         'adminForm' => array(
//             'elements' => array(
//                 array(
//                     'MultiCheckbox',
//                     'advShareOptions',
//                     array(
//                         'label' => "Choose options to be shown in Advance Share in this widget.",
//                         'multiOptions' => array(
//                             'privateMessage' => 'Private Message',
//                             'siteShare' => 'Site Share',
//                             'quickShare' => 'Quick Share',
//                             'tellAFriend' => 'Tell A Friend',
//                             'addThis' => 'Add This Share Links',
//                         ),
//                     )
//                 ),
//             ),
//         ),
//     ),
  array(
    'title' => 'SES - Crowdfunding - Profile Advanced Share Widget',
    'description' => 'This widget allow users to share the current Crowdfunding on your website and on other social networking websites. The recommended page for this widget is "SES - Crowdfunding - Crowdfunding View Page".',
    'category' => 'SES - Crowdfunding Plugin',
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-advance-share',
    'autoEdit' => true,
    'adminForm' => 'Sescrowdfunding_Form_Admin_Share',
  ),
  array(
    'title' => 'SES - Crowdfunding - Profile Breadcrumb',
    'description' => 'This widget displays Breadcrumb for Crowdfunding. This widget should be placed on the "SES - Crowdfunding - Crowdfunding View Page" of the selected content type.',
    'category' => 'SES - Crowdfunding Plugin',
    'type' => 'widget',
    'name' => 'sescrowdfunding.profile-breadcrumb',
    'autoEdit' => true,
  ),
  array(
    'title' => 'SES - Crowdfunding - Profile Featured Label',
    'description' => 'This widget displays Featured label on Crowdfunding Profile Page. The recommended page for this widget is "SES - Crowdfunding - Crowdfunding View Page".',
    'category' => 'SES - Crowdfunding Plugin',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sescrowdfunding.profile-featured-labels',
  ),
  array(
    'title' => 'SES - Crowdfunding - Profile Crowdfunding\'s Like Button',
    'description' => 'This widget displays like button for crowdfunding & should be placed on "SES - Crowdfunding - Crowdfunding View Page" only.',
    'category' => 'SES - Crowdfunding Plugin',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sescrowdfunding.profile-like-button',
  ),
  array(
    'title' => 'SES - Crowdfunding - Profile Similar Crowdfunding',
    'description' => 'This widget displays Crowdfunding similar to the current Crowdfunding based on the Crowdfunding Category. The recommended page for this widget is "SES - Crowdfunding - Crowdfunding View Page".',
    'category' => 'SES - Crowdfunding Plugin',
    'type' => 'widget',
		'autoEdit' => true,
    'name' => 'sescrowdfunding.profile-similar-crowdfundings',
    'adminForm' => array(
      'elements' => array (
        array(
          'Select',
          'viewType',
          array(
            'label' => 'Choose the view type.',
            'multiOptions' => array(
              "list" => "List",
              "grid" => "Grid View",
            )
          ),
          'value' => 'list'
        ),
        array(
          'MultiCheckbox',
          'show_criteria',
          array(
            'label' => "Choose from below the details that you want to show for crowdfunding in this widget.",
            'multiOptions' => array(
              'like' => 'Likes Count',
              'comment' => 'Comments Count',
              'view' => 'Views Count',
              'title' => 'Crowdfunding Title',
              'by' => 'Crowdfunding Owner\'s Name',
              'featuredLabel' => 'Featured Label',
              'sponsoredLabel' => 'Sponsored Label',
              'verifiedLabel' => 'Verified Label',
              'likeButton' => 'Like Button',
              'category' => 'Category',
              'socialSharing' => 'Social Share Button <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
              'description' => "Description",
              "viewButton" => "View Button",
            ),
            'escape' => false,
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
          'limit_data',
          array(
            'label' => 'Count (number of crowdfunding to show).',
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
    'title' => 'SES - Crowdfunding - Popular / Featured / Sponsored / Verified Crowdfunding',
    'description' => 'This widget displays Popular/ Featured / Sponsored & Verified Crowdfunding as chosen by you based on chosen criteria. This widget should place on "SES - Crowdfundng - Crowdfunding View page", Browse Categories page etc .',
    'category' => 'SES - Crowdfunding Plugin',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sescrowdfunding.sidebar-widget',
    'adminForm' => array(
      'elements' => array(
        array(
          'Select',
          'viewType',
          array(
            'label' => 'Choose the view type.',
            'multiOptions' => array(
              "list" => "List",
              "grid" => "Grid View",
            )
          ),
          'value' => 'list'
        ),
        array(
          'Select',
          'criteria',
          array(
            'label' => "Display Content",
            'multiOptions' => array(
              '5' => 'All',
              '1' => 'Only Featured',
              '2' => 'Only Sponsored',
              '3' => 'Only Verified',
              '4' => 'All except Featured & Sponsored',
            ),
            'value' => 5,
          )
        ),
        array(
          'Select',
          'order',
          array(
            'label' => 'Duration criteria for the crowdfunding to be shown in this widget',
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
              "most_donated" => "Most Donated",
            )
          ),
          'value' => 'recently_created',
        ),
        array(
          'MultiCheckbox',
          'show_criteria',
          array(
            'label' => "Choose from below the details that you want to show for crowdfunding in this widget.",
            'multiOptions' => array(
              'featuredLabel' => "Featured Label",
              'sponsoredLabel' => 'Sponsored Label',
              'verifiedLabel' => 'Verified Label',
              'like' => 'Likes Count',
              'comment' => 'Comments Count',
              'view' => 'Views Count',
              'title' => 'Crowdfunding Title',
              'by' => 'Crowdfunding Owner\'s Name',
              'category' => 'Category',
              'rating' => 'Ratings Count',
              'socialSharing' => 'Social Share Buttons for Grid view only <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
              'likeButton' => 'Like Button for Grid view only',
              "description" => "Description",
              "viewButton" => "View Button",
            ),
            'escape' => false,
          )
        ),
        array(
          'Text',
          'title_truncation',
          array(
            'label' => 'Crowdfunding title truncation limit.',
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
            'label' => 'Crowdfunding description truncation limit.',
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
            'label' => 'Count (number of crowdfunding to show).',
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
    'title' => 'SES - Crowdfunding - Crowdfunding of the Day',
    'description' => "This widget displays Crowdfunding Of The Day as chosen by you from the Edit Settings of this widget.",
    'category' => 'SES - Crowdfunding Plugin',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sescrowdfunding.of-the-day',
    'adminForm' => array(
      'elements' => array(
        array(
          'MultiCheckbox',
          'show_criteria',
          array(
            'label' => "Choose from below the details that you want to show for crowdfunding in this widget.",
            'multiOptions' => array(
              'title' => 'Title',
              'like' => 'Likes Count',
              'view' => 'Views Count',
              'comment' => 'Comment Count',
              'rating' => 'Rating Count',
              'by' => 'Owner\'s Name',
              'category' => 'Category',
              'likeButton' => 'Like Button',
              'featuredLabel' => 'Featured Label',
              'sponsoredLabel' => 'Sponsored Label',
              'verifiedLabel' => 'Verified Label',
              'socialSharing' => 'Social Sharing Buttons',
              "description" => "Description",
              "viewButton" => "View Button",
            ),
          )
        ),
        array(
          'Text',
          'title_truncation',
          array(
            'label' => 'Crowdfunding title truncation limit.',
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
            'label' => 'Crowdfunding description truncation limit.',
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
    'title' => 'SES - Crowdfunding - Popular / Featured / Sponsored / Verified Crowdfunding Carousel',
    'description' => "This widget displays Carousel of Crowdfunding as configured by you based on chosen criteria for this widget. You can also choose to show Crowdfunding of specific Categories in this widget.",
    'category' => 'SES - Crowdfunding Plugin',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sescrowdfunding.carousel',
    'adminForm' => array(
      'elements' => array(
        array(
          'Text',
          'slidesToShow',
            array(
            'label' => 'Enter number of slides to be shown at once.',
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
              '0' => 'All',
              '1' => 'Only Featured',
              '2' => 'Only Sponsored',
              '3' => 'Only Verified',
            ),
            'value' => 0,
          )
        ),
        array(
          'Select',
          'order',
          array(
            'label' => 'Duration criteria for the crowdfunding to be shown in this widget',
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
            )
          ),
          'value' => 'recently_created',
        ),
//         array(
//           'Select',
//           'isfullwidth',
//           array(
//             'label' => 'Do you want to show carousel in full width?',
//             'multiOptions'=>array(
//               1=>'Yes',
//               0=>'No'
//             ),
//             'value' => 1,
//           )
//         ),
        array(
          'Select',
          'autoplay',
          array(
            'label' => "Do you want to enable autoplay of crowdfunding?",
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
            'label' => 'Delay time for next crowdfunding when you have enabled autoplay.',
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
              'view' => 'Views Count',
              'title' => 'Crowdfunding Title',
              'by' => 'Crowdfunding Owner\'s Name',
              'rating' =>'Rating Count',
              'featuredLabel' => 'Featured Label',
              'sponsoredLabel' => 'Sponsored Label',
              'verifiedLabel' => 'Verified Label',
              'likeButton' => 'Like Button',
              'category' => 'Category',
              'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
              'description' => 'Description',
              "viewButton" => "View Button",
            ),
            'escape' => false,
          )
        ),
        array(
          'Text',
          'title_truncation',
          array(
            'label' => 'Crowdfunding title truncation limit.',
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
            'label' => 'Crowdfunding description truncation limit.',
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
//         array(
//           'Text',
//           'width',
//           array(
//             'label' => 'Enter the width of one block (in pixels).',
//             'value' => '180',
//             'validators' => array(
//               array('Int', true),
//               array('GreaterThan', true, array(0)),
//             )
//           )
//         ),
        array(
          'Text',
          'limit_data',
          array(
            'label' => 'Count (number of crowdfunding to show).',
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
    'title' => 'SES - Crowdfunding - Popular / Featured / Sponsored / Verified Crowdfunding Slideshow',
    'description' => 'This widget displays Crowdfunding Slideshow with Title, Category etc. Edit this widget to configure various settings.',
    'category' => 'SES - Crowdfunding Plugin',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sescrowdfunding.slideshow',
    'adminForm' => array(
      'elements' => array(
        array(
          'Select',
          'slideshowtype',
          array(
            'label' => "Choose the Slideshow Design",
            'multiOptions' => array(
              '1' => 'Slideshow Design - 1',
              '2' => 'Slideshow Design - 2'
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
          'criteria',
          array(
            'label' => "Display Content",
            'multiOptions' => array(
              '0' => 'All Crowdfunding',
              '1' => 'Only Featured',
              '2' => 'Only Sponsored',
              '3' => 'Only Verified',
            ),
            'value' => 1,
          )
        ),
        array(
          'Select',
          'order',
          array(
            'label' => 'Duration criteria for the crowdfunding to be shown in this widget.',
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
              "most_donated" => "Most Donated",
            )
          ),
          'value' => 'recently_created',
        ),
//         array(
//           'Select',
//           'isfullwidth',
//           array(
//             'label' => 'Do you want to show category carousel in full width?',
//             'multiOptions'=>array(
//               1=>'Yes',
//               0=>'No'
//             ),
//             'value' => 1,
//           )
//         ),
        array(
          'Select',
          'autoplay',
          array(
            'label' => "Do you want to enable autoplay of crowdfundings?",
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
            'label' => 'Delay time for next crowdfunding when you have enabled autoplay.',
            'value' => '2000',
            'validators' => array(
              array('Int', true),
              array('GreaterThan', true, array(0)),
            )
          )
        ),

//         array(
//           'Select',
//           'navigation',
//           array(
//             'label' => "Do you want to show buttons or circles to navigate to next slide.",
//             'multiOptions' => array(
//               'nextprev'=>'Show buttons',
//               'buttons'=>'Show circle'
//             ),
//           ),
//         ),
        array(
          'MultiCheckbox',
          'show_criteria',
          array(
            'label' => "Choose from below the details that you want to show for crowdfundings in this widget.",
            'multiOptions' => array(
              'featuredLabel' => 'Featured Label',
              'sponsoredLabel' => 'Sponsored Label',
              'verifiedLabel' => 'Verified Label',
              'like' => 'Likes Count',
              'comment' => 'Comments Count',
              'view' => 'Views Count',
              'title' => 'Crowdfunding Title',
              'by' => 'Crowdfunding Owner\'s Name',
              'rating' =>'Rating Count',
              'likeButton' => 'Like Button',
              'category' => 'Category',
              'description' => 'Description',
              'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
              'likeButton' => 'Like Button',
              'viewButton' => 'View Button',
            ),
            'escape' => false,
          )
        ),
        array(
          'Text',
          'title_truncation',
          array(
            'label' => 'Crowdfunding title truncation limit.',
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
            'label' => 'Crowdfunding description truncation limit.',
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
            'label' => 'Count (number of crowdfunding to show).',
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
    'title' => 'SES - Crowdfunding - Crowdfunding Browse Search',
    'description' => 'This widget displays a Search form in the "SES - Crowdfunding - Browse Crowdfunding Page" as configured by you.',
    'category' => 'SES - Crowdfunding Plugin',
    'type' => 'widget',
    'name' => 'sescrowdfunding.browse-search',
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
              'mostSPrated' => 'Most Rated',
              'mostSPdonated' => 'Most Donated',
              'featured' => 'Only Featured',
              'sponsored' => 'Only Sponsored',
              'verified' => 'Only Verified',
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
              'mostSPdonated' => 'Most Donated',
              'featured' => 'Only Featured',
              'sponsored' => 'Only Sponsored',
              'verified' => 'Only Verified',
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
            'label' => "Show \'Search Crowdfunding Keyword\' search field?",
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
      ),
    ),
  ),
  array(
    'title' => 'SES - Crowdfunding - Browse Crowdfunding',
    'description' => 'This widget display all Crowdfunding on your website. The recommended page for this widget is "SES -Crowdfunding - Browse Crowdfunding Page".',
    'category' => 'SES - Crowdfunding Plugin',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sescrowdfunding.browse-crowdfundings',
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
              'featuredLabel' => 'Featured Label',
              'sponsoredLabel' => 'Sponsored Label',
              'verifiedLabel' => 'Verified Label',
              'likeButton' => 'Like Button',
              'socialSharing' => 'Social Share Button <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
              'like' => 'Likes Count',
              'comment' => 'Comments Count',
              'ratingStar' => 'Ratings Star',
              'rating' => 'Ratings Count',
              'view' => 'Views Count',
              'title' => 'Crowdfunding Title',
              'category' => 'Category',
              'by' => 'Crowdfunding Owner Name',
              'viewButton' => 'View Button',
              'descriptionlist' => 'Description (In List View)',
              'descriptiongrid' => 'Description (In Grid View)',
            ),
            'escape' => false,
          )
        ),
				array(
					'Select',
					'sort',
					array(
						'label' => 'Choose Crowdfunding Display Criteria.',
						'multiOptions' => array(
						"recentlySPcreated" => "Recently Created",
						"mostSPviewed" => "Most Viewed",
						"mostSPliked" => "Most Liked",
						"mostSPated" => "Most Rated",
						"mostSPdonated" => "Most Donated",
						"mostSPcommented" => "Most Commented",
						'featured' => 'Only Featured',
                        'sponsored' => 'Only Sponsored',
                        'verified' => 'Only Verified',
						),
					),
                    'value' => 'recentlySPcreated',
				),
				array(
					'Select',
					'show_item_count',
					array(
						'label' => 'Do you want to show crowdfunding count in this widget?',
						'multiOptions' => array(
							'1' => 'Yes',
							'0' => 'No',
						),
						'value' => '0',
					),
				),
				array(
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
        ),
				array(
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
        ),

				array(
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
        ),
				array(
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
        ),
				array(
          'Text',
          'height_list',
          array(
            'label' => 'Enter the height of main photo block in List Views (in pixels).',
            'value' => '230',
          )
        ),
				array(
          'Text',
          'width_list',
          array(
            'label' => 'Enter the width of main photo block in List Views (in pixels).',
            'value' => '260',
          )
        ),
				array(
          'Text',
          'height_grid',
          array(
            'label' => 'Enter the height of one block in Grid Views (in pixels).',
            'value' => '270',
          )
        ),
				array(
          'Text',
          'width_grid',
          array(
            'label' => 'Enter the width of one block in Grid Views (in pixels).',
            'value' => '389',
          )
        ),
				array(
					'Text',
					'limit_data_grid',
					array(
						'label' => 'Count for Grid Views (number of crowdfunding to show).',
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
						'label' => 'Count for List Views (number of crowdfunding to show).',
						'value' => 20,
						'validators' => array(
							array('Int', true),
							array('GreaterThan', true, array(0)),
						)
					)
				),
        array(
          'Radio',
          'pagging',
          array(
            'label' => "Do you want the crowdfunding to be auto-loaded when users scroll down the page?",
            'multiOptions' => array(
              'auto_load' => 'Yes, Auto Load',
              'button' => 'No, show \'View more\' link.',
              'pagging' => 'No, show \'Pagination\'.'
            ),
            'value' => 'auto_load',
          )
        ),
      )
    ),
  ),
  array(
		'title' => 'SES - Crowdfunding - Category Banner Widget',
		'description' => 'This widget displays a Banner for Categories. You can place this widget at "SES - Crowdfunding - Browse Categories Page" on your website.',
		'category' => 'SES - Crowdfunding Plugin',
		'type' => 'widget',
		'autoEdit' => true,
		'name' => 'sescrowdfunding.banner-category',
		'adminForm' => 'Sescrowdfunding_Form_Admin_Categorywidget',
	),
  array(
    'title' => 'SES - Crowdfunding - Category View Page Widget',
    'description' => 'This widget displays a view page for Categories. You can place this widget only at "SES - Crowdfunding - Category View Page".',
    'category' => 'SES - Crowdfunding Plugin',
    'type' => 'widget',
    'name' => 'sescrowdfunding.category-view',
    'requirements' => array(
        'subject' => 'crowdfunding',
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
          'MultiCheckbox',
          'show_criteria',
          array(
            'label' => "Choose from below the details that you want to show on each album block.",
            'multiOptions' => array(
              'featuredLabel' => 'Featured Label',
              'sponsoredLabel' => 'Sponsored Label',
              'verifiedLabel' => 'Verified Label',
              'like' => 'Likes',
              'comment' => 'Comments',
              'rating' => 'Rating Count',
              'view' => 'Views',
              'title' => 'Titles',
              'by' => 'Item Owner Name',
              'category' => "Category",
              'description' => 'Show Description',
              'socialshare' => 'Social Share Icons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
              'likeButton' => "Like Button",
              'viewButton' => 'View Button',
            ),
            'escape' => false,
          )
        ),
        array(
          'Radio',
          'pagging',
          array(
            'label' => "Do you want the crowdfunding to be auto-loaded when users scroll down the page?",
            'multiOptions' => array(
              'auto_load' => 'Yes, Auto Load',
              'button' => 'No, show \'View more\' link.',
              //'pagging' => 'No, show \'Pagination\'.'
            ),
            'value' => 'auto_load',
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
          'crowdfunding_limit',
          array(
              'label' => 'count (number of crowdfunding to show).',
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
              'label' => 'Enter the height block (in pixels).',
              'value' => '160',
          )
        ),
        array(
          'Text',
          'width',
          array(
              'label' => 'Enter the width block (in pixels).',
              'value' => '300',
          )
        )
      )
    ),
  ),
  array(
		'title' => 'SES - Crowdfunding - Category View Banner Widget',
		'description' => 'This widget displays a Banner for Category View. This widget should be place on "SES - Crowdfunding Category View Page".',
		'category' => 'SES - Crowdfunding Plugin',
		'type' => 'widget',
		'autoEdit' => true,
		'name' => 'sescrowdfunding.category-view-banner',
	),
  array(
    'title' => 'SES - Crowdfunding - Categories Hierarchy View',
    'description' => 'This widget displays all Categories of Crowdfunding in Hierarchy View. Edit this widget to choose various other settings.',
    'category' => 'SES - Crowdfunding Plugin',
    'type' => 'widget',
    'name' => 'sescrowdfunding.category-sidebar',
    'autoEdit' => true,
  ),
  array(
    'title' => 'SES - Crowdfunding - Categories Square Block View',
    'description' => 'This widget displays all categories of Crowdfunding in Square Blocks. Edit this widget to configure various settings.',
    'category' => 'SES - Crowdfunding Plugin',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sescrowdfunding.category-squareview',
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
            'label' => "Do you want to show only those categories under which atleast 1 crowdfunding is posted?",
            'multiOptions' => array(
                '1' => 'Yes, show only categories with crowdfundings',
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
              'most_crowdfunding' => 'Most Crowdfunding Category First',
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
              'countCrowdfundings' => 'Crowdfunding count in each category',
            ),
          )
        ),
      ),
    ),
  ),
  array(
    'title' => 'SES - Crowdfunding - Categories Icon View',
    'description' => 'This widget displays all Categories of Crowdfunding in Icon View with their icon. Edit this widget to configure various settings.',
    'category' => 'SES - Crowdfunding Plugin',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sescrowdfunding.category-icons',
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
              'most_crowdfunding' => 'Categories with maximum Crowdfunding first',
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
              'countCrowdfundings' => 'Crowdfunding count in each category',
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
    'title' => 'SES - Crowdfunding - Category Based Crowdfunding Block View',
    'description' => 'This widget displays Crowdfunding in attractive Square Block View on the basis of their Categories. This widget can be placed any where on your website.',
    'category' => 'SES - Crowdfunding Plugin',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sescrowdfunding.category-associate-crowdfunding',
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
              'view' => 'Views Count',
              'title' => 'Title',
              'by' => 'Crowdfunding Owner\'s Name',
              'category' => 'Category',
              'featuredLabel' => 'Featured Label',
              'sponsoredLabel' => 'Sponsored Label',
              'verifiedLabel' => 'Verified Label',
              'socialshare' => 'Social Share Button <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
              'likeButton' => 'Like Button',
              'viewButton' => 'View Button',
            ),
            'escape' => false,
          )
        ),
        array(
          'Radio',
          'popularity_crowdfunding',
          array(
            'label' => 'Choose Crowdfunding Display Criteria.',
            'multiOptions' => array(
              "creationdate" => "Recently Created",
              "viewcount" => "Most Viewed",
              "likecount" => "Most Liked",
              "rating" => "Most Rated",
              "commentcount" => "Most Commented",
              'featured' => 'Only Featured',
              'sponsored' => 'Only Sponsored',
              'verified' => 'Only Verified',
            ),
            'value' => 'creationdate',
          )
        ),
        array(
          'Radio',
          'pagging',
          array(
            'label' => "Do you want the crowdfunding to be auto-loaded when users scroll down the page?",
            'multiOptions' => array(
              'autoload' => 'Yes, Auto Load',
              'button' => 'No, show \'View more\' link.',
//               'pagging' => 'No, show \'Pagination\'.'
            ),
            'value' => 'button',
          )
        ),
//         array(
//           'Select',
//           'count_crowdfunding',
//           array(
//             'label' => "Show crowdfundings count in each category.",
//             'multiOptions' => array(
//               '1' => 'Yes',
//               '0' => 'No'
//             ),
//           ),
//         ),
        array(
          'Select',
          'criteria',
          array(
            'label' => "Choose Popularity Criteria.",
            'multiOptions' => array(
                'alphabetical' => 'Alphabetical Order',
                'most_crowdfunding' => 'Categories with maximum crowdfundings first',
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
          'crowdfunding_limit',
          array(
            'label' => 'count (number of crowdfunding to show in each category. This setting will work, if you choose "Yes" for "Show crowdfunding count in each category" setting above.").',
            'value' => '8',
            'validators' => array(
              array('Int', true),
              array('GreaterThan', true, array(0)),
            )
          )
        ),
        array(
          'Text',
          'crowdfunding_description_truncation',
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
        array(
          'Text',
          'height',
          array(
            'label' => 'Enter the height of photo (in pixels).',
            'value' => '160',
          )
        ),
//         array(
//           'Text',
//           'width',
//           array(
//             'label' => 'Enter the width of photo (in pixels).',
//             'value' => '250',
//           )
//         ),
      )
    ),
  ),
  array(
      'title' => 'SES - Crowdfunding - Tags Cloud / Tab View',
      'description' => 'This widget displays all Tags of Crowdfunding in Cloud or Tab View. Edit this widget to choose various other settings.',
      'category' => 'SES - Crowdfunding Plugin',
      'type' => 'widget',
      'name' => 'sescrowdfunding.tag-cloud',
      'autoEdit' => true,
      'adminForm' => 'Sescrowdfunding_Form_Admin_Tagcloud',
  ),
  array(
      'title' => 'SES - Crowdfunding - Browse All Tags',
      'description' => 'This widget displays all Crowdfunding Tags on your website. The recommended page for this widget is "SES - Crowdfunding - Browse Tags Page".',
      'category' => 'SES - Crowdfunding Plugin',
      'type' => 'widget',
      'name' => 'sescrowdfunding.browse-tags',
  ),
  array(
    'title' => 'SES - Crowdfunding - Manage Crowdfunding',
    'description' => 'This widget displays Crowdfunding created, liked, rated, etc by the member viewing the manage page. Edit this widget to configure various settings and place on SES - Crowdfunding - Manage Crowdfunding Page .',
    'category' => 'SES - Crowdfunding Plugin',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sescrowdfunding.manage-crowdfundings',
  ),
  array(
    'title' => 'SES - Crowdfunding - My All Donations',
    'description' => 'This widget displays all user Donations. Edit this widget to configure various settings and place on SES - Crowdfunding - My All Donations Page.',
    'category' => 'SES - Crowdfunding Plugin',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sescrowdfunding.manage-all-donations',
  ),
  array(
    'title' => 'SES - Crowdfunding - Manage Received Donations',
    'description' => 'This widget displays all Received Donations and place this widget on SES - Crowdfunding - Manage Received Donations Page. Edit this widget to configure various settings.',
    'category' => 'SES - Crowdfunding Plugin',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sescrowdfunding.manage-received-donations',
  ),
  array(
    'title' => 'SES - Crowdfunding - Top Donors (Sidebar)',
    'description' => 'This widget displays list of Donors in all the crowdfunding on your website along with donation details. This widget can be placed anywhere in the right / left column of your website.',
    'category' => 'SES - Crowdfunding Plugin',
    'type' => 'widget',
    'name' => 'sescrowdfunding.top-donors-sidebar',
    'autoEdit' => true,
    'adminForm' => array(
			'elements' => array (
        array(
          'MultiCheckbox',
          'show_criteria',
          array(
            'label' => "Choose from below the details that you want to show for crowdfunding in this widget.",
            'multiOptions' => array(
              'donationAmount' => 'Donation Amount',
            ),
          )
        ),
        array(
          'Text',
          'itemCount',
          array(
            'label' => 'Enter the limit to be shown in this widget.',
            'value' => 3,
          )
        ),
			),
		),
  ),
  array(
    'title' => 'SES - Crowdfunding - Welcome Banner',
    'description' => 'This widget displays Welcome Banner.',
    'category' => 'SES - Crowdfunding Plugin',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sescrowdfunding.welcome-banner',
    'adminForm' => array(
        'elements' => array(
            array(
                'Select',
                'banner',
                array(
                    'label' => 'Choose the Banner to be shown in this widget.',
                    'multiOptions' => $banner_options,
                    'value' => 1,
                )
            ),
        ),
    ),
  ),
  array(
    'title' => 'SES - Crowdfunding - Who We Are',
    'description' => '',
    'category' => 'SES - Crowdfunding Plugin',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sescrowdfunding.who-we-are',
  ),
  array(
    'title' => 'SES - Crowdfunding - Feature Block',
    'description' => '',
    'category' => 'SES - Crowdfunding Plugin',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sescrowdfunding.feature-block',
  ),
  array(
    'title' => 'SES - Crowdfunding - Parallax Banner',
    'description' => 'This widget displays Parallax Banner.',
    'category' => 'SES - Crowdfunding Plugin',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sescrowdfunding.parallax-banner',
    'adminForm' => array(
        'elements' => array(
            array(
                'Select',
                'banner',
                array(
                    'label' => 'Choose the Banner to be shown in this widget.',
                    'multiOptions' => $banner_options,
                    'value' => 1,
                )
            ),
        ),
    ),
  ),
  array(
    'title' => 'SES - Crowdfunding - Make Community',
    'description' => 'This widget displays Make Community.',
    'category' => 'SES - Crowdfunding Plugin',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sescrowdfunding.make-community',
  ),
  array(
    'title' => 'SES - Crowdfunding - Feed Tooltip',
    'description' => '',
    'category' => 'SES - Crowdfunding Plugin',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sescrowdfunding.feed-tooltip',
  ),
);
