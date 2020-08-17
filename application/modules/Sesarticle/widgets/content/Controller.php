<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesarticle
 * @package    Sesarticle
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesarticle_Widget_ContentController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('article_id', null);
    $article_id = Engine_Api::_()->getDbtable('sesarticles', 'sesarticle')->getArticleId($id);
    if(!Engine_Api::_()->core()->hasSubject())
    $this->view->body = Engine_Api::_()->getItem('sesarticle', $article_id)->body;
    else
    $this->view->body = Engine_Api::_()->core()->getSubject()->body;
  }
  
}
