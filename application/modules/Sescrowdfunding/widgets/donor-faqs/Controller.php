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

class Sescrowdfunding_Widget_donorFaqsController extends Engine_Content_Widget_Abstract {

    public function indexAction() {
        $this->getElement()->removeDecorator('Title');
        $this->view->donerstitle = Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfunding.donerstitle', 'FAQs for Donors');
        $this->view->donersbody = Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfunding.donersbody', '');
    }
}
