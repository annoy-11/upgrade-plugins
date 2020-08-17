<?php

return array(
  'package' => array(
    'type' => 'module',
    'name' => 'sescleanwide',
    'sku' => 'sescleanwide',
    'version' => '4.10.3',
    'dependencies' => array(
        array(
            'type' => 'module',
            'name' => 'core',
            'minVersion' => '4.9.4p3',
        ),
    ),
    'path' => 'application/modules/Sescleanwide',
    'title' => 'SES - Responsive Clean Wide Theme',
    'description' => 'SES - Responsive Clean Wide Theme',
    'author' => '<a href="http://www.socialenginesolutions.com" style="text-decoration:underline;" target="_blank">SocialEngineSolutions</a>',
    'actions' => array(
        'install',
        'upgrade',
        'refresh',
        'enable',
        'disable',
    ),
    'callback' => array(
        'path' => 'application/modules/Sescleanwide/settings/install.php',
        'class' => 'Sescleanwide_Installer',
    ),
    'directories' => array(
        0 => 'application/modules/Sescleanwide',
        1 => 'application/themes/sescleanwide'
    ),
    'files' => array(
        'application/languages/en/sescleanwide.csv',
    ),
  ),
);
