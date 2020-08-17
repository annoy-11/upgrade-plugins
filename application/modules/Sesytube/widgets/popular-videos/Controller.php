<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesytube
 * @package    Sesytube
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-02-01 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesytube_Widget_PopularVideosController extends Engine_Content_Widget_Abstract {

    public function indexAction() {

        $db = Zend_Db_Table_Abstract::getDefaultAdapter();

        $popularitycriteria = $this->_getParam('popularitycriteria', 'creation_date');
        $limit = $this->_getParam('limit', 3);

        $table = Engine_Api::_()->getItemTable('video');
        $tableName = $table->info('name');

        $select = $table->select()->from($tableName)->limit($limit);

        $popularitycriteria_exist = $db->query("SHOW COLUMNS FROM ".$tableName." LIKE '".$popularitycriteria."'")->fetch();
        if (!empty($popularitycriteria_exist)) {
            $select->order("$popularitycriteria DESC");
        } else {
            $select->order('creation_date DESC');
        }
        $column_exist = $db->query("SHOW COLUMNS FROM ".$tableName." LIKE 'is_delete'")->fetch();
        if (!empty($column_exist)) {
            $select->where('is_delete =?',0);
        }

        $this->view->results = $results = $table->fetchAll($select);
        if(!count($results))
            $this->setNoRender();
    }
}
