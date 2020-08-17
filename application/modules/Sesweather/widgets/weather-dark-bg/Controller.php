<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesweather
 * @package    Sesweather
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-08-24 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesweather_Widget_WeatherDarkBgController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $viewer = $this->view->viewer();
    if (!Engine_Api::_()->authorization()->isAllowed('sesweatherview', $viewer, 'view'))
      return $this->setNoRender();
    $this->view->form = $form = new Sesweather_Form_Location(array('widgetId' => $this->view->identity));
    $this->view->widgetName = 'weather-Dark-bg';
    $this->view->bgPhoto = $this->_getParam('sesweather_bgphoto',false);
    $this->view->template = $this->_getParam('sesweather_temdesign',1);
    $this->view->is_ajax = $isAjax = $this->_getParam('is_ajax', false);
    $this->view->timezone = $this->_getParam('timezone', false);
    $this->view->canSearchLocation = $canSearchLoation = $this->_getParam('sesweather_location_search', 0);
    $this->view->sesweather_isintegrate = $CanIntegrateMemerLocation = $this->_getParam('sesweather_isintegrate', 0);
    $viewerId = $viewer->getIdentity();
    $this->view->identity = $this->_getParam('widgetId', $this->view->identity);
    $cookiedata = Engine_Api::_()->sesbasic()->getUserLocationBasedCookieData();
    if (!$this->_getParam('weatherlat', false)) {
      $adminlatitude = $this->_getParam('lat', 0);
      $adminlongitude = $this->_getParam('lng', 0);
      $adminLocation = $this->_getParam('location', 0);
      if ($viewerId) {
        if (!$CanIntegrateMemerLocation) {
          $lat = $cookiedata['lat'] ? $cookiedata['lat'] : $adminlatitude;
          $lng = $cookiedata['lng'] ? $cookiedata['lng'] : $adminlongitude;
          $location = $cookiedata['location'] ? $cookiedata['location'] : $adminLocation;
        } else {
          $latLng = Engine_Api::_()->getDbtable('locations', 'sesbasic')->getLocationData('user', $viewerId);
          $lat = $latLng->lat ? $latLng->lat : ($cookiedata['lat'] ? $cookiedata['lat'] : $adminlatitude);
          $lng = $latLng->lng ? $latLng->lng : ($cookiedata['lng'] ? $cookiedata['lng'] : $adminlongitude);
          $location = (isset($viewer->location) && $viewer->location) ? $viewer->location : ($cookiedata['location'] ? $cookiedata['location'] : $adminLocation);
        }
      } else {
        $lat = $cookiedata['lat'] ? $cookiedata['lat'] : $adminlatitude;
        $lng = $cookiedata['lng'] ? $cookiedata['lng'] : $adminlongitude;
        $location = $cookiedata['location'] ? $cookiedata['location'] : $adminLocation;
      }
      $form->location->setValue($location);
    } else {
      $lat = $this->_getParam('weatherlat', false);
      $lng = $this->_getParam('weatherlng', false);
    }
    $this->view->lat = $lat;
    $this->view->lng = $lng;
    if (!$isAjax)
      return;
    try {
      $this->view->result = $result = Engine_Api::_()->sesweather()->getApi()->getForecast($lat, $lng);
    } catch (DarkskyException $e) {
      // handle the exception
    } catch (Exception $e) {
      // handle the exception
    }
  }

}
