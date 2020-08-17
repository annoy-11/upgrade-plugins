<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array(
  'package' => array(
    'type' => 'module',
    'name' => 'sesprofilefield',
    //'sku' => 'sesprofilefield',
    'version' => '4.10.5',
	'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.10.5',
            ),
        ),
    'path' => 'application/modules/Sesprofilefield',
    'title' => 'SES - Professional Profile Fields Plugin',
    'description' => 'SES - Professional Profile Fields Plugin',
    'author' => '<a href="https://socialnetworking.solutions" style="text-decoration:underline;" target="_blank">SocialNetworking.Solutions</a>',
    'actions' => array(
      'install',
      'upgrade',
      'refresh',
      'enable',
      'disable',
    ),
    'callback' => array(
      'path' => 'application/modules/Sesprofilefield/settings/install.php',
      'class' => 'Sesprofilefield_Installer',
    ),
    'directories' => array(
      'application/modules/Sesprofilefield',
    ),
    'files' => array(
      'application/languages/en/sesprofilefield.csv',
    ),
  ),
  // Hooks ---------------------------------------------------------------------
  'hooks' => array(
  ),
  // Items ---------------------------------------------------------------------
  'items' => array(
    'sesprofilefield_education',
    'sesprofilefield_certification',
    'sesprofilefield_award',
    'sesprofilefield_experience',
    'sesprofilefield_endorsements',
    'sesprofilefield_skill',
    'sesprofilefield_school',
    'sesprofilefield_degree',
    'sesprofilefield_study',
    'sesprofilefield_position',
    'sesprofilefield_company',
    'sesprofilefield_authority',
    'sesprofilefield_specialty',
    'sesprofilefield_adminspecialty',
    'sesprofilefield_manageskills',
    'sesprofilefield_managelanguages',
    'sesprofilefield_language',
    'sesprofilefield_course',
    'sesprofilefield_project',
    'sesprofilefield_organization',

  ),
   // Routes --------------------------------------------------------------------
  'routes' => array(
  ),
);
