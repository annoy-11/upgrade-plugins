<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seserror
 * @package    Seserror
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2017-05-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seserror_Widget_NoSearchresultsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $seserror_table = Engine_Api::_()->getDbtable('errors', 'seserror');

    $select = $seserror_table->select()
            ->where('`default` = ?', 1)
            ->where('error_type = ?', 'search');
    $this->view->ses_error_results = $seserror_table->fetchRow($select);

    if (!$this->view->ses_error_results->default) {
      return $this->setNoRender();
    }
  }

}
