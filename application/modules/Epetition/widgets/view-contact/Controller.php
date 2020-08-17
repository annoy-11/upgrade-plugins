<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Controller.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Epetition_Widget_ViewContactController extends Engine_Content_Widget_Abstract
{
  protected $_childCount;

  public function indexAction()
  {
    $epetition_id = Engine_Api::_()->getDbtable('epetitions', 'epetition')->getPetitionId(Zend_Controller_Front::getInstance()->getRequest()->getParam('epetition_id', null));
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->epetition=$epetition=Engine_Api::_()->getItem('epetition', $epetition_id);
    if(empty($epetition['petition_contact_name']) && empty($epetition['petition_contact_email']) && empty($epetition['petition_contact_phone']) && empty($epetition['petition_contact_facebook']) && empty($epetition['petition_contact_linkedin']) && empty($epetition['petition_contact_twitter']) && empty($epetition['petition_contact_website']))
    {
     if($viewer->getIdentity()==$epetition['owner_id'])
     {
       echo "Click here to enter your contact details.<a href='".Zend_Registry::get('StaticBaseUrl')."/petitions/dashboard/contact-information/".$epetition['custom_url']."'>click here</a>";
       return;
     }
      return $this->setNoRender();
    }
    $this->view->allParams = $this->_getAllParams();
  }

}
