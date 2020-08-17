<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbusiness_Widget_BusinessInfoController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    // Get subject and check auth
    $subject = Engine_Api::_()->core()->getSubject('businesses');
    if (!$subject) {
      return $this->setNoRender();
    }
    $locationTable = Engine_Api::_()->getDbTable('locations', 'Sesbusiness');
    $select = $locationTable->select()
            ->where('business_id =?', $subject->business_id)
            ->where('is_default =?', 1);
    $this->view->location = $locationTable->fetchRow($select);
    $params = Engine_Api::_()->sesbusiness()->getWidgetParams($this->view->identity);
    $show_criterias = $params['show_criteria'];
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;
    $this->view->subject = $subject;
    $this->view->businessTags = $subject->tags()->getTagMaps();
  }

}
