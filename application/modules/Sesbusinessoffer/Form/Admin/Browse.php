<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessoffer
 * @package    Sesbusinessoffer
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Browse.php  2019-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbusinessoffer_Form_Admin_Browse extends Engine_Form {

  public function init() {

    $this->addElement('MultiCheckbox', "enableTabs", array(
        'label' => "Choose the View Type.",
        'multiOptions' => array(
            'list' => 'List View',
            'grid' => 'Grid View',
        ),
    ));
    $this->addElement('Select', "openViewType", array(
        'label' => "Choose Default View Type (This settings will apply, if you have selected more than one option in above setting)",
        'multiOptions' => array(
            'list' => 'List View',
            'grid' => 'Grid View',
        ),
    ));
    $this->addElement('MultiCheckbox', "show_criteria", array(
        'label' => "Choose from below the details that you want to show for business offers in this widget.",
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
    if (Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sessocialshare')) {
      $this->addElement('Select', 'socialshare_enable_plusicon', array(
          'label' => "Enable More Icon for social share buttons?",
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
      ));
      $this->addElement('Text', "socialshare_icon_limit", array(
          'label' => 'Count (number of social sites to show). If you enable More Icon, then other social sharing icons will display on clicking this plus icon.',
          'value' => 2,
          'validators' => array(
              array('Int', true),
              array('GreaterThan', true, array(0)),
          )
      ));
    }
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
        'value' => '270',
    ));
    $this->addElement('Text', "width_grid", array(
        'label' => 'Enter the width of one block (in pixels).',
        'value' => '389',
    ));
  }
}
