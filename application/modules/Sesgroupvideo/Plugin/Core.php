<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroupvideo
 * @package    Sesgroupvideo
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2018-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesgroupvideo_Plugin_Core {
  public function onStatistics($event) {
    $table = Engine_Api::_()->getDbTable('videos', 'sesgroupvideo');
    $select = new Zend_Db_Select($table->getAdapter());
    $select->from($table->info('name'), 'COUNT(*) AS count');
    $event->addResponse($select->query()->fetchColumn(0), 'groupvideo');
  }
	public function onRenderLayoutDefaultSimple($event) {
    return $this->onRenderLayoutDefault($event,'simple');
  }
  public function onRenderLayoutDefault($event,$mode=null) {
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
		$view->headTranslate(array(
		'Quick share successfully', 'Video removed successfully from watch later', 'Video successfully added to watch later', 'Video added as Favourite successfully', 'Video Unfavourited successfully', 'Video Liked successfully', 'Video Unliked successfully', 'Video Rated successfully'));
    $request = Zend_Controller_Front::getInstance()->getRequest();
    $moduleName = $request->getModuleName();
		$actionName = $request->getActionName();
		$controllerName = $request->getControllerName();
		$viewer = Engine_Api::_()->user()->getViewer();

    if ($viewer->getIdentity() == 0)
      $level = Engine_Api::_()->getDbtable('levels', 'authorization')->getPublicLevel()->level_id;
    else
      $level = $viewer;
		$headScript = new Zend_View_Helper_HeadScript();
     $type = Engine_Api::_()->authorization()->getPermission($level, 'sesbasic_video', 'videoviewer');

   if ($type == 1) {
      $headScript->appendFile(Zend_Registry::get('StaticBaseUrl')
                      . 'application/modules/Sesbasic/externals/scripts/SesLightbox/photoswipe.min.js')
              ->appendFile(Zend_Registry::get('StaticBaseUrl')
                      . 'application/modules/Sesbasic/externals/scripts/SesLightbox/photoswipe-ui-default.min.js')
              ->appendFile(Zend_Registry::get('StaticBaseUrl')
                      . 'application/modules/Sesbasic/externals/scripts/videolightbox/sesvideoimagevieweradvance.js');
      $view->headLink()->appendStylesheet($view->layout()->staticBaseUrl
              . 'application/modules/Sesbasic/externals/styles/photoswipe.css');
    } else {
      $loadImageViewerFile = Zend_Registry::get('StaticBaseUrl') . 'application/modules/Sesbasic/externals/scripts/videolightbox/sesvideoimageviewerbasic.js';
      $headScript->appendFile($loadImageViewerFile);
      $view->headLink()->appendStylesheet($view->layout()->staticBaseUrl
              . 'application/modules/Sesbasic/externals/styles/medialightbox.css');
    }
    $script = '';

        $script .= <<<EOF
  //Cookie get and set function
  function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toGMTString();
    document.cookie = cname + "=" + cvalue + "; " + expires+"; path=/";
  }

  function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) != -1) return c.substring(name.length,c.length);
    }
    return "";
  }
EOF;
    $script .=
						"var videoURLsesgroupvideo = '" . Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroupvideo.video.manifest', 'groupvideo') . "';
						var showAddnewVideoIconShortCut = ".Engine_Api::_()->getApi('settings', 'core')->getSetting('sesvideo.enable.addphotoshortcut',1).";
						";
		
    $view->headScript()->appendScript($script);
  }

  public function onUserDeleteBefore($event) {
    $payload = $event->getPayload();
    if ($payload instanceof User_Model_User) {
      // Delete videos
      $videoTable = Engine_Api::_()->getDbtable('videos', 'sesgroupvideo');
      $videoSelect = $videoTable->select()->where('owner_id = ?', $payload->getIdentity());
      foreach ($videoTable->fetchAll($videoSelect) as $video) {
        Engine_Api::_()->getApi('core', 'sesgroupvideo')->deleteVideo($video);
      }
    }
  }

}
