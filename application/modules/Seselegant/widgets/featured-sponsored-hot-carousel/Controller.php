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

class Seselegant_Widget_FeaturedSponsoredHotCarouselController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $settings = Engine_Api::_()->getApi('settings', 'core');

    $this->view->contentType = $contentType = $this->_getParam('contentType', 'albums');
    $this->view->viewType = $this->_getParam('viewType', 'horizontal');
    $this->view->height = $this->_getParam('height', '200');
    $this->view->width = $this->_getParam('width', '180');
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer->getIdentity();
    $settings = Engine_Api::_()->getApi('settings', 'core');

    //Album Settings
    $this->view->albumlink = unserialize($settings->getSetting('sesmusic.albumlink'));

    $params = array();
    $params['popularity'] = $this->_getParam('popularity', 'creation_date');
    $params['displayContentType'] = $this->_getParam('displayContentType', 'featured');
    $params['limit'] = $this->_getParam('limit', 10);

    if (!$settings->getSetting('sesmusic.checkmusic'))
      return $this->setNoRender();

    $this->view->information = $this->_getParam('information', array('featured', 'sponsored', 'hot', 'likeCount', 'commentCount', 'viewCount', 'songsCount', 'title', 'postedby', 'ratingCount'));

    $params['column'] = array('album_id', 'title', 'description', 'photo_id', 'owner_id', 'view_count', 'like_count', 'comment_count', 'song_count', 'featured', 'hot', 'sponsored', 'rating', 'special');

    $this->view->results = $results = Engine_Api::_()->getDbtable('albums', 'sesmusic')->widgetResults($params);

    if (count($results) <= 0)
      return $this->setNoRender();
  }

}