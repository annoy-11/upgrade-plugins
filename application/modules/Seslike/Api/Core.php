<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslike
 * @package    Seslike
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2018-12-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslike_Api_Core extends Core_Api_Abstract {

    public function getwidgetizePage($params = array()) {

        $corePages = Engine_Api::_()->getDbtable('pages', 'core');
        $select = $corePages->select()
                ->from($corePages->info('name'), array('*'))
                ->where('name = ?', $params['name'])
                ->limit(1);
        return $corePages->fetchRow($select);
    }

    public function isLikeID($type, $id) {

        $corelikeTable = Engine_Api::_()->getDbTable('likes','core');
        $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
        return $corelikeTable->select()
                        ->from($corelikeTable->info('name'), array('like_id'))
                        ->where('resource_type =?', $type)
                        ->where('resource_id =?', $id)
                        ->where('poster_id =?', $viewer_id)
                        ->query()
                        ->fetchColumn();
    }

    public function likeCount($resource_type, $resource_id) {

        $corelikeTable = Engine_Api::_()->getDbTable('likes','core');
        $select = $corelikeTable->select()
                ->from($corelikeTable->info('name'), new Zend_Db_Expr('COUNT(1) as count'))
                ->where('resource_id =?', $resource_id)
                ->where('resource_type =?', $resource_type);
        $data = $select->query()->fetchAll();
        return (int) $data[0]['count'];
    }

    public function getModulesEnable() {

        $moduleArray = array();
        $getResults = Engine_Api::_()->getDbTable('integrateothersmodules','seslike')->getResults(array('enabled' => 1));
        foreach($getResults as $getResult) {
            $getModules = $this->getModules($getResult['module_name']);
            if(!empty($getModules)) {
                $moduleArray[$getResult['content_type']] = $getResult['module_title'];
            }
        }
        return $moduleArray;
    }

    public function getModules($module_name) {

        $table = Engine_Api::_()->getDbTable('modules','core');
        return $table->select()
                        ->from($table, array('title'))
                        ->where('name =?', $module_name)
                        ->where('enabled =?', 1)
                        ->query()
                        ->fetchColumn();
    }

    public function getPluginItem($moduleName) {

        //initialize module item array
        $moduleType = array();
        $filePath =  APPLICATION_PATH . "/application/modules/" . ucfirst($moduleName) . "/settings/manifest.php";
        //check file exists or not
        if (is_file($filePath)) {
            //now include the file
            $manafestFile = include $filePath;
            $resultsArray =  Engine_Api::_()->getDbtable('integrateothermodules', 'sesbasic')->getResults(array('module_name'=>$moduleName));
            if (is_array($manafestFile) && isset($manafestFile['items'])) {
                foreach ($manafestFile['items'] as $item)
                if (!in_array($item, $resultsArray))
                    $moduleType[$item] = $item.' ';
            }
        }
        return $moduleType;
    }
}
