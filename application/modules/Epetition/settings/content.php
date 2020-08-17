<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: content.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

$headScript = new Zend_View_Helper_HeadScript();
$headScript->appendFile(Zend_Registry::get('StaticBaseUrl') . 'application/modules/Sesbasic/externals/scripts/jscolor/jscolor.js');
$headScript->appendFile(Zend_Registry::get('StaticBaseUrl') . 'application/modules/Sesbasic/externals/scripts/jquery.min.js');

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


$categories = array();
if (Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition.pluginactivated')) {
  $categories = Engine_Api::_()->getDbtable('categories', 'epetition')->getCategoriesAssoc(array('module' => true));
}
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
    'label' => 'Enter the height of main photo block in Grid Views (in pixels).',
    'value' => '230',
  )
);
$widthOfContainerGrid = array(
  'Text',
  'width_grid',
  array(
    'label' => 'Enter the width of main photo block in Grid Views (in pixels).',
    'value' => '260',
  )
);
$widthOfContainerPinboard = array(
  'Text',
  'width_pinboard',
  array(
    'label' => 'Enter the width of main photo block in Pinboard Views (in pixels).',
    'value' => '260',
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
    'value' => 'grid',
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
      'imageLabel'=>'Image',
      'signatureLable'=>'Signature',
      'verifiedLabel' => 'Verified Label',
      'favouriteButton' => 'Favourite Button',
      'likeButton' => 'Like Button',
      'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
      'like' => 'Likes Count',
      'favourite' => 'Favorites Count',
      'comment' => 'Comments Count',
      'view' => 'Views Count',
      'title' => 'Petition Title',
      'category' => 'Category',
      'by' => 'Petition Owner Name',
      'creationDate' => 'Creation Date',
      'location' => 'Location',
      'descriptionlist' => 'Description (In List View)',
      'descriptiongrid' => 'Description (In Grid View)',
      'descriptionpinboard' => 'Description (In Pinboard View)',
      'enableCommentPinboard' => 'Enable commenting in Pinboard View',
    ),
    'escape' => false,
  )
);
$pagging = array(
  'Radio',
  'pagging',
  array(
    'label' => "Do you want the petitions to be auto-loaded when users scroll down the page?",
    'multiOptions' => array(
      'auto_load' => 'Yes, Auto Load',
      'button' => 'No, show \'View more\' link.',
      'pagging' => 'No, show \'Pagination\'.'
    ),
    'value' => 'auto_load',
  )
);

return array(
  array(
    'title' => 'SNS  Petitions - Petition of the Day',
    'description' => "This widget displays petitions of the day as chosen by you from the Edit Settings of this widget.",
    'category' => 'SNS -  Petition',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'epetition.of-the-day',
    'adminForm' => array(
      'elements' => array(
        array(
          'MultiCheckbox',
          'show_criteria',
          array(
            'label' => "Choose from below the details that you want to show for petitions in this widget.",
            'multiOptions' => array(
              'title' => 'Petition Title',
              'like' => 'Likes Count',
              'view' => 'Views Count',
              'comment' => 'Comment Count',
              'favourite' => 'Favourites Count',
              'by' => 'Owner\'s Name',
              'favouriteButton' => 'Favourite Button',
              'likeButton' => 'Like Button',
              'featuredLabel' => 'Featured Label',
              'sponsoredLabel' => 'Sponsored Label',
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
            'label' => 'Petition title truncation limit.',
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
    'title' => 'SNS -  Petition - Popular / Featured / Sponsored / Verified Petitions Carousel',
    'description' => "Disaplys carousel of petitions as configured by you based on chosen criteria for this widget. You can also choose to show Petitions of specific categories in this widget.",
    'category' => 'SNS -  Petition',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'epetition.featured-sponsored-verified-category-carousel',
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
            'label' => 'Duration criteria for the petitions to be shown in this widget',
            'multiOptions' => array(
              '' => 'All Petitions',
              'week' => 'This Week Petitions',
              'month' => 'This Month Petitions',
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
            'label' => 'Do you want to show carousel in full width?',
            'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
            ),
            'value' => 1,
          )
        ),
        array(
          'Select',
          'autoplay',
          array(
            'label' => "Do you want to enable autoplay of petitions?",
            'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
            ),
          ),
        ),
        array(
          'Text',
          'speed',
          array(
            'label' => 'Delay time for next petition when you have enabled autoplay.',
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
              'title' => 'Petition Title',
              'by' => 'Petition Owner\'s Name',
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
            'label' => 'Petition title truncation limit.',
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
            'label' => 'Count (number of petitions to show).',
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
    'title' => 'SNS -  Petition - Popular / Featured / Sponsored / Verified Petitions Slideshow',
    'description' => "Displays slideshow of petitions as chosen by you based on chosen criteria for this widget. You can also choose to show Petitions of specific categories in this widget. The placement of this widget depends on the criteria chosen for this widget.",
    'category' => 'SNS -  Petition',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'epetition.featured-sponsored-verified-category-slideshow',
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
            'label' => "Display Content ( You can Display Maximum 5 Petitions )",
            'multiOptions' => array(
              '0' => 'All Petitions',
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
            'label' => 'Duration criteria for the petitions to be shown in this widget.',
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
          'autoplay',
          array(
            'label' => "Do you want to enable autoplay of petitions?",
            'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
            ),
          ),
        ),
        array(
          'MultiCheckbox',
          'show_criteria',
          array(
            'label' => "Choose from below the details that you want to show for petitions in this widget.",
            'multiOptions' => array(
              'like' => 'Likes Count',
              'comment' => 'Comments Count',
              'favourite' => 'Favourites Count',
              'view' => 'Views Count',
              'title' => 'Petition Title',
              'by' => 'Petition Owner\'s Name',
              'featuredLabel' => 'Featured Label',
              'sponsoredLabel' => 'Sponsored Label',
              'verifiedLabel' => 'Verified Label',
              'favouriteButton' => 'Favourite Button',
              'likeButton' => 'Like Button',
              'description'=>'Description',
              'category' => 'Category',
              'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
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
            'label' => 'Petition title truncation limit.',
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
            'value' => '300',
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
    'title' => 'SNS - Petitions - Petition Locations',
    'description' => 'This widget displays petitions based on their locations in Google Map.',
    'category' => 'SNS - Petition',
    'type' => 'widget',
    'name' => 'epetition.petition-location',
    'autoEdit' => true,
    'adminForm' => 'Epetition_Form_Admin_Location',
  ),


  array(
    'title' => 'SNS - Petition - Profile Petition\'s Like Button',
    'description' => 'Displays like button for petition. This widget should be only placed on SNS - Petition - Petition Profile Page and displays like button for the petition',
    'category' => 'SNS -  Petition',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'epetition.like-button',
    'defaultParams' => array(
      'title' => '',
    ),
  ),
  array(
    'title' => 'SNS -  Petition - Profile Petitions',
    'description' => 'Displays a member\'s petition entries on their profiles. The recommended page for this widget is "Member Profile Page"',
    'category' => 'SNS -  Petition',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'epetition.profile-epetitions',
    'requirements' => array(
      'subject' => 'user',
    ),
   'adminForm' => 'Epetition_Form_Admin_Tabbed',
  ),
  array(
    'title' => 'SNS -  Petition - Tabbed widget for Manage Petitions',
    'description' => 'This widget should be only placed on SNS - Petition - Manage Petitions Page & displays petitions created, favorite, liked, rated, etc by the member viewing the manage page. Edit this widget to configure various settings.',
    'category' => 'SNS -  Petition',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'epetition.manage-petitions',
    'requirements' => array(
      'subject' => 'petition',
    ),
    'adminForm' => 'Epetition_Form_Admin_Tabbed',
  ),
  array(
    'title' => 'SNS - Petition - Tabbed widget for Popular Petitions',
    'description' => 'Displays a tabbed widget for popular petitions on your website based on various popularity criterias. Edit this widget to choose tabs to be shown in this widget. This widget can be placed anywhere on your website.',
    'category' => 'SNS -  Petition',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'epetition.tabbed-widget-petition',
    'requirements' => array(
      'subject' => 'petition',
    ),
    'adminForm' => 'Epetition_Form_Admin_Tabbed',
  ),
  array(
    'title' => 'SNS Petitions - Petition Profile - Tags',
    'description' => 'Displays all tags of the current petition on Petition Profile Page. The recommended page for this widget is "SNS -  Petition - Petition Profile Page".',
    'category' => 'SNS -  Petition',
    'type' => 'widget',
    'name' => 'epetition.profile-tags',
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
    'title' => 'SNS - Petitions - Tabbed widget for Manage Signatures',
    'description' => 'This widget displays signatures added by the member viewing the manage page. Edit this widget to configure various settings.',
    'category' => 'SNS -  Petition',
    'type' => 'widget',
    'name' => 'epetition.petitions-mysignature',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'MultiCheckbox',
          'enableTabs',
          array(
            'label' => "Choose the View Type for Signatures.",
            'multiOptions' => array(
              'list' => 'List View',
              'grid' => 'Grid View',
            ),
            'value' =>'list',
          )
        ),
        array(
          'MultiCheckbox',
          'detailsdiplay',
        array(
          'label' => "Choose from below the details that you want to show in this widget?",
          'multiOptions' => array(
            'petitiontitle' => 'Petition Title',
            'signaturelocation' => 'Signature Location',
            'statement' => 'Statement',
            'reason' => 'Reason',
            'category' => 'Category',
            'submissiondate' => 'Submission Date',
          ),
         'value' => array('petitiontitle','signaturelocation','statement','reason','category','submissiondate'),
        ),
        ),


        array(
          'Radio',
          'displaystyle',
          array(
            'label' => "Do you want the signatures to be auto-loaded when users scroll down the page?",
            'multiOptions' => array(
              'autoload' => 'Yes, Auto Load',
              'viewmore' => "No, show 'View more' link",
              'pagination' => "No, show 'Pagination",
            ),
            'value' =>'autoload',
          )
        ),

        array(
          'text',
          'countshow',
          array(
            'label' => "Count (number of signatures to show)",
            'value' =>'5',
          )
        ),

      ),
    ),
  ),
  array(
    'title' => 'SNS  Petitions - Tags Cloud / Tab View',
    'description' => 'Displays all tags of petitions in cloud or tab view. Edit this widget to choose various other settings.',
    'category' => 'SNS -  Petition',
    'type' => 'widget',
    'name' => 'epetition.tag-cloud-petitions',
    'autoEdit' => true,
    'adminForm' => 'Epetition_Form_Admin_Tagcloudpetition',
  ),
  array(
    'title' => 'SNS  Petitions - Categories Cloud / Hierarchy View',
    'description' => 'Displays all categories of petitions in cloud or hierarchy view. Edit this widget to choose various other settings.',
    'category' => 'SNS -  Petition',
    'type' => 'widget',
    'name' => 'epetition.tag-cloud-category',
    'autoEdit' => true,
    'adminForm' => 'Epetition_Form_Admin_Tagcloudcategory',
  ),
  array(
    'title' => 'SNS  Petitions - Categories Icon View',
    'description' => 'Displays all categories of petitions in icon view with their icon. Edit this widget to configure various settings.',
    'category' => 'SNS -  Petition',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'epetition.petition-category-icons',
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
              'most_petition' => 'Categories with maximum petitions first',
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
              'countPetitions' => 'Petition count in each category',
	            'icon'=> 'Icon',
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
    'title' => 'SNS - Petition - Profile Petition\'s Favourite Button',
    'description' => 'Displays favourite button for petition.  This widget should be only placed on SNS - Petition - Petition Profile Page and displays favorite button.',
    'category' => 'SNS -  Petition',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'epetition.favourite-button',
    'defaultParams' => array(
      'title' => '',
    ),
  ),
  array(
    'title' => 'SNS -  Petition - Petition Tags',
    'description' => 'Change: This widget should display all Petition tags on your website. The recommended page for this widget is "SNS - Petition - Browse Tags Page',
    'category' => 'SNS -  Petition',
    'type' => 'widget',
    'name' => 'epetition.tag-petitions',
  ),
  array(
    'title' => 'SNS -  Petition - Categories Square Block View',
    'description' => 'Displays all categories of petitions in square blocks. Edit this widget to configure various settings.',
    'category' => 'SNS -  Petition',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'epetition.petition-category',
    'requirements' => array(
      'subject' => 'petition',
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
          'petition_required',
          array(
            'label' => "Do you want to show only those categories under which atleast 1 petition is posted?",
            'multiOptions' => array(
              '1' => 'Yes, show only categories with petitions',
              '0' => 'No, show all categories',
            ),
          ),
          'value' => '1'
        ),
        array(
          'Select',
          'criteria',
          array(
            'label' => "Choose Popularity Criteria.",
            'multiOptions' => array(
              'alphabetical' => 'Alphabetical Order',
              'most_petition' => 'Most Petitions Category First',
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
              'countPetitions' => 'Petition count in each category',
            ),
	          'value'=>array('title','icon','countPetitions'),
          )
        ),
      ),
    ),
  ),
  array(
    'title' => 'SNS -  Petition - Category Carousel',
    'description' => 'Displays categories in attractive carousel in this widget. The placement of this widget depends on the criteria chosen for this widget.',
    'category' => 'SNS -  Petition',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'epetition.category-carousel',
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
          'Select',
          'autoplay',
          array(
            'label' => "Do you want to enable auto play of categories?",
            'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
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
              'most_petition' => 'Categories with maximum petitions first',
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
              'countPetitions' => 'Petition count in each category',
              'socialshare' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
            ),
            'escape' => false,
	          'value'=>array('title','description','countPetitions','socialshare'),
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
              1 => 'Yes',
              0 => 'No'
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
    'title' => 'SNS -  Petition - Category View Page Widget',
    'description' => 'Displays a view page for categories. You can place this widget at view page of category on your site.',
    'category' => 'SNS -  Petition',
    'type' => 'widget',
    'name' => 'epetition.category-view',
    'requirements' => array(
      'subject' => 'petition',
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
          'radio',
          'show_banner',
          array(
            'label' => "Show category banner",
            'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No'
            ),
	          'value'=>1,
          ),
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
              'countPetition' => 'Petitions count in each category',
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
          'textPetition',
          array(
            'label' => 'Enter teh text for \'heading\' of this widget.',
            'value' => 'Petitions we like',
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
              'favourite' => 'Favourite',
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
          'petition_limit',
          array(
            'label' => 'count (number of petitions to show).',
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
    'title' => 'SNS -  Petition - Create New Petition Link',
    'description' => 'Displays a link to create new petition.',
    'category' => 'SNS -  Petition',
    'type' => 'widget',
    'name' => 'epetition.browse-menu-quick',
    'requirements' => array(
      'no-subject',
    ),
  ),
  array(
    'title' => 'SNS -  Petition - Labels',
    'description' => 'This widget displays Featured, Sponsored and Verified labels on Petition Profile Page. The recommended page for this widget is "SNS -  Petition - Petition Profile Page".',
    'category' => 'SNS -  Petition',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'epetition.labels',
  ),
  array(
    'title' => 'SNS -  Petition - People Like Petition',
    'description' => 'Placed on  a Petition view page.',
    'category' => 'SNS -  Petition',
    'type' => 'widget',
    'name' => 'epetition.people-like-item',
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
    'title' => 'SNS -  Petition - Popular / Featured / Sponsored / Verified Petitions',
    'description' => "Displays petitions as chosen by you based on chosen criteria for this widget. The placement of this widget depends on the criteria chosen for this widget.",
    'category' => 'SNS -  Petition',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'epetition.featured-sponsored',
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
            'label' => 'Duration criteria for the petitions to be shown in this widget',
            'multiOptions' => array(
              '' => 'All Petitions',
              'week' => 'This Week Petitions',
              'month' => 'This Month Petitions',
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
            'label' => "Choose from below the details that you want to show for petition in this widget.",
            'multiOptions' => array(
              'like' => 'Likes Count',
              'comment' => 'Comments Count',
              'favourite' => 'Favourites Count',
              'view' => 'Views Count',
              'title' => 'Petition Title',
              'by' => 'Petition Owner\'s Name',
              'creationDate' => 'Show Publish Date',
              'category' => 'Category',
              'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a> for Grid view only',
              'likeButton' => 'Like Button for Grid view only',
              'favouriteButton' => 'Favourite Button for Grid view only',
              'verifiedLabel' => 'Verified Label',
              'featuredLabel' => 'Featured Label',
              'sponsoredLabel' => 'Sponsored Label',
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
            'label' => 'Do you want to allow users to view more petition posters in this widget? (If you choose Yes, then users will see Next & Previous buttons to view more petition posters.)',
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
            'label' => 'Petition title truncation limit.',
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
            'label' => 'Count (number of petitions to show).',
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
    'title' => 'SNS Petition - Top Petitioners',
    'description' => 'Displays all top petitioners on your website. You can place this widget at the sidebar of any page.',
    'category' => 'SNS -  Petition',
    'type' => 'widget',
    'name' => 'epetition.top-petitions',
    'adminForm' => array(
      'elements' => array(
        array(
          'MultiCheckbox',
          'show_criteria',
          array(
            'label' => "Choose the details that you want to be shown in this widget.",
            'multiOptions' => array(
            'count' => 'Peitions Count',
            'ownername' => 'Petition Owner\'s Name',
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
            'label' => 'Do you want to allow users to view more petition posters in this widget? (If you choose Yes, then users will see Next & Previous buttons to view more petition posters.)',
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
            'label' => 'Count (number of petition posters to show).',
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
    'title' => 'SNS -  Petition - Category Banner Widget',
    'description' => 'Search & Explore Petitions according to different categories related to Health, Technology,  freedoms of speech, press, assembly, Recreation etc.',
    'category' => 'SNS -  Petition',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'epetition.banner-category',
    'requirements' => array(
      'subject' => 'petition',
    ),
    'adminForm' => 'Epetition_Form_Admin_Categorywidget',
  ),
  array(
    'title' => 'SNS -  Petition - Category Based Petitions Block View',
    'description' => 'Displays petitions in attractive square block view on the basis of their categories. This widget can be placed any where on your website.',
    'category' => 'SNS -  Petition',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'epetition.category-associate-petition',
    'requirements' => array(
      'subject' => 'petition',
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
              'view' => 'Views Count',
              'title' => 'Title',
              'favourite' => 'Favourites Count',
              'by' => 'Petition Owner\'s Name',
              'featuredLabelActive' => 'Featured Label',
              'sponsoredLabelActive' => 'Sponsored Label',
              'verifiedLabelActive' => 'Verified Label',
              'victoryLabelActive' => 'Victory Label',
              'creationDate' => 'Show Publish Date',
              'readmore' => 'Read More',
            ),
          )
        ),
        array(
          'Radio',
          'popularity_petition',
          array(
            'label' => 'Choose Petition Display Criteria.',
            'multiOptions' => array(
              "creationSPdate" => "Recently Created",
              "viewSPcount" => "Most Viewed",
              "likeSPcount" => "Most Liked",
              "commentSPcount" => "Most Commented",
              "favouriteSPcount" => "Most Favourite",
              'featured' => 'Only Featured',
              'sponsored' => 'Only Sponsored',
            ),
          )
        ),
        $pagging,
        array(
          'Select',
          'count_petition',
          array(
            'label' => "Show petitions count in each category.",
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
              'most_petition' => 'Categories with maximum petitions first',
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
          'petition_limit',
          array(
            'label' => 'count (number of petitions to show in each category. This setting will work, if you choose "Yes" for "Show petitions count in each category" setting above.").',
            'value' => '8',
            'validators' => array(
              array('Int', true),
              array('GreaterThan', true, array(0)),
            )
          )
        ),
//         array(
//           'Text',
//           'petition_description_truncation',
//           array(
//             'label' => 'Description truncation limit.',
//             'value' => 45,
//             'validators' => array(
//               array('Int', true),
//               array('GreaterThan', true, array(0)),
//             )
//           )
//         ),
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
        $heightOfContainerList,
        $widthOfContainerList,
      )
    ),
  ),
  array(
    'title' => 'SNS - Petition - Petition Navigation Menu',
    'description' => 'Displays a navigation menu bar in the Petition\'s pages for Petition Home, Browse Petition, Browse Categories, etc pages.',
    'category' => 'SNS - Petition',
    'type' => 'widget',
    'name' => 'epetition.browse-menu',
    'requirements' => array(
      'no-subject',
    ),
  ),
  array(
    'title' => 'SNS -  Petition - Browse Petitions',
    'description' => 'Display all petitions on your website. The recommended page for this widget is "SNS -  Petition - Browse Petitions Page".',
    'category' => 'SNS -  Petition',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'epetition.browse-petitions',
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
            'label' => 'Choose Petition Display Criteria.',
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
            'label' => 'Do you want to show petitions count in this widget?',
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
            'label' => 'Count for Pinboard View (number of petitions to show).',
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
            'label' => 'Count for Grid Views (number of petitions to show).',
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
            'label' => 'Count for List Views (number of petitions to show).',
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
    'title' => 'SNS -  Petition - Alphabetic Filtering of Petitions',
    'description' => "This widget displays all the alphabets for alphabetic filtering of petitions which will enable users to filter petitions on the basis of selected alphabet.",
    'category' => 'SNS - Petition',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'epetition.alphabet-search',
    'defaultParams' => array(
      'title' => "",
    ),
  ),
  array(
    'title' => 'SNS -  Petition - Petition Profile - Map',
    'description' => 'Displays a petition location on map on it\'s profile.',
    'category' => 'SNS -  Petition',
    'type' => 'widget',
    'name' => 'epetition.petition-map',
    'defaultParams' => array(
      'title' => 'Map',
      'titleCount' => true,
    ),
    'requirements' => array(
      'subject' => 'user',
    ),
  ),
  array(
    'title' => 'SNS -  Petition - Petition Profile - Similar Petitions',
    'description' => 'Displays petitions similar to the current petition based on the petition category. The recommended page for this widget is "SNS -  Petition - Petition Profile Page".',
    'category' => 'SNS -  Petition',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'epetition.similar-petitions',
    'adminForm' => array(
      'elements' => array(
        array(
          'MultiCheckbox',
          'show_criteria',
          array(
            'label' => "Choose from below the details that you want to show for petition in this widget.",
            'multiOptions' => array(
              'like' => 'Likes Count',
              'comment' => 'Comments Count',
              'favourite' => 'Favourites Count',
              'view' => 'Views Count',
              'title' => 'Petition Title',
              'by' => 'Petition Owner\'s Name',
              'featuredLabel' => 'Featured Label',
              'sponsoredLabel' => 'Sponsored Label',
              'verifiedLabel' => 'Verified Label',
              'favouriteButton' => 'Favourite Button',
              'likeButton' => 'Like Button',
              'category' => 'Category',
              'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
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
            'label' => 'Do you want to allow users to view more similar petitions in this widget? (If you choose Yes, then users will see Next & Previous buttons to view more petitions.)',
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
            'label' => 'Count (number of petitions to show).',
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
    'title' => 'SNS - Petition - Petition Signature Goal',
    'description' => 'Displays a petition signature widget. You can place this widget on petition view page only on your site.',
    'category' => 'SNS - Petition',
    'type' => 'widget',
    'name' => 'epetition.view-signpetition',
    'requirements' => array(
      'subject' => 'petition',
    ),
  ),
  array(
    'title' => 'SNS - Petitions - Petition Profile - Owner',
    'description' => 'Displays a petition owner. You can place this widget on petition view page only on your site.',
    'category' => 'SNS - Petition',
    'type' => 'widget',
    'name' => 'epetition.view-owner',
    'requirements' => array(
      'subject' => 'petition',
    ),
    'adminForm' => array(
      'elements' => array(
        array(
          'Radio',
          'ownername',
          array(
            'label' => "Enable Owner Name",
            'multiOptions' => array(
              'yes' => 'Yes',
              'no' => 'No'
            ),
            'value' => 'yes',
          )
        ),

        array(
          'Radio',
          'toppetition',
          array(
            'label' => "Enable to show Total Created Petitions?",
            'multiOptions' => array(
              'yes' => 'Yes',
              'no' => 'No'
            ),
            'value' => 'yes',
          )
        ),
        array(
          'Radio',
          'ownerphoto',
          array(
            'label' => "Enable Owner Photo?",
            'multiOptions' => array(
              'yes' => 'Yes',
              'no' => 'No'
            ),
            'value' => 'yes',
          )
        ),
        array(
          'Select',
          'photoviewtype',
        array(
          'label' => "Choose the shape of Photo.",
          'multiOptions' => array(
            'circle' => 'Circle',
            'square' => 'Square',
          ),
          'value' => 'circle',
        )

       ),
        array(
          'text',
          'aboutuser',
          array(
            'label' => "Truncation limit for \"About User\" information.",
            'value'=>30,
          )

        )
      )
    ),
  ),
  array(
    'title' => 'SNS - Petition - Petition View Recent Signature',
    'description' => 'Displays a petition recent signature. You can place this widget on petition view page only on your site.',
    'category' => 'SNS - Petition',
    'type' => 'widget',
    'name' => 'epetition.view-recent',
    'requirements' => array(
      'subject' => 'petition',
    ),
  ),

  array(
    'title' => 'SNS - Petitions - Petition Profile - Overview',
    'description' => 'Displays a petition about. You can place this widget on petition view page only on your site.',
    'category' => 'SNS - Petition',
    'type' => 'widget',
    'name' => 'epetition.view-about',
    'defaultParams' => array(
      'title' => 'About',
      'titleCount' => true,
    ),
    'requirements' => array(
      'subject' => 'petition',
    ),
  ),

  array(
    'title' => 'SNS - Petition - Petition Signature list',
    'description' => 'Displays a petition signature list. You can place this widget on petition view page only on your site.',
    'category' => 'SNS - Petition',
    'type' => 'widget',
    'name' => 'epetition.view-signatures',
    'requirements' => array(
      'subject' => 'petition',
    ),
  ),

  array(
    'title' => 'SNS - Petition - Petition Letter',
    'description' => 'Displays a petition letter. You can place this widget on petition view page only on your site.',
    'category' => 'SNS - Petition',
    'type' => 'widget',
    'name' => 'epetition.view-letter',
    'isPaginated' => false,
    'requirements' => array(
      'subject' => 'petition',
    ),
  ),

  array(
    'title' => 'SNS - Petitions - Petition Contact Details',
    'category' => 'SNS - Petition',
    'type' => 'widget',
    'name' => 'epetition.view-contact',
    'description'=> 'This widget will display contact details for petition owner at Petition Profile Page. The recommended page for this widget is “Petition Profile Page',
    'defaultParams' => array(
      'title' => 'Contact Details',
    ),
    'requirements' => array(
      'subject' => 'petition',
    ),
    'adminForm' => array(
      'elements' => array(
        array(
          'MultiCheckbox',
          'search_type',
          array(
            'label' => "Choose from below the details that you want to show in this widget.",
            'multiOptions' => array(
              'contactname' => 'Contact Name',
              'contactemail' => 'Contact Email',
              'contactphonenumber' => 'Contact Phone Number',
              'contactfacebook' => 'Contact Facebook',
              'contactlinkedin' => 'Contact Linkedin',
              'contacttwitter' => 'Contact Twitter',
              'contactwebsite' => 'Contact Website',
            ),
            'defaultParams' => array('contactname','contactemail', 'contactphonenumber', 'contactfacebook', 'contactlinkedin', 'contacttwitter', 'contactwebsite'),
          )
        ),
      )
    ),
  ),


  array(
    'title' => 'SNS - Petition - Petition Update',
    'description' => 'Displays a petition update. You can place this widget on petition view page only on your site.',
    'category' => 'SNS - Petition',
    'type' => 'widget',
    'name' => 'epetition.view-update',
	  'isPaginated' => true,
    'requirements' => array(
      'subject' => 'petition',
    ),
  ),

  array(
    'title' => 'SNS - Petition - Profile Options for Petitions',
    'description' => 'Displays a menu of actions (edit, decision maker, add to favourite, share, subscribe, etc) that can be performed on a petition on its profile.',
    'category' => 'SNS - Petition',
    'type' => 'widget',
    'name' => 'epetition.gutter-menu',
  ),

  array(
    'title' => 'SNS - Petitions - Petition Profile - Details',
    'description' => 'Displays a petition info. You can place this widget on petition view page only on your site.',
    'category' => 'SNS - Petition',
    'type' => 'widget',
    'name' => 'epetition.view-info',
    'defaultParams' => array(
      'title' => 'Information',
      'titleCount' => true,
    ),
    'requirements' => array(
      'subject' => 'petition',
    ),
  ),

  array(
    'title' => 'SNS - Petition - Petition Decision Maker',
    'description' => 'Displays a petition decision maker. You can place this widget on petition view page only on your site.',
    'category' => 'SNS - Petition',
    'type' => 'widget',
    'name' => 'epetition.view-decisionmaker',
    'isPaginated' => true,
    'defaultParams' => array(
      'title' => 'Decisionmaker',
      'titleCount' => true,
    ),
    'requirements' => array(
      'subject' => 'petition',
    ),
  ),

//  array(
//    'title' => 'SNS - Petition - Petition Sidebar Tabbed Widget',
//    'description' => 'Displays a tabbed widget for petitions. You can place this widget anywhere on your site.',
//    'category' => 'SNS - Petition',
//    'type' => 'widget',
//    'autoEdit' => true,
//    'name' => 'epetition.sidebar-tabbed-widget',
//    'requirements' => array(
//      'subject' => 'petition',
//    ),
//    'adminForm' => 'Epetition_Form_Admin_SidebarTabbed',
//  ),


  array(
    'title' => 'SNS - Petitions - Petition Profile - Statistics',
    'category' => 'SNS - Petition',
    'type' => 'widget',
    'description' => 'This widget displays statistics for Petition at Petition Profile Page. The recommended page for this widget is Petition Profile Page.',
    'name' => 'epetition.petition-statistics',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'MultiCheckbox',
          'statistics_info',
          array(
            'label' => "Do you want to enable the following fields in this widget?.",
            'multiOptions' => array(
              'createdby' => 'Created by',
              'creationdate' => 'Creation Date',
              'goalreach' => 'Signature Goal Reached',
              'approvedby' => 'Approved by',
              'markedvictory' => 'Marked as Victory',
              'countpresentsign' => 'Count of Present Signatures',
            ),
            'escape' => false,
          )
        ),
      ),
    ),
  ),

  array(
    'title' => 'SNS - Petitions - Petition Profile - Sidebar Info',
    'category' => 'SNS - Petition',
    'type' => 'widget',
    'description' => 'This widget displays Info for Petition at Petition Profile Page. You can place this widget in sidebar at Petition Profile Page.',
    'name' => 'epetition.sidebar-info',
    'autoEdit' => true,
    'adminForm' => array(
      'elements' => array(
        array(
          'MultiCheckbox',
          'sidebar_info',
          array(
            'label' => "Which fields you want to enable for this widget?.",
            'multiOptions' => array(
              'petitioncategory' => 'Petition Category',
              'tags' => 'Tags',
              'petitionlocation' => 'Petition Location',
            ),
            'escape' => false,
          )
        ),
      ),
    ),
  ),


  array(
    'title' => 'SNS -  Petition - Petition Profile - Breadcrumb',
    'description' => 'Displays breadcrumb for Petition.  This widget should be placed on the SNS - Petition - Petition Profile Page of the selected content type and displays breadcrumb',
    'category' => 'SNS -  Petition',
    'type' => 'widget',
    'name' => 'epetition.breadcrumb',
    'autoEdit' => true,
  ),
  array(
    'title' => 'SNS - Petitions - Tags Horizontal View',
    'description' => 'Displays all tags of petitions in horizontal view. Edit this widget to choose various other settings.',
    'category' => 'SNS - Petition',
    'type' => 'widget',
    'name' => 'epetition.tag-horizantal-petitions',
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
            'class' => 'SNScolor',
            'label'=>'Choose widget background color.',
            'value' => '424242',
          )
        ),
        array(
          'Text',
          'buttonbgcolor',
          array(
            'class' => 'SNScolor',
            'label'=>'Choose background color of the button.',
            'value' => '000000',
          )
        ),
        array(
          'Text',
          'textcolor',
          array(
            'class' => 'SNScolor',
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
    'title' => 'SNS - Petition Profile share',
    'description' => 'This widget allow users to share the current petition on your website and on other social networking websites. The recommended page for this widget is "SNS -  Petition - Petition Profile Page".',
    'category' => 'SNS -  Petition',
    'type' => 'widget',
    'name' => 'epetition.advance-share',
    'autoEdit' => true,
    'adminForm' => 'Epetition_Form_Admin_Share',
  ),
  array(
    'title' => 'SNS -  Petition - Petition Browse Search',
    'description' => 'Displays a search form in the petition browse page as configured by you.',
    'category' => 'SNS -  Petition',
    'type' => 'widget',
    'name' => 'epetition.browse-search',
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
            'label' => "Show \'Search Petitions Keyword\' search field?",
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
            'label' => "Show \'Petition With Photos\' search field?",
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
    'title' => 'SNS -  Petition - Petition Custom Field Info',
    'description' => 'Displays petition custom fields for Petition. This widget should be placed on the  Petition - View page of petition.',
    'category' => 'SNS -  Petition',
    'type' => 'widget',
    'name' => 'epetition.petition-info',
    'defaultParams' => array(
      'title' => "Custom Fields",
    ),
    'autoEdit' => false,
  ),


  array(
    'title' => 'SNS - Petitions - Petition Profile - Content',
     'description' => 'Recommended page for this widget is “Petition Profile Page” which displays content for the petition on its profile page.',
    'category' => 'SNS - Petition',
    'type' => 'widget',
    'name' => 'epetition.view-petition',
    'adminForm' => array(
      'elements' => array(
        array(
          'MultiCheckbox',
          'show_criteria',
          array(
            'label' => "Choose from below the details that you want to show in this widget.",
            'multiOptions' => array(
              'title' => 'Title',
              'shortDescription' => 'Short Description',
              'socialShare' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
              'likeButton' => 'Like Button',
              'favouriteButton' => 'Favourite Button',
              'view' => 'View Count',
              'favourite' => 'Favourite Count',
              'like' => 'Like Count',
              'comment' => 'Comment Count',
            ),
            'defaultParams' => array('title', 'shortDescription', 'socialShare', 'report', 'likeButton', 'favouriteButton', 'view', 'favourite', 'like', 'comment', 'review', 'statics'),
            'escape' => false,
          )
        ),
        $socialshare_enable_plusicon,
        $socialshare_icon_limit,
      ),
    ),
  ),


);
