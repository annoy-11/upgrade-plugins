<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesavatar
 * @package    Sesavatar
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: LetterAvatar.php  2018-09-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class phptextClass {

	public function phptext($text,$textColor,$backgroundColor='',$fontSize,$imgWidth,$imgHeight,$dir) {

		/* settings */
		
		$font = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'application'.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.'Sesavatar'.DIRECTORY_SEPARATOR.'externals'.DIRECTORY_SEPARATOR.'ABeeZee.ttf'; /*define font*/


		$textColor = $this->hexToRGB($textColor);	
		
		$im = imagecreatetruecolor($imgWidth, $imgHeight);
		$textColor = imagecolorallocate($im, $textColor['r'],$textColor['g'],$textColor['b']);	
		
		if($backgroundColor==''){ /*select random color*/
			$colorCode = array('#3cbec9', '#41af20', '#f2901c', '#a9b828', '#fb26a8', '#1a642f', '#2854b8', '#28b879', '#41af20', '#f2901c', '#f2901c', '#fb26a8', '#2854b8', '#95568b', '#c62222', '#ff6c00', '#58735a', '#ea27a7', '#45923a', '#b87628', '#a6b31a', '#000000');
			$backgroundColor = $this->hexToRGB($colorCode[rand(0, count($colorCode)-2)]);
			$backgroundColor = imagecolorallocate($im, $backgroundColor['r'],$backgroundColor['g'],$backgroundColor['b']);
		} else { /*select background color as provided*/
			$backgroundColor = $this->hexToRGB($backgroundColor);
			$backgroundColor = imagecolorallocate($im, $backgroundColor['r'],$backgroundColor['g'],$backgroundColor['b']);
		}

		imagefill($im,0,0,$backgroundColor);	

		list($x, $y) = $this->ImageTTFCenter($im, $text, $font, $fontSize);	
		imagettftext($im, $fontSize, 0, $x, $y, $textColor, $font, $text);
		
		if(imagejpeg($im,$dir,90)) { /*save image as JPG*/
      return true;
			//return json_encode(array('status'=>TRUE,'image'=>$dir.$fileName));
      imagedestroy($im);	
		}
	}
	
	/*function to convert hex value to rgb array*/
	protected function hexToRGB($colour) {
    if ( $colour[0] == '#' ) {
        $colour = substr( $colour, 1 );
    }
    if ( strlen( $colour ) == 6 ) {
        list( $r, $g, $b ) = array( $colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5] );
    } elseif ( strlen( $colour ) == 3 ) {
        list( $r, $g, $b ) = array( $colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2] );
    } else {
        return false;
    }
    $r = hexdec( $r );
    $g = hexdec( $g );
    $b = hexdec( $b );
    return array( 'r' => $r, 'g' => $g, 'b' => $b );
	}		
		
	/*function to get center position on image*/
	protected function ImageTTFCenter($image, $text, $font, $size, $angle = 8) 
	{
		$xi = imagesx($image);
		$yi = imagesy($image);
		$box = imagettfbbox($size, $angle, $font, $text);
		$xr = abs(max($box[2], $box[4]))+5;
		$yr = abs(max($box[5], $box[7]));
		$x = intval(($xi - $xr) / 2);
		$y = intval(($yi + $yr) / 2);
		return array($x, $y);	
	}
}
