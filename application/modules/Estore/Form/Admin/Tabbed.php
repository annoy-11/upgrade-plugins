<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Tabbed.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Estore_Form_Admin_Tabbed extends Engine_Form {

  public function init() {

    $this->addElement('MultiCheckbox', "enableTabs", array(
        'label' => "View Type.",
        'multiOptions' => array(
            'list' => 'List View',
            'grid' => 'Grid View',
            'pinboard' => 'Pinboard View',
            'map' => 'Map View',
        ),
    ));

    $this->addElement('Select', "openViewType", array(
        'label' => "Choose Default View Type (apply if more than 1 view type is selected.) (Note: In \"Tabbed widget for Manage Stores\" only List View will work.)",
        'multiOptions' => array(
            'list' => 'List View',
            'grid' => 'Grid View',
            'pinboard' => 'Pinboard View',
            'map' => 'Map View',
        ),
    ));

    $this->addElement('Select', "tabOption", array(
        'label' => 'Choose Tab Type.',
        'multiOptions' => array(
            'default' => 'Default',
            'advance' => 'Advanced',
            'filter' => 'Filter',
            'vertical' => 'Vertical',
            'select' => 'Dropdown',
        ),
        'value' => 'advance',
    ));

      $categories = Engine_Api::_()->getDbTable('categories', 'estore')->getCategoriesAssoc();
      $categories = array('' => '') + $categories;
      // category field
      $this->addElement('Select', 'category_id', array(
          'label' => 'Category',
          'multiOptions' => $categories,
          'allowEmpty' => true,
          'required' => false,
      ));

    if (Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('seslocation')) {
      $this->addElement('Radio', 'locationEnable', array(
          'label' => 'Do you want to show content in this widget based on the Location chosen by users on your website? (This is dependent on the “Location Based Member & Content Display Plugin”. Also, make sure location is enabled and entered for the content in this plugin. If setting is enabled and the content does not have a location, then such content will not be shown in this widget.)
',
          'multiOptions' => array('1' => 'Yes', '0' => 'No'),
          'value' => 0
      ));
    }
    $this->addElement('MultiCheckbox', "show_criteria", array(
        'label' => "Choose from below the details that you want to show in this widget.",
        'multiOptions' => array(
            'title' => 'Stores Title',
            'by' => 'Owner\'s Name',
            'creationDate' => 'Created On',
            'category' => 'Category',
            'location' => 'Location',
            'listdescription' => 'Description (List View)',
            'simplegriddescription' => 'Description (Grid View)',
            'pinboarddescription' => 'Description (Pinboard View)',
            'price' => 'Price',
            'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
            'contactDetail' => 'Contact Details',
            'likeButton' => 'Like Button',
            'favouriteButton' => 'Favourite Button',
            'followButton' => 'Follow Button',
            'joinButton' => 'Join Button',
            'contactButton' => 'Contact Button',
            'like' => 'Likes Count',
            'comment' => 'Comments Count',
            'favourite' => 'Favourite Count',
            'view' => 'Views Count',
            'follow' => 'Follow Counts',
            //'statusLabel' => 'Status Label [Open/ Closed]',
            'featuredLabel' => 'Featured Label',
            'sponsoredLabel' => 'Sponsored Label',
            'verifiedLabel' => 'Verified Label',
            'hotLabel' => 'Hot Label',
            'newLabel' => 'New Label',
            'totalProduct' =>'Product Count & Images',
        ),
        'escape' => false,
    ));

    $this->addElement('Radio', "pagging", array(
        'label' => "Do you want the stores to be auto-loaded when users scroll down the page?",
        'multiOptions' => array(
            'auto_load' => 'Yes, Auto Load',
            'button' => 'No, show \'View more\' link.',
            'pagging' => 'No, show \'Pagination\'.'
        ),
        'value' => 'auto_load',
    ));

    $this->addElement('Select', "show_limited_data", array(
        'label' => 'Show only the number of stores entered in the setting for Count of each view. [If you choose No, then you can choose how do you want to show more stores in this widget.]',
        'multiOptions' => array(
            'yes' => 'Yes',
            'no' => 'No',
        ),
        'value' => 'no',
    ));

    $this->addElement('Select', 'socialshare_enable_plusicon', array(
        'label' => "Enable More Icon for social share buttons in List View?",
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
    ));
    $this->addElement('Text', "socialshare_icon_limit", array(
        'label' => 'Count (number of social sites to show in list view). If you enable More Icon, then other social sharing icons will display on clicking this plus icon.',
        'value' => 2,
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    ));

    $this->addElement('Dummy', "dummy15", array(
        'label' => "<span style='font-weight:bold;'>List View</span>",
    ));
    $this->getElement('dummy15')->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', "limit_data_list", array(
        'label' => 'Count (number of stores to show).',
        'value' => 10,
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    ));
    $this->addElement('Text', "list_title_truncation", array(
        'label' => 'Title truncation limit.',
        'value' => 45,
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    ));
    $this->addElement('Text', "list_description_truncation", array(
        'label' => 'Description truncation limit.',
        'value' => 45,
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    ));

    $this->addElement('Text', "height", array(
        'label' => 'Enter the height of main photo block (in pixels).',
        'value' => '230',
    ));
    $this->addElement('Text', "width", array(
        'label' => 'Enter the width of main photo block (in pixels).',
        'value' => '260',
    ));

    $this->addElement('Dummy', "dummy17", array(
        'label' => "<span style='font-weight:bold;'>Grid View</span>",
    ));
    $this->getElement('dummy17')->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', "limit_data_simplegrid", array(
        'label' => 'Count (number of stores to show).',
        'value' => 10,
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    ));

    $this->addElement('Text', "simplegrid_title_truncation", array(
        'label' => 'Title truncation limit.',
        'value' => 45,
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    ));

    $this->addElement('Text', "simplegrid_description_truncation", array(
        'label' => 'Description truncation limit.',
        'value' => 45,
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    ));

    $this->addElement('Text', "height_simplegrid", array(
        'label' => 'Enter the height of one block (in pixels).',
        'value' => '270',
    ));
    $this->addElement('Text', "width_simplegrid", array(
        'label' => 'Enter the width of one block (in pixels).',
        'value' => '389',
    ));

    $this->addElement('Dummy', "dummy20", array(
        'label' => "<span style='font-weight:bold;'>Pinboard View</span>",
    ));
    $this->getElement('dummy20')->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', "limit_data_pinboard", array(
        'label' => 'Count (number of stores to show).',
        'value' => 10,
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    ));

    $this->addElement('Text', "pinboard_title_truncation", array(
        'label' => 'Title truncation limit.',
        'value' => 45,
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    ));

    $this->addElement('Text', "pinboard_description_truncation", array(
        'label' => 'Description truncation limit.',
        'value' => 45,
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    ));

    $this->addElement('Text', "width_pinboard", array(
        'label' => 'Enter the width of one block (in pixels).',
        'value' => '300',
    ));
    $this->addElement('Dummy', "dummy21", array(
        'label' => "<span style='font-weight:bold;'>Map View</span>",
    ));
    $this->getElement('dummy21')->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', "limit_data_map", array(
        'label' => 'Count (number of stores to show).',
        'value' => 10,
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    ));

    $this->addElement('MultiCheckbox', "search_type", array(
        'label' => "Choose from below tabs that you want to show in this widget.",
        'multiOptions' => array(
            'open' => 'Open',
            'close' => 'Closed',
            'recentlySPcreated' => 'Recently Created',
            'mostSPliked' => 'Most Liked',
            'mostSPcommented' => 'Most Commented',
            'mostSPviewed' => 'Most Viewed',
            'mostSPfavourite' => 'Most Favorited',
            'mostSPfollowed' => 'Most Followed',
            'mostSPrated' => 'Most Rated',
            'mostSPjoined' => 'Most Joined',
            'featured' => 'Featured',
            'sponsored' => 'Sponsored',
            'verified' => 'Verified',
            'hot' => 'Hot',
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

    // setting for Most Liked
    $this->addElement('Dummy', "dummy2", array(
        'label' => "<span style='font-weight:bold;'>Order and Title of 'Most Liked' Tab</span>",
    ));
    $this->getElement('dummy2')->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', "mostSPliked_order", array(
        'label' => "Order of this Tab.",
        'value' => '2',
    ));
    $this->addElement('Text', "mostSPliked_label", array(
        'label' => 'Title of this Tab.',
        'value' => 'Most Liked',
    ));

    // setting for Most Commented
    $this->addElement('Dummy', "dummy3", array(
        'label' => "<span style='font-weight:bold;'>Order and Title of 'Most Commented' Tab</span>",
    ));
    $this->getElement('dummy3')->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', "mostSPcommented_order", array(
        'label' => "Order of this Tab.",
        'value' => '3',
    ));
    $this->addElement('Text', "mostSPcommented_label", array(
        'label' => 'Title of this Tab.',
        'value' => 'Most Commented',
    ));

    // setting for Most Viewed
    $this->addElement('Dummy', "dummy4", array(
        'label' => "<span style='font-weight:bold;'>Order and Title of 'Most Viewed' Tab</span>",
    ));
    $this->getElement('dummy4')->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', "mostSPviewed_order", array(
        'label' => "Order of this Tab.",
        'value' => '4',
    ));
    $this->addElement('Text', "mostSPviewed_label", array(
        'label' => 'Title of this Tab.',
        'value' => 'Most Viewed',
    ));

    // setting for Most Favourite
    $this->addElement('Dummy', "dummy5", array(
        'label' => "<span style='font-weight:bold;'>Order and Title of 'Most Favourited' Tab</span>",
    ));
    $this->getElement('dummy5')->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', "mostSPfavourite_order", array(
        'label' => "Order of this Tab.",
        'value' => '5',
    ));
    $this->addElement('Text', "mostSPfavourite_label", array(
        'label' => 'Title of this Tab.',
        'value' => 'Most Favourited',
    ));

    $this->addElement('Dummy', "dummy6", array(
        'label' => "<span style='font-weight:bold;'>Order and Title of 'Most Followed' Tab</span>",
    ));
    $this->getElement('dummy6')->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', "mostSPfollowed_order", array(
        'label' => "Order of this Tab.",
        'value' => '6',
    ));
    $this->addElement('Text', "mostSPfollowed_label", array(
        'label' => 'Title of this Tab.',
        'value' => 'Most Followed',
    ));

    // setting for Featured
    $this->addElement('Dummy', "dummy7", array(
        'label' => "<span style='font-weight:bold;'>Order and Title of 'Featured' Tab</span>",
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
        'label' => "<span style='font-weight:bold;'>Order and Title of 'Sponsored' Tab</span>",
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

    $this->addElement('Dummy', "dummy9", array(
        'label' => "<span style='font-weight:bold;'>Order and Title of 'Verified' Tab</span>",
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

    $this->addElement('Dummy', "dummy10", array(
        'label' => "<span style='font-weight:bold;'>Order and Title of 'Hot' Tab</span>",
    ));
    $this->getElement('dummy10')->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', "hot_order", array(
        'label' => 'Order of this Tab.',
        'value' => '10',
    ));
    $this->addElement('Text', "hot_label", array(
        'label' => 'Title of this Tab.',
        'value' => 'Hot',
    ));
  }

}
