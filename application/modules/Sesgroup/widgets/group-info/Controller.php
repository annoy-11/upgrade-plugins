<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
class Sesgroup_Widget_GroupInfoController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    // Get subject and check auth
    $subject = Engine_Api::_()->core()->getSubject('sesgroup_group');
    if (!$subject) {
      return $this->setNoRender();
    }
    $locationTable = Engine_Api::_()->getDbTable('locations', 'Sesgroup');
    $select = $locationTable->select()
            ->where('group_id =?', $subject->group_id)
            ->where('is_default =?', 1);
    $this->view->location = $locationTable->fetchRow($select);
    $params = Engine_Api::_()->sesgroup()->getWidgetParams($this->view->identity);
    $show_criterias = $params['show_criteria'];
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;
    $this->view->subject = $subject;
    $this->view->groupTags = $subject->tags()->getTagMaps();
  }

}
