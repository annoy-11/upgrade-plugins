<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvpoll
 * @package    Sesadvpoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Menus.php  2018-12-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesadvpoll_Plugin_Menus {

    public function canCreatePolls() {

        //Must be logged in
        $viewer = Engine_Api::_()->user()->getViewer();
        if( !$viewer || !$viewer->getIdentity() ) {
            return false;
        }

        //Must be able to create polls
        if( !Engine_Api::_()->authorization()->isAllowed('sesadvpoll_poll', $viewer, 'create') ) {
            return false;
        }

        return true;
    }

    public function canViewPolls() {

        $viewer = Engine_Api::_()->user()->getViewer();

        //Must be able to view polls
        if( !Engine_Api::_()->authorization()->isAllowed('sesadvpoll_poll', $viewer, 'view') ) {
            return false;
        }
        return true;
    }
}
