<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seschristmas
 * @package    Seschristmas
 * @copyright  Copyright 2014-2015 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: christmastemplete.php 2014-11-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php

$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;

$api_settings = Engine_Api::_()->getApi('settings', 'core');
$seschristmas_template = $api_settings->getSetting('seschristmas.template', 1);

$seschristmas_template1 = $api_settings->getSetting('seschristmas.template1', 'a:4:{i:0;s:13:"header_before";i:1;s:12:"header_after";i:2;s:13:"footer_before";i:3;s:12:"footer_after";}');
$template1_value = unserialize($seschristmas_template1);

$seschristmas_template2 = $api_settings->getSetting('seschristmas.template2', 'a:3:{i:0;s:13:"header_before";i:1;s:15:"left_right_bell";i:2;s:13:"footer_before";}');
$template2_value = unserialize($seschristmas_template2);

?>
<?php if ($seschristmas_template) : ?>
  <?php if (!empty($template1_value)): ?>
    <style type="text/css">
      /*Site Element Template 1*/
      .seschristmas_template1{position: relative;overflow:hidden;}
      .seschristmas_template1 #global_content{min-height: 600px;}
      #global_header a, #global_footer a{position: relative;z-index: 2;}
      .seschristmas_template1:before, .seschristmas_template1:after{background-repeat:no-repeat;background-size: contain;content: "";position: absolute;z-index: 1;}
      <?php if (in_array('header_before', $template1_value)) : ?>
        .seschristmas_template1:before {background-image: url(<?php echo $view->layout()->staticBaseUrl . 'application/modules/Seschristmas/externals/images/temp1-topleft.png' ?>);background-position:top left;top:0;left:0;height:200px;width:200px;}
      <?php endif; ?>
      <?php if (in_array('footer_after', $template1_value)) : ?>
        .seschristmas_template1:after{background-image: url(<?php echo $view->layout()->staticBaseUrl . 'application/modules/Seschristmas/externals/images/temp1-bottomright.png' ?>);background-position:bottom right;bottom:0;right:0;height:200px;width: 200px;}
      <?php endif; ?>
        .seschristmas_template1 #global_wrapper{position:relative;}
       .seschristmas_template1 #global_wrapper:before, #global_wrapper:after{background-repeat:no-repeat;background-size:contain;content: "";position: absolute;z-index: 0;}
      <?php if (in_array('footer_before', $template1_value)) : ?>
        .seschristmas_template1 #global_wrapper:before {background-image: url(<?php echo $view->layout()->staticBaseUrl . 'application/modules/Seschristmas/externals/images/temp1-midbtmleft.png' ?>);background-position:center top;bottom:0;height:200px;left: 0;width: 150px;}
      <?php endif; ?>
      <?php if (in_array('header_after', $template1_value)) : ?>
        .seschristmas_template1 #global_wrapper:after {background-image: url(<?php echo $view->layout()->staticBaseUrl . 'application/modules/Seschristmas/externals/images/temp1-midtopright.png' ?>);background-position:center top;height:300px;right:0;top:0;width:176px;}
      <?php endif; ?>
        @media only screen and (max-width:1100px){
          .seschristmas_template1:before, .seschristmas_template1:after, .seschristmas_template1 #global_wrapper:before, .seschristmas_template1 #global_wrapper:after{display:none;padding:0;height:0;}
        }
    </style>
  <?php endif; ?>
<?php else: ?>
  <?php if (!empty($template2_value)): ?>
    <style type="text/css">
      /*Site Element Template 2*/
      <?php if (in_array('header_before', $template2_value)) : ?>
        .seschristmas_template2 #global_header{padding-top:40px;}
        .seschristmas_template2 #global_header:before{background-image: url(<?php echo $view->layout()->staticBaseUrl . 'application/modules/Seschristmas/externals/images/temp1-topheader.png' ?>);background-repeat:repeat-x;background-size:auto 100%;content:"";height: 40px;position: absolute;top:0;width:100%;z-index: 1;}
      <?php endif; ?>
      <?php if (in_array('left_right_bell', $template2_value)) : ?>
        .seschristmas_template2 #global_wrapper{position:relative;}
        .seschristmas_template2 #global_wrapper:before, #global_wrapper:after{background-size:100% 100%;content:"";height:128px;position:absolute;top:0;width:128px;z-index: -1;}
        .seschristmas_template2 #global_wrapper:before{background-image:url(<?php echo $view->layout()->staticBaseUrl . 'application/modules/Seschristmas/externals/images/temp2-midleft1.png' ?>);left:10px;}
        .seschristmas_template2 #global_wrapper:after{background-image: url(<?php echo $view->layout()->staticBaseUrl . 'application/modules/Seschristmas/externals/images/temp2-midright1.png' ?>);right:10px;}
      <?php endif; ?>
      <?php if (in_array('footer_before', $template2_value)) : ?>
        .seschristmas_template2{position:relative;padding-bottom:80px;}
        .seschristmas_template2:after{background-image:url(<?php echo $view->layout()->staticBaseUrl . 'application/modules/Seschristmas/externals/images/temp2-footerbg.png' ?>);background-repeat:repeat-x;bottom:0;content:"";height:80px;left:0;position: absolute;right:0;width: 100%;z-index: 1;}
        .seschristmas_template2 #global_footer:before, .seschristmas_template2 #global_footer:after{background-repeat:no-repeat;background-position:center center;bottom: 0;content:"";position:absolute;z-index:2;}
        .seschristmas_template2 #global_footer:before{background-image:url(<?php echo $view->layout()->staticBaseUrl . 'application/modules/Seschristmas/externals/images/temp2-footerleft.png' ?>);height:188px;left:0;width:170px;}
        .seschristmas_template2 #global_footer:after{background-image: url(<?php echo $view->layout()->staticBaseUrl . 'application/modules/Seschristmas/externals/images/temp2-footerright.png' ?>);height:149px;right:0;width: 128px;}
      <?php endif; ?>
      @media only screen and (max-width:1100px){
        .seschristmas_template2{padding-bottom:0;}
        body{padding-bottom:0;}        
        .seschristmas_template2 #global_wrapper:before, .seschristmas_template2 #global_wrapper:after, .seschristmas_template2 #global_footer:before, .seschristmas_template2 #global_footer:after, .seschristmas_template2:after{display:none;padding:0;height: 0;}
      }
    </style>
  <?php endif; ?>
<?php endif; ?>