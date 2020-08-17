<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroupvideo
 * @package    Sesgroupvideo
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: SearchAjax.php  2018-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesgroupvideo_Form_SearchAjax extends Engine_Form {

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
