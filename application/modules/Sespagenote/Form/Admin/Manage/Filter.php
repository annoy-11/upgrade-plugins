<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagenote
 * @package    Sespagenote
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Filter.php  2019-03-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespagenote_Form_Admin_Manage_Filter extends Engine_Form {

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
            ->setLabel('Note Title')
            ->clearDecorators()
            ->addDecorator('ViewHelper')
            ->addDecorator('Label', array('tag' => null, 'placement' => 'PREPEND'))
            ->addDecorator('HtmlTag', array('tag' => 'div'));

		$pagetitlename = new Zend_Form_Element_Text('page_title');
    $pagetitlename
            ->setLabel('Page Title')
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

    $sponsored = new Zend_Form_Element_Select('sponsored');
    $sponsored
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
    $arrayItem = !empty($pagetitlename) ? array_merge($arrayItem, array($pagetitlename)) : '';
    $arrayItem = !empty($album_title) ? array_merge($arrayItem, array($album_title)) : $arrayItem;
    $arrayItem = !empty($type) ? array_merge($arrayItem, array($type)) : $arrayItem;
    $arrayItem = !empty($owner_name) ? array_merge($arrayItem, array($owner_name)) : $arrayItem;
    $arrayItem = !empty($featured) ? array_merge($arrayItem, array($featured)) : $arrayItem;
    $arrayItem = !empty($sponsored) ? array_merge($arrayItem, array($sponsored)) : $arrayItem;
    $arrayItem = !empty($offtheday) ? array_merge($arrayItem, array($offtheday)) : $arrayItem;
    $arrayItem = !empty($date) ? array_merge($arrayItem, array($date)) : $arrayItem;
    $arrayItem = !empty($submit) ? array_merge($arrayItem, array($submit)) : '';
    $this->addElements($arrayItem);
  }
}
