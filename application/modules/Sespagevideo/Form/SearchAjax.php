<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagevideo
 * @package    Sespagevideo
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: SearchAjax.php 2015-10-11 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespagevideo_Form_SearchAjax extends Engine_Form {

  public function init() {

    $this->setAttribs(array(
        'id' => 'filter_form',
        'class' => 'global_form_box',
    ));
    parent::init();

    $this->addElement('Text', 'title', array(
        'placeholder' => 'Search'
    ));
  }

}
