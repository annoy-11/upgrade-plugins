<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesjob_Widget_CompanyViewController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    // Check permission
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer->getIdentity();

    $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('company_id', null);
    if(!Engine_Api::_()->core()->hasSubject())
        $company = Engine_Api::_()->getItem('sesjob_company', $company_id);
    else
        $company = Engine_Api::_()->core()->getSubject();

    $this->view->isCpnysubscribe = Engine_Api::_()->getDbTable('cpnysubscribes', 'sesjob')->isCpnysubscribe(array('resource_type' => "sesjob_company", 'resource_id' => $company->getIdentity()));

    // Prepare data
    $this->view->company = $company;
  }
}
