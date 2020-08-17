<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventvideo
 * @package    Seseventvideo
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Filter.php 2016-07-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seseventvideo_Form_Admin_Manage_Filter extends Engine_Form {

  public function init() {
    parent::init();
    $this
            ->clearDecorators()
            ->addDecorator('FormElements')
            ->addDecorator('Form')
            ->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'search'))
            ->addDecorator('HtmlTag2', array('tag' => 'div', 'class' => 'clear'))
    ;
    $this
            ->setAttribs(array(
                'id' => 'filter_form',
                'class' => 'global_form_box',
            ))
            ->setMethod('GET');

    $titlename = new Zend_Form_Element_Text('title');
    $titlename
            ->setLabel('Video Title')
            ->clearDecorators()
            ->addDecorator('ViewHelper')
            ->addDecorator('Label', array('tag' => null, 'placement' => 'PREPEND'))
            ->addDecorator('HtmlTag', array('tag' => 'div'));
		
		$eventtitlename = new Zend_Form_Element_Text('event_title');
    $eventtitlename
            ->setLabel('Event Title')
            ->clearDecorators()
            ->addDecorator('ViewHelper')
            ->addDecorator('Label', array('tag' => null, 'placement' => 'PREPEND'))
            ->addDecorator('HtmlTag', array('tag' => 'div'));
		
		$status = new Zend_Form_Element_Select('status');
    $status
            ->setLabel('Status')
            ->clearDecorators()
            ->addDecorator('ViewHelper')
            ->addDecorator('Label', array('tag' => null, 'placement' => 'PREPEND'))
            ->addDecorator('HtmlTag', array('tag' => 'div'))
            ->setMultiOptions(array(
								''  => '',
                '0' => 'Queued',
                '1' => 'Ready',
                '2' => 'Processing',
            ))
            ->setValue('');
	$type = new Zend_Form_Element_Select('type');
    $type
            ->setLabel('Type')
            ->clearDecorators()
            ->addDecorator('ViewHelper')
            ->addDecorator('Label', array('tag' => null, 'placement' => 'PREPEND'))
            ->addDecorator('HtmlTag', array('tag' => 'div'))
            ->setMultiOptions(array(
                '' => '',
                '1' => 'YouTube',
                '2' => 'Vimeo',
								'3' => 'Uploaded',
								'4' => 'Dailymotion',
            ))
            ->setValue('');	
    $owner_name = new Zend_Form_Element_Text('owner_name');
    $owner_name
            ->setLabel('Owner Name')
            ->clearDecorators()
            ->addDecorator('ViewHelper')
            ->addDecorator('Label', array('tag' => null, 'placement' => 'PREPEND'))
            ->addDecorator('HtmlTag', array('tag' => 'div'));

    $is_featured = new Zend_Form_Element_Select('is_featured');
    $is_featured
            ->setLabel('Featured')
            ->clearDecorators()
            ->addDecorator('ViewHelper')
            ->addDecorator('Label', array('tag' => null, 'placement' => 'PREPEND'))
            ->addDecorator('HtmlTag', array('tag' => 'div'))
            ->setMultiOptions(array(
                '' => '',
                '1' => 'Yes',
                '0' => 'No',
            ))
            ->setValue('');

    $offtheday = new Zend_Form_Element_Select('offtheday');
    $offtheday
            ->setLabel('Of The Day')
            ->clearDecorators()
            ->addDecorator('ViewHelper')
            ->addDecorator('Label', array('tag' => null, 'placement' => 'PREPEND'))
            ->addDecorator('HtmlTag', array('tag' => 'div'))
            ->setMultiOptions(array(
                '' => '',
                '1' => 'Yes',
                '0' => 'No',
            ))
            ->setValue('');
    $is_sponsored = new Zend_Form_Element_Select('is_sponsored');
    $is_sponsored
            ->setLabel('Sponsored')
            ->clearDecorators()
            ->addDecorator('ViewHelper')
            ->addDecorator('Label', array('tag' => null, 'placement' => 'PREPEND'))
            ->addDecorator('HtmlTag', array('tag' => 'div'))
            ->setMultiOptions(array(
                '' => '',
                '1' => 'Yes',
                '0' => 'No',
            ))
            ->setValue('');
    $is_hot = new Zend_Form_Element_Select('is_hot');
    $is_hot
            ->setLabel('Hot')
            ->clearDecorators()
            ->addDecorator('ViewHelper')
            ->addDecorator('Label', array('tag' => null, 'placement' => 'PREPEND'))
            ->addDecorator('HtmlTag', array('tag' => 'div'))
            ->setMultiOptions(array(
                '' => '',
                '1' => 'Yes',
                '0' => 'No',
            ))
            ->setValue('');
    $rating = new Zend_Form_Element_Select('rating');
    $rating
            ->setLabel('Rated')
            ->clearDecorators()
            ->addDecorator('ViewHelper')
            ->addDecorator('Label', array('tag' => null, 'placement' => 'PREPEND'))
            ->addDecorator('HtmlTag', array('tag' => 'div'))
            ->setMultiOptions(array(
                '' => '',
                '1' => 'Yes',
                '0' => 'No',
            ))
            ->setValue('');
    $location = new Zend_Form_Element_Select('location');
    $location
            ->setLabel('Has Location')
            ->clearDecorators()
            ->addDecorator('ViewHelper')
            ->addDecorator('Label', array('tag' => null, 'placement' => 'PREPEND'))
            ->addDecorator('HtmlTag', array('tag' => 'div'))
            ->setMultiOptions(array(
                '' => '',
                '1' => 'Yes',
                '0' => 'No',
            ))
            ->setValue('');
    $date = new Zend_Form_Element_Text('creation_date');
    $date
            ->setLabel('Creation Date: ex (2000-12-01)')
            ->clearDecorators()
            ->addDecorator('ViewHelper')
            ->addDecorator('Label', array('tag' => null, 'placement' => 'PREPEND'))
            ->addDecorator('HtmlTag', array('tag' => 'div'));

    $submit = new Zend_Form_Element_Button('search', array('type' => 'submit'));
    $submit
            ->setLabel('Search')
            ->clearDecorators()
            ->addDecorator('ViewHelper')
            ->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'buttons'))
            ->addDecorator('HtmlTag2', array('tag' => 'div'));

    $arrayItem = array();
    $arrayItem = !empty($titlename) ? array_merge($arrayItem, array($titlename)) : '';
		$arrayItem = !empty($eventtitlename) ? array_merge($arrayItem, array($eventtitlename)) : '';
    $arrayItem = !empty($album_title) ? array_merge($arrayItem, array($album_title)) : $arrayItem;
		$arrayItem = !empty($status) ? array_merge($arrayItem, array($status)) : $arrayItem;
	  $arrayItem = !empty($type) ? array_merge($arrayItem, array($type)) : $arrayItem;
    $arrayItem = !empty($owner_name) ? array_merge($arrayItem, array($owner_name)) : $arrayItem;
    $arrayItem = !empty($is_featured) ? array_merge($arrayItem, array($is_featured)) : $arrayItem;
    $arrayItem = !empty($is_hot) ? array_merge($arrayItem, array($is_hot)) : $arrayItem;
    $arrayItem = !empty($is_sponsored) ? array_merge($arrayItem, array($is_sponsored)) : $arrayItem;
    $arrayItem = !empty($location) ? array_merge($arrayItem, array($location)) : $arrayItem;
    $arrayItem = !empty($offtheday) ? array_merge($arrayItem, array($offtheday)) : $arrayItem;
    $arrayItem = !empty($rating) ? array_merge($arrayItem, array($rating)) : $arrayItem;
    $arrayItem = !empty($date) ? array_merge($arrayItem, array($date)) : $arrayItem;
    $arrayItem = !empty($submit) ? array_merge($arrayItem, array($submit)) : '';
    $this->addElements($arrayItem);
  }

}
