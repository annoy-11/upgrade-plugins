<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesvideoimporter
 * @package    Sesvideoimporter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: YouTubeSearch.php 2016-04-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
class Sesvideoimporter_Form_YouTubeSearch extends Engine_Form
{
  public function init()
  {
    $this->setAttribs(array(
        'id' => 'filter_form',
        'class' => 'global_form_box video_form_box',
      ))
      ->setMethod('GET');
      ;
    $this->addElement('Text', 'text', array(
      //'label' => 'Search',
        'placeholder'=> $this->getView()->translate('Search')
    ));
       // Buttons
    $this->addElement('Button', 'submit', array(
        'label' => 'Search',
        'type' => 'submit',
    ));

  }
}