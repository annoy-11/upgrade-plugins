<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessocialshare
 * @package    Sessocialshare
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2017-07-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sessocialshare_Widget_SidebarSocialShareController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
  
    $subject = '';
    if(Engine_Api::_()->core()->hasSubject() ) {
      $this->view->subject = $subject = Engine_Api::_()->core()->getSubject();
    }
    
    $this->view->sessocialshareApi = Engine_Api::_()->sessocialshare();
    
    $this->view->showtotalshare = $this->_getParam('showtotalshare', 1);
		$this->view->margintype = $this->_getParam('margintype','per');	  
		$this->view->margin = $this->_getParam('margin','3');	
		
		$this->view->radius = $this->_getParam('radius','5');
		$this->view->showsharedefault = $this->_getParam('showsharedefault', 0);
		
		$this->view->showCountnumber = $this->_getParam('showCountnumber', 100);
		
    $this->view->position = $this->_getParam('position', 1);
    $this->view->socialshare_enable_plusicon = $this->_getParam('socialshare_enable_plusicon', 1);
    $this->view->socialshare_icon_limit = $this->_getParam('socialshare_icon_limit', 4);
    $this->view->showCount = $this->_getParam('showCount', 1);
    $this->view->showTitleTip = $this->_getParam('showTitleTip', 1);
    
    $URL = ((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    
    $linksavesTable = Engine_Api::_()->getDbTable('linksaves', 'sessocialshare');
    $values = array();
    $this->view->facebook = $facebook =  $linksavesTable->socialShareCounter(array('pageurl' => $URL, 'title' => 'facebook', 'from_date' => @$values['from_date'], 'to_date' => @$values['to_date']));
    $sessocialshare_widget = Zend_Registry::isRegistered('sessocialshare_widget') ? Zend_Registry::get('sessocialshare_widget') : null;
    if(empty($sessocialshare_widget)) {
      return $this->setNoRender();
    }
    $this->view->twitter = $twitter =  $linksavesTable->socialShareCounter(array('pageurl' => $URL, 'title' => 'twitter'));
    
    $this->view->pinterest = $pinterest =  $linksavesTable->socialShareCounter(array('pageurl' => $URL, 'title' => 'pinterest'));
    
    $this->view->googleplus = $googleplus =  $linksavesTable->socialShareCounter(array('pageurl' => $URL, 'title' => 'googleplus'));
    
    $this->view->linkedin = $linkedin =  $linksavesTable->socialShareCounter(array('pageurl' => $URL, 'title' => 'linkedin'));
    
    $this->view->gmail = $gmail =  $linksavesTable->socialShareCounter(array('pageurl' => $URL, 'title' => 'gmail'));
    
    $this->view->tumblr = $tumblr =  $linksavesTable->socialShareCounter(array('pageurl' => $URL, 'title' => 'tumblr'));
    
    $this->view->digg = $digg =  $linksavesTable->socialShareCounter(array('pageurl' => $URL, 'title' => 'digg'));
    
    $this->view->stumbleupon = $stumbleupon =  $linksavesTable->socialShareCounter(array('pageurl' => $URL, 'title' => 'stumbleupon'));
    
    $this->view->myspace = $myspace =  $linksavesTable->socialShareCounter(array('pageurl' => $URL, 'title' => 'myspace'));
    
    $this->view->facebookmessager = $facebookmessager =  $linksavesTable->socialShareCounter(array('pageurl' => $URL, 'title' => 'facebookmessager'));
    
    $this->view->rediff =  $rediff =  $linksavesTable->socialShareCounter(array('pageurl' => $URL, 'title' => 'rediff'));
    
    $this->view->googlebookmark = $googlebookmark =  $linksavesTable->socialShareCounter(array('pageurl' => $URL, 'title' => 'googlebookmark'));
    
    $this->view->flipboard = $flipboard =  $linksavesTable->socialShareCounter(array('pageurl' => $URL, 'title' => 'flipboard'));
    
    $this->view->skype = $skype =  $linksavesTable->socialShareCounter(array('pageurl' => $URL, 'title' => 'skype'));
    
    $this->view->whatsapp = $whatsapp =  $linksavesTable->socialShareCounter(array('pageurl' => $URL, 'title' => 'whatsapp'));
    
    $this->view->email = $email =  $linksavesTable->socialShareCounter(array('pageurl' => $URL, 'title' => 'email'));
    
    $this->view->vk = $vk =  $linksavesTable->socialShareCounter(array('pageurl' => $URL, 'title' => 'vk'));
    
    $this->view->yahoo = $yahoo =  $linksavesTable->socialShareCounter(array('pageurl' => $URL, 'title' => 'yahoo'));
    
    $this->view->totalCount = $facebook + $twitter + $pinterest + $googleplus + $linkedin + $gmail + $tumblr + $digg + $stumbleupon + $myspace + $facebookmessager + $rediff + $googlebookmark + $flipboard + $skype + $whatsapp + $email + $vk + $yahoo;
  }
}