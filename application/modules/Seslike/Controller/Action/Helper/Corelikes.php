<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslike
 * @package    Seslike
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Corelikes.php  2018-12-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslike_Controller_Action_Helper_Corelikes extends Zend_Controller_Action_Helper_Abstract {

    function postDispatch() {

        $front = Zend_Controller_Front::getInstance();
        $dbInsert = Engine_Db_Table::getDefaultAdapter();
        $module = $front->getRequest()->getModuleName();
        $controller = $front->getRequest()->getControllerName();
        $action = $front->getRequest()->getActionName();

        $type = $front->getRequest()->getParam('type', null);
        $id = $front->getRequest()->getParam('id', null);
        $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();

        if($module == 'core' && $controller == 'comment' && $action == 'like') {
            if(!empty($type) && !empty($id)) {
                $isLikeID = Engine_Api::_()->seslike()->isLikeID($type, $id);
                $seslikeTable = Engine_Api::_()->getDbTable('likes', 'seslike');
                if(!empty($isLikeID)) {
                    $dbInsert->query('DELETE FROM `engine4_seslike_likes` WHERE `engine4_seslike_likes`.`resource_id` = "'.$id.'" AND `engine4_seslike_likes`.`resource_type` = "'.$type.'" AND `engine4_seslike_likes`.`poster_id` = "'.$viewer_id.'";');
                    $db = $seslikeTable->getAdapter();
                    $db->beginTransaction();
                    try {
                        $values = array('corelike_id' => $isLikeID, 'resource_type' => $type, 'resource_id' => $id, 'poster_type' => 'user', 'poster_id' => $viewer_id, 'creation_date' => date('Y-m-d H:i:s'));
                        $row = $seslikeTable->createRow();
                        $row->setFromArray($values);
                        $row->save();
                        $db->commit();
                    } catch( Exception $e ) {

                    }
                }
            }
        } else if($module == 'core' && $controller == 'comment' && $action == 'unlike') {
            $dbInsert->query('DELETE FROM `engine4_seslike_likes` WHERE `engine4_seslike_likes`.`resource_id` = "'.$id.'" AND `engine4_seslike_likes`.`resource_type` = "'.$type.'" AND `engine4_seslike_likes`.`poster_id` = "'.$viewer_id.'";');
        }
    }
}
