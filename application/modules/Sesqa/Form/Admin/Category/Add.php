<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Add.php  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Sesqa_Form_Admin_Category_Add extends Engine_Form {

  public function init() {

    $category_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id', 0);
    if ($category_id)
      $category = Engine_Api::_()->getItem('sesqa_category', $category_id);

    $this->setMethod('post');

    $this->addElement('Text', 'category_name', array(
        'label' => 'Name',
        'description' => 'The name is how it appears on your site.',
        'allowEmpty' => false,
        'required' => true,
    ));
    
    $this->addElement('Text', 'slug', array(
        'label' => 'Slug',
        'description' => 'The "slug" is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.',
        'allowEmpty' => false,
        'required' => true,
    ));
    
    $this->addElement('Text', 'title', array(
        'label' => 'Title',
        'description' => 'Title will appear on the Category View Page of your site.',
        'allowEmpty' => true,
        'required' => false,
    ));
    
// 		$this->addElement('Text', 'color', array(
//         'label' => 'Color',
//         'description' => 'This will be category color & will appear in Grid View of qas.',
// 				'class'=>'SEScolor',
//         'allowEmpty' => true,
//         'required' => false,
//     ));
    
//     $profiletype = array();
//     $topStructure = Engine_Api::_()->fields()->getFieldStructureTop('sesqa_qa');
//     if (count($topStructure) == 1 && $topStructure[0]->getChild()->type == 'profile_type') {
//       $profileTypeField = $topStructure[0]->getChild();
//       $options = $profileTypeField->getOptions();
//       $options = $profileTypeField->getElementParams('sesqa_qa');
//       unset($options['options']['order']);
//       unset($options['options']['multiOptions']['0']);
//       $profiletype = $options['options']['multiOptions'];
//     }
    /* $parentArray[''] = 'None';
      $categorys = Engine_Api::_()->getDbtable('categories', 'sesqa')->getCategory(array('column_name' => '*','profile_type'=>true));
      foreach ($categorys as $categoryData){
      if($categoryData->category_id == 0) {
      continue;
      }
      if($category->category_id == $categoryData->category_id)
      continue;
      $parentArray[$categoryData->category_id] = $categoryData->category_name;
      $subcategory = Engine_Api::_()->getDbtable('categories', 'sesqa')->getModuleSubcategory(array('column_name' => "*", 'category_id' => $categoryData->category_id));          foreach ($subcategory as $sub_category){
      if($category->category_id == $sub_category->category_id)
      continue;
      $parentArray[$sub_category->category_id] = '-'.$category->category_name;
      $subsubcategory = Engine_Api::_()->getDbtable('categories', 'sesqa')->getModuleSubsubcategory(array('column_name' => "*", 'category_id' => $sub_category->category_id));
      foreach ($subsubcategory as $subsub_category){
      if($category->category_id == $subsub_category->category_id)
      continue;
      $parentArray[$subsub_category->category_id] = '--'.$subsub_category->category_name;
      }
      }
      }
      $this->addElement('Select', 'parent', array(
      'label' =>'Parent',
      'allowEmpty' => true,
      'required' => false,
      'multiOptions' =>$parentArray
      )); */
// 		if(isset($category) && $category->category_id != 0){
// 			$this->addElement('Select', 'profile_type', array(
// 					'label' => 'Map Profile Type',
// 					'description' => 'Map this category with the profile type, so that questions belonging to the mapped profile type will appear to users while creating / editing their qas when they choose the associated Category.',
// 					'allowEmpty' => true,
// 					'required' => false,
// 					'multiOptions' => $profiletype
// 			));
// 		}
    $this->addElement('Textarea', 'description', array(
        'label' => 'Description',
        'description' => 'Description will appear on the Category View Page of your site.',
        'allowEmpty' => true,
        'required' => false,
    ));
    
    $levelOptions = array();
    $levelValues = array();
    foreach (Engine_Api::_()->getDbtable('levels', 'authorization')->fetchAll() as $level) {
      if($level->getTitle() == 'Public')
      continue;
      $levelOptions[$level->level_id] = $level->getTitle();
      $levelValues[] = $level->level_id;
    }
    // Select Member Levels
    $this->addElement('multiselect', 'member_levels', array(
        'label' => 'Member Levels',
        'multiOptions' => $levelOptions,
        'description' => 'Choose the Member Levels to which this Page will be displayed.(Note: Hold down the CTRL key to select or de-select specific Member Levels.)',
        'value' => $levelValues,
    ));
    
    $this->addElement('File', 'cat_icon', array(
        'label' => 'Upload Icon',
        'description' => 'Upload an icon. (The Recommended dimensions of the icon: 24px * 24px.]'
    ));
    $this->cat_icon->addValidator('Extension', false, 'jpg,jpeg,png,gif,PNG,GIF,JPG,JPEG');

    if (isset($category) && $category->cat_icon) {
      $img_path = Engine_Api::_()->storage()->get($category->cat_icon, '');
      if($img_path) {
        $img_path = $img_path->getPhotoUrl();
        if (strpos($img_path, 'http') === FALSE) {
          $path = 'http://' . $_SERVER['HTTP_HOST'] . $img_path;
        } else
          $path = $img_path;
        if (isset($path) && !empty($path)) {
          $this->addElement('Image', 'cat_icon_preview', array(
              'src' => $path,
              'width' => 100,
              'height' => 100,
          ));
        }
      }
      $this->addElement('Checkbox', 'remove_cat_icon', array(
          'label' => 'Yes, delete this category icon.'
      ));
    }

    $this->addElement('File', 'thumbnail', array(
        'label' => 'Upload Big Icon',
        'description' => 'Upload Big Icon. (The Recommended dimensions of the thumbnail: 250px * 250px.]'
    ));
    $this->thumbnail->addValidator('Extension', false, 'jpg,jpeg,png,gif,PNG,GIF,JPG,JPEG');
    if (isset($category) && $category->thumbnail) {
      $img_path = Engine_Api::_()->storage()->get($category->thumbnail, '');
      if($img_path) {
        $img_path = $img_path->getPhotoUrl();
        if (strpos($img_path, 'http') === FALSE) {
          $path = 'http://' . $_SERVER['HTTP_HOST'] . $img_path;
        } else
          $path = $img_path;
        if (isset($path) && !empty($path)) {
          $this->addElement('Image', 'cat_thumbnail_preview', array(
              'src' => $path,
              'width' => 100,
              'height' => 100,
          ));
        }
      }
      $this->addElement('Checkbox', 'remove_thumbnail_icon', array(
          'label' => 'Yes, delete this category big icon.'
      ));
    }
    
		//upload colored category icon
		$this->addElement('File', 'colored_icon', array(
        'label' => 'Upload Banner Photo',
        'description' => 'Upload Banner Photo. (The Recommended dimensions of the icon: 900px * 500px.]'
    ));
    $this->colored_icon->addValidator('Extension', false, 'jpg,jpeg,png,gif,PNG,GIF,JPG,JPEG');

    if (isset($category) && $category->colored_icon) {
      $img_path = Engine_Api::_()->storage()->get($category->colored_icon, '');
      if($img_path) {
        $img_path = $img_path->getPhotoUrl();
        if (strpos($img_path, 'http') === FALSE) {
          $path = 'http://' . $_SERVER['HTTP_HOST'] . $img_path;
        } else
          $path = $img_path;
        if (isset($path) && !empty($path)) {
          $this->addElement('Image', 'colored_icon_preview', array(
              'src' => $path,
              'width' => 100,
              'height' => 100,
          ));
        }
      }
      $this->addElement('Checkbox', 'remove_colored_icon', array(
          'label' => 'Yes, delete this banner category photo.'
      ));
    }
// 		$this->colored_icon->addValidator('Extension', false, 'jpg,jpeg,png,gif,PNG,GIF,JPG,JPEG');
    
    $this->addElement('Button', 'submit', array(
        'label' => 'Add',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper')
    ));

    $this->addElement('Cancel', 'cancel', array(
        'label' => 'Cancel',
        'link' => true,
        'prependText' => ' or ',
        'href' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'index')),
        'onClick' => 'javascript:parent.Smoothbox.close();',
        'decorators' => array(
            'ViewHelper'
        )
    ));
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
  }
}
