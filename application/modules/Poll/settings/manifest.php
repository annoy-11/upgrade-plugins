<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Poll
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: manifest.php 10150 2014-03-27 15:59:48Z andres $
 * @author     John
 */
return array(
  // Package -------------------------------------------------------------------
  'package' => array(
    'type' => 'module',
    'name' => 'poll',
    'version' => '4.10.4',
    'revision' => '$Revision: 10150 $',
    'path' => 'application/modules/Poll',
    'repository' => 'socialengine.com',
    'title' => 'Polls',
    'description' => 'Polls',
    'author' => 'Webligo Developments',
    'dependencies' => array(
      array(
        'type' => 'module',
        'name' => 'core',
        'minVersion' => '4.2.0',
      ),
    ),
    'actions' => array(
       'install',
       'upgrade',
       'refresh',
       'enable',
       'disable',
     ),
    'callback' => array(
      'path' => 'application/modules/Poll/settings/install.php',
      'class' => 'Poll_Installer',
    ),
    'directories' => array(
      'application/modules/Poll',
    ),
    'files' => array(
      'application/languages/en/poll.csv',
    ),
  ),
  // Hooks ---------------------------------------------------------------------
  'hooks' => array(
    array(
      'event' => 'onStatistics',
      'resource' => 'Poll_Plugin_Core'
    ),
    array(
      'event' => 'onUserDeleteBefore',
      'resource' => 'Poll_Plugin_Core',
    ),
  ),
  // Items ---------------------------------------------------------------------
  'items' => array(
    'poll'
  ),
  // Routes --------------------------------------------------------------------
  'routes' => array(
    'poll_extended' => array(
      'route' => 'polls/:controller/:action/*',
      'defaults' => array(
        'module' => 'poll',
        'controller' => 'index',
        'action' => 'index',
      ),
      'reqs' => array(
        'controller' => '\D+',
        'action' => '\D+',
      ),
    ),
    'poll_general' => array(
      'route' => 'polls/:action/*',
      'defaults' => array(
        'module' => 'poll',
        'controller' => 'index',
        'action' => 'browse',
      ),
      'reqs' => array(
        'action' => '(index|browse|manage|create)',
      ),
    ),
    'poll_specific' => array(
      'route' => 'polls/:action/:poll_id/*',
      'defaults' => array(
        'module' => 'poll',
        'controller' => 'poll',
        'action' => 'index',
      ),
      'reqs' => array(
        'poll_id' => '\d+',
        'action' => '(delete|edit|close|vote)',
      ),
    ),
    'poll_view' => array(
      'route' => 'polls/view/:poll_id/:slug',
      'defaults' => array(
        'module' => 'poll',
        'controller' => 'poll',
        'action' => 'view',
        'slug' => '',
      ),
      'reqs' => array(
        'poll_id' => '\d+'
      )
    ),
  ),
);
