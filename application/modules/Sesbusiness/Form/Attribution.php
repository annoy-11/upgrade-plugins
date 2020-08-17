<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Attribution.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbusiness_Form_Attribution extends Engine_Form {
  protected $_businessItem;
  public function getBusinessItem() {
    return $this->_businessItem;
  }

  public function setBusinessItem($businessItem) {
    $this->_businessItem = $businessItem;
    return $this;
  }
  public function init() {
    parent::init();
    //get current logged in user
    $this->setTitle('Post Attribution')
            ->setAttrib('id', 'sesbusiness_attr_form')
            ->setAttrib('enctype', 'multipart/form-data')
            ->setMethod("POST");

    $attribution[1] = '<b>Post as '.$this->_businessItem->getTitle().'</b><br>Your posts, likes and comments on this Business\'s timeline will be attributed to the Business by default. When you\'re creating or replying to a post, you will still have the option to post as yourself or another Business you manage.';

    $attribution[0] = '<b>Post as '.Engine_Api::_()->user()->getViewer()->getTitle().'</b></br>Your posts, likes and comments on this Business\'s timeline will be attributed to you by default. When you\'re creating or replying to a post, you will still have the option to post as this Business or another Business you manage.';

    $this->addElement('Radio', 'attribution', array(
          'label' => '',
          'description' => '',
          'multiOptions' => $attribution,
          'escape' => false,
      ));
  }
}
