<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessportz
 * @package    Sessportz
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: SearchAjax.php  2019-04-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sessportz_Form_SearchAjax extends Engine_Form {

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
