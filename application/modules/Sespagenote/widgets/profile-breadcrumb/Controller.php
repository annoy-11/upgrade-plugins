<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagenote
 * @package    Sespagenote
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-03-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespagenote_Widget_ProfileBreadcrumbController extends Engine_Content_Widget_Abstract {

    public function indexAction() {

        $coreApi = Engine_Api::_()->core();
        if (!$coreApi->hasSubject('pagenote'))
            return $this->setNoRender();
        $sespagenote_widget = Zend_Registry::isRegistered('sespagenote_widget') ? Zend_Registry::get('sespagenote_widget') : null;
        if(empty($sespagenote_widget))
          return $this->setNoRender();
        $this->view->note = $note = $coreApi->getSubject('pagenote');
        $this->view->parentItem = Engine_Api::_()->getItem('sespage_page', $note->parent_id);
    }

}
