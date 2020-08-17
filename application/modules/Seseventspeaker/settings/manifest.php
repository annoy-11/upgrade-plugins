<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventspeaker
 * @package    Seseventspeaker
 * @copyright  Copyright 2018-2017 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php 2017-03-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array (
  // Package -------------------------------------------------------------------
  'package' => array(
      'type' => 'module',
      'name' => 'seseventspeaker',
      'version' => '4.8.12',
      'path' => 'application/modules/Seseventspeaker',
      'title' => 'Advanced Events Speakers Extesnion',
      'description' => 'Advanced Events Speakers Extesnion',
      'author' => 'SocialEngineSolutions',
      'actions' => array(
          'install',
          'upgrade',
          'refresh',
          'enable',
          'disable',
      ),
      'callback' => array(
          'path' => 'application/modules/Seseventspeaker/settings/install.php',
          'class' => 'Seseventspeaker_Installer',
      ),
      'directories' => array(
          'application/modules/Seseventspeaker',
      ),
      'files' => array(
          'application/languages/en/seseventspeaker.csv',
      ),
  ),    
  // Items ---------------------------------------------------------------------
  'items' => array(
    'seseventspeaker_speakers', 'seseventspeaker_eventspeakers','seseventspeaker_speaker'
  ),
  // Routes --------------------------------------------------------------------
  'routes' => array(
    'seseventspeaker_general' => array(
      'route' => 'events/speaker/:action/*',
      'defaults' => array(
          'module' => 'seseventspeaker',
          'controller' => 'index',
          'action' => 'browse',
      ),
    ),
    'seseventspeaker_dashboard' => array(
        'route' => 'events/dashboard/:action/:event_id/*',
        'defaults' => array(
            'module' => 'seseventspeaker',
            'controller' => 'index',
            'action' => 'speaker',
        ),
        'reqs' => array(
            'action' => '(speakers|add-admin-speaker|getadminspeakers|delete-speaker|add-events-speaker|edit-events-speaker|enabled)',
        )
    ),
    'seseventspeaker_speakers' => array(
        'route' => 'events/speakers/:controller/:action/*',
        'defaults' => array(
            'module' => 'seseventspeaker',
            'controller' => 'index',
            'action' => 'view',
        ),
        'reqs' => array(
            'speaker_id' => '\d+',
        )
    ),
  ),
); 
?>