<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdemouser
 * @package    Sesdemouser
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php 2015-10-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesdemouser_IndexController extends Core_Controller_Action_Standard {

  public function loginAction() {

    $id = $this->_getParam('id');
    $user = Engine_Api::_()->getItem('user', $id);

    $getDemoUserId = Engine_Api::_()->getDbtable('demousers', 'sesdemouser')->getDemoUserId($id);
		if(!empty($getDemoUserId) && $getDemoUserId && $user->level_id != 1) {

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

        // Get ip address
        $db = Engine_Db_Table::getDefaultAdapter();
        $ipObj = new Engine_IP();
        $ipExpr = new Zend_Db_Expr($db->quoteInto('UNHEX(?)', bin2hex($ipObj->toBinary())));

        // Check if user exists
        //Login table work
        if($user) {
            $loginTable = Engine_Api::_()->getDbtable('logins', 'user');
            $loginTable->insert(array(
                'user_id' => $user->getIdentity(),
                'email' => $user->email,
                'ip' => $ipExpr,
                'timestamp' => new Zend_Db_Expr('NOW()'),
                'state' => 'success',
                'active' => true,
            ));
        }

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
