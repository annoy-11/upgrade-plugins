<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesariana
 * @package    Sesariana
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Tabbed.php 2016-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesariana_Form_Admin_Tabbed extends Engine_Form
{
  public function init()
  {
		$this->addElement('Radio', "search_type", array(
			 'label' => "Choose Popularity Criteria.",
			'multiOptions' => array(
					'recentlySPcreated' => 'Recently Created',
					'mostSPviewed' => 'Most Viewed',
					'mostSPfavourite' => 'Most Favourite',
					'mostSPliked' => 'Most Liked',
					'mostSPcommented' => 'Most Commented',
					'mostSPrated' => 'Most Rated',
					'mostSPdownloaded' => 'Most Downloaded',
					'featured' => 'Only Featured',
					'sponsored' => 'Only Sponsored'
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
						'favouriteCount' => 'Favourites Count',
						'downloadCount' => 'Downloads Count',
						'photoCount' => 'Photos Count',
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