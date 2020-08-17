<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventpdfticket
 * @package    Seseventpdfticket
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: pdfGenerate.php 2016-03-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php
	include_once APPLICATION_PATH . '/application/modules/Seseventpdfticket/Api/pdf/autoload.inc.php';
	use Dompdf\Dompdf;
	$pdfTemp = APPLICATION_PATH . '/public/sesevent_ticketpdf';
	if((!@is_dir($pdfTemp) && @mkdir($pdfTemp, 0777, true)) || is_writable($pdfTemp)) {
		$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
		ob_start();
		$html = include ( APPLICATION_PATH . '/application/modules/Seseventpdfticket/views/scripts/pdfContent.tpl');
		$html = ob_get_contents();
		ob_end_clean();
		$id = $orderDetail->getIdentity();
		$pdffilename = "eventticket_$id".".pdf";
		$pdfTicketFile = "$pdfTemp/$pdffilename";
		$dompdf = new Dompdf();
		$dompdf->set_base_path(realpath(APPLICATION_PATH));
		$dompdf->load_html($html);
		$dompdf->set_option('enable_remote',true);
		$dompdf->setPaper('A4', 'landscape');
		$dompdf->render();
		$pdf = $dompdf->output();
		file_put_contents($pdfTicketFile, $pdf);
	}else
		$pdffilename = false;
	
?>
