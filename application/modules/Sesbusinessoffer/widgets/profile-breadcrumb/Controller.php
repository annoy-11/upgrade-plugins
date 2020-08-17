<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessoffer
 * @package    Sesbusinessoffer
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbusinessoffer_Widget_ProfileBreadcrumbController extends Engine_Content_Widget_Abstract {

    public function indexAction() {

        $coreApi = Engine_Api::_()->core();
        if (!$coreApi->hasSubject('businessoffer'))
            return $this->setNoRender();

        $this->view->offer = $offer = $coreApi->getSubject('businessoffer');
        $this->view->parentItem = Engine_Api::_()->getItem('businesses', $offer->parent_id);
    }

}
