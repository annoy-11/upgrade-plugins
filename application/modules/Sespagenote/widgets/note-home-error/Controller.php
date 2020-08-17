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
class Sespagenote_Widget_NoteHomeErrorController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('pagenotes', 'sespagenote')->getNotesPaginator();
    if ($paginator->getTotalItemCount() == 0)
      return $this->setNoRender();
  }
}
