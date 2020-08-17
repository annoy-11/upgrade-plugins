<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmembershipcard
 * @package    Sesmembershipcard
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php  2019-02-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesmembershipcard_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $db = Engine_Db_Table::getDefaultAdapter();

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesmembershipcard_admin_main', array(), 'sesmembershipcard_admin_main_settings');
    
    $table_exist = $db->query('SHOW TABLES LIKE \'engine4_sesmembershipcard_settings\'')->fetch();
    if($table_exist) {
      Engine_Api::_()->getApi('settings', 'core')->setSetting('sesmembershipcard.pluginactivated', 1);
    }

    $this->view->form = $form = new Sesmembershipcard_Form_Admin_Global();

    if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
      $values = $form->getValues();
      include_once APPLICATION_PATH . "/application/modules/Sesmembershipcard/controllers/License.php";
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmembershipcard.pluginactivated')) {
        foreach ($values as $key => $value) {
          if($value != '')
            Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
        }
        $form->addNotice('Your changes have been saved.');
        if($error)
          $this->_helper->redirector->gotoRoute(array());
      }
    }
  }

  public function levelAction()
  {
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
            ->getNavigation('sesmembershipcard_admin_main', array(), 'sesmembershipcard_admin_main_level');



    $table = Engine_Api::_()->getDbTable('levels','authorization');
        $results = $table->fetchAll($table->select()->where('type !=?','public'));
    $memberLevelId = 0;
    $profileId = 0;
        $levels = array();

        foreach($results as $result){
        if(!$memberLevelId)
        $memberLevelId = $result->getIdentity();
        $levels[$result->getIdentity()] = $result->title;
        }

        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
    $results = $db->query("SELECT * FROM engine4_user_fields_options WHERE field_id = 1")->fetchAll();

    $profileTypes = array();
    foreach($results as $result){
        if(!$profileId)
        $profileId = $result['option_id'];
        $profileTypes[$result['option_id']] = $result['label'];
        }

        if(!empty($_GET['level']))
        $memberLevelId = $_GET['level'];
        if(!empty($_GET['profile']))
        $profileId = $_GET['profile'];

    //$form->populate($row->toArray());
        $table = Engine_Api::_()->getDbTable('settings','sesmembershipcard');
         $level = $table->fetchRow($table->select()->where('member_level =?',$memberLevelId)->where('profile_type =?',$profileId)->limit(1));


         $db = Zend_Db_Table_Abstract::getDefaultAdapter();

        $results = $db->query("SELECT alias,label FROM engine4_user_fields_maps LEFT JOIN engine4_user_fields_meta ON (engine4_user_fields_meta.field_id = engine4_user_fields_maps.child_id) WHERE alias != '' AND option_id = ".$profileId)->fetchAll();

        $profileFields = array('username'=>'Username','profile_type_name'=>'Profile Type');
        foreach($results as $result){
            $profileFields[$result['alias']] = $result['label'];


        }
         $this->view->form = $form = new Sesmembershipcard_Form_Admin_Level(array('itemData'=>$level));
         $form->member_level->setMultiOptions($levels);
         $form->profile_type->setMultiOptions($profileTypes);

         $form->member_level->setValue($memberLevelId);
         $form->profile_type->setValue($profileId);
         $form->profile_fields->setMultiOptions($profileFields);

         if($level){
              $keys = json_decode($level->profile_fields,true);
              $form->populate($level->toArray());
              $form->profile_fields->setValue(array_combine($keys, $keys));
          }





        if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
            $values = $form->getValues();
            // Process
            $db = Engine_Api::_()->getDbTable('settings', 'sesmembershipcard')->getAdapter();
            $db->beginTransaction();
            try {

                $settingsTable = Engine_Api::_()->getDbTable('settings', 'sesmembershipcard');
                if(!$level){
                    $level = $settingsTable->createRow();
                }
                $level->setFromArray($values);
                $level->save();
                if($values['show_title'] == "2")
                {
                $level->title = '';
                $level->title_color = '';
                 $level->title_font = 0;
                }

                      if($values['background'] == "2"){
                         if(!empty($_FILES["background_image_img"]['name']) && !empty($_FILES["background_image_img"]['size']) ){
                         $level->background_color = '';
                         $level->background_image =   $level->setPhoto($form->background_image_img);
                         }
                  }else{
                    $level->background_image = 0;
                }
                if($values['site_title_logo'] == "0"){
                   if(!empty($_FILES["logo_image_img"]['name']) & !empty($_FILES["logo_image_img"]['size']) )
                     $level->logo_image =   $level->setPhoto($form->logo_image_img);
                }else
                {
                  $level->logo_image = 0;
                }


                   if($values['back_background'] == "2"){
                    if(!empty($_FILES["back_background_image_img"]['name']) & !empty($_FILES["back_background_image_img"]['size']))
                     $level->back_background_image =   $level->setPhoto($form->back_background_image_img);
                }
                else
                {
                  $level->back_background_image = 0;
                }

                 if($values['backside'] == "1"){
                  if($values['back_title_logo'] == "0"){
                     if(!empty($_FILES["back_logo_img"]['name']) & !empty($_FILES["back_logo_img"]['size']))
                     $level->back_logo =   $level->setPhoto($form->back_logo_img);
                  }
                 }else{
                   $level->back_logo = 0;
                 }


                $level->profile_fields = json_encode($values['profile_fields']);// to save the multicheckbox values.



                $level->save();
                $db->commit();

                $form->addNotice("All changes saved successfully.");
                $this->_helper->redirector->gotoRoute(array());
            }catch(Exception $e){
                $db->rollBack();
                throw $e;

            }
        }
  }

}
