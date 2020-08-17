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

class Seslike_Widget_SideWidgetController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->allParam = $allParam = $this->_getAllParams();

    $type = $allParam['module'];
    $limit = $allParam['limit'];

    $likesTable = Engine_Api::_()->getDbTable('likes', 'seslike');
    $likesTableName = $likesTable->info('name');

    $select = $likesTable->select()
                        ->from($likesTableName, array('COUNT(like_id) AS like_count', '*'))
                        ->where('resource_type =?', $type)
                        ->group('resource_type')
                        ->group('resource_id')
                        ->order('like_count DESC')
                        ->limit($limit);
    $this->view->results = $results = $likesTable->fetchAll($select);
    if(count($results) == 0)
        return $this->setNoRender();

  }

}
