<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: VoteHashSesqa.php  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesqa_View_Helper_VoteHashSesqa extends Zend_View_Helper_Abstract
{
    private $element = array();

    public function voteHashSesqa(Sesqa_Model_Question $question = null)
    {
        $this->element = new Engine_Form_Element_Hash('token_poll_' . $question->getIdentity(), array(
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
