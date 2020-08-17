<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessoffer
 * @package    Sesbusinessoffer
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Tabbed.php  2019-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbusinessoffer_Form_Admin_Tabbed extends Engine_Form {

  public function init() {

    $this->addElement('MultiCheckbox', "enableTabs", array(
        'label' => "View Type.",
        'multiOptions' => array(
            'list' => 'List View',
            'grid' => 'Grid View',
        ),
    ));
    $this->addElement('Select', "openViewType", array(
        'label' => "Choose Default View Type (apply if more than 1 view type is selected.)",
        'multiOptions' => array(
            'list' => 'List View',
            'grid' => 'Grid View',
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

    $this->addElement('MultiCheckbox', "show_criteria", array(
        'label' => "Choose from below the details that you want to show in this widget.",
        'multiOptions' => array(
            'title' => 'Offer Title',
            'by' => 'Owner Name',
            'businessname' => "Business Name",
            'description' => 'Offer Description',
            'posteddate' => 'Created On',
            'likecount' => 'Likes Count',
            'followcount' => 'Follows Count ',
            'favouritecount' => 'Favourites Count ',
            'commentcount' => 'Comments Count ',
            'viewcount' => 'Views Count',
            'totalquantitycount' => 'Total Quantity Count',
            'offerlink' => 'Offer Link',
            'offertypevalue' => "Offer Type / Value",
            'showcouponcode' => "Show Coupon Code",
            'claimedcount' => "Claimed Count",
            'remainingcount' => "Remaining Count",
            'getofferlink' => "Get Offer Link",
            'featured' => 'Featured Label',
            'hot' => 'Hot Label',
            'new' => 'New Label',
            'likeButton' => 'Like Button',
            'favouriteButton' => "Favourite Button",
            'followButton' => "Follow Button",
            'listdescription' => "Show Description in List View",
            'griddescription' => "Description for Grid View only",
            'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
        ),
        'escape' => false,
    ));

    $this->addElement('Radio', "pagging", array(
        'label' => "Do you want the business offers to be auto-loaded when users scroll down the business?",
        'multiOptions' => array(
            'auto_load' => 'Yes, Auto Load',
            'button' => 'No, show \'View more\' link.',
            'pagging' => 'No, show \'Pagination\'.'
        ),
        'value' => 'auto_load',
    ));

    $this->addElement('Select', "show_limited_data", array(
        'label' => 'Show only the number of business offers entered in the setting for Count of each view. [If you choose No, then you can choose how do you want to show more business offers in this widget.]',
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

    $this->addElement('Select', "htmlTitle", array(
        'label' => 'Do you want to show HTML title on view type?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => 'advance',
    ));

    $this->addElement('Dummy', "dummy15", array(
        'label' => "<span style='font-weight:bold;'>List View</span>",
    ));
    $this->getElement('dummy15')->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', "limit_data_list", array(
        'label' => 'Count (number of business offers to show).',
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

    $this->addElement('Text', "limit_data_grid", array(
        'label' => 'Count (number of business offers to show).',
        'value' => 10,
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    ));

    $this->addElement('Text', "grid_title_truncation", array(
        'label' => 'Title truncation limit.',
        'value' => 45,
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    ));

    $this->addElement('Text', "grid_description_truncation", array(
        'label' => 'Description truncation limit.',
        'value' => 45,
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    ));

    $this->addElement('Text', "height_grid", array(
        'label' => 'Enter the height of one block (in pixels).',
        'value' => '240',
    ));
    $this->addElement('Text', "width_grid", array(
        'label' => 'Enter the width of one block (in pixels).',
        'value' => '384',
    ));


    $options = array(
        'recentlySPcreated' => 'Recently Created',
        'mostSPliked' => 'Most Liked',
        'mostSPcommented' => 'Most Commented',
        'mostSPviewed' => 'Most Viewed',
        'mostSPfavourite' => 'Most Favourite',
        'mostSPfollowed' => 'Most Followed',
        'new' => 'New',
        'featured' => 'Featured',
        'hot' => 'Hot',
    );

    $this->addElement('MultiCheckbox', "search_type", array(
      'label' => "Choose from below tabs that you want to show in this widget.",
      'multiOptions' => $options,
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
        'label' => "<span style='font-weight:bold;'>Order and Title of 'New' Tab</span>",
    ));
    $this->getElement('dummy5')->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', "new_order", array(
        'label' => "Order of this Tab.",
        'value' => '5',
    ));
    $this->addElement('Text', "new_label", array(
        'label' => 'Title of this Tab.',
        'value' => 'New',
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

    // setting for Hot
    $this->addElement('Dummy', "dummy8", array(
        'label' => "<span style='font-weight:bold;'>Order and Title of 'Hot' Tab</span>",
    ));
    $this->getElement('dummy8')->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', "hot_order", array(
        'label' => "Order of this Tab.",
        'value' => '8',
    ));
    $this->addElement('Text', "hot_label", array(
        'label' => 'Title of this Tab.',
        'value' => 'Hot',
    ));

    // setting for Most Favourite
    $this->addElement('Dummy', "dummy9", array(
        'label' => "<span style='font-weight:bold;'>Order and Title of 'Most Favourite' Tab</span>",
    ));
    $this->getElement('dummy9')->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', "favourite_order", array(
        'label' => "Order of this Tab.",
        'value' => '9',
    ));
    $this->addElement('Text', "favourite_label", array(
        'label' => 'Title of this Tab.',
        'value' => 'Most Favourite',
    ));

    // setting for Most Followed
    $this->addElement('Dummy', "dummy10", array(
        'label' => "<span style='font-weight:bold;'>Order and Title of 'Most Followed' Tab</span>",
    ));
    $this->getElement('dummy10')->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', "followed_order", array(
        'label' => "Order of this Tab.",
        'value' => '10',
    ));
    $this->addElement('Text', "followed_label", array(
        'label' => 'Title of this Tab.',
        'value' => 'Most Followed',
    ));
  }
}
