<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesytube
 * @package    Sesytube
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-02-01 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesytube_Widget_TextBlockController extends Engine_Content_Widget_Abstract {

    public function indexAction() {

        $settings = Engine_Api::_()->getApi('settings', 'core');

        $this->view->htmlheading = $settings->getSetting('sesytube.htmlheading', '');
        $this->view->htmldescription = $settings->getSetting('sesytube.htmldescription', '');

        $this->view->htmlblock1title = $settings->getSetting('sesytube.htmlblock1title', '');
        $this->view->htmlblock1description = $settings->getSetting('sesytube.htmlblock1description', '');

        $this->view->htmlblock2title = $settings->getSetting('sesytube.htmlblock2title', '');
        $this->view->htmlblock2description = $settings->getSetting('sesytube.htmlblock2description', '');

        $this->view->htmlblock3title = $settings->getSetting('sesytube.htmlblock3title', '');
        $this->view->htmlblock3description = $settings->getSetting('sesytube.htmlblock3description', '');

    }
}
