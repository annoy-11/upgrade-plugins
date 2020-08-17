<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Seselegant
 * @package    Seselegant
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Tabbed.php 2016-04-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seselegant_Form_Admin_Tabbed extends Engine_Form
{
  public function init()
  {
		$this->addElement('Radio', "search_type", array(
			 'label' => "Choose Popularity Criteria.",
			'multiOptions' => array(
					'recentlySPcreated' => 'Recently Created',
					'mostSPviewed' => 'Most Viewed',
					'mostSPliked' => 'Most Liked',
					'mostSPcommented' => 'Most Commented',
			),
    ));

		$this->addElement('MultiCheckbox', "show_criteria", array(
        'label' => "Choose from below the details that you want to show in this widget.",
        'multiOptions' => array(
						'like' => 'Likes Count',
						'comment' => 'Comments Count',
						'view' => 'Views Count',
						'title' => 'Album Title',
						'by' => 'Owner\'s Name',
        ),
    ));

		$this->addElement('Text', "limit_data", array(
			'label' => 'count (number of albums to show).',
        'value' => 20,
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    ));
  }
}
