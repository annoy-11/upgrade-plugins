<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmembershorturl
 * @package    Sesmembershorturl
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Bodyclass.php 2016-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesmembershorturl_View_Filter_Bodyclass {

	public function filter($string) {
    return str_replace('/FAZXCA88RTYUJHFERCFG455DTR', '', $string);
  }
}