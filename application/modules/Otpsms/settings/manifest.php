<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Otpsms
 * @package    Otpsms
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2018-11-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 return array (
  'package' =>
  array (
    'type' => 'module',
    'name' => 'otpsms',
    //'sku' => 'otpsms',
    'version' => '4.10.5p1',
	'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
    'path' => 'application/modules/Otpsms',
    'title' => '(OTP) One Time Password, SMS Mobile Verification & Safe Login Plugin',
    'description' => '(OTP) One Time Password, SMS Mobile Verification & Safe Login Plugin',
    'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
    'callback' =>
    array (
      'path' => 'application/modules/Otpsms/settings/install.php',
      'class' => 'Otpsms_Installer',
    ),
    'actions' =>
    array (
      0 => 'install',
      1 => 'upgrade',
      2 => 'refresh',
      3 => 'enable',
      4 => 'disable',
    ),
    'directories' =>
    array (
      0 => 'application/modules/Otpsms',
    ),
    'files' =>
    array (
      0 => 'application/languages/en/otpsms.csv',
    ),
  ),
  'items' => array(

    ),
  'hooks' => array(
      array(
          'event' => 'onRenderLayoutDefault',
          'resource' => 'Otpsms_Plugin_Core'
      ),
      array(
          'event' => 'onRenderLayoutDefaultSimple',
          'resource' => 'Otpsms_Plugin_Core'
      ),
      array(
          'event' => 'onRenderLayoutMobileDefault',
          'resource' => 'Otpsms_Plugin_Core'
      ),
      array(
          'event' => 'onRenderLayoutMobileDefaultSimple',
          'resource' => 'Otpsms_Plugin_Core'
      ),
      array(
          'event' => 'onUserFormLoginInitAfter',
          'resource'=>'Otpsms_Plugin_Core',
      ),
      array(
          'event' => 'onUserFormSignupAccountInitAfter',
          'resource'=>'Otpsms_Plugin_Core',
      ),
      array(
          'event' => 'onQuicksignupFormSignupFieldsInitAfter',
          'resource'=>'Otpsms_Plugin_Core',
      )
  ),
  'routes' => array(
     'optsms_general' => array(
        'route' =>  'otp/auth/*',
        'defaults' => array(
            'module' => 'otpsms',
            'controller' => 'index',
            'action' => 'phone-number',
        ),
    ),
    'optsms_verify' => array(
        'route' =>  'otp/auth/verify/*',
        'defaults' => array(
            'module' => 'otpsms',
            'controller' => 'index',
            'action' => 'verify',
        ),
    ),
  ),
);
