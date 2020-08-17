<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventspeaker
 * @package    Seseventspeaker
 * @copyright  Copyright 2018-2017 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: SearchSpeaker.php 2017-03-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Seseventspeaker_Form_SearchSpeaker extends Engine_Form {

  public function init() {

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $front = Zend_Controller_Front::getInstance();
    $module = $front->getRequest()->getModuleName();
    $controller = $front->getRequest()->getControllerName();
    $action = $front->getRequest()->getActionName();

    $content_table = Engine_Api::_()->getDbtable('content', 'core');
    $params = $content_table->select()
            ->from($content_table->info('name'), array('params'))
            ->where('name = ?', 'seseventspeaker.speaker-browse-search')
            ->query()
            ->fetchColumn();
    $params = Zend_Json_Decoder::decode($params);

    $this->setAttribs(array(
                'id' => 'filter_form',
                'class' => 'global_form_box',
            ))
            ->setMethod('GET');

    if ($module == 'seseventspeaker' && $controller == 'index' && $action == 'browse') {
      $this->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()));
    } else {
      $this->setAction($view->url(array('module' => 'seseventspeaker', 'controller' => 'index', 'action' => 'browse'), 'default', true));
    }
    parent::init();

    if (!empty($params['searchOptionsType']) && in_array('searchBox', $params['searchOptionsType'])) {
      $this->addElement('Text', 'title_name', array(
          'label' => 'Search Speaker',
          'placeholder' => 'Enter Speaker Name',
      ));
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
              //'event_count' => 'Most Event Speaker',
              'favourite_count' => 'Most Favorite',
							'like_count' => 'Most Liked',
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