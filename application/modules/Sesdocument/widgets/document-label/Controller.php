<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesevent
 * @package    Sesevent
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-07-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesdocument_Widget_DocumentLabelController extends Engine_Content_Widget_Abstract {

    public function indexAction() {

        if(!Engine_Api::_()->core()->hasSubject('sesdocument'))
            return $this->setNoRender();

        $this->view->subject = $subject = Engine_Api::_()->core()->getSubject('sesdocument');
        if(!$subject->sponsored && !$subject->featured && !$subject->verified){
            return $this->setNoRender();
        }
        $this->view->option = $options = $this->_getParam('option',array('verified','sponsored','featured'));
        if(empty($options))
            return $this->setNoRender();
    }
}
