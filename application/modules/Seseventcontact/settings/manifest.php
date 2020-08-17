<?php return array (
  'package' => array(
      'type' => 'module',
      'name' => 'seseventcontact',
      'version' => '4.8.9',
      'path' => 'application/modules/Seseventcontact',
      'title' => 'Advanced Events Contact Extesnion',
      'description' => 'Advanced Events Contact Extesnion',
      'author' => 'SocialEngineSolutions',
      'actions' => array(
          'install',
          'upgrade',
          'refresh',
          'enable',
          'disable',
      ),
      'callback' => array(
          'path' => 'application/modules/Seseventcontact/settings/install.php',
          'class' => 'Seseventcontact_Installer',
      ),
      'directories' => array(
          'application/modules/Seseventcontact',
      ),
      'files' => array(
          'application/languages/en/seseventcontact.csv',
      ),
  ),
); ?>