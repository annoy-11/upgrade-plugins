<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvpoll
 * @package    Sesadvpoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: TabbedWidget.php  2018-12-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesadvpoll_Form_Admin_Settings_TabbedWidget extends Engine_Form {

  public function init() {

    $this->addElement('Select', "tabOption", array(
        'label' => 'Choose Tab Type.',
        'multiOptions' => array(
            '0' => 'Default',
            '1' => 'Select'
        ),
        'value' => '0',
    ));

    $this->addElement('MultiCheckbox', "show_criteria", array(
        'label' => "Choose from below the details that you want to show in this widget.",
        'multiOptions' => array(
            'favouriteButton' => 'Favourite Button',
            'likeButton' => 'Like Button',
            'siteshare' => "Site Share",
            'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
            'like' => 'Like Counts',
            'favourite' => 'Favourite Counts',
            'vote' => 'Vote Counts',
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
        'value' => '260',
    ));
    $this->addElement('Text', "width", array(
        'label' => 'Enter the width of one block for Gird View (in pixels).',
        'value' => '300',
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
      'value' => 10,
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
	 $this->addElement('MultiCheckbox', "search_type", array(
        'label' => "Choose from below tabs that you want to show in this widget.",
        'multiOptions' => array(
            'open' => 'Opened',
            'close' => 'Closed',
            'recentlySPcreated' => 'Recently Created',
            'mostSPliked' => 'Most Liked',
            'mostSPcommented' => 'Most Commented',
            'mostvoted' => 'Most Voted',
            'mostSPviewed' => 'Most Viewed',
            'mostSPfavourite' => 'Most Favorited',
        ),
    ));
    $this->addElement('Dummy', "dummy1", array(
        'label' => "<span style='font-weight:bold;'>Order and Title of 'Opened' Tab</span>",
    ));
    $this->getElement('dummy1')->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    $this->addElement('Text', "open_order", array(
        'label' => "Order this tab.",
        'value' => '1',
    ));
    $this->addElement('Text', "open_label", array(
				'label'=> 'Title of this tab.',
        'value' => 'Opened',
    ));
    $this->addElement('Dummy', "dummy2", array(
        'label' => "<span style='font-weight:bold;'>Order and Title of 'Closed' Tab</span>",
    ));
    $this->getElement('dummy2')->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    $this->addElement('Text', "close_order", array(
       'label' => "Order this tab.",
        'value' => '2',
    ));
    $this->addElement('Text', "close_label", array(
		'label'=> 'Title of this tab.',
        'value' => 'Closed',
    ));
    $this->addElement('Dummy', "dummy3", array(
        'label' => "<span style='font-weight:bold;'>Order and Title of 'Recently Created' Tab</span>",
    ));
    $this->getElement('dummy3')->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    $this->addElement('Text', "recentlySPcreated_order", array(
        'label' => "Order this tab.",
        'value' => '3',
    ));
    $this->addElement('Text', "recentlySPcreated_label", array(
		'label'=> 'Title of this tab.',
        'value' => 'Recently Created',
    ));
   $this->addElement('Dummy', "dummy4", array(
        'label' => "<span style='font-weight:bold;'>Order and Title of 'Most Liked' Tab</span>",
    ));
    $this->getElement('dummy4')->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    $this->addElement('Text', "mostSPliked_order", array(
        'label' => "Order this tab.",
        'value' => '4',
    ));
    $this->addElement('Text', "mostSPliked_label", array(
		'label'=> 'Title of this tab.',
        'value' => 'Most Liked',
    ));
    $this->addElement('Dummy', "dummy5", array(
        'label' => "<span style='font-weight:bold;'>Order and Title of 'Most Commented' Tab</span>",
    ));
    $this->getElement('dummy5')->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    $this->addElement('Text', "mostSPcommented_order", array(
        'label' => "Order this tab.",
        'value' => '5',
    ));
    $this->addElement('Text', "mostSPcommented_label", array(
		'label'=> 'Title of this tab.',
        'value' => 'Most Commented',
    ));

    $this->addElement('Dummy', "dummy6", array(
        'label' => "<span style='font-weight:bold;'>Order and Title of 'Most Voted' Tab</span>",
    ));
    $this->getElement('dummy6')->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    $this->addElement('Text', "mostvoted_order", array(
        'label' => "Order this tab.",
        'value' => '6',
    ));
    $this->addElement('Text', "mostvoted_label", array(
		'label'=> 'Title of this tab.',
        'value' => 'Most Voted',
    ));
    $this->addElement('Dummy', "dummy7", array(
        'label' => "<span style='font-weight:bold;'>Order and Title of 'Most Viewed' Tab</span>",
    ));
    $this->getElement('dummy7')->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    $this->addElement('Text', "mostSPviewed_order", array(
        'label' => "Order this tab.",
        'value' => '7',
    ));
    $this->addElement('Text', "mostSPviewed_label", array(
		'label'=> 'Title of this tab.',
        'value' => 'Most Viewed',
    ));

    $this->addElement('Dummy', "dummy8", array(
        'label' => "<span style='font-weight:bold;'>Order and Title of 'Most Favorited' Tab</span>",
    ));
    $this->getElement('dummy8')->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    $this->addElement('Text', "mostSPfavourite_order", array(
        'label' => "Order this tab.",
        'value' => '8',
    ));
    $this->addElement('Text', "mostSPfavourite_label", array(
		'label'=> 'Title of this tab.',
        'value' => 'Most Favorited',
    ));
	}

}
