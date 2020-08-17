<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
class Sespage_Widget_PageInfoController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    // Get subject and check auth
    $subject = Engine_Api::_()->core()->getSubject('sespage_page');
    if (!$subject) {
      return $this->setNoRender();
    }
    $locationTable = Engine_Api::_()->getDbTable('locations', 'Sespage');
    $select = $locationTable->select()
            ->where('page_id =?', $subject->page_id)
            ->where('is_default =?', 1);
    $this->view->location = $locationTable->fetchRow($select);
    $params = Engine_Api::_()->sespage()->getWidgetParams($this->view->identity);
    $show_criterias = $params['show_criteria'];
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;
    $this->view->subject = $subject;
    $this->view->pageTags = $subject->tags()->getTagMaps();
  }

}
