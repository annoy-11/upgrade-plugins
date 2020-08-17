<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: SearchWishlist.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Courses_Form_Wishlist_SearchWishlist extends Engine_Form {

  public function init() {

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $front = Zend_Controller_Front::getInstance();
    $module = $front->getRequest()->getModuleName();
    $controller = $front->getRequest()->getControllerName();
    $action = $front->getRequest()->getActionName();

    $content_table = Engine_Api::_()->getDbtable('content', 'core');
    $params = $content_table->select()
            ->from($content_table->info('name'), array('params'))
            ->where('name = ?', 'courses.wishlists-browse-search')
            ->query()
            ->fetchColumn();
    $params = Zend_Json_Decoder::decode($params);

       $searchFor = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module'=>'courses','controller'=>'album','action'=>'browse'));

    $this->setAttribs(array(
                'id' => 'filter_form',
                'class' => 'global_form_box',
            ))
            ->setMethod('GET');

    if ($module == 'courses' && $controller == 'wishlist' && $action == 'browse') {
      $this->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()));
    } else {
      $this->setAction($view->url(array('module' => 'courses', 'controller' => 'wishlist', 'action' => 'browse'), 'default', true));
    }
    parent::init();
    if (!empty($params['searchOptionsType']) && in_array('searchBox', $params['searchOptionsType'])) {
      $this->addElement('Text', 'title_name', array(
          'label' => 'Search Wishlist',
          'placeholder' => 'Enter Wishlist Name',
      ));
    }
    if (!empty($params['searchOptionsType']) && in_array('view', $params['searchOptionsType'])) {
      $this->addElement('Select', 'show', array(
          'label' => 'View',
          'multiOptions' => array(
              '1' => 'Everyone\'s Wishlist',
              '2' => 'Only My Friends\' Wishlist',
          ),
      ));
    }
    if (!empty($params['searchOptionsType']) && in_array('category', $params['searchOptionsType'])) {
        $categories = Engine_Api::_()->getDbtable('categories', 'courses')->getCategory(array('column_name' => '*'));
            $data[''] = 'Choose a Category';
        foreach ($categories as $category) {
            $data[$category['category_id']] = $category['category_name'];
                    $categoryId = $category['category_id'];
        }
        if (count($categories) > 1) {
        $this->addElement('Select', 'category_id', array(
            'label' => "Category",
            'required' => false,
            'multiOptions' => $data,
            'decorators' => array(
                'ViewHelper',
                array('Label', array('tag' => null, 'placement' => 'PREPEND')),
                array('HtmlTag', array('tag' => 'div'))
            ),
        ));
        }
    }
    if (!empty($params['searchOptionsType']) && in_array('show', $params['searchOptionsType'])) {
      $this->addElement('Select', 'popularity', array(
          'label' => 'List By',
          'multiOptions' => array(
            '' => 'Select Popularity',
            'creation_date' => 'Most Recent',
            'featured' => "Only Featured",
            'sponsored' => "Only Sponsored",
            'view_count' => 'Most Viewed',
            'course_count' => 'Most Courses Wishlist',
            'favourite_count' => 'Most Favourite',
            'like_count' => 'Most Liked',
          ),
      ));
    }
    if (!empty($params['searchOptionsType']) && in_array('brand', $params['searchOptionsType'])) {

    }
    $this->addElement('Hidden', 'user');

    //Element: execute
    $this->addElement('Button', 'submit', array(
        'label' => 'Search',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array(
            'ViewHelper',
        ),
    ));
  }

}
