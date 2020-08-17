<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagebuilder_IndexController extends Core_Controller_Action_Standard {

  public function indexAction() {

    $pagebuilderId = $this->_getParam('pagebuilder_id', null);
    $page = "sespagebuilder_index_$pagebuilderId";

    $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
    $pageObject = Engine_Api::_()->getDbtable('pagebuilders', 'sespagebuilder')->find($pagebuilderId)->current();
//     if (empty($viewer_id) && isset($pageObject->show_page) && empty($pageObject->show_page))
//       return $this->_forward('requireauth', 'error', 'core');

    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagebuilder.showpages'))
      return $this->_forward('notfound', 'error', 'core');

    $returnValue = Engine_Api::_()->sespagebuilder()->checkPrivacySetting($pagebuilderId);
    if ($returnValue == false) {
      $this->renderScript('index/index.tpl');
      return;
    }

    //Render
    $this->_helper->content
            ->setContentName($page)
            ->setEnabled();
  }

}
