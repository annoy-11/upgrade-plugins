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

class Sescrowdfunding_Widget_CrowdfundingOverviewController extends Engine_Content_Widget_Abstract {

    public function indexAction() {

        // Don't render this if not authorized
        $viewer = Engine_Api::_()->user()->getViewer();
        if (!Engine_Api::_()->core()->hasSubject()) {
            return $this->setNoRender();
        }

        $subject = $this->view->subject = Engine_Api::_()->core()->getSubject();

        $this->view->editOverview = $editOverview = $subject->authorization()->isAllowed($viewer, 'edit');
        if (!$editOverview && (!$subject->overview || is_null($subject->overview))) {
            return $this->setNoRender();
        }
    }
}
