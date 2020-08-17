<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesariana
 * @package    Sesariana
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesariana_Widget_LoginController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $this->view->showlogo = $this->_getParam('showlogo', 1);
    $this->view->form = $form = new User_Form_Login();
    //$form->addError('testing');
  }

}
