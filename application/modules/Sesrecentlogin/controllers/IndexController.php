<?php

class Sesrecentlogin_IndexController extends Core_Controller_Action_Standard
{
  public function removerecentloginAction() {

    $user_id = $this->_getParam('user_id', null);
    if(empty($user_id))
        return;
    $sesrecentlogin = Zend_Json::decode($_COOKIE['sesrecentlogin_users']);
    if(count($sesrecentlogin) > 0) {
        unset($sesrecentlogin['userid_'.$user_id]);
        $cookie_value = Zend_Json::encode($sesrecentlogin);
        setcookie('sesrecentlogin_users', $cookie_value, time() + 86400, '/');
    } else {
        setcookie('sesrecentlogin_users', '', time() + 86400, '/');
    }
  }

  public function loginAction() {

    $id = $this->_getParam('user_id');
    $password = $this->_getParam('password', null);
    if(empty($password))
        return;
    $checkUser = Engine_Api::_()->sesrecentlogin()->checkUser($password, $id);

    $user = Engine_Api::_()->getItem('user', $id);
    if(!empty($checkUser) && $user->password == $password && $user->user_id == $id) {

	    // @todo change this to look up actual superadmin level
	    if (!$this->getRequest()->isPost()) {
	      if (null === $this->_helper->contextSwitch->getCurrentContext()) {
	        return $this->_helper->redirector->gotoRoute(array('action' => 'index', 'id' => null));
	      } else {
	        $this->view->status = false;
	        $this->view->error = true;
	        return;
	      }
	    }

	    // Login
	    Zend_Auth::getInstance()->getStorage()->write($user->getIdentity());

	    // Redirect
	    if (null === $this->_helper->contextSwitch->getCurrentContext()) {
	      return $this->_helper->redirector->gotoRoute(array(), 'default', true);
	    } else {
	      $this->view->status = true;
	      return;
	    }
    }
  }
}
