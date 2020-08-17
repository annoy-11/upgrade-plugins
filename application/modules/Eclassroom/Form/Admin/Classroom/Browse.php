<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Browse.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Eclassroom_Form_Admin_Classroom_Browse extends Engine_Form {

  public function init() {

    $this->addElement('MultiCheckbox', "enableTabs", array(
        'label' => "Choose the View Type.",
        'multiOptions' => array(
            'list' => 'List View',
            'grid' => 'Grid View',
            'pinboard' => 'Pinboard View',
            'map' => 'Map View',
        ),
    ));
    $this->addElement('Select', "openViewType", array(
        'label' => "Choose Default View Type (This settings will apply, if you have selected more than one option in above setting)",
        'multiOptions' => array(
            'list' => 'List View',
            'simplegrid' => 'Grid View',
            'pinboard' => 'Pinboard View',
            'map' => 'Map View',
        ),
    ));
    if (1) {
      $categories = Engine_Api::_()->getDbTable('categories', 'eclassroom')->getCategoriesAssoc();
      $categories = array('' => '') + $categories;
      // category field
      $this->addElement('Select', 'category_id', array(
          'label' => 'Category',
          'multiOptions' => $categories,
          'allowEmpty' => true,
          'required' => false,
      ));
    }
    $this->addElement('MultiCheckbox', "show_criteria", array(
        'label' => "Choose from below the details that you want to show for Classroom in this.",
        'multiOptions' => array(
            'title' => 'Classroom Title',
            'listdescription' => 'Description (List View)',
            'simplegriddescription' => 'Description (Simple Grid View)',
            'pinboarddescription' => 'Description (Pinboard View)',
            'ownerPhoto' => 'Owner\'s Photo',
            'by' => 'Owner\'s Name',
            'creationDate' => 'Created On',
            'category' => 'Category',
            'location' => 'Location',
            'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
            'contactDetail' => 'Contact Details',
            'likeButton' => 'Like Button',
            'favouriteButton' => 'Favourite Button',
            'followButton' => 'Follow Button',
            'joinButton' => 'Join Button',
            'contactButton' => 'Contact Button',
            'courseCount'=>'Courses Count',
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
            'rating' => 'Reviews & Rating',
        ),
        'escape' => false,
    ));
    $this->addElement('Radio', "pagging", array(
        'label' => "Do you want the classrooms to be auto-loaded when users scroll down the page?",
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
        'label' => 'Count (number of classrooms to show).',
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
    $this->addElement('Text', "limit_data_grid", array(
        'label' => 'Count (number of classrooms to show).',
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
    $this->addElement('Dummy', "dummy20", array(
        'label' => "<span style='font-weight:bold;'>Pinboard View</span>",
    ));
    $this->dummy20->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    $this->addElement('Text', "limit_data_pinboard", array(
        'label' => 'Count (number of classrooms to show).',
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
        'label' => 'Count (number of Classroom to show).',
        'value' => 10,
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    ));
  }

}
