<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdiscussion
 * @package    Sesdiscussion
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Search.php  2018-12-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesdiscussion_Form_Search extends Engine_Form
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

    $action = Zend_Controller_Front::getInstance()->getRequest()->getParam('action', null);


    $this->addElement('Text', 'search', array(
      'label' => 'Search Discussions',
    ));

    $request = Zend_Controller_Front::getInstance()->getRequest();
    $getModuleName = $request->getModuleName();
    $getControllerName = $request->getControllerName();
    $getActionName = $request->getActionName();

    if(!in_array($getActionName, array('manage', 'top-voted'))) {

      $this->addElement('Select', 'orderby', array(
        'label' => 'Popularity Criteria',
        'multiOptions' => array(
          '' => '',
          'creation_date' => 'Recently Created',
          'like_count' => 'Most Liked',
          'comment_count' => 'Most Commented',
          'view_count' => 'Most Viewed',
          'modified_date' => 'Recently Modified',
          'toptolow' => 'Votes (Top - Low)',
          'lowtotop' => 'Votes (Low - Top)',
        ),
      ));
    }

    if($getActionName != 'manage') {
      $this->addElement('Select', 'show', array(
        'label' => 'Show',
        'multiOptions' => array(
          '1' => 'Everyone\'s Discussions',
          '2' => 'Only My Friends\' Discussions',
        ),
      ));
    }


    if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.enablecategory', 1)) {
      $categories =  $categories = Engine_Api::_()->getDbtable('categories', 'sesdiscussion')->getCategoriesAssoc(array('uncategories' => true));
      if (count($categories) > 0) {

        $categories = array('' => 'All Category') + $categories;
        $this->addElement('Select', 'category_id', array(
          'label' => 'Category',
          'multiOptions' => $categories,
          'onchange' => 'showSubCategory(this.value);',
        ));

        $this->addElement('Select', 'subcat_id', array(
          'label' => "Sub Category",
          'allowEmpty' => true,
          'required' => false,
          'multiOptions' => array('0' => 'Please select sub category'),
          'registerInArrayValidator' => false,
          'onchange' => "showSubSubCategory(this.value);"
        ));

        //Add Element: Sub Sub Category
        $this->addElement('Select', 'subsubcat_id', array(
          'label' => "3rd Category",
          'allowEmpty' => true,
          'registerInArrayValidator' => false,
          'required' => false,
          'multiOptions' => array('0' => 'Please select 3rd category'),
        ));
      }
    }



    $this->addElement('Button', 'find', array(
      'type' => 'submit',
      'label' => 'Search',
      'ignore' => true,
      'order' => 10000001,
    ));

    $this->addElement('Hidden', 'page', array(
      'order' => 100
    ));

    $this->addElement('Hidden', 'tag', array(
      'order' => 101
    ));

    $this->addElement('Hidden', 'start_date', array(
      'order' => 102
    ));

    $this->addElement('Hidden', 'end_date', array(
      'order' => 103
    ));
  }
}
