<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Edocument
 * @package    Edocument
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2015-10-11 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Edocument_Widget_PeopleLikeItemController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    if (!Engine_Api::_()->core()->hasSubject('edocument'))
      return $this->setNoRender();

    if(Engine_Api::_()->core()->hasSubject('edocument'))
      $this->view->subject = $subject = Engine_Api::_()->core()->getSubject('edocument');

    $param['id'] = $subject->getIdentity();
    $param['type'] = $subject->getType();
    $this->view->height = $this->_getParam('height', '48');
    $this->view->width = $this->_getParam('width', '48');
    $this->view->title = $this->getElement()->getTitle();
    $this->view->data_show = $limit_data = $this->_getParam('limit_data','11');

    $this->view->paginator = $paginator = Engine_Api::_()->edocument()->likeItemCore($param);
    $paginator->setItemCountPerPage($limit_data);
    $paginator->setCurrentPageNumber(1);

    if($this->_getParam('removeDecorator'))
        $this->getElement()->removeDecorator('Container');

    if( $paginator->getTotalItemCount() <= 0 ) {
      return $this->setNoRender();
    }
  }
}
