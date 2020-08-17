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
class Seslike_Widget_mylikesWidgetController extends Engine_Content_Widget_Abstract {

    public function indexAction() {

        $this->view->identityForWidget = isset($_POST['identity']) ? $_POST['identity'] : '';

        $defaultOptionsArray = array_merge(array('all' => 'All Content'), Engine_Api::_()->seslike()->getModulesEnable());

        if (isset($_POST['params']))
            $params = $_POST['params'];

        $this->view->is_ajax = $is_ajax = isset($_POST['is_ajax']) ? true : false;
        $this->view->view_more = isset($_POST['view_more']) ? true : false;

        $defaultOpenTab = array();
        $defaultOptions = $arrayOptions = array();
        if (!$is_ajax && is_array($defaultOptionsArray)) {
            foreach ($defaultOptionsArray as $key => $defaultValue) {
                $arrayOptions[$key] = $defaultValue;
            }
            $defaultOptions = $arrayOptions;
        }
        $this->view->defaultOptions = $defaultOptions;

        if (isset($_GET['openTab']) || $is_ajax) {
            $this->view->defaultOpenTab = $defaultOpenTab = (isset($_GET['openTab']) ? str_replace('_', 'SP', $_GET['openTab']) : ($this->_getParam('openTab') != NULL ? $this->_getParam('openTab') : (isset($params['openTab']) ? $params['openTab'] : '' )));
        }

        $limit = isset($params['limit']) ? $params['limit'] : $this->_getParam('limit', '12');
        $this->view->loadOptionData = $loadOptionData = isset($params['pagging']) ? $params['pagging'] : $this->_getParam('pagging', 'auto_load');
        $resource_type = $defaultOpenTab;
        $params = array('openTab' => $defaultOpenTab,'limit'=>$limit, 'pagging' => $loadOptionData, 'resource_type' => $defaultOpenTab);
        $this->view->loadJs = true;

        $value['fixedData'] = isset($fixedData) ? $fixedData : '';
        $options = array('tabbed' => true, 'paggindData' => true);
        $this->view->optionsListGrid = $options;
        $params = array_merge($params, $value);

        $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
        $select = Engine_Api::_()->getDbTable('likes', 'seslike')->getLikeResults(array('viewer_id' => $viewer_id, 'resource_type' => $resource_type));

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
