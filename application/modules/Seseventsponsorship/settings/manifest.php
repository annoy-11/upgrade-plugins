<?php 
return array (
  'package' => array(
    'type' => 'module',
    'name' => 'seseventsponsorship',
    'version' => '4.8.12',
    'path' => 'application/modules/Seseventsponsorship',
    'title' => 'Advanced Events Sponsorship Extension',
    'description' => 'Advanced Events Sponsorship Extension',
    'author' => '<a href="http://www.socialenginesolutions.com" style="text-decoration:underline;" target="_blank">SocialEngineSolutions</a>',
    'actions' => array(
        'install',
        'upgrade',
        'refresh',
        'enable',
        'disable',
    ),
    'callback' => array(
        'path' => 'application/modules/Seseventsponsorship/settings/install.php',
        'class' => 'Seseventsponsorship_Installer',
    ),
    'directories' => array(
        'application/modules/Seseventsponsorship',
    ),
    'files' => array(
        'application/languages/en/seseventsponsorship.csv',
    ),
  ),
);