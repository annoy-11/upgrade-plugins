<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgrouppoll
 * @package    Sesgrouppoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Viewpage.php  2018-11-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesgrouppoll_Form_Admin_Settings_Viewpage extends Engine_Form {
  public function init() {
	  $this->addElement('MultiCheckbox', "show_criteria", array(
        'label' => "Choose from below the details that you want to show in this widget.",
        'multiOptions' => array(
            'favouriteButton' => 'Favourite Button',
            'likeButton' => 'Like Button',

            'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
            'likecount' => 'Like Counts',
            'favouritecount' => 'Favourite Counts',
            'votecount' => 'Vote Counts',
            'viewcount' => 'View Counts',	
        ),
        'escape' => false,
    ));
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
	}

}
