<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmaterial
 * @package    Sesmaterial
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: SearchAjax.php 2018-07-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesmaterial_Form_SearchAjax extends Engine_Form {

  public function init() {

    $this->setAttribs(array(
        'id' => 'filter_form',
        'class' => 'global_form_box',
    ));
    parent::init();

    $this->addElement('Select', 'type', array(
        'multiOptions' => array(
            'video' => 'Videos',
            'sesvideo_chanel' => 'Chanels',
            'sesvideo_artist' => 'Artists',
            'sesvideo_playlist' => 'Playlists',
        ),
        'onchange' => 'typevalue(this.value)',
        'value' => 'video',
    ));

    $this->addElement('Text', 'title', array(
        'placeholder' => 'Search'
    ));
  }

}
