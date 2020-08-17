<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Viewpage.php  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesqa_Form_Admin_Viewpage extends Engine_Form {

  public function init() {
    
            $this->addElement(
                'MultiCheckbox',
                'show_criteria',
                array(
                    'label' => "Choose from below the details that you want to show in this widget.",
                    'multiOptions' => array(
                        'title'=>'Title of Question',
                        'openClose' => 'Open/Close',
                        'voteBtn' => 'Vote Button',
                        'favBtn' => 'Favourite Button',
                        'likeBtn' => 'Like Button',
                        'followBtn' => 'Follow Button',
                        'location' => 'Location',
                        'share' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
                        'report'=>'Report',
                        'location'=>'Location',
                        'date' => 'Date',
                        'tags' => 'Tags',
                        'owner' => 'Owner',
                        'category' => 'Category',
                        'vote' => 'Vote Counts',
                        'answerCount' => 'Answer Counts',
                        'view' => 'View Counts',
                        'comment'=>'Comment Count',
                        'favourite'=>'Favourite Count',
                        'follow'=>'Follow Count',
                        'like'=>'Like Count',
                        'featuredLabel'=>'Featured Label',
                        'sponsoredLabel' =>'Sponsored Label',
                        'verifiedLabel'=>'Verified Label',
                        'hotLabel'=>'Hot Label',
                        'newLabel'=>'New Label',
                    ),
                    'escape' => false,
                )
            );
            
            $this->addElement(
                'Select',
                'socialshare_enable_plusicon',
                array(
                    'label' => "Enable More Icon for social share buttons?",
                    'multiOptions' => array(
                      '1' => 'Yes',
                      '0' => 'No',
                    ),
                )
            );
             $this->addElement(
              'Text',
              'socialshare_icon_limit',
              array(
                'label' => 'Count (number of social sites to show). If you enable More Icon, then other social sharing icons will display on clicking this plus icon.',
                'value' => 2,
              )
            );
           
    //answer            
    $this->addElement('Dummy', "dummy4", array(
       'label' => "<span style='font-weight:bold;'>Answer's Block</span>",
    ));
		$this->getElement('dummy4')->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
	  
    $this->addElement(
                'MultiCheckbox',
                'answer_show_criteria',
                array(
                    'label' => "Choose from below the details that you want to show in this widget.",
                    'multiOptions' => array(
                        'vote' => 'Vote Btn',
                        'comment' => 'Comment[depend on SES advanced activity plugin]',
                        'owner' => 'Owner',
                        'date' => 'Date',
                        'markBest' => 'Mark As Best',
                    ),
                    'escape' => false,
                )
            );
            
            $this->addElement(
                'Select',
                'tinymce',
                array(
                    'label' => 'Show answer box as tinymce editor',
                    'multiOptions'=>array('1'=>'Yes',0=>'No'),
                    'value' => 1,
                    
                )
            );
            
            $this->addElement(
                'Text',
                'limit_data',
                array(
                    'label' => 'Count (number of answers to show.)',
                    'value' => 20,
                    'validators' => array(
                        array('Int', true),
                        array('GreaterThan', true, array(0)),
                    )
                )
            );      
  }

}