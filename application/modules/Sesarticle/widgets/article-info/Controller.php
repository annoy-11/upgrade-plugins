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

class Sesarticle_Widget_ArticleInfoController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
  
    // Don't render this if not authorized
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!Engine_Api::_()->core()->hasSubject())
      return $this->setNoRender();
    
    $subject = $this->view->subject = Engine_Api::_()->core()->getSubject();
		$customMetaFields = $this->view->customMetaFields = Engine_Api::_()->sesarticle()->getCustomFieldMapDataArticle($subject);
    if (!count($customMetaFields)) {
      return $this->setNoRender();
    }
  }
}