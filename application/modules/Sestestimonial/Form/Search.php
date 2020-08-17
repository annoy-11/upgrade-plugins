<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sestestimonial
 * @package    Sestestimonial
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Search.php  2018-10-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sestestimonial_Form_Search extends Engine_Form
{
  public function init()
  {
    $this
      ->setAttribs(array(
        'id' => 'filter_form',
        'class' => 'global_form_box',
      ))
      ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()))
      ->setMethod('GET')
      ;

    $this->addElement('Text', 'description', array(
      'label' => 'Search Testimonials',
    ));

    $this->addElement('Text', 'designation', array(
      'label' => 'Search Designation',
    ));

    $this->addElement('Select', 'rating', array(
      'label' => 'Rating',
      'multiOptions' => array(
        '' => '',
        '5' => 'Only 5 Star',
        '4' => 'Only 4 Star',
        '3' => 'Only 3 Star',
        '2' => 'Only 2 Star',
        '1' => 'Only 1 Star',
      ),
    ));

    $this->addElement('Select', 'popularitycreteria', array(
      'label' => 'Browse by',
      'multiOptions' => array(
        '' => '',
        'creation_date' => 'Recently Created',
        'modified_date' => 'Recently Updated',
        'view_count' => 'Most Viewed',
        'like_count' => 'Most Liked',
        'comment_count' => 'Most Commented',
        'helpful_count' => 'Most Helpful',
        'ratinghightolow' => 'Rating: High to Low',
        'ratinglowtohigh' => 'Rating: Low to High',
      ),
    ));

    $this->addElement('Button', 'find', array(
      'type' => 'submit',
      'label' => 'Search',
      'ignore' => true,
      'order' => 10000001,
    ));

    $this->addElement('Hidden', 'page', array(
      'order' => 100
    ));
  }
}
