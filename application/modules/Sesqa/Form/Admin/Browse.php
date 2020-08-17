<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Browse.php  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesqa_Form_Admin_Browse extends Engine_Form {

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
    if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('seslocation')){
      $label = Engine_Api::_()->seslocation()->getWidgetText('sesqa');
      $this->addElement(
        'Select',
        'locationEnable',
        array(
          'label' => $label,
          'multiOptions'=>array('1'=>'Yes','0'=>'No'),
          'value'=>0
        )
      );
    }
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
  }

}