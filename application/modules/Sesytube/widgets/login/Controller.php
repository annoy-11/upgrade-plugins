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
class Sesytube_Widget_LoginController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $this->view->form = $form = new User_Form_Login();
    //$form->addError('testing');
  }

}
