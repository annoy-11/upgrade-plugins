<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslike
 * @package    Seslike
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-12-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Seslike_Widget_sidebarTabbedWidgetController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->identityForWidget = isset($_POST['identity']) ? $_POST['identity'] : '';
    $this->view->defaultOptionsArray = $defaultOptionsArray = $this->_getParam('search_type',array('week', 'month', 'overall'));

    $this->view->viewer = Engine_Api::_()->user()->getViewer();

    if (isset($_POST['params']))
        $params = $_POST['params'];

    $this->view->is_ajax = $is_ajax = isset($_POST['is_ajax']) ? true : false;

    $defaultOpenTab = array();
    $defaultOptions = $arrayOptions = array();
    if (!$is_ajax && is_array($defaultOptionsArray)) {
      foreach ($defaultOptionsArray as $key => $defaultValue) {
        if ($this->_getParam($defaultValue . '_order'))
          $order = $this->_getParam($defaultValue . '_order');
        else
          $order = (777 + $key);
        if ($this->_getParam($defaultValue.'_label'))
          $valueLabel = $this->_getParam($defaultValue . '_label'). '||' . $defaultValue;
        else {
            if ($defaultValue == 'week')
                $valueLabel = 'This Week'. '||' . $defaultValue;
            else if ($defaultValue == 'month')
                $valueLabel = 'This Month'. '||' . $defaultValue;
            else if ($defaultValue == 'overall')
                $valueLabel = 'Overall'. '||' . $defaultValue;
        }
        $arrayOptions[$order] = $valueLabel;
      }
      ksort($arrayOptions);
      $counter = 0;
      foreach ($arrayOptions as $key => $valueOption) {
        $key = explode('||', $valueOption);
        if ($counter == 0)
          $this->view->defaultOpenTab = $defaultOpenTab = $key[1];
        $defaultOptions[$key[1]] = $key[0];
        $counter++;
      }
    }
    $this->view->defaultOptions = $defaultOptions;

    if (isset($_GET['openTab']) || $is_ajax) {
        $this->view->defaultOpenTab = $defaultOpenTab = (isset($_GET['openTab']) ? str_replace('_', 'SP', $_GET['openTab']) : ($this->_getParam('openTab') != NULL ? $this->_getParam('openTab') : (isset($params['openTab']) ? $params['openTab'] : '' )));
    }

    $this->view->limit = $limit = isset($params['limit']) ? $params['limit'] : $this->_getParam('limit', '3');
    $this->view->resource_type = $resource_type = isset($params['resource_type']) ? $params['resource_type'] : $this->_getParam('type', '');
    $params = array('openTab' => $defaultOpenTab, 'limit' => $limit, 'resource_type' => $resource_type);
    $this->view->loadJs = true;

    $type = '';
    switch ($defaultOpenTab) {
        case 'week':
            $popularCol = 'week';
            $type = 'week';
        break;
        case 'month':
            $popularCol = 'month';
            $type = 'month';
        break;
        case 'overall':
            $popularCol = 'overall';
            $type = 'overall';
        break;
    }

    $this->view->type = $type;
    $value['popularCol'] = isset($popularCol) ? $popularCol : '';
    $this->view->widgetName = 'sidebar-tabbed-widget';
    $params = array_merge($params, $value);

    $likesTable = Engine_Api::_()->getDbTable('likes', 'seslike');
    $likesTableName = $likesTable->info('name');

    $select = $likesTable->select()
                        ->from($likesTableName, array('COUNT(like_id) AS like_count', '*'))
                        ->where('resource_type =?', $resource_type)
                        ->group('resource_type')
                        ->group('resource_id')
                        ->order('like_count DESC')
                        ->limit($limit);

    $currentTime = date('Y-m-d H:i:s');
    if(isset($value['popularCol']) && !empty($value['popularCol'])) {
        if($value['popularCol'] == 'week') {
            $endTime = date('Y-m-d H:i:s', strtotime("-1 week"));
            $select->where("DATE(".$likesTableName.".creation_date) between ('$endTime') and ('$currentTime')");
        } elseif($value['popularCol'] == 'month') {
            $endTime = date('Y-m-d H:i:s', strtotime("-1 month"));
            $select->where("DATE(".$likesTableName.".creation_date) between ('$endTime') and ('$currentTime')");
        }
    }

    $this->view->paginator = $paginator = Zend_Paginator::factory($select); //$likesTable->fetchAll($select);
    $paginator->setItemCountPerPage($limit);
    $this->view->params = $params;
    if ($is_ajax)
        $this->getElement()->removeDecorator('Container');
  }
}
