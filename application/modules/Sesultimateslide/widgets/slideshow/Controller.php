<?php

/**
 * SocialEngineSolutions
 *
 * @category Application_Sesultimateslide
 * @package Sesultimateslide
 * @copyright Copyright 2018-2019 SocialEngineSolutions
 * @license http://www.socialenginesolutions.com/license/
 * @version $Id: Controller.php 2018-07-05 00:00:00 SocialEngineSolutions $
 * @author SocialEngineSolutions
 */
class Sesultimateslide_Widget_SlideshowController extends Engine_Content_Widget_Abstract {

    public function indexAction(){
      $this->view->identity = $galleryId = $this->_getParam('gallery_id', '0');
      // slide wrapper height
      $this->view->sesslider_wrapper_height = $sesslider_wrapper_height = $this->_getParam('banner_height', '200');
      // slide navigation
      $this->view->enable_navigation = $sesslider_wrapper_height = $this->_getParam('enable_navigation', 0);
      // slide transition time
      $this->view->transition_delay = $transition_delay = $this->_getParam('transition_delay', '5000');
      // header inside/out
      $this->view->header_insight_out = $header_insight_out = $this->_getParam('header_insight_out', null);
      // slide order
      $sesultimateslide_widgets = Zend_Registry::isRegistered('sesultimateslide_widgets') ? Zend_Registry::get('sesultimateslide_widgets') : null;
      if(empty($sesultimateslide_widgets))
        return $this->setNoRender();
      $this->view->max =  $this->_getParam('max_menus', 6);
      $sildeOrder = $this->_getParam('slide_order', null);
      $this->view->logo = $this->_getParam('logo', 1);
      $this->view->logo_url = $this->_getParam('logo_url', false);
      $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
      // slide count shows
      $countnumberShows = $this->_getParam('count_number_shows', null);
      $sesultimateslide_widgets = Zend_Registry::isRegistered('sesultimateslide_widgets') ? Zend_Registry::get('sesultimateslide_widgets') : null;
      if (empty($sesultimateslide_widgets)) {
        return $this->setNoRender();
      }
      $showMainmenu = Engine_Api::_()->getApi('settings', 'core')->getSetting('seshtmlbackground.showmenu.nologin', 1);
      $viewer_id = $viewer->getIdentity();
      if($viewer_id == 0) {
        if($showMainmenu == 0)
          $this->view->show_menu = 0;
        else
          $this->view->show_menu = 1;
      }
      else
        $this->view->show_menu = 1;
      $this->view->main_navigation = $main_navigation = $this->_getParam('main_navigation', 0);
      $this->view->mini_navigation = $mini_navigation = $this->_getParam('mini_navigation', 0);
      if ($main_navigation) {
        //main menu widget
        $this->view->navigation = $navigation = Engine_Api::_()
          ->getApi('menus', 'core')
          ->getNavigation('core_main');
        $require_check = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.general.browse', 1);
        if (!$require_check && !$viewer->getIdentity()) {
          $navigation->removePage($navigation->findOneBy('route', 'user_general'));
        }
      }
      $this->view->moduleEnable = "sesspectromedia";
      $this->view->sesspectromedia = $sesspectromedia = Engine_Api::_()->getApi('core', 'sesbasic')->isModuleEnable(array('sesspectromedia'));
      if(!$sesspectromedia){
        $this->view->moduleEnable = "sesariana";
        $this->view->sesspectromedia = $sesspectromedia = Engine_Api::_()->getApi('core', 'sesbasic')->isModuleEnable(array('sesariana'));
        if(!$sesspectromedia){
          $this->view->moduleEnable = "sesexpose";
          $this->view->sesspectromedia = $sesspectromedia = Engine_Api::_()->getApi('core', 'sesbasic')->isModuleEnable(array('sesexpose'));
        }
      }
      if(!$sesspectromedia){
        $this->view->menumininavigation = $menumininavigation = Engine_Api::_()
          ->getApi('menus', 'core')
          ->getNavigation('core_mini');
        if( $viewer->getIdentity() )
        {
          $this->view->notificationCount = Engine_Api::_()->getDbtable('notifications', 'activity')->hasNotifications($viewer);
        }
        $request = Zend_Controller_Front::getInstance()->getRequest();
        $this->view->notificationOnly = $request->getParam('notificationOnly', false);
        $this->view->updateSettings = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.general.notificationupdate');
      }

      // slide banner width
      $this->view->banner_full_width = $banner_full_width = $this->_getParam('banner_full_width', null);
      if (!$galleryId)
        return $this->setNoRender();
      $gallery = Engine_Api::_()->getItem('sesultimateslide_gallery', $galleryId);
      if (!$gallery)
        return $this->setNoRender();
      if ($sildeOrder)
        $params['order'] = 'admin';
      else
        $params['order'] = 'random';
      if ($countnumberShows)
        $params['limit'] = $countnumberShows;
      $params['gallery_id'] = $gallery->gallery_id;
      $this->view->paginator = $paginator = $itemTable = Engine_Api::_()->getDbtable('slides', 'sesultimateslide')->getDbslidePaginator($params);
      if ($galleryId && count($paginator)>0) {
        $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
        $view->headScript()->appendFile(Zend_Registry::get('StaticBaseUrl') . 'application/modules/Sesbasic/externals/scripts/jquery.min.js');
        $settings = Engine_Api::_()->getApi('settings', 'core');
        //Google Font Work
        $string = 'https://fonts.googleapis.com/css?family=';
        $counter = 0;
        foreach ($paginator as $slides) {
          $array[$counter] = $slides->fixed_caption_font_family;
          $counter++;
          $array[$counter] = $slides->floating_caption_font_family;
          $counter++;
          $array[$counter] = $slides->description_font_family;
          $counter++;
        }
        for ($i = 0; $i < count($array); $i++) {
          $mainmenuFontFamily = str_replace('"', '', $array[$i]);
          if($i>0)
          $string .='|'. $mainmenuFontFamily;
          else
            $string .= $mainmenuFontFamily;
        }
        $view->headLink()->appendStylesheet($string);
      }
      // no slide then return
      if (!count($paginator))
        return $this->setNoRender();
    }
}
