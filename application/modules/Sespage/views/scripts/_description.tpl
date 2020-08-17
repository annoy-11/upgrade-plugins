<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _description.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $descriptionLimit = $this->limit;?>
<?php $ro = preg_replace('/\s+/', ' ',$this->description);?>
<?php $tmpBody = preg_replace('/ +/', ' ',html_entity_decode(strip_tags( $ro)));?>
<?php  echo nl2br( Engine_String::strlen($tmpBody) > $descriptionLimit ? Engine_String::substr($tmpBody, 0, $descriptionLimit) . '...' : $tmpBody );?>