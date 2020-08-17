<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventpdfticket
 * @package    Seseventpdfticket
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php 2016-03-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Seseventpdfticket_Api_Core extends Core_Api_Abstract {
	function checkRequiredModulesExists(){
		  if (!extension_loaded('gd')) {
					return false;
			}	
			if (!extension_loaded('mbstring')) {
					return false;
			}
			if(!extension_loaded('dom')){
					return false;	
			}
			return true;
	}
	//create pdf file
	function createPdfFile($orderDetail,$event,$eventOrder,$user){
			$pdffilename = false;
			if(!$orderDetail || !$this->checkRequiredModulesExists())
				return false;
			try{
				include APPLICATION_PATH . '/application/modules/Seseventpdfticket/views/scripts/pdfGenerate.php';
			}catch ( Exception $e ){
				//silence
			}
			return $pdffilename;
					
	}

}