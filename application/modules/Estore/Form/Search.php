<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Search.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Estore_Form_Search extends Engine_Form {

  protected $_defaultProfileId;
  protected $_contentId;

  public function getDefaultProfileId() {
    return $this->_defaultProfileId;
  }

  public function setDefaultProfileId($default_profile_id) {
    $this->_defaultProfileId = $default_profile_id;
    return $this;
  }

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
    $hideClass = 'estore_widget_advsearch_hide_' . $identity;

    $params = Engine_Api::_()->estore()->getWidgetParams($identity);

    if (isset($params['show_option']))
      $show_criterias = $params['show_option'];
    else
      $show_criterias = array();
    if (isset($params['hide_option']))
      $show_advSearch = $params['hide_option'];
    else
      $show_advSearch = array();

    $viewerId = Engine_Api::_()->user()->getViewer()->getIdentity();

    $this->setAttribs(array('id' => 'filter_form', 'class' => 'global_form_box'))->setMethod('GET');
    $this->setAction($view->url(array('module' => 'estore', 'controller' => 'index', 'action' => 'index'), 'default', true));
    $viewer = Engine_Api::_()->user()->getViewer();
    if (in_array('searchStoreTitle', $show_criterias)) {
      $this->addElement('Text', 'search', array(
          'label' => 'Search Stores',
          'class' => in_array('searchStoreTitle', $show_advSearch) ? $hideClass : '',
      ));
    }

    if (isset($show_criterias) && in_array('browseBy', $show_criterias)) {
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
        case 'mostSPfollower':
          $default_search_type = 'follow_count';
          break;
        case 'featured':
          $default_search_type = 'featured';
          break;
        case 'sponsored':
          $default_search_type = 'sponsored';
          break;
        case 'verified':
          $default_search_type = 'verified';
          break;
        case 'hot':
          $default_search_type = 'hot';
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
          case 'mostSPfollower':
            $columnValue = 'follow_count';
            $value = 'Followers';
            break;
          case 'featured':
            $columnValue = 'featured';
            $value = 'Featured';
            break;
          case 'sponsored':
            $columnValue = 'sponsored';
            $value = 'Sponsored';
            break;
          case 'verified':
            $columnValue = 'verified';
            $value = 'Verified';
            break;
          case 'hot':
            $columnValue = 'hot';
            $value = 'Hot';
            break;
        }
        $filterOptions[$columnValue] = ucwords($value);
      }
      $filterOptions = array('' => '') + $filterOptions;
      $this->addElement('Select', 'sort', array(
          'label' => 'Browse By',
          'multiOptions' => $filterOptions,
          'value' => $default_search_type,
          'class' => in_array('browseBy', $show_advSearch) ? $hideClass : '',
      ));
    }
    if (in_array('view', $show_criterias)) {
      $filterOptions = array();
      foreach ($params['criteria'] as $key => $viewOption) {
        if (!$viewerId && ($key == 1 || $key == 2 || $key == 3))
          continue;
        if (is_numeric($key))
          $columnValue = $viewOption;
        else
          $columnValue = $key;
        switch ($columnValue) {
          case '0':
            $value = 'All Stores';
            break;
          case '1':
            $value = 'Only My Friend\'s Stores';
            break;
          case '2':
            $value = 'Only My Network Stores';
            break;
          case '3':
            $value = 'Only My Stores';
            break;
          case '4':
            $value = 'Open Stores';
            break;
          case '5':
            $value = 'Closed Stores';
            break;
        }
        $filterOptions[$columnValue] = ucwords($value);
      }
      $this->addElement('Select', 'show', array(
          'label' => 'Show',
          'multiOptions' => $filterOptions,
          'value' => isset($params['default_view_search_type']) ? $params['default_view_search_type'] : '',
          'class' => in_array('view', $show_advSearch) ? $hideClass : '',
      ));
    }
    if (in_array('alphabet', $show_criterias)) {
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
          'class' => in_array('alphabet', $show_advSearch) ? $hideClass : '',
      ));
    }
    $categories = Engine_Api::_()->getDbTable('categories', 'estore')->getCategoriesAssoc();
    if (count($categories) > 0 && in_array('Categories', $show_criterias)) {
      $categories = array('0' => '') + $categories;
      $this->addElement('Select', 'category_id', array(
          'label' => 'Category',
          'multiOptions' => $categories,
          'onchange' => "showSubCategory(this.value);",
          'class' => in_array('categories', $show_advSearch) ? $hideClass : '',
      ));
      //Add Element: Sub Category
      $this->addElement('Select', 'subcat_id', array(
          'label' => "2nd-level Category",
          'allowEmpty' => true,
          'required' => false,
          'multiOptions' => array('0' => ''),
          'registerInArrayValidator' => false,
          'class' => in_array('categories', $show_advSearch) ? $hideClass : '',
          'onchange' => "showSubSubCategory(this.value);"
      ));
      //Add Element: Sub Sub Category
      $this->addElement('Select', 'subsubcat_id', array(
          'label' => "3rd-level Category",
          'allowEmpty' => true,
          'registerInArrayValidator' => false,
          'required' => false,
          'class' => in_array('categories', $show_advSearch) ? $hideClass : '',
          'multiOptions' => array('0' => ''),
          'onchange' => 'showFields(this.value,1);'
      ));
      if (in_array('customFields', $show_criterias)) {
        $defaultProfileId = "0_0_" . $this->getDefaultProfileId();
        $customFields = new Estore_Form_Custom_Fields(array(
            'packageId' => '',
            'resourceType' => '',
            'item' => isset($store) ? $store : 'stores',
            'decorators' => array(
                'FormElements'
        )));
        $customFields->removeElement('submit');
        if ($customFields->getElement($defaultProfileId)) {
          $customFields->getElement($defaultProfileId)
                  ->clearValidators()
                  ->setRequired(false)
                  ->setAllowEmpty(true);
        }
        $this->addSubForms(array(
            'fields' => $customFields
        ));
      }
    }
    $cookiedata = Engine_Api::_()->sesbasic()->getUserLocationBasedCookieData();
    if (in_array('location', $show_criterias) && Engine_Api::_()->getApi('settings', 'core')->getSetting('estore_enable_location', 1)) {
      $this->addElement('Text', 'location', array(
          'label' => 'Location:',
          'id' => 'locationSesList',
          'class' => '',
          'value' => !empty($cookiedata['location']) ? $cookiedata['location'] : '',
          'class' => in_array('location', $show_advSearch) ? $hideClass : '',
          'filters' => array(
              new Engine_Filter_Censor(),
              new Engine_Filter_HtmlSpecialChars(),
          ),
      ));
      $this->addElement('Text', 'lat', array(
          'id' => 'latSesList',
          'style' => 'display:none',
          'value' => !empty($cookiedata['lat']) ? $cookiedata['lat'] : '',
          'filters' => array(
              new Engine_Filter_Censor(),
              new Engine_Filter_HtmlSpecialChars(),
          ),
      ));
      $this->addElement('Text', 'lng', array(
          'id' => 'lngSesList',
          'style' => 'display:none',
          'value' => !empty($cookiedata['lng']) ? $cookiedata['lng'] : '',
          'filters' => array(
              new Engine_Filter_Censor(),
              new Engine_Filter_HtmlSpecialChars(),
          ),
      ));

      if (in_array('miles', $show_criterias)) {
        if (Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.search.type', 1) == 1)
          $searchType = 'Miles:';
        else
          $searchType = 'Kilometer:';
        //Add Element: Sub Category
        $this->addElement('Select', 'miles', array(
            'label' => $searchType,
            'allowEmpty' => true,
            'class' => in_array('miles', $show_advSearch) ? $hideClass : '',
            'required' => false,
            'multiOptions' => array('0' => '', '1' => '1', '5' => '5', '10' => '10', '20' => '20', '50' => '50', '100' => '100', '200' => '200', '500' => '500', '1000' => '1000'),
            'value' => 1000,
            'registerInArrayValidator' => false,
        ));
      }
    }
    if (in_array('country', $show_criterias)) {
      $locale = Zend_Registry::get('Zend_Translate')->getLocale();
      $territories = Zend_Locale::getTranslationList('territory', $locale, 2);
      asort($territories);
      $arrayTerr = array('' => '');
      foreach ($territories as $key => $val)
        $arrayTerr[$val] = $val;
      //Add Element: country
      $this->addElement('Select', 'country', array(
          'label' => "Country:",
          'allowEmpty' => true,
          'class' => in_array('country', $show_advSearch) ? $hideClass : '',
          'registerInArrayValidator' => false,
          'required' => false,
          'multiOptions' => $arrayTerr,
      ));
    }
    if (in_array('state', $show_criterias)) {
      $this->addElement('Text', 'state', array(
          'label' => 'State:',
          'class' => in_array('state', $show_advSearch) ? $hideClass : '',
      ));
    }
    if (in_array('city', $show_criterias)) {
      $this->addElement('Text', 'city', array(
          'label' => 'City:',
          'class' => in_array('city', $show_advSearch) ? $hideClass : '',
      ));
    }
    if (in_array('zip', $show_criterias)) {
      $this->addElement('Text', 'zip', array(
          'label' => 'Zip:',
          'class' => in_array('zip', $show_advSearch) ? $hideClass : '',
      ));
    }
    if (in_array('venue', $show_criterias)) {
      $this->addElement('Text', 'venue', array(
          'label' => 'Venue:',
          'class' => in_array('venue', $show_advSearch) ? $hideClass : '',
      ));
    }
    if (in_array('closestore', $show_criterias)) {
      $this->addElement('Checkbox', 'is_close_store', array(
          'label' => 'Include Closed Stores',
          'class' => in_array('closestore', $show_advSearch) ? $hideClass : '',
              //'decorators' => array(
//              'ViewHelper',
//              array('Description', array()),
//             // array('Label', array('placement' => 'APPEND', 'tag' => 'label')),
//              // array('HtmlTag', array('tag' => 'li', 'class' => 'is_close_store'))
//          ),
      ));
    }
    $this->addElement('Cancel', 'advanced_options_search_' . $identity, array(
        'label' => 'Show Advanced Settings',
        'link' => true,
        'class' => 'active',
        'href' => 'javascript:;',
        'onclick' => 'return false;',
        'decorators' => array(
            'ViewHelper'
        )
    ));
    $this->addElement('Hidden', 'stores', array(
        'order' => 100
    ));
    $this->addElement('Hidden', 'tag', array(
        'order' => 101
    ));
    $this->addElement('Button', 'submit', array(
        'label' => 'Search',
        'type' => 'submit'
    ));

    $this->addDisplayGroup(array('submit', 'advanced_options_search_' . $identity), 'buttons', array(
        'decorators' => array(
            'FormElements',
            'DivDivDivWrapper',
        ),
    ));
  }

}
