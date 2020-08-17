<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmusicapp
 * @package    Sesmusicapp
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Category.php  2018-12-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesmusicapp_Form_Admin_Category extends Engine_Form {

  public function init() {
    $this->addElement('Select', 'contentType', array(
        'label' => 'Choose the content type belonging to which categories will be shown in this.',
        'multiOptions' => array(
            'album' => 'Music Album',
            'song' => 'Song',
        ),
        'value' => 'album',
    ));
	$this->addElement('Select','popularity',array(
        'label' => 'Popularity Criteria',
        'multiOptions' => array(
            'featured' => 'Only Featured',
            'sponsored' => 'Only Sponsored',
            'hot' => 'Only Hot',
            'upcoming' => 'Only Latest',
            'bothfesp' => 'Both Featured and Sponsored',
            'view_count' => 'Most Viewed',
            'like_count' => 'Most Liked',
            'comment_count' => 'Most Commented',
            'favourite_count' => 'Most Favorite',
            'creation_date' => 'Most Recent',
            'rating' => 'Most Rated',
            'modified_date' => 'Recently Updated',
            'song_count' => "Maximum Songs",
        ),
        'value' => 'creation_date',
    ));
	$this->addElement( 'Text','limit',array(
        'label' => 'Count (number of content to show)',
        'value' => 15,
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    ));
	
    $this->addElement('Select', 'showType', array(
        'label' => 'View Type',
        'multiOptions' => array(
            'simple' => 'Hierarchy View',
            'tagcloud' => 'Cloud View',
        ),
        'value' => 'simple',
    ));
	$this->addElement('Select', 'listingType', array(
        'label' => 'Listing Type',
        'multiOptions' => array(
            'vertical' => 'Vertical',
            'horizontal' => 'Horizontal',
        ),
        'value' => 'simple',
    ));
	$this->addElement('Select', 'viewType', array(
        'label' => "Choose what do you want to show in this widget.",
        'multiOptions' => array(
            'icon' => 'Category Icons',
            'image' => 'Category Images',
        ),
    ));
    $this->addElement('Select', 'shapeType', array(
        'label' => "Choose the shape of the category blocks in this widget.",
        'multiOptions' => array(
            'circle' => 'Circle',
            'square' => 'Square',
        ),
    ));
    $this->addElement('Select', 'image', array(
        'label' => 'Do you want to show category icon in this widget? [Display of icon depend on the View Type chosen by you from the above setting.]',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
            //'2' => 'Both'
        ),
        'value' => 1,
    ));
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $URL = $view->baseUrl() . "/admin/sesbasic/settings/color-chooser";
    $click = '<a href="' . $URL . '" target="_blank">Click Here</a>';
    $changeColorText = sprintf('%s to choose the color of category text for "Cloud View".]', $click);
    
    $this->addElement('Text', "color", array(
        'label' => $changeColorText,
        'value' => '#00f',
    ));
    $this->getElement('color')->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', "itemCountPerPage", array(
        'label' => 'Limit data to show [This settings only work when you choose "Tag Cloud Categories" from the above settings.]',
        'value' => '15',
    ));

    $this->addElement('Text', "text_height", array(
        'label' => 'Choose height of category text for "Cloud View".]',
        'value' => '15',
    ));

    $this->addElement('Text', "height", array(
        'label' => 'Choose height of category container for “Cloud View” (in pixels).',
        'value' => '150',
    ));
  }

}
