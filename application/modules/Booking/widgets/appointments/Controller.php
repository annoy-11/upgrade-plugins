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
class Booking_Widget_AppointmentsController extends Engine_Content_Widget_Abstract
{
    public function indexAction()
    {
        $viewer = Engine_Api::_()->user()->getViewer();
        $this->view->is_ajax=$is_ajax=(isset($_POST["is_ajax"]) ? 1 : 0);
        $type['type']='0';
        if($is_ajax)
            $this->view->appointmentType=$appointmentType=$this->_getParam("appointmentType");
        if($appointmentType)
            if($appointmentType=="cancelled" || $appointmentType=="completed" || $appointmentType=="reject")
                $type['type']=$appointmentType;
        $this->view->tab_option = $this->_getParam('tabOption','advance');
        $defaultOptionsArray = $this->_getParam('search_type',array('given','taken','cancelled','completed','reject'));
        $defaultOpenTab=$defaultOptionsArray[0];
        $isProfessional=Engine_Api::_()->getDbtable('professionals', 'booking')->getProfessionalAvailable(array("user_id"=>$viewer->getIdentity()));
        $isProfessionalInAppointments=Engine_Api::_()->getDbtable('appointments', 'booking')->isProfessionalInAppointments();
        $this->view->isProfessionalInAppointments=$isProfessionalInAppointments->professional_id;
        $this->view->isProfessional=$isProfessional->professional_id;
        if(empty($isProfessional->professional_id))
            $defaultOpenTab=$defaultOptionsArray[1];
        if (is_array($defaultOptionsArray)) {
			$this->view->tab_option = $this->_getParam('tabOption','advance');
            $defaultOptions =array();
            foreach ($defaultOptionsArray as $key => $defaultValue) {
                $appointments="Appointments";
                if ($defaultValue == 'given' && !empty($isProfessional->professional_id) && !empty($isProfessional->professional_id) )
                    $defaultOptions[$defaultValue] = ucwords ($defaultValue)." ".$appointments;
                else if ($defaultValue == 'taken')
                    $defaultOptions[$defaultValue] = ucwords ($defaultValue)." ".$appointments;
                else if ($defaultValue == 'cancelled')
                    $defaultOptions[$defaultValue] = ucwords ($defaultValue)." ".$appointments;
                else if ($defaultValue == 'completed')
                    $defaultOptions[$defaultValue] = ucwords ($defaultValue)." ".$appointments;
                else if ($defaultValue == 'reject')
                    $defaultOptions[$defaultValue] = ucwords (str_replace ("reject","rejected", $defaultValue))." ".$appointments;
            }
            $this->view->defaultOptions = $defaultOptions;
            $this->view->defaultOpenTab = $defaultOpenTab;
            $appointmentsData=Engine_Api::_()->getDbtable('appointments', 'booking')->getAppointments($type);
            $this->view->appointmentPaginator=$appointmentsData;
            /* Setting default user Timezone*/
            $tablename = Engine_Api::_()->getDbtable('professionals', 'booking');
            $select = $tablename->select()->from($tablename->info('name'), array('timezone'))->where("user_id =?",$viewer->getIdentity());
            $data=$tablename->fetchRow($select);
            date_default_timezone_set($data->timezone);
        }
    }
}




