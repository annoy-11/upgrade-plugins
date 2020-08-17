<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescrowdfunding_Widget_ProfilePhotosSlideshowController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $subject = Engine_Api::_()->core()->getSubject();
    if(empty($subject))
      return $this->setNoRender();

    $this->view->storage = Engine_Api::_()->storage();
    $table = Engine_Api::_()->getDbTable('photos', 'sescrowdfunding');
    $select = $table->select()->where('crowdfunding_id =?', $subject->getIdentity())->order('photo_id DESC');

    $this->view->paginator = $paginator = $table->fetchAll($select);
    if (count($paginator) == 0)
      return $this->setNoRender();
  }

}
