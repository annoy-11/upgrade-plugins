<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessiteiframe
 * @package    Sessiteiframe
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php  2017-10-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
class Sessiteiframe_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {
  
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sessiteiframe_admin_main', array(), 'sessiteiframe_admin_main_settings');
    
    $this->view->form = $form = new Sessiteiframe_Form_Admin_Global();
    
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
    
      $values = $form->getValues();
      include_once APPLICATION_PATH . "/application/modules/Sessiteiframe/controllers/License.php";
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sessiteiframe.pluginactivated')) {
        if(!empty($values['sessiteiframe_updatecode'])){
          //update core file
          $this->fixDefaultAction(true);
        }
        foreach ($values as $key => $value) {
          if($key == "sessiteiframe_updatecode")
            continue;
          Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
        }
        $form->addNotice('Your changes have been saved.');
        if($error)
          $this->_helper->redirector->gotoRoute(array());
      }
    }
  }
  function faqAction(){
      $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sessiteiframe_admin_main', array(), 'sessiteiframe_admin_main_faq');
  }
  function fixDefaultAction($return = false){
  
    if(file_exists('application/modules/Core/layouts/scripts/default.tpl')){
      $string = "<?php if(file_exists('application/modules/Sessiteiframe/views/scripts/Core/default.tpl')){
 include('application/modules/Sessiteiframe/views/scripts/Core/default.tpl');
 }
?>
                ";
      $file = APPLICATION_PATH . DIRECTORY_SEPARATOR .'application/modules/Core/layouts/scripts/default.tpl';
      chmod($file, 0777);
      $getContent = file_get_contents($file);
      $checkString = "echo $this->doctype()->__toString()";
      if(strpos($getContent,$file) == false){
        $getContent =  $string.$getContent;
        chmod($file, 0777);
        $user_model_codewrite = fopen($file, 'w+');
        fwrite($user_model_codewrite, $getContent);
        fclose($user_model_codewrite);
      }      
    }
    if($return)
      return true;
    header("Location:".$_SERVER['HTTP_REFERER']);
  }
}