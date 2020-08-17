<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Editaccordion.php 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagebuilder_Form_Admin_Accordion_Editaccordion extends Sespagebuilder_Form_Admin_Accordion_Createaccordion {

  public function init() {
    parent::init();

    $this->setTitle('Edit Accordion Menu Item')
            ->setDescription('Below, edit this accordion menu item.');
    $this->save->setLabel('Save Changes');
  }

}
