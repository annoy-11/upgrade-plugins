<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Pricetable.php 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagebuilder_Form_Admin_Pricetable extends Engine_Form {

  public function init() {

    $tree_array[] = '';
    $trees = Engine_Api::_()->getItemTable('sespagebuilder_content')->getContent('pricing_table');
    foreach ($trees as $tree) {
      $tree_array[$tree['content_id']] = $tree['title'];
    }

    $this->addElement('Select', 'tableName', array(
        'label' => 'Choose content to be shown in this widget.',
        'multiOptions' => $tree_array,
    ));

    $this->addElement('Text', 'row_height', array(
        'label' => "Enter the height of rows of this table (in pixels).",
        'value' => '30',
    ));

    $this->addElement('Radio', 'price_header', array(
        'label' => 'Do you want to show price section?',
        'multiOptions' => array('1' => 'Yes', '0' => 'No'),
        'value' => '1'
    ));

    $this->addElement('Radio', 'description_header', array(
        'label' => 'Do you want to show description section?',
        'multiOptions' => array('1' => 'Yes', '0' => 'No'),
        'value' => '0'
    ));
		
	  $this->addElement('Text', 'description_height', array(
        'label' => "Enter the height of description (in pixels).",
        'value' => '40',
    ));
  }

}
