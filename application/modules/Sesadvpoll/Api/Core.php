<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvpoll
 * @package    Sesadvpoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2018-12-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesadvpoll_Api_Core extends Core_Api_Abstract {

    public function getSearchWidgetParams($widgetId) {

        $db = Engine_Db_Table::getDefaultAdapter();
        $pageId = $db->select()
                ->from('engine4_core_content', 'page_id')
                ->where('`content_id` = ?', $widgetId)
                ->query()
                ->fetchColumn();
        $params = $db->select()
                ->from('engine4_core_content', 'params')
                ->where('`page_id` = ?', $pageId)
                ->where('`name` = ?', 'sesadvpoll.browse-search')
                ->query()
                ->fetchColumn();
        if ($params)
            return json_decode($params, true);
        else
            return 0;
    }
    public function getwidgetizePage($params = array()) {

        $corePages = Engine_Api::_()->getDbtable('pages', 'core');
        $select = $corePages->select()
                ->from($corePages->info('name'), array('*'))
                ->where('name = ?', $params['name'])
                ->limit(1);
        return $corePages->fetchRow($select);
    }
    public function getIdentityWidget($name, $type, $corePages) {
        $widgetTable = Engine_Api::_()->getDbTable('content', 'core');
        $widgetPages = Engine_Api::_()->getDbTable('pages', 'core')->info('name');
        $identity = $widgetTable->select()
                ->setIntegrityCheck(false)
                ->from($widgetTable, 'content_id')
                ->where($widgetTable->info('name') . '.type = ?', $type)
                ->where($widgetTable->info('name') . '.name = ?', $name)
                ->where($widgetPages . '.name = ?', $corePages)
                ->joinLeft($widgetPages, $widgetPages . '.page_id = ' . $widgetTable->info('name') . '.page_id')
                ->query()
                ->fetchColumn();
        return $identity;
    }
}
