<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Estore_Widget_StoreInfoController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    // Get subject and check auth
    $subject = Engine_Api::_()->core()->getSubject('stores');
    if (!$subject) {
      return $this->setNoRender();
    }
    $locationTable = Engine_Api::_()->getDbTable('locations', 'Estore');
    $select = $locationTable->select()
            ->where('store_id =?', $subject->store_id)
            ->where('is_default =?', 1);
    $this->view->location = $locationTable->fetchRow($select);
    $params = Engine_Api::_()->estore()->getWidgetParams($this->view->identity);
    $show_criterias = $params['show_criteria'];
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;
    $this->view->subject = $subject;
    $this->view->storeTags = $subject->tags()->getTagMaps();
  }

}
