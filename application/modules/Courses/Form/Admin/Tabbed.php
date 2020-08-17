<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Tabbed.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Courses_Form_Admin_Tabbed extends Engine_Form {
  public function init() {
    $this->addElement('MultiCheckbox', "enableTabs", array(
      'label' => "Choose the View Type For Courses",
      'multiOptions' => array(
      'list' => 'List View',
      'grid' => 'Grid View',
      'pinboard' => 'Pinboard View',
      'map' => 'Map View',
      ),
    ));
    $this->addElement('Select', "openViewType", array(
      'label' => "Choose the view type which you want to display by default. (Settings will apply, if you have selected more than one option in above tab.)",
      'multiOptions' => array(
        'list' => 'List View',
        'grid' => 'Grid View',
        'pinboard' => 'Pinboard View',
        'map' => 'Map View',
      ),
    ));
    $this->addElement('Select', "tabOption", array(
        'label' => 'Show Tab Type?',
       	'multiOptions' => array(
            'default' => 'Default',
            'advance' => 'Advanced',
            'filter'=>'Filter',
            'vertical'=>'Vertical',
        ),
        'value' => 'advance',
   ));
    $this->addElement('MultiCheckbox', "show_criteria", array(
      'label' => "Choose from below the details that you want to show in this widget.",
      'multiOptions' => array(
        'featuredLabel' => 'Featured Label',
        'sponsoredLabel' => 'Sponsored Label',
        'verifiedLabel' => 'Verified Label',
        'favouriteButton' => 'Favourite Button',
        'likeButton' => 'Like Button',
        'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
        'like' => 'Like Counts',
        'favourite' => 'Favourite Counts',
        'comment' => 'Comment Counts',
        'rating' => 'Reviews & Ratiing Counts',
        'view' => 'View Counts',
        'lectureCount'=>'Lecture Counts',
        'title' => 'Course Title',
        'category' => 'Category',
        'creationDate' => 'Creation Date',
        'description' => 'Description',
        'price' =>'Price',
        'discount' =>'Discount',
        'classroomName' => 'Classroom Name & Photo(Display only when Classroom exists)',
        'addCart' => 'Add to Cart',
        'addWishlist' => 'Add to wishlist',
        'addCompare' =>'Add to Compare',
        'totalCourse' =>'Total Course',
      ),
      'escape' => false,
    ));
    //Social Share Plugin work
    if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sessocialshare')) {
        $this->addElement('Select','socialshare_enable_plusicon',array(
            'label' => "Enable More Icon for social share buttons?",
            'multiOptions' => array('1' => 'Yes','0' => 'No'),
        ));
        $this->addElement('Text','socialshare_icon_limit',array(
            'label' => 'Count (number of social sites to show). If you enable More Icon, then other social sharing icons will display on clicking this plus icon.',
            'value' => 2,
        ));
    }
    //Social Share Plugin work
    $this->addElement('Select', "show_limited_data", array(
			'label' => 'Show only the number of Courses entered in the above setting. [If you choose No, then you can choose how do you want to show more Courses in this widget.]',
			 'multiOptions' => array(
            'yes' => 'Yes',
            'no' => 'No',
        ),
        'value' => 'no',
    ));
    $this->addElement('Radio', "pagging", array(
      'label' => "Do you want the Courses to be auto-loaded when users scroll down the page?",
      'multiOptions' => array(
      'auto_load' => 'Yes, Auto Load',
      'button' => 'No, show \'View more\' link.',
      'pagging' => 'No, show \'Pagination\'.'
      ),
      'value' => 'auto_load',
    ));
    $this->addElement('Text', "title_truncation_list", array(
      'label' => 'Title truncation limit for List Views.',
      'value' => 45,
      'validators' => array(
        array('Int', true),
        array('GreaterThan', true, array(0)),
      )
    ));
    $this->addElement('Text', "limit_data_list", array(
      'label' => 'Count for List View (Number of Courses to show).',
      'value' => 10,
      'validators' => array(
        array('Int', true),
        array('GreaterThan', true, array(0)),
      )
    ));
    $this->addElement('Text', "description_truncation_list", array(
      'label' => 'Description truncation limit for List Views.',
      'value' => 45,
      'validators' => array(
        array('Int', true),
        array('GreaterThan', true, array(0)),
      )
    ));
    $this->addElement('Text', "height_list", array(
      'label' => 'Enter the height of main photo block in List Views (in pixels).',
      'value' => '230',
    ));
    $this->addElement('Text', "width_list", array(
      'label' => 'Enter the width of main photo block in List Views (in pixels).',
      'value' => '260',
    ));

    $this->addElement('Text', "title_truncation_grid", array(
      'label' => 'Title truncation limit for Grid Views.',
      'value' => 45,
      'validators' => array(
        array('Int', true),
        array('GreaterThan', true, array(0)),
      )
    ));
    $this->addElement('Text', "limit_data_grid", array(
      'label' => 'Count for Grid Views (number of courses to show).',
      'value' => 10,
      'validators' => array(
        array('Int', true),
        array('GreaterThan', true, array(0)),
      )
    ));
    $this->addElement('Text', "description_truncation_grid", array(
      'label' => 'Description truncation limit for Grid Views.',
      'value' => 45,
      'validators' => array(
        array('Int', true),
        array('GreaterThan', true, array(0)),
      )
    ));
    $this->addElement('Text', "height_grid", array(
      'label' => 'Enter the height of one block in Grid Views (in pixels).',
      'value' => '270',
    ));
    $this->addElement('Text', "width_grid", array(
      'label' => 'Enter the width of one block in Grid Views (in pixels).',
      'value' => '389',
    ));
    $this->addElement('Text', "title_truncation_pinboard", array(
      'label' => 'Title truncation limit for Pinboard View.',
      'value' => 45,
      'validators' => array(array('Int', true),array('GreaterThan', true, array(0)))
    ));
    $this->addElement('Text', "limit_data_pinboard", array(
      'label' => 'Count for Pinboard View (number of courses to show).',
      'value' => 10,
      'validators' => array(array('Int', true),array('GreaterThan', true, array(0)))
    ));
    $this->addElement('Text', "description_truncation_pinboard", array(
      'label' => 'Description truncation limit for Pinboard View.',
      'value' => 45,
      'validators' => array(array('Int', true),array('GreaterThan', true, array(0)))
    ));
     $this->addElement('Text', "height_pinboard", array(
      'label' => 'Enter the height of one block in Pinboard View (in pixels).',
      'value' => '300',
    ));
    $this->addElement('Text', "width_pinboard", array(
      'label' => 'Enter the width of one block in Pinboard View (in pixels).',
      'value' => '300',
    ));
    $this->addElement('Text', "limit_data_map", array(
      'label' => 'Count for Map View (number of courses to show).',
      'value' => 10,
      'validators' => array(array('Int', true),array('GreaterThan', true, array(0)))
    ));
    $this->addElement('MultiCheckbox', "search_type", array(
        'label' => "Choose from below the Tabs that you want to show in this widget.",
        'multiOptions' => array(
            'recentlySPcreated' => 'Recently Created',
            'mostSPviewed' => 'Most Viewed',
            'mostSPliked' => 'Most Liked',
            'mostSPcommented' => 'Most Commented',
            'mostSPrated' => 'Most Rated',
            'mostSPfavourite' => 'Most Favourite',
            'week'=>'This Week',
            'month'=>'This Month',
            'featured' => 'Featured',
            'sponsored' => 'Sponsored',
            'verified' => 'Verified',
            'priceHigh' =>'Price High To Low',
            'priceLow' =>'Price Low To High',
            'mostSPlecture'=>'Most Lectures',
        ),
    ));
  	  // setting for Recently Created
    $this->addElement('Dummy', "dummy1", array(
			'label' => "<span style='font-weight:bold;'>Order and Title of 'Recently Created' Tab</span>",
    ));
    $this->getElement('dummy1')->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', "recentlySPcreated_order", array(
			'label' => "Order of this Tab.",
  			'value' => '1',
    ));
    $this->addElement('Text', "recentlySPcreated_label", array(
			'label' => 'Title of this Tab.',
			'value' => 'Recently Created',
    ));
 	   // setting for Most Viewed
    $this->addElement('Dummy', "dummy2", array(
			'label' => "<span style='font-weight:bold;'>Order and Title of 'Most Viewed' Tab</span>",
    ));
    $this->getElement('dummy2')->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    $this->addElement('Text', "mostSPviewed_order", array(
			'label' => "Order of this Tab.",
			'value' => '2',
    ));
    $this->addElement('Text', "mostSPviewed_label", array(
			'label' => 'Title of this Tab.',
			'value' => 'Most Viewed',
    ));
  	  // setting for Most Liked
    $this->addElement('Dummy', "dummy3", array(
			'label' => "<span style='font-weight:bold;'>Order and Title of 'Most Liked' Tab</span>",
    ));
    $this->getElement('dummy3')->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', "mostSPliked_order", array(
			'label' => "Order of this Tab.",
			'value' => '3',
    ));
    $this->addElement('Text', "mostSPliked_label", array(
			'label' => 'Title of this Tab.',
			'value' => 'Most Liked',
    ));
 	   // setting for Most Commented
    $this->addElement('Dummy', "dummy4", array(
			'label' => "<span style='font-weight:bold;'>Order and Title of 'Most Commented' Tab</span>",
    ));
    $this->getElement('dummy4')->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', "mostSPcommented_order", array(
			'label' => "Order of this Tab.",
			'value' => '4',
    ));
    $this->addElement('Text', "mostSPcommented_label", array(
			'label' => 'Title of this Tab.',
			'value' => 'Most Commented',
    ));
  	  // setting for Most Rated
    $this->addElement('Dummy', "dummy5", array(
			'label' => "<span style='font-weight:bold;'>Order and Title of 'Most Rated' Tab</span>",
    ));
    $this->getElement('dummy5')->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', "mostSPrated_order", array(
			'label' => "Order of this Tab.",
			'value' => '5',
    ));
    $this->addElement('Text', "mostSPrated_label", array(
			'label' => 'Title of this Tab.',
			'value' => 'Most Rated',
    ));
   	 // setting for Most Favourite
    $this->addElement('Dummy', "dummy6", array(
			'label' => "<span style='font-weight:bold;'>Order and Title of 'Most Favourite' Tab</span>",
    ));
    $this->getElement('dummy6')->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', "mostSPfavourite_order", array(
			'label' => "Order of this Tab.",
			'value' => '6',
    ));
    $this->addElement('Text', "mostSPfavourite_label", array(
			'label' => 'Title of this Tab.',
			'value' => 'Most Favourite',
    ));
  	  // setting for Featured
    $this->addElement('Dummy', "dummy7", array(
			'label' => "<span style='font-weight:bold;'>Order and Title of 'Most Featured' Tab</span>",
    ));
    $this->getElement('dummy7')->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', "featured_order", array(
			'label' => "Order of this Tab.",
			'value' => '7',
    ));
    $this->addElement('Text', "featured_label", array(
			'label' => 'Title of this Tab.',
			'value' => 'Featured',
    ));
   	 // setting for Sponsored
    $this->addElement('Dummy', "dummy8", array(
			'label' => "<span style='font-weight:bold;'>Order and Title of 'Most Sponsored' Tab</span>",
    ));
    $this->getElement('dummy8')->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', "sponsored_order", array(
			'label' => "Order of this Tab.",
			'value' => '8',
    ));
    $this->addElement('Text', "sponsored_label", array(
     			'label' => 'Title of this Tab.',
			'value' => 'Sponsored',
    ));
	    // setting for Verified
    $this->addElement('Dummy', "dummy9", array(
			'label' => "<span style='font-weight:bold;'>Order and Title of 'Most Verified' Tab</span>",
    ));
    $this->getElement('dummy9')->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', "verified_order", array(
			'label' => "Order of this Tab.",
			'value' => '9',
    ));
    $this->addElement('Text', "verified_label", array(
			'label' => 'Title of this Tab.',
			'value' => 'Verified',
    ));
	  // setting for This Week
    $this->addElement('Dummy', "dummy10", array(
			'label' => "<span style='font-weight:bold;'>Order and Title of 'This Week' Tab</span>",
    ));
    $this->getElement('dummy10')->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', "week_order", array(
			'label' => "Order of this Tab.",
			'value' => '10',
    ));
    $this->addElement('Text', "week_label", array(
			'label' => 'Title of this Tab.',
			'value' => 'This Week',
    ));

	  // setting for This Month
    $this->addElement('Dummy', "dummy11", array(
			'label' => "<span style='font-weight:bold;'>Order and Title of 'This Month' Tab</span>",
    ));
    $this->getElement('dummy11')->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', "month_order", array(
			'label' => 'Order of this Tab.',
			'value' => '11',
    ));
    $this->addElement('Text', "month_label", array(
			'label' => 'Title of this Tab.',
			'value' => 'This Month',
    ));
    
    // setting for Price High To Low
    $this->addElement('Dummy', "dummy12", array(
			'label' => "<span style='font-weight:bold;'>Order and Title of 'Price High To Low' Tab</span>",
    ));
    $this->getElement('dummy12')->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    $this->addElement('Text', "priceHigh_order", array(
			'label' => 'Order of this Tab.',
			'value' => '12',
    ));
    $this->addElement('Text', "priceHigh_label", array(
			'label' => 'Title of this Tab.',
			'value' => 'Price High To Low',
    ));
    
    // setting for Price Low To High
    $this->addElement('Dummy', "dummy13", array(
			'label' => "<span style='font-weight:bold;'>Order and Title of 'Price Low To High' Tab</span>",
    ));
    $this->getElement('dummy13')->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    $this->addElement('Text', "priceLow_order", array(
			'label' => 'Order of this Tab.',
			'value' => '12',
    ));
    $this->addElement('Text', "priceLow_label", array(
			'label' => 'Title of this Tab.',
			'value' => 'Price Low To High',
    ));
    
    // setting for Most Lectures
    $this->addElement('Dummy', "dummy14", array(
			'label' => "<span style='font-weight:bold;'>Order and Title of 'Most Lectures' Tab</span>",
    ));
    $this->getElement('dummy14')->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    $this->addElement('Text', "lecture_order", array(
			'label' => 'Order of this Tab.',
			'value' => '13',
    ));
    $this->addElement('Text', "lecture_label", array(
			'label' => 'Title of this Tab.',
			'value' => 'Most Lectures',
    ));
  }

}
