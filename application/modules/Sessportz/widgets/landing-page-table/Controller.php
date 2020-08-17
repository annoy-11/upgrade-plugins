<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessportz
 * @package    Sessportz
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-04-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Sessportz_Widget_LandingPageTableController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->results = $results = Engine_Api::_()->getDbtable('teams', 'sessportz')->getTeamMemers(array('widgettype' => 'widget'));
    if(count($results) == 0)
        return $this->setNoRender();

  }
}
