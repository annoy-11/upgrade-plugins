<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagenote
 * @package    Sespagenote
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-03-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespagenote_Widget_YouMayAlsoLikeNotesController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->params = $this->view->allParams = $params = Engine_Api::_()->sespage()->getWidgetParams($this->view->identity);

    $show_criterias = $params['show_criteria'];
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;

    $value = array();
    $value['limit'] = $params['limit_data'];
    $value['widgtename'] = 'You May Also Like';
    $value['fetchAll'] = 'true';

    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('pagenotes', 'sespagenote')->getNotesSelect($value);

    if (count($paginator) == 0)
      return $this->setNoRender();
  }

}
