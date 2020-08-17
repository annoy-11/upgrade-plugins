<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesemoji
 * @package    Sesemoji
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2017-11-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesemoji_Api_Core extends Core_Api_Abstract {

	/**
	 * Encode emoji in text
	 * @param string $text text to encode
	 */
	public function EncodeEmoji($text) {

		return $this->convertEmoji($text,"ENCODE");
	}

	/**
	 * Decode emoji in text
	 * @param string $text text to decode
	 */
	public function DecodeEmoji($text) {
		return $this->convertEmoji($text,"DECODE");
	}

	public function convertEmoji($text,$op) {
	
		if($op=="ENCODE") {
			return preg_replace_callback('/([0-9|#][\x{20E3}])|[\x{00ae}|\x{00a9}|\x{203C}|\x{2047}|\x{2048}|\x{2049}|\x{3030}|\x{303D}|\x{2139}|\x{2122}|\x{3297}|\x{3299}][\x{FE00}-\x{FEFF}]?|[\x{2190}-\x{21FF}][\x{FE00}-\x{FEFF}]?|[\x{2300}-\x{23FF}][\x{FE00}-\x{FEFF}]?|[\x{2460}-\x{24FF}][\x{FE00}-\x{FEFF}]?|[\x{25A0}-\x{25FF}][\x{FE00}-\x{FEFF}]?|[\x{2600}-\x{27BF}][\x{FE00}-\x{FEFF}]?|[\x{2600}-\x{27BF}][\x{1F000}-\x{1FEFF}]?|[\x{2900}-\x{297F}][\x{FE00}-\x{FEFF}]?|[\x{2B00}-\x{2BF0}][\x{FE00}-\x{FEFF}]?|[\x{1F000}-\x{1F9FF}][\x{FE00}-\x{FEFF}]?|[\x{1F000}-\x{1F9FF}][\x{1F000}-\x{1FEFF}]?/u',array('self',"encodeEmojis"),$text);
		} else {
			return preg_replace_callback('/(\\\u[0-9a-f]{4})+/',array('self',"decodeEmojis"),$text);
		}
	}
	
	private static function encodeEmojis($match) {
		return str_replace(array('[',']','"'),'',json_encode($match));
	}
	
	private static function decodeEmojis($text) {
		if(!$text) return '';
		$text = $text[0];
		$decode = json_decode($text,true);
		if($decode) return $decode;
		$text = '["' . $text . '"]';
		$decode = json_decode($text);
		if(count($decode) == 1){
		   return $decode[0];
		}
		return $text;
	}

}