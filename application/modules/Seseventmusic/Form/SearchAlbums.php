<?php

class Seseventmusic_Form_SearchAlbums extends Engine_Form {

  public function init() {

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $front = Zend_Controller_Front::getInstance();
    $module = $front->getRequest()->getModuleName();
    $controller = $front->getRequest()->getControllerName();
    $action = $front->getRequest()->getActionName();

    $content_table = Engine_Api::_()->getDbtable('content', 'core');
    $params = $content_table->select()
            ->from($content_table->info('name'), array('params'))
            //->where('page_id = ?', $id)
            ->where('name = ?', 'seseventmusic.browse-search')
            ->query()
            ->fetchColumn();
    $params = Zend_Json_Decoder::decode($params);

    $this->setAttribs(array(
                'id' => 'filter_form',
                'class' => 'global_form_box',
            ))
            ->setMethod('GET');

    if ($module == 'seseventmusic' && $controller == 'index' && $action == 'browse') {
      $this->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()));
    } else {
      $this->setAction($view->url(array('module' => 'seseventmusic', 'controller' => 'index', 'action' => 'browse'), 'seseventmusic_general', true));
    }


    parent::init();

    if (!empty($params['searchOptionsType']) && in_array('searchBox', $params['searchOptionsType'])) {
      $this->addElement('Text', 'title_name', array(
          'label' => 'Search Music Album',
          'placeholder' => 'Enter Album Name',
          
      ));
    }

    if (!empty($params['searchOptionsType']) && in_array('view', $params['searchOptionsType'])) {
      $this->addElement('Select', 'show', array(
          'label' => 'View',
          'multiOptions' => array(
              '1' => 'Everyone\'s Music Albums',
              '2' => 'Only My Friends\' Music Albums',
          ),
      ));
    }

    if (!empty($params['searchOptionsType']) && in_array('show', $params['searchOptionsType'])) {

      $this->addElement('Select', 'popularity', array(
          'label' => 'List By',
          'multiOptions' => array(
              '' => 'Select Popularity',
              'creation_date' => 'Most Recent',
              'upcoming' => 'Latest',
              'comment_count' => 'Most Commented',
              'like_count' => 'Most Liked',
              'view_count' => 'Most Viewed',
              'song_count' => 'Most Song Albums',
              'favourite_count' => 'Most Favorite',
              'rating' => 'Most Rated',
          ),
      ));
    }
    $this->addElement('Hidden', 'user');

    //Element: execute
    $this->addElement('Button', 'execute', array(
        'label' => 'Search',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array(
            'ViewHelper',
        ),
    ));
  }

}