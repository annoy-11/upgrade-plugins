<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmembersubscription
 * @package    Sesmembersubscription
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Searchorder.php 2016-07-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesmembersubscription_Form_SearchSubscriber extends Engine_Form {

  public function init() {

    $this
    ->setMethod('POST')
    ->setAction($_SERVER['REQUEST_URI'])
    ->setAttribs(array(
      'id' => 'manage_order_search_form',
      'class' => 'subscribers_form_box global_form_box',
    ));

    $this->addElement('Text', 'subscriber_name', array(
      'label'=>'Subscriber Name',
    ));
    
		$this->addElement('Text', 'subscriber_email', array(
      'label'=>'Subscriber Email',
    ));
    
		$this->addElement('Button', 'search', array(
      'label' => 'Search',
      'type' => 'submit',
    ));
		$this->addElement('Dummy','loading-img-sesevent', array(
        'content' => '<img src="application/modules/Core/externals/images/loading.gif" id="sesevent-search-order-img" alt="Loading" />',
   ));
  }

}
