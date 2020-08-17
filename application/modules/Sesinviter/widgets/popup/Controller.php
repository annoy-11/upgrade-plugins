<?php

class Sesinviter_Widget_PopupController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    
    $request = Zend_Controller_Front::getInstance()->getRequest();
    $module = $request->getModuleName();
    $controller = $request->getControllerName();
    $action = $request->getActionName();
    if ($module == "sesinviter" && $controller == "index" && $action == "invite") {
      return $this->setNoRender();
    }
    
		$this->view->formtype = $formtype = $this->_getParam('formtype',$this->_getParam('formid',null));
		$this->view->popuptype  = $this->_getParam('popuptype',1);
		$this->view->redirectOpen  = $this->_getParam('redirectOpen','0');
		
		if(!$this->view->redirectOpen)
			$this->view->popuptype = 1;
			
    $settings = Engine_Api::_()->getApi('settings', 'core');
		
    $this->view->buttontext = $this->_getParam('buttontext',false);   
    if (!($this->view->buttontext))
      return $this->setNoRender();
			
		$this->view->margintype = $this->_getParam('margintype','per');	  
		$this->view->margin = $this->_getParam('margin','3');	  
    $this->view->buttonposition = $this->_getParam('position','3');
    $this->view->buttoncolor = $this->_getParam('buttoncolor','#78c744');
    $this->view->textcolor = $this->_getParam('textcolor', '#ffffff');
    $this->view->texthovercolor = $this->_getParam('texthovercolor', '#000c24');

  }
}