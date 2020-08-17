<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Edocument
 * @package    Edocument
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Edocument_Widget_DocumentPhotoController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('edocument_id', null);
    $edocument_id = Engine_Api::_()->getDbtable('edocuments', 'edocument')->getDocumentId($id);

    if(!Engine_Api::_()->core()->hasSubject())
        $this->view->edocument = Engine_Api::_()->getItem('edocument', $edocument_id);
    else
        $this->view->edocument = Engine_Api::_()->core()->getSubject();
  }
}
