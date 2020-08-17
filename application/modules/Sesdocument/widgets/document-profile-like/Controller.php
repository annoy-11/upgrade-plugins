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
class Sesdocument_Widget_DocumentProfileLikeController extends Engine_Content_Widget_Abstract {

    public function indexAction() {

        $viewer = Engine_Api::_()->user()->getViewer();
        $this->view->viewer_id = $viewerId = $viewer->getIdentity();
        if (empty($viewerId))
            return $this->setNoRender();
        if (!Engine_Api::_()->core()->hasSubject('sesdocument'))
            return $this->setNoRender();
        $this->view->subject = $articleItem = Engine_Api::_()->core()->getSubject('sesdocument');
        $this->view->document_id = $articleItem->getIdentity();
        $this->view->is_like = Engine_Api::_()->getDbTable('likes', 'core')->isLike($articleItem, $viewer);
    }

}
