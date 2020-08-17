<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Filtersignature.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Epetition_Form_Admin_Filtersignature extends Engine_Form
 {

 	public function init() 
 	{
      $this->clearDecorators()
            ->addDecorator('FormElements')
            ->addDecorator('Form')
            ->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'search'))
            ->addDecorator('HtmlTag2', array('tag' => 'div', 'class' => 'clear'));
    $this->setAttribs(array('id' => 'filter_form', 'class' => 'global_form_box'))->setMethod('GET');

    $petition_list=array(''=>"Select Petition");
        $table = Engine_Api::_()->getDbtable('epetitions', 'epetition');
        $data = $table->select()
            ->query()
            ->fetchAll();
        foreach ($data as $datas)
        {
            $petition_list[$datas['epetition_id']]=$datas['title'];
        }

    $this->addElement('Select', 'epetition_id', array(
        'label' => 'Petition Title',
        'placeholder' => 'Enter Petition Title',
        'multiOptions'=>$petition_list,
        'decorators' => array(
            'ViewHelper',
            array('Label', array('tag' => null, 'placement' => 'PREPEND')),
            array('HtmlTag', array('tag' => 'div'))
        ),
    ));

    $this->addElement('Text', 'name', array(
        'label' => 'Name',
        'placeholder' => 'Enter Name',
        'decorators' => array(
            'ViewHelper',
            array('Label', array('tag' => null, 'placement' => 'PREPEND')),
            array('HtmlTag', array('tag' => 'div'))
        ),
    ));

    $this->addElement('Text', 'from_date', array(
        'label' => 'Creation From Date Ex(2015-03-02)',
        'placeholder' => 'Enter Creation From Date',
        'decorators' => array(
            'ViewHelper',
            array('Label', array('tag' => null, 'placement' => 'PREPEND')),
            array('HtmlTag', array('tag' => 'div'))
        ),
    ));

        $this->addElement('Text', 'to_date', array(
            'label' => 'Creation To Date Ex(2015-03-02)',
            'placeholder' => 'Enter Creation To Date',
            'decorators' => array(
                'ViewHelper',
                array('Label', array('tag' => null, 'placement' => 'PREPEND')),
                array('HtmlTag', array('tag' => 'div'))
            ),
        ));

    $this->addElement('Select', 'user_type', array(
        'label' => "User Type",
        'required' => true,
        'multiOptions' => array("" => 'Select', "1" => "Log-In", "0" => "Non-Login"),
        'decorators' => array(
            'ViewHelper',
            array('Label', array('tag' => null, 'placement' => 'PREPEND')),
            array('HtmlTag', array('tag' => 'div'))
        ),
    ));


		 $this->addElement('Button', 'search', array(
        'label' => 'Search',
        'type' => 'submit',
        'ignore' => true,
    ));
 	}
}
?>