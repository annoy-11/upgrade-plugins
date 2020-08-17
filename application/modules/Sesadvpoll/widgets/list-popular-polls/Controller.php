<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvpoll
 * @package    Sesadvpoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-12-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesadvpoll_Widget_ListPopularPollsController extends Engine_Content_Widget_Abstract {

    public function indexAction() {

        $params = $this->_getAllParams();

        $this->view->title_truncation = $params['title_truncation'] ? $params['title_truncation'] : 20;
        $this->view->description_truncation = @$params['description_truncation']?@$params['description_truncation']:45;
        $this->view->show_criteria = $params['show_criteria']?$params['show_criteria']:$this->_getParam('show_criteria',array('like','in', 'comment','vote','by','favourite','title','description', 'favouriteButton', 'likeButton', 'socialSharing', 'view'));

        $values['order'] = $params['popular_type'];

        $paginator = Engine_Api::_()->getDbTable('polls', 'sesadvpoll')->getPollsPaginator($values);
        $this->view->paginator = $paginator;

        $paginator->setItemCountPerPage($params['limit_data']?$params['limit_data']:$this->_getParam('limit',3));
        $paginator->setCurrentPageNumber($this->_getParam('limit',1));

        if( $paginator->getTotalItemCount() <= 0)
            return $this->setNoRender();
    }
}
