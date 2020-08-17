<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinesspoll
 * @package    Sesbusinesspoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: SwsBusinessVoteHash.php  2018-10-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbusinesspoll_View_Helper_SesBusinessVoteHash extends Zend_View_Helper_Abstract
{
    private $element = array();
    public function sesBusinessVoteHash(Sesbusinesspoll_Model_Poll $poll = null)
    {
        $this->element = new Engine_Form_Element_Hash('token_sesbusinesspoll_' . $poll->getIdentity(), array(
          'timeout' => 3600
        ));
        return $this;
    }
    public function getElement()
    {
        return $this->element;
    }
    public function generateHash()
    {
        $this->element->initCsrfToken();
        return $this->element->getHash();
    }

}
