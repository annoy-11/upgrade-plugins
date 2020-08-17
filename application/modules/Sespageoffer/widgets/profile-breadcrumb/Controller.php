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

class Sespageoffer_Widget_ProfileBreadcrumbController extends Engine_Content_Widget_Abstract {

    public function indexAction() {

        $coreApi = Engine_Api::_()->core();
        if (!$coreApi->hasSubject('pageoffer'))
            return $this->setNoRender();

        $this->view->offer = $offer = $coreApi->getSubject('pageoffer');
        $this->view->parentItem = Engine_Api::_()->getItem('sespage_page', $offer->parent_id);
    }

}
