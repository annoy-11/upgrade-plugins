<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfooter
 * @package    Sesfooter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2015-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php
$footerDesign = Engine_Api::_()->sesfooter()->getContantValueXML('ses_footer_design');
?>

<?php if($footerDesign == '1'): ?>
	<?php include 'footer1.tpl'; ?>
<?php elseif($footerDesign == '2'): ?>
	<?php include 'footer2.tpl'; ?>
<?php elseif($footerDesign == '3'): ?>
	<?php include 'footer3.tpl'; ?>
<?php elseif($footerDesign == '4'): ?>
	<?php include 'footer4.tpl'; ?>	  
<?php elseif($footerDesign == '5'): ?> 
	<?php include 'footer5.tpl'; ?>
<?php elseif($footerDesign == '6'): ?>
	<?php include 'footer6.tpl'; ?>
<?php elseif($footerDesign == '7'): ?>
	<?php include 'footer7.tpl'; ?>
<?php elseif($footerDesign == '8'): ?>
	<?php include 'footer8.tpl'; ?>
<?php endif; ?>