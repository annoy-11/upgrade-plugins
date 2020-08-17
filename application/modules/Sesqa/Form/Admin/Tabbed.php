<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Tabbed.php  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesqa_Form_Admin_Tabbed extends Engine_Form {

  public function init() {
  
    $this->addElement('Radio', "viewType", array(
        'label' => "Choose the View Type.",
        'multiOptions' => array(
            'list1' => 'List View 1',
            'list2' => 'List View 2',
            'grid1' => 'Grid View 1',
            'grid2' => 'Grid View 2',
        ),
    ));    
    $this->addElement('Radio', "showTabType", array(
        'label' => 'Show Tab Type?',
        'multiOptions' => array(
            'default' => 'Default',
            'advance' => 'Advance',
            'vertical' => 'Vertical',
            'filter' => 'Filter',
        ),
        'value' => 1,
    ));
    
    $setting = Engine_Api::_()->getApi('settings', 'core');
    $categories = Engine_Api::_()->getDbtable('categories', 'sesqa')->getCategoriesAssoc();
	  if( count($categories) > 0 &&  $setting->getSetting('qanda.allow.category','1')) {
      $categories = array(''=>'')+$categories;
      $this->addElement('Select', 'category_id', array(
        'label' => 'Category',
        'multiOptions' => $categories,
				'allowEmpty' => true,
				'required' => false,
		  ));
    }
//     if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('seslocation')){
//       $label = Engine_Api::_()->seslocation()->getWidgetText('sesqa');
//       $this->addElement(
//         'Select',
//         'locationEnable',
//         array(
//           'label' => $label,
//           'multiOptions'=>array('1'=>'Yes','0'=>'No'),
//           'value'=>0
//         )
//       );
//     }
    $this->addElement('MultiCheckbox', "show_criteria", array(
        'label' => "Choose from below the details that you want to show in this widget.",
        'multiOptions' => array(
            'title'=>'Title of Question',
            'favBtn' => 'Favourite Button',
            'likeBtn' => 'Like Button',
            'followBtn' => 'Follow Button',
            'userImage' =>'Owner Photo',
            'share' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
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
    ));
     $this->addElement('Text', "height", array(
          'label' => 'Enter the height of one block',
          'value' => 0,
          'validators' => array(
              array('Int', true)
          )
      ));
       $this->addElement('Text', "width", array(
          'label' => 'Enter the width of one block',
          'value' => 0,
          'validators' => array(
              array('Int', true)
          )
      ));
    //Social Share Plugin work
    if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sessocialshare')) {
      $this->addElement('Select', "socialshare_enable_plusicon", array(
        'label' => "Enable plus (+) icon for social share buttons in View?",
          'multiOptions' => array(
          '1' => 'Yes',
          '0' => 'No',
        ),
        'value' => 1,
      ));
      $this->addElement('Text', "socialshare_icon_limit", array(
          'label' => 'Enter the number of Social Share Buttons after which plus (+) icon will come in View. Other social sharing icons will display on clicking this plus icon.',
          'value' => 2,
          'validators' => array(
              array('Int', true),
              array('GreaterThan', true, array(0)),
          )
      ));
    }
    //Social Share Plugin work
    
    $this->addElement('Radio', "pagging", array(
        'label' => "Do you want the questions to be auto-loaded when users scroll down the page?",
        'multiOptions' => array(
            'button' => 'View more',
            'auto_load' => 'Auto Load',
            'pagging' => 'Pagination'
        ),
        'value' => 'auto_load',
    ));
    $this->addElement('Text', "title_truncate", array(
        'label' => 'Title truncation limit.',
        'value' => 200,
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    ));
    
		$this->addElement('Text', "limit", array(
        'label' => 'count (number of questions to show).',
        'value' => 10,
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    ));
		$this->addElement('Select', "show_limited_data", array(
			'label' => 'Show only the number of questions entered in above setting. [If you choose No, then you can choose how do you want to show more question in this widget in below setting.]',
			'multiOptions' => array(
            'yes' => 'Yes',
            'no' => 'No',
        ),
        'value' => 'no',
    ));
    
    $this->addElement('MultiCheckbox', "search_type", array(
        'label' => "Choose from below the details that you want to show in this widget.",
        'multiOptions' => array(
            'recentlySPcreated' => 'Recently Created',
            'mostSPviewed' => 'Most Viewed',
            'mostSPliked' => 'Most Liked',
            'mostSPcommented' => 'Most Commented',
            'mostSPvoted' => 'Most Voted',
            'mostSPfavourite' => 'Most Favourite',
            'homostSPanswered' => 'Most Answered',
            'unanswered'=>'Unanswered',
            'featured'=>'Featured',
            'sponsored'=>'Sponsored',
            'hot'=>'Hot',
            'verified'=>'Verified',
        ),
    ));
    // setting for Recently Updated
    $this->addElement('Text', "recentlySPcreated_order", array(
        'label' => "Enter The order & text for tabs to be shown in this widget. ",
        'value' => '1',
    ));
    $this->addElement('Text', "recentlySPcreated_label", array(
        'value' => 'Recently Created',
    ));
    // setting for Most Viewed
    $this->addElement('Text', "mostSPviewed_order", array(
        'label' => 'Most Viewed',
        'value' => '2',
    ));
    $this->addElement('Text', "mostSPviewed_label", array(
        'value' => 'Most Viewed',
    ));
    // setting for Most Liked
    $this->addElement('Text', "mostSPliked_order", array(
        'label' => 'Most Liked',
        'value' => '3',
    ));
    $this->addElement('Text', "mostSPliked_label", array(
        'value' => 'Most Liked',
    ));
    // setting for Most Commented
    $this->addElement('Text', "mostSPcommented_order", array(
        'label' => 'Most Commented',
        'value' => '4',
    ));
    $this->addElement('Text', "mostSPcommented_label", array(
        'value' => 'Most Commented',
    ));
    // setting for Most Voted
    $this->addElement('Text', "mostSPvoted_order", array(
        'label' => 'Most Voted',
        'value' => '5',
    ));
    $this->addElement('Text', "mostSPvoted_label", array(
        'value' => 'Most Voted',
    ));

    // setting for Most Favourite
    $this->addElement('Text', "mostSPfavourite_order", array(
        'label' => 'Most Favourite',
        'value' => '6',
    ));
    $this->addElement('Text', "mostSPfavourite_label", array(
        'value' => 'Most Favourite',
    ));
    // setting for Most Hot
    $this->addElement('Text', "homostSPanswered_order", array(
        'label' => 'Most Answered',
        'value' => '7',
    ));
    $this->addElement('Text', "homostSPanswered_label", array(
        'value' => 'Most Answered',
    ));
    
    // setting for Most Hot
    $this->addElement('Text', "unanswered_order", array(
        'label' => 'Unanswered',
        'value' => '7',
    ));
    $this->addElement('Text', "unanswered_label", array(
        'value' => 'Unanswered',
    ));  
    
    
    
     $this->addElement('Text', "featured_order", array(
        'label' => 'Featured',
        'value' => '8',
    ));
    $this->addElement('Text', "featured_label", array(
        'value' => 'Featured',
    ));  
    
     $this->addElement('Text', "sponsored_order", array(
        'label' => 'Sponsored',
        'value' => '8',
    ));
    $this->addElement('Text', "sponsored_label", array(
        'value' => 'Sponsored',
    ));
    
     $this->addElement('Text', "hot_order", array(
        'label' => 'Hot',
        'value' => '9',
    ));
    $this->addElement('Text', "hot_label", array(
        'value' => 'Hot',
    ));    
     $this->addElement('Text', "verified_order", array(
        'label' => 'Verified',
        'value' => '10',
    ));
    $this->addElement('Text', "verified_label", array(
        'value' => 'Verified',
    ));  
  }

}
