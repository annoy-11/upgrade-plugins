<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventspeaker
 * @package    Seseventspeaker
 * @copyright  Copyright 2018-2017 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2017-03-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seseventspeaker_Widget_SpeakerBrowseSearchController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $viewer = Engine_Api::_()->user()->getViewer();
    $requestParams = Zend_Controller_Front::getInstance()->getRequest()->getParams();
    $searchOptionsType = $this->_getParam('searchOptionsType', array('searchBox', 'view', 'show'));
    if (empty($searchOptionsType))
      return $this->setNoRender();
    $this->view->form = $formFilter = new Seseventspeaker_Form_SearchSpeaker();
    if ($formFilter->isValid($requestParams))
      $values = $formFilter->getValues();
    else
      $values = array();
    $this->view->formValues = array_filter($values);
    if (@$values['show'] == 2 && $viewer->getIdentity())
      $values['users'] = $viewer->membership()->getMembershipsOfIds();
    unset($values['show']);
  }

}
