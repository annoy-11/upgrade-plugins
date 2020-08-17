<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessoffer
 * @package    Sesbusinessoffer
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Filter.php  2019-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbusinessoffer_Form_Admin_Manage_Filter extends Engine_Form {

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
            ->setLabel('Offer Title')
            ->clearDecorators()
            ->addDecorator('ViewHelper')
            ->addDecorator('Label', array('tag' => null, 'placement' => 'PREPEND'))
            ->addDecorator('HtmlTag', array('tag' => 'div'));

		$businesstitlename = new Zend_Form_Element_Text('business_title');
    $businesstitlename
            ->setLabel('Business Title')
            ->clearDecorators()
            ->addDecorator('ViewHelper')
            ->addDecorator('Label', array('tag' => null, 'placement' => 'PREPEND'))
            ->addDecorator('HtmlTag', array('tag' => 'div'));


    $owner_name = new Zend_Form_Element_Text('owner_name');
    $owner_name
            ->setLabel('Owner Name')
            ->clearDecorators()
            ->addDecorator('ViewHelper')
            ->addDecorator('Label', array('tag' => null, 'placement' => 'PREPEND'))
            ->addDecorator('HtmlTag', array('tag' => 'div'));

    $featured = new Zend_Form_Element_Select('featured');
    $featured
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

    $hot = new Zend_Form_Element_Select('hot');
    $hot
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

    $new = new Zend_Form_Element_Select('new');
    $new
            ->setLabel('New')
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
    $arrayItem = !empty($businesstitlename) ? array_merge($arrayItem, array($businesstitlename)) : '';
    $arrayItem = !empty($album_title) ? array_merge($arrayItem, array($album_title)) : $arrayItem;
    $arrayItem = !empty($type) ? array_merge($arrayItem, array($type)) : $arrayItem;
    $arrayItem = !empty($owner_name) ? array_merge($arrayItem, array($owner_name)) : $arrayItem;
    $arrayItem = !empty($featured) ? array_merge($arrayItem, array($featured)) : $arrayItem;
    $arrayItem = !empty($hot) ? array_merge($arrayItem, array($hot)) : $arrayItem;
    $arrayItem = !empty($new) ? array_merge($arrayItem, array($new)) : $arrayItem;
    $arrayItem = !empty($offtheday) ? array_merge($arrayItem, array($offtheday)) : $arrayItem;
    $arrayItem = !empty($date) ? array_merge($arrayItem, array($date)) : $arrayItem;
    $arrayItem = !empty($submit) ? array_merge($arrayItem, array($submit)) : '';
    $this->addElements($arrayItem);
  }
}
