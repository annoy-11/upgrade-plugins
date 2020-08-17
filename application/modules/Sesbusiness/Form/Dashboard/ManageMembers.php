<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: ManageMembers.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesbusiness_Form_Dashboard_ManageMembers extends Engine_Form {

  public function init() {

    $this->setMethod('POST')
            ->setAction($_SERVER['REQUEST_URI'])
            ->setAttribs(array(
                'id' => 'manage_members_search_form',
                'class' => 'global_form_box',
    ));

    $this->addElement('Text', 'name', array(
        'label' => 'Member Name',
        'placeholder' => 'Enter Member Name'
    ));

    $this->addElement('Text', 'business_role', array(
        'label' => 'Business Role',
        'placeholder' => 'Enter Business Name'
    ));

    $this->addElement('Text', 'email', array(
        'label' => 'Email',
        'placeholder' => 'Email'
    ));

    $this->addElement('Select', 'status', array(
        'label' => 'Approved',
        'MultiOptions' => array('' => 'Choose Status', '1' => 'Yes', '0' => 'No')
    ));

    $this->addElement('Button', 'search', array(
        'label' => 'Search',
        'type' => 'submit',
    ));

    $this->addElement('Dummy', 'loading-img-sesbusiness', array(
        'content' => '<img src="application/modules/Core/externals/images/loading.gif" id="sesbusiness-search-order-img" alt="Loading" />',
    ));
  }

}
