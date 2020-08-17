<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Advancedsearch
 * @package    Advancedsearch
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Search.php  2018-12-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Advancedsearch_Form_Search extends Engine_Form
{
    protected $_type;

    public function getType() {
        return $this->_type;
    }

    public function setType($type) {
        $this->_type = $type;
        return $this;
    }
  public function init()
  {
    $this
      ->setAttribs(array(
        'id' => 'filter_form_advsearch',
        'class' => 'global_form_box',
      ))
      ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()));

    parent::init();
    
    $this->addElement('Text', 'search', array(
      'label' => 'Search:'
    ));

//    $this->addElement('Select', 'sort', array(
//      'label' => 'Browse By:',
//      'multiOptions' => array(
//        'recent' => 'Most Recent',
//        'popular' => 'Most Popular',
//      ),
//    ));

    $this->addElement('Button', 'find', array(
      'type' => 'submit',
      'label' => 'Search',
      'ignore' => true,
      'order' => 10000001,
    ));

    if($this->_type) {
        // prepare categories
        if($this->_type == "video"){
            $categoriesA = Engine_Api::_()->video()->getCategories();
            $categories[0] = "All Categories";
            foreach ($categoriesA as $category){
                $categories[$category->category_id] = $category->category_name;
            }
        }else {
            $categoriesA = Engine_Api::_()->getDbtable('categories', $this->_type)->getCategoriesAssoc();
            $categories = array_merge(array('0'=>"All Categories"),$categoriesA);
        }
        if (count($categories) > 0) {
            $this->addElement('Select', 'category_id', array(
                'label' => 'Category',
                'multiOptions' => $categories,
            ));
        }
    }
  }
}
