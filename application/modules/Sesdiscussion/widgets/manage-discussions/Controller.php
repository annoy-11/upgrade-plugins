<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdiscussion
 * @package    Sesdiscussion
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-12-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesdiscussion_Widget_ManageDiscussionsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->identityForWidget = isset($_POST['identity']) ? $_POST['identity'] : '';
    $this->view->loadOptionData = $loadOptionData = isset($params['pagging']) ? $params['pagging'] : $this->_getParam('pagging', 'auto_load');
    $this->view->defaultOptionsArray = $defaultOptionsArray = $this->_getParam('search_type',array('recentlySPcreated','mostSPviewed','mostSPliked','mostSPcommented','mostSPfavourite'));

    if (isset($_POST['params']))
        $params = $_POST['params'];

    if (isset($_POST['searchParams']) && $_POST['searchParams'])
        parse_str($_POST['searchParams'], $searchArray);

    $this->view->is_ajax = $is_ajax = isset($_POST['is_ajax']) ? true : false;
    $this->view->view_more = isset($_POST['view_more']) ? true : false;
    $defaultOpenTab = array();
    $defaultOptions = $arrayOptions = array();
    if (!$is_ajax && is_array($defaultOptionsArray)) {
      foreach ($defaultOptionsArray as $key => $defaultValue) {

        if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.enable.favourite', 1) && $defaultValue == 'mostSPfavourite')
            continue;

        if ($this->_getParam($defaultValue . '_order'))
          $order = $this->_getParam($defaultValue . '_order') . '||' . $defaultValue;
        else
          $order = (1000 + $key).'||'.$defaultValue;

        if ($this->_getParam($defaultValue.'_label'))
          $valueLabel = $this->_getParam($defaultValue.'_label');
        else {
          if ($defaultValue == 'recentlySPcreated')
            $valueLabel = 'Recently Created';
          else if ($defaultValue == 'mostSPviewed')
            $valueLabel = 'Most Viewed';
          else if ($defaultValue == 'mostSPliked')
            $valueLabel = 'Most Liked';
          else if ($defaultValue == 'mostSPcommented')
            $valueLabel = 'Most Commented';
          else if ($defaultValue == 'mostSPrated')
            $valueLabel = 'Most Favourite';
        }
        $arrayOptions[$order] = $valueLabel;
      }
      ksort($arrayOptions);
      $counter = 0;
      foreach ($arrayOptions as $key => $valueOption) {
        $key = explode('||',$key);
        if ($counter == 0)
          $this->view->defaultOpenTab = $defaultOpenTab = $key[1];
        $defaultOptions[$key[1]] = $valueOption;
        $counter++;
      }
    }
    $this->view->defaultOptions = $defaultOptions;

    if (isset($_GET['openTab']) || $is_ajax) {
      $this->view->defaultOpenTab = $defaultOpenTab = (isset($_GET['openTab']) ? str_replace('_', 'SP', $_GET['openTab']) : ($this->_getParam('openTab') != NULL ? $this->_getParam('openTab') : (isset($params['openTab']) ? $params['openTab'] : '' )));
    }

    $this->view->htmlTitle = $htmlTitle = isset($params['htmlTitle']) ? $params['htmlTitle'] : $this->_getParam('htmlTitle','1');

    $this->view->tab_option = $tab_option = isset($params['tabOption']) ? $params['tabOption'] : $this->_getParam('tabOption','vertical');

    //START CODE OF FORM FILTERING
    $value['sort'] = isset($searchArray['sort']) ? $searchArray['sort'] : (isset($_GET['sort']) ? $_GET['sort'] : (isset($params['sort']) ? $params['sort'] : $this->_getParam('sort', 'mostSPliked')));

    $value['category_id'] =  isset($searchArray['category_id']) ? $searchArray['category_id'] : (isset($_GET['category_id']) ? $_GET['category_id'] : (isset($params['category_id']) ? $params['category_id'] : ''));

    $value['subcat_id'] = isset($searchArray['subcat_id']) ? $searchArray['subcat_id'] :  (isset($_GET['subcat_id']) ? $_GET['subcat_id'] : (isset($params['subcat_id']) ? $params['subcat_id'] : ''));

    $value['subsubcat_id'] = isset($searchArray['subsubcat_id']) ? $searchArray['subsubcat_id'] : (isset($_GET['subsubcat_id']) ? $_GET['subsubcat_id'] : (isset($params['subsubcat_id']) ? $params['subsubcat_id'] : ''));

    $value['tag'] = isset($_GET['tag_id']) ? $_GET['tag_id'] : (isset($params['tag_id']) ? $params['tag_id'] : '');

    $show_criterias = isset($params['show_criterias']) ? $params['show_criterias'] : $this->_getParam('show_criteria', array('like', 'comment', 'by', 'title','category', 'favouriteButton','likeButton', 'socialSharing', 'view', 'creationDate'));


    $value['user_id'] = isset($_GET['user_id']) ? $_GET['user_id'] : (isset($params['user_id']) ?  $params['user_id'] : Engine_Api::_()->user()->getViewer()->getIdentity());

    $text =  isset($searchArray['search']) ? $searchArray['search'] : (!empty($params['search']) ? $params['search'] : (isset($_GET['search']) && ($_GET['search'] != '') ? $_GET['search'] : ''));
    //END CODE OF SEARH FILTERING

    $show_criterias = isset($params['show_criterias']) ? $params['show_criterias'] : $this->_getParam('show_criteria', array('like', 'comment', 'by', 'title', 'featuredLabel','sponsoredLabel','category','description_list','description_grid', 'favouriteButton','likeButton', 'socialSharing', 'view'));
    if(is_array($show_criterias)) {
      foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;
    }

    $this->view->limit_data_list = $limit_data_list = isset($params['limit_data_list']) ? $params['limit_data_list'] : $this->_getParam('limit_data_list', '10');

    $this->view->bothViewEnable = false;
    if (!$is_ajax) {
      $optionsEnable = $this->_getParam('enableTabs', array('list'));
      if($optionsEnable == '')
      $this->view->optionsEnable = array();
      else
      $this->view->optionsEnable = $optionsEnable;
      $view_type = $this->_getParam('openViewType', 'list');
      if (count($optionsEnable) > 1) {
        $this->view->bothViewEnable = true;
      }
    }

    $this->view->socialshare_enable_plusicon = $socialshare_enable_plusicon =isset($params['socialshare_enable_plusicon']) ? $params['socialshare_enable_plusicon'] : $this->_getParam('socialshare_enable_plusicon', 1);
    $this->view->socialshare_icon_limit = $socialshare_icon_limit =isset($params['socialshare_icon_limit']) ? $params['socialshare_icon_limit'] : $this->_getParam('socialshare_icon_limit', 2);

    $this->view->view_type = $view_type = (isset($_POST['type']) ? $_POST['type'] : (isset($params['view_type']) ? $params['view_type'] : $view_type));

    $this->view->loadOptionData = $loadOptionData = isset($params['pagging']) ? $params['pagging'] : $this->_getParam('pagging', 'auto_load');
    $params = array('tag' => $value['tag'],'limit_data_list'=>$limit_data_list,'pagging' => $loadOptionData, 'show_criterias' => $show_criterias, 'view_type' => $view_type,'category_id'=>$value['category_id'],'subcat_id'=>$value['subcat_id'],'subsubcat_id' => $value['subsubcat_id'], 'sort' => $value['sort'],'user_id'=>$value['user_id'], 'socialshare_enable_plusicon' => $socialshare_enable_plusicon, 'socialshare_icon_limit' => $socialshare_icon_limit, 'tabOption' => $tab_option);

    $this->view->loadJs = true;

    // custom list grid view options
    $this->view->can_create = Engine_Api::_()->authorization()->isAllowed('discussion', null, 'create');

    $type = '';
    switch ($defaultOpenTab) {
      case 'recentlySPcreated':
        $popularCol = 'creation_date';
        $type = 'creation';
        break;
      case 'mostSPviewed':
        $popularCol = 'view_count';
        $type = 'view';
        break;
      case 'mostSPliked':
        $popularCol = 'like_count';
        $type = 'like';
        break;
      case 'mostSPcommented':
        $popularCol = 'comment_count';
        $type = 'comment';
        break;
      case 'mostSPfavourite':
        $popularCol = 'favourite_count';
        $type = 'favourite';
        break;
    }

    //START CODE OF SEARCH FORM
    $this->view->category = $value['category_id'];
    $this->view->text = $value['text']  = stripslashes($text);
    if (isset($value['sort']) && $value['sort'] != '')
    $value['getParamSort'] = str_replace('SP', '_', $value['sort']);
    else
    $value['getParamSort'] = 'creation_date';

    if (isset($value['getParamSort'])) {
      switch ($value['getParamSort']) {
        case 'most_viewed':
          $value['popularCol'] = 'view_count';
          break;
        case 'most_liked':
          $value['popularCol'] = 'like_count';
          break;
        case 'most_commented':
          $value['popularCol'] = 'comment_count';
          break;
        case 'recently_created':
        default:
          $value['popularCol'] = 'creation_date';
        break;
      }
    }
    //END CODE OF SEARCH FORM

    $this->view->type = $type;
    $value['orderby'] = $value['popularCol'] = isset($popularCol) ? $popularCol : '';
    $value['fixedData'] = isset($fixedData) ? $fixedData : '';
    //$value['search'] = 1;
    $value['manage-widget'] = 1;
    $options = array('tabbed' => true, 'paggindData' => true);
    $this->view->optionsListGrid = $options;
    $this->view->widgetName = 'manage-discussions';
    $params = array_merge($params, $value, array('search'=>addslashes($text)));

    // Get Discussions
    $paginator = Engine_Api::_()->getDbtable('discussions', 'sesdiscussion')->getDiscussionsPaginator($value);
    $this->view->paginator = $paginator;
    // Set item count per page and current page number
    $limit_data = $this->view->{'limit_data_'.$view_type};
    $paginator->setItemCountPerPage($limit_data);
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->page = $page;
    $paginator->setCurrentPageNumber($page);
    $this->view->params = $params;
    if ($is_ajax)
    $this->getElement()->removeDecorator('Container');
  }
}
