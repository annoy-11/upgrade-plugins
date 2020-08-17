<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagepoll
 * @package    Sespagepoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Popularpolls.php  2018-10-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespagepoll_Form_Admin_Settings_Popularpolls extends Engine_Form {

  public function init() {
    $this->addElement('Radio', "popular_type", array(
        'label' => "Popular Type",
        'multiOptions' => array(
            'mostfavourite' => 'Most Favourite',
            'mostcommented' => 'Most Comment',
	    'mostvoted' => 'Most Vote',
            'mostliked' => 'Most Like',
            'mostviewed' => 'Most View',
            'recentlycreated' => 'Most Recent',
            
        ),
        'escape' => false,
    ));
    $this->addElement('MultiCheckbox', "show_criteria", array(
        'label' => "Choose from below the details that you want to show in this widget.",
        'multiOptions' => array(
            'favouriteButton' => 'Favourite Button',
            'likeButton' => 'Like Button',
            'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
            'like' => 'Like Counts',
            'vote' => 'Vote Counts',
            'favourite' => 'Favourite Counts',
            'comment' => 'Comment Counts',
            'view' => 'View Counts',
            'title' => 'Titles',
            'by' => 'Poll Owner Name',
            'in' => 'Page name',
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
      'value' => 5,
      'validators' => array(
        array('Int', true),
        array('GreaterThan', true, array(0)),
      )
    ));
	}

}
