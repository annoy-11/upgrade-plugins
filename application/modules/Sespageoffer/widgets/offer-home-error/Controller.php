<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespageoffer
 * @package    Sespageoffer
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespageoffer_Widget_OfferHomeErrorController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('pageoffers', 'sespageoffer')->getOffersPaginator();
    if ($paginator->getTotalItemCount() == 0)
      return $this->setNoRender();
  }
}
