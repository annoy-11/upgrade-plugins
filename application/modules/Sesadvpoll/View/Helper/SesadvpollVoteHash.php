<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvpoll
 * @package    Sesadvpoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: SesadvpollVoteHash.php  2018-12-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesadvpoll_View_Helper_SesadvpollVoteHash extends Zend_View_Helper_Abstract
{
    private $element = array();
    public function sesadvpollVoteHash(Sesadvpoll_Model_Poll $poll = null)
    {
        $this->element = new Engine_Form_Element_Hash('token_sesadvpoll_' . $poll->getIdentity(), array(
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
