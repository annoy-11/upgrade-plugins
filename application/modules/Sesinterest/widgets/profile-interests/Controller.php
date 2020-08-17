<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesinterest
 * @package    Sesinterest
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-03-11 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesinterest_Widget_ProfileInterestsController extends Engine_Content_Widget_Abstract {

    public function indexAction() {

        $subject = Engine_Api::_()->core()->getSubject();
        $subject_id = $subject->getIdentity();
        if(empty($subject_id))
            return $this->setNoRender();

        $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('userinterests', 'sesinterest')->getUserInterests(array('user_id' => $subject_id));

        if(count($paginator) == 0 )
            return $this->setNoRender();
    }
}
