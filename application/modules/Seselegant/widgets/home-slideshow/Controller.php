<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Seselegant
 * @package    Seselegant
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-04-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seselegant_Widget_HomeSlideshowController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->storage = Engine_Api::_()->storage();
    $table = Engine_Api::_()->getDbTable('slideimages', 'seselegant');
    $select = $table->select()->order('order');
    $this->view->paginator = $paginator = $table->fetchAll($select);
    if (count($paginator) <= 0)
      return $this->setNoRender();

    $this->view->countPage = count($paginator);
  }

}