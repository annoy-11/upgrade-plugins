<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventmusic
 * @package    Seseventmusic
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Search.php 2015-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Seseventmusic_Form_Search extends Engine_Form {

  public function init() {

    $this->setAttribs(array(
        'id' => 'filter_form',
        'class' => 'global_form_box',
    ));
    parent::init();

    $this->addElement('Select', 'type', array(
        'multiOptions' => array(
            'seseventmusic_album' => 'Music Albums',
            'seseventmusic_albumsong' => 'Songs',
        ),
        'onchange' => 'typevalue(this.value)',
        'value' => 'seseventmusic_album',
    ));

    $this->addElement('Text', 'title', array(
        'placeholder' => 'Search'
    ));
  }

}