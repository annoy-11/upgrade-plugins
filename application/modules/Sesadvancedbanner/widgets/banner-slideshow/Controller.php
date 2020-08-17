<?php
/**
 * SocialEngineSolutions
 *
 * @category Application_Sesadvancedbanner
 * @package Sesadvancedbanner
 * @copyright Copyright 2018-2019 SocialEngineSolutions
 * @license http://www.socialenginesolutions.com/license/
 * @version $Id: Controller.php 2018-07-26 00:00:00 SocialEngineSolutions $
 * @author SocialEngineSolutions
 */

class Sesadvancedbanner_Widget_BannerSlideshowController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    //1 for ourside and 0 for inside.
    $this->view->inside_outside = $this->_getParam('inside_outside',0);
		$this->view->full_width = $this->_getParam('full_width', 1);
    $this->view->bgimg_move = $this->_getParam('bgimg_move', 1);
    $this->view->height = $this->_getParam('height', '583');
    $this->view->banner_id = $banner_id = $this->_getParam('banner_id', 0);
    $this->view->duration = $duration = $this->_getParam('duration',3000);

    $this->view->button_type = $button_type = $this->_getParam('button_type',0);
    $this->view->slideeffect = $slideeffect = $this->_getParam('slideeffect',1);
    //show navigation
    $this->view->nav = $this->_getParam('nav',0);
    $this->view->scrollbottom = $this->_getParam('scrollbottom',1);
    if (!$banner_id)
      return $this->setNoRender();

    $this->view->paginator = $paginator = Engine_Api::_()->getDbtable('slides', 'sesadvancedbanner')->getWidgetSlides($banner_id,'',true);

    if ($banner_id && count($paginator) > 0) {
        $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
        $settings = Engine_Api::_()->getApi('settings', 'core');
        //Google Font Work
        $string = 'https://fonts.googleapis.com/css?family=';
        $counter = 0;
        foreach ($paginator as $slides) {
        $array[$counter] = $slides->title_font_family;
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

    if (count($paginator) == 0)
      return $this->setNoRender();

	}
}
