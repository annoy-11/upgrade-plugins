<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdocument
 * @package    Sesdocument
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-12-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesdocument_Widget_CreateController extends Engine_Content_Widget_Abstract
{
  public function indexAction(){
  	$this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
->getNavigation('sesdocument_main');
$this->view->max = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdocument.taboptions', 6);
    }
}
