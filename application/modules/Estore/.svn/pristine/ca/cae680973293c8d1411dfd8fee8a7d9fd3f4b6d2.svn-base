<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Browse.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Estore_Form_Admin_Browse extends Engine_Form {

  public function init() {

    $this->addElement('MultiCheckbox', "enableTabs", array(
        'label' => "Choose the View Type.",
        'multiOptions' => array(
            'list' => 'List View',
            'simplegrid' => 'Plain Grid View',
            'pinboard' => 'Pinboard View',
            'map' => 'Map View',
        ),
    ));
    $this->addElement('Select', "openViewType", array(
        'label' => "Choose Default View Type (This settings will apply, if you have selected more than one option in above setting)",
        'multiOptions' => array(
            'list' => 'List View',
            'simplegrid' => 'Plain Grid View',
            'pinboard' => 'Pinboard View',
            'map' => 'Map View',
        ),
    ));
    if (1) {
      $categories = Engine_Api::_()->getDbTable('categories', 'estore')->getCategoriesAssoc();
      $categories = array('' => '') + $categories;
      // category field
      $this->addElement('Select', 'category_id', array(
          'label' => 'Category',
          'multiOptions' => $categories,
          'allowEmpty' => true,
          'required' => false,
      ));
    }
    if (Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('seslocation')) {
      $this->addElement('Radio', 'locationEnable', array(
          'label' => 'Do you want to show content in this widget based on the Location chosen by users on your website? (This is dependent on the “Location Based Member & Content Display Plugin”. Also, make sure location is enabled and entered for the content in this plugin. If setting is enabled and the content does not have a location, then such content will not be shown in this widget.)
',
          'multiOptions' => array('1' => 'Yes', '0' => 'No'),
          'value' => 0
      ));
    }
    $this->addElement('MultiCheckbox', "show_criteria", array(
        'label' => "Choose from below the details that you want to show for store directories in this widget.",
        'multiOptions' => array(
            'title' => 'Store Title',
            'listdescription' => 'Description (List View)',
            'simplegriddescription' => 'Description (Simple Grid View)',
            'pinboarddescription' => 'Description (Pinboard View)',
            //'ownerPhoto' => 'Owner\'s Photo',
            'by' => 'Owner\'s Name',
            'creationDate' => 'Created On',
            'category' => 'Category',
            'price' => 'Price',
            'location' => 'Location',
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
            'member' => 'Members Count',
            'statusLabel' => 'Status Label [Open/ Closed]',
            'featuredLabel' => 'Featured Label',
            'sponsoredLabel' => 'Sponsored Label',
            'verifiedLabel' => 'Verified Label',
            'hotLabel' => 'Hot Label',
            'newLabel' => 'New Label',
            'rating' => 'Reviews & Rating',
            'totalProduct' => 'Product Count & Photos',
        ),
        'escape' => false,
    ));
    $this->addElement('Radio', "pagging", array(
        'label' => "Do you want the store directories to be auto-loaded when users scroll down the page?",
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
    $this->dummy15->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', "limit_data_list", array(
        'label' => 'Count (number of store directories to show).',
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
    $this->dummy17->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

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
    $this->dummy20->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

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
     $this->addElement('Text', "height_pinboard", array(
        'label' => 'Enter the height of one block in pixels.',
        'value' => '300',
    ));
    $this->addElement('Dummy', "dummy21", array(
        'label' => "<span style='font-weight:bold;'>Map View</span>",
    ));
    $this->dummy21->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', "limit_data_map", array(
        'label' => 'Count (number of stores to show).',
        'value' => 10,
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    ));
  }

}
