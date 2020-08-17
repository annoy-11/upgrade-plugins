<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvpoll
 * @package    Sesadvpoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Browsepolls.php  2018-12-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesadvpoll_Form_Admin_Settings_Browsepolls extends Engine_Form {
  public function init() {
    $this->addElement('MultiCheckbox', "show_criteria", array(
        'label' => "Choose from below the details that you want to show in this widget.",
        'multiOptions' => array(
            'favouriteButton' => 'Favourite Button',
            'likeButton' => 'Like Button',
            'siteshare' => "Site Share",
            'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
            'like' => 'Like Counts',
			'vote' => 'Vote Counts',
            'favourite' => 'Favourite Counts',
            'comment' => 'Comment Counts',
            'view' => 'View Counts',
            'title' => 'Titles',
            'by' => 'Poll Owner Name',
            'in' => 'Page name',
            'description' => 'Polls description',

        ),
        'escape' => false,
    ));
	//Social Share Plugin work
    if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sessocialshare')) {
	$this->addElement('Text', "socialshare_icon_limit",
					array(
						'label' => 'Count (number of social sites to show). If you enable More Icon, then other social sharing icons will display on clicking this plus icon.',
						'value' => 2,
						'validators' => array(
						   array('Int', true),
						   array('GreaterThan', true, array(0)),
						)
					));
				$this->addElement('Select', "socialshare_enable_plusicon",
					array(
						'label' => "Enable More Icon for social share buttons?",
						'multiOptions' => array(
							'1' => 'Yes',
							'0' => 'No',
						),
						'value' => 1,
					));
	}
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
        'label' => "Do you want the polls to be auto-loaded when users scroll down the page?",
        'multiOptions' => array(
            'button' => 'View more',
            'auto_load' => 'Auto Load',
            'pagging' => 'Pagination'
        ),
        'value' => 'auto_load',
    ));
	$this->addElement('Radio', "gridlist", array(
        'label' => "How do you want to show poll in page, type of list or grid?",
        'multiOptions' => array(
            '0' => 'list',
            '1' => 'grid'
        ),
        'value' => '0',
    ));
    $this->addElement('Text', "height", array(
        'label' => 'Enter the height of one block for Gird View (in pixels).',
        'value' => '200',
    ));
    $this->addElement('Text', "width", array(
        'label' => 'Enter the width of one block for Gird View (in pixels).',
        'value' => '320',
    ));
	$this->addElement('Select', "show_limited_data", array(
        'label' => 'Show only the number of Polls entered in the setting for Count of each view. [If you choose No, then you can choose how do you want to show more polls in this widget.]',
        'multiOptions' => array(
            'yes' => 'Yes',
            'no' => 'No',
        ),
        'value' => 'no',
    ));
    $this->addElement('Text', "title_truncation", array(
        'label' => 'Title truncation limit .',
        'value' => 45,
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    ));

    $this->addElement('Text', "limit_data", array(
      'label' => 'count (number of Polls to show).',
      'value' => 20,
      'validators' => array(
        array('Int', true),
        array('GreaterThan', true, array(0)),
      )
    ));

    $this->addElement('Text', "description_truncation", array(
        'label' => 'Description truncation limit.',
        'value' => 45,
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    ));
	}

}
