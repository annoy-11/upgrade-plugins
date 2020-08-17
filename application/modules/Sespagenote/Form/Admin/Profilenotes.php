<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagenote
 * @package    Sespagenote
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Profilenotes.php  2019-03-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespagenote_Form_Admin_Profilenotes extends Engine_Form {

  public function init() {

    $this->addElement('MultiCheckbox', "enableTabs", array(
      'label' => "Choose the View Type.",
      'multiOptions' => array(
          'list' => 'List View',
          'grid' => 'Grid View',
          'pinboard' => 'Pinboard View',
      ),
    ));

    $this->addElement('Select', "openViewType", array(
        'label' => " Default open View Type (apply if select more than one option in above tab)?",
        'multiOptions' => array(
            'list' => 'List View',
            'grid' => 'Grid View',
            'pinboard' => 'Pinboard View',
        ),
    ));
		$this->addElement('Select', "viewTypeStyle", array(
        'label' => "Show Data in this widget on mouse over/fixed (work in grid view only)?",
        'multiOptions' => array(
            'mouseover' => 'Yes,on mouse over',
            'fixed' => 'No,not on mouse over'
        ),
        'value' => 'fixed',
    ));
    $this->addElement('Radio', "showTabType", array(
        'label' => 'Show Tab Type?',
        'multiOptions' => array(
            '0' => 'Default',
            '1' => 'Custom'
        ),
        'value' => 1,
    ));
    $this->addElement('MultiCheckbox', "show_criteria", array(
        'label' => "Choose from below the details that you want to show in this widget.",
        'multiOptions' => array(
            'featuredLabel' => 'Featured Label',
            'sponsoredLabel' => 'Sponsored Label',
            'hotLabel' => 'Hot Label',
            'watchLater' => 'Watch Later Button',
            'favouriteButton' => 'Favourite Button',
            'location'=>'Location',
            'likeButton' => 'Like Button',
            'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
            'like' => 'Like Counts',
            'favourite' => 'Favourite Counts',
            'comment' => 'Comment Counts',
            'rating' => 'Rating Stars',
            'view' => 'View Counts',
            'title' => 'Title',
            'category' => 'Category',
            'by' => 'Item Owner Name',
            'duration' => 'Duration',
            'descriptionlist' => 'Description (List View)',
            'descriptiongrid' => 'Description (Grid View)',
            'descriptionpinboard' => 'Description (Pinboard View)',
            'enableCommentPinboard'=>'Enable comment on pinboard',
        ),
        'escape' => false,
    ));

    //Social Share Plugin work
    if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sessocialshare')) {

      $this->addElement('Select', "socialshare_enable_plusicon", array(
        'label' => "Enable More Icon for social share buttons?",
          'multiOptions' => array(
          '1' => 'Yes',
          '0' => 'No',
        ),
        'value' => 1,
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
    //Social Share Plugin work

    $this->addElement('Radio', "pagging", array(
        'label' => "Do you want the videos to be auto-loaded when users scroll down the page?",
        'multiOptions' => array(
            'button' => 'View more',
            'auto_load' => 'Auto Load',
            'pagging' => 'Pagination'
        ),
        'value' => 'auto_load',
    ));
    $this->addElement('Text', "title_truncation_grid", array(
        'label' => 'Title truncation limit for Grid View.',
        'value' => 45,
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    ));
    $this->addElement('Text', "title_truncation_list", array(
        'label' => 'Title truncation limit for List View.',
        'value' => 45,
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    ));
		$this->addElement('Text', "title_truncation_pinboard", array(
        'label' => 'Title truncation limit for Pinboard View.',
        'value' => 45,
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    ));

		$this->addElement('Text', "limit_data_pinboard", array(
        'label' => 'Pinboard count (number of videos to show).',
        'value' => 10,
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    ));
		$this->addElement('Text', "limit_data_list", array(
        'label' => 'List count (number of videos to show).',
        'value' => 10,
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    ));
		$this->addElement('Text', "limit_data_grid", array(
        'label' => 'Grid count (number of videos to show).',
        'value' => 10,
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    ));
		$this->addElement('Select', "show_limited_data", array(
			'label' => 'Show only the number of videos entered in above setting. [If you choose No, then you can choose how do you want to show more videos in this widget in below setting.]',
			'multiOptions' => array(
            'yes' => 'Yes',
            'no' => 'No',
        ),
        'value' => 'no',
    ));
    $this->addElement('Text', "description_truncation_list", array(
        'label' => 'Description truncation limit for List View.',
        'value' => 45,
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    ));
		 $this->addElement('Text', "description_truncation_grid", array(
        'label' => 'Description truncation limit for Grid View.',
        'value' => 45,
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    ));
		 $this->addElement('Text', "description_truncation_pinboard", array(
        'label' => 'Description truncation limit for Pinboard View.',
        'value' => 45,
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    ));
    $this->addElement('Text', "height_grid", array(
        'label' => 'Enter the height of one block Grid(in pixels).',
        'value' => '270',
    ));
    $this->addElement('Text', "width_grid", array(
        'label' => 'Enter the width of one block Grid(in pixels).',
        'value' => '389',
    ));
		$this->addElement('Text', "height_list", array(
        'label' => 'Enter the height of one block List(in pixels).',
        'value' => '230',
    ));
    $this->addElement('Text', "width_list", array(
        'label' => 'Enter the width of one block List(in pixels).',
        'value' => '260',
    ));
    $this->addElement('Text', "width_pinboard", array(
        'label' => 'Enter the width of one block Pinboard(in pixels).',
        'value' => '300',
    ));
	}

}
