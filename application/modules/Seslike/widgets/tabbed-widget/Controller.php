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
class Seslike_Widget_tabbedWidgetController extends Engine_Content_Widget_Abstract {

    public function indexAction() {

        $this->view->identityForWidget = isset($_POST['identity']) ? $_POST['identity'] : '';
        $defaultOptionsArray = $this->_getParam('search_type',array('recent','popular','random', 'week', 'month', 'overall'));

        if (isset($_POST['params']))
            $params = $_POST['params'];

        $this->view->is_ajax = $is_ajax = isset($_POST['is_ajax']) ? true : false;
        $this->view->view_more = isset($_POST['view_more']) ? true : false;

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
                    if ($defaultValue == 'recent')
                    $valueLabel = 'Recent'. '||' . $defaultValue;
                    else if ($defaultValue == 'popular')
                    $valueLabel = 'Popular'. '||' . $defaultValue;
                    else if ($defaultValue == 'random')
                    $valueLabel = 'Random'. '||' . $defaultValue;
                    else if ($defaultValue == 'week')
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

        $this->view->show_limited_data = $show_limited_data = isset($params['show_limited_data']) ? $params['show_limited_data'] : $this->_getParam('show_limited_data', 0);

        $show_criterias = isset($params['show_criterias']) ? $params['show_criterias'] : $this->_getParam('show_criteria', array('like', 'by', 'title', 'likeButton'));
        if(is_array($show_criterias)) {
            foreach ($show_criterias as $show_criteria)
                $this->view->{$show_criteria . 'Active'} = $show_criteria;
        }

        $limit = isset($params['limit']) ? $params['limit'] : $this->_getParam('limit', '10');
        $this->view->loadOptionData = $loadOptionData = isset($params['pagging']) ? $params['pagging'] : $this->_getParam('pagging', 'auto_load');
        $resource_type = isset($params['resource_type']) ? $params['resource_type'] : $this->_getParam('type', '');
        $params = array('openTab' => $defaultOpenTab,'limit'=>$limit,'pagging' => $loadOptionData, 'show_criterias' => $show_criterias, 'show_limited_data'=>$show_limited_data, 'resource_type' => $resource_type);
        $this->view->loadJs = true;

        $type = '';
        switch ($defaultOpenTab) {
            case 'recent':
                $popularCol = 'creation_date';
                $type = 'creation';
            break;
            case 'popular':
                $popularCol = 'like_count';
                $type = 'popular';
            break;
            case 'random':
                $popularCol = 'random';
                $type = 'random';
            break;
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
        $value['fixedData'] = isset($fixedData) ? $fixedData : '';
        $options = array('tabbed' => true, 'paggindData' => true);
        $this->view->optionsListGrid = $options;
        $params = array_merge($params, $value);


        $likesTable = Engine_Api::_()->getDbTable('likes', 'seslike');
        $likesTableName = $likesTable->info('name');

        $select = $likesTable->select()
                            ->from($likesTableName, array('COUNT(like_id) AS like_count', '*'))
                            ->group('resource_type')
                            ->group('resource_id');

        if(!empty($popularCol) && ($popularCol == 'recent' || $popularCol == 'popular'))
            $select->order($popularCol.' DESC');
        else if(!empty($popularCol) && $popularCol == 'random')
            $select->order('RAND()');
        else
            $select->order('like_count DESC');

        if(!empty($resource_type))
            $select->where('resource_type =?', $resource_type);

        $currentTime = date('Y-m-d H:i:s');
        if(isset($popularCol) && !empty($popularCol)) {
            if($popularCol == 'week') {
                $endTime = date('Y-m-d H:i:s', strtotime("-1 week"));
                $select->where("DATE(".$likesTableName.".creation_date) between ('$endTime') and ('$currentTime')");
            } elseif($popularCol == 'month') {
                $endTime = date('Y-m-d H:i:s', strtotime("-1 month"));
                $select->where("DATE(".$likesTableName.".creation_date) between ('$endTime') and ('$currentTime')");
            }
        }

        $this->view->paginator = $paginator = Zend_Paginator::factory($select);
        $paginator->setItemCountPerPage($limit);
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $this->view->page = $page;
        $paginator->setCurrentPageNumber($page);
        $this->view->params = $params;
        if ($is_ajax)
            $this->getElement()->removeDecorator('Container');
    }
}
