<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescrowdfunding_Widget_ManageCrowdfundingsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $values['user_id'] = $viewer->getIdentity();
    $values['manage-widget'] = 1;
    $this->view->paginator = $paginator = Engine_Api::_()->getItemTable('crowdfunding')->getSescrowdfundingsPaginator($values);
    $paginator->setItemCountPerPage(15);
    $this->view->paginator = $paginator->setCurrentPageNumber(10);

  }
}
