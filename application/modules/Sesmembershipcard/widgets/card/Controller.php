<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmembershipcard
 * @package    Sesmembershipcard
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-02-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesmembershipcard_Widget_CardController extends Engine_Content_Widget_Abstract
{
   function indexAction(){
        $this->view->id = Zend_Controller_Front::getInstance()->getRequest()->getParam('print_id', null);
        $viewer = $this->view->viewer();
        $subject = $this->view->subject();
        $levelId= $subject->level_id;
        $userFields =  $this->view->userFields = Engine_Api::_()->fields()->getFieldsValuesByAlias($subject);
        $settings = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmembershipcard_visibility','3');
        $visibility = $settings['visibility'];
        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        $results = $this->view->results = $db->query("SELECT alias,label FROM engine4_user_fields_maps LEFT JOIN engine4_user_fields_meta ON (engine4_user_fields_meta.field_id = engine4_user_fields_maps.child_id) WHERE alias != '' AND option_id = ".$levelId)->fetchAll();
        $profileType = !empty($userFields["profile_type"]) ? $userFields["profile_type"] : 0;
        $viewer_id = $viewer->getIdentity();
        $subject_id = $subject->getIdentity();
        if(!$profileType)
         return $this->setNoRender();

        if($visibility == 1){
           if($viewer > 0){

             if($viewer != $subject)
             return $this->setNoRender();
        }}
        if($visibility == 2){
         if($viewer_id == 0)
          return $this->setNoRender();
        }
        $sesmembershipcard_widget = Zend_Registry::isRegistered('sesmembershipcard_widget') ? Zend_Registry::get('sesmembershipcard_widget') : null;
        if(empty($sesmembershipcard_widget))
          return $this->setNoRender();
        $profileFields = array();
        foreach ($results as   $result){
        $profileFields[$result['alias']]=$result['label'];
        }
        $this->view->profileFields = $profileFields;

        $this->view->username =  $userFields['username'] = $subject->username;

        $regular_member = $db->query("SELECT label FROM engine4_user_fields_options WHERE field_id = '1' AND option_id = ".$profileType)->fetchAll();


        $this->view->profileType =  $userFields['profile_type_name'] = $regular_member[0]['label'] ;
        $table = Engine_Api::_()->getDbTable('settings','sesmembershipcard');

        $level = $this->view->level =  $table->fetchRow($table->select()->where('profile_type =?',$profileType)->where('member_level =?',$levelId)->limit(1));

         if(!$level || !$level->enable)
         return $this->setNoRender();
            // Load fields view helpers
            $view = $this->view;
            $view->addHelperPath(APPLICATION_PATH . '/application/modules/Fields/View/Helper', 'Fields_View_Helper');

            // Values
            $this->view->fieldStructure = $fieldStructure = Engine_Api::_()->fields()->getFieldsStructurePartial($subject);

         if($level->enable != 1){
         return $this->setNoRender();
         }

        $settings = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmembershipcard_print','3');
        $printing = $settings['print'] ;
        $this->view->allowed = "false";
        if($printing == 1){
           if($viewer_id > 0){
                if($viewer == $subject)
                $this->view->allowed = "true";
           }
        }
        if($printing == 2){
           if ($viewer_id != 0)
            $this->view->allowed = "true";

        }
        if($printing == 3)
           $this->view->allowed = "true";
    }
}
