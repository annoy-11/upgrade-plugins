<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagenote
 * @package    Sespagenote
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Search.php  2019-03-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagenote_Form_Search extends Engine_Form {

  protected $_contentId;
  public function getContentId() {
    return $this->_contentId;
  }

  public function setContentId($content_id) {
    $this->_contentId = $content_id;
    return $this;
  }

  public function init() {

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;

    $identity = $view->identity;

    if($this->_contentId){
        $identity = $this->_contentId;
    }
    $params = Engine_Api::_()->sespage()->getWidgetParams($identity);
    $viewerId = Engine_Api::_()->user()->getViewer()->getIdentity();

    $this->setAttribs(array('id' => 'filter_form', 'class' => 'global_form_box'))->setMethod('GET');
    $this->setAction($view->url(array('module' => 'sespagenote', 'controller' => 'index', 'action' => 'index'), 'default', true));
    $viewer = Engine_Api::_()->user()->getViewer();
      $this->addElement('Text', 'search', array(
          'label' => 'Search Notes',
      ));

      switch ($params['default_search_type']) {
        case 'recentlySPcreated':
          $default_search_type = 'creation_date';
          break;
        case 'mostSPviewed':
          $default_search_type = 'view_count';
          break;
        case 'mostSPliked':
          $default_search_type = 'like_count';
          break;
        case 'mostSPcommented':
          $default_search_type = 'comment_count';
          break;
        case 'mostSPfavourite':
          $default_search_type = 'favourite_count';
          break;
        case 'featured':
          $default_search_type = 'featured';
          break;
        case 'sponsored':
          $default_search_type = 'sponsored';
          break;
      }
      $filterOptions = array();
      foreach ($params['search_type'] as $key => $widgetOption) {
        if (is_numeric($key))
          $columnValue = $widgetOption;
        else
          $columnValue = $key;
        switch ($columnValue) {
          case 'recentlySPcreated':
            $columnValue = 'creation_date';
            $value = 'Newest';
            break;
          case 'mostSPviewed':
            $columnValue = 'view_count';
            $value = 'Views';
            break;
          case 'mostSPliked':
            $columnValue = 'like_count';
            $value = 'Likes';
            break;
          case 'mostSPcommented':
            $columnValue = 'comment_count';
            $value = 'Comments';
            break;
          case 'mostSPfavourite':
            $columnValue = 'favourite_count';
            $value = 'Favourites';
            break;
          case 'featured':
            $columnValue = 'featured';
            $value = 'Featured';
            break;
          case 'sponsored':
            $columnValue = 'sponsored';
            $value = 'Sponsored';
            break;
        }
        $filterOptions[$columnValue] = ucwords($value);
      }
      $filterOptions = array('' => '') + $filterOptions;
      $this->addElement('Select', 'order', array(
          'label' => 'Browse By',
          'multiOptions' => $filterOptions,
          'value' => $default_search_type,
      ));

    $alphabetArray[] = '';
    foreach (range('A', 'Z') as $char) {
    $alphabetArray[strtolower($char)] = $char;
    }
    $this->addElement('Select', 'alphabet', array(
        'label' => 'Alphabet:',
        'multiOptions' => $alphabetArray,
        'filters' => array(
            new Engine_Filter_Censor(),
            new Engine_Filter_HtmlSpecialChars(),
        ),
    ));


    $this->addElement('Hidden', 'page', array(
        'order' => 100
    ));
    $this->addElement('Button', 'submit', array(
        'label' => 'Search',
        'type' => 'submit'
    ));
  }
}
