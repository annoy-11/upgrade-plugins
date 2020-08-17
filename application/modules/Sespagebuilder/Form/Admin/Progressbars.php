<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Progressbars.php 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagebuilder_Form_Admin_Progressbars extends Engine_Form {

  public function init() {
    $result_array = array();
    $results = Engine_Api::_()->getItemTable('sespagebuilder_progressbar')->getContent();
    foreach ($results as $result) {
      $result_array[$result['progressbar_id']] = $result['title'];
    }
    $this->addElement('Select', 'progressbar_id', array(
        'label' => 'Choose the content to be shown in this widget.',
        'multiOptions' => $result_array,
    ));
  }

}
