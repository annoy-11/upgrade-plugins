<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Booking
 * @package    Booking
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-03-19 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Booking_Widget_ProfileServicesController extends Engine_Content_Widget_Abstract
{
  public function indexAction()
  {
    //$this->view->form = $form = new Booking_Form_Servicesearch();
//    print_r($this->_getAllParams());
    $var= $this->_getParam("show_criteria");
    $this->view->serviceimage=(!empty(in_array("serviceimage",$var))?1:0);
    $this->view->servicename=(!empty(in_array("servicename",$var))?1:0);
    $this->view->price=(!empty(in_array("price",$var))?1:0);
    $this->view->minute=(!empty(in_array("minute",$var))?1:0);
    $this->view->bookbutton=(!empty(in_array("bookbutton",$var))?1:0);
    $booking_widget = Zend_Registry::isRegistered('booking_widget') ? Zend_Registry::get('booking_widget') : null;
    if(empty($booking_widget))
      return $this->setNoRender();
    $this->view->like=(!empty(in_array("like",$var))?1:0);
    $this->view->favourite=(!empty(in_array("favourite",$var))?1:0);
    $this->view->likecount=(!empty(in_array("likecount",$var))?1:0);
    $this->view->favouritecount=(!empty(in_array("favouritecount",$var))?1:0);
    $this->view->servicenamelimit=$this->_getParam("title_truncation");
    $this->view->width=$this->_getParam("width");
    $this->view->height=$this->_getParam("height");
    $professionalId=Zend_Controller_Front::getInstance()->getRequest()->getParam("professional_id");
    $userSelected = Engine_Api::_()->getItem('professional',$professionalId);
    $this->view->ifNoProfessioanl = $userSelected ;
    if($userSelected)
        $table = Engine_Api::_()->getDbTable('services', 'booking')->getMainServices(array("viewerId"=>$userSelected->user_id));
    $this->view->paginator = $paginator = $table;
//    $isService=$this->_getParam("isService",0);
//    if(!empty($isService)){
//        $serviceSQLData=array();
//        $serviceSQLData["isService"]=$isService;
//        $serviceName=$this->_getParam("servicename",0);
//        $serviceProfessional=$this->_getParam("professional",0);
//        $price=$this->_getParam("price",0);
//
//        if(!empty($serviceName))
//            $serviceSQLData["servicename"]=$serviceName;
//        if(!empty($price))
//            $serviceSQLData["price"]=$price;
//        
//        $serviceData=array();
//        $getAllServices=Engine_Api::_()->getDbTable('services', 'booking')->getMainServices($serviceSQLData);
//        foreach ($getAllServices as $val){
//           $serviceData[]=array(
//               "name"=>$val->name,
//               "price"=>Engine_Api::_()->booking()->getCurrencyPrice($val->price),
//               "time"=>$val->duration." ".(($val->timelimit=="h")?"Hour.":"Minutes."),
//               "fileid"=>Engine_Api::_()->storage()->get($val->file_id, '')->getPhotoUrl(),
//            );
//        }
////        echo json_encode(array("size"=>"1"));
//        echo json_encode($serviceData);
//        die;
//    }
  }
}
